<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use DB;
use Auth;
use Carbon\Carbon;

class CompanyJob extends Model
{
    use HasFactory;
    protected $table = 'company_jobs';
    protected $fillable = [
        'id',
        'user_id',
        'company_id',
        'title',
        'slug',
        'company_address_id',
        'job_category_id',
        'job_subcategory_id',
        'job_industry_id',
        'job_employment_type_id',
        'job_schedule_ids',
        'job_contract_id',
        'contract_duration',
        'contract_duration_type',
        'relocation_available',
        'sponsorship_available',
        'job_remote_work_id',
        'vaccancy',
        'salary_type',
        'compensation_type',
        'from_salary',
        'to_salary',
        'pay_duration',
        'hide_compensation_details_to_candidates',
        'supplemental_pay_offered_ids',
        'benefits_offered_ids',
        'additional_benefits',
        'job_description',
        'job_short_description',
        'covid_precautions',
        'job_technology_id',
        'job_skills',
        'job_questionnaire_template_id',
        'job_communication_template_id',
        'amount',
        'total_amount_paid',
        'balance',
        'closed_datetime',
        'recruiter_commission',
        'admin_commission',
        'job_post_amount',
        'status',
        'updated_at',
        'created_at',
        'deleted_at',
    ];

    public static $status = [
        '1' => 'Open',
        '2' => 'Draft',
        '3' => 'Paused',
        '4' => 'Closed',
    ];

    public static function getStatus(){
        return self::$status;
    }

    public function companyJobFunding()
    {
        //return $this->hasOne(CompanyJobFunding::class, 'company_job_id', 'id');
        return $this->hasMany(CompanyJobFunding::class, 'company_job_id', 'id');
    }

    public function Company()
    {
        return $this->hasOne(Companies::class, 'id', 'company_id');
        // return $this->hasMany(CompanyJobFunding::class, 'company_job_id', 'id');
    }

    public function CompanyAddress()
    {
        return $this->hasOne(CompanyAddress::class, 'id', 'company_address_id');
        // return $this->hasMany(CompanyJobFunding::class, 'company_job_id', 'id');
    }

    public static function getStatusText($status)
    {
        $return  = $status;
        $arr = [1 => 'Pending', 2 => 'In Review', 3 => 'Approved', 4 => 'Rejected'];
        if (isset($arr[$status])) {
            $return = $arr[$status];
        }
        return $return;
    }

    public static function getCompanyList()
    {
        $company = self::select('companies.id', 'companies.name')
            ->leftJoin("companies", "company_jobs.company_id", "companies.id")
            ->where('company_jobs.status', 1)
            ->whereNull('company_jobs.deleted_at')->distinct()->pluck('name', 'id');

        return $company;
    }

    public static function getCategoryJobCount($limit = "")
    {
        $companyJobCount = self::where('company_jobs.status', 1)
            ->whereNull('company_jobs.deleted_at')->count();

        return $companyJobCount;
    }
    public static function getActiveJobs($companyId, $limit = "")
    {
        $companyJobs = self::select('company_jobs.id', 'company_jobs.title as companyJobTitle', 'companies.name as companyName', 'company_address.city as companyCity', 'company_address.state as companyState', 'company_jobs.salary_type as salaryType', 'company_jobs.from_salary as fromSalary', 'company_jobs.to_salary as toSalary', 'company_jobs.job_description as jobDescription', 'company_jobs.created_at as postedOn', 'company_jobs.total_amount_paid as amountRequired', 'company_jobs.balance as blanace', 'company_jobs.status as companyStatus', 'company_jobs.vaccancy', 'company_jobs.slug','company_jobs.job_short_description as jobShortDescription', 'company_jobs.job_remote_work_id', 'countries.name as companyCountry')
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
            ->whereNull('company_jobs.deleted_at')
            ->where('company_jobs.status', 1)
            ->where('company_jobs.company_id', $companyId)
            ->groupBy('company_jobs.id')
            ->orderBy('company_jobs.created_at', 'DESC')
            ->limit($limit)
            ->distinct()->get();

        if ($companyJobs) {
            $companyJobs = self::formatJobList($companyJobs);
        }
        $return = $companyJobs;
        return $return;
    }

