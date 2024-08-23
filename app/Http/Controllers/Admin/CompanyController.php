<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Controllers\FrontEnd\StripeController;
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
use App\Models\CompanySubscription;
use App\Models\CompanyUser;
use App\Models\ScheduledSubscription;
use Exception;
use Auth;
use Carbon\Carbon;
use Faker\Provider\Company;
use Response;
use Mail;
use Illuminate\Support\Facades\Session;
use Illuminate\Routing\Route;
use Illuminate\Support\Facades\URL;

class CompanyController extends Controller
{

    public function index(Request $request)
    {
        $companies = Companies::serchCompanyList();
        $accountManagers = User::getAccountManagers();
        // pre($accountManagers);
        return view('admin.company-details.list.index', compact('companies', 'accountManagers'));
    }

    public function getList(Request $request)
    {
        $input = $request->all();
        $page = isset($input['page']) ? $input['page'] : 1;
        $search = isset($input['search']) ? $input['search'] : '';
        $sortBy = isset($input['sortBy']) ? $input['sortBy'] : 'date_desc';
        $searchChar = isset($input['searchChar']) ? $input['searchChar'] : '';
        $companies = Companies::serchCompanyList($page, $search, $searchChar, $sortBy);
        $pageNo = $companies['page'];
        $limit = $companies['limit'];
        if (!empty($companies['companies']))
            return view('admin.company-details.list.components.company-list', compact('companies'));
        else
            return $this->sendError('Something went wrong!!', ['error' => 'Something went wrong!!'], 300);
    }

    public function viewDetails(Request $request, $id)
    {
        $company = Companies::find($id);
        $activeJobsCount = CompanyJob::getJobsCountByStatus($id, 1);
        $closedJobsCount = CompanyJob::getJobsCountByStatus($id, 4);
        $pausedJobsCount = CompanyJob::getJobsCountByStatus($id, 3);
        $unpublishedJobsCount = CompanyJob::getJobsCountByStatus($id, 2);
        $activeJobs = CompanyJob::getActiveJobs($id, 3);
        return view('admin.company-details.list.detail', compact('company', 'activeJobsCount', 'closedJobsCount', 'pausedJobsCount', 'unpublishedJobsCount', 'activeJobs'));
    }

    public function monthlyGraph($duration = '', $companyId = '')
    {
        $totalClosedApplication = $totalSale = $totalFans = $dates = [];
        $company = Companies::find($companyId);
        if ($duration == 'monthly') {
            $lastSixMonths = Admin::getLastSixMonths();
            krsort($lastSixMonths);
            foreach ($lastSixMonths as $k => $v) {
                $month = date('m', strtotime($v));
                $year = date('Y', strtotime($v));
                //$dates[] = date('M y', strtotime($v));
                $totalClosedApplication[] = [
                    "dates" => date('M y', strtotime($v)),
                    "totalClosed" => CompanyJob::getMonthwiseClosedCount($companyId, $month, $year),
                    "totalSubmittals" => CompanyJobApplications::getMonthwiseJobApplicationCount($companyId, $month, $year, 1),
                    "totalApproved" => CompanyJobApplications::getMonthwiseJobApplicationCount($companyId, $month, $year, 3),
                    "totalRejected" => CompanyJobApplications::getMonthwiseJobApplicationCount($companyId, $month, $year, 4),
                    "amountSpent" => CompanyJob::getMonthwiseAmountSpent($companyId, $month, $year),
                ];
            }
        } else if ($duration == 'yearly') {
            $lastFiveYears = Admin::getLastFiveYears();
            krsort($lastFiveYears);
            foreach ($lastFiveYears as $k => $v) {
                $year = date('Y', strtotime($v));
                $totalClosedApplication[] = [
                    "dates" => date('Y', strtotime($v)),
                    "totalClosed" => CompanyJob::getYearwiseClosedCount($companyId, $year),
                    "totalSubmittals" => CompanyJobApplications::getYearwiseJobApplicationCount($companyId, $year, 1),
                    "totalApproved" => CompanyJobApplications::getYearwiseJobApplicationCount($companyId, $year, 3),
                    "totalRejected" => CompanyJobApplications::getYearwiseJobApplicationCount($companyId, $year, 4),
                    "amountSpent" => CompanyJob::getYearwiseAmountSpent($companyId, $year),
                ];
            }
        } else {
            $lifeTimeYears = Admin::getLifeTimeYears($company->created_at);
            krsort($lifeTimeYears);
            foreach ($lifeTimeYears as $k => $v) {
                $year = date('Y', strtotime($v));
                $totalClosedApplication[] = [
                    "dates" => date('Y', strtotime($v)),
                    "totalClosed" => CompanyJob::getYearwiseClosedCount($companyId, $year),
                    "totalSubmittals" => CompanyJobApplications::getYearwiseJobApplicationCount($companyId, $year, 1),
                    "totalApproved" => CompanyJobApplications::getYearwiseJobApplicationCount($companyId, $year, 3),
                    "totalRejected" => CompanyJobApplications::getYearwiseJobApplicationCount($companyId, $year, 4),
                    "amountSpent" => CompanyJob::getYearwiseAmountSpent($companyId, $year),
                ];
            }
        }
        $json_data = [
            'total_closed_applications' => $totalClosedApplication,
            'status' => true,
        ];
        return Response::json($json_data);
    }

