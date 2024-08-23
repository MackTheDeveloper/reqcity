<?php

namespace App\Http\Controllers\FrontEnd\Company;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use App\Models\User;
use App\Models\Companies;
use App\Models\CompanyAddress;
use App\Models\CompanyQuestionnaires;
use App\Models\CompanyQuestionnairesType;
use App\Models\CompanyQuestionnaireTemplates;
use App\Models\CompanyQuestionnaireType;
use App\Models\CompanyTransaction;
use App\Models\CompanyUser;
use App\Models\Country;
use App\Models\JobFieldOption;
use Exception;
use Auth;
use Response;
use Mail;
use Illuminate\Support\Facades\Session;
use Illuminate\Routing\Route;
use Illuminate\Support\Facades\URL;

class CompanyQuestionnaireController extends Controller
{
    public function index(){
        $isEditable = whoCanCheckFront('company_questionnaire_edit');
        $isDeletable = whoCanCheckFront('company_questionnaire_delete');
        $shoAction = ($isEditable || $isDeletable);
        return view('frontend.company.questionnaire.index',compact('shoAction'));
    }

    public function list(Request $request)
    {
        $req = $request->all();
        $page = !empty($req['page']) ? $req['page'] : 1;
        if ($page) {
            $length = 10;
            $start = ($page - 1) * $length;
        }
        $search = ""; //$req['search']['value'];
        
        $userId = Auth::user()->id;
        $company_id = CompanyUser::getCompanyIdByUserId($userId);

        $total = CompanyQuestionnaireTemplates::has('User')->where('company_id',$company_id)->selectRaw('count(*) as total')->first();
        
        $query = CompanyQuestionnaireTemplates::has('User')->where('company_id',$company_id)->whereNull('deleted_at');

        $filteredq = CompanyQuestionnaireTemplates::has('User')->where('company_id',$company_id)->whereNull('deleted_at');

        $totalfiltered = $total->total;

        $query = $query->offset($start)->limit($length)->get();

        $data = [];
        foreach ($query as $key => $value) {
            $id = $value->id;
            $editUrl = route('companyQuestionnaireManagmentEdit',$value->id);
            $module = 'company-questionnaire-management';
            $isEditable = whoCanCheckFront('company_questionnaire_edit');
            $isDeletable = whoCanCheckFront('company_questionnaire_delete');
            $action = view('frontend.company.components.action-normal', compact('id', 'editUrl', 'module', 'isEditable', 'isDeletable'))->render();
            $dataSingle = [
                "title" => $value->title,
                "createdBy" => $value->user->firstname.' '. $value->user->lastname,
                "date" => getFormatedDate($value->created_at, 'd M Y'),
                // "action" => $action
            ];
            if($isEditable || $isDeletable){
                $dataSingle['action'] = $action;
            }
            $data[] = $dataSingle;
        }
        $json_data = array(
            "recordsTotal" => intval($total->total),
            "recordsFiltered" => intval($totalfiltered),
            "recordPerPage" => $length,
            "currentPage" => $page,
            "data" => $data,
        );
        // pre($data);
        return Response::json($json_data);
    }

    public function create()
    {
        $model = new CompanyQuestionnaireTemplates();
        $types = CompanyQuestionnaireType::getData();
        $typeChoices = CompanyQuestionnaireType::getHasChoicesType();
        return view('frontend.company.questionnaire.form',compact('model', 'types'));
    }

    public function store(Request $request)
    {
        $input = $request->all();
        $data = CompanyQuestionnaireTemplates::addTemplate($input['template']);
        if ($data['success']) {
            $templateId = $data['data'];
            CompanyQuestionnaires::addUpdateData($templateId, $input['question'], $input['option']);
            $notification = array(
                'message' => config('message.frontendMessages.questionnaire.add'),
                'alert-type' => 'success'
            );
            return redirect()->route('companyQuestionnaireManagment')->with($notification);
        }
    }


    public function edit($id)
    {
        $model = CompanyQuestionnaireTemplates::find($id);
        $types = CompanyQuestionnaireType::getData();
        $typeChoices = CompanyQuestionnaireType::getHasChoicesType();
        return view('frontend.company.questionnaire.form', compact('model', 'types', 'typeChoices'));
    }

    public function update($id,Request $request)
    {
        $input = $request->all();
        // pre($input);
        $data = CompanyQuestionnaireTemplates::editTemplate($id,$input['template']);
        if ($data['success']) {
            $templateId = $data['data'];
            CompanyQuestionnaires::addUpdateData($templateId, $input['question'], $input['option']);

            $notification = array(
                'message' => config('message.frontendMessages.questionnaire.update'),
                'alert-type' => 'success'
            );
            return redirect()->route('companyQuestionnaireManagment')->with($notification);
        }
    }
    
    public function delete($id)
    {
        $model = CompanyQuestionnaireTemplates::find($id);
        if ($model) {
            $model->delete();
            $notification = array(
                'message' => config('message.frontendMessages.questionnaire.delete'),
                'alert-type' => 'success'
            );
            return Response::json($notification);
        }
    }
}
