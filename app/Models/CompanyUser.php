<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class CompanyUser extends Model
{
    use HasFactory;
    use SoftDeletes;
    protected $table = 'company_user';
    protected $fillable = [
        'id',
        'company_id',
        'user_id',
        'email',
        'password',
        'name',
        'phone_ext',
        'phone',
        'company_address_id',
        'fax',
        'address_1',
        'designation',
        'address_2',
        'city',
        'state',
        'postcode',
        'country',
        'is_owner',
        'is_verify',
        'status',
        'created_at',
        'deleted_at',
    ];

    public function company()
    {
        return $this->hasOne(Companies::class, 'id', 'company_id');
    }

    public function user()
    {
        return $this->hasOne(User::class, 'id', 'user_id');
    }

    public function currentSubscription()
    {
        $return = [];
        $currentSubscriptionId = User::getAttrById($this->user_id, 'current_subscription_id');
        if ($currentSubscriptionId) {
            $return =  CompanySubscription::find($currentSubscriptionId);
        }
        return $return;
    }

    public static function getList()
    {
        return self::whereNull('deleted_at')->pluck('name', 'id');
    }

    public static function createOrUpdate($pk, $inputArray)
    {
        $companyUser = CompanyUser::updateOrCreate(
            [
                'id' => $pk
            ],
            $inputArray
        );
        return $companyUser;
    }

    public static function deleteUser($user_id)
    {
        $user = self::where('user_id', $user_id)->first();
        if($user)
        {
            $user->email = $user->email.'deleted'.now();
            $user->phone = $user->phone.'deleted'.now();
            $user->save();
            if($user->delete()){
                User::deleteUser($user_id);
            }
        }
    }

    public static function companyUserList($companyId)
    {
        $users = self::where('company_id',$companyId)
                    ->where('is_owner', '!=', 1)
                    ->whereNull('deleted_at')
                    ->get(['id','name'])
                    ->toArray();
        return $users;
    }

    public static function checkIsOwner($userId){
        $return = false;
        $data = self::select('is_owner')->where('user_id', $userId)->first();
        if($data && $data->is_owner){
            $return = true;
        }
        return $return;
    }

    public static function getCompanyIdByUserId($userId){
        $return = 0;
        $data = self::where('user_id', $userId)->first();
        if ($data) {
            $return = $data->company_id;
        }
        return $return;
    }

    public static function getCompanyUserMainIdByUserId($userId)
    {
        $return = 0;
        $data = self::where('user_id', $userId)->first();
        if ($data) {
            $return = $data->company->user_id;
        }
        return $return;
    }

    public static function getStripeCustomerIdByUserId($userId)
    {
        $return = 0;
        $data = self::where('user_id', $userId)->first();
        if ($data) {
            $data = self::where('is_owner','1')->where('company_id', $data->company_id)->first();
            $return = $data->user_id;
        }
        return $return;
    }
}