    public static function serchJobList($companyId, $status, $page = '1', $search = '', $sort = '', $filter = [])
    {
        $data = [];
        $limit = 0;
        $companyJobs = self::select('company_jobs.id', 'company_jobs.title as companyJobTitle', 'companies.name as companyName', 'company_address.city as companyCity', 'company_address.state as companyState', 'company_jobs.salary_type as salaryType', 'company_jobs.from_salary as fromSalary', 'company_jobs.to_salary as toSalary', 'company_jobs.job_description as jobDescription', 'company_jobs.created_at as postedOn', 'company_jobs.total_amount_paid as amountRequired', 'company_jobs.balance as blanace', 'company_jobs.status as companyStatus', 'company_jobs.vaccancy', 'company_jobs.slug', 'company_jobs.job_short_description as jobShortDescription', 'company_jobs.job_remote_work_id', 'countries.name as companyCountry')
            ->leftJoin('companies', function ($join) {
                $join->on('companies.id', '=', 'company_jobs.company_id');
                $join->where('companies.status', '=', 1);
                $join->whereNull('companies.deleted_at');
            })
            /* ->leftJoin('company_address', function ($join) {
                $join->on('company_address.company_id', '=', 'companies.id');
                $join->where('company_address.status', '=', 1);
                $join->whereNull('company_address.deleted_at');
            }) */
            ->leftJoin('company_address', function ($join) {
                $join->on('company_address.id', '=', 'company_jobs.company_address_id');
            })
            ->leftJoin('countries', 'countries.id', '=', 'company_address.country')
            ->whereNull('company_jobs.deleted_at')
            ->where('company_jobs.company_id', $companyId)
            ->groupBy('company_jobs.id');
        if (!empty($status))
            $companyJobs = $companyJobs->where('company_jobs.status', $status);
        if ($search) {
            $companyJobs->where('company_jobs.title', 'like', '%' . $search . '%');
        }
        if (!empty($filter['parentCat'])) {
            $parentCat = explode(',', $filter['parentCat']);
            $companyJobs->where(function ($q) use ($parentCat) {
                foreach ($parentCat as $key => $value) {
                    $q->orWhere('company_jobs.job_category_id', $value);
                }
            });
        }
        if (!empty($filter['childCat'])) {
            $childCat = explode(',', $filter['childCat']);
            $companyJobs->where(function ($q) use ($childCat) {
                foreach ($childCat as $key => $value) {
                    $q->orWhere('company_jobs.job_subcategory_id', $value);
                }
            });
        }
        if (!empty($filter['statusArr'])) {
            $statusArr = explode(',', $filter['statusArr']);
            $companyJobs->where(function ($q) use ($statusArr) {
                foreach ($statusArr as $key => $value) {
                    $q->orWhere('company_jobs.status', $statusArr);
                }
            });
        }
        if (!empty($filter['joblocation'])) {
            $joblocation = explode(',', $filter['joblocation']);
            $companyJobs->where(function ($q) use ($joblocation) {
                foreach ($joblocation as $key => $value) {
                    $q->orWhere('company_address.id', $value);
                }
            });
        }
        if (!empty($filter['empType'])) {
            $empType = explode(',', $filter['empType']);
            $companyJobs->where(function ($q) use ($empType) {
                foreach ($empType as $key => $value) {
                    $q->orWhere('company_jobs.job_employment_type_id', $value);
                }
            });
        }
        if (!empty($filter['conType'])) {
            $i = 0;
            $conType = explode(',', $filter['conType']);
            $companyJobs->where(function ($q) use ($conType) {
                foreach ($conType as $key => $value) {
                    $q->orWhere('company_jobs.job_contract_id', $value);
                }
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
                case 'balance_asc':
                    $companyJobs->orderBy("company_jobs.balance", "ASC");
                    break;
                case 'balance_desc':
                    $companyJobs->orderBy("company_jobs.balance", "DESC");
                    break;
                default:
                    $companyJobs->orderBy("company_jobs.created_at", "DESC");
            }
        } else {
            $companyJobs = $companyJobs->orderBy('company_jobs.created_at', 'DESC');
        }
        if ($page) {
            $limit = 10;
            $offset = ($page - 1) * $limit;
            $companyJobs->offset($offset);
            $companyJobs->limit($limit);
        }
        $companyJobs = $companyJobs->distinct()->get();
        if ($companyJobs) {
            $companyJobs = self::formatJobList($companyJobs);
        }
        // pre($companyJobs);
        $return = ['companyJobs' => $companyJobs, 'page' => $page, 'limit' => $limit];
        //return ['data' => $return, 'page' => $page, 'limit' => $limit];
        return $return;
    }

    public static function serchJobListForRecruiter($recuriterId, $limit = "", $status, $page = '1', $search = '', $sort = '', $filter = [])
    {
        $data = [];
        //$limit = 0;
        $companyJobs = self::select('company_jobs.id', 'company_jobs.title as companyJobTitle', 'companies.name as companyName', 'company_address.city as companyCity', 'company_address.state as companyState', 'countries.name as companyCountry', 'company_jobs.salary_type as salaryType', 'company_jobs.from_salary as fromSalary', 'company_jobs.to_salary as toSalary', 'company_jobs.job_description as jobDescription', 'company_jobs.created_at as postedOn', 'company_jobs.total_amount_paid as amountRequired', 'company_jobs.balance as blanace', 'company_jobs.status as companyStatus', 'company_jobs.compensation_type', 'company_jobs.compensation_type', 'company_jobs.job_short_description', 'company_jobs.slug', 'company_jobs.job_remote_work_id' )
            ->leftJoin('companies', function ($join) {
                $join->on('companies.id', '=', 'company_jobs.company_id');
                $join->where('companies.status', '=', 1);
                $join->whereNull('companies.deleted_at');
            })
            /* ->leftJoin('company_address', function ($join) {
                $join->on('company_address.company_id', '=', 'companies.id');
                $join->where('company_address.status', '=', 1);
                $join->whereNull('company_address.deleted_at');
            }) */
            ->leftJoin('company_address', function ($join) {
                $join->on('company_address.id', '=', 'company_jobs.company_address_id');
            })
            ->leftJoin('countries', 'countries.id', '=', 'company_address.country')
            ->whereNull('company_jobs.deleted_at')
            ->groupBy('company_jobs.id');
        if (!empty($status)) {
            if ($status == 1) {
                $companyJobs = $companyJobs->where('company_jobs.status', $status);
            } else if ($status == 2) // Favorite
            {
                $companyJobs = $companyJobs->join('recruiter_favourite_jobs', function ($join) use ($recuriterId) {
                    $join->on('recruiter_favourite_jobs.company_job_id', '=', 'company_jobs.id');
                    $join->where('recruiter_favourite_jobs.recruiter_id', $recuriterId);
                });
            } else if ($status == 3) //Submitted
            {
                $companyJobs = $companyJobs->join('company_job_applications', function ($join) use ($recuriterId) {
                    $join->on('company_job_applications.company_job_id', '=', 'company_jobs.id');
                });
                $companyJobs->where('company_job_applications.applied_type', 1)
                    ->where('company_job_applications.related_id', $recuriterId)
                    ->groupBy('company_job_applications.company_job_id');
            } else if ($status == 4) //Similar
            {
                $companyJobs->whereIn('company_jobs.job_category_id', function ($query) use ($recuriterId) {
                    $query->select('company_jobs.job_category_id')
                        ->from('company_job_applications')
                        ->leftjoin('company_jobs', 'company_jobs.id', 'company_job_applications.company_job_id')
                        ->where('company_job_applications.related_id', $recuriterId);
                });
                $companyJobs->whereNotIn('company_jobs.id', function ($query) use ($recuriterId) {
                    $query->select('company_job_applications.company_job_id')
                        ->from('company_job_applications')
                        ->where('company_job_applications.applied_type', 1)
                        ->where('company_job_applications.related_id', $recuriterId);
                });
                $companyJobs->where('company_jobs.status', 1);
                // $companyJobs->join('company_jobs as cj', function ($join) {
                //     $join->on('cj.job_category_id', '=', 'company_jobs.job_category_id');
                //     $join->on('cj.id', '!=', 'company_jobs.id');
                // })->join('company_job_applications', function ($join) {
                //     $join->on('company_job_applications.company_job_id', '=', 'cj.id');
                // });

                // $companyJobs->where('company_job_applications.applied_type', 1)
                //     ->where('company_job_applications.related_id', $recuriterId)
                //     ->where('company_jobs.status', 1);
                //->groupBy('company_jobs.id');
            }
        }

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

        if ($limit) {
            $companyJobs = $companyJobs->limit($limit);
        }
        if ($page) {
            $limit = 10;
            $offset = ($page - 1) * $limit;
            $companyJobs->offset($offset);
            $companyJobs->limit($limit);
        }
        $companyJobs = $companyJobs->distinct()->get();
        if ($companyJobs) {
            $companyJobs = self::formatJobListForRecruiter($companyJobs, $recuriterId);
        }
        $return = ['companyJobs' => $companyJobs, 'page' => $page, 'limit' => $limit];
        //return ['data' => $return, 'page' => $page, 'limit' => $limit];
        return $return;
    }

    public static function formatJobList($data)
    {
        $return = [];
        foreach ($data as $key => $value) {
            //$totalJobOpenings = CompanyJobApplications::getTotalJobOpening($value->id);
            $totalJobRejected = CompanyJobApplications::getTotalJobRejected($value->id);
            $totalJobApproved = CompanyJobApplications::getTotalJobApproved($value->id);
            $totalJobPending = CompanyJobApplications::getTotalJobPending($value->id);
            if (!empty($value['toSalary']))
                $salary = '$' . getFormatedAmount($value['fromSalary'], 0) . ' - $' . getFormatedAmount($value['toSalary'], 0);
            else
                $salary = '$' . getFormatedAmount($value['fromSalary'], 0);
            $statusText = '';
            $statusColor = '';
            switch ($value['companyStatus']) {
                case 1:
                    $statusText = 'Open';
                    $statusColor = 'open';
                    break;
                case 2:
                    $statusText = 'Drafted';
                    $statusColor = 'drafted';
                    break;
                case 3:
                    $statusText = 'Paused';
                    $statusColor = 'paused';
                    break;
                case 4:
                    $statusText = 'Closed';
                    $statusColor = 'closed';
                    break;

                default:
                    $statusText = '';
                    $statusColor = '';
            }
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
                "jobShortDescription" => $value['jobShortDescription'],
                "jobDescription" => $value['jobDescription'],
                "postedOn" => getFormatedDateForWeb($value['postedOn']),
                "amountRequired" => ($value['amountRequired']) ? '$' . $value['amountRequired'] : '-',
                "blanace" => ($value['blanace']) ? '$' . $value['blanace'] : '-',
                "blanaceToCheck" => ($value['blanace']) ? $value['blanace'] : 0.00,
                "jobOpenings" => ($value['vaccancy']) ?  $value['vaccancy'] : 0,
                "jobRejected" => $totalJobRejected,
                "jobApproved" => $totalJobApproved,
                "jobPending" => $totalJobPending,
                "companyStatus" => $value['companyStatus'],
                "statusText" => $statusText,
                "status" => $value['companyStatus'],
                "jobRemoteWork" => JobFieldOption::getAttrById($value['job_remote_work_id'], 'option'),
                "statusColor" => $statusColor,

            ];
        }
        return $return;
    }

