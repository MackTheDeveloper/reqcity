<?php

namespace App\Http\Controllers\FrontEnd\Company;

use App\Http\Controllers\Controller;
use App\Models\AdminCommission;
use App\Models\Candidate;
use App\Models\CandidateApplications;
use App\Models\CandidateExperience;
use App\Models\CandidateResume;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Illuminate\Support\Arr;
use App\Models\User;
use App\Models\Companies;
use App\Models\CompanyAddress;
use App\Models\CompanyJob;
use App\Models\CompanyUser;
use App\Models\RecruiterCandidate;
use App\Models\CompanyJobApplication;
use App\Models\CompanyJobApplicationQuestionnaire;
use App\Models\Country;
use App\Models\EmailTemplates;
use App\Models\GlobalSettings;
use App\Models\RecruiterCandidateExperience;
use App\Models\RecruiterCandidateResume;
use Exception;
use Auth;
use Carbon\Carbon;
use Response;
use Mail;
use Illuminate\Support\Facades\Session;
use Illuminate\Routing\Route;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Facades\Artisan;
use DB;

class CompanyCandidateController extends Controller
{

    public function index(Request $request)
    {
        $companyId = Auth::user()->companyUser->company_id;
        $jobs = CompanyJob::getCompanyJobList($companyId);
        try {
            return view('frontend.company.candidate.index', compact('jobs'));
        } catch (Exception $e) {
            return redirect()->route('showDashboard');
        }
    }




