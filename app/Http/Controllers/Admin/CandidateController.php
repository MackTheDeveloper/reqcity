<?php

namespace App\Http\Controllers\Admin;

use App\Exports\CandidateListExport;
use App\Http\Controllers\Controller;
use App\Models\Candidate;
use App\Models\CandidateResume;
use App\Models\CompanyJobFunding;
use App\Models\CompanyJob;
use App\Models\SubscriptionPlan;
use App\Models\Companies;
use App\Models\Country;
use App\Models\User;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use Auth;
use DataTables;
use Carbon\Carbon;
use DB;
use Excel;
use Response;

class CandidateController extends Controller
{
    public function index(Request $request)
    {
        $req = $request->all();
        //  $search = (isset($req['search']) ? $req['search'] : '');
        $company = Companies::getList();
        return view("admin.candidate.index", compact('company'));
    }
    public function list(Request $request)
    {
        $req = $request->all();
        $start = $req['start'];
        $length = $req['length'];
        $search = $req['search']['value'];
        $order = $req['order'][0]['dir'];
        $column = $req['order'][0]['column'];
        $orderby = ['id', '', 'first_name', 'email', 'phone', 'job_title', 'country', 'city', 'postcode', '', '', 'status', 'created_at'];

        $total = Candidate::selectRaw('count(*) as total')->whereNull('candidates.deleted_at')->first();
        $query = Candidate::select('candidates.*', 'countries.name as countryName')
            ->leftJoin('countries', 'candidates.country', 'countries.id')
            ->whereNull('candidates.deleted_at');

        $filteredq = Candidate::select('candidates.*', 'countries.name as countryName')
            ->leftJoin('countries', 'candidates.country', 'countries.id')
            ->whereNull('candidates.deleted_at');

        $totalfiltered = $total->total;
        if ($search != '') {
            $query->where(function ($query2) use ($search) {
                $query2->where('candidates.first_name', 'like', '%' . $search . '%')
                    ->orWhere('candidates.last_name', 'like', '%' . $search . '%')
                    ->orWhere('job_title', 'like', '%' . $search . '%')
                    ->orWhere('city', 'like', '%' . $search . '%');
            });

            $filteredq->where(function ($query2) use ($search) {
                $query2->where('candidates.first_name', 'like', '%' . $search . '%')
                    ->orWhere('candidates.last_name', 'like', '%' . $search . '%')
                    ->orWhere('job_title', 'like', '%' . $search . '%')
                    ->orWhere('city', 'like', '%' . $search . '%');
            });

            $filteredq = $filteredq->selectRaw('count(*) as total')->first();
            $totalfiltered = $filteredq->total;
        }
        if (isset($request->is_active) && $request->is_active != "") {
            $filteredq = $filteredq->where('candidates.status', $request->is_active);
            $query = $query->where('candidates.status', $request->is_active);
        }
        // if (isset($request->company) && $request->company!='all') {
        //     $filteredq = $filteredq->where('companies.id', $request->company);
        //     $query = $query->where('companies.id', $request->company);
        // }
        if (!empty($request->startDate) && !empty($request->endDate)) {
            $startDate = date($request->startDate);
            $endDate = date($request->endDate);
            $filteredq = $filteredq->where(function ($q) use ($startDate, $endDate) {
                $q->whereBetween('candidates.created_at', [$startDate, $endDate]);
            });
            $query = $query->where(function ($q) use ($startDate, $endDate) {
                $q->whereBetween('candidates.created_at', [$startDate, $endDate]);
            });
            $recordCount = $filteredq->selectRaw('count(*) as total')->first();
            $totalfiltered = $recordCount->total;
        }
        $query = $query->orderBy($orderby[$column], $order)->offset($start)->limit($length)->get();
        // $query = $query->offset($start)->limit($length)->get();
        // $firstname = Subscription::select('firstname')->leftJoin("users","subscriptions.customer_id","=","users.role_id")->first();
        //$duration = Subscription::select('duration')->leftJoin("subscription__plans", "subscriptions.subscription_plan","=","subscription__plans.id")->first();
        $data = [];
        // $imagePath = url('public/assets/images/candidate-img');
        foreach ($query as $key => $value) {
            $isActive = '';
            $action = '';
            $activeInactive = $edit = '';
            if ($value->status == 1) {
                $isActive .= '<button type="button" class="btn btn-sm btn-toggle active toggle-is-active-switch" data-id="' . $value->id . '" data-toggle="button" aria-pressed="true" autocomplete="off"><div class="handle"></div></button>';
            } else {
                $isActive .= '<button type="button" class="btn btn-sm btn-toggle toggle-is-active-switch" data-id="' . $value->id . '" data-toggle="button" aria-pressed="false" autocomplete="off"><div class="handle"></div></button>';
            }
            if (whoCanCheck(config('app.arrWhoCanCheck'), 'admin_candidate_edit')) {
                $activeInactive = '<li class="nav-item">'
                    . '<a class="nav-link active-inactive-link" data-id="' . $value->id . '" data-status="' . $value->status . '" >Mark as ' . (($value->status == '1') ? 'Inactive' : 'Active') . '</a>'
                    . '</li>';
            }
            if (whoCanCheck(config('app.arrWhoCanCheck'), 'admin_candidate_edit')) {
                $edit = '<li class="nav-item">'
                    . '<a class="nav-link" href="' . route('candidateEdit', $value->id) . '" >Edit</a>'
                    . '</li>';
            }
            if ($activeInactive || $edit) {
                $action .= '<div class="d-inline-block dropdown">'
                    . '<button type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" class="btn-shadow dropdown-toggle btn btn-primary">'
                    . '<span class="btn-icon-wrapper pr-2 opacity-7">'
                    . '<i class="fa fa-cog fa-w-20"></i>'
                    . '</span>'
                    . '</button>'
                    . '<div tabindex="-1" role="menu" aria-hidden="true" class="dropdown-menu dropdown-menu-right">'
                    . '<ul class="nav flex-column">'
                    . $activeInactive
                    . $edit
                    . '</ul>'
                    . '</div>'
                    . '</div>';
            }
            $resume = CandidateResume::getLatestResumeNew($value->id);
            $resume = (isset($resume->resume) && $resume->resume != "") ? $resume->resume : Null;
            $downloadLink = "";
            $extension = pathinfo(storage_path($resume), PATHINFO_EXTENSION);
            if ($extension == "pdf") {
                $downloadLink = '<a href="' . $resume . '" download><i class="fas fa-file-pdf"></i></a>';
            } else {
                $downloadLink = '<a href="' . $resume . '" download><i class="fas fa-file-word"></i></a>';
            }
            if (!isset($resume)) {
                $downloadLink = "Not Uploaded";
            }
            $image = '<img width="50" height="50" src=' . $value->profile_pic . '/>';
            $linkedin = "-";
            if ($value->linkedin_profile_link != "") {
                $logo = url('public/assets/frontend/img/Linkedin-btn.svg');
                $linkedin = '<a href="' . $value->linkedin_profile_link . '" target="_blank" class="icon-btns">
                <img src="' . $logo . '" alt="" />
                </a>';
            }
            $data[] = [$value->id, $action, $image, $value->first_name . ' ' . $value->last_name, $value->email, $value->phone_ext . '-' . $value->phone, ($value->job_title) ?: "-", ($value->countryName) ?: "-", ($value->city) ?: "-", ($value->postcode) ?: "-", $downloadLink, $linkedin, $value->status, getFormatedDate($value->created_at)];
        }
        $json_data = array(
            "draw" => intval($_REQUEST['draw']),
            "recordsTotal" => intval($total->total),
            "recordsFiltered" => intval($totalfiltered),
            "data" => $data,
        );
        return Response::json($json_data);
    }

