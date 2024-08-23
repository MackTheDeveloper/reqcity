<?php

namespace App\Http\Controllers\Admin;

use App\Exports\RecruiterBankDetailsExport;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use App\Models\User;
use App\Models\Recruiter;
use App\Models\RecruiterBankDetail;
use Exception;
use Auth;
use Response;
use Mail;
use Excel;
use Illuminate\Support\Facades\Session;
use Illuminate\Routing\Route;
use Illuminate\Support\Facades\URL;

class RecruiterBankController extends Controller
{

    public function index(Request $request)
    {
        return view('admin.recruiters.bank-details');
    }


    public function list(Request $request)
    {
        $req = $request->all();
        $start = $req['start'];
        $length = $req['length'];
        $search = $req['search']['value'];
        $order = $req['order'][0]['dir'];
        $column = $req['order'][0]['column'];
        $orderby = ['id', '', 'first_name', 'currency_code', 'bank_name', 'account_number', 'countryName', 'city', 'postcode'];

        $total = RecruiterBankDetail::selectRaw('count(*) as total')->whereNull('deleted_at')->first();
        $query = RecruiterBankDetail::select('recruiter_bank_details.*', 'countries.name as countryName','recruiters.first_name','recruiters.last_name')
            ->leftJoin('recruiters', 'recruiter_bank_details.recruiter_id', 'recruiters.id')
            ->leftJoin('countries', 'recruiter_bank_details.bank_country', 'countries.id')
            ->whereNull('recruiter_bank_details.deleted_at');

        $filteredq = RecruiterBankDetail::select('recruiter_bank_details.*', 'countries.name as countryName')
            ->leftJoin('recruiters', 'recruiter_bank_details.recruiter_id', 'recruiters.id')
            ->leftJoin('countries', 'recruiter_bank_details.bank_country', 'countries.id')
            ->whereNull('recruiter_bank_details.deleted_at');

        $totalfiltered = $total->total;
        if ($search != '') {
            $query->where(function ($query2) use ($search) {
                $query2->where('recruiters.first_name', 'like', '%' . $search . '%')
                    ->orWhere('recruiters.last_name', 'like', '%' . $search . '%')
                    ->orWhere('recruiter_bank_details.bank_name', 'like', '%' . $search . '%')
                    ->orWhere('recruiter_bank_details.account_number', 'like', '%' . $search . '%')
                    ->orWhere('recruiter_bank_details.swift_code', 'like', '%' . $search . '%');
            });

            $filteredq->where(function ($query2) use ($search) {
                $query2->where('recruiters.first_name', 'like', '%' . $search . '%')
                    ->orWhere('recruiters.last_name', 'like', '%' . $search . '%')
                    ->orWhere('recruiter_bank_details.bank_name', 'like', '%' . $search . '%')
                    ->orWhere('recruiter_bank_details.account_number', 'like', '%' . $search . '%')
                    ->orWhere('recruiter_bank_details.swift_code', 'like', '%' . $search . '%');
            });

            $filteredq = $filteredq->selectRaw('count(*) as total')->first();
            $totalfiltered = $filteredq->total;
        }
       
        $query = $query->orderBy($orderby[$column], $order)->offset($start)->limit($length)->get();
        $data = [];
        foreach ($query as $key => $value) {
            $data[] = [$value->first_name . ' ' . $value->last_name, $value->currency_code ,$value->bank_name, $value->account_number,$value->swift_code,$value->bank_address,$value->bank_city,$value->countryName];
        }
        $json_data = array(
            "draw" => intval($_REQUEST['draw']),
            "recordsTotal" => intval($total->total),
            "recordsFiltered" => intval($totalfiltered),
            "data" => $data,
        );
        return Response::json($json_data);
    }

    public function exportBankDetails(Request $request)
    {
        try{
            return Excel::download(new RecruiterBankDetailsExport(), 'ReqCity_Recruiter_Bank_Details.xlsx');
        } catch(\Exception $ex) {
            return view('errors.500');
        }
    }
}
