<?php

namespace App\Http\Controllers\Admin;

use App\Exports\CompanyTransactionExport;
use App\Http\Controllers\Controller;
use App\Models\CompanyTransaction;
use App\Models\SubscriptionPlan;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use Auth;
use DataTables;
use Carbon\Carbon;
use DB;
use Excel;
use Response;

class CompanyTransactionController extends Controller
{
    public function index(Request $request)
    {
        $req = $request->all();
        //  $search = (isset($req['search']) ? $req['search'] : '');
        $subscriptions = SubscriptionPlan::getList('company');
        return view("admin.company-transaction.index", compact('subscriptions'));
    }
    public function list(Request $request)
    {
        $req = $request->all();
        $start = $req['start'];
        $length = $req['length'];
        $search = $req['search']['value'];
        $order = $req['order'][0]['dir'];
        $column = $req['order'][0]['column'];
        $orderby = ['name', 'email', 'phone', 'subscription_name', 'companyName', 'amount', 'status', 'payment_id', 'created_at'];
        $sumAmount = 0;
        $sumAmountQuery = CompanyTransaction::selectRaw('SUM(company_transactions.amount) as sumAmount')
            ->leftJoin("subscription_plans", "company_transactions.subscription_plan_id", "subscription_plans.id")
            ->leftJoin("companies", "company_transactions.company_id", "companies.id")
            ->whereNull('company_transactions.deleted_at');

        $total = CompanyTransaction::selectRaw('count(*) as total')->whereNull('company_transactions.deleted_at')->first();

        $query = CompanyTransaction::select('company_transactions.*', 'subscription_plans.subscription_name', 'companies.name as companyName', 'company_user.phone as userPhone', 'company_user.phone_ext as userPhonePrefix')
            ->leftJoin("subscription_plans", "company_transactions.subscription_plan_id", "subscription_plans.id")
            ->leftJoin("companies", "company_transactions.company_id", "companies.user_id")
            ->leftJoin("users", "company_transactions.company_id", "users.id")
            ->leftJoin("company_user", "company_user.user_id", "users.id")
            ->whereNull('company_transactions.deleted_at');

        $filteredq = CompanyTransaction::leftJoin("subscription_plans", "company_transactions.subscription_plan_id", "subscription_plans.id")
            ->leftJoin("companies", "company_transactions.company_id", "companies.user_id")
            ->leftJoin("users", "company_transactions.company_id", "users.id")
            ->leftJoin("company_user", "company_user.user_id", "users.id")
            ->whereNull('company_transactions.deleted_at');
            
        $totalfiltered = $total->total;
        if ($search != '') {
            $query->where(function ($query2) use ($search) {
                $query2->where('company_transactions.name', 'like', '%' . $search . '%')
                    ->orWhere('company_transactions.email', 'like', '%' . $search . '%')
                    ->orWhere('company_transactions.phone', 'like', '%' . $search . '%')
                    ->orWhere('company_transactions.invoice_number', 'like', '%' . $search . '%')
                    ->orWhere('company_transactions.amount', 'like', '%' . $search . '%');
            });
            $filteredq->where(function ($query2) use ($search) {
                $query2->where('company_transactions.name', 'like', '%' . $search . '%')
                    ->orWhere('company_transactions.email', 'like', '%' . $search . '%')
                    ->orWhere('company_transactions.phone', 'like', '%' . $search . '%')
                    ->orWhere('company_transactions.invoice_number', 'like', '%' . $search . '%')
                    ->orWhere('company_transactions.amount', 'like', '%' . $search . '%');
            });
            $sumAmountQuery->where(function ($query2) use ($search) {
                $query2->where('company_transactions.name', 'like', '%' . $search . '%')
                    ->orWhere('company_transactions.email', 'like', '%' . $search . '%')
                    ->orWhere('company_transactions.phone', 'like', '%' . $search . '%')
                    ->orWhere('company_transactions.paymeninvoice_numbert_id', 'like', '%' . $search . '%')
                    ->orWhere('company_transactions.amount', 'like', '%' . $search . '%');
            });
            $filteredq = $filteredq->selectRaw('count(*) as total')->first();
            $totalfiltered = $filteredq->total;
        }
        if (isset($request->is_active)) {
            $filteredq = $filteredq->where('company_transactions.status', $request->is_active);
            $query = $query->where('company_transactions.status', $request->is_active);
            $sumAmountQuery = $sumAmountQuery->where('company_transactions.status', $request->is_active);
        }
        if (isset($request->plan) && $request->plan != 'all') {
            $filteredq = $filteredq->where('company_transactions.subscription_plan_id', $request->plan);
            $query = $query->where('company_transactions.subscription_plan_id', $request->plan);
            $sumAmountQuery = $sumAmountQuery->where('company_transactions.subscription_plan_id', $request->plan);
        }
        if (!empty($request->startDate) && !empty($request->endDate)) {
            $startDate = date($request->startDate);
            $endDate = date($request->endDate);
            $filteredq = $filteredq->where(function ($q) use ($startDate, $endDate) {
                $q->whereBetween('company_transactions.created_at', [$startDate, $endDate]);
            });
            $query = $query->where(function ($q) use ($startDate, $endDate) {
                $q->whereBetween('company_transactions.created_at', [$startDate, $endDate]);
            });
            $sumAmountQuery = $sumAmountQuery->where(function ($q) use ($startDate, $endDate) {
                $q->whereBetween('company_transactions.created_at', [$startDate, $endDate]);
            });
        }
        $sumAmountQuery = $sumAmountQuery->where('company_transactions.status', 1)->first();
        $sumAmount = $sumAmountQuery->sumAmount;
        if (empty($sumAmount))
            $sumAmount = 0;
        $recordCount = $filteredq->selectRaw('count(*) as total')->first();
        $totalfiltered = $recordCount->total;
        $query = $query->orderBy($orderby[$column], $order)->offset($start)->limit($length)->get();
        // $query = $query->offset($start)->limit($length)->get();
        // $firstname = Subscription::select('firstname')->leftJoin("users","subscriptions.customer_id","=","users.role_id")->first();
        //$duration = Subscription::select('duration')->leftJoin("subscription__plans", "subscriptions.subscription_plan","=","subscription__plans.id")->first();
        $data = [];
        foreach ($query as $key => $value) {
            $data[] = [$value->name, $value->email, $value->userPhonePrefix . '-' . $value->userPhone, $value->subscription_name, $value->companyName, $value->amount, $value->invoice_number, $value->payment_status, getFormatedDate($value->created_at)];
        }
        $json_data = array(
            "draw" => intval($_REQUEST['draw']),
            "recordsTotal" => intval($total->total),
            "recordsFiltered" => intval($totalfiltered),
            "data" => $data,
            'sumAmount' => $sumAmount
        );
        return Response::json($json_data);
    }

    public function exportCompanyTransaction(Request $request)
    {
        try {
            return Excel::download(new CompanyTransactionExport(), 'ReqCity_Company_Transaction.xlsx');
        } catch (\Exception $ex) {
            return view('errors.500');
        }
    }
}