    public function candidateChangeStatus(Request $request)
    {
        try {
            $candidate = Candidate::where('id', $request->candidate_id)->first();
            // dd($request->status);
            if ($request->status == 1) {
                $candidate->status = $request->status;
                $msg = "Candidate Activated Successfully!";
            } else {
                $candidate->status = $request->status;
                $msg = "Candidate Inactivated Successfully!";
            }
            $candidate->save();
            $result['status'] = 'true';
            $result['msg'] = $msg;
            return $result;
        } catch (\Exception $ex) {
            return view('errors.500');
        }
    }

    public function exportCandidateList(Request $request)
    {
        try {
            return Excel::download(new CandidateListExport(), 'ReqCity_Candidate_lists.xlsx');
        } catch (\Exception $ex) {
            return view('errors.500');
        }
    }

    public function edit($id)
    {
        $candidate = Candidate::where('id', $id)->first();
        // pre($candidate);
        $countries = Country::getListForDropdown();
        $resume = $candidate ? CandidateResume::getLatestResumeNew($candidate->id) : [];
        // pre($resume);
        return view("admin.candidate.form", compact('candidate', 'countries', 'resume'));
    }

    public function update($id, Request $request)
    {
        $input = $request->all();
        // pre($input);
        unset($input['_token']);
        unset($input['email']);
        unset($input['resume']);
        Candidate::where('id', $id)->update($input);
        if ($request->hasFile('resume')) {
            $fileObject = $request->file('resume');
            $file = Candidate::uploadResume($id, $fileObject);
        }
        $userId = Candidate::getUserId($id);
        if ($userId) {
            User::where('id', $userId)->update(['firstname' => $input['first_name'], 'lastname' => $input['last_name']]);
        }
        $notification = array(
            'message' => 'Details Updated Successfully!',
            'alert-type' => 'success'
        );
        return redirect()->route('candidateListing')->with($notification);
    }
}
