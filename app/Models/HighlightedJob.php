<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;
use Faker\Provider\Company;

class HighlightedJob extends Model
{
    use HasFactory;
    protected $table = 'highlited_jobs';
    protected $fillable = [
        'id',
        'company_id',
        'company_job_id',
        'start_date',
        'end_date',
        'created_at',
        'created_by',
        'updated_at',
        'updated_by',
        'deleted_at',
    ];

    public function companyJob()
    {
        return $this->hasOne(CompanyJob::class, 'id', 'company_job_id');
    }

    public function companies()
    {
        return $this->hasOne(Companies::class, 'id', 'company_id');
    }

    public static function getCompanyList(){
        $company = self::select('companies.id','companies.name')
                         ->leftJoin("companies","highlited_jobs.company_id","companies.id")
                         ->whereNull('highlited_jobs.deleted_at')->distinct()->pluck('name','id');
        return $company;
    }

    public static function getCompanyJobIds(){
        $jobIds = self::whereNull('highlited_jobs.deleted_at')->pluck('company_job_id')->toArray();
        return $jobIds;
    }
    public static function getHighlightedJobs($limit=""){
      $highlightedJobsDetails = self::select('company_jobs.title as companyJobTitle','company_jobs.slug as jobSlug','companies.name as companyName','company_address.city as companyCity','company_address.state as companyState','company_jobs.salary_type as salaryType','company_jobs.from_salary as fromSalary','company_jobs.to_salary as toSalary','company_jobs.job_description as jobDescription','company_jobs.created_at as postedOn')
      ->leftJoin('company_jobs', function($join) {
          $join->on('company_jobs.id', '=' , 'highlited_jobs.company_job_id');
          $join->where('company_jobs.status',1);
          $join->whereNull('company_jobs.deleted_at');
      })
      ->leftJoin('companies', function($join) {
          $join->on('companies.id', '=' , 'company_jobs.company_id');
          $join->where('companies.status','=',1);
          $join->whereNull('companies.deleted_at');
      })
      ->leftJoin('company_address',function ($join) {
          $join->on('company_address.company_id', '=' , 'companies.id');
          $join->where('company_address.status','=',1);
          $join->whereNull('company_address.deleted_at');
          // $join->where('images.is_default','=','yes');
      })
      ->whereNull('highlited_jobs.deleted_at')
      ->where(function ($query) {
        //   $query->where('highlited_jobs.end_date', '=', Carbon::now())
          $query->where('highlited_jobs.end_date', '>=', Carbon::now())
                ->orWhere('highlited_jobs.end_date', '=', null);
      })
      ->limit($limit)
      ->distinct()->get();//pre($highlightedJobsDetails);
      if ($highlightedJobsDetails)
      {
          $highlightedJobsDetails = self::formatHighlioghtedJobList($highlightedJobsDetails);
      }
      $return = $highlightedJobsDetails;
      return $return;
    }

