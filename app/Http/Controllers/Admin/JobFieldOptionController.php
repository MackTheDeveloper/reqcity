<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use App\Models\JobFieldOption;
use App\Models\JobField;
use Auth;
use Validator;
use Carbon\Carbon;
use DataTables;
use Response;
use DB;
use Image;


class JobFieldOptionController extends Controller
{
    public function index()
    {
        $searchText = isset($_GET['searchText']) ? $_GET['searchText'] : "";
        return view("admin.job-field-options.index",compact('searchText'));
    }

    public function list(Request $request)
    {
        $isEditable = whoCanCheck(config('app.arrWhoCanCheck'), 'admin_job_field_options_edit');
        $isDeletable = whoCanCheck(config('app.arrWhoCanCheck'), 'admin_job_field_options_delete');
        $req = $request->all();
        $start = $req['start'];
        $length = $req['length'];
        $search = $req['search']['value'];
        $order = $req['order'][0]['dir'];
        $column = $req['order'][0]['column'];
        $orderby = ['job_field_options.id','','option','job_field_id','sort_order',''];
        $total = JobFieldOption::selectRaw('count(*) as total')->whereNull('deleted_at')->first();
        $query = JobFieldOption::selectRaw('job_field_options.id as optiin_id,job_field_options.*,job_fields.id,job_fields.field_name')->leftjoin('job_fields','job_fields.id','job_field_options.job_field_id')->whereNull('job_field_options.deleted_at');
        $filteredq = JobFieldOption::selectRaw('job_field_options.id as optiin_id,job_field_options.*,job_fields.id,job_fields.field_name')->leftjoin('job_fields','job_fields.id','job_field_options.job_field_id')->whereNull('job_field_options.deleted_at');
        $totalfiltered = $total->total;

        if ($search != '') {
            $query->where(function ($query2) use ($search) {
                $query2->where('job_field_options.option', 'like', '%' . $search . '%');
                $query2->orWhere('job_fields.field_name', 'like', '%' . $search . '%');
            });
            $filteredq->where(function ($query2) use ($search) {
                $query2->where('job_field_options.option', 'like', '%' . $search . '%');
                $query2->orWhere('job_fields.field_name', 'like', '%' . $search . '%');
            });
            $filteredq = $filteredq->selectRaw('count(*) as total')->first();
            $totalfiltered = $filteredq->total;
        }
        $query = $query->orderBy($orderby[$column], $order)->offset($start)->limit($length)->get();
        $data = [];
        foreach ($query as $key => $value) {
            $isActive = '';
            $action = '';
            $editUrl = route('editJobFieldOption', $value->optiin_id);
            if ($value->status == 1) {
                $isActive .= '<button type="button" class="btn btn-sm btn-toggle active toggle-is-active-switch" data-id="' . $value->optiin_id . '" data-toggle="button" aria-pressed="true" autocomplete="off"><div class="handle"></div></button>';
            } else {
                $isActive .= '<button type="button" class="btn btn-sm btn-toggle toggle-is-active-switch" data-id="' . $value->optiin_id . '" data-toggle="button" aria-pressed="false" autocomplete="off"><div class="handle"></div></button>';
            }
            $edit = '<li class="nav-item">'
            .'<a class="nav-link" href="' . $editUrl . '">Edit</a>'
        .'</li>';
            $activeInactive = ($isEditable)?'<li class="nav-item">'
                .'<a class="nav-link active-inactive-link" >Mark as '.(( $value->status == '1')?'Inactive':'Active').'</a>'
            .'</li>':'';

            $delete = ($isDeletable)?'<li class="nav-item">'
                        .'<a class="nav-link job_field_option_delete" data-id="' . $value->optiin_id . '">Delete</a>'
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
            //$image = '<img width="50" height="50" src=' .$baseUrl.'/public/assets/images/subscription-plan/'. $value->icon . '/>';
            $classRow = $value->status?"":"row_inactive";
            $data[] = [$classRow,$action,$value->option,$value->field_name,$value->sort_order,$isActive];
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
        $model = new JobFieldOption();
        $JobFields=JobField::whereNull('deleted_at')->get();
        $model->sort_order = JobFieldOption::getSortOrder();
        return view('admin.job-field-options.form', compact('model','JobFields'));
    }

    public function store(Request $request)
    {
        $input = $request->all();
        $validator = Validator::make(
            $input,
            [
                'job_field_id' => 'required',
                'option' => 'required',
                'sort_order' => 'required',
            ]
        );

        if ($validator->fails())
        {
            $notification = array(
                'message' => 'Validation Required!',
                'alert-type' => 'error'
            );
            return redirect(config('app.adminPrefix').'/job-field-options/index')->with($notification);

        }
        else
        {
            $model = new JobFieldOption();
            $model->job_field_id = $request->job_field_id;
            $model->option = $request->option;
            $model->sort_order = $request->sort_order;
            $model->status = $request->status;
            $model->save();

            $notification = array(
                'message' => 'Job field option added successfully!',
                'alert-type' => 'success'
            );
            return redirect(config('app.adminPrefix').'/job-field-options/index')->with($notification);
        }
    }

    public function edit($id)
    {
        $model = JobFieldOption::findOrFail($id);
        $JobFields=JobField::whereNull('deleted_at')->get();
        $baseUrl=$this->getBaseUrl();
        return view('admin.job-field-options.form', compact('model','baseUrl','JobFields'));
    }

    public function update(Request $request, $id)
    {
       /* try {
            $model = Category::findOrFail($id);
            $input = $request->all();
            $model->update($input);
            $notification = array(
                'message' => 'Music category updated successfully!',
                'alert-type' => 'success'
            );
            return redirect(config('app.adminPrefix').'/music-categories/index')->with($notification);
        } catch (\Exception $e) {
            return redirect(config('app.adminPrefix').'/music-categories/index');
        }*/
        $model = JobFieldOption::findOrFail($id);
        if (!empty($model)) {
          //$model = new JobFieldOption();
          $model->job_field_id = $request->job_field_id;
          $model->option = $request->option;
          $model->sort_order = $request->sort_order;
          $model->status = $request->status;
          $model->save();

            $notification = array(
                'message' => 'Job field option updated successfully!',
                'alert-type' => 'success'
            );

            return redirect(config('app.adminPrefix').'/job-field-options/index')->with($notification);
        }
    }

    public function activeInactive(Request $request)
    {
        try {
            $model = JobFieldOption::where('id', $request->job_field_option_id)->first();
            if ($request->status == 1) {
                $model->status = $request->status;
                $msg = "Job field option Activated Successfully!";
            } else {
                $model->status = $request->status;
                $msg = "Job Field Option Deactivated Successfully!";
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
        $model = JobFieldOption::where('id', $request->job_field_option_id)->first();
        if (!empty($model)) {
            $model->deleted_at = Carbon::now();
            $model->save();
            // dd($model);
            $result['status'] = 'true';
            $result['msg'] = "Job Field Option Deleted Successfully!";
            return $result;
        } else {
            $result['status'] = 'false';
            $result['msg'] = "Something went wrong!!";
            return $result;
        }
    }
}
