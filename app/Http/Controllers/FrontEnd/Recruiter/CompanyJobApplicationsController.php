<?php

namespace App\Http\Controllers\FrontEnd\Recruiter;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\CompanyJob;
use App\Models\CompanyJobApplication;
use App\Models\CompanyJobApplicationQuestionnaire;
use App\Models\CompanyJobQuestionnaires;
use App\Models\CompanyQuestionnaires;
use App\Models\CompanyQuestionnaireType;
use App\Models\Country;
use App\Models\Notifications;
use App\Models\RecruiterCandidate;
use App\Models\RecruiterCandidateExperience;
use App\Models\RecruiterCandidateResume;
use App\Models\User;
use Exception;
use Auth;
use Response;
use Mail;
use Illuminate\Support\Facades\Session;
use Illuminate\Routing\Route;
use Illuminate\Support\Facades\URL;

class CompanyJobApplicationsController extends Controller{

    public function index($slug){
        $companyJob = CompanyJob::where('slug',$slug)->first();
        if ($companyJob) {
            // pre($companyJob->id);
            Session::put('RecCandSub.company_job_id', $companyJob->id);
            return redirect()->route('recruiterCandidateSubmit');
        }
        return abort(404);
    }

    public function candidateSearch(Request $request)
    {
        $input = $request->all();
        // pre($input);
        $query = $input['query'];
        $return = [];
        $authId = User::getLoggedInId();
        $data = RecruiterCandidate::where('recruiter_id', $authId)->where('name','like','%'. $query.'%')->get();
        if ($data) {
            foreach ($data as $key => $value) {
                $return[] = ['value' => $value->id, 'label' => $value->name, 'desc' => $value->email];
            }
        }
        return Response::json($return);
    }