    public static function getRecruiterFavoriteJobs($recuriterId, $limit = "")
    {
        $data = [];
        $companyJobs = self::select('company_jobs.id','company_jobs.slug', 'company_jobs.title as companyJobTitle', 'companies.name as companyName', 'company_address.city as companyCity', 'company_address.state as companyState', 'company_jobs.salary_type as salaryType', 'company_jobs.from_salary as fromSalary', 'company_jobs.to_salary as toSalary', 'company_jobs.job_description as jobDescription', 'company_jobs.created_at as postedOn', 'company_jobs.total_amount_paid as amountRequired', 'company_jobs.balance as blanace', 'company_jobs.status as companyStatus', 'company_jobs.compensation_type', 'company_jobs.compensation_type', 'company_jobs.job_short_description', 'countries.name as companyCountry', 'company_jobs.job_remote_work_id')

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
            ->whereNull('company_jobs.deleted_at');
        $companyJobs = $companyJobs->join('recruiter_favourite_jobs', function ($join) use ($recuriterId) {
            $join->on('recruiter_favourite_jobs.company_job_id', '=', 'company_jobs.id');
            $join->where('recruiter_favourite_jobs.recruiter_id', $recuriterId);
        });
        $companyJobs = $companyJobs->groupBy('company_jobs.id');
        $companyJobs = $companyJobs->orderBy('company_jobs.created_at', 'DESC');
        $companyJobs = $companyJobs->limit($limit);
        $companyJobs = $companyJobs->get();
        if ($companyJobs) {
            $companyJobs = self::formatJobListForRecruiter($companyJobs, $recuriterId);
        }
        $return = $companyJobs;
        //return ['data' => $return, 'page' => $page, 'limit' => $limit];
        return $return;
    }

