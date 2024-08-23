<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\RecruiterTaxForms;
use App\Models\Recruiter;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use Auth;
use DataTables;
use Carbon\Carbon;
use DB;
use Excel;
use Response;

class RecruiterTaxFormController extends Controller
{
    public function index(Request $request)
    {
        $req = $request->all();
      //  $search = (isset($req['search']) ? $req['search'] : '');
        $recruiters = Recruiter::getList();
        return view("admin.recruiters.tax-forms",compact('recruiters'));
    }
    public function list(Request $request)
    {
        $req = $request->all();
        $start = $req['start'];
        $length = $req['length'];
        $search = $req['search']['value'];
        $order = $req['order'][0]['dir'];
        $column = $req['order'][0]['column'];
        $orderby = ['first_name','last_name', 'form_name', 'created_at'];

        $total = RecruiterTaxForms::selectRaw('count(*) as total')->whereNull('recruiter_tax_forms.deleted_at')->first();
        $query = RecruiterTaxForms::select('recruiter_tax_forms.*','recruiters.first_name','recruiters.last_name')
                                    ->leftJoin("recruiters","recruiter_tax_forms.recruiter_id","recruiters.id")
                                    ->whereNull('recruiter_tax_forms.deleted_at');
        $filteredq =RecruiterTaxForms::select('recruiter_tax_forms.*','recruiters.first_name','recruiters.last_name')
                                    ->leftJoin("recruiters","recruiter_tax_forms.recruiter_id","recruiters.id")
                                    ->whereNull('recruiter_tax_forms.deleted_at');
        $totalfiltered = $total->total;
        if ($search != '') {
          $query->where(function ($query2) use ($search) {
              $query2->where('recruiter_tax_forms.form_name', 'like', '%' . $search . '%')
                  ->orWhere('recruiters.first_name', 'like', '%' . $search . '%')
                  ->orWhere('recruiters.last_name', 'like', '%' . $search . '%');
          });
            $filteredq->where(function ($query2) use ($search) {
              $query2->where('recruiter_tax_forms.form_name', 'like', '%' . $search . '%')
                  ->orWhere('recruiters.first_name', 'like', '%' . $search . '%')
                  ->orWhere('recruiters.last_name', 'like', '%' . $search . '%');
            });
            $filteredq = $filteredq->selectRaw('count(*) as total')->first();
            $totalfiltered = $filteredq->total;
        }
        if (isset($request->recruiter) && $request->plan!='all') {
            $filteredq = $filteredq->where('recruiter_tax_forms.recruiter_id', $request->recruiter);
            $query = $query->where('recruiter_tax_forms.recruiter_id', $request->recruiter);
            $recordCount = $filteredq->selectRaw('count(*) as total')->first();
            $totalfiltered = $recordCount->total;
        }
        if (!empty($request->startDate) && !empty($request->endDate)) {
          $startDate = date($request->startDate);
          $endDate = date($request->endDate);

            $filteredq = $filteredq->where(function($q) use ($startDate,$endDate){
                $q->whereBetween('recruiter_tax_forms.created_at', [$startDate, $endDate]);
            });
            $query = $query->where(function($q) use ($startDate,$endDate){
                $q->whereBetween('recruiter_tax_forms.created_at', [$startDate, $endDate]);
            });
            $recordCount = $filteredq->selectRaw('count(*) as total')->first();
            $totalfiltered = $recordCount->total;
        }
       $query = $query->orderBy($orderby[$column], $order)->offset($start)->limit($length)->get();
        // $query = $query->offset($start)->limit($length)->get();
        // $firstname = Subscription::select('firstname')->leftJoin("users","subscriptions.customer_id","=","users.role_id")->first();
        //$duration = Subscription::select('duration')->leftJoin("subscription__plans", "subscriptions.subscription_plan","=","subscription__plans.id")->first();
        $data = [];
        foreach ($query as $key => $value)
        {
          $url=RecruiterTaxForms::getFormFile($value->id);
          if(!empty($value->tax_form))
            $downloadLink='<a href="'.$url.'" download><i class="fas fa-file-pdf"></i></a>';
          else
            $downloadLink='-';
            $data[] = [$value->first_name.' '.$value->last_name, $value->form_name,$downloadLink,getFormatedDate($value->created_at)];
        }
        $json_data = array(
            "draw" => intval($_REQUEST['draw']),
            "recordsTotal" => intval($total->total),
            "recordsFiltered" => intval($totalfiltered),
            "data" => $data,
        );
        return Response::json($json_data);
    }

}
