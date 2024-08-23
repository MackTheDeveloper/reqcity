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
use App\Models\AdminCommission;
use App\Models\Country;
use App\Models\Recruiter;
use App\Models\RecruiterCandidate;
use App\Models\RecruiterCandidateResume;
use App\Models\RecruiterSubscription;
use App\Models\RecruiterTaxForms;
use App\Models\ScheduledSubscription;
use Exception;
use Auth;
use Carbon\Carbon;
use Response;
use Mail;
use Illuminate\Support\Facades\Session;
use Illuminate\Routing\Route;
use Illuminate\Support\Facades\URL;

class RecruiterController extends Controller
{

    public function index(Request $request)
    {
        $recruiters = Recruiter::searchRecruiterList();
        return view('admin.recruiter-details.list.index', compact('recruiters'));
    }

    public function getList(Request $request)
    {
        $input = $request->all();
        $page = isset($input['page']) ? $input['page'] : 1;
        $search = isset($input['search']) ? $input['search'] : '';
        $sortBy = isset($input['sortBy']) ? $input['sortBy'] : 'date_desc';
        $searchChar = isset($input['searchChar']) ? $input['searchChar'] : '';
        $recruiters = Recruiter::searchRecruiterList($page, $search, $searchChar,'', $sortBy);
        $pageNo = $recruiters['page'];
        $limit = $recruiters['limit'];
        if (!empty($recruiters['recruiters']))
            return view('admin.recruiter-details.list.components.recruiter-list', compact('recruiters'));
        else
            return $this->sendError('Something went wrong!!', ['error' => 'Something went wrong!!'], 300);
    }

    public function viewDetails(Request $request, $id)
    {
        $recruiters = Recruiter::searchRecruiterList('', '', '', $id);
        $recruiters = $recruiters['recruiters'][0];
        $candidateCount = CompanyJobApplications::getTotalJobByRecruiter($id);
        $candidateApprovedCount = CompanyJobApplications::getTotalJobApprovedByRecruiter($id);
        $candidateRejectedCount = CompanyJobApplications::getTotalJobRejectedByRecruiter($id);
        $balance = AdminCommission::getPayoutTotal($id, 0);
        $payouts = AdminCommission::getPayoutTotal($id, 1);
        $userIdofRecruiter = Recruiter::getUserIdByReruiterId($id);
        $recruiterCandidates = RecruiterCandidate::getCandidatesOfRecruiter($userIdofRecruiter);
        $jobList = CompanyJob::serchJobListForRecruiter($id, 3, '3', 0);
        $jobListData = $jobList['companyJobs'];
        $model = Recruiter::find($id);
        $w9Form = RecruiterTaxForms::where('recruiter_id', $id)->orderBy('id', 'DESC')->first();
        $w9FormLink = "";
        if ($w9Form) {
            $w9FormLink = RecruiterTaxForms::getFormFile($w9Form->id);
        }
        $countries = Country::getListForDropdown();
        // pre($countries);
        return view('admin.recruiter-details.list.detail', compact('recruiters', 'candidateCount', 'candidateApprovedCount', 'candidateRejectedCount', 'balance', 'payouts', 'recruiterCandidates', 'userIdofRecruiter', 'jobListData', 'model', 'w9FormLink', 'countries'));
    }

    public function candidates(Request $request, $recruiterId = '')
    {
        $recruiters = Recruiter::searchRecruiterList('', '', '', $recruiterId);
        $recruiters = $recruiters['recruiters'][0];
        $userIdofRecruiter = Recruiter::getUserIdByReruiterId($recruiterId);
        return view('admin.recruiter-details.candidate.index', compact('recruiters', 'userIdofRecruiter'));
    }