    public static function getRecruiterSimilarJobs($recuriterId, $limit = "")
    {
        $companyJobs = self::select('company_jobs.id','company_jobs.slug', 'company_jobs.title as companyJobTitle', 'companies.name as companyName', 'company_address.city as companyCity', 'company_address.state as companyState', 'countries.name as companyCountry', 'company_jobs.salary_type as salaryType', 'company_jobs.from_salary as fromSalary', 'company_jobs.to_salary as toSalary', 'company_jobs.job_description as jobDescription', 'company_jobs.created_at as postedOn', 'company_jobs.total_amount_paid as amountRequired', 'company_jobs.balance as blanace', 'company_jobs.status as companyStatus', 'company_jobs.compensation_type', 'company_jobs.compensation_type', 'company_jobs.job_short_description', 'company_jobs.slug')
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
            ->whereNull('company_jobs.deleted_at')
            ->groupBy('company_jobs.id');
            
        $companyJobs->whereIn('company_jobs.job_category_id', function ($query) use ($recuriterId) {
            $query->select('company_jobs.job_category_id')
                ->from('company_job_applications')
                ->leftjoin('company_jobs', 'company_jobs.id', 'company_job_applications.company_job_id')
                ->where('company_job_applications.related_id', $recuriterId);
        });
        $companyJobs->whereNotIn('company_jobs.id', function ($query) use ($recuriterId) {
            $query->select('company_job_applications.company_job_id')
                ->from('company_job_applications')
                ->where('company_job_applications.applied_type', 1)
                ->where('company_job_applications.related_id', $recuriterId);
        });
        $companyJobs->where('company_jobs.status', 1);
        
        $companyJobs->orderBy('company_jobs.created_at', 'DESC');
        if ($limit) {
            $companyJobs = $companyJobs->limit($limit);
        }
        $companyJobs = $companyJobs->distinct()->get();
        if ($companyJobs) {
            $companyJobs = self::formatJobListForRecruiterSimilar($companyJobs, $recuriterId);
        }        
        $return = $companyJobs;
        return $return;

        //$data = [];
        /* $companyJobs = DB::select(DB::raw("SELECT cj1.* ,cj1.id, cj1.title as companyJobTitle, companies.name as companyName, company_address.city as companyCity, company_address.state as companyState, cj1.salary_type as salaryType, cj1.from_salary as fromSalary, cj1.to_salary as toSalary, cj1.job_description as jobDescription, cj1.created_at as postedOn, cj1.total_amount_paid as amountRequired, cj1.balance as blanace, cj1.status as companyStatus, cj1.compensation_type, cj1.compensation_type, cj1.job_short_description FROM company_jobs cj, company_job_applications ja, company_jobs cj1,companies,company_address WHERE ja.applied_type = '1'  AND ja.related_id = $recuriterId  AND ja.company_job_id = cj.id  AND cj.job_category_id = cj1.job_category_id  AND cj1.status = '1'  AND cj1.deleted_at IS NULL  AND cj.id != cj1.id  GROUP By cj1.id  ORDER BY cj1.created_at DESC  LIMIT $limit"));
        if ($companyJobs) {
            $companyJobs = self::formatJobListForRecruiterSimilar($companyJobs, $recuriterId);
        }
        $return = $companyJobs;
        return $return; */
    }
    public static function formatJobListForRecruiterSimilar($data, $recuriterId)
    {
        $return = [];
        foreach ($data as $key => $value) {
            $jobOpenings = self::getAttrById($value->id, 'vaccancy');
            $jobApproved = CompanyJobApplications::getTotalJobApproved($value->id);
            $jobRemainingApprovals = $jobOpenings - $jobApproved;
            $jobMyApproved = CompanyJobApplications::getTotalJobMyApproved($value->id, $recuriterId);
            $jobMyRejected = CompanyJobApplications::getTotalJobMyRejected($value->id, $recuriterId);
            $jobMyPending = CompanyJobApplications::getTotalJobMyPending($value->id, $recuriterId);
            $jobPayout = AdminCommission::getTotalJobByPayout($recuriterId, $value->id);

            if ($value->compensation_type == 'r')
                $salary = '$' . getFormatedAmount($value->fromSalary, 0) . ' - $' . getFormatedAmount($value->toSalary, 0);
            else
                $salary = '$' . getFormatedAmount($value->fromSalary, 0);

            $statusText = '';
            $statusColor = '';
            switch ($value->companyStatus) {
                case 1:
                    $statusText = 'Open';
                    $statusColor = 'open';
                    break;
                case 2:
                    $statusText = 'Drafted';
                    $statusColor = 'drafted';
                    break;
                case 3:
                    $statusText = 'Paused';
                    $statusColor = 'paused';
                    break;
                case 4:
                    $statusText = 'Closed';
                    $statusColor = 'closed';
                    break;

                default:
                    $statusText = '';
                    $statusColor = '';
            }
            $return[] = [
                "jobId" => $value->id,
                "jobTitle" => $value->companyJobTitle,
                "jobSlug" => $value->slug,
                "companyName" => $value->companyName,
                "companyCity" => $value->companyCity,
                "companyState" => $value->companyState,
                "companyCountry" => $value->companyCountry,
                "salaryType" => $value->salaryType,
                "salaryText" => $salary,
                "jobDescription" => $value->jobDescription,
                "jobShortDescription" => $value->job_short_description,
                "postedOn" => getFormatedDateForWeb($value->postedOn),
                "amountRequired" => ($value->amountRequired) ? '$' . $value->amountRequired : '-',
                "blanace" => ($value->blanace) ? '$' . $value->blanace : '-',
                "jobOpenings" => $jobOpenings,
                "jobApproved" => $jobApproved,
                "jobRemainingApprovals" => $jobRemainingApprovals,
                "jobMyApproved" => $jobMyApproved,
                "jobMyRejected" => $jobMyRejected,
                "jobMyPending" => $jobMyPending,
                "companyStatus" => $value->companyStatus,
                "statusText" => $statusText,
                "statusColor" => $statusColor,
                "isFavorite" => RecruiterFavouriteJobs::checkIsFavorite($value->id, $recuriterId),
                "jobPayout" => ($jobPayout) ? '$' . $jobPayout : '-',

            ];
        }
        return $return;
    }

