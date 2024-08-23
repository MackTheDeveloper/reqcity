<?php

namespace App\Http\Controllers\FrontEnd\Candidate;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use App\Models\User;
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
use App\Models\CompanyAddress;
use App\Models\Category;
use App\Models\JobFieldOption;
use Exception;
use Auth;
use Response;
use Mail;
use Illuminate\Support\Facades\Session;
use Illuminate\Routing\Route;
use Illuminate\Support\Facades\URL;

class CandidateJobsController extends Controller
{

  public function index(Request $request,$tab="")
  {
      switch ($tab) {
      case 'all':
        $tab=1;
        break;
      case 'favorites':
        $tab=2;
        break;
      case 'applied':
        $tab=3;
        break;
      case 'similar':
        $tab=4;
        break;
      default:
        $tab='';
      }
      try {
          $jobList=CompanyJob::searchCandidateJobList($tab);

          $parentCategories = Category::getCategoryList();
          $childCategories = Category::getChildCategoriesHaveJob();
          $jobLocations = CompanyAddress::getJobAddressForRecruiter();
          $employmentType = JobFieldOption::getOptions('EMPTY');
          $contractType = JobFieldOption::getOptions('CONTY');

          $jobListData=$jobList['companyJobs'];
          $pageNo=$jobList['page'];
          $limit=$jobList['limit'];
          return view('frontend.candidate.jobs.index',compact('tab','jobListData','pageNo','limit','childCategories','parentCategories','employmentType','contractType','jobLocations'));
      } catch (Exception $e) {dd($e);
          return redirect()->route('showDashboard');
      }
  }

  public function ajaxJobList(Request $request)
  {
    $input = $request->all();
    $tab =isset($input['tab']) ? $input['tab'] : '';
    $page = isset($input['page']) ? $input['page'] : 1;
    $search = isset($input['search']) ? $input['search'] : '';
    $sort = isset($input['sort']) ? $input['sort'] : '';
    $filter = isset($input['filter']) ? $input['filter'] : [];
    $jobList = CompanyJob::searchCandidateJobList($tab, $page, $search, $sort, $filter);
    //$jobList=CompanyJob::serchJobList($companyId,$status);
    $jobListData=$jobList['companyJobs'];
    $pageNo=$jobList['page'];
    $limit=$jobList['limit'];
    if(!empty($jobListData))
    return view('frontend.candidate.jobs.components.job-list',compact('tab','jobListData','pageNo','limit'));
    else
    return $this->sendError('Something went wrong!!', ['error' => 'Something went wrong!!'], 300);
  }

  public function findJobs(Request $request,$slug="")
  {
      $searchTitle='';
      $searchCat='';
      if(!empty($slug)){
          $categoryId = Category::where('slug',$slug)->whereNull('deleted_at')->where('status',1)->pluck('id');
          if(!empty($categoryId) && count($categoryId)>0)
            $searchCat=$categoryId[0];
      }
      if(!empty($request->search))
      {
        $searchTitle=$request->search;
      }
      $jobList = CompanyJob::serchJobListForCandidate(1, $searchTitle, $searchLoc = '',  $sort = '', $searchCat);
      $parentCategories = Category::getCategoryList();
      $jobListData=$jobList['companyJobs'];
      $pageNo=$jobList['page'];
      $limit=$jobList['limit'];
      return view('frontend.candidate.jobs.find-job', compact('jobListData','parentCategories','pageNo','limit','searchTitle','searchCat'));
  }
  public function ajaxFindJobList(Request $request)
  {
    $input = $request->all();
    $page = isset($input['page']) ? $input['page'] : 1;
    $search = isset($input['search']) ? $input['search'] : '';
    $searchLoc = isset($input['searchLoc']) ? $input['searchLoc'] : '';
    $sort = isset($input['sort']) ? $input['sort'] : '';
    $filter = isset($input['filter']) ? $input['filter'] : '';
    $jobList = CompanyJob::serchJobListForCandidate($page, $search, $searchLoc,$sort,$filter);
    //$jobList=CompanyJob::serchJobList($companyId,$status);
    $jobListData=$jobList['companyJobs'];
    $pageNo=$jobList['page'];
    $limit=$jobList['limit'];
    if(!empty($jobListData))
    return view('frontend.candidate.jobs.components.job-list',compact('jobListData','pageNo','limit'));
    else
    return $this->sendError('Something went wrong!!', ['error' => 'Something went wrong!!'], 300);
  }

  public function applyForJob(Request $request)
  {
    $candidateId = Auth::user()->candidate->id;
    $input = $request->all();
    /* pre($input, 1);
    pre($jobId); */
    $jobId=$input['jobId'];
    $jobData = CompanyJob::find($input['jobId']);
    $exist = CandidateApplications::where('candidate_id', $candidateId)->where('company_job_id', $jobId)->first();
    if (!$exist) {
      $dataApplications = [
        "candidate_id" => $candidateId,
        "company_job_id" => $jobId,
        "candidate_cv_id" => CandidateResume::getLastestCvId($candidateId),
        'status' => 0,//Pending
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
    $jobTitle=$jobData->title;
    $notification = array(
      'message' => config('message.frontendMessages.jobPostApply.applied'),
      'alert-type' => 'success'
    );
    return view('frontend.candidate.jobs.applied-job',compact('jobTitle'));
  }


}
