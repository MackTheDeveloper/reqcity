<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\CandidateResume;
use App\Models\AssignedJob;
use App\Models\Candidate;
use App\Models\CandidateExperience;
use App\Models\CompanyJob;
use App\Models\CompanyJobApplication;
use App\Models\CompanyJobApplicationQuestionnaire;
use App\Models\CompanyJobQuestionnaires;
use App\Models\CompanyQuestionnaires;
use App\Models\CompanyQuestionnaireType;
use App\Models\Country;
use App\Models\Notifications;
use App\Models\User;
use Illuminate\Http\Request;
use Auth;
use DataTables;
use Carbon\Carbon;
use Response;
use Session;

class AssignedJobController extends Controller
{
    public function index(Request $request)
    {
        $req = $request->all();
        return view("admin.assigned-job.index");
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
        $loginUserId = Auth::guard('admin')->user()->id;
        // pre($loginUserId);
        $role = User::getBackendRole();

        $total = AssignedJob::selectRaw('count(*) as total')
            // ->where('candidate_applications.specialist_user_id',$loginUserId)
            ->where('candidate_applications.status', '!=', '0')
            ->whereNull('candidate_applications.deleted_at');

        $query = AssignedJob::select('candidate_applications.*', 'companies.name as companyName', 'company_jobs.title as jobTitle', 'candidates.first_name', 'candidates.last_name')
            ->leftJoin("company_jobs", "candidate_applications.company_job_id", "company_jobs.id")
            ->leftJoin("companies", "company_jobs.company_id", "companies.id")
            ->leftJoin("candidates", "candidate_applications.candidate_id", "candidates.id")
            ->leftJoin("candidate_resume", "candidate_applications.candidate_cv_id", "candidate_resume.id")
            // ->where('candidate_applications.specialist_user_id',$loginUserId)
            ->where('candidate_applications.status', '!=', '0')
            ->whereNull('candidates.deleted_at');

        $filteredq = AssignedJob::select('candidate_applications.*', 'companies.name as companyName', 'company_jobs.title as jobTitle', 'candidates.first_name', 'candidates.last_name')
            ->leftJoin("company_jobs", "candidate_applications.company_job_id", "company_jobs.id")
            ->leftJoin("companies", "company_jobs.company_id", "companies.id")
            ->leftJoin("candidates", "candidate_applications.candidate_id", "candidates.id")
            ->leftJoin("candidate_resume", "candidate_applications.candidate_cv_id", "candidate_resume.id")
            // ->where('candidate_applications.specialist_user_id',$loginUserId)
            ->where('candidate_applications.status', '!=', '0')
            ->whereNull('candidates.deleted_at');

        if ($role == config('app.candidateSpecialistRoleId')) {
            $total = $total->where('candidate_applications.specialist_user_id', $loginUserId);
            $query = $query->where('candidate_applications.specialist_user_id', $loginUserId);
            $filteredq = $filteredq->where('candidate_applications.specialist_user_id', $loginUserId);
        }

        if (isset($request->is_active) && $request->is_active != 'all') {
            $total = $total->where('candidate_applications.status', $request->is_active);
            $filteredq = $filteredq->where('candidate_applications.status', $request->is_active);
            $query = $query->where('candidate_applications.status', $request->is_active);
        }
        // if (isset($request->company) && $request->company!='all') {
        //     $filteredq = $filteredq->where('companies.id', $request->company);
        //     $query = $query->where('companies.id', $request->company);
        // }
        if (!empty($request->startDate) && !empty($request->endDate)) {
            $startDate = date($request->startDate);
            $endDate = date($request->endDate);
            $total = $total->where(function ($q) use ($startDate, $endDate) {
                $q->whereBetween('candidate_applications.created_at', [$startDate, $endDate]);
                // ->orWhereBetween('candidate_applications.updated_at', [$startDate, $endDate]);
            });
            $filteredq = $filteredq->where(function ($q) use ($startDate, $endDate) {
                $q->whereBetween('candidate_applications.created_at', [$startDate, $endDate]);
                // ->orWhereBetween('candidate_applications.updated_at', [$startDate, $endDate]);
            });
            $query = $query->where(function ($q) use ($startDate, $endDate) {
                $q->whereBetween('candidate_applications.created_at', [$startDate, $endDate]);
                // ->orWhereBetween('candidate_applications.updated_at', [$startDate, $endDate]);
            });
        }

        $total = $total->first();
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
                $downloadLink = "Not Uploaded";
            }
            $menu = "";
            if (whoCanCheck(config('app.arrWhoCanCheck'), 'admin_assigned_job_submit')) {
                $menu .= ($value->status == 1) ? '<li class="nav-item">'
                    . '<a class="nav-link submit-candidate" data-id="' . $value->id . '">Submit Candidate</a>'
                    . '</li>' : '';
            }
            // $action = '<div class="d-inline-block dropdown">'
            // .'<button type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" class="btn-shadow dropdown-toggle btn btn-primary">'
            // .'<span class="btn-icon-wrapper pr-2 opacity-7">'
            // .'<i class="fa fa-cog fa-w-20"></i>'
            // .'</span>'
            // .'</button>'
            // .'<div tabindex="-1" role="menu" aria-hidden="true" class="dropdown-menu dropdown-menu-right">'
            // .'<ul class="nav flex-column">'
            // .$submit
            // .'</ul>'
            // .'</div>'
            // .'</div>';
            if (whoCanCheck(config('app.arrWhoCanCheck'), 'admin_assigned_job_view')) {
                $menu .= '<li class="nav-item">'
                    . '<a class="nav-link view-job" data-job-id="' . $value->company_job_id . '">View</a>'
                    . '</li>';
            }
            $action = view('admin.components.config-menu', compact('menu'))->render();
            $updatedAt = (!isset($value->updated_at)) ? "N/A" : getFormatedDate($value->updated_at);
            // $createdAt = (!isset($value->created_at))? "N/A":getFormatedDate($value->end_date);
            $data[] = [$value->id, $action, $value->first_name . ' ' . $value->last_name, $value->jobTitle, $value->companyName, $downloadLink, $value->status, $value->rejection_reason, getFormatedDate($value->created_at), $updatedAt];
        }
        $json_data = array(
            "draw" => intval($_REQUEST['draw']),
            "recordsTotal" => intval($total->total),
            "recordsFiltered" => intval($totalfiltered),
            "data" => $data,
        );
        return Response::json($json_data);
    }

    public function submitCandidateStart(Request $request)
    {
        $input = $request->all();
        $data = AssignedJob::find($input['id']);
        if ($data) {
            Session::forget('specialCandSub');
            Session::put('specialCandSub.candidate_application.id', $data->id);
            return redirect()->route('getCandidateSubmit');
        }
    }

    public function candidateSubmitUniqueEmail(Request $request)
    {
        $input = $request->all();
        $email = $input['email'];
        $candidateAppId = Session::get('specialCandSub.candidate_application.id');
        $return = true;
        $companyJobId = AssignedJob::getAttrById($candidateAppId, 'company_job_id');
        // pre($companyJobId);
        $companyAppliedJob = CompanyJobApplication::leftjoin('candidates', 'company_job_applications.candidate_id', 'candidates.id')
            ->where('company_job_applications.applied_type', '2')->where('company_job_id', $companyJobId)->where('candidates.email', $email)->whereNull('candidates.deleted_at')->first();
        if (empty($companyAppliedJob)) {
            $companyAppliedJob = CompanyJobApplication::leftjoin('recruiter_candidates', 'company_job_applications.candidate_id', 'recruiter_candidates.id')
                ->where('company_job_applications.applied_type', '1')->where('company_job_id', $companyJobId)->where('recruiter_candidates.email', $email)->whereNull('recruiter_candidates.deleted_at')->first();
            if (empty($companyAppliedJob)) {
                $return = true;
            } else {
                $return = false;
            }
        } else {
            $return = false;
            if (Session::has('specialCandSub.candidate')) {
                $candidate = Session::get('specialCandSub.candidate');
                if ($companyAppliedJob->id == $candidate) {
                    $return = true;
                }
            }
        }
        $json_data = array(
            "data" => $return,
        );
        return Response::json($json_data);
    }

    public function getCandidateSubmit()
    {
        $candidateAppId = Session::get('specialCandSub.candidate_application.id');
        if ($candidateAppId) {
            $assignedJob = AssignedJob::find($candidateAppId);
            // pre($assignedJob);
            $model = Candidate::find($assignedJob->candidate_id);
            $modelCv = CandidateResume::getLatestResumeNew($assignedJob->candidate_id);
            $countries = Country::getListForDropdown();
            $year['start'] = date('Y') - 100;
            $year['end'] = date('Y');
            $month = [1 => 'Jan', 2 => 'Feb', 3 => 'Mar', 4 => 'Apr', 5 => 'May', 6 => 'Jun', 7 => 'Jul', 8 => 'Aug', 9 => 'Sep', 10 => 'Oct', 11 => 'Nov', 12 => 'Dec'];
            $candidateExp = [];
            if (Session::has('specialCandSub.candidate_exp')) {
                $candidateExp = Session::get('specialCandSub.candidate_exp');
            }
            // pre($candidateExp);
            return view('admin.candidate-submit.step-one', compact('assignedJob', 'model', 'modelCv', 'countries', 'year', 'month', 'candidateExp'));
        }
        return abort(404);
    }

    public function postCandidateSubmit(Request $request)
    {
        $candidateAppId = Session::get('specialCandSub.candidate_application.id');
        $input = $request->all();
        if (!empty($input['_phoneCode'])) {
            $input['candidate']['phone_ext'] = $input['_phoneCode'];
            unset($input['_candidate']);
        }
        // pre($input);
        $fileObject = $request->file('candidate_cv.cv');
        // pre($fileObject);
        $companyJobId = AssignedJob::getAttrById($candidateAppId, 'company_job_id');
        if ($companyJobId) {
            $candidate = $input['candidate'];
            // $candidate_cv = $input['candidate_cv'];
            $candidate_exp = $input['candidate_exp'];
            Session::put('specialCandSub.candidate_exp', $candidate_exp);
            if (!empty($candidate['id'])) {
                $candidateUpdated = Candidate::editData($candidate['id'], $candidate);
                $candidateId = $candidateUpdated['data'];
                Session::put('specialCandSub.candidate', $candidateId);
            } else {
                $candidateUpdated = Candidate::addData($candidate);
                $candidateId = $candidateUpdated['data'];
                Session::put('specialCandSub.candidate', $candidateId);
            }
            if ($candidateId && $request->hasFile('candidate_cv.cv')) {
                $fileObject = $request->file('candidate_cv.cv');
                // pre($fileObject);
                $cvId = CandidateResume::uploadResume($candidateId, $fileObject);
                Session::put('specialCandSub.candidate_cv', $cvId);
            }
            // return view('frontend.recruiter.job-application.candidate-submit');
            $notification = array(
                'message' => config('message.frontendMessages.jobPostApply.candidateSubmit'),
                'alert-type' => 'success'
            );

            return redirect()->route('getJobQuestionnaire')->with($notification);
        }

        return abort(404);
    }

    public function getJobQuestionnaire()
    {
        $candidateAppId = Session::get('specialCandSub.candidate_application.id');
        if ($candidateAppId) {
            $companyJobId = AssignedJob::getAttrById($candidateAppId, 'company_job_id');
            if ($companyJobId) {
                $companyJob = CompanyJob::find($companyJobId);
                $templateId = $companyJob->job_questionnaire_template_id;
                // pre($templateId);
                $extraQuestions = $templateQuestions = [];
                // pre($companyJobId);
                $selectedQuesions = CompanyJobQuestionnaires::where('company_questionnaire_id', '!=', '0')->where('company_job_id', $companyJobId)->pluck('company_questionnaire_id')->toArray();
                $extraQuestions = CompanyJobQuestionnaires::where('company_questionnaire_id', '0')->where('company_job_id', $companyJobId)->get();
                if ($selectedQuesions) {
                    $templateQuestions = CompanyQuestionnaires::whereIn('id', $selectedQuesions)->where('cqt_id', $templateId)->get();
                }
                $types = CompanyQuestionnaireType::getData();
                $questionnaire = [];
                if (Session::has('specialCandSub.questionnaire')) {
                    $questionnaire = Session::get('specialCandSub.questionnaire');
                }
                // pre($templateQuestions);
                return view('admin.candidate-submit.step-two', compact('extraQuestions', 'templateQuestions', 'types', 'questionnaire', 'companyJob'));
            }
        }
    }

    public function postJobQuestionnaire(Request $request)
    {
        $input = $request->all();
        // pre($input);
        $candidateAppId = Session::get('specialCandSub.candidate_application.id');
        if ($candidateAppId) {
            $companyJobId = AssignedJob::getAttrById($candidateAppId, 'company_job_id');
            // pre($companyJobId);
            if ($companyJobId) {
                if (!empty($input['templateQuestions'])) {
                    $templateQuestions = $input['templateQuestions'];
                    foreach ($templateQuestions as $key => $value) {
                        if ($request->hasFile('templateQuestions.' . $key)) {
                            $fileObject = $request->file('templateQuestions.' . $key);
                            $fileUrl = CompanyJobApplicationQuestionnaire::uploadFile($fileObject);
                            $templateQuestions[$key] = $fileUrl;
                        }
                    }
                    Session::put('specialCandSub.questionnaire.templateQuestions', $templateQuestions);
                }
                if (!empty($input['extraQuestions'])) {
                    $extraQuestions = $input['extraQuestions'];
                    foreach ($extraQuestions as $key => $value) {
                        if ($request->hasFile('extraQuestions.' . $key)) {
                            $fileObject = $request->file('extraQuestions.' . $key);
                            $fileUrl = CompanyJobApplicationQuestionnaire::uploadFile($fileObject);
                            $extraQuestions[$key] = $fileUrl;
                        }
                    }
                    Session::put('specialCandSub.questionnaire.extraQuestions', $extraQuestions);
                }
                $notification = array(
                    'message' => config('message.frontendMessages.jobPostApply.candidateSubmitQuestionnaire'),
                    'alert-type' => 'success'
                );
                return redirect()->route('getCandidateSubmitReview')->with($notification);
            }
        }
        return abort(404);
    }

    public function getCandidateSubmitReview()
    {
        $candidateAppId = Session::get('specialCandSub.candidate_application.id');
        if ($candidateAppId) {
            $companyJobId = AssignedJob::getAttrById($candidateAppId, 'company_job_id');
            if ($companyJobId) {
                if (Session::has('specialCandSub.candidate') && Session::has('specialCandSub.questionnaire') && Session::has('specialCandSub.candidate_exp')) {
                    $recCandSub = Session::get('specialCandSub');
                    // pre($recCandSub);
                    $candidate = Session::get('specialCandSub.candidate');
                    $questionnaire = Session::get('specialCandSub.questionnaire');
                    $candidate_exp = Session::get('specialCandSub.candidate_exp');

                    $modelCv = CandidateResume::getLatestResumeNew($candidate);
                    $model = Candidate::find($candidate);
                    // pre($model);

                    $templateId = CompanyJob::getAttrById($companyJobId, 'job_questionnaire_template_id');
                    // pre($templateId);
                    // $companyJob = CompanyJob::find($companyJobId);
                    // $templateId = $companyJob->job_questionnaire_template_id;
                    $extraQuestions = $templateQuestions = [];
                    // pre($templateId);
                    $selectedQuesions = CompanyJobQuestionnaires::where('company_questionnaire_id', '!=', '0')->where('company_job_id', $companyJobId)->pluck('company_questionnaire_id')->toArray();
                    $extraQuestions = CompanyJobQuestionnaires::where('company_questionnaire_id', '0')->where('company_job_id', $companyJobId)->get();
                    if ($selectedQuesions) {
                        $templateQuestions = CompanyQuestionnaires::whereIn('id', $selectedQuesions)->where('cqt_id', $templateId)->get();
                    }
                    $types = CompanyQuestionnaireType::getData();
                    $questionnaire = [];
                    if (Session::has('specialCandSub.questionnaire')) {
                        $questionnaire = Session::get('specialCandSub.questionnaire');
                    }
                    $companyJob = CompanyJob::find($companyJobId);
                    // pre($selectedQuesions);
                    // return view('admin.candidate-submit.step-two', compact('extraQuestions', 'templateQuestions', 'types', 'questionnaire', 'companyJob'));
                    return view('admin.candidate-submit.step-three', compact('modelCv', 'model', 'questionnaire', 'templateQuestions', 'extraQuestions', 'types', 'companyJob'));
                }
            }
        }
        return abort(404);
    }

    public function postCandidateSubmitReview(Request $request)
    {
        $input = $request->all();
        // pre($input);
        $candidateAppId = Session::get('specialCandSub.candidate_application.id');
        if ($candidateAppId) {
            $companyJobId = AssignedJob::getAttrById($candidateAppId, 'company_job_id');
            if ($companyJobId) {
                $authId = (Auth::guard('admin')->check()) ? Auth::guard('admin')->user()->id : Auth::guard('users')->user()->id;
                if (Session::has('specialCandSub.candidate') && Session::has('specialCandSub.questionnaire') && Session::has('specialCandSub.candidate_exp')) {
                    $recCandSub = Session::get('specialCandSub');
                    $candidate = $recCandSub['candidate'];
                    $candidate_exp = $recCandSub['candidate_exp'];
                    if ($candidate_exp) {
                        foreach ($candidate_exp as $key => $value) {
                            $value['candidate_id'] = $candidate;
                            $value['company_job_id'] = $companyJobId;
                            $value['is_current_working'] = isset($value['is_current_working']) ? $value['is_current_working'] : '0';
                            $insert = CandidateExperience::addData($candidate, $value);
                        }
                    }
                    // pre($insert);
                    $latestExp = CandidateExperience::latestExperience($candidate);
                    // pre($latestExp);
                    $companyJob = CompanyJob::find($companyJobId);
                    if ($companyJob) {
                        $companyJobApp = new CompanyJobApplication();
                        $companyJobApp->company_id = $companyJob->company_id;
                        $companyJobApp->company_job_id = $companyJobId;
                        $companyJobApp->applied_type = 2;
                        $companyJobApp->related_id = $authId;
                        $companyJobApp->candidate_id = $candidate;
                        $companyJobApp->latest_exp_end_year = $latestExp['end_year'];
                        $companyJobApp->latest_exp_end_month = $latestExp['end_month'];
                        $companyJobApp->is_current_working = $latestExp['is_current_working'];
                        $companyJobApp->job_questionnaire_template_id = $companyJob->job_questionnaire_template_id;
                        $companyJobApp->status = 1;
                        $companyJobApp->save();
                        // questionnaire insert
                        if (!empty($recCandSub['questionnaire']['templateQuestions'])) {
                            $templateQuestions = $recCandSub['questionnaire']['templateQuestions'];
                            foreach ($templateQuestions as $key => $value) {
                                $comJobQue = CompanyJobQuestionnaires::where('company_questionnaire_id', $key)->where('company_job_id', $companyJobId)->first();
                                if ($comJobQue) {
                                    $insert = new CompanyJobApplicationQuestionnaire();
                                    $insert->company_job_id = $companyJobId;
                                    $insert->company_job_application_id = $companyJobApp->id;
                                    $insert->company_questionnaire_id = $key;
                                    $insert->question = $comJobQue->question;
                                    $insert->question_type = $comJobQue->question_type;
                                    $insert->options_JSON = $comJobQue->options_JSON;
                                    $insert->answer = (gettype($value) == 'array') ? implode(',', $value) : $value;
                                    // $insert->answer = $value;
                                    $insert->save();
                                }
                            }
                            Session::put('specialCandSub.questionnaire.templateQuestions', $templateQuestions);
                        }
                        if (!empty($recCandSub['questionnaire']['extraQuestions'])) {
                            $extraQuestions = $recCandSub['questionnaire']['extraQuestions'];
                            foreach ($extraQuestions as $key => $value) {
                                $comJobQue = CompanyJobQuestionnaires::find($key);
                                if ($comJobQue) {
                                    $insert = new CompanyJobApplicationQuestionnaire();
                                    $insert->company_job_id = $companyJobId;
                                    $insert->company_job_application_id = $companyJobApp->id;
                                    $insert->company_questionnaire_id = 0;
                                    $insert->question = $comJobQue->question;
                                    $insert->question_type = $comJobQue->question_type;
                                    $insert->options_JSON = $comJobQue->options_JSON;
                                    $insert->answer = (gettype($value) == 'array') ? implode(',', $value) : $value;
                                    // $insert->answer = $value;
                                    $insert->save();
                                }
                            }
                            Session::put('specialCandSub.questionnaire.extraQuestions', $extraQuestions);
                        }

                        $msg = getResponseMessage(config('message.NotificationMsg.jobpostaddedByCandidateSpecialist'), $companyJob->title);
                        $msgCandidate = getResponseMessage(config('message.NotificationMsg.jobpostaddedCandidate'), $companyJob->title);
                        $data = [
                            'related_id' => $companyJob->company_id,
                            'type' => 1,
                            'notification_code' => 'JOBSUB',
                            'message_type' => 'Candidate Submittal',
                            'message' => $msg,
                            'status' => 1,
                        ];
                        $dataCandidate = [
                            'related_id' => $candidate,
                            'type' => 3,
                            'notification_code' => 'JOBSUB',
                            'message_type' => 'Candidate Submittal',
                            'message' => $msgCandidate,
                            'status' => 1,
                        ];
                        Notifications::addNotification($data);
                        Notifications::addNotification($dataCandidate);
                    }
                }
                // pre('submitted');
                return redirect()->route('getCandidateSubmitSuccess');
            }
        }
        return abort(404);
    }

    public function getCandidateSubmitSuccess()
    {
        $candidateAppId = Session::get('specialCandSub.candidate_application.id');
        if ($candidateAppId) {
            $companyJobId = AssignedJob::getAttrById($candidateAppId, 'company_job_id');
            if ($companyJobId) {
                $assignedJob = AssignedJob::find($candidateAppId);
                if ($assignedJob) {
                    $assignedJob->status = 2;
                    $assignedJob->save();
                }
                Session::forget('specialCandSub');
                // return view('admin.candidate-submit.step-four');
            }
            // return abort(404);
        }
        // return abort(404);
        return view('admin.candidate-submit.step-four');
    }
}
