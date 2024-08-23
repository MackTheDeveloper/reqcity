<?php

namespace App\Http\Controllers\FrontEnd\Recruiter;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use App\Models\User;
use App\Models\Companies;
use App\Models\CompanyAddress;
use App\Models\JobBalanceTransferRequests;
use App\Models\CompanyJob;
use App\Models\CompanyJobApplications;
use App\Models\Category;
use App\Models\JobFieldOption;
use App\Models\CompanyJobCommunications;
use App\Models\Admin;
use App\Models\Country;
use App\Models\RecruiterCandidate;
use App\Models\RecruiterCandidateResume;
use App\Models\RecruiterFavouriteJobs;
use Exception;
use Auth;
use Response;
use Mail;
use Illuminate\Support\Facades\Session;
use Illuminate\Routing\Route;
use Illuminate\Support\Facades\URL;

class RecruiterCandidatesController extends Controller
{
  public function index(Request $request)
  {
    return view('frontend.recruiter.candidate.index');
  }

  public function getList(Request $request)
  {
    $req = $request->all();

    $page = !empty($req['page']) ? $req['page'] : 1;
    if ($page) {
      $length = \Config::get('app.dataTable')['length'];
      $start = ($page - 1) * $length;
    }
    $search = $req['search'];
    $posted = $req['posted'];
    $userId = Auth::user()->id;

    $total = RecruiterCandidate::selectRaw('count(*) as total')->where('recruiter_id', '=', $userId)->first();
    $query = RecruiterCandidate::where('recruiter_id', $userId);
    $filteredq = RecruiterCandidate::where('recruiter_id', $userId);

    $totalfiltered = $total->total;
    if ($search != '') {
      $query->where(function ($query2) use ($search) {
        $query2->where('recruiter_candidates.name', 'like', '%' . $search . '%')
          ->orWhere('recruiter_candidates.email', 'like', '%' . $search . '%');
      });

      $filteredq->where(function ($query2) use ($search) {
        $query2->where('recruiter_candidates.name', 'like', '%' . $search . '%')
          ->orWhere('recruiter_candidates.email', 'like', '%' . $search . '%');
      });

      $filteredq = $filteredq->selectRaw('count(*) as total')->first();
      $totalfiltered = $filteredq->total;
    }

    if ($posted == "recently") {
      $query->orderBy('recruiter_candidates.created_at', 'DESC');
    } else if ($posted == "old") {
      $query->orderBy('recruiter_candidates.created_at', 'ASC');
    } else if ($posted == "title_asc") {
      $query->orderBy('recruiter_candidates.name', 'ASC');
    } else if ($posted == "title_desc") {
      $query->orderBy('recruiter_candidates.name', 'DESC');
    } else {
      $query->orderBy('recruiter_candidates.created_at', 'DESC');
    }

    $query = $query->offset($start)->limit($length)->get();

    $data = [];
    foreach ($query as $key => $value) {
      $resumeImage = '<img src="' . url('public/assets/frontend/img/pdf.svg') . '" alt="" />';
      $resume = RecruiterCandidateResume::getLatestResume($value->id);
      if (!empty($resume) && !empty($resume['cv']))
        $resumeCv = "<a class='pdf-link' href='" . $resume['cv'] . "' target='_blank'>" . $resumeImage . "</a>";
      else
        $resumeCv = '';


      $linkedInImage = '<img src="' . url('public/assets/frontend/img/Linkedin-btn.svg') . '" alt="" />';
      $linkedIn = !empty($value->linkedin_profile) ? "<a class='linkdin-link' href='" . $value->linkedin_profile . "' target='_blank'>" . $linkedInImage . "</a>" : '';

      $id = $value->id;
      $module = 'recruiter/candidates';
      $editInPopup = 1;
      $action = view('frontend.recruiter.components.action', compact('id', 'module', 'editInPopup'))->render();
      $name = [
        "name" => $value->name,
        "diverse" => $value->is_diverse_candidate,
      ];
      $data[] = [
        "name" => $name,
        "number" => $value->phone_ext . " " . $value->phone,
        "email" => $value->email,
        "city" => $value->city,
        "state" => $value->state,
        "country" => $value->Countrydata->name,
        "resume" => $resumeCv,
        "linkedIn" => $linkedIn,
        "action" => $action,
      ];
    }
    $json_data = array(
      "recordsTotal" => intval($total->total),
      "recordsFiltered" => intval($totalfiltered),
      "recordPerPage" => $length,
      "currentPage" => $page,
      "data" => $data,
    );
    return Response::json($json_data);
  }

  public function create()
  {
    $model = new RecruiterCandidate();
    $countries = Country::getListForDropdown();
    $userId = Auth::user()->id;
    $modelCv = [];
    return view('frontend.recruiter.candidate.components.add-edit-body', compact('model', 'countries', 'modelCv', 'userId'));
  }

  public function edit($id)
  {
    $model = RecruiterCandidate::find($id);
    $countries = Country::getListForDropdown();
    $userId = Auth::user()->id;
    $modelCv = RecruiterCandidateResume::getLatestResume($id);
    return view('frontend.recruiter.candidate.components.add-edit-body', compact('model', 'countries', 'modelCv', 'userId'));
  }

  public function store(Request $request)
  {
    $input = $request->all();
    if (!empty($input['_candidate']['phone_ext'])) {
      $input['candidate']['phone_ext'] = $input['_candidate']['phone_ext'];
      unset($input['_candidate']);
    }
    $fileObject = $request->file('candidate_cv.cv');
    $candidate = $input['candidate'];
    if (!empty($candidate['id'])) {
      if(!isset($input['candidate']['is_diverse_candidate']))
      $candidate['is_diverse_candidate']=0;
      $candidateUpdated = RecruiterCandidate::editData($candidate['id'], $candidate);
      $candidateId = $candidateUpdated['data'];
      $resMessage = config('message.frontendMessages.candidate.update');
    } else {
      $candidateUpdated = RecruiterCandidate::addData($candidate);
      $candidateId = $candidateUpdated['data'];
      $resMessage = config('message.frontendMessages.candidate.add');
    }
    if ($candidateId && $request->hasFile('candidate_cv.cv')) {
      $fileObject = $request->file('candidate_cv.cv');
      $cvId = RecruiterCandidateResume::uploadResume($candidateId, $fileObject);
    }
    $notification = array(
      'message' => $resMessage,
      'alert-type' => 'success'
    );
    return redirect()->route('recruiterCandidates')->with($notification);
  }

  public function delete($id)
  {
    $model = RecruiterCandidate::find($id);
    if ($model) {
      $model->delete();
      $notification = array(
        'message' => config('message.frontendMessages.candidate.delete'),
        'alert-type' => 'success'
      );
      return Response::json($notification);
    }
  }

  public function checkUniqueEmail(Request $request)
  {
    $input = $request->all();
    $email = $input['email'];
    $id = $input['id'];
    $userId = $input['userId'];

    $return = true;
    if ($id)
      $data = RecruiterCandidate::where('recruiter_candidates.email', $email)->where('recruiter_id', $userId)->where('id', '<>', $id)->first();
    else
      $data = RecruiterCandidate::where('recruiter_candidates.email', $email)->where('recruiter_id', $userId)->first();
    if (empty($data)) {
      $return = true;
    } else {
      $return = false;
    }
    $json_data = array(
      "data" => $return,
    );
    return Response::json($json_data);
  }
}
