<?php

namespace App\Http\Controllers\FrontEnd\Company;

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
use Exception;
use Auth;
use Response;
use Mail;
use Illuminate\Support\Facades\Session;
use Illuminate\Routing\Route;
use Illuminate\Support\Facades\URL;

class CompanyJobController extends Controller
{

  public function index(Request $request, $status = "")
  {

    $companyId = Auth::user()->companyUser->company_id;
    switch ($status) {
      case 'open':
        $status = 1;
        break;
      case 'paused':
        $status = 3;
        break;
      case 'closed':
        $status = 4;
        break;
      case 'draft':
        $status = 2;
        break;
      default:
        $status = '';
    }
    try {
      $jobList = CompanyJob::serchJobList($companyId, $status);
      $childCategories = Category::getChildCategoriesHaveJob();
      $parentCategories = Category::getCategoryList();
      $employmentType = JobFieldOption::getOptions('EMPTY');
      $contractType = JobFieldOption::getOptions('CONTY');
      $jobLocations = CompanyAddress::getJobAddress($companyId);
      $jobStatus = CompanyJob::getStatus();
      // pre($jobStatus);
      $jobListData = $jobList['companyJobs'];
      $pageNo = $jobList['page'];
      $limit = $jobList['limit'];
      return view('frontend.company.jobs.index', compact('status', 'jobListData', 'pageNo', 'limit', 'companyId', 'childCategories', 'parentCategories', 'employmentType', 'contractType', 'jobLocations', 'jobStatus'));
    } catch (Exception $e) {
      dd($e);
      return redirect()->route('showDashboard');
    }
  }

  public function ajaxJobList(Request $request)
  {
    $input = $request->all();
    $companyId = $input['companyId'];
    $status = isset($input['status']) ? $input['status'] : '';
    $page = isset($input['page']) ? $input['page'] : 1;
    $search = isset($input['search']) ? $input['search'] : '';
    $sort = isset($input['sort']) ? $input['sort'] : '';
    $filter = isset($input['filter']) ? $input['filter'] : [];
    $jobList = CompanyJob::serchJobList($companyId, $status, $page, $search, $sort, $filter);
    //$jobList=CompanyJob::serchJobList($companyId,$status);
    $jobListData = $jobList['companyJobs'];
    $pageNo = $jobList['page'];
    $limit = $jobList['limit'];
    if (!empty($jobListData))
      return view('frontend.company.jobs.components.ajax-list', compact('status', 'jobListData', 'pageNo', 'limit', 'companyId'));
    else
      return $this->sendError('Something went wrong!!', ['error' => 'Something went wrong!!'], 300);
  }
  public function getList(Request $request)
  {
    $companyId = Auth::user()->companyUser->company_id;
    $req = $request->all();
    $jobId = $req['jobId'];
    $jobList = CompanyJob::getList($companyId, $jobId);
    // pre($jobList);
    $jobDetails = CompanyJob::getJobById($companyId, $jobId);
    $json_data = array(
      "jobList" => $jobList,
      "jobTitle" => $jobDetails['title'],
      "balance" => $jobDetails['balance'],
    );
    return Response::json($json_data);
  }

  public function submitBalanceTransferRequest(Request $request)
  {
    $companyId = Auth::user()->companyUser->company_id;
    $userId = Auth::user()->id;
    $validator = Validator::make(
      $request->all(),
      [
        'toJobId' => 'required',
        // 'phone' => 'required|unique:users,phone',
        // 'email' => 'required|email|unique:users',
        // 'role_id' => 'required',
      ]
    );
    if ($validator->fails()) {
      return $this->sendError('Validation Error.', $validator->errors(), 300);
    }
    unset($request['_token']);
    $input = $request->all();
    $success = array();
    $input['status'] = 1;
    $input['company_id'] = $companyId;
    $input['created_by'] = $userId;
    $balanceTransfer = JobBalanceTransferRequests::addNew($input);
    $company = Companies::select('name')->where('id', $companyId)->first();
    if (!empty($balanceTransfer)) {
      $model = CompanyJob::where('id', $input['fromJobId'])->first();
      $model->status = 4;
      $model->update();
      $code = 'BALTRFREQ';
      $msg_type = 'Job Transfer Requested';
      $msg = $company->name . 'has requested for balance transfer';
      $notification = insertNotification(4, 0, $code, $msg_type, $msg);
      //     try {
      //         $data = ['FIRST_NAME' => $bookDemoRequest->first_name, 'LAST_NAME' => $bookDemoRequest->last_name, 'LINK' => route('login'),];
      //         EmailTemplates::sendMail('book-demo-request', $data, $bookDemoRequest->email);
      //     } catch (\Exception $e) {
      //         pre($e->getMessage());
      //     }
      return $this->sendResponse([], config('message.frontendMessages.BalanceTransfer.Add'));
    } else {
      return $this->sendError('Something went wrong!!', ['error' => 'Something went wrong!!'], 300);
    }
  }

