<?php

namespace App\Http\Controllers\FrontEnd\Recruiter;

use App\Http\Controllers\Controller;
use App\Models\AdminCommission;
use App\Models\Recruiter;
use App\Models\RecruiterPayouts;
use App\Models\RecruiterTransaction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use App\Models\User;
use Exception;
use Auth;
use Response;
use Illuminate\Support\Facades\Session;
use Illuminate\Routing\Route;
use Illuminate\Support\Facades\URL;

class RecruiterPaymentController extends Controller
{
    public function index(Request $request)
    {
        $authId = Auth::user()->id;
        $recruiter = Recruiter::where('user_id',$authId)->first();
        $recruiterId = $recruiter->id;
        $total = AdminCommission::getPayoutTotal($recruiterId);
        return view('frontend.recruiter.payment.index',compact('total'));
    }

    public function list(Request $request)
    {
        $req = $request->all();
        $page = !empty($req['page'])? $req['page']:1;
        if ($page) {
            $length = \Config::get('app.dataTable')['length'];
            $start = ($page - 1) * $length;
        }
        // $start = !empty($req['start'])? $req['start']:0;
        // $length = !empty($req['length'])? $req['length']:2;
        $search = "";//$req['search']['value'];
        // $order = $req['order'][0]['dir'];
        // $column = $req['order'][0]['column'];
        // $orderby = ['id','','first_name','email','phone','job_title','country','state','city','postcode','','status','created_at'];
        $userId = Auth::user()->id;

        $total = RecruiterTransaction::selectRaw('count(*) as total')->has('SubscriptionPlan')->where('recruiter_id', '=', $userId)->first();
        // pre($total);

        $query = RecruiterTransaction::has('SubscriptionPlan')
            ->where('recruiter_id', $userId)
            ->whereNull('deleted_at');

        $filteredq = RecruiterTransaction::has('SubscriptionPlan')
            ->where('recruiter_id', $userId)
            ->whereNull('deleted_at');

        $totalfiltered = $total->total;
        // if ($search != '') {
        //     $query->where(function ($query2) use ($search) {
        //         $query2->where('subscription_plans.subscription_name', 'like', '%' . $search . '%')
        //             ->orWhere('company_transactions.invoice_id', 'like', '%' . $search . '%');
        //     });

        //     $filteredq->where(function ($query2) use ($search) {
        //         $query2->where('subscription_plans.subscription_name', 'like', '%' . $search . '%')
        //         ->orWhere('company_transactions.invoice_id', 'like', '%' . $search . '%');
        //     });

        //     $filteredq = $filteredq->selectRaw('count(*) as total')->first();
        //     $totalfiltered = $filteredq->total;
        // }
        if (!empty($request->startDate) && !empty($request->endDate)) {
            $startDate = $request->startDate;
            // dd($startDate);
            $endDate = $request->endDate;
            $filteredq = $filteredq->where(function($q) use ($startDate,$endDate){
                $q->whereBetween('invoice_date', [$startDate, $endDate]);
            });
            $query = $query->where(function($q) use ($startDate,$endDate){
                $q->whereBetween('invoice_date', [$startDate, $endDate]);
            });
            $recordCount = $filteredq->selectRaw('count(*) as total')->first();
            $totalfiltered = $recordCount->total;
        }
        //$query = $query->orderBy($orderby[$column], $order)->offset($start)->limit($length)->get();
        $query = $query->offset($start)->limit($length)->get();

        // $firstname = Subscription::select('firstname')->leftJoin("users","subscriptions.customer_id","=","users.role_id")->first();
        //$duration = Subscription::select('duration')->leftJoin("subscription__plans", "subscriptions.subscription_plan","=","subscription__plans.id")->first();

        // pre($query);
        $data = [];
        foreach ($query as $key => $value) {
            // $data[] = [getFormatedDate($value->created_at), 'Paid for' . $value->subscriptionPlan->subscription_name . 'Subscription', $value->invoice_id];
            $data[] = [
                "date" => getFormatedDate($value->invoice_date,'d M Y'),
                "description" => 'Paid for ' . $value->subscriptionPlan->subscription_name . ' Subscription',
                "amount" => getFormatedAmount($value->amount, 2),
                "invoice" => "<a href='". $value->invoice_pdf_url."' target='_blank'>". $value->invoice_number."</a>"
            ];
        }
        $json_data = array(
            "recordsTotal" => intval($total->total),
            "recordsFiltered" => intval($totalfiltered),
            "recordPerPage" => $length,
            "currentPage" => $page,
            "data" => $data,
        );
        return Response::json($json_data);
    }

