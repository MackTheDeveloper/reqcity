<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use App\Models\PlanFeatures;
use App\Models\EmailTemplatesCc;
use App\Models\GlobalLanguage;
use Auth;
use Validator;
use Carbon\Carbon;
use DataTables;
use Response;
use DB;

class PlanFeaturesController extends Controller
{
    public function index()
    {
        $model = DB::table('plan_features')->where('deleted', '0')->orderBy('id', 'desc')->get();
        return view("admin.plan_features.index", ['model' => $model]);
    }

    public function list(Request $request)
    {
        $isEditable = whoCanCheck(config('app.arrWhoCanCheck'), 'admin_plan_features_edit');
        $isDeletable = whoCanCheck(config('app.arrWhoCanCheck'), 'admin_plan_features_delete');
        $req = $request->all();
        $start = $req['start'];
        $length = $req['length'];
        $search = $req['search']['value'];
        $order = $req['order'][0]['dir'];
        $column = $req['order'][0]['column'];
        $orderby = ['id','', 'type', 'title','', 'description','sort_order','status'];


        $total = PlanFeatures::selectRaw('count(*) as total')->where('deleted', '0')->first();
        $query = PlanFeatures::where('deleted', '0');
        $filteredq = PlanFeatures::where('deleted', '0');
        $totalfiltered = $total->total;

        if ($search != '') {
            $query->where(function ($query2) use ($search) {
                $query2->where('title', 'like', '%' . $search . '%')
                    ->orWhere('sort_order', 'like', '%' .$search .'%')
                    ->orWhere('description', 'like', '%' . $search . '%');
            });
            $filteredq->where(function ($query2) use ($search) {
                $query2->where('title', 'like', '%' . $search . '%')
                    ->orWhere('sort_order', 'like', '%' .$search .'%')
                    ->orWhere('description', 'like', '%' . $search . '%');
            });
            $filteredq = $filteredq->selectRaw('count(*) as total')->first();
            $totalfiltered = $filteredq->total;
        }
        $query = $query->orderBy($orderby[$column], $order)->offset($start)->limit($length)->get();
        $data = [];
        foreach ($query as $key => $value) {
            $isActive = '';
            $action = '';
            $editUrl = route('editPlanFeatures', $value->id);
            if ($value->status == 1) {
                $isActive .= '<button type="button" class="btn btn-sm  btn-toggle active toggle-is-active-switch" data-id="' . $value->id . '" data-toggle="button" aria-pressed="true" autocomplete="off"><div class="handle"></div></button>';
            } else {
                $isActive .= '<button type="button" class="btn btn-sm  btn-toggle toggle-is-active-switch" data-id="' . $value->id . '" data-toggle="button" aria-pressed="false" autocomplete="off"><div class="handle"></div></button>';
            }
            $edit = '<li class="nav-item">'
                        .'<a class="nav-link" href="' . $editUrl . '">Edit</a>'
                    .'</li>';
            $activeInactive = ($isEditable)?'<li class="nav-item">'
                    .'<a class="nav-link active-inactive-link" >Mark as '.(( $value->status == 1)?'Inactive':'Active').'</a>'
                .'</li>':'';

            $delete = ($isDeletable)?'<li class="nav-item">'
                    .'<a class="nav-link template_delete" data-id="' . $value->id . '">Delete</a>'
                .'</li>':'';
            // $action .= '<a class="template_delete text-danger" data-id="'.$value->id.'"><i class="fa fa-trash" aria-hidden="true"></i></a>';
            if ($activeInactive || $delete) {
                $action .= '<div class="d-inline-block dropdown">'
                    .'<button type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" class="btn-shadow dropdown-toggle btn btn-primary">'
                        .'<span class="btn-icon-wrapper pr-2 opacity-7">'
                            .'<i class="fa fa-cog fa-w-20"></i>'
                        .'</span>'
                    .'</button>'
                    .'<div tabindex="-1" role="menu" aria-hidden="true" class="dropdown-menu dropdown-menu-right">'
                        .'<ul class="nav flex-column">'
                        .$activeInactive.$edit.$delete
                        .'</ul>'
                    .'</div>'
                .'</div>';
            }

            $classRow = $value->status?"":"row_inactive";
            // $imagePath = public_path('/assets/images/plan_feature_image/');
            $imagePath = url('public/assets/images/plan_feature_image/');
            $data[] = [$classRow,$action,$value->type, $value->title,$value->icon,$value->description, $value->sort_order, $isActive];
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
        $model = new PlanFeatures;
        $model->sort_order = PlanFeatures::getSortOrder();
        $baseUrl = '';
        return view('admin.plan_features.form', compact('model','baseUrl'));
    }

    public function store(Request $request)
    {
        try {

            $input = $request->all();
            $model = PlanFeatures::create($input);
            if ($request->hasFile('icon')) {
                $fileObject = $request->file('icon');
                $image = PlanFeatures::uploadAndSaveImage($fileObject);
                // $input['image'] = $image;
                $model->icon = $image;
                $model->update();
            }else{
                if (isset($input['icon'])) {
                    unlink($input['icon']);
                }
            }
            $notification = array(
                'message' => 'Plan Features added successfully!',
                'alert-type' => 'success'
            );
            return redirect(config('app.adminPrefix').'/plan-features/index')->with($notification);
        } catch (\Exception $e) {
            return redirect(config('app.adminPrefix').'/plan-features/index');
        }
    }

    public function edit($id)
    {
        $model = PlanFeatures::findOrFail($id);
        $baseUrl=$this->getBaseUrl();
        return view('admin.plan_features.form', compact('model','baseUrl'));
    }

    public function update(Request $request,$id)
    {
        
        try {
            
            
            $model = PlanFeatures::findOrFail($id);
            $input = $request->all();
            $model->update($input);
            if ($request->hasFile('icon')) {
                $fileObject = $request->file('icon');
                $image = PlanFeatures::uploadAndSaveImage($fileObject,$id);
                $model->icon = $image;
                $model->update();
            }else{
                if (isset($input['icon'])) {
                    unlink($input['icon']);
                }
            }
            $notification = array(
                'message' => 'Plan Features updated successfully!',
                'alert-type' => 'success'
            );
            return redirect(config('app.adminPrefix').'/plan-features/index')->with($notification);
        } catch (\Exception $e) {
            return redirect(config('app.adminPrefix').'/plan-features/index');
        }
    }

    public function activeInactive(Request $request)
    {
        try {
            $plan = PlanFeatures::where('id', $request->id)->first();
            if ($request->status == 1) {
                $plan->status = $request->status;
                $msg = "Plan feature activated successfully!";
            } else {
                $plan->status = $request->status;
                $msg = "Plan feature deactivated successfully!";
            }
            $plan->save();
            $result['status'] = 'true';
            $result['msg'] = $msg;
            return $result;
        } catch (\Exception $ex) {
            return view('errors.500');
        }
    }

    public function delete(Request $request)
    {
        $plan = PlanFeatures::where('id', $request->id)->first();
        if (!empty($plan)) {
            $plan->deleted_at = Carbon::now();
            $plan->deleted = '1';
            $plan->save();
            $result['status'] = 'true';
            $result['msg'] = "Plan feature deleted successfully!";
            return $result;
        } else {
            $result['status'] = 'false';
            $result['msg'] = "Something went wrong!!";
            return $result;
        }
    }
}
