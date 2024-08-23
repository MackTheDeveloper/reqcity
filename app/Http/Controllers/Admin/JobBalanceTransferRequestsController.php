<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\JobBalanceTransferRequests;
use App\Models\CompanyJob;
use App\Models\Companies;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use Auth;
use DataTables;
use Carbon\Carbon;
use DB;
use Excel;
use Response;

class JobBalanceTransferRequestsController extends Controller
{
    public function index(Request $request)
    {
        $req = $request->all();
        //  $search = (isset($req['search']) ? $req['search'] : '');
        $baseUrl = $this->getBaseUrl();
        $company = Companies::getList();
        return view("admin.job-balance-transfer-requests.index", compact('company', 'baseUrl'));
    }
    public function list(Request $request, $status = "")
    {
        $isEditable = whoCanCheck(config('app.arrWhoCanCheck'), 'admin_categories_edit');
        $isDeletable = whoCanCheck(config('app.arrWhoCanCheck'), 'admin_categories_delete');
        $req = $request->all();
        $start = $req['start'];
        $length = $req['length'];
        $search = $req['search']['value'];
        $order = $req['order'][0]['dir'];
        $column = $req['order'][0]['column'];
        $orderby = ['companyName', 'jobTitle', 'amount', 'payment_id', 'status', 'created_at'];
        $sumAmount = 0;
        $sumAmountQuery = JobBalanceTransferRequests::selectRaw('SUM(job_balance_transfer_requests.balance) as sumAmount')
            ->leftJoin("company_jobs as FJ", "job_balance_transfer_requests.from_company_job_id", "FJ.id")
            ->leftJoin("company_jobs as TJ", "job_balance_transfer_requests.to_company_job_id", "TJ.id")
            ->leftJoin("companies", "job_balance_transfer_requests.company_id", "companies.id")
            ->whereNull('job_balance_transfer_requests.deleted_at');



        $total = JobBalanceTransferRequests::selectRaw('count(*) as total')
            ->leftJoin("company_jobs as FJ", "job_balance_transfer_requests.from_company_job_id", "FJ.id")
            ->leftJoin("company_jobs as TJ", "job_balance_transfer_requests.to_company_job_id", "TJ.id")
            ->leftJoin("companies", "job_balance_transfer_requests.company_id", "companies.id")
            ->whereNull('job_balance_transfer_requests.deleted_at');

        $query = JobBalanceTransferRequests::select('job_balance_transfer_requests.*', 'companies.name as companyName', 'FJ.title as fromJobTitle', 'TJ.title as toJobTitle')
            ->leftJoin("company_jobs as FJ", "job_balance_transfer_requests.from_company_job_id", "FJ.id")
            ->leftJoin("company_jobs as TJ", "job_balance_transfer_requests.to_company_job_id", "TJ.id")
            ->leftJoin("companies", "job_balance_transfer_requests.company_id", "companies.id")
            ->whereNull('job_balance_transfer_requests.deleted_at');

        $filteredq = JobBalanceTransferRequests::select('job_balance_transfer_requests.*', 'companies.name as companyName', 'FJ.title as fromJobTitle', 'TJ.title as toJobTitle')
            ->leftJoin("company_jobs as FJ", "job_balance_transfer_requests.from_company_job_id", "FJ.id")
            ->leftJoin("company_jobs as TJ", "job_balance_transfer_requests.to_company_job_id", "TJ.id")
            ->leftJoin("companies", "job_balance_transfer_requests.company_id", "companies.id")
            ->whereNull('job_balance_transfer_requests.deleted_at');

        if ($status) {
            $query->where('job_balance_transfer_requests.status', $status);
            $filteredq->where('job_balance_transfer_requests.status', $status);
            $total->where('job_balance_transfer_requests.status', $status);
        }

        if (isset($request->is_active)) {
            $total = $total->where('job_balance_transfer_requests.status', $request->is_active);
            $filteredq = $filteredq->where('job_balance_transfer_requests.status', $request->is_active);
            $query = $query->where('job_balance_transfer_requests.status', $request->is_active);
            $sumAmountQuery = $sumAmountQuery->where('job_balance_transfer_requests.status', $request->is_active);
        }

        if (isset($request->company) && $request->company != 'all') {
            $total = $total->where('companies.id', $request->company);
            $filteredq = $filteredq->where('companies.id', $request->company);
            $query = $query->where('companies.id', $request->company);
            $sumAmountQuery = $sumAmountQuery->where('companies.id', $request->company);
        }
        if (!empty($request->startDate) && !empty($request->endDate)) {
            $startDate = date($request->startDate);
            $endDate = date($request->endDate);
            $total = $total->where(function ($q) use ($startDate, $endDate) {
                $q->whereBetween('job_balance_transfer_requests.created_at', [$startDate, $endDate]);
            });
            $filteredq = $filteredq->where(function ($q) use ($startDate, $endDate) {
                $q->whereBetween('job_balance_transfer_requests.created_at', [$startDate, $endDate]);
            });
            $query = $query->where(function ($q) use ($startDate, $endDate) {
                $q->whereBetween('job_balance_transfer_requests.created_at', [$startDate, $endDate]);
            });
            $sumAmountQuery = $sumAmountQuery->where(function ($q) use ($startDate, $endDate) {
                $q->whereBetween('job_balance_transfer_requests.created_at', [$startDate, $endDate]);
            });
        }
        $total = $total->first();
        $totalfiltered = $total->total;

        if ($search != '') {
            $query->where(function ($query2) use ($search) {
                $query2->where('companies.name', 'like', '%' . $search . '%')
                    ->orWhere('FJ.title', 'like', '%' . $search . '%')
                    ->orWhere('TJ.title', 'like', '%' . $search . '%');
            });

            $filteredq->where(function ($query2) use ($search) {
                $query2->where('companies.name', 'like', '%' . $search . '%')
                    ->orWhere('FJ.title', 'like', '%' . $search . '%')
                    ->orWhere('TJ.title', 'like', '%' . $search . '%');
            });
            $sumAmountQuery->where(function ($query2) use ($search) {
                $query2->where('companies.name', 'like', '%' . $search . '%')
                    ->orWhere('FJ.title', 'like', '%' . $search . '%')
                    ->orWhere('TJ.title', 'like', '%' . $search . '%');
            });
            $filteredq = $filteredq->selectRaw('count(*) as total')->first();
            $totalfiltered = $filteredq->total;
        }



        /* $recordCount = $filteredq->selectRaw('count(*) as total')->first();
        $totalfiltered = $recordCount->total; */

        $sumAmountQuery = $sumAmountQuery->where('job_balance_transfer_requests.status', 1)->first();
        $sumAmount = $sumAmountQuery->sumAmount;
        if (empty($sumAmount))
            $sumAmount = 0;
        $query = $query->orderBy($orderby[$column], $order)->offset($start)->limit($length)->get();
        // $query = $query->offset($start)->limit($length)->get();
        // $firstname = Subscription::select('firstname')->leftJoin("users","subscriptions.customer_id","=","users.role_id")->first();
        //$duration = Subscription::select('duration')->leftJoin("subscription__plans", "subscriptions.subscription_plan","=","subscription__plans.id")->first();
        $data = [];
        foreach ($query as $key => $value) {
            $approve = $reject = $action = '';
            // admin_job_balance_transfer_requests_approve_reject
            if (whoCanCheck(config('app.arrWhoCanCheck'), 'admin_job_balance_transfer_requests_approve_reject')) {
                $approve = ($isEditable && $value->status != '2') ? '<li class="nav-item">'
                    . '<a class="nav-link approve-link" data-id="' . $value->id . '">Mark as Approve</a>'
                    . '</li>' : '';
    
                $reject = ($isDeletable && $value->status == '1') ? '<li class="nav-item">'
                    . '<a class="nav-link reject-link" data-id="' . $value->id . '">Mark as Reject</a>'
                    . '</li>' : '';
            }
            if ($approve || $reject) {
                $action .= '<div class="d-inline-block dropdown">'
                    . '<button type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" class="btn-shadow dropdown-toggle btn btn-primary">'
                    . '<span class="btn-icon-wrapper pr-2 opacity-7">'
                    . '<i class="fa fa-cog fa-w-20"></i>'
                    . '</span>'
                    . '</button>'
                    . '<div tabindex="-1" role="menu" aria-hidden="true" class="dropdown-menu dropdown-menu-right">'
                    . '<ul class="nav flex-column">'
                    . $approve . $reject
                    . '</ul>'
                    . '</div>'
                    . '</div>';
            }
            $data[] = [$action, $value->companyName, $value->fromJobTitle, $value->toJobTitle, $value->balance, $value->status, $value->reject_reason, getFormatedDate($value->created_at)];
        }
        $json_data = array(
            "draw" => intval($_REQUEST['draw']),
            "recordsTotal" => intval($total->total),
            "recordsFiltered" => intval($totalfiltered),
            "data" => $data,
            "sumAmount" => $sumAmount
        );
        return Response::json($json_data);
    }