    public static function getCandidateSimilarJobs($candidateId, $limit = "")
    {
        $companyJobs = self::select('company_jobs.id', 'company_jobs.title as companyJobTitle', 'companies.name as companyName', 'company_address.city as companyCity', 'company_address.state as companyState', 'countries.name as companyCountry', 'company_jobs.salary_type as salaryType', 'company_jobs.from_salary as fromSalary', 'company_jobs.to_salary as toSalary', 'company_jobs.job_description as jobDescription', 'company_jobs.created_at as postedOn', 'company_jobs.total_amount_paid as amountRequired', 'company_jobs.balance as blanace', 'company_jobs.status as companyStatus', 'company_jobs.compensation_type', 'company_jobs.compensation_type', 'company_jobs.job_short_description', 'company_jobs.slug')
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
            ->whereNull('company_jobs.deleted_at')
            ->groupBy('company_jobs.id');
        // $companyJobs->join('company_jobs as cj', function ($join) {
        //     $join->on('cj.job_category_id', '=', 'company_jobs.job_category_id');
        //     $join->on('cj.id', '!=', 'company_jobs.id');
        // })->join('candidate_applications', function ($join) {
        //     $join->on('candidate_applications.company_job_id', '=', 'cj.id');
        // });
        $companyJobs->whereIn('company_jobs.job_category_id', function ($query) use ($candidateId) {
            $query->select('company_jobs.job_category_id')
                ->from('candidate_applications')
                ->leftjoin('company_jobs', 'company_jobs.id', 'candidate_applications.company_job_id')
                ->where('candidate_applications.candidate_id', $candidateId);
        });
        $companyJobs->whereNotIn('company_jobs.id', function ($query) use ($candidateId) {
            $query->select('candidate_applications.company_job_id')
                ->from('candidate_applications')
                //->where('candidate_applications.applied_type', 1)
                ->where('candidate_applications.candidate_id', $candidateId);
        });
        $companyJobs->where('company_jobs.status', 1);

        // $companyJobs->where('candidate_applications.candidate_id', $candidateId)
        //     ->where('company_jobs.status', 1);
        $companyJobs = $companyJobs->distinct()->get();
        if ($companyJobs) {
            $companyJobs = self::formatJobListForCandidateSimilar($companyJobs);
            $return = $companyJobs;
        }
        return $return;
    }

    public static function formatJobListForCandidateSimilar($data)
    {
        $return = [];
        $candidateId = Auth::user()->candidate->id;
        foreach ($data as $key => $value) {
            $jobOpenings = self::getAttrById($value->id, 'vaccancy');

            if ($value->compensation_type == 'r')
                $salary = '$' . getFormatedAmount($value->fromSalary, 0) . ' - $' . getFormatedAmount($value->toSalary, 0);
            else
                $salary = '$' . getFormatedAmount($value->fromSalary, 0);

            $statusText = '';
            $statusColor = '';
            switch ($value->companyStatus) {
                case 1:
                    $statusText = 'Open';
                    $statusColor = 'open';
                    break;
                case 2:
                    $statusText = 'Drafted';
                    $statusColor = 'drafted';
                    break;
                case 3:
                    $statusText = 'Paused';
                    $statusColor = 'paused';
                    break;
                case 4:
                    $statusText = 'Closed';
                    $statusColor = 'closed';
                    break;

                default:
                    $statusText = '';
                    $statusColor = '';
            }
            $return[] = [
                "jobId" => $value->id,
                "jobTitle" => $value->companyJobTitle,
                "companyName" => $value->companyName,
                "companyCity" => $value->companyCity,
                "companyState" => $value->companyState,
                "companyCountry" => $value->companyCountry,
                "salaryType" => $value->salaryType,
                "salaryText" => $salary,
                "jobDescription" => $value->jobDescription,
                "jobShortDescription" => $value->job_short_description,
                "postedOn" => getFormatedDateForWeb($value->postedOn),
                "amountRequired" => ($value->amountRequired) ? '$' . $value->amountRequired : '-',
                "blanace" => ($value->blanace) ? '$' . $value->blanace : '-',
                "jobOpenings" => $jobOpenings,
                "companyStatus" => $value->companyStatus,
                "statusText" => $statusText,
                "statusColor" => $statusColor,
                "isFavorite" => CandidateFavouriteJobs::checkIsFavorite($value->id),

            ];
        }
        return $return;
    }


