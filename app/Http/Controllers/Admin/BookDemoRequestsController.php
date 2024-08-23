<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\BookDemoRequest;
use App\Models\CompanyJob;
use App\Models\Companies;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use Auth;
use DataTables;
use Carbon\Carbon;
use DB;
use Excel;
use Response;

class BookDemoRequestsController extends Controller
{
    public function index(Request $request)
    {
        $req = $request->all();
        //  $search = (isset($req['search']) ? $req['search'] : '');
        return view("admin.book-demo-requests.index");
    }
    public function list(Request $request)
    {
        $isView = whoCanCheck(config('app.arrWhoCanCheck'), 'admin_book_demo_request_view');
        $isMarkCompleted = whoCanCheck(config('app.arrWhoCanCheck'), 'admin_book_demo_request_mark_completed');
        $req = $request->all();
        $start = $req['start'];
        $length = $req['length'];
        $search = $req['search']['value'];
        $order = $req['order'][0]['dir'];
        $column = $req['order'][0]['column'];
        $orderby = ['id','','type', 'first_name', 'email', '', '','created_at'];
        $total = BookDemoRequest::selectRaw('count(*) as total')->whereNull('book_demo_requests.deleted_at')->first();

        $query = BookDemoRequest::selectRaw('book_demo_requests.*')
            ->whereNull('book_demo_requests.deleted_at');

        $filteredq = BookDemoRequest::selectRaw('book_demo_requests.*')
            ->whereNull('book_demo_requests.deleted_at');
            
        $totalfiltered = $total->total;
        if ($search != '') {
            $query->where(function ($query2) use ($search) {
                $query2->where('book_demo_requests.first_name', 'like', '%' . $search . '%')
                    ->orWhere('book_demo_requests.last_name', 'like', '%' . $search . '%')
                    ->orWhere('book_demo_requests.email', 'like', '%' . $search . '%');
            });

            $filteredq->where(function ($query2) use ($search) {
                $query2->where('book_demo_requests.first_name', 'like', '%' . $search . '%')
                    ->orWhere('book_demo_requests.last_name', 'like', '%' . $search . '%')
                    ->orWhere('book_demo_requests.email', 'like', '%' . $search . '%');
            });
        }
        if (isset($request->is_active)) {
            $filteredq = $filteredq->where('book_demo_requests.status', $request->is_active);
            $query = $query->where('book_demo_requests.status', $request->is_active);
        }
        if (isset($request->type) && $request->type != 'all') {
            $filteredq = $filteredq->where('book_demo_requests.type', $request->type);
            $query = $query->where('book_demo_requests.type', $request->type);
        }
        if (!empty($request->startDate) && !empty($request->endDate)) {
            $startDate = date($request->startDate);
            $endDate = date($request->endDate);
            $filteredq = $filteredq->where(function ($q) use ($startDate, $endDate) {
                $q->whereBetween('book_demo_requests.created_at', [$startDate, $endDate]);
            });
            $query = $query->where(function ($q) use ($startDate, $endDate) {
                $q->whereBetween('book_demo_requests.created_at', [$startDate, $endDate]);
            });
        }
        $recordCount = $filteredq->selectRaw('count(*) as total')->first();
        $totalfiltered = $recordCount->total;
        
       $query = $query->orderBy($orderby[$column], $order)->offset($start)->limit($length)->get();
        // $query = $query->offset($start)->limit($length)->get();
        // $firstname = Subscription::select('firstname')->leftJoin("users","subscriptions.customer_id","=","users.role_id")->first();
        //$duration = Subscription::select('duration')->leftJoin("subscription__plans", "subscriptions.subscription_plan","=","subscription__plans.id")->first();
        $data = [];
        foreach ($query as $key => $value) {
            $action = '';
            $view = ($isView) ? '<li class="nav-item">'
                . '<a class="nav-link view-link" data-id="' . $value->id . '" value="'.$value->id.'">View</a>'
                . '</li>' : '';

            $markComplete = ($isMarkCompleted) ? '<li class="nav-item">'
                . '<a class="nav-link mark-complete" data-id="' . $value->id . '" value="'.$value->id.'">Mark as Completed</a>'
                . '</li>' : '';
            if ($view || $markComplete) {
                if($value->status == 1){
                    $markComplete = "";
                }
                $action .= '<div class="d-inline-block dropdown">'
                    . '<button type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" class="btn-shadow dropdown-toggle btn btn-primary">'
                    . '<span class="btn-icon-wrapper pr-2 opacity-7">'
                    . '<i class="fa fa-cog fa-w-20"></i>'
                    . '</span>'
                    . '</button>'
                    . '<div tabindex="-1" role="menu" aria-hidden="true" class="dropdown-menu dropdown-menu-right">'
                    . '<ul class="nav flex-column">'
                    . $view .$markComplete
                    . '</ul>'
                    . '</div>'
                    . '</div>';
            }
            $data[] = [$value->id,$action, $value->type, $value->first_name.' '.$value->last_name, $value->email, $value->phone, $value->requirement,getFormatedDate($value->created_at),$value->status];
        }
        $json_data = array(
            "draw" => intval($_REQUEST['draw']),
            "recordsTotal" => intval($total->total),
            "recordsFiltered" => intval($totalfiltered),
            "data" => $data,
        );
        return Response::json($json_data);
    }

    public function markAsCompleted(Request $request)
    {
        $model = BookDemoRequest::where('id', $request->id)->first();
        if (!empty($model)) {
            $model->updated_at = Carbon::now();
            $model->status = 1;
            $model->save();
            $result['status'] = 'true';
            $result['msg'] = "Demo request completed successfully!";
            return $result;
        } else {
            $result['status'] = 'false';
            $result['msg'] = "Something went wrong!!";
            return $result;
        }
    }

    public function view(Request $request)
    {
        $model = BookDemoRequest::where('id', $request->id)->first();
        if (!empty($model)) {
            $created_at = getFormatedDate($model->created_at);  
            $json_data = array(
                "status" => true,
                "data" => $model,
                'created_at'=>$created_at,
            );
            return $json_data;
        }
    }
}
