<?php

namespace App\Http\Controllers\Admin;

use App\Exports\RecruiterPaymentExport;
use App\Http\Controllers\Controller;
use App\Models\RecruiterPayment;
use App\Models\RecruiterPayouts;
use App\Models\CompanyJob;
use App\Models\SubscriptionPlan;
use App\Models\Companies;
use App\Models\Country;
use App\Models\EmailTemplates;
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

class RecruiterPaymentController extends Controller
{
    public function index(Request $request)
    {
        $req = $request->all();
        //  $search = (isset($req['search']) ? $req['search'] : '');
        $company = RecruiterPayment::getCompanyList();
        $recruiter = RecruiterPayment::getRecruiterList();
        return view("admin.recruiter-payment.index", compact('company', 'recruiter'));
    }
    public function list(Request $request)
    {
        $req = $request->all();
        $start = $req['start'];
        $length = $req['length'];
        $search = $req['search']['value'];
        $order = $req['order'][0]['dir'];
        $column = $req['order'][0]['column'];
        $orderby = ['id', '', 'first_name','last_name', 'companyName', 'jobTitle', 'jobPosted', 'amount', '',];
        $sumAmount = 0;
        $sumAmountQuery = RecruiterPayment::selectRaw('SUM(company_job_commission.amount) as sumAmount')
            ->leftJoin("company_jobs", "company_job_commission.company_job_id", "company_jobs.id")
            ->leftJoin("companies", "company_jobs.company_id", "companies.id")
            ->leftJoin("company_job_applications", "company_job_commission.company_job_application_id", "company_job_applications.id")
            ->leftJoin("recruiters", "company_job_commission.recruiter_id", "recruiters.id")
            ->where('company_job_commission.flag_paid', 0)
            ->where('company_job_commission.type', 1)
            ->whereNull('company_job_commission.deleted_at');
        $total = RecruiterPayment::selectRaw('count(*) as total')
            ->where('company_job_commission.flag_paid', 0)
            ->where('company_job_commission.type', 1)
            ->whereNull('company_job_commission.deleted_at')
            ->first();
        $query = RecruiterPayment::select('company_job_commission.*', 'companies.name as companyName', 'recruiters.first_name','recruiters.last_name', 'company_jobs.title as jobTitle', 'company_job_applications.created_at as jobPosted')
            ->leftJoin("company_jobs", "company_job_commission.company_job_id", "company_jobs.id")
            ->leftJoin("companies", "company_jobs.company_id", "companies.id")
            ->leftJoin("company_job_applications", "company_job_commission.company_job_application_id", "company_job_applications.id")
            ->leftJoin("recruiters", "company_job_commission.recruiter_id", "recruiters.id")
            ->where('company_job_commission.flag_paid', 0)
            ->where('company_job_commission.type', 1)
            ->whereNull('company_job_commission.deleted_at');

        $filteredq = RecruiterPayment::select('company_job_commission.*', 'companies.name as companyName', 'recruiters.first_name','recruiters.last_name', 'company_jobs.title as jobTitle', 'company_job_applications.created_at as jobPosted')
            ->leftJoin("company_jobs", "company_job_commission.company_job_id", "company_jobs.id")
            ->leftJoin("companies", "company_jobs.company_id", "companies.id")
            ->leftJoin("company_job_applications", "company_job_commission.company_job_application_id", "company_job_applications.id")
            ->leftJoin("recruiters", "company_job_commission.recruiter_id", "recruiters.id")
            ->where('company_job_commission.flag_paid', 0)
            ->where('company_job_commission.type', 1)
            ->whereNull('company_job_commission.deleted_at');

        $totalfiltered = $total->total;
        if ($search != '') {
            $query->where(function ($query2) use ($search) {
                $query2->where('companies.name', 'like', '%' . $search . '%')
                    ->orWhere('company_jobs.title', 'like', '%' . $search . '%')
                    ->orWhere('recruiters.first_name', 'like', '%' . $search . '%')
                    ->orWhere('recruiters.last_name', 'like', '%' . $search . '%');
            });

            $filteredq->where(function ($query2) use ($search) {
                $query2->where('companies.name', 'like', '%' . $search . '%')
                    ->orWhere('company_jobs.title', 'like', '%' . $search . '%')
                    ->orWhere('recruiters.first_name', 'like', '%' . $search . '%')
                    ->orWhere('recruiters.last_name', 'like', '%' . $search . '%');
            });
            $sumAmountQuery->where(function ($query2) use ($search) {
                $query2->where('companies.name', 'like', '%' . $search . '%')
                    ->orWhere('company_jobs.title', 'like', '%' . $search . '%')
                    ->orWhere('recruiters.first_name', 'like', '%' . $search . '%')
                    ->orWhere('recruiters.last_name', 'like', '%' . $search . '%');
            });
        }
        // if (isset($request->is_active)) {
        //     $filteredq = $filteredq->where('company_job_funding.status', $request->is_active);
        //     $query = $query->where('company_job_funding.status', $request->is_active);
        // }
        if (isset($request->company) && $request->company != 'all') {
            $filteredq = $filteredq->where('companies.id', $request->company);
            $query = $query->where('companies.id', $request->company);
            $sumAmountQuery = $sumAmountQuery->where('companies.id', $request->company);
        }
        if (isset($request->recruiter) && $request->recruiter != 'all') {
            $filteredq = $filteredq->where('company_job_commission.recruiter_id', $request->recruiter);
            $query = $query->where('company_job_commission.recruiter_id', $request->recruiter);
            $sumAmountQuery = $sumAmountQuery->where('company_job_commission.recruiter_id', $request->recruiter);
        }
        if (!empty($request->startDate) && !empty($request->endDate)) {
            $startDate = date($request->startDate);
            $endDate = date($request->endDate);
            $newDate = new DateTime($endDate);
            $newDate->add(new DateInterval('P1D'));

            $filteredq = $filteredq->where(function ($q) use ($startDate, $newDate) {
                $q->whereBetween('company_job_applications.created_at', [$startDate, $newDate]);
            });
            $query = $query->where(function ($q) use ($startDate, $newDate) {
                $q->whereBetween('company_job_applications.created_at', [$startDate, $newDate]);
            });
            $sumAmountQuery = $sumAmountQuery->where(function ($q) use ($startDate, $newDate) {
                $q->whereBetween('company_job_applications.created_at', [$startDate, $newDate]);
            });
        }
        $recordCount = $filteredq->selectRaw('count(*) as total')->first();
        $totalfiltered = $recordCount->total;
        $sumAmountQuery = $sumAmountQuery->first();
        $sumAmount = $sumAmountQuery->sumAmount;
        if (empty($sumAmount))
            $sumAmount = 0;
        $query = $query->orderBy($orderby[$column], $order)->offset($start)->limit($length)->get();
        // $query = $query->offset($start)->limit($length)->get();
        // $firstname = Subscription::select('firstname')->leftJoin("users","subscriptions.customer_id","=","users.role_id")->first();
        //$duration = Subscription::select('duration')->leftJoin("subscription__plans", "subscriptions.subscription_plan","=","subscription__plans.id")->first();
        $data = [];
        foreach ($query as $key => $value) {
            $check  = '<input name="id[]" value="' . $value->id . '" id="id_' . $value->id . '" type="checkbox" class="recruiterCheck" />';
            $data[] = [$value->id, $check, $value->first_name.' '.$value->last_name, $value->companyName, $value->jobTitle, getFormatedDate($value->jobPosted), $value->amount];
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

    public function exportRecruiterPayment(Request $request)
    {
        try {
            return Excel::download(new RecruiterPaymentExport(), 'ReqCity_Recruiter_Payments.xlsx');
        } catch (\Exception $ex) {
            return view('errors.500');
        }
    }

    public function getRecruiterBankDetails(Request $request)
    {
        $checkedIds = $request['checkedIds'];
        $retunIds = "";
        $total = "";
        $startDate = $request['startDate'];
        $endDate = $request['endDate'];
        $search = $request['search'];
        $company = $request['company'];
        $recruiterId = $request['id'];

        $query = RecruiterPayment::select('company_job_commission.*', 'companies.name as companyName', 'recruiters.first_name','recruiters.last_name', 'company_jobs.title as jobTitle', 'company_job_applications.created_at as jobPosted')
            ->leftJoin("company_jobs", "company_job_commission.company_job_id", "company_jobs.id")
            ->leftJoin("companies", "company_jobs.company_id", "companies.id")
            ->leftJoin("company_job_applications", "company_job_commission.company_job_application_id", "company_job_applications.id")
            ->leftJoin("recruiters", "company_job_commission.recruiter_id", "recruiters.id")
            ->where('company_job_commission.flag_paid', 0)
            ->where('company_job_commission.type', 1)
            ->whereNull('company_job_commission.deleted_at');

        if ($search != '') {
            $query->where(function ($query2) use ($search) {
                $query2->where('companies.name', 'like', '%' . $search . '%')
                    ->orWhere('company_jobs.title', 'like', '%' . $search . '%')
                    ->orWhere('recruiters.first_name', 'like', '%' . $search . '%')
                    ->orWhere('recruiters.last_name', 'like', '%' . $search . '%');
            });
        }

        if (isset($company) && $company != 'all') {
            $query = $query->where('companies.id', $request->company);
        }
        if (isset($recruiterId) && $recruiterId != 'all') {
            $query = $query->where('company_job_commission.recruiter_id', $request->recruiter);
        }
        if (!empty($startDate) && !empty($endDate)) {
            $startDate = date($startDate);
            $endDate = date($endDate);
            $newDate = new DateTime($endDate);
            $newDate->add(new DateInterval('P1D'));

            $query = $query->where(function ($q) use ($startDate, $newDate) {
                $q->whereBetween('company_job_applications.created_at', [$startDate, $newDate]);
            });
        }
        if ($checkedIds[0] == "selectAll") {
            $total = $query->sum('company_job_commission.amount');
            $retunIds = $query->pluck('company_job_commission.id')->toArray();
        } else {
            $total =  $query->whereIn('company_job_commission.id', $checkedIds)->sum('company_job_commission.amount');
            $retunIds = $query->whereIn('company_job_commission.id', $checkedIds)->pluck('company_job_commission.id')->toArray();
        }

        if ($recruiterId) {
            $details = RecruiterPayment::getRecruiterBankDetail($recruiterId);
            if($details->bank_country)
                $details->bank_country = Country::getCountryName($details->bank_country);
            $json_data = array(
                "data" => $details,
                "total" => $total,
                "Ids" => $retunIds,
            );
            return $json_data;
        }
    }

    //make entry in recruiter payout with bank details and make all payment flag to paid
    public function makeRecruiterPayout(Request $request)
    {
        $recruiterId = $request['recId'];
        $Ids = explode(",", $request['checkedValues']);
        $amount = $request['amount'];
        $paymentId = $request['paymentId'];
        if (!isset($Ids)) {
            $result['status'] = 'false';
            $result['msg'] = 'Please select at least one.';
            return $result;
        }
        $idString = implode(",", RecruiterPayment::getJobApplicationId($Ids));
        $jobApplicationIds = $idString;
        $bankDetails = RecruiterPayment::getRecruiterBankDetail($recruiterId);
        if (isset($bankDetails)) {
            $payOuts = new RecruiterPayouts();
            $payOuts->recruiter_id = $recruiterId;
            $payOuts->amount = $amount;
            $payOuts->application_ids = $jobApplicationIds;
            $payOuts->payment_id = $paymentId;
            $payOuts->bank_name = $bankDetails->bank_name;
            $payOuts->currency_code = $bankDetails->currency_code;
            $payOuts->account_number = $bankDetails->account_number;
            $payOuts->bank_address = $bankDetails->bank_address;
            $payOuts->swift_code = $bankDetails->swift_code;
            $payOuts->bank_city = $bankDetails->bank_city;
            $payOuts->bank_country = (isset($bankDetails) && isset($bankDetails->country)) ? $bankDetails->country->name : null;
            $payOuts->created_at = Carbon::now();
            $payOuts->save();
            RecruiterPayment::changePaymentFlag($Ids);
            if ($payOuts->save()) {
                $code='JOBPAY';
                $msg_type='Payout Done';
                $msg='ReqCity has made payment of $'.$amount.' in your bank account';
                $notification=insertNotification(2,$recruiterId,$code,$msg_type,$msg);
            }
            $result['status'] = 'true';
            $result['msg'] = 'Payment Successfull.';
            //send notification mail
            $slug = 'recruiter-payout-related-event';
            $data = ['recruiterId'=>$recruiterId,
                    'payment_id'=>$paymentId,
                    'date'=>$payOuts->created_at,
                    'amount'=>$amount,
            ];
            EmailTemplates::sendNotificationMailRecruiter($slug,$data);
            return $result;
        } else {
            $result['status'] = 'false';
            $result['msg'] = 'Something went wrong..!';
            return $result;
        }
    }
}
