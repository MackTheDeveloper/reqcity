<?php

namespace App\Http\Controllers\Admin;

use App\Exports\CompanyJobFundingExport;
use App\Http\Controllers\Controller;
use App\Models\CompanyJobFunding;
use App\Models\CompanyJob;
use App\Models\SubscriptionPlan;
use App\Models\Companies;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use Auth;
use DataTables;
use Carbon\Carbon;
use DB;
use Excel;
use Response;

class CompanyJobFundingController extends Controller
{
    public function index(Request $request)
    {
        $req = $request->all();
      //  $search = (isset($req['search']) ? $req['search'] : '');
        $company = Companies::getList();
        return view("admin.company-job-funding.index",compact('company'));
    }
    public function list(Request $request)
    {
        // dd($request);
        $req = $request->all();
        $start = $req['start'];
        $length = $req['length'];
        $search = $req['search']['value'];
        $order = $req['order'][0]['dir'];
        $column = $req['order'][0]['column'];
        $orderby = ['companyName','jobTitle','amount', 'payment_id','status','created_at'];
        $sumAmount=0;
        $sumAmountQuery= CompanyJobFunding::selectRaw('SUM(company_job_funding.amount) as sumAmount')
                                    ->leftJoin("company_jobs", "company_job_funding.company_job_id","company_jobs.id")
                                    ->leftJoin("companies","company_job_funding.company_id","companies.id")
                                    ->whereNull('company_job_funding.deleted_at');
        $total = CompanyJobFunding::selectRaw('count(*) as total')->whereNull('company_job_funding.deleted_at')->first();
        $query = CompanyJobFunding::select('company_job_funding.*','companies.name as companyName','company_jobs.title as jobTitle')
                                    ->leftJoin("company_jobs", "company_job_funding.company_job_id","company_jobs.id")
                                    ->leftJoin("companies","company_job_funding.company_id","companies.id")
                                    ->whereNull('company_job_funding.deleted_at');

        $filteredq = CompanyJobFunding::select('company_job_funding.*','companies.name as companyName','company_jobs.title as jobTitle')
                                    ->leftJoin("company_jobs", "company_job_funding.company_job_id","company_jobs.id")
                                    ->leftJoin("companies","company_job_funding.company_id","companies.id")
                                    ->whereNull('company_job_funding.deleted_at');
        $totalfiltered = $total->total;
        if ($search != '') {
            $query->where(function ($query2) use ($search) {
                $query2->where('companies.name', 'like', '%' . $search . '%')
                    ->orWhere('company_jobs.title', 'like', '%' . $search . '%')
                    ->orWhere('company_job_funding.payment_id', 'like', '%' . $search . '%');
            });

            $filteredq->where(function ($query2) use ($search) {
                $query2->where('companies.name', 'like', '%' . $search . '%')
                ->orWhere('company_jobs.title', 'like', '%' . $search . '%')
                ->orWhere('company_job_funding.payment_id', 'like', '%' . $search . '%');
            });
            $sumAmountQuery->where(function ($query2) use ($search) {
                $query2->where('companies.name', 'like', '%' . $search . '%')
                    ->orWhere('company_jobs.title', 'like', '%' . $search . '%')
                    ->orWhere('company_job_funding.payment_id', 'like', '%' . $search . '%');
            });
            $filteredq = $filteredq->selectRaw('count(*) as total')->first();
            $totalfiltered = $filteredq->total;
        }
        if (isset($request->is_active)) {
            $filteredq = $filteredq->where('company_job_funding.status', $request->is_active);
            $query = $query->where('company_job_funding.status', $request->is_active);
            $sumAmountQuery = $sumAmountQuery->where('company_job_funding.status', $request->is_active);
        }
        if (isset($request->company) && $request->company!='all') {
            $filteredq = $filteredq->where('companies.id', $request->company);
            $query = $query->where('companies.id', $request->company);
            $sumAmountQuery = $sumAmountQuery->where('companies.id', $request->company);
        }
        if (!empty($request->startDate) && !empty($request->endDate)) {
            $startDate = date($request->startDate);
            $endDate = date($request->endDate);
            $filteredq = $filteredq->where(function($q) use ($startDate,$endDate){
                $q->whereBetween('company_job_funding.created_at', [$startDate, $endDate]);
            });
            $query = $query->where(function($q) use ($startDate,$endDate){
                $q->whereBetween('company_job_funding.created_at', [$startDate, $endDate]);
            });
            $sumAmountQuery = $sumAmountQuery->where(function($q) use ($startDate,$endDate){
                $q->whereBetween('company_job_funding.created_at', [$startDate, $endDate]);
            });
            $recordCount = $filteredq->selectRaw('count(*) as total')->first();
            $totalfiltered = $recordCount->total;
        }

        $sumAmountQuery=$sumAmountQuery->where('company_job_funding.status',1)->first();
        $sumAmount=$sumAmountQuery->sumAmount;
        if(empty($sumAmount))
        $sumAmount=0;
        $query = $query->orderBy($orderby[$column], $order)->offset($start)->limit($length)->get();
        // $query = $query->offset($start)->limit($length)->get();
        // $firstname = Subscription::select('firstname')->leftJoin("users","subscriptions.customer_id","=","users.role_id")->first();
        //$duration = Subscription::select('duration')->leftJoin("subscription__plans", "subscriptions.subscription_plan","=","subscription__plans.id")->first();
        $data = [];
        foreach ($query as $key => $value)
        {
            $data[] = [$value->companyName, $value->jobTitle, $value->amount,$value->payment_id,$value->status,getFormatedDate($value->created_at)];
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

     public function exportCompanyJobFunding(Request $request)
    {
        try{
            return Excel::download(new CompanyJobFundingExport(), 'ReqCity_Company_Job_Funds.xlsx');
        } catch(\Exception $ex) {
            return view('errors.500');
        }
    }

}
