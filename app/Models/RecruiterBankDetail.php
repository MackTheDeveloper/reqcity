<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RecruiterBankDetail extends Model
{
    use HasFactory;
    protected $table = 'recruiter_bank_details';
    protected $fillable = [
        'id',
        'recruiter_id',
        'bank_name',
        'currency_code',
        'account_number',
        'bank_address',
        'currency_code',
        'swift_code',
        'bank_city',
        'swift_code',
        'bank_city',
        'bank_country',
        'created_at',
    ];

    public function Country()
    {
        return $this->hasOne(Country::class,'id','bank_country');
        // note: we can also inlcude Mobile model like: 'App\Mobile'
    }

    public static function createOrUpdate($pk, $inputArray)
    {
        $bank = RecruiterBankDetail::updateOrCreate(
            [
                'id' => $pk
            ],
            $inputArray
        );
        return $bank;
    }
    public static function getRecruiterBankDetail($id)
    {
      $data = RecruiterBankDetail::where('recruiter_id', $id)
          ->whereNull('deleted_at')->first();
        if ($data)
        {
            $data =$data;
        }
        $return = $data;
        return $return;
    }
}
