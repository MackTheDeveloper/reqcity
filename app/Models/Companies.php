<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Session;
use DB;
use Auth;

class Companies extends Model
{
    use HasFactory, SoftDeletes;
    protected $table = 'companies';
    protected $fillable = [
        'id',
        'user_id',
        'name',
        'email',
        'phone_ext',
        'phone',
        'website',
        'strength',
        'about',
        'logo',
        'why_work_here',
        'account_managers',
        'status',
        'created_at',
        'deleted_at',
    ];

    public static function getLogoAttribute($logo)
    {
        $return = url('/public/assets/frontend/img/user-img.svg');
        $path = public_path() . '/assets/images/company-logo/' . $logo;
        if (file_exists($path) && $logo) {
            $return = url('/public/assets/images/company-logo/' . $logo);
        }
        return $return;
    }
    public function Address()
    {
        return $this->hasOne(CompanyAddress::class, 'company_id', 'id')->where('def_address', '1');
    }
    
    public function JobFieldOptions()
    {
        return $this->hasOne(JobFieldOption::class, 'id', 'strength');
    }
    
    public function CompanyUser()
    {
        return $this->hasOne(CompanyUser::class, 'company_id', 'id')->where('is_owner', '1');;
    }

    public static function getList()
    {
        return self::whereNull('deleted_at')->pluck('name', 'id');
    }

    public static function createOrUpdate($pk, $inputArray)
    {
        $company = Companies::updateOrCreate(
            [
                'id' => $pk
            ],
            $inputArray
        );
        return $company;
    }

    public static function uploadIconEncoded($songIconBase64)
    {
        $image_parts = explode(";base64,", $songIconBase64);
        $ext = str_replace('data:image/', '', $image_parts[0]);
        $imageName = rand() . '_' . time() . '.' . $ext;
        $image_base64 = base64_decode($image_parts[1]);

        $imageFullPath = public_path() . '/assets/images/company-logo/' . $imageName;
        file_put_contents($imageFullPath, $image_base64);

        return $imageName;
    }

    public static function getCompanyDetailsById($id)
    {
        $data = Companies::where('id', $id)
            ->whereNull('deleted_at')->first();
        if ($data) {
            $data = self::formatCompanyList($data);
        }
        $return = $data;
        return $return;
    }
    public static function formatCompanyList($data)
    {
        $return = [];
        $return = [
            "companyName" => $data->name,
            "logo" => $data->logo,
        ];
        return $return;
    }

    public static function serchCompanyList($page = '1', $search = '', $searchChar = '', $sortBy='date_desc')
    {
        $data = [];
        $limit = 0;
        $companies = self::select('companies.id', 'companies.name as companyName', 'company_address.city as companyCity', 'company_address.state as companyState', 'countries.name as companyCountry', 'companies.about as aboutCompany','companies.logo','users.current_subscription')
            ->leftJoin('users', 'users.id', '=', 'companies.user_id')
            ->leftJoin('company_address', function ($join) {
                $join->on('company_address.company_id', '=', 'companies.id');
                $join->where('company_address.status', '=', 1);
                $join->whereNull('company_address.deleted_at');
                $join->where('company_address.def_address', '=', 1);
            })
            ->leftJoin('countries', 'countries.id', '=', 'company_address.country')
            // ->orderBy('companies.id', 'asc')
            ->groupBy('companies.id');

        if ($search) {
            $companies->where('companies.name', 'like', '%' . $search . '%');
        }

        if ($searchChar) {
            $companies->where('companies.name', 'like', $searchChar . '%');
        }
        $accountMngr = Role::getAccountManagerRole();
        $backendRole = User::getBackendRole();
        if ($backendRole == $accountMngr) {
            $authId = Auth::guard('admin')->user()->id;
            $companies->whereRaw("FIND_IN_SET(?, companies.account_managers) > 0", [$authId]);
        }
        if ($sortBy) {
            $sortBy = explode('_', $sortBy);
            if ($sortBy[0] == 'date') {
                $companies->orderBy('companies.created_at', $sortBy[1]);
            }
            if ($sortBy[0] == 'name') {
                $companies->orderBy('companies.name', $sortBy[1]);
            }
        }

        if ($page) {
            $limit = 10;
            $offset = ($page - 1) * $limit;
            $companies->offset($offset);
            $companies->limit($limit);
        }
        $companies = $companies->distinct()->get();
        if ($companies) {
            $companies = self::formatCompaniesList($companies);
        }
        $return = ['companies' => $companies, 'page' => $page, 'limit' => $limit];
        return $return;
    }

    public static function formatCompaniesList($data)
    {
        $return = [];
        foreach ($data as $key => $value) {
            $activeJobsCount = CompanyJob::getJobsCountByStatus($value->id, 1);
            $activeJobsBalance = CompanyJob::getTotalBalance($value->id);
            $return[] = [
                "companyId" => $value['id'],
                "companyLogo" => $value['logo'],
                "companyName" => $value['companyName'],
                "companyCity" => $value['companyCity'],
                "companyState" => $value['companyState'],
                "companyCountry" => $value['companyCountry'],
                "aboutCompany" => $value['aboutCompany'],
                "activeJobsCount" => $activeJobsCount,
                "activeJobsBalance" => '$'.getFormatedAmount($activeJobsBalance,2),
                "currentSubscription" => SubscriptionPlan::getAttrById($value['current_subscription'],'plan_type'),
            ];
        }
        return $return;
    }

    public static function getCountDashboard($from="",$to=""){
        $count = 0;
        $data = self::selectRaw('count(*) as total')->whereNull('deleted_at');
        if ($from!="" && $to!="") {
            $data->whereBetween('created_at', [$from, $to]);
        }else{
            $data->whereDate('created_at', Carbon::today());
        }
        $data = $data->first();
        if ($data) {
            $count = $data->total;
        }
        return $count;
    }

    public static function getCountDashboardGraph($type="daily",$date)
    {
        $return = 0;
        $data = self::selectRaw('count(*) as total')->whereNull('deleted_at');
        if ($type=="daily") {
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

    public static function getCompanyIdByUserId($id)
    {
        $return = 0;
        $data = self::where('user_id', $id)->first();
        if ($data) {
            $return = $data->id;
        }
        return $return;
    }
}
