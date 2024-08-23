<?php

namespace App\Http\Controllers\FrontEnd;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use App\Models\User;
use App\Models\Companies;
use App\Models\CompanyPermission;
use App\Models\CompanyUser;
use App\Models\Country;
use App\Models\EmailTemplates;
use App\Models\JobFieldOption;
use Exception;
use Auth;
use Response;
use Mail;
use Illuminate\Support\Facades\Session;
use Illuminate\Routing\Route;
use Illuminate\Support\Facades\URL;

class CompanyUserController extends Controller
{
    public function index(Request $request)
    {
        $authId = Auth::user()->id;
        $companyUser = CompanyUser::where('user_id', $authId)->first();
        $companyId = $companyUser->company_id;
        $isEditable = whoCanCheckFront('company_user_management_edit');
        $isDeletable = whoCanCheckFront('company_user_management_delete');
        $shoAction = ($isEditable || $isDeletable);
        return view('frontend.company.company-user.index', compact('companyId', 'shoAction'));
    }

    public function getCompanyUserList(Request $request)
    {
        $authId = Auth::user()->id;
        $companyUser = CompanyUser::where('user_id', $authId)->first();
        $companyId = $companyUser->company_id;
        $companyUserList = CompanyUser::companyUserList($companyId);
        return view('frontend.company.components.user-dropdown', compact('companyUserList'));
    }

    public function store(Request $request)
    {
        try {

            $input = $request->all();
            $input['phone_ext'] = $request->phone_ext_phoneCode;
            $input['prefix'] = $request->phone_ext_phoneCode;
            $input['firstname'] = $request->name;
            $input['role_id'] = 3;
            $input['user_type'] = 'frontend';
            $input['password'] = Hash::make($input['password']);
            $input['step'] = 'first';
            $input['is_active'] = '1';
            $input['registration_complete'] = '1';
            $user = User::create($input);
            $input['user_id'] = $user->id;
            $companyUser = CompanyUser::create($input);
            $json_data = array(
                "user_id" => $companyUser->id,
                "msg" => config('message.Users.AddUserSuccess'),
            );
            //Send a verification email
            $encId =  encrypt($user->id);
            $link = route('emailVerification', ['id' => $encId]);
            try {
                $data = ['FIRST_NAME' => $user->firstname, 'LAST_NAME' => '' , 'LINK' => $link];
                EmailTemplates::sendMail('email-verification', $data, $user->email);
            } catch (\Exception $e) {
                //pre($e->getMessage());
            }
            return Response::json($json_data);
        } catch (Exception $e) {
            $notification = array(
                'message' => config('message.frontendMessages.error.wrong'),
                'alert-type' => 'success'
            );
            return redirect()->route('companyUserIndex')->with($notification);
        }
    }