  public function companyJobChangeStatus(Request $request)
  {
    $flag = 0;
    try {
      $id = $request->id;
      $status = $request->status;
      $model = CompanyJob::where('id', $id)->first();
      $model->status = $status;
      if ($model->update()) {
        $result['status'] = 'true';
        $result['message'] = config('message.frontendMessages.comapnyjob.changestatus');
        return $result;
      } else {
        $result['status'] = 'false';
        $result['message'] = 'Something went wrong!!';
        return $result;
      }
    } catch (\Exception $ex) {
      return view('errors.500');
    }
  }

  public function showCompanyJobDetails($slug = '')
  {
    $companyId = Auth::user()->companyUser->company_id;
    $jobDetails = CompanyJob::where('slug', $slug)->first();
    if ($jobDetails && !in_array($jobDetails->status,[2,3])) {
      $companyJobId = $jobDetails->id;
      $companyAddress = CompanyAddress::where('company_id', $companyId)->first();;
      $jobLocations = CompanyAddress::getAddress($companyId);
      $parentCategories = Category::getParentCategories();
      $jobIndustries = JobFieldOption::getOptions('JOBIN');
      $employmentType = JobFieldOption::getDetails($jobDetails->job_employment_type_id);
      //$jobSchedule = JobFieldOption::getOptions('JOBSC');
      $contractType = JobFieldOption::getDetails($jobDetails->job_contract_id);
      $remoteWork = JobFieldOption::getDetails($jobDetails->job_remote_work_id);
      $companyJobFaq = CompanyJobCommunications::getCompanyFaq($companyJobId);
      // $companyJobFaq = CompanyJobCommunications::where('company_job_id',$companyJobId)->whereNull('deleted_at')->get();
      $companyJobOpenings = $jobDetails->vaccancy;
      $companyJobApproved = CompanyJobApplications::getCantidateCountByStatus($companyId, $companyJobId, 3);
      $companyJobRejected = CompanyJobApplications::getCantidateCountByStatus($companyId, $companyJobId, 4);
      //$companyJobPending = $companyJobOpenings-($companyJobApproved+$companyJobRejected);
      $companyJobPending = CompanyJobApplications::getCantidateCountByStatus($companyId, $companyJobId, 1);
      $jobSchedule = explode(',', $jobDetails->job_schedule_ids);
      $scheduleData = '';
      $i = 1;
      if (!empty($jobSchedule)) {
        foreach ($jobSchedule as $schId) {
          $count = count($jobSchedule);
          $data = JobFieldOption::getDetails($schId);
          if (!empty($data)) {
            if ($count > 1 && $i < $count)
              $scheduleData .= $data->option . ',';
            else
              $scheduleData .= $data->option;
          }
          $i++;
        }
      }
      if (!empty($jobDetails->to_salary))
        $salary = '$' . getFormatedAmount($jobDetails->from_salary, 0) . ' - $' . getFormatedAmount($jobDetails->to_salary, 0);
      else
        $salary = '$' . getFormatedAmount($jobDetails->from_salary, 0);
      $statusText = '';
      $statusColor = '';
      switch ($jobDetails->status) {
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
      $totalCost = ($jobDetails->total_amount_paid) ? '$' . $jobDetails->total_amount_paid : '-';
      $balance = ($jobDetails->balance) ? '$' . $jobDetails->balance : '-';
      return view('frontend.company.jobs.job_details', compact('jobDetails', 'jobLocations', 'parentCategories',  'jobIndustries', 'employmentType', 'scheduleData', 'contractType', 'remoteWork', 'companyJobFaq', 'companyJobOpenings', 'companyJobApproved', 'companyJobRejected', 'companyJobPending', 'salary', 'statusText', 'statusColor', 'totalCost', 'balance', 'companyAddress'));
    } else {
      if ($jobDetails) {
        $companyJob = [
          'id' => $jobDetails->id,
        ];
        Session::put('company_job', $companyJob);
      } else {
        Session::forget('company_job');
      }
      return redirect()->route('jobDetailsShow');
    }
  }

  public function monthlyGraph($compnayJobId)
  {
    $totalApplication = [];
    $companyId = Auth::user()->companyUser->company_id;
    $jobDetails = CompanyJob::where('id', $compnayJobId)->first(); //echo($jobDetails['created_at']);die;
    $lifeTimeMonths = Admin::getLifeTimeMonths($jobDetails['created_at']);
    krsort($lifeTimeMonths);
    foreach ($lifeTimeMonths as $k => $v) {
      $month = date('m', strtotime($v));
      $year = date('Y', strtotime($v));
      $totalApplication[] = [
        "dates" => date('M y', strtotime($v)),
        "totalSubmittals" => CompanyJobApplications::getMonthwiseCompanyJobApplicationCount($companyId, $compnayJobId, $month, $year, 1),
        "totalApproved" => CompanyJobApplications::getMonthwiseCompanyJobApplicationCount($companyId, $compnayJobId, $month, $year, 3),
        "totalRejected" => CompanyJobApplications::getMonthwiseCompanyJobApplicationCount($companyId, $compnayJobId, $month, $year, 4),
      ];
    } //pre($totalApplication);
    //}
    $json_data = [
      'total_closed_applications' => $totalApplication,
      'status' => true,
    ]; //pre($json_data);
    return Response::json($json_data);
  }
}
