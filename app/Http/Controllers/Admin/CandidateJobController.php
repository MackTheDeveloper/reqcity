<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\CandidateApplications;
use App\Models\Candidate;
use App\Models\CandidateResume;
use App\Models\CompanyJob;
use App\Models\CompanyJobCommunications;
use App\Models\JobFieldOption;
use App\Models\User;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use Auth;
use DataTables;
use Carbon\Carbon;
use DB;
use Excel;
use Response;

class CandidateJobController extends Controller
{
    public function index(Request $request)
    {
        $req = $request->all();
        $baseUrl = $this->getBaseUrl();
        $candidates = User::getCandidateSpecialist();
        return view("admin.candidate.candidate_jobs", compact('candidates', 'baseUrl'));
    }
    public function list(Request $request)
    {
        $req = $request->all();
        $start = $req['start'];
        $length = $req['length'];
        $search = $req['search']['value'];
        $order = $req['order'][0]['dir'];
        $column = $req['order'][0]['column'];
        $orderby = ['id', '', 'first_name', 'jobTitle', 'companyName', '', '', '', 'created_at', 'updated_at'];

        $total = CandidateApplications::selectRaw('count(*) as total')
            ->whereNull('candidate_applications.deleted_at');
            
        $query = CandidateApplications::select('candidate_applications.*', 'companies.name as companyName', 'company_jobs.title as jobTitle', 'candidates.first_name', 'candidates.last_name','users.firstname as candidateSpecialistFirstName', 'users.lastname as candidateSpecialistLastName')
            ->leftJoin("company_jobs", "candidate_applications.company_job_id", "company_jobs.id")
            ->leftJoin("companies", "company_jobs.company_id", "companies.id")
            ->leftJoin("candidates", "candidate_applications.candidate_id", "candidates.id")
            ->leftJoin("candidate_resume", "candidate_applications.candidate_cv_id", "candidate_resume.id")
            ->leftJoin("users", "candidate_applications.specialist_user_id", "users.id")
            ->whereNull('candidates.deleted_at');

        $filteredq = CandidateApplications::select('candidate_applications.*', 'companies.name as companyName', 'company_jobs.title as jobTitle', 'candidates.first_name', 'candidates.last_name')
            ->leftJoin("company_jobs", "candidate_applications.company_job_id", "company_jobs.id")
            ->leftJoin("companies", "company_jobs.company_id", "companies.id")
            ->leftJoin("candidates", "candidate_applications.candidate_id", "candidates.id")
            ->leftJoin("candidate_resume", "candidate_applications.candidate_cv_id", "candidate_resume.id")
            ->leftJoin("users", "candidate_applications.specialist_user_id", "users.id")
            ->whereNull('candidates.deleted_at');

        if (isset($request->is_active) && $request->is_active != 'all') {
            $total = $total->where('candidate_applications.status', $request->is_active);
            $filteredq = $filteredq->where('candidate_applications.status', $request->is_active);
            $query = $query->where('candidate_applications.status', $request->is_active);
        }
        if (isset($request->candiateSpecialist) && $request->candiateSpecialist != 'all') {
            $total = $total->where('candidate_applications.specialist_user_id', $request->candiateSpecialist);
            $filteredq = $filteredq->where('candidate_applications.specialist_user_id', $request->candiateSpecialist);
            $query = $query->where('candidate_applications.specialist_user_id', $request->candiateSpecialist);
        }
        if (!empty($request->startDate) && !empty($request->endDate)) {
            $startDate = date($request->startDate);
            $endDate = date($request->endDate);
            $total = $total->where(function ($q) use ($startDate, $endDate) {
                $q->whereBetween('candidate_applications.created_at', [$startDate, $endDate]);
            });
            $filteredq = $filteredq->where(function ($q) use ($startDate, $endDate) {
                $q->whereBetween('candidate_applications.created_at', [$startDate, $endDate]);
            });
            $query = $query->where(function ($q) use ($startDate, $endDate) {
                $q->whereBetween('candidate_applications.created_at', [$startDate, $endDate]);
            });
        }
        
        $total= $total->first();
        $totalfiltered = $total->total;

        if ($search != '') {
            $query->where(function ($query2) use ($search) {
                $query2->where('candidates.first_name', 'like', '%' . $search . '%')
                    ->orWhere('candidates.last_name', 'like', '%' . $search . '%')
                    ->orWhere('company_jobs.title', 'like', '%' . $search . '%')
                    ->orWhere('companies.name', 'like', '%' . $search . '%');
            });

            $filteredq->where(function ($query2) use ($search) {
                $query2->where('candidates.first_name', 'like', '%' . $search . '%')
                    ->orWhere('candidates.last_name', 'like', '%' . $search . '%')
                    ->orWhere('company_jobs.title', 'like', '%' . $search . '%')
                    ->orWhere('companies.name', 'like', '%' . $search . '%');
            });

            $recordCount = $filteredq->selectRaw('count(*) as total')->first();
            $totalfiltered = $recordCount->total;
        }


        $query = $query->orderBy($orderby[$column], $order)->offset($start)->limit($length)->get();
        $data = [];
        foreach ($query as $key => $value) {
            $resume = CandidateResume::getResumeById($value->candidate_cv_id);
            $downloadLink = "";
            $extension = pathinfo(storage_path($resume), PATHINFO_EXTENSION);
            if (isset($resume) && $resume != "") {
                if ($extension == "pdf") {
                    $downloadLink = '<a href="' . $resume . '" download><i class="fas fa-file-pdf"></i></a>';
                } else {
                    $downloadLink = '<a href="' . $resume . '" download><i class="fas fa-file-word"></i></a>';
                }
            } else {
                $downloadLink = "Not Uploded";
            }
            $menu = "";
            if (whoCanCheck(config('app.arrWhoCanCheck'), 'admin_candidate_jobs_assign')) {
                $menu .= ($value->status == 0 || $value->status == 1) ? '<li class="nav-item">'
                    . '<a class="nav-link assign-specialist" data-id="' . $value->id . '" data-specialist_id="' . $value->specialist_user_id . '">Assign Candidate Specialist </a>'
                    . '</li>' : '';
            }
            if (whoCanCheck(config('app.arrWhoCanCheck'), 'admin_candidate_jobs_view')) {
            $menu .= '<li class="nav-item">'
                . '<a class="nav-link view-job" data-job-id="' . $value->company_job_id . '">View</a>'
                . '</li>';
            }
            $action = view('admin.components.config-menu', compact('menu'))->render();
            $updatedAt = (!isset($value->updated_at)) ? "N/A" : getFormatedDate($value->updated_at);
            // $createdAt = (!isset($value->created_at))? "N/A":getFormatedDate($value->end_date);
            $data[] = [$value->id, $action, $value->first_name . ' ' . $value->last_name, $value->jobTitle, $value->companyName, $downloadLink, $value->candidateSpecialistFirstName . ' ' . $value->candidateSpecialistLastName, $value->status, $value->rejection_reason, getFormatedDate($value->created_at), $updatedAt];
        }
        $json_data = array(
            "draw" => intval($_REQUEST['draw']),
            "recordsTotal" => intval($total->total),
            "recordsFiltered" => intval($totalfiltered),
            "data" => $data,
        );
        return Response::json($json_data);
    }

