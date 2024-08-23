<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use DB;

class CompanyAddress extends Model
{
    use HasFactory;
    protected $table = 'company_address';
    protected $fillable = [
        'id',
        'company_id',
        'def_address',
        'address_1',
        'address_2',
        'city',
        'state',
        'postcode',
        'country',
        'phone_ext',
        'phone',
        'email',
        'fax',
        'status',
        'created_at',
        'deleted_at',
    ];

    public function countries()
    {
        return $this->hasOne(Country::class, 'id', 'country');
    }

    public static function createOrUpdate($companyId, $inputArray)
    {
        DB::table('company_address')->where('company_id', $companyId)->delete();
        foreach ($inputArray as $k => $v) {
            if ($k == 0)
                $inputArray[$k]['def_address'] = 1;

            $inputArray[$k]['company_id'] = $companyId;

            CompanyAddress::create($inputArray[$k]);
        }
    }

    public static function addAddress($data)
    {     
        $return = 0;
        $success = true;
        $exist = CompanyAddress::where('country', $data['country'])->where('city', $data['city'])->where('state', $data['state'])->where('company_id', $data['company_id'])->first();
        if (!$exist) {
            if(isset($data['def_address']) && $data['def_address']==1){
                CompanyAddress::where('company_id',$data['company_id'])->update(['def_address' => 0]);
            }
            $newEntry = new CompanyAddress();
            try {
                foreach ($data as $key => $value) {
                    $newEntry->$key = $value;
                }
                $newEntry->save();
                $return = $newEntry->id;
            } catch (\Exception $e) {
                $return = $e->getMessage();
                $success = false;
            }
            return ['data' => $return, 'success' => $success];
        }else{
            $return = "The address already exist on the same country, city and state";
            $success = false;
            return ['data' => $return, 'id' => $exist->id, 'success' => $success];
        }
    }
    public static function editAddress($id,$data)
    {
        $return = 0;
        $success = true;
        $exist = CompanyAddress::where('country', $data['country'])->where('city', $data['city'])->where('state', $data['state'])->where('company_id', $data['company_id'])->where('id',"!=", $id)->first();
        // pre($exist);
        if (!$exist) {
            if(isset($data['def_address']) && $data['def_address']==1){
                CompanyAddress::where('company_id',$data['company_id'])->update(['def_address' => 0]);
            }
            $newEntry = CompanyAddress::where('id', $id)->first();
            try {
                foreach ($data as $key => $value) {
                    $newEntry->$key = $value;
                }
                $newEntry->update();
                $return = $newEntry->id;
            } catch (\Exception $e) {
                $return = $e->getMessage();
                $success = false;
            }
            return ['data' => $return, 'success' => $success];
        } else {
            $return = "The address already exist on the same country, city and state";
            $success = false;
            return ['data' => $return, 'success' => $success];
        }
    }

    public static function createOrUpdateSingleRecord($pk, $inputArray)
    {
        $companyAddress = CompanyAddress::updateOrCreate(
            [
                'id' => $pk
            ],
            $inputArray
        );
        return $companyAddress;
    }

    public static function getAddress($companyId)
    {
        $data = self::selectRaw('company_address.id,address_1,address_2,city,state,countries.name as country')
            ->leftJoin('countries', 'countries.id', '=', 'company_address.country')
            ->where('company_address.company_id', $companyId)
            ->orderBy('company_address.def_address', 'desc')
            ->get();

        $return = array();
        $return[0] = "Other";
        foreach ($data as $k => $v) {
            // $address1 = !empty($v->address_1) ? $v->address_1 : '';
            // $address2 = !empty($v->address_2) ? ', ' . $v->address_2 : '';
            // $city = !empty($v->city) ? ', ' . $v->city : '';
            $city = !empty($v->city) ? $v->city : '';
            $state = !empty($v->state) ? ', ' . $v->state : '';
            $country = !empty($v->country) ? ', ' . $v->country : '';
            $return[$v->id] = $city . $state. $country;
            // $return[$v->id] = $address1 . $address2 . $city . $country;
        }
        return $return;
    }
    public static function getJobAddress($companyId)
    {
        $data = self::selectRaw('company_address.id,address_1,address_2,city,countries.name as country')
            ->leftJoin('countries', 'countries.id', '=', 'company_address.country')
            ->where('company_address.company_id', $companyId)
            ->orderBy('company_address.def_address', 'desc')
            ->get();

        $return = array();
        foreach ($data as $k => $v) {
            $city = !empty($v->city) ?  $v->city : '';
            $country = !empty($v->country) ? ', ' . $v->country : '';
            $return[$v->id] = $city . $country;
        }
        return $return;
    }
    public static function getJobAddressForRecruiter()
    {
        $data = self::selectRaw('company_address.id,address_1,address_2,city,countries.name as country')
            ->leftJoin('countries', 'countries.id', '=', 'company_address.country')
            ->orderBy('company_address.def_address', 'desc')
            ->get();

        $return = array();
        foreach ($data as $k => $v) {
            $city = !empty($v->city) ?  $v->city : '';
            $country = !empty($v->country) ? ', ' . $v->country : '';
            $return[$v->id] = $city . $country;
        }
        return $return;
    }
    public static function getDefaultAddress($companyId)
    {
        $data = self::selectRaw('company_address.id,address_1,address_2,city,countries.name as country')
            ->leftJoin('countries', 'countries.id', '=', 'company_address.country')
            ->where('company_address.company_id', $companyId)
            ->where('company_address.def_address', 1)
            ->orderBy('company_address.def_address', 'desc')
            ->get();

        $return = "";
        foreach ($data as $k => $v) {
            $address1 = !empty($v->address_1) ? $v->address_1 : '';
            $address2 = !empty($v->address_2) ? ', ' . $v->address_2 : '';
            $city = !empty($v->city) ? ', ' . $v->city : '';
            $country = !empty($v->country) ? ', ' . $v->country : '';
            $return = trim($city . $country,",");
        }
        return $return;
    }

    public static function getSelectedAddress($companyAddressId)
    {
        $data = self::selectRaw('company_address.id,address_1,address_2,city,countries.name as country')
        ->leftJoin('countries', 'countries.id', '=', 'company_address.country')
        ->where('company_address.id', $companyAddressId)
            ->get();

        $return = "";
        foreach ($data as $k => $v) {
            $address1 = !empty($v->address_1) ? $v->address_1 : '';
            $address2 = !empty($v->address_2) ? ', ' . $v->address_2 : '';
            $city = !empty($v->city) ? ', ' . $v->city : '';
            $country = !empty($v->country) ? ', ' . $v->country : '';
            $return = trim($city . $country, ",");
        }
        return $return;
    }
}
