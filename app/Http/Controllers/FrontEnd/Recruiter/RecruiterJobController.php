<?php

namespace App\Http\Controllers\FrontEnd\Recruiter;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use App\Models\User;
use App\Models\Companies;
use App\Models\CompanyAddress;
use App\Models\JobBalanceTransferRequests;
use App\Models\CompanyJob;
use App\Models\CompanyJobApplications;
use App\Models\Category;
use App\Models\JobFieldOption;
use App\Models\CompanyJobCommunications;
use App\Models\Admin;
use App\Models\CompanyJobApplication;
use App\Models\CompanyJobApplicationQuestionnaire;
use App\Models\RecruiterCandidateExperience;
use App\Models\RecruiterFavouriteJobs;
use App\Models\RecruiterPayment;
use Exception;
use Auth;
use Response;
use Mail;
use Illuminate\Support\Facades\Session;
use Illuminate\Routing\Route;
use Illuminate\Support\Facades\URL;

class RecruiterJobController extends Controller
{

  public function index(Request $request, $status = "")
  {
    /* $userId = Auth::user()->id;
    $recruiterId = Auth::user()->recruiter->id;
    pre($userId,1);
    pre($recruiterId); */
    switch ($status) {
      case 'all':
        $status = 1;
        break;
      case 'favorites':
        $status = 2;
        break;
      case 'submitted':
        $status = 3;
        break;
      case 'similar':
        $status = 4;
        break;
      default:
        $status = '';
    }
    try {
      $recuriterId = Auth::user()->recruiter->id;
      $jobList = CompanyJob::serchJobListForRecruiter($recuriterId, '', $status);

      $parentCategories = Category::getCategoryList();
      $childCategories = Category::getChildCategoriesHaveJob();
      $jobLocations = CompanyAddress::getJobAddressForRecruiter();
      $employmentType = JobFieldOption::getOptions('EMPTY');
      $contractType = JobFieldOption::getOptions('CONTY');

      $jobListData = $jobList['companyJobs'];
      $pageNo = $jobList['page'];
      $limit = $jobList['limit'];

      return view('frontend.recruiter.jobs.index', compact('status', 'jobListData', 'pageNo', 'limit', 'parentCategories', 'childCategories', 'jobLocations', 'employmentType', 'contractType'));
    } catch (Exception $e) {
      pre($e->getMessage());
      //return redirect()->route('showDashboard');
    }
  }

  public function ajaxJobList(Request $request)
  {
    $input = $request->all();
    $recuriterId = Auth::user()->recruiter->id;
    $status = isset($input['status']) ? $input['status'] : '';
    $page = isset($input['page']) ? $input['page'] : 1;
    $search = isset($input['search']) ? $input['search'] : '';
    $sort = isset($input['sort']) ? $input['sort'] : '';
    $filter = isset($input['filter']) ? $input['filter'] : [];
    $jobList = CompanyJob::serchJobListForRecruiter($recuriterId, '', $status, $page, $search, $sort, $filter);
    //$jobList=CompanyJob::serchJobList($companyId,$status);
    $jobListData = $jobList['companyJobs'];
    $pageNo = $jobList['page'];
    $limit = $jobList['limit'];
    if (!empty($jobListData))
      return view('frontend.recruiter.jobs.components.job-list', compact('status', 'jobListData', 'pageNo', 'limit'));
    else
      return $this->sendError('Something went wrong!!', ['error' => 'Something went wrong!!'], 300);
  }

  public function makeFavorite(Request $request)
  {
    $input = $request->all();
    $jobId = $input['jobId'];
    $recuriterId = Auth::user()->recruiter->id;
    $data = RecruiterFavouriteJobs::where('recruiter_id', $recuriterId)->where('company_job_id', $jobId)->first();
    if (empty($data)) {
      RecruiterFavouriteJobs::create([
        "recruiter_id" => $recuriterId,
        "company_job_id" => $jobId
      ]);
      $msg = config('message.frontendMessages.jobPost.jobFavourite');
    } else {
      RecruiterFavouriteJobs::where('recruiter_id', $recuriterId)->where("company_job_id", $jobId)->delete();;
      $msg = config('message.frontendMessages.jobPost.jobUnFavourite');
    }
    return $this->sendResponse([], $msg);
  }

  public static function detail($slug)
  {
    $model = CompanyJob::where('slug', $slug)->first();
    if ($model) {
      $authId = User::getLoggedInId();
      $recuriterId = Auth::user()->recruiter->id;
      $modelCounts = CompanyJobApplication::getTotalCandidates($model->id, $recuriterId);
      $modelPayout = RecruiterPayment::getJobCommission($model->id, $recuriterId);
      $modelCandidates = CompanyJobApplication::getCandidates($model->id, $recuriterId);
      $faq = CompanyJobCommunications::getCompanyFaq($model->id);
      $extra['employmentType'] =  JobFieldOption::getAttrById($model->job_employment_type_id, 'option');
      $extra['schedule'] =  JobFieldOption::getAttrById($model->job_schedule_ids, 'option');
      $extra['contractType'] =  JobFieldOption::getAttrById($model->job_contract_id, 'option');
      $extra['remoteWork'] =  JobFieldOption::getAttrById($model->job_remote_work_id, 'option');
      $extra['isFavourite'] =  RecruiterFavouriteJobs::checkIsFavorite($model->id,$recuriterId);
      // pre($faq);
      return view('frontend.recruiter.jobs.detail', compact('model', 'modelCounts', 'modelPayout', 'modelCandidates', 'faq', 'extra'));
    }
  }

  public function candidateDetail($id, $jobId)
  {
    $model = CompanyJobApplication::where('candidate_id', $id)->where('company_job_id', $jobId)->where('applied_type', 1)->first();
    $candidate = $model->recruiterCandidateData;
    $latestExp = RecruiterCandidateExperience::latestExperience($id);
    $questionnaire = CompanyJobApplicationQuestionnaire::getQuestionnaire($model->id, $jobId);
    return view('frontend.recruiter.jobs.components.candidate-info', compact('model', 'candidate', 'latestExp', 'questionnaire'));
  }
}