    public function list(Request $request)
    {
        //$companyId = Auth::user()->companyUser->company_id;
        //$companyId = Auth::user()->company->id;
        $companyId = CompanyUser::getCompanyIdByUserId(Auth::user()->id);
        $userId = Auth::user()->id;
        $req = $request->all();
        $page = !empty($req['page']) ? $req['page'] : 1;
        if ($page) {
            $length = \Config::get('app.dataTable')['length'];
            $start = ($page - 1) * $length;
        }
        $search = ""; //$req['search']['value'];
        $jobId = $req['jobId'];
        $posted = $req['posted'];
        $search = $req['search'];
        $status = $req['status'];
        // $order = $req['order'][0]['dir'];
        // $column = $req['order'][0]['column'];
        // $orderby = ['id','','first_name','email','phone','job_title','country','state','city','postcode','','status','created_at'];

        // dd($recruiterCandidateData);
        $total = CompanyJobApplication::selectRaw('count(*) as total')->where('company_id', '=', $companyId)
            ->where('company_job_id', '=', $jobId)
            ->first();

        $query = CompanyJobApplication::select('company_job_applications.*')
            ->leftJoin('candidates', function ($join) {
                $join->on('candidates.id', '=', 'company_job_applications.candidate_id');
                $join->on('company_job_applications.applied_type', '=', DB::raw('2'));
            })->leftJoin('recruiter_candidates', function ($join) {
                $join->on('recruiter_candidates.id', '=', 'company_job_applications.candidate_id');
                $join->on('company_job_applications.applied_type', '=', DB::raw('1'));
            })
            ->where('company_id', $companyId)
            ->where('company_job_id', '=', $jobId)
            ->whereNull('recruiter_candidates.deleted_at')
            ->whereNull('candidates.deleted_at');

        $filteredq = CompanyJobApplication::leftJoin('candidates', function ($join) {
            $join->on('candidates.id', '=', 'company_job_applications.candidate_id');
            $join->on('company_job_applications.applied_type', '=', DB::raw('2'));
        })->leftJoin('recruiter_candidates', function ($join) {
            $join->on('recruiter_candidates.id', '=', 'company_job_applications.candidate_id');
            $join->on('company_job_applications.applied_type', '=', DB::raw('1'));
        })
            ->where('company_id', $companyId)
            ->where('company_job_id', '=', $jobId)
            ->whereNull('recruiter_candidates.deleted_at')
            ->whereNull('candidates.deleted_at');

        if ($search) {
            $query->where(function ($q1) use ($search) {
                $q1->where(function ($q2) use ($search) {
                    $q2->where('recruiter_candidates.name', 'like', '%' . $search . '%')
                        ->where('company_job_applications.applied_type', '1')
                        ->where('company_job_applications.status', '3');
                })->orWhere(function ($q2) use ($search) {
                    $q2->where('candidates.first_name', 'like', '%' . $search . '%')
                        ->orWhere('candidates.last_name', 'like', '%' . $search . '%')
                        ->where('company_job_applications.applied_type', '2')
                        ->where('company_job_applications.status', '3');
                });
            });

            $filteredq->where(function ($q1) use ($search) {
                $q1->where(function ($q2) use ($search) {
                    $q2->where('recruiter_candidates.name', 'like', '%' . $search . '%')
                        ->where('company_job_applications.applied_type', '1')
                        ->where('company_job_applications.status', '3');
                })->orWhere(function ($q2) use ($search) {
                    $q2->where('candidates.first_name', 'like', '%' . $search . '%')
                        ->orWhere('candidates.last_name', 'like', '%' . $search . '%')
                        ->where('company_job_applications.applied_type', '2')
                        ->where('company_job_applications.status', '3');
                });
            });
        }
        if ($status && $status != "") {
            if ($status != 1) {
                $query->where('company_job_applications.status', $status);
                $filteredq->where('company_job_applications.status', $status);
            } else {
                $query->whereIn('company_job_applications.status', [1, 2]);
                $filteredq->whereIn('company_job_applications.status', [1, 2]);
            }
        }


        if ($posted == "recently") {
            $query->orderBy('company_job_applications.is_current_working', 'ASC');
            $query->orderBy('company_job_applications.status', 'ASC');
            $query->orderBy('latest_exp_end_year', 'DESC');
        } else {
            $query->orderBy('company_job_applications.is_current_working', 'DESC');
            $query->orderBy('company_job_applications.status', 'ASC');
            $query->orderBy('latest_exp_end_year', 'ASC');
        }

        $totalfiltered = $total->total;


        // if (!empty($request->startDate) && !empty($request->endDate)) {
        //     $startDate = $request->startDate;
        //     $endDate = $request->endDate;
        //     $filteredq = $filteredq->where(function ($q) use ($startDate, $endDate) {
        //         $q->whereBetween('created_at', [$startDate, $endDate]);
        //     });
        //     $query = $query->where(function ($q) use ($startDate, $endDate) {
        //         $q->whereBetween('created_at', [$startDate, $endDate]);
        //     });
        //     $recordCount = $filteredq->selectRaw('count(*) as total')->first();

        //     $totalfiltered = $recordCount->total;
        // }
        //$query = $query->orderBy($orderby[$column], $order)->offset($start)->limit($length)->get();
        $query = $query->offset($start)->limit($length)->get();
        // dd($query);
        $data = [];
        foreach ($query as $key => $value) {
            $statusWord = "";
            if ($value->status == 3) {
                $statusWord = "Accepted";
            } else if ($value->status == 4) {
                $statusWord = "Rejected";
            } else {
                $statusWord = "Pending";
            }

            if ($value->applied_type == '1') {
                $recCandidate = RecruiterCandidate::where('id', $value->candidate_id)->first();
                $recCandExp = RecruiterCandidateExperience::where('candidate_id', $value->candidate_id)
                    ->where('company_job_id', $jobId)->orderBy('id', 'DESC')->first();
                $resume = RecruiterCandidateResume::getLatestResume($recCandidate->id);
                $resume = (isset($resume)) ? $resume->cv : "";
                $exp = "";
                $country = Country::getCountryName($recCandidate->country);
                $country = (isset($country)) ? $country : "";
                if ($recCandExp) {
                    if ($recCandExp->is_current_working) {
                        $exp = getMonth($recCandExp->start_month) . ' ' . $recCandExp->start_year . '-' . 'Present';
                    } else {
                        $exp = getMonth($recCandExp->start_month). ' ' . $recCandExp->start_year . '-' . getMonth($recCandExp->end_month) . ' ' . $recCandExp->end_year;
                    }
                }
                $id = $value->id;
                $linkedin = $recCandidate->linkedin_profile ?: "";
                $actionStatus = $value->status;
                $action = view('frontend.company.candidate.components.action', compact('id', 'linkedin', 'actionStatus'))->render();
                $name = "";
                $contactInfo = "";
                $experience = [];
                if (isset($recCandExp)) {
                    $experience = [
                        "title" => $recCandExp->job_title ?: "",
                        "company" => $recCandExp->company ?: "",
                        "exp" => $exp ?: "",
                        "start_month" => $recCandExp->start_month ?: "",
                        "start_year" => $recCandExp->start_year ?: "",
                        "end_month" => $recCandExp->end_month ?: "",
                        "end_year" => $recCandExp->end_year ?: "",
                        "current_working" => $recCandExp->is_current_working ? "Present" : "",
                    ];
                }
                if ($value->status == 3) {
                    $name = [
                        "name" => $recCandidate->name,
                        "state" => $country,
                        "city" => $recCandidate->city,
                        "diverse" => $recCandidate->is_diverse_candidate,
                    ];
                    $contactInfo =  [
                        "email" => $recCandidate->email,
                        "phone" => $recCandidate->phone_ext . '-' . $recCandidate->phone
                    ];
                } else {
                    $name = [
                        "name" => "",
                        "state" => $country,
                        "city" => $recCandidate->city,
                        "diverse" => $recCandidate->is_diverse_candidate,
                    ];
                    $contactInfo = [
                        "email" => "",
                        "phone" => "",
                    ];
                    $resume = "";
                    if ($value->status == 4) {
                        $experience = [
                            "title" => "Rejection Reason",
                            "reason" => $value->rejection_reason,
                        ];
                    }
                }
                $data[] = [
                    "name" => $name,
                    "status" => [
                        "status" => $statusWord,
                        "created_at" => "Applied " . getFormatedDate($recCandidate->created_at, 'd M')
                    ],
                    "experience" => $experience,
                    "contactInfo" => $contactInfo,
                    "resume" => [
                        "resume" => $resume
                    ],
                    "action" => [
                        "action" => $action
                    ],

                ];
            }
            if ($value->applied_type == '2') {
                $candidate = Candidate::where('id', $value->candidate_id)->first();
                $candExp = CandidateExperience::where('candidate_id', $value->candidate_id)
                    ->where('company_job_id', $jobId)->orderBy('id', 'DESC')->first();
                $exp = "";
                $resume = CandidateResume::getLatestResumeNew($candidate->id);
                $resume = (isset($resume)) ? $resume->resume : "";
                $country = Country::getCountryName($candidate->country);
                $country = (isset($country)) ? $country : "";
                if ($candExp) {
                    if ($candExp->is_current_working) {
                        $exp = getMonth($candExp->start_month) . ' ' . $candExp->start_year . '-' . 'Present';
                    } else {
                        $exp = getMonth($candExp->start_month) . ' ' . $candExp->start_year . '-' . getMonth($candExp->end_month) . ' ' . $candExp->end_year;
                    }
                }
                $id = $value->id;
                $linkedin = $candidate->linkedin_profile ?: "";
                $actionStatus = $value->status;
                $action = view('frontend.company.candidate.components.action', compact('id', 'linkedin', 'actionStatus'))->render();
                $name = "";
                $contactInfo = "";
                $experience = [];
                if ($candExp) {
                    $experience = [
                        "title" => $candExp->job_title ?: "",
                        "company" => $candExp->company ?: "",
                        "exp" => $exp ?: "",
                        "start_month" => $candExp->start_month ?: "",
                        "start_year" => $candExp->start_year ?: "",
                        "end_month" => $candExp->end_month ?: "",
                        "end_year" => $candExp->end_year ?: "",
                        "current_working" => $candExp->is_current_working ? "Present" : "",
                    ];
                }
                if ($value->status == 3) {
                    $name =  [
                        "name" => $candidate->first_name . ' ' . $candidate->last_name,
                        "state" => $country,
                        "city" => $candidate->city,
                    ];
                    $contactInfo = [
                        "email" => $candidate->email,
                        "phone" => $candidate->phone_ext . '-' . $candidate->phone
                    ];
                } else {
                    $name = [
                        "name" => "",
                        "state" => $country,
                        "city" => $candidate->city,
                        "diverse" => $candidate->is_diverse_candidate,
                    ];
                    $contactInfo = [
                        "email" => "",
                        "phone" => "",
                    ];
                    $resume = "";
                    if ($value->status == 4) {
                        $experience = [
                            "title" => "Rejection Reason",
                            "reason" => $value->rejection_reason,
                        ];
                    }
                }

                $data[] = [
                    "name" => $name,
                    "status" => [
                        "status" => $statusWord,
                        "created_at" => "Applied " . getFormatedDate($candidate->created_at, 'd M ')
                    ],
                    "experience" => $experience,
                    "contactInfo" => $contactInfo,
                    "resume" => [
                        "resume" => $resume,
                    ],
                    "action" => [
                        "action" => $action,
                    ]

                ];
            }
        }
        $json_data = array(
            "recordsTotal" => intval($total->total),
            "recordsFiltered" => intval($totalfiltered),
            "recordPerPage" => $length,
            "currentPage" => $page,
            "data" => $data,
        );
        return Response::json($json_data);
    }

