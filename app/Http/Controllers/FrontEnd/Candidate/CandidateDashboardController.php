<?php

namespace App\Http\Controllers\FrontEnd\Candidate;

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
use App\Models\Candidate;
use App\Models\CandidateApplications;
use App\Models\CandidateFavouriteJobs;
use App\Models\CandidateResume;
use App\Models\RecruiterTaxForms;
use App\Models\RecruiterCandidate;
use Exception;
use Auth;
use Response;
use Mail;
use Illuminate\Support\Facades\Session;
use Illuminate\Routing\Route;
use Illuminate\Support\Facades\URL;

class CandidateDashboardController extends Controller
{

  public function showDashboard(Request $request)
  {
    $userId = Auth::user()->id;
    if ($userId) {
      try {
        $candidateId = Auth::user()->candidate->id;
        $candidateData = Candidate::getCandidateDetailsById($candidateId);
        $appliedJobs = CandidateApplications::getAppliedJobs($candidateId, 5);
        $similarJobs = CompanyJob::getCandidateSimilarJobs($candidateId, 3);
        $notificationData = Notifications::getNotifications($candidateId);
        $candidateUploadedResume = CandidateResume::checkResumeUploaded($candidateId);
        $candidateUpdatedAddressDetails = Candidate::checkAddressDetailsUpdated($candidateId);
        $candidateAppliedForFirstJob = CandidateApplications::checkFirstJobAppliedOrNot($candidateId);
        $maximumPoints  = 100;
        $hasVerifiedEmail = 0;
        $hasUploadedResume = 0;
        $hasUpdatedAddressDetails = 0;
        $hasAppliedForFirstJob = 0;
        if (Auth::user()->is_verify == 1) {
          $hasVerifiedEmail = 25;
        }
        if (!empty($candidateUploadedResume)) {
          $hasUploadedResume = 25;
        }
        if (!empty($candidateUpdatedAddressDetails)) {
          $hasUpdatedAddressDetails = 25;
        }
        if (!empty($candidateAppliedForFirstJob)) {
          $hasAppliedForFirstJob = 25;
        }
        $percentage = ($hasVerifiedEmail + $hasUploadedResume + $hasUpdatedAddressDetails + $hasAppliedForFirstJob) * $maximumPoints / 100;
        return view('frontend.candidate.dashboard.dashboard', compact(
          'candidateData',
          'appliedJobs',
          'similarJobs',
          'percentage',
          'hasVerifiedEmail',
          'hasUploadedResume',
          'hasUpdatedAddressDetails',
          'hasAppliedForFirstJob',
          'notificationData'
        ));
      } catch (Exception $e) {
        return redirect()->route('showMyInfoCandidate');
      }
    }
  }

  public function makeFavorite(Request $request)
  {
    $input = $request->all();
    $jobId = $input['jobId'];
    $candidateId = Auth::user()->candidate->id;
    $data = CandidateFavouriteJobs::where('candidate_id', $candidateId)->where('company_job_id', $jobId)->first();
    if (empty($data)) {
      CandidateFavouriteJobs::create([
        "candidate_id" => $candidateId,
        "company_job_id" => $jobId
      ]);
      $msg = config('message.frontendMessages.jobPost.jobFavourite');
    } else {
      CandidateFavouriteJobs::where('candidate_id', $candidateId)->where("company_job_id", $jobId)->delete();;
      $msg = config('message.frontendMessages.jobPost.jobUnFavourite');
    }
    return $this->sendResponse([], $msg);
  }

  public function applyJob(Request $request, $jobId)
  {
    $candidateId = Auth::user()->candidate->id;
    $input = $request->all();
    /* pre($input, 1);
    pre($jobId); */
    $jobData = CompanyJob::find($jobId);
    $exist = CandidateApplications::where('candidate_id', $candidateId)->where('company_job_id', $jobId)->first();
    if (!$exist) {
      $dataApplications = [
        "candidate_id" => $candidateId,
        "company_job_id" => $jobId,
        "candidate_cv_id" => CandidateResume::getLastestCvId($candidateId),
        'status' => 0,//pending
        'specialist_user_id' => 0,
        'rejection_reason' => null,
      ];
      $dataCandidateApplications = CandidateApplications::addCandidateApplication($dataApplications);

      $dataNotification = [
        "type" => 4,
        "related_id" => 0,
        "notification_code" => 'ADMINNOTI',
        "message_type" => 'Candidate Applied',
        'message' => Auth::user()->candidate->first_name . ' ' . Auth::user()->candidate->last_name . ' has applied for job ' . $jobData->title . ' Need to assign Candidate Specialist',
        'status' => 1,
      ];
      $dataNotifications = Notifications::addNotification($dataNotification);
    }
    $notification = array(
      'message' => config('message.frontendMessages.jobPostApply.applied'),
      'alert-type' => 'success'
    );
    return Response::json($notification);
  }
  
}