    public function getCandidatesList(Request $request)
    {

        $req = $request->all();
        $start = $req['start'];
        $length = $req['length'];
        $search = $req['search']['value'];
        $order = $req['order'][0]['dir'];
        $column = $req['order'][0]['column'];
        $orderby = ['name', '', 'email', 'city', '', '', ''];
        $userId = $req['userIdofRecruiter'];

        $total = RecruiterCandidate::selectRaw('count(*) as total')->where('recruiter_id', '=', $userId)->first();
        $query = RecruiterCandidate::where('recruiter_id', $userId);
        $filteredq = RecruiterCandidate::where('recruiter_id', $userId);

        $totalfiltered = $total->total;
        if ($search != '') {
            $query->where(function ($query2) use ($search) {
                $query2->where('recruiter_candidates.name', 'like', '%' . $search . '%')
                    ->orWhere('recruiter_candidates.email', 'like', '%' . $search . '%');
            });

            $filteredq->where(function ($query2) use ($search) {
                $query2->where('recruiter_candidates.name', 'like', '%' . $search . '%')
                    ->orWhere('recruiter_candidates.email', 'like', '%' . $search . '%');
            });

            $filteredq = $filteredq->selectRaw('count(*) as total')->first();
            $totalfiltered = $filteredq->total;
        }

        $query = $query->orderBy($orderby[$column], $order)->offset($start)->limit($length)->get();

        $data = [];
        foreach ($query as $key => $value) {
            $resumeImage = '<img src="' . url('public/assets/frontend/img/pdf.svg') . '" alt="" />';
            $resume = RecruiterCandidateResume::getLatestResume($value->id);
            if (!empty($resume))
                $resumeCv = "<a class='pdf-link' href='" . $resume['cv'] . "' target='_blank'>" . $resumeImage . "</a>";
            else
                $resumeCv = '';


            $linkedInImage = '<img src="' . url('public/assets/frontend/img/Linkedin-btn.svg') . '" alt="" />';
            $linkedIn = !empty($value->linkedin_profile) ? "<a class='linkdin-link' href='" . $value->linkedin_profile . "' target='_blank'>" . $linkedInImage . "</a>" : '';
            $data[] = [
                $value->name,
                $value->phone_ext . " " . $value->phone,
                $value->email,
                $value->city,
                $value->Countrydata->name,
                $resumeCv,
                $linkedIn,
            ];
        }
        $json_data = array(
            "draw" => intval($_REQUEST['draw']),
            "recordsTotal" => intval($total->total),
            "recordsFiltered" => intval($totalfiltered),
            "data" => $data,
        );
        return Response::json($json_data);
    }

    public function getRecruiterJobList(Request $request, $recruiterId = '', $status = "")
    {
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
                $status = 3;
        }
        try {
            $recruiters = Recruiter::searchRecruiterList('', '', '', $recruiterId);
            $recruiters = $recruiters['recruiters'][0];
            $jobList = CompanyJob::serchJobListForRecruiter($recruiterId, '', $status);

            $parentCategories = Category::getCategoryList();
            $childCategories = Category::getChildCategoriesHaveJob();
            $jobLocations = CompanyAddress::getJobAddressForRecruiter();
            $employmentType = JobFieldOption::getOptions('EMPTY');
            $contractType = JobFieldOption::getOptions('CONTY');

            $jobListData = $jobList['companyJobs'];
            $pageNo = $jobList['page'];
            $limit = $jobList['limit'];

            return view('admin.recruiter-details.job.index', compact('status', 'jobListData', 'pageNo', 'limit', 'parentCategories', 'childCategories', 'jobLocations', 'employmentType', 'contractType', 'recruiters'));
        } catch (Exception $e) {
            //pre($e->getMessage());
            return redirect()->route('recruiters');
        }
    }

    public function getRecruiterAjaxJobList(Request $request)
    {
        $input = $request->all();
        $recuriterId = $input['recruiterId'];
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
            return view('admin.recruiter-details.job.components.job-list', compact('status', 'jobListData', 'pageNo', 'limit'));
        else
            return $this->sendError('Something went wrong!!', ['error' => 'Something went wrong!!'], 300);
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
            $model = Recruiter::find($id);
            if ($model) {
                $userId = $model->user_id;
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
                        $subsc = RecruiterSubscription::find($user->current_subscription_id);
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
                        abort(404);
                    }
                }
                abort(404);
            }
            abort(404);
        }
    }

    public function editDetails(Request $request, $id)
    {
        // pre($request->all());
        $input = $request->all();
        unset($input['_token']);
        unset($input['email']);
        // pre($input);
        Recruiter::where('id', $id)->update($input);
        if (!empty($input['first_name']) || !empty($input['last_name'])) {
            $user = Recruiter::getUserIdByReruiterId($id);
            if ($user) {
                User::where('id', $user)->update(['firstname' => $input['first_name'] , 'lastname'=>$input['last_name']]);
            }
        }
        $notification = array(
            'message' => 'Details Updated Successfully!',
            'alert-type' => 'success'
        );
        return redirect()->back()->with($notification);
    }

    public function delete(Request $request)
    {
        $input = $request->all();
        $recruiterId = $input['module_id'];
        $recruiterData = Recruiter::find($recruiterId);
        if ($recruiterData) {
            Recruiter::where('id', $recruiterId)->update(['deleted_at' => Carbon::now()]);
            User::where('id', $recruiterData->user_id)->update(['deleted_at' => Carbon::now()]);
            $result['status'] = 'true';
            $result['msg'] = "Recruiter has been deleted successfully!";
            return $result;
        } else {
            $result['status'] = 'false';
            $result['msg'] = "Something went wrong!!";
            return $result;
        }
    }
}