    public function view(Request $request)
    {
        $jobApplication = CompanyJobApplication::where('id', $request->id)->first();
        $type = $jobApplication->applied_type;
        $jobId = $jobApplication->company_job_id;
        $candidate = "";
        $que = CompanyJobApplicationQuestionnaire::getQuestionAnsers($jobApplication->company_job_id, $jobApplication->id);
        try {
            if ($type == 2) {
                $candidate = Candidate::has('Country')->where('id', $jobApplication->candidate_id)->first();
                // $candidateExp = CandidateExperience::where('candidate_id', $jobApplication->candidate_id)->first();
                $candidateExp = CandidateExperience::where('candidate_id', $jobApplication->candidate_id)
                ->where('company_job_id', $jobId)->get();
                $candExpM = [];
                foreach($candidateExp as $key => $value){
                    $candExpM[$key]['jobTitle'] = $value->job_title;
                    $candExpM[$key]['company'] = $value->company;
                    $candExpM[$key]['expStart'] = getMonth($value->start_month) . ' ' . $value->start_year;
                    $candExpM[$key]['expEnd'] = ($value->is_current_working == 1) ? 'Present' : getMonth($value->end_month) . ' ' . $value->end_year;
                    $candExpM[$key]['responsibilities'] = ($value->job_responsibilities) ?: "";
                }
                $data['name'] = ($jobApplication->status == 3) ? $candidate->first_name . ' ' . $candidate->last_name : "";
                $data['email'] = ($jobApplication->status == 3) ? $candidate->email : "";
                $data['phone'] = ($jobApplication->status == 3) ? $candidate->phone_ext . '-' . $candidate->phone : "";
                $data['city'] = $candidate->city;
                $data['country'] = $candidate->Country->name;
                // $data['jobTitle'] = $candidateExp->job_title;
                // $data['company'] = $candidateExp->company;
                // $data['expStart'] = getMonth($candidateExp->start_month) . ' ' . $candidateExp->start_year;
                // $data['expEnd'] = ($candidateExp->is_current_working == 1) ? 'Present' : getMonth($candidateExp->end_month) . ' ' . $candidateExp->end_year;
                // $data['responsibilities'] = ($candidateExp->job_responsibilities) ?: "";
                $data['experience'] = $candExpM;
                $data['question'] = $que;
                return view('frontend.company.candidate.view', compact('data'));
            }
            if ($type == 1) {
                $rcandidate = RecruiterCandidate::has('Countrydata')->where('id', $jobApplication->candidate_id)->first();
                $rcandidateExp = RecruiterCandidateExperience::where('candidate_id', $jobApplication->candidate_id)
                                    ->where('company_job_id', $jobId)->get();
                $rcandExpM = [];
                foreach($rcandidateExp as $key => $value){
                    $rcandExpM[$key]['jobTitle'] = $value->job_title;
                    $rcandExpM[$key]['company'] = $value->company;
                    $rcandExpM[$key]['expStart'] = getMonth($value->start_month) . ' ' . $value->start_year;
                    $rcandExpM[$key]['expEnd'] = ($value->is_current_working == 1) ? 'Present' : getMonth($value->end_month) . ' ' . $value->end_year;
                    $rcandExpM[$key]['responsibilities'] = ($value->job_responsibilities) ?: "";
                }
                $data['name'] = ($jobApplication->status == 3) ? $rcandidate->name : "";
                $data['email'] = ($jobApplication->status == 3) ? $rcandidate->email : "";
                $data['phone'] = ($jobApplication->status == 3) ? $rcandidate->phone_ext . '-' . $rcandidate->phone : "";
                $data['city'] = $rcandidate->city;
                $data['country'] = ($rcandidate->Countrydata->name) ?: "-";
                // $data['jobTitle'] = $rcandidateExp->job_title;
                // $data['company'] = $rcandidateExp->company;
                // $data['expStart'] = getMonth($rcandidateExp->start_month) . ' ' . $rcandidateExp->start_year;
                // $data['expEnd'] = ($rcandidateExp->is_current_working == 1) ? 'Present' : getMonth($rcandidateExp->end_month) . ' ' . $rcandidateExp->end_year;
                // $data['responsibilities'] = ($rcandidateExp->job_responsibilities) ?: "";
                $data['experience'] = $rcandExpM;
                $data['question'] = $que;
                return view('frontend.company.candidate.view', compact('data'));
            }
        } catch (Exception $e) {
            $notification = array(
                'message' => config('message.error.wrong'),
                'alert-type' => 'success'
            );
            return redirect()->route('showCompanyCandidate')->with($notification);
        }
    }

