<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use App\Models\SubscriptionPlan;
use Auth;
use Validator;
use Carbon\Carbon;
use DataTables;
use Response;
use DB;
use Image;


class SubscriptionPlanController extends Controller
{
    public function index()
    {
        return view("admin.subscription-plan.index");
    }

    public function list(Request $request)
    {
        $isEditable = whoCanCheck(config('app.arrWhoCanCheck'), 'admin_subscription_plan_edit');
        $isDeletable = whoCanCheck(config('app.arrWhoCanCheck'), 'admin_subscription_plan_delete');
        $req = $request->all();
        $start = $req['start'];
        $length = $req['length'];
        $search = $req['search']['value'];
        $order = $req['order'][0]['dir'];
        $column = $req['order'][0]['column'];
        $orderby = ['id', '', 'type', 'subscription_name', '', 'plan_type', 'price', ''];
        $sumAmount = 0;
        $sumAmountQuery = SubscriptionPlan::selectRaw('SUM(subscription_plans.price) as sumAmount')->whereNull('deleted_at');
        $total = SubscriptionPlan::selectRaw('count(*) as total')->whereNull('deleted_at')->first();
        $query = SubscriptionPlan::whereNull('deleted_at');
        $filteredq = SubscriptionPlan::whereNull('deleted_at');
        $totalfiltered = $total->total;

        if ($search != '') {
            $query->where(function ($query2) use ($search) {
                $query2->where('subscription_name', 'like', '%' . $search . '%');
                //$query2->where('slug', 'like', '%' . $search . '%');
            });
            $filteredq->where(function ($query2) use ($search) {
                $query2->where('subscription_name', 'like', '%' . $search . '%');
                //  $query2->where('slug', 'like', '%' . $search . '%');
            });
            $sumAmountQuery->where(function ($query2) use ($search) {
                $query2->where('subscription_name', 'like', '%' . $search . '%');
                //  $query2->where('slug', 'like', '%' . $search . '%');
            });
            $filteredq = $filteredq->selectRaw('count(*) as total')->first();
            $totalfiltered = $filteredq->total;
        }
        $sumAmountQuery = $sumAmountQuery->first();
        $sumAmount = $sumAmountQuery->sumAmount;
        if (empty($sumAmount))
            $sumAmount = 0;
        $query = $query->orderBy($orderby[$column], $order)->offset($start)->limit($length)->get();
        $data = [];
        foreach ($query as $key => $value) {
            $isActive = '';
            $action = '';
            $editUrl = route('editSubscriptionPlan', $value->id);
            if ($value->status == 1) {
                $isActive .= '<button type="button" class="btn btn-sm btn-toggle active toggle-is-active-switch" data-id="' . $value->id . '" data-toggle="button" aria-pressed="true" autocomplete="off"><div class="handle"></div></button>';
            } else {
                $isActive .= '<button type="button" class="btn btn-sm btn-toggle toggle-is-active-switch" data-id="' . $value->id . '" data-toggle="button" aria-pressed="false" autocomplete="off"><div class="handle"></div></button>';
            }
            $edit = '<li class="nav-item">'
                . '<a class="nav-link" href="' . $editUrl . '">Edit</a>'
                . '</li>';
            $activeInactive = ($isEditable) ? '<li class="nav-item">'
                . '<a style="pointer-events: none" class="nav-link active-inactive-link" >Mark as ' . (($value->status == '1') ? 'Inactive' : 'Active') . '</a>'
                . '</li>' : '';

            $delete = ($isDeletable) ? '<li class="nav-item">'
                . '<a style="pointer-events: none" class="nav-link subscription_plan_delete" data-id="' . $value->id . '">Delete</a>'
                . '</li>' : '';
            if ($activeInactive || $delete) {
                $action .= '<div class="d-inline-block dropdown">'
                    . '<button type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" class="btn-shadow dropdown-toggle btn btn-primary">'
                    . '<span class="btn-icon-wrapper pr-2 opacity-7">'
                    . '<i class="fa fa-cog fa-w-20"></i>'
                    . '</span>'
                    . '</button>'
                    . '<div tabindex="-1" role="menu" aria-hidden="true" class="dropdown-menu dropdown-menu-right">'
                    . '<ul class="nav flex-column">'
                    . $edit . $activeInactive . $delete
                    . '</ul>'
                    . '</div>'
                    . '</div>';
            }
            $baseUrl = $this->getBaseUrl();
            $image = '<img width="50" height="50" src=' . $baseUrl . '/public/assets/images/subscription-plan/' . $value->icon . '/>';
            $classRow = $value->status ? "" : "row_inactive";
            $data[] = [$classRow, $action, ucfirst($value->type), $value->subscription_name, $image, ucfirst($value->plan_type), $value->price, $isActive];
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
        $model = new SubscriptionPlan;
        //  $model->sort_order = SubscriptionPlan::getSortOrder();
        return view('admin.subscription-plan.form', compact('model'));
    }

    public function store(Request $request)
    {
        $input = $request->all();
        $validator = Validator::make(
            $input,
            [
                'subscription_name' => 'required',
                'description' => 'required',
                'tag_line' => 'required',
                'price' => 'required',
                'icon' => 'required|mimes:jpeg,jpg,png,gif',
            ]
        );

        if ($validator->fails()) {
            $notification = array(
                'message' => 'Validation Required!',
                'alert-type' => 'error'
            );
            return redirect(config('app.adminPrefix') . '/subscription-plan/index')->with($notification);
        } else {
            $plan = new SubscriptionPlan();
            $plan->subscription_name = $request->subscription_name;
            $plan->type = $request->type;
            $plan->plan_type = $request->plan_type;
            $plan->description = $request->description;
            $plan->tag_line = $request->tag_line;
            $plan->price = $request->price;
            $plan->flag_recommended = $request->flag_recommended;
            $plan->trial_period = $request->trial_period;
            if ($request->hasFile('icon')) {
                $fileObject = $request->file('icon');
                $image = SubscriptionPlan::uploadAndSaveImage($fileObject);
                // $input['image'] = $image;
                $plan->icon = $image;
            } else {
                if (isset($input['icon'])) {
                    unlink($input['icon']);
                }
            }
            // if ($request->hasFile('image')) {
            //     $photo = $request->file('image');
            //     $ext = $photo->extension();
            //     $filename = rand().'_'.time().'.'.$ext;
            //     $filePath = public_path().'/admin/music_category/';
            //     $img = Image::make($photo->path());
            //     $width = config('app.musicCategoryIconDimension.width');
            //     $height = config('app.musicCategoryIconDimension.height');
            //     if($img->width() == $width && $img->height() == $height){
            //         $photo->move($filePath.'/', $filename);
            //     }else{
            //         $img->resize($width, $height)->save($filePath.'/'.$filename);
            //     }
            //     $cat->image = $filename;
            // }
            $plan->status = $request->status;
            $plan->save();

            $notification = array(
                'message' => 'Subscription added successfully!',
                'alert-type' => 'success'
            );
            return redirect(config('app.adminPrefix') . '/subscription-plan/index')->with($notification);
        }
    }

    public function edit($id)
    {
        $model = SubscriptionPlan::findOrFail($id);
        $baseUrl = $this->getBaseUrl();
        return view('admin.subscription-plan.form', compact('model', 'baseUrl'));
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
        $plan = SubscriptionPlan::findOrFail($id);
        if (!empty($plan)) {
            //  $plan = new SubscriptionPlan();
            $plan->subscription_name = $request->subscription_name;
            $plan->type = $request->type;
            $plan->plan_type = $request->plan_type;
            $plan->description = $request->description;
            $plan->tag_line = $request->tag_line;
            $plan->price = $request->price;
            $plan->flag_recommended = $request->flag_recommended;
            $plan->trial_period = $request->trial_period;
            if ($request->hasFile('icon')) {
                $fileObject = $request->file('icon');
                $image = SubscriptionPlan::uploadAndSaveImage($fileObject, $id);
                // $input['image'] = $image;
                $plan->icon = $image;
            } else {
                if (isset($input['icon'])) {
                    unlink($input['icon']);
                }
            }
            // if ($request->hasFile('image')) {
            //     $photo = $request->file('image');
            //     $ext = $photo->extension();
            //     $filename = rand().'_'.time().'.'.$ext;
            //     $filePath = public_path().'/admin/music_category/';
            //     $img = Image::make($photo->path());
            //     $width = config('app.musicCategoryIconDimension.width');
            //     $height = config('app.musicCategoryIconDimension.height');
            //     if($img->width() == $width && $img->height() == $height){
            //         $photo->move($filePath.'/', $filename);
            //     }else{
            //         $img->resize($width, $height)->save($filePath.'/'.$filename);
            //     }
            //     $home->image = $filename;
            // }
            //$home->sort_order = $request->sortOrder;
            $plan->status = $request->status;
            $plan->save();

            $notification = array(
                'message' => 'Subscription Plan updated successfully!',
                'alert-type' => 'success'
            );

            return redirect(config('app.adminPrefix') . '/subscription-plan/index')->with($notification);
        }
    }

    public function activeInactive(Request $request)
    {
        try {
            $model = SubscriptionPlan::where('id', $request->subscription_plan_id)->first();
            if ($request->status == 1) {
                $model->status = $request->status;
                $msg = "Subscription Plan Activated Successfully!";
            } else {
                $model->status = $request->status;
                $msg = "Subscription Plan Deactivated Successfully!";
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
        $model = SubscriptionPlan::where('id', $request->subscription_plan_id)->first();
        if (!empty($model)) {
            $model->deleted_at = Carbon::now();
            $model->save();
            $result['status'] = 'true';
            $result['msg'] = "Subscription Plan Deleted Successfully!";
            return $result;
        } else {
            $result['status'] = 'false';
            $result['msg'] = "Something went wrong!!";
            return $result;
        }
    }

    public function checkPlan(Request $request)
    {
        if ($request->planId) {
            $exist = SubscriptionPlan::where('id', $request->planId)->where('type', $request->type)
                ->where('plan_type', $request->planType)
                ->first();
            if($exist){
                $json_data = array(
                    "success" => true,
                );
                return Response::json($json_data);
            }else{
                $json_data = array(
                    "message" => "Plan already exist...!",
                    "success" => false,
                );
                return Response::json($json_data);
            }
        }else{
            $planExist = SubscriptionPlan::where('type', $request->type)
            ->where('plan_type', $request->planType)
            ->first();
            
            if ($planExist) {
                $json_data = array(
                    "message" => "Plan already exist...!",
                    "success" => false,
                );
                return Response::json($json_data);
            } else {
                $json_data = array(
                    "success" => true,
                );
                return Response::json($json_data);
            }
        }
        
    }
}
