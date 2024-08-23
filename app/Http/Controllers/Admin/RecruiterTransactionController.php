<?php

namespace App\Http\Controllers\Admin;

use App\Exports\RecruiterTransactionExport;
use App\Http\Controllers\Controller;
use App\Models\RecruiterTransaction;
use App\Models\SubscriptionPlan;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use Auth;
use DataTables;
use Carbon\Carbon;
use DB;
use Excel;
use Response;

class RecruiterTransactionController extends Controller
{
    public function index(Request $request)
    {
        $req = $request->all();
      //  $search = (isset($req['search']) ? $req['search'] : '');
        $subscriptions = SubscriptionPlan::getList('recruiter');
        return view("admin.recruiter-transaction.index",compact('subscriptions'));
    }
    public function list(Request $request)
    {
        $req = $request->all();
        $start = $req['start'];
        $length = $req['length'];
        $search = $req['search']['value'];
        $order = $req['order'][0]['dir'];
        $column = $req['order'][0]['column'];
        $orderby = ['name', 'email', 'phone', 'subscription_name','first_name','last_name','amount','status', 'payment_id','created_at'];
        $sumAmount=0;
        $sumAmountQuery=RecruiterTransaction::selectRaw('SUM(recruiter_transactions.amount) as sumAmount')
                                    ->leftJoin("subscription_plans", "recruiter_transactions.subscription_plan_id","subscription_plans.id")
                                    ->leftJoin("recruiters","recruiter_transactions.recruiter_id","recruiters.id")
                                    ->whereNull('recruiter_transactions.deleted_at');
        $total = RecruiterTransaction::selectRaw('count(*) as total')->whereNull('recruiter_transactions.deleted_at')->first();
        $query = RecruiterTransaction::select('recruiter_transactions.*','subscription_plans.subscription_name','users.firstname','users.lastname','recruiters.phone as rec_phone','recruiters.phone_ext as rec_phoneExt','users.email as user_email')
                                    ->leftJoin("subscription_plans", "recruiter_transactions.subscription_plan_id","subscription_plans.id")
                                    ->leftJoin("recruiters","recruiter_transactions.recruiter_id","recruiters.user_id")
                                    ->leftJoin("users","recruiter_transactions.recruiter_id","users.id")
                                    ->whereNull('recruiter_transactions.deleted_at');
        $filteredq =RecruiterTransaction::select('recruiter_transactions.*','subscription_plans.subscription_name','recruiters.first_name','recruiters.last_name','users.firstname','users.lastname','recruiters.phone as rec_phone','recruiters.phone_ext as rec_phoneExt','users.email as user_email')
                                    ->leftJoin("subscription_plans", "recruiter_transactions.subscription_plan_id","subscription_plans.id")
                                    ->leftJoin("recruiters","recruiter_transactions.recruiter_id","recruiters.user_id")
                                    ->leftJoin("users","recruiter_transactions.recruiter_id","users.id")
                                    ->whereNull('recruiter_transactions.deleted_at');
        $totalfiltered = $total->total;
        if ($search != '') {
          $query->where(function ($query2) use ($search) {
              $query2->where('recruiter_transactions.name', 'like', '%' . $search . '%')
                  ->orWhere('recruiter_transactions.email', 'like', '%' . $search . '%')
                  ->orWhere('recruiter_transactions.phone', 'like', '%' . $search . '%')
                  ->orWhere('recruiter_transactions.invoice_number', 'like', '%' . $search . '%')
                  ->orWhere('recruiter_transactions.amount', 'like', '%' . $search . '%');
          });
          $filteredq->where(function ($query2) use ($search) {
            $query2->where('name', 'like', '%' . $search . '%')
            ->orWhere('recruiter_transactions.email', 'like', '%' . $search . '%')
            ->orWhere('recruiter_transactions.recruiter_transactions.phone', 'like', '%' . $search . '%')
            ->orWhere('recruiter_transactions.invoice_number', 'like', '%' . $search . '%')
            ->orWhere('recruiter_transactions.amount', 'like', '%' . $search . '%');
          });
          $sumAmountQuery->where(function ($query2) use ($search) {
              $query2->where('recruiter_transactions.name', 'like', '%' . $search . '%')
                  ->orWhere('recruiter_transactions.email', 'like', '%' . $search . '%')
                  ->orWhere('recruiter_transactions.phone', 'like', '%' . $search . '%')
                  ->orWhere('recruiter_transactions.invoice_number', 'like', '%' . $search . '%')
                  ->orWhere('recruiter_transactions.amount', 'like', '%' . $search . '%');
          });
            $filteredq = $filteredq->selectRaw('count(*) as total')->first();
            $totalfiltered = $filteredq->total;
        }
        if (isset($request->is_active)) {
            $filteredq = $filteredq->where('recruiter_transactions.status', $request->is_active);
            $query = $query->where('recruiter_transactions.status', $request->is_active);
            $sumAmountQuery = $sumAmountQuery->where('recruiter_transactions.status', $request->is_active);
            $recordCount = $filteredq->selectRaw('count(*) as total')->first();
            $totalfiltered = $recordCount->total;
        }
        if (isset($request->plan) && $request->plan!='all') {
            $filteredq = $filteredq->where('recruiter_transactions.subscription_plan_id', $request->plan);
            $query = $query->where('recruiter_transactions.subscription_plan_id', $request->plan);
            $sumAmountQuery = $sumAmountQuery->where('recruiter_transactions.subscription_plan_id', $request->plan);
            $recordCount = $filteredq->selectRaw('count(*) as total')->first();
            $totalfiltered = $recordCount->total;
        }
        if (!empty($request->startDate) && !empty($request->endDate)) {
            $startDate = date($request->startDate);
            $endDate = date($request->endDate);
            $filteredq = $filteredq->where(function($q) use ($startDate,$endDate){
                $q->whereBetween('recruiter_transactions.created_at', [$startDate, $endDate]);
            });
            $query = $query->where(function($q) use ($startDate,$endDate){
                $q->whereBetween('recruiter_transactions.created_at', [$startDate, $endDate]);
            });
            $sumAmountQuery = $sumAmountQuery->where(function($q) use ($startDate,$endDate){
                $q->whereBetween('recruiter_transactions.created_at', [$startDate, $endDate]);
            });
            $recordCount = $filteredq->selectRaw('count(*) as total')->first();
            $totalfiltered = $recordCount->total;
        }
        $sumAmountQuery=$sumAmountQuery->where('recruiter_transactions.status',1)->first();
        $sumAmount=$sumAmountQuery->sumAmount;
        if(empty($sumAmount))
        $sumAmount=0;
       $query = $query->orderBy($orderby[$column], $order)->offset($start)->limit($length)->get();
        // $query = $query->offset($start)->limit($length)->get();
        // $firstname = Subscription::select('firstname')->leftJoin("users","subscriptions.customer_id","=","users.role_id")->first();
        //$duration = Subscription::select('duration')->leftJoin("subscription__plans", "subscriptions.subscription_plan","=","subscription__plans.id")->first();
        $data = [];
        //dd($data);
        foreach ($query as $key => $value)
        {
            $data[] = [$value->name, $value->user_email,$value->rec_phoneExt.'-'.$value->rec_phone,$value->subscription_name,$value->firstname.' '.$value->lastname,$value->amount, $value->invoice_number,$value->payment_status ,getFormatedDate($value->created_at)];
        }
        $json_data = array(
            "draw" => intval($_REQUEST['draw']),
            "recordsTotal" => intval($total->total),
            "recordsFiltered" => intval($totalfiltered),
            "data" => $data,
            "sumAmount"=>$sumAmount,
        );
        return Response::json($json_data);
    }

     public function exportRecruiterTransaction(Request $request)
    {
        try{
            return Excel::download(new RecruiterTransactionExport(), 'ReqCity_Recruiter_Transaction.xlsx');
        } catch(\Exception $ex) {
            return view('errors.500');
        }
    }

}
