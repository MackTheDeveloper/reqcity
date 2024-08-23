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
use App\Models\CompanyFaqs;
use App\Models\CompanyFaqsTemplates;
use App\Models\CompanyJob;
use App\Models\CompanyJobFunding;
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

class CompanyFaqsTemplatesController extends Controller
{

    public function index(Request $request)
    {
        $userId = Auth::user()->id;
        if ($userId) {
            try {
                $isEditable = whoCanCheckFront('company_communication_management_edit');
                $isDeletable = whoCanCheckFront('company_communication_management_delete');
                $shoAction = ($isEditable || $isDeletable); 
                return view('frontend.company.faq-templates.index',compact('shoAction'));
            } catch (Exception $e) {
                return redirect()->route('showMyInfoCompany');
            }
        }
    }

    public function getList(Request $request)
    {
        //$companyId = Auth::user()->company->id;
        $companyId = CompanyUser::getCompanyIdByUserId(Auth::user()->id);
        $req = $request->all();
        $page = !empty($req['page']) ? $req['page'] : 1;
        if ($page) {
            $length = \Config::get('app.dataTable')['length'];
            $start = ($page - 1) * $length;
        }
        $search = "";

        $total = CompanyFaqsTemplates::selectRaw('count(*) as total')->has('companyUser')->where('company_id', '=', $companyId)->where('status', 1)->first();
        $query = CompanyFaqsTemplates::has('companyUser')->where('company_id', $companyId)->where('status', 1);
        $filteredq = CompanyFaqsTemplates::has('companyUser')->where('company_id', $companyId)->where('status', 1);
        $totalfiltered = $total->total;
        $query = $query->offset($start)->limit($length)->get();

        $data = [];
        foreach ($query as $key => $value) {
            $id = $value->id;
            $editUrl = route('editCompanyCommunicationManagment',$value->id);
            $module = 'company-communication-management';
            $isEditable = whoCanCheckFront('company_communication_management_edit');
            $isDeletable = whoCanCheckFront('company_communication_management_delete');
            $action = view('frontend.company.components.action-normal', compact('id', 'editUrl', 'module','isEditable','isDeletable'))->render();
            $dataSingle = [
                "template" => $value->title,
                "createdBy" => $value->companyUser->firstname,
                "date" => getFormatedDate($value->created_at, 'd M Y'),
                // "action" => $action,
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
        return Response::json($json_data);
    }

    public function create(Request $request)
    {
        $model = new CompanyFaqsTemplates();
        return view('frontend.company.faq-templates.form', compact('model'));
    }

    public function store(Request $request)
    {
        $userId = Auth::user()->id;
        $companyId = Auth::user()->company->id;
        $input = $request->all();
        
        $faqsTemplatesData = CompanyFaqsTemplates::addTemplate($input['companyFaqsTemplates']);

        if ($faqsTemplatesData['success'] && isset($input['companyFaqs'])) {
            $templateId = $faqsTemplatesData['templateId'];
            CompanyFaqs::addUpdateData($templateId, $input['companyFaqs']);
        }

        $notification = array(
            'message' => config('message.frontendMessages.communicationMgt.add'),
            'alert-type' => 'success'
        );
        return redirect()->route('companyCommunicationManagment')->with($notification);
    }

    public function edit(Request $request, $id)
    {
        $model = CompanyFaqsTemplates::find($id);
        return view('frontend.company.faq-templates.form', compact('model'));
    }

    public function update(Request $request, $id)
    {
        $input = $request->all();
        // pre($input);
        $faqsTemplatesData = CompanyFaqsTemplates::editTemplate($id,$input['companyFaqsTemplates']);
        if ($faqsTemplatesData['success']) {
            $templateId = $faqsTemplatesData['templateId'];
            CompanyFaqs::addUpdateData($templateId, $input['companyFaqs']);
        }

        $notification = array(
            'message' => config('message.frontendMessages.communicationMgt.update'),
            'alert-type' => 'success'
        );
        return redirect()->route('companyCommunicationManagment')->with($notification);
    }

    public function addFaqs()
    {
        $countFaqs = $_POST['countFaqs'];
        return view('frontend.company.faq-templates.components.add-more', compact('countFaqs'));
    }

    public function delete($id)
    {
        $model = CompanyFaqsTemplates::find($id);
        if ($model) {
            $model->delete();
            $notification = array(
                'message' => config('message.frontendMessages.communicationMgt.delete'),
                'alert-type' => 'success'
            );
            return Response::json($notification);
        }
    }
}
