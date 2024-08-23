<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use DB;
use App\Models\RecruiterTaxForms;
use Carbon\Carbon;
use File;
use Illuminate\Database\Eloquent\SoftDeletes;

class Recruiter extends Model
{
    use HasFactory, SoftDeletes;
    protected $table = 'recruiters';
    protected $fillable = [
        'id',
        'user_id',
        'first_name',
        'last_name',
        'email',
        'password',
        'phone_ext',
        'phone',
        'dob',
        'about',
        'website',
        'city',
        'state',
        'postcode',
        'expertise',
        'profile_pic',
        'address_1',
        'address_2',
        'country',
        'w9_file',
        'status',
        'is_verify',
        'created_at',
        'deleted_at',
    ];

    public static function getList($type = "")
    {
        return self::select(DB::raw("CONCAT(first_name,' ',last_name) AS name"), 'id')->whereNull('deleted_at')->pluck('name', 'id');
    }

    public static function uploadTaxForm($recruiterId, $fileObject)
    {
        $file = $fileObject;
        $ext = $fileObject->extension();
        $filename = rand() . '_' . time() . '.' . $ext;
        $filePath = public_path() . '/assets/tax-forms/';
        if (!File::exists($filePath)) {
            File::makeDirectory($filePath);
        }
        $file->move($filePath . '/', $filename);
        if ($recruiterId) {
            $oldData = RecruiterTaxForms::where('recruiter_id', $recruiterId)->first();
            if ($oldData) {
                $path = public_path() . '/assets/tax-forms/' . $oldData->tax_form;
                if (file_exists($path)) {
                    unlink($path);
                }
                $oldData->tax_form = $filename;
                $oldData->save();
            } else {
                $taxForm = new RecruiterTaxForms();
                $taxForm->form_name = "W-9";
                $taxForm->tax_form = $filename;
                $taxForm->recruiter_id = $recruiterId;
                $taxForm->created_at = Carbon::now();
                $taxForm->save();
            }
        }
        return $filename;
    }

    public static function deleteTaxForm($recruiterId)
    {
        if ($recruiterId) {
            $oldData = RecruiterTaxForms::where('recruiter_id', $recruiterId)->first();
            if ($oldData) {
                $path = public_path() . '/assets/tax-forms/' . $oldData->tax_form;
                if (file_exists($path)) {
                    unlink($path);
                }
                $oldData->delete();
                return true;
            } else {
                return false;
            }
        }
    }

    public function RecruiterBankDetail()
    {
        return $this->hasOne(RecruiterBankDetail::class, 'recruiter_id', 'id');
    }

    public function User()
    {
        return $this->hasOne(User::class, 'id', 'user_id');
    }

    public function Country()
    {
        return $this->hasOne(Country::class, 'id', 'country');
    }

    public function currentSubscription()
    {
        $return = [];
        $currentSubscriptionId = User::getAttrById($this->user_id, 'current_subscription_id');
        if ($currentSubscriptionId) {
            $return =  RecruiterSubscription::find($currentSubscriptionId);
        }
        return $return;
    }

    public static function createOrUpdate($pk, $inputArray)
    {
        $recruiter = Recruiter::updateOrCreate(
            [
                'id' => $pk
            ],
            $inputArray
        );
        return $recruiter;
    }
    public static function getRecruiterDetailsById($id)
    {
        $data = Recruiter::where('id', $id)
            ->whereNull('deleted_at')->first();
        if ($data) {
            $data = self::formatRecruiterList($data);
        }
        $return = $data;
        return $return;
    }
    public static function formatRecruiterList($data)
    {
        $return = [];
        $address[] = $data->address_1;
        $address[] = $data->address_2;
        $address[] = $data->city;
        $address[] = $data->state;
        $address[] = $data->postcode;
        $address[] = $data->Country->name;
        $address = array_filter($address);
        $address = implode(', ', $address);
        $return = [
            "recruiterId" => $data->id,
            "recruiterCode" => 'RC' . sprintf('%04d', $data->id),
            "recruiterName" => $data->first_name . ' ' . $data->last_name,
            "recruiterPhone" => $data->phone_ext . $data->phone,
            "recruiterEmail" => $data->email,
            "recruiterAddress" => $address,
        ];
        return $return;
    }

