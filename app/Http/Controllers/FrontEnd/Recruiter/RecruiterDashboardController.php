<?php

namespace App\Http\Controllers\FrontEnd\Recruiter;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use App\Models\User;
use App\Models\Recruiter;
use App\Models\RecruiterBankDetail;
use App\Models\CompanyJob;
use App\Models\CompanyJobApplications;
use App\Models\Notifications;
use App\Models\Admin;
use App\Models\AdminCommission;
use App\Models\RecruiterTaxForms;
use App\Models\RecruiterCandidate;
use Exception;
use Auth;
use Response;
use Mail;
use Illuminate\Support\Facades\Session;
use Illuminate\Routing\Route;
use Illuminate\Support\Facades\URL;

class RecruiterDashboardController extends Controller
{

    public function showDashboard(Request $request)
    {
        $userId = Auth::user()->id;
        if ($userId) {
            try {
               $recruiterId = Auth::user()->recruiter->id;
               $recruiterData=Recruiter::getRecruiterDetailsById($recruiterId);
               $favoriteJobs=CompanyJob::getRecruiterFavoriteJobs($recruiterId,3);
               $similarJobs=CompanyJob::getRecruiterSimilarJobs($recruiterId,3);
               $candidateCount=CompanyJobApplications::getTotalJobByRecruiter($recruiterId);
               $candidateApprovedCount=CompanyJobApplications::getTotalJobApprovedByRecruiter($recruiterId);
               $candidateRejectedCount=CompanyJobApplications::getTotalJobRejectedByRecruiter($recruiterId);
                $notificationData= Notifications::where('type',2)
                                        ->where('related_id',$recruiterId)
                                       ->whereNull('deleted_at')->orderBy('created_at','DESC')->limit(4)->get();
                $payouts=AdminCommission::getPayoutTotal($recruiterId,1);
                $balance=AdminCommission::getPayoutTotal($recruiterId,0);
                $recruiterBankDetail=RecruiterBankDetail::getRecruiterBankDetail($recruiterId);
                $recruiterW9Forms=RecruiterTaxForms::getRecruiterW9Forms($recruiterId);
                $recruiterCandidate=RecruiterCandidate::getRecruiterCandidate($userId);
                   $maximumPoints  = 100;
                   $hasVerifiedEmail=0;
                   $hasBankDetails=0;
                   $hasW9Forms=0;
                   $hasCandidate=0;
                  if(Auth::user()->is_verify==1){
                    $hasVerifiedEmail = 25;
                    }
                  if(!empty($recruiterBankDetail) ){
                    $hasBankDetails = 25;
                  }
                  if(!empty($recruiterW9Forms)){
                    $hasW9Forms = 25;
                  }
                  if(!empty($recruiterCandidate)){
                    $hasCandidate = 25;
                  }
                  $percentage = ($hasVerifiedEmail+$hasBankDetails+$hasW9Forms+$hasCandidate)*$maximumPoints/100;
            //     return view('frontend.company.dashboard.dashboard', compact('companyData','notificationData','activeJobs','activeJobsCount','closedJobsCount','pausedJobsCount','unpublishedJobsCount','percentage','faqTemplateCount','questionnaireTemplatesCount','firstJobCount','hasVerifiedEmail'));
            return view('frontend.recruiter.dashboard.dashboard',compact('recruiterData','favoriteJobs','similarJobs','percentage','hasVerifiedEmail','hasBankDetails','hasW9Forms','hasCandidate','notificationData','payouts','balance','candidateCount','candidateApprovedCount','candidateRejectedCount'));
             } catch (Exception $e) {
              dd($e);
                return redirect()->route('showMyInfoCompany');
            }
        }
    }
}