    public function candidateSubmitUniqueEmail(Request $request)
    {
        $input = $request->all();
        $email = $input['email'];
        $companyJobId = Session::get('RecCandSub.company_job_id');
        $return = true;
        // pre($companyJobId);
        $companyAppliedJob = CompanyJobApplication::leftjoin('recruiter_candidates','company_job_applications.candidate_id', 'recruiter_candidates.id')
                ->where('company_job_applications.applied_type', '1')->where('company_job_id', $companyJobId)->where('recruiter_candidates.email', $email)->whereNull('recruiter_candidates.deleted_at')->first();
        if (empty($companyAppliedJob)) {
            $companyAppliedJob = CompanyJobApplication::leftjoin('candidates','company_job_applications.candidate_id', 'candidates.id')
                ->where('company_job_applications.applied_type', '2')->where('company_job_id', $companyJobId)->where('candidates.email', $email)->whereNull('candidates.deleted_at')->first();
            if (empty($companyAppliedJob)) {
                $return = true;
            }else{
                $return = false;
            }
        }else{
            $return = false;
            if (Session::has('RecCandSub.candidate')) {
                $candidate = Session::get('RecCandSub.candidate');
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

    public function candidateSubmit($candidate="")
    {
        $companyJobId = Session::get('RecCandSub.company_job_id');
        if ($companyJobId) {
            if (Session::has('RecCandSub.candidate')) {
                $candidate = Session::get('RecCandSub.candidate');
            }
            // Recruiter Candidate view
            $modelCv = [];
            if ($candidate) {
                $modelCv = RecruiterCandidateResume::getLatestResume($candidate);
                $model = RecruiterCandidate::find($candidate);
            }else{
                $model = new RecruiterCandidate;
            }
            $countries = Country::getListForDropdown();
            $year['start'] = date('Y')-100;
            $year['end'] = date('Y');
            $month = [1 =>'Jan', 2 => 'Feb', 3 => 'Mar', 4 => 'Apr', 5 => 'May', 6 => 'Jun', 7 => 'Jul', 8 =>'Aug', 9 => 'Sep', 10 => 'Oct', 11 => 'Nov', 12 => 'Dec'];
            $candidateExp = [];
            if (Session::has('RecCandSub.candidate_exp')) {
                $candidateExp = Session::get('RecCandSub.candidate_exp');
            }
            $companyJob = CompanyJob::find($companyJobId);
            return view('frontend.recruiter.job-application.candidate-submit',compact('model', 'countries', 'year', 'month', 'candidateExp', 'modelCv', 'companyJob'));
        }
        return abort(404);
    }

    public function postCandidateSubmit(Request $request)
    {
        $input = $request->all();
        if (!empty($input['_candidate']['phone_ext'])) {
            $input['candidate']['phone_ext'] = $input['_candidate']['phone_ext'];
            unset($input['_candidate']);
        }
        $fileObject = $request->file('candidate_cv.cv');
        // pre($fileObject);
        $companyJobId = Session::get('RecCandSub.company_job_id');
        // pre($companyJobId);
        if ($companyJobId) {
            $candidate = $input['candidate'];
            // $candidate_cv = $input['candidate_cv'];
            $candidate_exp = $input['candidate_exp'];
            Session::put('RecCandSub.candidate_exp', $candidate_exp);
            if (!empty($candidate['id'])) {
                if(!isset($input['candidate']['is_diverse_candidate']))
                $candidate['is_diverse_candidate']=0;
                $candidateUpdated = RecruiterCandidate::editData($candidate['id'], $candidate);
                $candidateId = $candidateUpdated['data'];
                Session::put('RecCandSub.candidate', $candidateId);
            }else{
                $candidateUpdated = RecruiterCandidate::addData($candidate);
                $candidateId = $candidateUpdated['data'];
                Session::put('RecCandSub.candidate', $candidateId);
            }
            if ($candidateId && $request->hasFile('candidate_cv.cv')) {
                $fileObject = $request->file('candidate_cv.cv');
                // pre($fileObject);
                $cvId = RecruiterCandidateResume::uploadResume($candidateId, $fileObject);
                // pre('asd');
                Session::put('RecCandSub.candidate_cv', $cvId);
            }
            // return view('frontend.recruiter.job-application.candidate-submit');
            $notification = array(
                'message' => config('message.frontendMessages.jobPostApply.candidateSubmit'),
                'alert-type' => 'success'
            );
            return redirect()->route('recruiterCandidateQuestionnaire')->with($notification);
        }

        return abort(404);
    }

    public function candidateQuestionnaire()
    {
        $companyJobId = Session::get('RecCandSub.company_job_id');
        if ($companyJobId) {
            $templateId = CompanyJob::getAttrById($companyJobId, 'job_questionnaire_template_id');
            $extraQuestions = $templateQuestions = [];
            // pre($templateId);
            $selectedQuesions = CompanyJobQuestionnaires::where('company_questionnaire_id','!=','0')->where('company_job_id', $companyJobId)->pluck('company_questionnaire_id')->toArray();
            $extraQuestions = CompanyJobQuestionnaires::where('company_questionnaire_id','0')->where('company_job_id', $companyJobId)->get();
            if ($selectedQuesions) {
                $templateQuestions = CompanyQuestionnaires::whereIn('id', $selectedQuesions)->where('cqt_id', $templateId)->get();
            }
            $types = CompanyQuestionnaireType::getData();
            $questionnaire = [];
            if (Session::has('RecCandSub.questionnaire')) {
                $questionnaire = Session::get('RecCandSub.questionnaire');
            }
            // pre($questionnaire);
            $companyJob = CompanyJob::find($companyJobId);
            // pre($companyJob);
            return view('frontend.recruiter.job-application.candidate-questionnaire',compact('extraQuestions', 'templateQuestions', 'types', 'questionnaire', 'companyJob'));
        }
    }

    public function postCandidateQuestionnaire(Request $request)
    {
        $input = $request->all();
        $companyJobId = Session::get('RecCandSub.company_job_id');
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
                Session::put('RecCandSub.questionnaire.templateQuestions', $templateQuestions);
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
                Session::put('RecCandSub.questionnaire.extraQuestions', $extraQuestions);
            }
            $notification = array(
                'message' => config('message.frontendMessages.jobPostApply.candidateSubmitQuestionnaire'),
                'alert-type' => 'success'
            );
            return redirect()->route('recruiterCandidateSubmitReview')->with($notification);
        }
        return abort(404);
    }
    
    public function candidateSubmitReview()
    {
        $companyJobId = Session::get('RecCandSub.company_job_id');
        if ($companyJobId) {
            //if (Session::has('RecCandSub.candidate') && Session::has('RecCandSub.questionnaire') && Session::has('RecCandSub.candidate_exp')) {
                $recCandSub = Session::get('RecCandSub');
                $candidate = Session::get('RecCandSub.candidate');
                $questionnaire = Session::get('RecCandSub.questionnaire');
                $candidate_exp = Session::get('RecCandSub.candidate_exp');
                
                $modelCv = RecruiterCandidateResume::getLatestResume($candidate);
                $model = RecruiterCandidate::find($candidate);
                // pre($model);

                $templateId = CompanyJob::getAttrById($companyJobId, 'job_questionnaire_template_id');
                $extraQuestions = $templateQuestions = [];
                // pre($templateId);
                $selectedQuesions = CompanyJobQuestionnaires::where('company_questionnaire_id', '!=', '0')->where('company_job_id', $companyJobId)->pluck('company_questionnaire_id')->toArray();
                $extraQuestions = CompanyJobQuestionnaires::where('company_questionnaire_id', '0')->where('company_job_id', $companyJobId)->get();
                if ($selectedQuesions) {
                    $templateQuestions = CompanyQuestionnaires::whereIn('id', $selectedQuesions)->where('cqt_id', $templateId)->get();
                }
                $types = CompanyQuestionnaireType::getData();
                $questionnaire = [];
                if (Session::has('RecCandSub.questionnaire')) {
                    $questionnaire = Session::get('RecCandSub.questionnaire');
                }
                $companyJob = CompanyJob::find($companyJobId);
                return view('frontend.recruiter.job-application.candidate-review',compact('modelCv', 'model', 'questionnaire', 'templateQuestions', 'extraQuestions', 'types', 'companyJob'));
            //}
        }
        return abort(404);
    }

    public function postCandidateSubmitReview(Request $request)
    {
        $input = $request->all();
        $companyJobId = Session::get('RecCandSub.company_job_id');
        if ($companyJobId) {
            $authId = User::getLoggedInId();
            //if (Session::has('RecCandSub.candidate') && Session::has('RecCandSub.questionnaire') && Session::has('RecCandSub.candidate_exp')) {
                $recCandSub = Session::get('RecCandSub');
                $candidate = $recCandSub['candidate'];
                $candidate_exp = $recCandSub['candidate_exp'];
                if ($candidate_exp) {
                    foreach ($candidate_exp as $key => $value) {
                        $value['candidate_id'] = $candidate;
                        $value['company_job_id'] = $companyJobId;
                        $value['is_current_working'] = isset($value['is_current_working'])? $value['is_current_working']:'0';
                        $insert = RecruiterCandidateExperience::addData($candidate, $value);
                    }
                }
                $latestExp = RecruiterCandidateExperience::latestExperience($candidate);
                // pre($latestExp);
                $companyJob = CompanyJob::find($companyJobId);
                if ($companyJob) {
                    $recuriterId = Auth::user()->recruiter->id;
                    $companyJobApp = new CompanyJobApplication();
                    $companyJobApp->company_id = $companyJob->company_id;
                    $companyJobApp->company_job_id = $companyJobId;
                    $companyJobApp->applied_type = 1;
                    $companyJobApp->related_id = $recuriterId;
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
                                $insert->answer = (gettype($value) == 'array') ? implode(',',$value) : $value;
                                $insert->save();
                            }
                        }
                        Session::put('RecCandSub.questionnaire.templateQuestions', $templateQuestions);
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
                                $insert->answer = (gettype($value) == 'array') ? implode(',',$value) : $value;
                                $insert->save();
                            }
                        }
                        Session::put('RecCandSub.questionnaire.extraQuestions', $extraQuestions);
                    }

                    $msg = getResponseMessage(config('message.NotificationMsg.jobpostadded'), $companyJob->title);
                    $data=[
                        'related_id'=> $companyJob->company_id,
                        'type'=>1,
                        'notification_code'=> 'JOBSUB',
                        'message_type'=> 'Candidate Submittal',
                        'message'=> $msg,
                        'status'=>1,
                    ];
                    Notifications::addNotification($data);
                }
            //}            
            return redirect()->route('recruiterCandidateSubmitSuccess');
        }
        return abort(404);
    }
    
    public function candidateSubmitSuccess()
    {
        $companyJobId = Session::get('RecCandSub.company_job_id');
        if ($companyJobId) {
            $slug = CompanyJob::getAttrById($companyJobId, 'slug');
            Session::forget('RecCandSub');
            return view('frontend.recruiter.job-application.submit-success',compact('slug'));
        }
        return abort(404);
    }
}