    public function approve(Request $request)
    {
        $model = JobBalanceTransferRequests::where('id', $request->job_balance_id)->first();
        if (!empty($model)) {
            $model->updated_at = Carbon::now();
            $model->updated_by = Auth::guard('admin')->user()->id;
            $model->status = 2;
            if ($model->save()) {
                $toComponyJob = CompanyJob::where('id', $model->to_company_job_id)->where('company_id', $model->company_id)->whereNull('deleted_at')->first();
                $fromComponyJob = CompanyJob::where('id', $model->from_company_job_id)->where('company_id', $model->company_id)->whereNull('deleted_at')->first();
                $toComponyJob->balance = $toComponyJob->balance + $model->balance;
                $fromComponyJob->balance = $fromComponyJob->balance - $model->balance;
                if ($toComponyJob->save() && $fromComponyJob->save()) {
                    $code = 'JOBBALAPR';
                    $msg_type = 'Job Balance Update';
                    $msg = 'Your ' . $fromComponyJob->title . ' balance trasnfer request to ' . $toComponyJob->title . ' has been approved.';
                    $notification = insertNotification(1, $model->company_id, $code, $msg_type, $msg);
                }
            }
            $result['status'] = 'true';
            $result['msg'] = "Job balance transfer request approved successfully!";
            return $result;
        } else {
            $result['status'] = 'false';
            $result['msg'] = "Something went wrong!!";
            return $result;
        }
    }