    public static function searchRecruiterList($page = '1', $search = '', $searchChar = '', $id = '', $sortBy='date_desc')
    {
        $data = [];
        $limit = 0;
        $recruiters = self::selectRaw("CONCAT(recruiters.last_name,' ',recruiters.first_name) AS recruiterName, recruiters.id as recruiterId, recruiters.email as recruiterEmail, recruiters.address_1 as recruiterAddress1,recruiters.address_2 as recruiterAddress2, recruiters.city as recruiterCity, recruiters.state as recruiterState, countries.name as recruiterCountry, recruiters.phone_ext as phoneExt, recruiters.phone, users.unique_id as recruiterUniqueId")
            ->leftJoin('users', 'users.id', '=', 'recruiters.user_id')
            ->leftJoin('countries', 'countries.id', '=', 'recruiters.country');
            // ->orderBy('recruiters.id', 'asc');
        if ($id) {
            $recruiters = $recruiters->where('recruiters.id', $id);
        }

        if ($search) {
            $recruiters->where(function ($query2) use ($search) {
                // $query2->where('recruiters.first_name', 'like', '%' . $search . '%')
                //     ->orWhere('recruiters.last_name', 'like', '%' . $search . '%');
                $query2->whereRaw("CONCAT(recruiters.last_name,' ',recruiters.first_name) like '%". $search ."%'")
                        ->orWhere('recruiters.email', 'like', '%' . $search . '%');
            });
        }

        if ($searchChar) {
            $recruiters->where(function ($query2) use ($searchChar) {
                // $query2->where('recruiters.first_name', 'like', $searchChar . '%');
                $query2->whereRaw("CONCAT(recruiters.last_name,' ',recruiters.first_name) like '" . $searchChar . "%'");
            });
        }

        if ($sortBy) {
            $sortBy = explode('_', $sortBy);
            if ($sortBy[0] == 'date') {
                $recruiters->orderBy('recruiters.created_at', $sortBy[1]);
            }
            if ($sortBy[0] == 'name') {
                $recruiters->orderBy('recruiters.last_name', $sortBy[1]);
            }
        }

        if ($page) {
            $limit = 10;
            $offset = ($page - 1) * $limit;
            $recruiters->offset($offset);
            $recruiters->limit($limit);
        }
        $recruiters = $recruiters->distinct()->get();
        if ($recruiters) {
            $recruiters = self::formatrecruitersList($recruiters);
        }
        $return = ['recruiters' => $recruiters, 'page' => $page, 'limit' => $limit];
        return $return;
    }

    public static function formatrecruitersList($data)
    {
        $return = [];
        foreach ($data as $key => $value) {
            $totalPayout = RecruiterPayouts::getTotalPayout($value->recruiterId, 1);
            $amountDue = AdminCommission::getPayoutTotal($value->recruiterId);
            $approvedCandidates = CompanyJobApplication::getApprovedCandidates($value->recruiterId);
            $return[] = [
                "recruiterId" => $value['recruiterId'],
                "recruiterName" => $value['recruiterName'],
                "phoneExt" => $value['phoneExt'],
                "phone" => $value['phone'],
                "recruiterEmail" => $value['recruiterEmail'],
                "recruiterCity" => $value['recruiterCity'],
                "recruiterState" => $value['recruiterState'],
                "recruiterCountry" => $value['recruiterCountry'],
                "recruiterUniqueId" => $value['recruiterUniqueId'],
                "recruiterAddress1" => $value['recruiterAddress1'],
                "recruiterAddress2" => $value['recruiterAddress2'],
                "totalPayout" => getFormatedAmount($totalPayout, 2),
                "amountDue" => getFormatedAmount($amountDue, 2),
                "approvedCandidates" => $approvedCandidates,
            ];
        }
        return $return;
    }

    public static function getUserIdByReruiterId($id){
        $return = 0;
        $data = self::where('id', $id)->first();
        if ($data) {
            $return = $data->user_id;
        }
        return $return;
    }

    public static function getReruiterIdByUserId($id)
    {
        $return = 0;
        $data = self::where('user_id', $id)->first();
        if ($data) {
            $return = $data->id;
        }
        return $return;
    }

    public static function getCountDashboard($from = "", $to = "")
    {
        $count = 0;
        $data = self::selectRaw('count(*) as total')->whereNull('deleted_at');
        if ($from != "" && $to != "") {
            $data->whereBetween('created_at', [$from, $to]);
        } else {
            $data->whereDate('created_at', Carbon::today());
        }
        $data = $data->first();
        if ($data) {
            $count = $data->total;
        }
        return $count;
    }

    public static function getCountDashboardGraph($type = "daily", $date)
    {
        $return = 0;
        $data = self::selectRaw('count(*) as total')->whereNull('deleted_at');
        if ($type == "daily") {
            $data->whereDate('created_at', $date);
        } elseif ($type == "monthly") {
            $month = date('m', strtotime($date));
            $year = date('Y', strtotime($date));
            $data->whereMonth('created_at', $month);
            $data->whereYear('created_at', $year);
        } elseif ($type == "yearly") {
            $year = date('Y', strtotime($date));
            $data->whereYear('created_at', $year);
        }
        $data = $data->first();
        if ($data) {
            $return = $data->total;
        }
        return $return;
    }
}