    public static function formatHighlioghtedJobList($data){
        $return = [];
        foreach ($data as $key => $value) {
          if(!empty($value['toSalary']))
              $salary='$'.getFormatedAmount($value['fromSalary'],0).' - $'.getFormatedAmount($value['toSalary'],0);
          else
              $salary='$'.getFormatedAmount($value['fromSalary'],0);
            $return[] = [
                "jobTitle"=>$value['companyJobTitle'],
                "jobSlug"=>$value['jobSlug'],
                "companyName"=>$value['companyName'],
                "companyCity"=>$value['companyCity'],
                "companyState"=>$value['companyState'],
                "salaryType"=>$value['salaryType'],
                "salaryText"=>$salary,
                "jobDescription"=>$value['jobDescription'],
                "postedOn"=>getFormatedDateForWeb($value['postedOn']),
            ];
        }
        return $return;
    }
    //search highlight jobs for all login
    public static function searchHighlightedJobList($page = '1', $search = '', $sort = '', $filter = [])
    {
        $data = [];
        $limit = 0;
        $companyJobs = self::has('companyJob')->has('companies')->select('company_jobs.id', 'company_jobs.title as companyJobTitle', 'companies.name as companyName', 'company_address.city as companyCity', 'company_address.state as companyState', 'countries.name as companyCountry', 'company_jobs.salary_type as salaryType', 'company_jobs.from_salary as fromSalary', 'company_jobs.to_salary as toSalary', 'company_jobs.job_description as jobDescription', 'company_jobs.created_at as postedOn', 'company_jobs.total_amount_paid as amountRequired', 'company_jobs.balance as blanace', 'company_jobs.status as companyStatus', 'company_jobs.compensation_type', 'company_jobs.compensation_type', 'company_jobs.job_short_description', 'company_jobs.slug','company_jobs.hide_compensation_details_to_candidates')
        ->leftJoin('company_jobs', function($join) {
            $join->on('company_jobs.id', '=' , 'highlited_jobs.company_job_id');
            $join->where('company_jobs.status',1);
            $join->whereNull('company_jobs.deleted_at');
            $join->groupBy('company_jobs.id');
        })
            ->leftJoin('companies', function ($join) {
                $join->on('companies.id', '=', 'company_jobs.company_id');
                $join->where('companies.status', '=', 1);
                $join->whereNull('companies.deleted_at');
            })
            ->leftJoin('company_address', function ($join) {
                $join->on('company_address.company_id', '=', 'companies.id');
                $join->where('company_address.status', '=', 1);
                $join->whereNull('company_address.deleted_at');
                // $join->where('images.is_default','=','yes');
            })
            ->leftJoin('countries', 'countries.id', '=', 'company_address.country')
            ->whereNull('highlited_jobs.deleted_at')
            ->groupBy('highlited_jobs.id');
        if ($search) {
            $companyJobs->where('company_jobs.title', 'like', '%' . $search . '%');
        }

        if (!empty($filter['parentCat'])) {
            $parentCat = explode(',', $filter['parentCat']);
            $companyJobs->where(function ($q) use ($parentCat) {
                $q->orWhereIn('company_jobs.job_category_id', $parentCat);
            });
        }

        if (!empty($filter['childCat'])) {
            $childCat = explode(',', $filter['childCat']);
            $companyJobs->where(function ($q) use ($childCat) {
                $q->orWhereIn('company_jobs.job_subcategory_id', $childCat);
            });
        }

        if (!empty($filter['joblocation'])) {
            $joblocation = explode(',', $filter['joblocation']);
            $remoteWorkIds = JobFieldOption::getIdsOfJobFieldByOption('REMWK');
            $companyJobs->where(function ($q) use ($joblocation, $remoteWorkIds) {
                $q->orWhereIn('company_jobs.company_address_id', $joblocation);
                if (in_array('remote', $joblocation)) {
                    $q->orWhereIn('company_jobs.job_remote_work_id', $remoteWorkIds);
                }
            });
        }

        if (!empty($filter['empType'])) {
            $empType = explode(',', $filter['empType']);
            $companyJobs->where(function ($q) use ($empType) {
                $q->orWhereIn('company_jobs.job_employment_type_id', $empType);
            });
        }

        if (!empty($filter['conType'])) {
            $conType = explode(',', $filter['conType']);
            $companyJobs->where(function ($q) use ($conType) {
                $q->orWhereIn('company_jobs.job_contract_id', $conType);
            });
        }

        if (!empty($sort)) {
            switch ($sort) {
                case 'latest':
                    $companyJobs->orderBy("company_jobs.created_at", "DESC");
                    break;
                case 'old':
                    $companyJobs->orderBy("company_jobs.created_at", "ASC");
                    break;
                case 'title_asc':
                    $companyJobs->orderBy("company_jobs.title", "ASC");
                    break;
                case 'title_desc':
                    $companyJobs->orderBy("company_jobs.title", "DESC");
                    break;
                default:
                    $companyJobs->orderBy("company_jobs.created_at", "DESC");
            }
        } else {
            $companyJobs = $companyJobs->orderBy('company_jobs.created_at', 'DESC');
        }
        $companyJobs->where(function ($query) {
          //   $query->where('highlited_jobs.end_date', '=', Carbon::now())
            $query->where('highlited_jobs.end_date', '>=', Carbon::now())
                  ->orWhere('highlited_jobs.end_date', '=', null);
        });
        if ($page) {
            $limit = 10;
            $offset = ($page - 1) * $limit;
            $companyJobs->offset($offset);
            $companyJobs->limit($limit);
        }
        $companyJobs = $companyJobs->distinct()->get();
        // pre($companyJobs);
        if ($companyJobs) {
            $companyJobs = self::formatJobList($companyJobs);
        }
        $return = ['companyJobs' => $companyJobs, 'page' => $page, 'limit' => $limit];
        //return ['data' => $return, 'page' => $page, 'limit' => $limit];
        return $return;
    }

    public static function formatJobList($data)
    {
        $return = [];
        //$recuriterId = Auth::user()->recruiter->id;
        foreach ($data as $key => $value) {
            $jobOpenings = CompanyJob::getAttrById($value->id, 'vaccancy');
            if ($value->compensation_type == 'r')
                $salary = '$' . getFormatedAmount($value['fromSalary'], 0) . ' - $' . getFormatedAmount($value['toSalary'], 0);
            else
                $salary = '$' . getFormatedAmount($value['fromSalary'], 0);

            if (!empty($value['id'])) {
                $return[] = [
                    "jobId" => $value['id'],
                    "jobTitle" => $value['companyJobTitle'],
                    "jobSlug" => $value['slug'],
                    "companyName" => $value['companyName'],
                    "companyCity" => $value['companyCity'],
                    "companyState" => $value['companyState'],
                    "companyCountry" => $value['companyCountry'],
                    "salaryType" => $value['salaryType'],
                    "salaryText" => $salary,
                    "jobDescription" => $value['jobDescription'],
                    "jobShortDescription" => $value['job_short_description'],
                    "postedOn" => getFormatedDateForWeb($value['postedOn']),
                    "jobOpenings" => $jobOpenings,
                    "isFavorite" => CandidateFavouriteJobs::checkIsFavorite($value->id),
                    "isApplied" => CandidateApplications::checkIsApplied($value->id),
                    "isHidecompensationDetails" => $value['hide_compensation_details_to_candidates'],
                ];
            }
        }
        return $return;
    }
}