    //Applied type 1 = recruiter type 2 = candidate
    public function reject(Request $request)
    {
        $id = $request->id;
        $reason = $request->reason;
        try {
            $companyJob = CompanyJobApplication::where('id', $id)->first();
            $type = $companyJob->applied_type;
            $companyJobId = $companyJob->company_job_id;
            $candidateId = $companyJob->candidate_id;
            $company = Companies::where('id', $companyJob->company_id)->first();
            $job = CompanyJob::where('id', $companyJobId)->first();
            // $candidateId = $companyJob->candidate_id;
            //type 1 = recruiter type 2 = candidate
            if ($companyJob->applied_type == 2) {
                // $candidateApplication = CandidateApplications::where('company_job_id', $companyJobId)
                //     ->where('candidate_id', $candidateId)->first();
                $candidateApplication = CandidateApplications::changeStatusReject($candidateId, $companyJobId, $reason);
                $candidate = Candidate::where('id', $candidateId)->first();
                $code = 'JOBCANREJ';
                $msg_type = 'Job Candidate Rejected';
                $msg = 'Your job application for ' . $job->title . ' of ' . $candidate->first_name . ' ' . $candidate->last_name . ' has been rejected by ' . $company->name . '.';
                $msgCandidate = 'Your job application for ' . $job->title . ' has been rejected by ' . $company->name . '.';
                $notification = insertNotification(2, $companyJob->related_id, $code, $msg_type, $msg);
                $notification = insertNotification(3, $candidateId, $code, $msg_type, $msgCandidate);
                $notification = insertNotification(5, $companyJob->related_id, $code, $msg_type, $msg);
                // if ($candidateApplication) {
                //     $candidateApplication->status = 4;
                //     $candidateApplication->rejection_reason = $reason;
                //     $candidateApplication->rejected_at = Carbon::now();
                //     $candidateApplication->update();
                // }

                //send mail notification
                $slug = 'candidate-job-application-rejected';
                if ($candidate) {
                    $data = [
                        'userId' => $candidate->user_id,
                        'job_title' => $job->title,
                        'candidate_name' => $candidate->first_name . " " . $candidate->last_name,
                    ];
                    EmailTemplates::sendNotificationMailCandidate($slug, $data);
                }
            }
            if ($type == 1) {
                $rCandidate = RecruiterCandidate::where('id', $candidateId)->first();
                $code = 'JOBCANREJ';
                $msg_type = 'Job Candidate Rejected';
                $msg = 'Your job application for ' . $job->title . ' of candidate ' . $rCandidate->name . ' has been rejected by ' . $company->name . '.';
                $notification = insertNotification(2, $companyJob->related_id, $code, $msg_type, $msg);
                //send notification mail
                $slug = 'recruiter-candidate-rejected';
                if ($rCandidate) {
                    $data = [
                        'recruiterId' => $rCandidate->recruiter_id,
                        'job_title' => $job->title,
                        'candidate_name' => $rCandidate->name,
                    ];
                    EmailTemplates::sendNotificationMailRecruiter($slug, $data);
                }
            }
            $companyJob->status = 4;
            $companyJob->rejection_reason = $reason;
            $companyJob->rejected_at = Carbon::now();
            $companyJob->update();
            $notification = array(
                'message' => "Candidate Rejected",
                'alert-type' => 'success'
            );
            return redirect()->route('showCompanyCandidate')->with($notification);
        } catch (Exception $e) {
            $notification = array(
                'message' => config('message.frontendMessages.error.wrong'),
                'alert-type' => 'success'
            );
            return redirect()->route('showCompanyCandidate')->with($notification);
        }
    }