    public function jobs(Request $request, $companyId = "", $status = "")
    {
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
        $company = Companies::find($companyId);
        if ($company) {

            $jobList = CompanyJob::serchJobList($companyId, $status);
            $childCategories = Category::getChildCategoriesHaveJob();
            $parentCategories = Category::getCategoryList();
            $employmentType = JobFieldOption::getOptions('EMPTY');
            $contractType = JobFieldOption::getOptions('CONTY');
            $jobLocations = CompanyAddress::getJobAddress($companyId);
            $jobListData = $jobList['companyJobs'];
            $pageNo = $jobList['page'];
            $limit = $jobList['limit'];
            return view('admin.company-details.jobs.index', compact('status', 'jobListData', 'pageNo', 'limit', 'companyId', 'childCategories', 'parentCategories', 'employmentType', 'contractType', 'jobLocations', 'company'));
        } else {
            abort('404');
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
            return view('admin.company-details.jobs.components.job-list', compact('status', 'jobListData', 'pageNo', 'limit', 'companyId'));
        else
            return $this->sendError('Something went wrong!!', ['error' => 'Something went wrong!!'], 300);
    }

    public function companyJobDetails($slug = '')
    {
        $jobDetails = CompanyJob::where('slug', $slug)->first();
        if ($slug && $jobDetails) {
            $companyId = $jobDetails->company_id;
            $company = Companies::find($companyId);
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
            //$companyJobPending = $companyJobOpenings - ($companyJobApproved + $companyJobRejected);
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
            return view('admin.company-details.jobs.detail', compact('jobDetails', 'jobLocations', 'parentCategories',  'jobIndustries', 'employmentType', 'scheduleData', 'contractType', 'remoteWork', 'companyJobFaq', 'companyJobOpenings', 'companyJobApproved', 'companyJobRejected', 'companyJobPending', 'salary', 'statusText', 'statusColor', 'totalCost', 'balance', 'companyAddress', 'companyId', 'company'));
        } else {
            abort('404');
        }
    }

    public function monthlyGraphForJobDetail($compnayJobId)
    {
        $totalApplication = [];
        $jobDetails = CompanyJob::where('id', $compnayJobId)->first();
        $companyId = $jobDetails->company_id;
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
        }
        $json_data = [
            'total_closed_applications' => $totalApplication,
            'status' => true,
        ]; //pre($json_data);
        return Response::json($json_data);
    }