    public static function formatJobListForRecruiter($data, $recuriterId)
    {
        $return = [];
        foreach ($data as $key => $value) {
            $jobOpenings = self::getAttrById($value->id, 'vaccancy');
            $jobApproved = CompanyJobApplications::getTotalJobApproved($value->id);
            $jobRemainingApprovals = $jobOpenings - $jobApproved;
            $jobMyApproved = CompanyJobApplications::getTotalJobMyApproved($value->id, $recuriterId);
            $jobMyRejected = CompanyJobApplications::getTotalJobMyRejected($value->id, $recuriterId);
            $jobMyPending = CompanyJobApplications::getTotalJobMyPending($value->id, $recuriterId);
            $jobPayout = AdminCommission::getTotalJobByPayout($recuriterId, $value->id);

            if ($value->compensation_type == 'r')
                $salary = '$' . getFormatedAmount($value['fromSalary'], 0) . ' - $' . getFormatedAmount($value['toSalary'], 0);
            else
                $salary = '$' . getFormatedAmount($value['fromSalary'], 0);

            $statusText = '';
            $statusColor = '';
            switch ($value['companyStatus']) {
                case 1:
                    $statusText = 'Open';
                    $statusColor = 'open';
                    break;
                case 2:
                    $statusText = 'Drafted';
                    $statusColor = 'drafted';
                    break;
                case 3:
                    $statusText = 'Paused';
                    $statusColor = 'paused';
                    break;
                case 4:
                    $statusText = 'Closed';
                    $statusColor = 'closed';
                    break;

                default:
                    $statusText = '';
                    $statusColor = '';
            }
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
                "amountRequired" => ($value['amountRequired']) ? '$' . $value['amountRequired'] : '-',
                "blanace" => ($value['blanace']) ? '$' . $value['blanace'] : '-',
                "jobOpenings" => $jobOpenings,
                "jobApproved" => $jobApproved,
                "jobRemainingApprovals" => $jobRemainingApprovals,
                "jobMyApproved" => $jobMyApproved,
                "jobMyApprovedList" => $jobMyApproved > 0 ? CompanyJobApplications::getTotalJobMyApprovedList($value->id, $recuriterId) : array(),
                "jobMyRejected" => $jobMyRejected,
                "jobMyRejectedList" => $jobMyRejected > 0 ? CompanyJobApplications::getTotalJobMyRejectedList($value->id, $recuriterId) : array(),
                "jobMyPending" => $jobMyPending,
                "jobMyPendingList" => $jobMyPending > 0 ? CompanyJobApplications::getTotalJobMyPendingList($value->id, $recuriterId) : array(),
                "companyStatus" => $value['companyStatus'],
                "statusText" => $statusText,
                "statusColor" => $statusColor,
                "jobRemoteWork" => JobFieldOption::getAttrById($value['job_remote_work_id'], 'option'),
                "isFavorite" => RecruiterFavouriteJobs::checkIsFavorite($value->id, $recuriterId),
                "jobPayout" => ($jobPayout) ? '$' . $jobPayout : '-',

            ];
        }
        return $return;
    }

    public static function getJobsCountByStatus($companyId, $status = "")
    {
        if ($status != '')
            return self::where('company_id', $companyId)->where('status', $status)->whereNull('deleted_at')->count();
        else
            return self::where('company_id', $companyId)->whereNull('deleted_at')->count();
    }
    public static function getMonthwiseClosedCount($companyId, $month, $year)
    {
        return self::where('company_id', $companyId)->where('status', 4)->whereMonth('created_at', $month)->whereYear('created_at', $year)->whereNull('deleted_at')->count();
    }
    public static function getYearwiseClosedCount($companyId, $year)
    {
        return self::where('company_id', $companyId)->where('status', 4)->whereYear('created_at', $year)->whereNull('deleted_at')->count();
    }
    public static function getClosedCount($companyId)
    {
        return self::where('company_id', $companyId)->where('status', 4)->whereNull('deleted_at')->count();
    }
    public static function getMonthwiseAmountSpent($companyId, $month, $year)
    {
        $data = CompanyJob::select(DB::raw('SUM(total_amount_paid) AS amount_spent'))->where('company_id', $companyId)->whereMonth('created_at', $month)->whereYear('created_at', $year)->whereNull('deleted_at')->first();
        if (!empty($data) && isset($data['amount_spent']))
            return $data['amount_spent'];
        else
            return 0;
    }
    public static function getYearwiseAmountSpent($companyId, $year)
    {
        $data = CompanyJob::select(DB::raw('SUM(total_amount_paid) AS amount_spent'))->where('company_id', $companyId)->whereNull('deleted_at')->whereYear('created_at', $year)->first();
        if (!empty($data) && isset($data['amount_spent']))
            return $data['amount_spent'];
        else
            return 0;
    }
    public static function getAmountSpent($companyId)
    {
        $data = CompanyJob::select(DB::raw('SUM(total_amount_paid) AS amount_spent'))->where('company_id', $companyId)->whereNull('deleted_at')->first();
        if (!empty($data) && isset($data['amount_spent']))
            return $data['amount_spent'];
        else
            return 0;
    }

    public static function getCompanyJobList($companyId)
    {
        $companyJobs = self::where('company_id', $companyId)
            ->where('status', 1)
            ->whereNull('deleted_at')->get(['title', 'id']);

        return $companyJobs;
    }

    public static function checkSlug($companyId, $slug)
    {
        $companyJobs = self::where('slug', $slug)
            ->where('company_id', $companyId)
            ->whereNull('deleted_at')->first();
        if (!empty($companyJobs))
            return $slug;
        else
            return $slug . '-' . rand(1, 100);
    }

    public static function addJobDetails($data)
    {
        $return = 0;
        $success = true;
        $authId = User::getLoggedInId();
        $companyId = User::getLoggedInCompanyId();
        $data['user_id'] = $authId;
        $data['company_id'] = $companyId;
        if (isset($data['company_address_id']) && $data['company_address_id'] == "0") {
            // pre($data['address']);
            $data['address']['company_id'] = $companyId;
            $data['address']['is_other'] = 1;
            $addressIs = CompanyAddress::addAddress($data['address']);
            if ($addressIs['success']) {
                $data['company_address_id'] = $addressIs['data'];
            } else {
                $data['company_address_id'] = $addressIs['id'];
            }
            unset($data['address']);
        }
        $data['slug'] = getSlug(stringSlugify($data['title']), "", 'company_jobs', 'slug');
        $allowed = [
            'id',
            'user_id',
            'company_id',
            'title',
            'slug',
            'company_address_id',
            'job_category_id',
            'job_subcategory_id',
            'job_industry_id',
            'job_employment_type_id',
            'job_schedule_ids',
            'job_contract_id',
            'contract_duration',
            'contract_duration_type',
            'relocation_available',
            'sponsorship_available',
            'job_remote_work_id',
            'vaccancy',
            'salary_type',
            'compensation_type',
            'from_salary',
            'to_salary',
            'pay_duration',
            'hide_compensation_details_to_candidates',
            'supplemental_pay_offered_ids',
            'benefits_offered_ids',
            'additional_benefits',
            'job_description',
            'job_short_description',
            'covid_precautions',
            'job_communication_template_id',
            'amount',
            'total_amount_paid',
            'balance',
            'recruiter_commission',
            'admin_commission',
            'job_post_amount',
            'status',
        ];
        $data = array_intersect_key($data, array_flip($allowed));
        $newEntry = new CompanyJob();
        try {
            foreach ($data as $key => $value) {
                if ($key == 'job_schedule_ids' || $key == 'supplemental_pay_offered_ids' || $key == 'benefits_offered_ids')
                    $newEntry->$key = implode(',', $value);
                else
                    $newEntry->$key = $value;
            }
            $newEntry->save();
            $return = $newEntry->id;
        } catch (\Exception $e) {
            //pre($e->getMessage());
            $success = false;
        }
        return ['companyJobId' => $return, 'success' => $success];
    }

    public static function updateJobDetails($id, $data)
    {
        $return = 0;
        $success = true;
        $authId = User::getLoggedInId();
        $companyId = User::getLoggedInCompanyId();
        // pre($data);
        $data['user_id'] = $authId;
        $data['company_id'] = $companyId;
        if (isset($data['company_address_id']) && $data['company_address_id'] == "0") {
            // pre($data['address']);
            $data['address']['company_id'] = $companyId;
            $data['address']['is_other'] = 1;
            $addressIs = CompanyAddress::addAddress($data['address']);
            if ($addressIs['success']) {
                $data['company_address_id'] = $addressIs['data'];
            }else{
                $data['company_address_id'] = $addressIs['id'];
            }
            unset($data['address']);
        }

        if (isset($data['title']))
            $data['slug'] = getSlug(stringSlugify($data['title']), "", 'company_jobs', 'slug',$id);
        $allowed = [
            'id',
            'user_id',
            'company_id',
            'title',
            'slug',
            'company_address_id',
            'job_category_id',
            'job_subcategory_id',
            'job_industry_id',
            'job_employment_type_id',
            'job_schedule_ids',
            'job_contract_id',
            'contract_duration',
            'contract_duration_type',
            'relocation_available',
            'sponsorship_available',
            'job_remote_work_id',
            'vaccancy',
            'salary_type',
            'compensation_type',
            'from_salary',
            'to_salary',
            'pay_duration',
            'hide_compensation_details_to_candidates',
            'supplemental_pay_offered_ids',
            'benefits_offered_ids',
            'additional_benefits',
            'job_description',
            'job_short_description',
            'covid_precautions',
            'job_communication_template_id',
            'amount',
            'total_amount_paid',
            'balance',
            'recruiter_commission',
            'admin_commission',
            'job_post_amount',
            'status',
            'created_at',
            'updated_at'
        ];
        $data = array_intersect_key($data, array_flip($allowed));
        $exist = self::where('id', $id)->first();
        if ($exist) {
            try {
                foreach ($data as $key => $value) {
                    if ($key == 'job_schedule_ids' || $key == 'supplemental_pay_offered_ids' || $key == 'benefits_offered_ids')
                        $exist->$key = implode(',', $value);
                    else
                        $exist->$key = $value;
                }
                $exist->save();
                $return = $exist->id;
            } catch (\Exception $e) {
                //$return = $e->getMessage();
                $success = false;
            }
        }
        return ['companyJobId' => $return, 'success' => $success];
    }
    public static function diductJobBalance($jobId)
    {
        $jobPostAmount = GlobalSettings::getSingleSettingVal('job_post_amount');
        $companyJob = CompanyJob::where('id', $jobId)->first();
        $balance = (float) $companyJob->balance;
        $balance = $balance - (float) $jobPostAmount;
        $companyJob->balance = $balance;
        $companyJob->update();
    }

    public static function getJobBalance($jobId)
    {
        $companyJob = CompanyJob::where('id', $jobId)->first();
        $balance = (float) $companyJob->balance;
        return $balance;
    }

    public static function getList($companyId, $jobId)
    {
        $return = [];
        $data = self::selectRaw('id,title')->where('company_id', $companyId)->where('id', "!=", $jobId)->where('status', 1)->whereNull('deleted_at')->get();
        foreach ($data as $value) {
            $return[] = [
                "jobId" => $value['id'],
                "jobTitle" => $value['title'],
            ];
        }
        return $return;
    }
    public static function getJobById($companyId, $jobId)
    {
        $return = self::where('company_id', $companyId)->where('id', $jobId)->whereIn('status', [1,2])->whereNull('deleted_at')->first();
        return $return;
    }

    public static function getAttrById($id, $attr)
    {
        $return = "";
        $data = self::select($attr)->where('id', $id)->first();
        if ($data) {
            $return = $data->$attr;
        }
        return $return;
    }
    //find job query
    public static function serchJobListForCandidate($page = '1', $search = '', $searchLoc = '',  $sort = '', $filter = '')
    {
        //$recuriterId = Auth::user()->recruiter->id;
        $data = [];
        $limit = 0;
        $companyJobs = self::select('company_jobs.id', 'company_jobs.title as companyJobTitle', 'companies.name as companyName', 'company_address.city as companyCity', 'company_address.state as companyState', 'countries.name as companyCountry', 'company_jobs.salary_type as salaryType', 'company_jobs.from_salary as fromSalary', 'company_jobs.to_salary as toSalary', 'company_jobs.job_description as jobDescription', 'company_jobs.created_at as postedOn', 'company_jobs.total_amount_paid as amountRequired', 'company_jobs.balance as blanace', 'company_jobs.status as companyStatus', 'company_jobs.compensation_type', 'company_jobs.compensation_type', 'company_jobs.job_short_description', 'company_jobs.slug', 'company_jobs.hide_compensation_details_to_candidates')
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
            ->whereNull('company_jobs.deleted_at')
            ->groupBy('company_jobs.id');

        if ($search) {
            $companyJobs->where('company_jobs.title', 'like', '%' . $search . '%');
        }
        if ($searchLoc) {
            $companyJobs->where(function ($q) use ($searchLoc) {
                $q->orWhere('company_address.city', 'like', '%' . $searchLoc . '%');
                $q->orWhere('company_address.state', 'like', '%' . $searchLoc . '%');
            });
        }
        if (!empty($filter)) {
            $companyJobs->where('company_jobs.job_category_id', $filter);
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

        if ($page) {
            $limit = 10;
            $offset = ($page - 1) * $limit;
            $companyJobs->offset($offset);
            $companyJobs->limit($limit);
        }
        $companyJobs = $companyJobs->distinct()->get();
        if ($companyJobs) {
            $companyJobs = self::formatJobListForCandidate($companyJobs);
        }
        $return = ['companyJobs' => $companyJobs, 'page' => $page, 'limit' => $limit];
        //return ['data' => $return, 'page' => $page, 'limit' => $limit];
        return $return;
    }
    public static function formatJobListForCandidate($data)
    {
        $return = [];
        //$recuriterId = Auth::user()->recruiter->id;
        foreach ($data as $key => $value) {
            $jobOpenings = self::getAttrById($value->id, 'vaccancy');
            if ($value->compensation_type == 'r')
                $salary = '$' . getFormatedAmount($value['fromSalary'], 0) . ' - $' . getFormatedAmount($value['toSalary'], 0);
            else
                $salary = '$' . getFormatedAmount($value['fromSalary'], 0);
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
                "jobRemoteWork" => JobFieldOption::getAttrById($value['job_remote_work_id'], 'option'),
                "isHidecompensationDetails" => $value['hide_compensation_details_to_candidates'],
            ];
        }
        return $return;
    }

    //candidate job list
    public static function searchCandidateJobList($tab, $page = '1', $search = '', $sort = '', $filter = [])
    {
        $candidateId = Auth::user()->candidate->id;
        $data = [];
        $limit = 0;
        $companyJobs = self::select('company_jobs.id', 'company_jobs.title as companyJobTitle', 'companies.name as companyName', 'company_address.city as companyCity', 'company_address.state as companyState', 'countries.name as companyCountry', 'company_jobs.salary_type as salaryType', 'company_jobs.from_salary as fromSalary', 'company_jobs.to_salary as toSalary', 'company_jobs.job_description as jobDescription', 'company_jobs.created_at as postedOn', 'company_jobs.total_amount_paid as amountRequired', 'company_jobs.balance as blanace', 'company_jobs.status as companyStatus', 'company_jobs.compensation_type', 'company_jobs.compensation_type', 'company_jobs.job_short_description', 'company_jobs.slug', 'company_jobs.hide_compensation_details_to_candidates', 'company_jobs.job_remote_work_id')
            ->leftJoin('companies', function ($join) {
                $join->on('companies.id', '=', 'company_jobs.company_id');
                $join->where('companies.status', '=', 1);
                $join->whereNull('companies.deleted_at');
            })
            /* ->leftJoin('company_address', function ($join) {
                $join->on('company_address.company_id', '=', 'companies.id');
                $join->where('company_address.status', '=', 1);
                $join->whereNull('company_address.deleted_at');
            }) */
            ->leftJoin('company_address', function ($join) {
                $join->on('company_address.id', '=', 'company_jobs.company_address_id');
            })
            ->leftJoin('countries', 'countries.id', '=', 'company_address.country')
            ->whereNull('company_jobs.deleted_at')
            ->groupBy('company_jobs.id');
        if (!empty($tab)) {
            if ($tab == 1) {
                $companyJobs = $companyJobs->where('company_jobs.status', 1);
            } else if ($tab == 2) // Favorite
            {
                $companyJobs = $companyJobs->join('candidate_favourite_jobs', function ($join) use ($candidateId) {
                    $join->on('candidate_favourite_jobs.company_job_id', '=', 'company_jobs.id');
                    $join->where('candidate_favourite_jobs.candidate_id', $candidateId);
                });
            } else if ($tab == 3) //Applied
            {
                $companyJobs = $companyJobs->join('candidate_applications', function ($join) use ($candidateId) {
                    $join->on('candidate_applications.company_job_id', '=', 'company_jobs.id');
                });
                $companyJobs->where('candidate_applications.candidate_id', $candidateId)
                    ->groupBy('candidate_applications.company_job_id');
            } else if ($tab == 4) //Similar
            {
              $companyJobs->whereIn('company_jobs.job_category_id', function ($query) use ($candidateId) {
                    $query->select('company_jobs.job_category_id')
                        ->from('candidate_applications')
                        ->leftjoin('company_jobs', 'company_jobs.id', 'candidate_applications.company_job_id')
                        ->where('candidate_applications.candidate_id', $candidateId);
                });
                $companyJobs->whereNotIn('company_jobs.id', function ($query) use ($candidateId) {
                    $query->select('candidate_applications.company_job_id')
                        ->from('candidate_applications')
                        //->where('candidate_applications.applied_type', 1)
                        ->where('candidate_applications.candidate_id', $candidateId);
                });
                $companyJobs->where('company_jobs.status', 1);
                // $companyJobs->join('company_jobs as cj', function ($join) {
                //     $join->on('cj.job_category_id', '=', 'company_jobs.job_category_id');
                //     $join->on('cj.id', '!=', 'company_jobs.id');
                // })->join('candidate_applications', function ($join) {
                //     $join->on('candidate_applications.company_job_id', '=', 'cj.id');
                // });
                //
                // $companyJobs->where('candidate_applications.candidate_id', $candidateId)
                //     ->where('company_jobs.status', 1);
                //->groupBy('company_jobs.id');
            }
        }

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

        if ($page) {
            $limit = 10;
            $offset = ($page - 1) * $limit;
            $companyJobs->offset($offset);
            $companyJobs->limit($limit);
        }
        $companyJobs = $companyJobs->distinct()->get();
        if ($companyJobs) {
            $companyJobs = self::formatJobListForCandidate($companyJobs);
        }
        $return = ['companyJobs' => $companyJobs, 'page' => $page, 'limit' => $limit];
        //return ['data' => $return, 'page' => $page, 'limit' => $limit];
        return $return;
    }

    //search jobs for all login
    public static function searchJobList($page = '1', $search = '', $sort = '', $filter = [])
    {
        $data = [];
        $limit = 0;
        $companyJobs = self::select('company_jobs.id', 'company_jobs.title as companyJobTitle', 'companies.name as companyName', 'company_address.city as companyCity', 'company_address.state as companyState', 'countries.name as companyCountry', 'company_jobs.salary_type as salaryType', 'company_jobs.from_salary as fromSalary', 'company_jobs.to_salary as toSalary', 'company_jobs.job_description as jobDescription', 'company_jobs.created_at as postedOn', 'company_jobs.total_amount_paid as amountRequired', 'company_jobs.balance as blanace', 'company_jobs.status as companyStatus', 'company_jobs.compensation_type', 'company_jobs.compensation_type', 'company_jobs.job_short_description', 'company_jobs.slug', 'company_jobs.hide_compensation_details_to_candidates', 'company_jobs.job_remote_work_id')
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
            ->whereNull('company_jobs.deleted_at')
            ->groupBy('company_jobs.id');
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

        if ($page) {
            $limit = 10;
            $offset = ($page - 1) * $limit;
            $companyJobs->offset($offset);
            $companyJobs->limit($limit);
        }
        $companyJobs = $companyJobs->where('company_jobs.status',1)->distinct()->get();
        if ($companyJobs) {
            $companyJobs = self::formatJobListForCandidate($companyJobs);
        }
        $return = ['companyJobs' => $companyJobs, 'page' => $page, 'limit' => $limit];
        //return ['data' => $return, 'page' => $page, 'limit' => $limit];
        return $return;
    }
    public static function getTotalBalance($companyId)
    {
        return self::where('company_id', $companyId)->whereNull('deleted_at')->sum('balance');
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
}