    public function approve(Request $request)
    {
        try {
            $id = $request['id'];
            $companyJobApplication = CompanyJobApplication::where('id', $id)->first();
            $companyJob = CompanyJob::where('id', $companyJobApplication->company_job_id)->first();
            $candidateId = $companyJobApplication->candidate_id;
            $type = $companyJobApplication->applied_type;
            $company = Companies::where('id', $companyJob->company_id)->first();
            $candidate = "";
            // $balance = (double)$companyJob->balance;
            $recruiterCommission = GlobalSettings::getSingleSettingVal('job_recruiter_commission');
            $jobPostAmount = GlobalSettings::getSingleSettingVal('job_post_amount');
            $reqcityCommission = GlobalSettings::getSingleSettingVal('job_admin_comission');
            if ($type == 1) {
                $candidate = RecruiterCandidate::where('id', $candidateId)->first();
                // add entry in job_commission table for recruiter
                $jobCommission = new AdminCommission;
                $jobCommission->company_job_id = $companyJob->id;
                $jobCommission->company_job_application_id = $id;
                $jobCommission->amount = $recruiterCommission;
                $jobCommission->type = 1;//for recruiter
                $jobCommission->recruiter_id = $companyJobApplication->related_id;
                $jobCommission->flag_paid = 0;
                $jobCommission->created_at = Carbon::now();
                $jobCommission->save();
                // add entry in job_commission table for reqcity admin
                $jobCommissionReq = new AdminCommission;
                $jobCommissionReq->company_job_id = $companyJob->id;
                $jobCommissionReq->company_job_application_id = $id;
                $jobCommissionReq->amount = $reqcityCommission;
                $jobCommissionReq->type = 2;//for admin
                $jobCommissionReq->recruiter_id = 0;
                $jobCommissionReq->flag_paid = 0;
                $jobCommissionReq->created_at = Carbon::now();
                $jobCommissionReq->save();
                //add notification
                $code = 'JOBCANAPR';
                $msg_type = 'Job Candidate Approved';
                $msg = 'Your job application for ' . $companyJob->title . ' of candidate ' . $candidate->name . ' has been approved by ' . $company->name . '.';
                $notification = insertNotification(2, $companyJobApplication->related_id, $code, $msg_type, $msg);
                //send notification mail
                if ($candidate) {
                    $slug = 'recruiter-candidate-accepted';
                    $data = [
                        'recruiterId' => $candidate->recruiter_id,
                        'job_title' => $companyJob->title,
                        'candidate_name' => $candidate->name,
                    ];
                    EmailTemplates::sendNotificationMailRecruiter($slug, $data);
                }
            }
            if ($type == 2) {
                $candidate = Candidate::where('id', $candidateId)->first();
                // $candidateApplication = CandidateApplications::where('company_job_id', $companyJobApplication->company_job_id)
                //     ->where('candidate_id', $candidateId)->first();
                // if($candidateApplication){
                //     $candidateApplication->status = 3;
                //     $candidateApplication->approved_at = Carbon::now();
                //     $candidateApplication->update();
                // }
                $candidateApplication = CandidateApplications::changeStatusApprove($candidateId, $companyJobApplication->company_job_id);
                // add entry in job_commission table for candidate
                $jobCommission = new AdminCommission;
                $jobCommission->company_job_id = $companyJob->id;
                $jobCommission->company_job_application_id = $id;
                $jobCommission->amount = $jobPostAmount;
                $jobCommission->type = 2;
                $jobCommission->recruiter_id = 0;
                $jobCommission->flag_paid = 0;
                $jobCommission->created_at = Carbon::now();
                $jobCommission->save();
                //add notification
                $code = 'JOBCANAPR';
                $msg_type = 'Job Candidate Approved';
                $msg = 'Your job application for ' . $companyJob->title . ' of candidate ' . $candidate->first_name . ' ' . $candidate->last_name . ' has been approved by ' . $company->name . '.';
                $msgCandidate = 'Your job application for ' . $companyJob->title . '  has been approved by ' . $company->name . '.';
                $notification = insertNotification(2, $companyJobApplication->related_id, $code, $msg_type, $msg);
                $notificationCandidate = insertNotification(3, $companyJobApplication->candidate_id, $code, $msg_type, $msgCandidate);
                $notificationCandidateSpecialist = insertNotification(5, $companyJobApplication->related_id, $code, $msg_type, $msg);
                //send mail notification
                if ($candidate) {
                    $slug = 'candidate-job-application-accepted';
                    $data = [
                        'userId' => $candidate->user_id,
                        'job_title' => $companyJob->title,
                        'candidate_name' => $candidate->first_name . " " . $candidate->last_name,
                    ];
                    EmailTemplates::sendNotificationMailCandidate($slug, $data);
                }
            }
            // $balance = $balance - (double)$jobPostAmount;
            $companyJobApplication->status = 3;
            $companyJobApplication->approved_at = Carbon::now();
            $companyJobApplication->update();
            $updateJobBalance = CompanyJob::diductJobBalance($companyJob->id);
            $balance = CompanyJob::getJobBalance($companyJob->id);
            //no fund notification
            if ($balance <= 0) {
                $slug = 'company-job-posting-expire';
                $data = [
                    'companyId' => $companyJob->company_id,
                    'job_title' => $companyJob->title,
                    // 'balance'=>$balance,
                ];
                EmailTemplates::sendNotificationMailCompany($slug, $data);
                //add simple notification
                $code = 'JOBNOFUND';
                $msg_type = 'Job Fund Alert';
                $msg = 'The job ' . $companyJob->title . ' has no fund.';
                $notification = insertNotification(1, $companyJob->company_id, $code, $msg_type, $msg);
            }
            $singleJobBalance = GlobalSettings::getSingleSettingVal('job_post_amount');
            //low fund notifications
            if ($balance == $singleJobBalance) {
                $slug = 'company-job-posting-expire-soon';
                $data = [
                    'companyId' => $companyJob->company_id,
                    'job_title' => $companyJob->title,
                    'balance' => $balance,
                ];
                EmailTemplates::sendNotificationMailCompany($slug, $data);
                //add simple notification
                $code = 'JOBLOWFUND';
                $msg_type = 'Job Fund Alert';
                $msg = 'The job ' . $companyJob->title . ' has low fund.';
                $notification = insertNotification(1, $companyJob->company_id, $code, $msg_type, $msg);
            }
            // $companyJob->balance = (double)$balance;
            // $companyJob->update();
            $notification = array(
                'message' => config('message.frontendMessages.candidate.approved'),
                'alert-type' => 'success'
            );
            return redirect()->route('showCompanyCandidate')->with($notification);
        } catch (Exception $e) {
            $notification = array(
                'message' => config('message.frontendMessages.error.wrong'),
                'alert-type' => 'success'
            );
            return redirect()->route('showCompanyCandidate')->with($notification);
        }
    }

    public function checkJobBalance(Request $request)
    {
        $id = $request->id;
        $companyJobApplication = CompanyJobApplication::where('id', $id)->first();
        $companyJob = CompanyJob::where('id', $companyJobApplication->company_job_id)->first();
        $balance = $companyJob->balance;
        if ($balance > 0) {
            $title = 'Confirm';
            $message = 'are you sure?';
            return view('frontend.company.candidate.approve', compact('title', 'message', 'id'));
        } else {
            $id = 0;
            $title = 'Alert';
            $message = 'You do not have sufficient balance to approve this job application.';
            return view('frontend.company.candidate.approve', compact('title', 'message', 'id'));
        }
    }
}