    public function assignCandidateSpecialist(Request $request)
    {
        $model = CandidateApplications::where('id', $request->application_id)->first();
        $jobDetails = CompanyJob::select('title')->where('id', $model->company_job_id)->first();
        if (!empty($model)) {
            if (!empty($model->specialist_user_id)) {
                $code = 'JOBRMV';
                $msg_type = 'Job Application Assigned';
                $specialist_id = $model->specialist_user_id;
                $msg = 'Candidate job application has been assigned to another candidate specialist.';
                $candidate_id = $model->candidate_id;
                $msgCandidate = 'Your job application is for job ' . $jobDetails->title . ' is assigned to a candidate specialist';
            } else {
                $code = 'JOBASG';
                $msg_type = 'Job Application Assigned';
                $specialist_id = $request->specialist_user_id;
                $msg = 'New candidate job application has been assigned to you.';
                $candidate_id = $model->candidate_id;
                $msgCandidate = 'Your job application is for job ' . $jobDetails->title . ' is assigned to a candidate specialist';
            }
            $model->updated_at = Carbon::now();
            $model->specialist_user_id = $request->specialist_user_id;
            $model->status = 1;
            if ($model->save()) {
                $notification = insertNotification(5, $specialist_id, $code, $msg_type, $msg);
                $notificationCAndidate = insertNotification(3, $candidate_id, $code, $msg_type, $msgCandidate);
            }
            $result['status'] = 'true';
            $result['msg'] = "Candidate Specialist assigned successfully!";
            return $result;
        } else {
            $result['status'] = 'false';
            $result['msg'] = "Something went wrong!!";
            return $result;
        }
    }

    public function jobDetail($id)
    {
        $model = CompanyJob::where('id', $id)->first();
        if ($model) {
            $faq = CompanyJobCommunications::getCompanyFaq($model->id);
            $extra['employmentType'] =  JobFieldOption::getAttrById($model->job_employment_type_id, 'option');
            $extra['schedule'] =  JobFieldOption::getAttrById($model->job_schedule_ids, 'option');
            $extra['contractType'] =  JobFieldOption::getAttrById($model->job_contract_id, 'option');
            $extra['remoteWork'] =  JobFieldOption::getAttrById($model->job_remote_work_id, 'option');
            // pre($extra);
            return view('admin.candidate.view-job', compact('model', 'faq', 'extra'));
        }
    }

    public function newPageDynamic($slug)
    {
        return view("admin.candidate-submit." . $slug);
    }
}
