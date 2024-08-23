<?php

namespace App\Http\Controllers\Admin;

use App\Exports\CompanySubscriptionExport;
use App\Exports\UsersExport;
use App\Http\Controllers\Controller;
use App\Models\Fan;
use App\Models\FanPlaylist;
use App\Models\FanPlaylistSongs;
use App\Models\CompanySubscription;
use App\Models\SubscriptionPlan;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use Auth;
use DataTables;
use App\Models\GlobalCurrency;
use App\Models\CmsPages;
use App\Models\CurrencyConversionRate;
use Carbon\Carbon;
use DB;
use Excel;
use Response;

class CompanySubscriptionController extends Controller
{
    public function index(Request $request)
    {
        $req = $request->all();
        $subscriptions = SubscriptionPlan::getList();
        $search = (isset($req['search']) ? $req['search'] : '');
        return view("admin.company_subscription.index",compact('subscriptions','search'));
    }
    public function list(Request $request)
    {
        $req = $request->all();
        $start = $req['start'];
        $length = $req['length'];
        $search = $req['search']['value'];
        $order = $req['order'][0]['dir'];
        $column = $req['order'][0]['column'];
        $orderby = ['companies.name', 'company_subscription.email','','','subscription_plans.price','','subscription_number','created_at'];
        $sumAmount=0;
        $sumAmountQuery=CompanySubscription::selectRaw('SUM(company_subscription.amount) as sumAmount')
                                            ->leftJoin("subscription_plans", "company_subscription.plan_id","subscription_plans.id")
                                            ->leftJoin("companies","company_subscription.company_id","companies.id")
                                            ->whereNull('company_subscription.deleted_at');
        $total = CompanySubscription::selectRaw('count(*) as total')->whereNull('company_subscription.deleted_at')->first();
        
        $query = CompanySubscription::select('company_subscription.*','companies.name','companies.phone as phone','company_subscription.plan_type','company_subscription.amount',
            'company_subscription.status as status','company_subscription.plan_type as subscription_name','payment_id','company_subscription.created_at')
            ->leftJoin("subscription_plans", "company_subscription.plan_id","subscription_plans.id")
            ->leftJoin("companies","company_subscription.company_id","companies.user_id")
            ->whereNull('company_subscription.deleted_at');
        $filteredq = CompanySubscription::whereNull('company_subscription.deleted_at')->leftJoin("subscription_plans", "company_subscription.plan_id","=","subscription_plans.id")
            ->leftJoin("companies","company_subscription.company_id","=","companies.id");
        $totalfiltered = $total->total;
        if ($search != '') {
            $query->where(function ($query2) use ($search) {
                $query2->where('companies.name', 'like', '%' . $search . '%')
                    ->orWhere('company_subscription.email', 'like', '%' . $search . '%')
                    ->orWhere('company_subscription.created_at', 'like', '%' . $search . '%')
                    ->orWhere('company_subscription.subscription_number', 'like', '%' . $search . '%');

            });
            $filteredq->where(function ($query2) use ($search) {
                $query2->where('companies.name', 'like', '%' . $search . '%')
                    ->orWhere('company_subscription.email', 'like', '%' . $search . '%')
                    ->orWhere('company_subscription.created_at', 'like', '%' . $search . '%')
                    ->orWhere('company_subscription.subscription_number', 'like', '%' . $search . '%');
            });
            $sumAmountQuery->where(function ($query2) use ($search) {
                $query2->where('companies.name', 'like', '%' . $search . '%')
                    ->orWhere('company_subscription.email', 'like', '%' . $search . '%')
                    ->orWhere('company_subscription.created_at', 'like', '%' . $search . '%')
                    ->orWhere('company_subscription.subscription_number', 'like', '%' . $search . '%');
            });
            $filteredq = $filteredq->selectRaw('count(*) as total')->first();
            $totalfiltered = $filteredq->total;
        }
        if (isset($request->is_active)) {
            $filteredq = $filteredq->where('company_subscription.status', $request->is_active);
            $query = $query->where('company_subscription.status', $request->is_active);
            $sumAmountQuery = $sumAmountQuery->where('company_subscription.status', $request->is_active);
            // dd($query);
        }
        if (isset($request->subscription) && $request->subscription!='all') {
            $filteredq = $filteredq->where('company_subscription.plan_type', $request->subscription);
            $query = $query->where('company_subscription.plan_type', $request->subscription);
            $sumAmountQuery = $sumAmountQuery->where('company_subscription.plan_type', $request->subscription);
        }
        if (!empty($request->startDate) && !empty($request->endDate)) {
            $startDate = date($request->startDate);
            $endDate = date($request->endDate);
            $filteredq = $filteredq->where(function($q) use ($startDate,$endDate){
                $q->whereBetween('company_subscription.created_at', [$startDate, $endDate]);
            });
            $query = $query->where(function($q) use ($startDate,$endDate){
                $q->whereBetween('company_subscription.created_at', [$startDate, $endDate]);
            });
            $sumAmountQuery = $sumAmountQuery->where(function($q) use ($startDate,$endDate){
                $q->whereBetween('company_subscription.created_at', [$startDate, $endDate]);
            });
            $recordCount = $filteredq->selectRaw('count(*) as total')->first();
            $totalfiltered = $recordCount->total;
        }
       $sumAmountQuery=$sumAmountQuery->where('company_subscription.status',1)->first();
       $sumAmount=$sumAmountQuery->sumAmount;
       if(empty($sumAmount))
       $sumAmount=0;
       $query = $query->orderBy($orderby[$column], $order)->offset($start)->limit($length)->get();
        // $query = $query->offset($start)->limit($length)->get();
        // $firstname = Subscription::select('firstname')->leftJoin("users","subscriptions.customer_id","=","users.role_id")->first();
        $duration = CompanySubscription::select('company_subscription.plan_type')->leftJoin("subscription_plans", "company_subscription.plan_id","=","subscription_plans.id")->first();
        $data = [];
        foreach ($query as $key => $value)
        {
            $data[] = [$value->name, $value->email, $value->phone,$value->subscription_name , $value->amount, $value->status,($value->subscription_number)?:"-" ,getFormatedDate($value->created_at)];
        }
        $json_data = array(
            "draw" => intval($_REQUEST['draw']),
            "recordsTotal" => intval($total->total),
            "recordsFiltered" => intval($totalfiltered),
            "data" => $data,
            "sumAmount"=>$sumAmount
        );
        return Response::json($json_data);
    }

     public function exportCompanySubscription(Request $request)
    {
        try{
            return Excel::download(new CompanySubscriptionExport(), 'Reqcity_Company_Subscription.xlsx');
        } catch(\Exception $ex) {
            return view('errors.500');
        }
    }

}
