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
use App\Models\CompanyUser;
use App\Models\Country;
use Exception;
use Auth;
use Response;
use Mail;
use Illuminate\Support\Facades\Session;
use Illuminate\Routing\Route;
use Illuminate\Support\Facades\URL;

class CompanyAddressController extends Controller
{
    public function index(){
        $isEditable = whoCanCheckFront('company_address_edit');
        $isDeletable = whoCanCheckFront('company_address_delete');
        //$isViewable = whoCanCheckFront('company_address_view');
        $shoAction = ($isEditable || $isDeletable) ;
        return view('frontend.company.addresses.index',compact('shoAction'));
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

        $filteredq = CompanyAddress::where('company_id',$company_id)->leftjoin('countries','countries.id','=','company_address.country')->whereNull('deleted_at');
        $total = CompanyAddress::where('company_id',$company_id)->selectRaw('count(*) as total')->where('is_other','0')->first();
        
        $query = CompanyAddress::select('company_address.*','countries.name as CountryName')->where('company_id',$company_id)->leftjoin('countries','countries.id','=','company_address.country')->whereNull('company_address.deleted_at')->where('is_other','0');

        $filteredq = CompanyAddress::select('company_address.*','countries.name as CountryName')->where('company_id',$company_id)->leftjoin('countries','countries.id','=','company_address.country')->whereNull('company_address.deleted_at')->where('is_other','0');

        $totalfiltered = $total->total;

        $query = $query->offset($start)->limit($length)->get();

        $data = [];
        foreach ($query as $key => $value) {
            $id = $value->id;
            $editUrl = route('companyAddressEdit',$value->id);
            $module = 'company-address-management';
            $isEditable = whoCanCheckFront('company_address_edit');
            $isDeletable = whoCanCheckFront('company_address_delete');
            
            if($value->def_address==1)
            $defaultAdd='Yes';
            else
            $defaultAdd='No';
            $action = view('frontend.company.components.action-address', compact('id', 'editUrl', 'module', 'isEditable', 'isDeletable'))->render();
            $dataSingle = [
                "address_1" => $value->address_1,
                "city" => $value->city,
                "state" => $value->state?:"-",
                "country" => $value->CountryName,
                "postcode" => $value->postcode,
                "def_address" => $defaultAdd,
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
        $model = new CompanyAddress(); 
        $countries = Country::getListForDropdown();
        $userId = Auth::user()->id;
        $companyId = CompanyUser::getCompanyIdByUserId($userId);
        return view('frontend.company.addresses.form',compact('model','companyId','countries'));
    }

    public function store(Request $request)
    { 
        $input = $request->all();
        unset($input['_token']);
        unset($input['address_id']);
        $data = CompanyAddress::addAddress($input);
        if ($data['success']) {
            $addressId = $data['data'];
            //CompanyQuestionnaires::addUpdateData($templateId, $input['question'], $input['option']);
            $notification = array(
                'message' => config('message.frontendMessages.address.add'),
                'alert-type' => 'success'
            );
            return redirect()->route('companyAddressManagment')->with($notification);
        }else{
            $notification = array(
                'message' => $data['data'],
                'alert-type' => 'error'
            );
            return redirect()->route('companyAddressManagment')->with($notification);
        }
    }


    public function edit($id)
    {
        $model = CompanyAddress::find($id);
        $countries = Country::getListForDropdown();
        $userId = Auth::user()->id;
        $companyId = CompanyUser::getCompanyIdByUserId($userId);
        return view('frontend.company.addresses.form', compact('model','companyId','countries'));
    }

    public function update($id,Request $request)
    {
        $input = $request->all();
        unset($input['_token']);
        unset($input['address_id']);
        $data = CompanyAddress::editAddress($id,$input);
        if ($data['success']) {
            $addressId = $data['data'];
            //CompanyQuestionnaires::addUpdateData($templateId, $input['question'], $input['option']);
            $notification = array(
                'message' => config('message.frontendMessages.address.update'),
                'alert-type' => 'success'
            );
            return redirect()->route('companyAddressManagment')->with($notification);
        } else {
            $notification = array(
                'message' => $data['data'],
                'alert-type' => 'error'
            );
            return redirect()->route('companyAddressManagment')->with($notification);
        }
    }
    
    public function delete($id)
    {
        $model = CompanyAddress::find($id);
        if ($model) {
            $model->delete();
            $notification = array(
                'message' => config('message.frontendMessages.address.delete'),
                'alert-type' => 'success'
            );
            return Response::json($notification);
        }
    }
}