    public function recruiterPayoutList(Request $request)
    {
        $req = $request->all();
        $page = !empty($req['page'])? $req['page']:1;
        if ($page) {
            $length = \Config::get('app.dataTable')['length'];
            $start = ($page - 1) * $length;
        }
        // $start = !empty($req['start'])? $req['start']:0;
        // $length = !empty($req['length'])? $req['length']:2;
        $search = "";//$req['search']['value'];
        // $order = $req['order'][0]['dir'];
        // $column = $req['order'][0]['column'];
        // $orderby = ['id','','first_name','email','phone','job_title','country','state','city','postcode','','status','created_at'];
        $userId = Auth::user()->id;
        $recruiter = Recruiter::where('user_id',$userId)->first();
        $recruiterId = $recruiter->id;

        $total = RecruiterPayouts::selectRaw('count(*) as total')->where('recruiter_id', '=', $recruiterId)->first();
        // pre($total);

        $query = RecruiterPayouts::where('recruiter_id', $recruiterId)
            ->whereNull('deleted_at');

        $filteredq = RecruiterPayouts::where('recruiter_id', $recruiterId)
        ->whereNull('deleted_at');

        $totalfiltered = $total->total;
        // if ($search != '') {
        //     $query->where(function ($query2) use ($search) {
        //         $query2->where('subscription_plans.subscription_name', 'like', '%' . $search . '%')
        //             ->orWhere('company_transactions.invoice_id', 'like', '%' . $search . '%');
        //     });

        //     $filteredq->where(function ($query2) use ($search) {
        //         $query2->where('subscription_plans.subscription_name', 'like', '%' . $search . '%')
        //         ->orWhere('company_transactions.invoice_id', 'like', '%' . $search . '%');
        //     });

        //     $filteredq = $filteredq->selectRaw('count(*) as total')->first();
        //     $totalfiltered = $filteredq->total;
        // }
        if (!empty($request->startDate) && !empty($request->endDate)) {
            $startDate = $request->startDate;
            // dd($startDate);
            $endDate = $request->endDate;
            $filteredq = $filteredq->where(function($q) use ($startDate,$endDate){
                $q->whereBetween('created_at', [$startDate, $endDate]);
            });
            $query = $query->where(function($q) use ($startDate,$endDate){
                $q->whereBetween('created_at', [$startDate, $endDate]);
            });
            $recordCount = $filteredq->selectRaw('count(*) as total')->first();
            $totalfiltered = $recordCount->total;
        }
        //$query = $query->orderBy($orderby[$column], $order)->offset($start)->limit($length)->get();
        $query = $query->offset($start)->limit($length)->get();

        // $firstname = Subscription::select('firstname')->leftJoin("users","subscriptions.customer_id","=","users.role_id")->first();
        //$duration = Subscription::select('duration')->leftJoin("subscription__plans", "subscriptions.subscription_plan","=","subscription__plans.id")->first();

        // pre($query);
        $data = [];
        foreach ($query as $key => $value) {
            // $data[] = [getFormatedDate($value->created_at), 'Paid for' . $value->subscriptionPlan->subscription_name . 'Subscription', $value->invoice_id];
            $data[] = [
                "date" => getFormatedDate($value->created_at,'d M Y'),
                "description" => 'Payout for your candidate submittals',
                "amount" => number_format((float)$value->amount, 2, '.', ''),
                "invoice" => $value->payment_id
            ];
        }
        $json_data = array(
            "recordsTotal" => intval($total->total),
            "recordsFiltered" => intval($totalfiltered),
            "recordPerPage" => $length,
            "currentPage" => $page,
            "data" => $data,
        );
        return Response::json($json_data);
    }

}
