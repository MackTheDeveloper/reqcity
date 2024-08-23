<?php

namespace App\Http\Controllers\Admin;

use App\Exports\RecruiterPayoutExport;
use App\Http\Controllers\Controller;
use App\Models\RecruiterPayouts;
use App\Models\Recruiter;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use Auth;
use DataTables;
use Carbon\Carbon;
use DB;
use Excel;
use Response;

class RecruiterPayoutController extends Controller
{
    public function index(Request $request)
    {
        $req = $request->all();
      //  $search = (isset($req['search']) ? $req['search'] : '');
        $recruiters = Recruiter::getList();
        return view("admin.recruiters.payouts",compact('recruiters'));
    }
    public function list(Request $request)
    {
        $req = $request->all();
        $start = $req['start'];
        $length = $req['length'];
        $search = $req['search']['value'];
        $order = $req['order'][0]['dir'];
        $column = $req['order'][0]['column'];
        $orderby = ['first_name','last_name', 'amount', 'payment_id', '','','created_at'];
        $sumAmount=0;
        $sumAmountQuery=RecruiterPayouts::selectRaw('SUM(recruiter_payouts.amount) as sumAmount')
                                    ->leftJoin("recruiters","recruiter_payouts.recruiter_id","recruiters.id")
                                    ->whereNull('recruiter_payouts.deleted_at');
        $total = RecruiterPayouts::selectRaw('count(*) as total')->whereNull('recruiter_payouts.deleted_at')->first();
        $query = RecruiterPayouts::select('recruiter_payouts.*','recruiters.first_name','recruiters.last_name')
                                    ->leftJoin("recruiters","recruiter_payouts.recruiter_id","recruiters.id")
                                    ->whereNull('recruiter_payouts.deleted_at');
        $filteredq =RecruiterPayouts::select('recruiter_payouts.*','recruiters.first_name','recruiters.last_name')
                                    ->leftJoin("recruiters","recruiter_payouts.recruiter_id","recruiters.id")
                                    ->whereNull('recruiter_payouts.deleted_at');
        $totalfiltered = $total->total;
        if ($search != '') {
          $query->where(function ($query2) use ($search) {
              $query2->where('recruiters.first_name', 'like', '%' . $search . '%')
                    ->where('recruiters.last_name', 'like', '%' . $search . '%')
                  ->orWhere('recruiter_payouts.payment_id', 'like', '%' . $search . '%');
          });
            $filteredq->where(function ($query2) use ($search) {
              $query2->where('recruiters.first_name', 'like', '%' . $search . '%')
                     ->where('recruiters.last_name', 'like', '%' . $search . '%')
                   ->orWhere('recruiter_payouts.payment_id', 'like', '%' . $search . '%');
            });
            $sumAmountQuery->where(function ($query2) use ($search) {
              $query2->where('recruiters.first_name', 'like', '%' . $search . '%')
                    ->where('recruiters.last_name', 'like', '%' . $search . '%')
                  ->orWhere('recruiter_payouts.payment_id', 'like', '%' . $search . '%');
            });
            $filteredq = $filteredq->selectRaw('count(*) as total')->first();
            $totalfiltered = $filteredq->total;
        }
        if (isset($request->recruiter) && $request->recruiter!='all') {
            $filteredq = $filteredq->where('recruiter_payouts.recruiter_id', $request->recruiter);
            $query = $query->where('recruiter_payouts.recruiter_id', $request->recruiter);
            $sumAmountQuery = $sumAmountQuery->where('recruiter_payouts.recruiter_id', $request->recruiter);
        }
        if (!empty($request->startDate) && !empty($request->endDate)) {
            $startDate = date($request->startDate);
            $endDate = date($request->endDate);
            $filteredq = $filteredq->where(function($q) use ($startDate,$endDate){
                $q->whereBetween('recruiter_payouts.created_at', [$startDate, $endDate]);
            });
            $query = $query->where(function($q) use ($startDate,$endDate){
                $q->whereBetween('recruiter_payouts.created_at', [$startDate, $endDate]);
            });
            $sumAmountQuery = $sumAmountQuery->where(function($q) use ($startDate,$endDate){
                $q->whereBetween('recruiter_payouts.created_at', [$startDate, $endDate]);
            });
            $recordCount = $filteredq->selectRaw('count(*) as total')->first();
            $totalfiltered = $recordCount->total;
        }
        $sumAmountQuery=$sumAmountQuery->first();
        $sumAmount=$sumAmountQuery->sumAmount;
        if(empty($sumAmount))
        $sumAmount=0;
        $query = $query->orderBy($orderby[$column], $order)->offset($start)->limit($length)->get();
        $data = [];
        foreach ($query as $key => $value)
        {
          $bankHtml=$value->bank_name.'<br>'.$value->bank_address;
          $bankDetails ='Account Number: '.$value->account_number.'<br>';
          $bankDetails.='Swift Code: '.$value->swift_code.'<br>';
          $bankDetails.='City: '.$value->bank_city.'<br>';
          $bankDetails.='Country: '.$value->bank_country;
            $data[] = [$value->first_name.' '.$value->last_name,$value->amount, $value->payment_id,$bankHtml,$bankDetails,getFormatedDate($value->created_at)];
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

     public function exportRecruiterPayout(Request $request)
    {
        try{
            return Excel::download(new RecruiterPayoutExport(), 'ReqCity_Recruiter_payouts.xlsx');
        } catch(\Exception $ex) {
            return view('errors.500');
        }
    }

}
