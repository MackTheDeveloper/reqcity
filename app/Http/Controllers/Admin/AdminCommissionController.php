<?php

namespace App\Http\Controllers\Admin;

use App\Exports\AdminCommissionExport;
use App\Http\Controllers\Controller;
use App\Models\AdminCommission;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use Auth;
use DataTables;
use Carbon\Carbon;
use DB;
use Excel;
use Response;
use DateTime;
use DatePeriod;
use DateInterval;
use Symfony\Component\Console\Input\Input;

class AdminCommissionController extends Controller
{
    public function index(Request $request)
    {
        $req = $request->all();
      //  $search = (isset($req['search']) ? $req['search'] : '');
        $company = AdminCommission::getCompanyList();
        return view("admin.admin-commission.index",compact('company'));
    }
    public function list(Request $request)
    {
        $req = $request->all();
        $start = $req['start'];
        $length = $req['length'];
        $search = $req['search']['value'];
        $order = $req['order'][0]['dir'];
        $column = $req['order'][0]['column'];
        $orderby = ['id','companyName','jobTitle','jobPosted','amount', 'created_at',];
        $sumAmount=0;
        $sumAmountQuery=AdminCommission::selectRaw('SUM(company_job_commission.amount) as sumAmount')
                                    ->leftJoin("company_jobs", "company_job_commission.company_job_id","company_jobs.id")
                                    ->leftJoin("companies","company_jobs.company_id","companies.id")
                                    ->leftJoin("company_job_applications","company_job_commission.company_job_application_id","company_job_applications.id")
                                    ->where('company_job_commission.type',2)
                                    ->whereNull('company_job_commission.deleted_at');
        $total = AdminCommission::selectRaw('count(*) as total')
                    ->where('company_job_commission.type',2)
                    ->whereNull('company_job_commission.deleted_at')
                    ->first();
        $query = AdminCommission::select('company_job_commission.*','companies.name as companyName','company_jobs.title as jobTitle','company_job_applications.created_at as jobPosted')
                                    ->leftJoin("company_jobs", "company_job_commission.company_job_id","company_jobs.id")
                                    ->leftJoin("companies","company_jobs.company_id","companies.id")
                                    ->leftJoin("company_job_applications","company_job_commission.company_job_application_id","company_job_applications.id")
                                    ->where('company_job_commission.type',2)
                                    ->whereNull('company_job_commission.deleted_at');

        $filteredq = AdminCommission::select('company_job_commission.*','companies.name as companyName','company_jobs.title as jobTitle','company_job_applications.created_at')
                                    ->leftJoin("company_jobs", "company_job_commission.company_job_id","company_jobs.id")
                                    ->leftJoin("companies","company_jobs.company_id","companies.id")
                                    ->leftJoin("company_job_applications","company_job_commission.company_job_application_id","company_job_applications.id")
                                    ->where('company_job_commission.type',2)
                                    ->whereNull('company_job_commission.deleted_at');

        $totalfiltered = $total->total;
        if ($search != '') {
            $query->where(function ($query2) use ($search) {
                $query2->where('companies.name', 'like', '%' . $search . '%')
                    ->orWhere('company_jobs.title', 'like', '%' . $search . '%');
            });

            $filteredq->where(function ($query2) use ($search) {
                $query2->where('companies.name', 'like', '%' . $search . '%')
                    ->orWhere('company_jobs.title', 'like', '%' . $search . '%');
            });
            $sumAmountQuery->where(function ($query2) use ($search) {
                $query2->where('companies.name', 'like', '%' . $search . '%')
                    ->orWhere('company_jobs.title', 'like', '%' . $search . '%');
            });
        }

        if (isset($request->company) && $request->company!='all') {
            $filteredq = $filteredq->where('companies.id', $request->company);
            $query = $query->where('companies.id', $request->company);
            $sumAmountQuery = $sumAmountQuery->where('companies.id', $request->company);
        }

        if (!empty($request->startDate) && !empty($request->endDate)) {
            $startDate = date($request->startDate);
            $endDate = date($request->endDate);
            $newDate = new DateTime($endDate);
            $newDate->add(new DateInterval('P1D'));

            $filteredq = $filteredq->where(function($q) use ($startDate,$newDate){
                $q->whereBetween('company_job_commission.created_at', [$startDate, $newDate]);
            });
            $query = $query->where(function($q) use ($startDate,$newDate){
                $q->whereBetween('company_job_commission.created_at', [$startDate, $newDate]);
            });
            $sumAmountQuery = $sumAmountQuery->where(function($q) use ($startDate,$newDate){
                $q->whereBetween('company_job_commission.created_at', [$startDate, $newDate]);
            });
            $recordCount = $filteredq->selectRaw('count(*) as total')->first();
            $totalfiltered = $recordCount->total;
        }
        $sumAmountQuery=$sumAmountQuery->first();
        $sumAmount=$sumAmountQuery->sumAmount;
        $query = $query->orderBy($orderby[$column], $order)->offset($start)->limit($length)->get();
        // $query = $query->offset($start)->limit($length)->get();
        // $firstname = Subscription::select('firstname')->leftJoin("users","subscriptions.customer_id","=","users.role_id")->first();
        //$duration = Subscription::select('duration')->leftJoin("subscription__plans", "subscriptions.subscription_plan","=","subscription__plans.id")->first();
        $data = [];
        foreach ($query as $key => $value)
        {
            $data[] = [$value->id,$value->companyName, $value->jobTitle,getFormatedDate($value->jobPosted),$value->amount,getFormatedDate($value->created_at)];
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

     public function exportAdminCommission(Request $request)
    {
        try{
            return Excel::download(new AdminCommissionExport(), 'ReqCity_Admin_Commission.xlsx');
        } catch(\Exception $ex) {
            return view('errors.500');
        }
    }

}