    public function reject(Request $request)
    {
        $model = JobBalanceTransferRequests::where('id', $request->job_balance_id)->first();
        if (!empty($model)) {
            $model->updated_at = Carbon::now();
            $model->updated_by = Auth::guard('admin')->user()->id;
            $model->reject_reason = $request->reject_reason;
            $model->status = 3;
            if ($model->save()) {
                $toComponyJob = CompanyJob::where('id', $model->to_company_job_id)->where('company_id', $model->company_id)->whereNull('deleted_at')->first();
                $fromComponyJob = CompanyJob::where('id', $model->from_company_job_id)->where('company_id', $model->company_id)->whereNull('deleted_at')->first();
                $code = 'JOBBALRJC';
                $msg_type = 'Job Balance Update';
                $msg = "Your Job Balance Transfer request has been rejected. Reason for rejection is " . $request->reject_reason . '.';
                if (isset($toComponyJob) && isset($fromComponyJob)) {
                    $msg = 'Your ' . (isset($fromComponyJob) ? $fromComponyJob->title : "") . ' balance trasnfer request to ' . (isset($toComponyJob) ? $toComponyJob->title : "") . ' has been rejected.Reason for rejection is ' . $request->reject_reason . '.';
                }
                $notification = insertNotification(1, $model->company_id, $code, $msg_type, $msg);
            }
            $result['status'] = 'true';
            $result['msg'] = "Job balance transfer request rejected successfully!";
            return $result;
        } else {
            $result['status'] = 'false';
            $result['msg'] = "Something went wrong!!";
            return $result;
        }
    }
}
