<?php

namespace App\Http\Controllers\Admin;

use App\Exports\CandidateListExport;
use App\Http\Controllers\Controller;
use App\Models\HomePageBanner;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use Auth;
use Carbon\Carbon;
use DataTables;
use Response;
use Excel;
use DB;
use Image;

class HomePageBannerController extends Controller
{
    public function index(Request $request)
    {
        $req = $request->all();
        return view("admin.website_managements.home_page_banner");
    }
    public function list(Request $request)
    {
        $req = $request->all();
        $start = $req['start'];
        $length = $req['length'];
        $search = $req['search']['value'];
        $order = $req['order'][0]['dir'];
        $column = $req['order'][0]['column'];
        $orderby = ['id', 'title', 'sub_title', 'main_banner'];

        $total = HomePageBanner::selectRaw('count(*) as total')->whereNull('deleted_at')->first();
        $query = HomePageBanner::whereNull('deleted_at');

        $filteredq = HomePageBanner::whereNull('deleted_at');
        $totalfiltered = $total->total;
        if ($search != '') {
            $query->where(function ($query2) use ($search) {
                $query2->where('title', 'like', '%' . $search . '%')
                    ->orWhere('sub_title', 'like', '%' . $search . '%');
            });

            $filteredq->where(function ($query2) use ($search) {
                $query2->where('title', 'like', '%' . $search . '%')
                    ->orWhere('sub_title', 'like', '%' . $search . '%');
            });

            $filteredq = $filteredq->selectRaw('count(*) as total')->first();
            $totalfiltered = $filteredq->total;
        }
        $recordCount = $filteredq->selectRaw('count(*) as total')->first();
        $totalfiltered = $recordCount->total;
        $query = $query->orderBy($orderby[$column], $order)->offset($start)->limit($length)->get();
        // $query = $query->offset($start)->limit($length)->get();
        // $firstname = Subscription::select('firstname')->leftJoin("users","subscriptions.customer_id","=","users.role_id")->first();
        //$duration = Subscription::select('duration')->leftJoin("subscription__plans", "subscriptions.subscription_plan","=","subscription__plans.id")->first();
        $data = [];
        // $imagePath = url('public/assets/images/candidate-img');
        foreach ($query as $key => $value) {
            $isEditable = whoCanCheck(config('app.arrWhoCanCheck'), 'admin_home_page_banner_edit');
            $action = '';
            $editUrl = route('editHomePageBanner', $value->id);
            $edit = '<li class="nav-item">'
                . '<a class="nav-link" href="' . $editUrl . '">Edit</a>'
                . '</li>';

            if ($isEditable) {
                $action .= '<div class="d-inline-block dropdown">'
                    . '<button type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" class="btn-shadow dropdown-toggle btn btn-primary">'
                    . '<span class="btn-icon-wrapper pr-2 opacity-7">'
                    . '<i class="fa fa-cog fa-w-20"></i>'
                    . '</span>'
                    . '</button>'
                    . '<div tabindex="-1" role="menu" aria-hidden="true" class="dropdown-menu dropdown-menu-right">'
                    . '<ul class="nav flex-column">'
                    . $edit
                    . '</ul>'
                    . '</div>'
                    . '</div>';
            }
            $MainBanner = '<img width="50" height="50" src=' . HomePageBanner::getBannerImage($value->id) . '/>';
            $data[] = [$value->id, $action, $value->title, $value->sub_title, $MainBanner];
        }
        $json_data = array(
            "draw" => intval($_REQUEST['draw']),
            "recordsTotal" => intval($total->total),
            "recordsFiltered" => intval($totalfiltered),
            "data" => $data,
        );
        return Response::json($json_data);
    }
    public function edit($id)
    {
        $model = HomePageBanner::findOrFail($id);
        $MainBanner = HomePageBanner::getBannerImage($id);
        $HighlightJobsBanner = HomePageBanner::getHighlightJobsBannerImage($id);
        return view('admin.website_managements.form', compact('model', 'MainBanner', 'HighlightJobsBanner'));
    }

    public function update(Request $request, $id)
    {

        try {
            $model = HomePageBanner::findOrFail($id);
            $input = $request->all();
            $model->update($input);
            if ($request->hasFile('main_banner')) {
                $fileObject = $request->file('main_banner');
                $image = HomePageBanner::uploadAndSaveImage($fileObject, $id);
                $model->main_banner = $image;
                $model->update();
            } else {
                if (isset($input['main_banner'])) {
                    unlink($input['main_banner']);
                }
            }
            if ($request->hasFile('highlight_jobs_banner')) {
                $fileObject = $request->file('highlight_jobs_banner');
                $image = HomePageBanner::uploadAndSaveJobImage($fileObject, $id);
                $model->highlight_jobs_banner = $image;
                $model->update();
            } else {
                if (isset($input['highlight_jobs_banner'])) {
                    unlink($input['highlight_jobs_banner']);
                }
            }
            $notification = array(
                'message' => 'Home page banner updated successfully!',
                'alert-type' => 'success'
            );
            return redirect(config('app.adminPrefix') . '/home-page-banner/index')->with($notification);
        } catch (\Exception $e) {
            return redirect(config('app.adminPrefix') . '/home-page-banner/index');
        }
    }
}