    public function companyUserList(Request $request)
    {
        $req = $request->all();
        $page = !empty($req['page']) ? $req['page'] : 1;
        if ($page) {
            $length = \Config::get('app.dataTable')['length'];
            $start = ($page - 1) * $length;
        }
        $search = ""; //$req['search']['value'];
        $userId = Auth::user()->id;
        $companyUser = CompanyUser::where('user_id', $userId)->first();
        $companyId =  $companyUser->company_id;
        $total = CompanyUser::selectRaw('count(*) as total')
            ->where('company_id', '=', $companyId)
            // ->where('is_owner', '!=', 1)
            ->whereNull('deleted_at')
            ->first();
        // pre($total);

        $query = CompanyUser::where('company_id', $companyId)
            // ->where('is_owner', '!=', 1)
            ->whereNull('deleted_at');

        $filteredq = CompanyUser::where('company_id', $companyId)
            // ->where('is_owner', '!=', 1)
            ->whereNull('deleted_at');

        $totalfiltered = $total->total;
        if (!empty($request->startDate) && !empty($request->endDate)) {
            $startDate = $request->startDate;
            $endDate = $request->endDate;
            $filteredq = $filteredq->where(function ($q) use ($startDate, $endDate) {
                $q->whereBetween('created_at', [$startDate, $endDate]);
            });
            $query = $query->where(function ($q) use ($startDate, $endDate) {
                $q->whereBetween('created_at', [$startDate, $endDate]);
            });
            $recordCount = $filteredq->selectRaw('count(*) as total')->first();
            $totalfiltered = $recordCount->total;
        }
        $query = $query->offset($start)->limit($length)->get();

        $data = [];
        foreach ($query as $key => $value) {
            // $data[] = [getFormatedDate($value->created_at), 'Paid for' . $value->subscriptionPlan->subscription_name . 'Subscription', $value->invoice_id];
            $id = $value->id;
            $isEditable = whoCanCheckFront('company_user_management_edit');
            $isDeletable = whoCanCheckFront('company_user_management_delete');
            $module = 'company-user';
            $action = view('frontend.company.components.action', compact('id', 'module', 'isEditable', 'isDeletable'))->render();
            $dataSingle = [
                "name" => $value->name,
                "email" => $value->email,
                "phone" => $value->phone_ext . "-" . $value->phone,
                "designation" => $value->designation ?: "N/A",
                // "action" => $action,
            ];
            
            if(!$value->is_owner){
                if ($isEditable || $isDeletable) {
                    $dataSingle['action'] = $action;
                }
            }else{
                if ($isEditable || $isDeletable) {
                    $dataSingle['action'] = "";
                }
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

    public function create()
    {
        $model = new CompanyUser();
        $authId = Auth::user()->id;
        $companyUser = CompanyUser::where('user_id', $authId)->first();
        $companyId = $companyUser->company_id;
        return view('frontend.company.company-user.form', compact('model', 'companyId'));
    }

    public function edit(Request $request)
    {
        $model = CompanyUser::find($request->id);
        if($model->is_owner){
            return False;
        }
        $authId = Auth::user()->id;
        $companyUser = CompanyUser::where('user_id', $authId)->first();
        $companyId = $companyUser->company_id;
        return view('frontend.company.company-user.form', compact('model', 'companyId'));
    }

    public function update(Request $request)
    {
        try {

            $input = $request->all();
            $modelId = $request->id;
            $input['phone_ext'] = $request->phone_ext_phoneCode;
            $input['firstname'] = $request->name;
            $input['role_id'] = 3;
            $input['user_type'] = 'frontend';
            $companyUser = CompanyUser::find($modelId);
            if ($request->password) {
                $input['password'] = Hash::make($input['password']);
            } else {
                $input['password'] = $companyUser->password;
            }
            $companyUser->update($input);
            $userId = $companyUser->user_id;
            $user = User::find($userId);
            $user->update($input);
            $notification = array(
                'message' => config('message.Users.UpdateUserSuccess'),
                'alert-type' => 'success'
            );
            return redirect()->route('companyUserIndex')->with($notification);
        } catch (Exception $e) {
            $notification = array(
                'message' => config('message.frontendMessages.error.wrong'),
                'alert-type' => 'success'
            );
            return redirect()->route('companyUserIndex')->with($notification);
        }
    }

    public function delete($id)
    {
        try {
            $modelId = $id;
            $companyUser = CompanyUser::find($modelId);
            if($companyUser->is_owner){
                return False;
            }
            $userId = $companyUser->user_id;
            $delete = CompanyUser::deleteUser($userId);
            $json_data = array(
                "message" => config('message.Users.DeleteUserSuccess'),
            );
            return Response::json($json_data);
        } catch (Exception $e) {
            $notification = array(
                'message' => config('message.frontendMessages.error.wrong'),
                'alert-type' => 'success'
            );
            return redirect()->route('companyUserIndex')->with($notification);
        }
    }

    public function companyUserUniqueEmail(Request $request)
    {
        if ($request->user_id) {
            $companyUser = CompanyUser::findOrFail($request->user_id);
            if ($companyUser->email == $request->email) {
                $email = true;
            } else {
                $email  = User::checkUniqueEmail('frontend', $request->email);
            }
            $json_data = array(
                "data" => $email,
            );
            return Response::json($json_data);
        } else {
            $email  = User::checkUniqueEmail('frontend', $request->email);
            $json_data = array(
                "data" => $email,
            );
            return Response::json($json_data);
        }
        // $email  = User::checkUniqueEmail('frontend',$request->email);
        // $json_data = array(
        //     "data" => $email,
        // );
        // return Response::json($json_data);
    }
}