    public function cancelSubscription(Request $request, $id)
    {
        $input = $request->all();
        $validator = Validator::make(
            $input,
            [
                'cancel_reason' => 'required',
            ]
        );

        if ($validator->fails()) {
            $notification = array(
                'message' => 'Validation Required!',
                'alert-type' => 'error'
            );
            return redirect()->back()->with($notification);
        } else {
            // pre($input);
            $company = Companies::find($id);
            if ($company) {
                $userId = $company->user_id;
                $user = User::find($userId);
                if ($user) {
                    $upcoming = ScheduledSubscription::getScheduledSubscriptionByUser($userId);
                    if ($upcoming) {
                        $stripe = new StripeController;
                        $cancelled = $stripe->cancelScheduledSubscription($upcoming['shed_sub_id']);
                        if ($cancelled) {
                            $user->cancel_reason = $input['cancel_reason'];
                            $user->save();
                            $notification = array(
                                'message' => 'Successfully Cancelled!',
                                'alert-type' => 'success'
                            );
                            return redirect()->back()->with($notification);
                        }
                        abort(404);
                    } else {
                        $subsc = CompanySubscription::find($user->current_subscription_id);
                        if ($subsc) {
                            $currentSubscriptionId = $subsc->stripe_subscription_id;
                            $stripe = new StripeController;
                            $cancelled = $stripe->cancelSubscription($currentSubscriptionId, $userId);
                            if ($cancelled) {
                                $subsc->cancel_reason = $input['cancel_reason'];
                                $subsc->save();
                                $user->cancel_reason = $input['cancel_reason'];
                                $user->save();
                                $notification = array(
                                    'message' => 'Successfully Cancelled!',
                                    'alert-type' => 'success'
                                );
                                return redirect()->back()->with($notification);
                            }
                            abort(404);
                        }
                    }
                    abort(404);
                }
                abort(404);
            }
            abort(404);
        }
    }

    public function companyJobDetailUpdate(Request $request, $id)
    {
        // pre($request->all());
        CompanyJob::where('id', $id)->update(['job_description' => $request->job_description]);
        $notification = array(
            'message' => 'Job Description Updated Successfully!',
            'alert-type' => 'success'
        );
        return redirect()->back()->with($notification);
    }

    public function getSelectedManagerList(Request $request)
    {
        $input = $request->all();
        $companyId = $input['companyId'];
        $accountManagerSelected = Companies::where('id', $companyId)->pluck('account_managers')->first();
        $accountManagerSelected = $accountManagerSelected ? explode(',', $accountManagerSelected) : [];
        $accountManagers = User::getAccountManagers();
        return view('admin.company-details.list.components.list-manager-dropdown', compact('accountManagerSelected', 'accountManagers'));
    }

    public function setSelectedManagerList(Request $request)
    {
        $input = $request->all();
        // pre($input);
        $companyId = $input['company_id'];
        $accountManagers = $input['account_managers'] ? implode(',', $input['account_managers']) : '';
        $accountManagerSelected = Companies::where('id', $companyId)->update(['account_managers' => $accountManagers]);
        $notification = array(
            'message' => 'Manager Assigned Successfully',
            'alert-type' => 'success',
            'success' => true
        );
        return Response::json($notification);
    }

    public function loginLink(Request $request)
    {
        $input = $request->all();
        $companyId = $input['companyId'];
        $success = false;
        $login = "";
        $company = Companies::find($companyId);
        if ($company) {
            $userId = $company->user_id;
            $user = User::find($userId);
            if ($user) {
                $loginlink = md5($user->email . $user->id . time());
                User::where('id', $userId)->update(['login_link' => $loginlink]);
                $login = route('loginViaLink', $loginlink);
                $success = true;
            }
        }

        if ($success) {
            $notification = array(
                'message' => 'Link Coppied Successfully',
                'link' => $login,
                'alert-type' => 'success',
                'success' => true
            );
            return Response::json($notification);
        } else {
            $notification = array(
                'message' => 'Something went wrong',
                'alert-type' => 'error',
                'success' => false
            );
            return Response::json($notification);
        }
    }

    public function delete(Request $request)
    {
        $input = $request->all();
        $companyId = $input['module_id'];
        $companyData = Companies::find($companyId);
        if ($companyData) {
            Companies::where('id', $companyId)->update(['deleted_at' => Carbon::now()]);
            CompanyUser::where('company_id', $companyId)->update(['deleted_at' => Carbon::now()]);
            CompanyAddress::where('company_id', $companyId)->update(['deleted_at' => Carbon::now()]);
            User::where('id', $companyData->user_id)->update(['deleted_at' => Carbon::now()]);
            $result['status'] = 'true';
            $result['msg'] = "Company has been deleted successfully!";
            return $result;
        } else {
            $result['status'] = 'false';
            $result['msg'] = "Something went wrong!!";
            return $result;
        }
    }
}
