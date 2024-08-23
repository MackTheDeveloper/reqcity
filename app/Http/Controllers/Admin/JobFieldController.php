<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use App\Models\JobField;
use Auth;
use Validator;
use Carbon\Carbon;
use DataTables;
use Response;
use DB;
use Image;


class JobFieldController extends Controller
{
    public function index()
    {
        return view("admin.job-fields.index");
    }

    public function list(Request $request)
    {
        $isEditable = whoCanCheck(config('app.arrWhoCanCheck'), 'admin_job_field_edit');
        $isDeletable = whoCanCheck(config('app.arrWhoCanCheck'), 'admin_job_field_delete');
        $req = $request->all();
        $start = $req['start'];
        $length = $req['length'];
        $search = $req['search']['value'];
        $order = $req['order'][0]['dir'];
        $column = $req['order'][0]['column'];
        $orderby = ['id','','code','field_name','filterable',''];
        $total = JobField::selectRaw('count(*) as total')->whereNull('deleted_at')->first();
        $query = JobField::whereNull('deleted_at');
        $filteredq = JobField::whereNull('deleted_at');
        $totalfiltered = $total->total;

        if ($search != '') {
            $query->where(function ($query2) use ($search) {
                $query2->where('code', 'like', '%' . $search . '%');
                $query2->orWhere('field_name', 'like', '%' . $search . '%');
            });
            $filteredq->where(function ($query2) use ($search) {
                $query2->where('code', 'like', '%' . $search . '%');
                $query2->orWhere('field_name', 'like', '%' . $search . '%');
            });
            $filteredq = $filteredq->selectRaw('count(*) as total')->first();
            $totalfiltered = $filteredq->total;
        }
        $query = $query->orderBy($orderby[$column], $order)->offset($start)->limit($length)->get();
        $data = [];
        foreach ($query as $key => $value) {
            $isActive = '';
            $action = '';
            $editUrl = route('editJobField', $value->id);
            if ($value->status == 1) {
                $isActive .= '<button type="button" class="btn btn-sm btn-toggle active toggle-is-active-switch" data-id="' . $value->id . '" data-toggle="button" aria-pressed="true" autocomplete="off"><div class="handle"></div></button>';
            } else {
                $isActive .= '<button type="button" class="btn btn-sm btn-toggle toggle-is-active-switch" data-id="' . $value->id . '" data-toggle="button" aria-pressed="false" autocomplete="off"><div class="handle"></div></button>';
            }
            $edit = '<li class="nav-item">'
            .'<a class="nav-link" href="' . $editUrl . '">Edit</a>'
        .'</li>';
            $activeInactive = ($isEditable)?'<li class="nav-item">'
                .'<a class="nav-link active-inactive-link" >Mark as '.(( $value->status == '1')?'Inactive':'Active').'</a>'
            .'</li>':'';

            $delete = ($isDeletable)?'<li class="nav-item">'
                        .'<a class="nav-link job_field_delete" data-id="' . $value->id . '">Delete</a>'
                    .'</li>':'';
            if ($activeInactive || $delete) {
                $action .= '<div class="d-inline-block dropdown">'
                    .'<button type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" class="btn-shadow dropdown-toggle btn btn-primary">'
                        .'<span class="btn-icon-wrapper pr-2 opacity-7">'
                            .'<i class="fa fa-cog fa-w-20"></i>'
                        .'</span>'
                    .'</button>'
                    .'<div tabindex="-1" role="menu" aria-hidden="true" class="dropdown-menu dropdown-menu-right">'
                        .'<ul class="nav flex-column">'
                        .$edit.$activeInactive.$delete
                        .'</ul>'
                    .'</div>'
                .'</div>';
            }
            $baseUrl=$this->getBaseUrl();
            $titleLink='<a href="'.url(config('app.adminPrefix').'/job-field-options/index?searchText='.$value->field_name).'">'.$value->field_name.'</a>';

          //  $image = '<img width="50" height="50" src=' .$baseUrl.'/public/assets/images/subscription-plan/'. $value->icon . '/>';
            $classRow = $value->status?"":"row_inactive";
            $data[] = [$classRow,$action,$value->code,$titleLink,ucfirst($value->filterable),$isActive];
        }
        $json_data = array(
            "draw" => intval($_REQUEST['draw']),
            "recordsTotal" => intval($total->total),
            "recordsFiltered" => intval($totalfiltered),
            "data" => $data,
        );
        return Response::json($json_data);
    }


    public function add()
    {
        $model = new JobField;
      //  $model->sort_order = SubscriptionPlan::getSortOrder();
        return view('admin.job-fields.form', compact('model'));
    }

    public function store(Request $request)
    {
        $input = $request->all();
        $validator = Validator::make(
            $input,
            [
                'code' => 'required',
                'field_name' => 'required',
                'filterable' => 'required',
            ]
        );

        if ($validator->fails())
        {
            $notification = array(
                'message' => 'Validation Required!',
                'alert-type' => 'error'
            );
            return redirect(config('app.adminPrefix').'/job-fields/index')->with($notification);

        }
        else
        {
            $model = new JobField();
            $model->code = $request->code;
            $model->field_name = $request->field_name;
            $model->filterable = $request->filterable;
            $model->status = $request->status;
            $model->save();

            $notification = array(
                'message' => 'Job Field added successfully!',
                'alert-type' => 'success'
            );
            return redirect(config('app.adminPrefix').'/job-fields/index')->with($notification);
        }
    }

    public function edit($id)
    {
        $model = JobField::findOrFail($id);
        $baseUrl=$this->getBaseUrl();
        return view('admin.job-fields.form', compact('model','baseUrl'));
    }

    public function update(Request $request, $id)
    {
        $model = JobField::findOrFail($id);
        if (!empty($model)) {
          //$plan = new SubscriptionPlan();
        //  $model->code = $request->code;
          $model->field_name = $request->field_name;
          $model->filterable = $request->filterable;
          $model->status = $request->status;
          $model->save();
            $notification = array(
                'message' => 'Job Field updated successfully!',
                'alert-type' => 'success'
            );

            return redirect(config('app.adminPrefix').'/job-fields/index')->with($notification);
        }
    }

    public function activeInactive(Request $request)
    {
        try {
            $model = JobField::where('id', $request->job_field_id)->first();
            if ($request->status == 1) {
                $model->status = $request->status;
                $msg = "Job Field Activated Successfully!";
            } else {
                $model->status = $request->status;
                $msg = "Job Field Deactivated Successfully!";
            }
            $model->save();
            $result['status'] = 'true';
            $result['msg'] = $msg;
            return $result;
        } catch (\Exception $ex) {
            return view('errors.500');
        }
    }

    public function delete(Request $request)
    {
        $model = JobField::where('id', $request->job_field_id)->first();
        if (!empty($model)) {
            $model->deleted_at = Carbon::now();
            $model->save();
            $result['status'] = 'true';
            $result['msg'] = "Job Field Deleted Successfully!";
            return $result;
        } else {
            $result['status'] = 'false';
            $result['msg'] = "Something went wrong!!";
            return $result;
        }
    }
}
