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
use App\Models\CompanyJob;
use App\Models\CompanyJobFunding;
use App\Models\CompanyTransaction;
use App\Models\CompanyUser;
use App\Models\Country;
use App\Models\JobFieldOption;
use App\Models\NotificationSetting;
use App\Models\UserNotificationSetting;
use Exception;
use Auth;
use Response;
use Mail;
use Illuminate\Support\Facades\Session;
use Illuminate\Routing\Route;
use Illuminate\Support\Facades\URL;

class CompanyFrontController extends Controller
{

    public function showMyInfo(Request $request)
    {
        $userId = Auth::user()->id;
        if ($userId) {
            try {
                $data = User::select(
                    'users.id as user_id',
                    'users.role_id',
                    'users.email as userEmail',
                    'users.firstname',
                    'users.lastname',
                    'companies.name as companyName',
                    'companies.id as companyId',
                    'companies.email as companyEmail',
                    'companies.phone_ext as companyPhoneExt',
                    'companies.phone as companyPhone',
                    'company_address.city',
                    'company_address.state',
                    'companies.website',
                    'companies.about',
                    'companies.logo',
                    'companies.why_work_here',
                    'company_user.is_owner',
                    'company_user.id as companyUserId',
                    'company_user.name as companyUserName',
                    'company_user.email as companyUserEmail',
                    'company_user.phone as companyUserPhone',
                    'company_user.phone_ext as companyUserPhoneExt',
                    'countries.name as countryName',
                    'countries.id as countryId',
                    'company_address.address_1',
                    'company_address.address_2',
                    'company_address.postcode',
                    'job_field_options.option as strength'
                )->leftJoin('company_user', 'users.id', 'company_user.user_id')
                    ->leftJoin('companies', 'companies.id', 'company_user.company_id')
                    ->leftJoin('company_address', 'companies.id', 'company_address.company_id')
                    ->leftJoin('countries', 'company_address.country', 'countries.id')
                    ->leftJoin('job_field_options', 'companies.strength', 'job_field_options.id')
                    ->where('users.id', $userId)
                    ->where('company_address.def_address', 1)
                    ->whereNull('users.deleted_at')->first();
                $logo = Companies::getLogoAttribute($data->logo);
                $countries = Country::getListForDropdown();
                $companySize = JobFieldOption::getOptions('CMPSZ');
                return view('frontend.company.my-info.myinfo', compact('data', 'logo', 'countries', 'companySize'));
            } catch (Exception $e) {
                return redirect()->route('showMyInfoCompany');
            }
        }
    }


    public function updateMyInfo(Request $request)
    {
        $userId = Auth::user()->id;
        $companyId = "";
        $companyLogo = "";
        $companyUser = CompanyUser::where('user_id', $userId)->first();
        $companyId = $companyUser->company_id;
        if ($request->hasFile('myFile')) {
            if (isset($request->hiddenPreviewImg)) {
                $companyLogo = Companies::uploadIconEncoded($request->hiddenPreviewImg);
                unset($request->hiddenPreviewImg);
            }
        }
        if (isset($request['companyUser'])) {
            $companyUserData = [
                // 'company_id' => $company->id,
                'name' => $request['companyUser']['yourName'],
                'email' => $request['companyUser']['email'],
                'user_id' => $userId,
                'phone_ext' => $request['companyUser']['phoneField1'],
                'phone' => $request['companyUser']['phoneNumber'],
            ];
            if ($companyUser) {
                $companyUserUpdate = CompanyUser::createOrUpdate($companyUser->id, $companyUserData);
            }
            if (isset($request['companyUser']['email'])) {
                $user = User::where('id', $userId)->first();
                $user->email = $request['companyUser']['email'];
                $user->save();
            }
        }
        if (isset($request['company'])) {
            $companyData = $request['company'];
            if (isset($companyLogo) && $companyLogo != "") {
                $companyData['logo'] = $companyLogo;
            }
            if ($companyData) {
                $companyUpdate = Companies::createOrUpdate($companyId, $companyData);
            }
        }
        if (isset($request['companyAddress'])) {
            $companyAddressData = $request['companyAddress'];
            $companyAddress = CompanyAddress::where('company_id', $companyId)->first();
            if ($companyData) {
                $companyUpdate = CompanyAddress::createOrUpdateSingleRecord($companyAddress->id, $companyAddressData);
            }
        }

        return redirect()->route('showMyInfoCompany');
    }


    public function showPasswordSecurity(Request $request)
    {
        return view('frontend.company.password-security.password-security');
    }

    public function showPasswordSecurityForm(Request $request)
    {
        return view('frontend.company.password-security.form');
    }

    public function changePassword(Request $request)
    {
        $authId = Auth::user()->id;
        $returnData = User::changePassword($request, $authId);
        if ($returnData) {
            $notification = array(
                'message' => 'Your password has been changed successfully.',
                'alert-type' => 'success'
            );
            $user = User::find($authId);
            Auth::login($user);
            return redirect()->route('showPasswordSecurityCompany')->with($notification);
        } else {
            $notification = array(
                'message' => 'Please enter correct old password',
                'alert-type' => 'error'
            );
            return redirect()->route('showPasswordSecurityFormCompany')->with($notification);
        }
    }


    public function companyPayment(Request $request)
    {
        $userId = Auth::user()->id;
        $data = CompanyTransaction::has('SubscriptionPlan')
            ->where('company_id', '=', $userId)->get();
        // $data = CompanyTransaction::select('company_transactions.*',
        //                             'subscription_plans.subscription_name')
        //                             ->leftJoin('subscription_plans','company_transactions.subscription_plan_id','subscription_plans.id')
        //                             ->where('company_transactions.company_id',$userId)
        //                             ->whereNull('company_transactions.deleted_at')
        //                             ->get();
        // dd($data);
        return view('frontend.company.payment.index', compact('data'));
    }

    public function list(Request $request)
    {
        $req = $request->all();
        $page = !empty($req['page']) ? $req['page'] : 1;
        if ($page) {
            $length = \Config::get('app.dataTable')['length'];
            $start = ($page - 1) * $length;
        }
        // $start = !empty($req['start'])? $req['start']:0;
        // $length = !empty($req['length'])? $req['length']:2;
        $search = ""; //$req['search']['value'];
        // $order = $req['order'][0]['dir'];
        // $column = $req['order'][0]['column'];
        // $orderby = ['id','','first_name','email','phone','job_title','country','state','city','postcode','','status','created_at'];
        $userId = Auth::user()->id;

        $total = CompanyTransaction::selectRaw('count(*) as total')->has('SubscriptionPlan')->where('company_id', '=', $userId)->first();
        // pre($total);

        $query = CompanyTransaction::has('SubscriptionPlan')
            ->where('company_id', $userId)
            ->whereNull('deleted_at');

        $filteredq = CompanyTransaction::has('SubscriptionPlan')
            ->where('company_id', $userId)
            ->whereNull('deleted_at');

        $totalfiltered = $total->total;
        // if ($search != '') {
        //     $query->where(function ($query2) use ($search) {
        //         $query2->where('subscription_plans.subscription_name', 'like', '%' . $search . '%')
        //             ->orWhere('company_transactions.invoice_id', 'like', '%' . $search . '%');
        //     });

        //     $filteredq->where(function ($query2) use ($search) {
        //         $query2->where('subscription_plans.subscription_name', 'like', '%' . $search . '%')
        //         ->orWhere('company_transactions.invoice_id', 'like', '%' . $search . '%');
        //     });

        //     $filteredq = $filteredq->selectRaw('count(*) as total')->first();
        //     $totalfiltered = $filteredq->total;
        // }
        if (!empty($request->startDate) && !empty($request->endDate)) {
            $startDate = $request->startDate;
            $endDate = $request->endDate;
            $filteredq = $filteredq->where(function ($q) use ($startDate, $endDate) {
                $q->whereBetween('invoice_date', [$startDate, $endDate]);
            });
            $query = $query->where(function ($q) use ($startDate, $endDate) {
                $q->whereBetween('invoice_date', [$startDate, $endDate]);
            });
            $recordCount = $filteredq->selectRaw('count(*) as total')->first();
            $totalfiltered = $recordCount->total;
        }
        //$query = $query->orderBy($orderby[$column], $order)->offset($start)->limit($length)->get();
        $query = $query->offset($start)->limit($length)->get();

        // $firstname = Subscription::select('firstname')->leftJoin("users","subscriptions.customer_id","=","users.role_id")->first();
        //$duration = Subscription::select('duration')->leftJoin("subscription__plans", "subscriptions.subscription_plan","=","subscription__plans.id")->first();

        // pre($query);
        $data = [];
        foreach ($query as $key => $value) {
            // $data[] = [getFormatedDate($value->created_at), 'Paid for' . $value->subscriptionPlan->subscription_name . 'Subscription', $value->invoice_id];
            $data[] = [
                "date" => getFormatedDate($value->invoice_date, 'd M Y'),
                "description" => 'Paid for ' . $value->subscriptionPlan->subscription_name . ' Subscription',
                "amount" => number_format((float) $value->amount, 2, '.', ''),
                "invoice" => "<a href='" . $value->invoice_pdf_url . "' target='_blank'>" . $value->invoice_number . "</a>"
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

    public function companyPaymentApprovalList(Request $request)
    {
        $companyId = Auth::user()->company->id;
        $userId = Auth::user()->id;
        $req = $request->all();
        $page = !empty($req['page']) ? $req['page'] : 1;
        if ($page) {
            $length = \Config::get('app.dataTable')['length'];
            $start = ($page - 1) * $length;
        }
        $search = ""; //$req['search']['value'];
        // $order = $req['order'][0]['dir'];
        // $column = $req['order'][0]['column'];
        // $orderby = ['id','','first_name','email','phone','job_title','country','state','city','postcode','','status','created_at'];


        $total = CompanyJobFunding::selectRaw('count(*) as total')->has('companyJob')->where('company_id', '=', $companyId)->first();

        $query = CompanyJobFunding::has('companyJob')
            ->where('company_id', $companyId)
            ->whereNull('deleted_at');

        $filteredq = CompanyJobFunding::has('companyJob')
            ->where('company_id', $companyId)
            ->whereNull('deleted_at');

        /*  $total = CompanyJob::selectRaw('count(*) as total')->has('companyJobFunding')->where('company_id', '=', $companyId)->first();

        $query = CompanyJob::has('companyJobFunding')
            ->where('company_id', $companyId)
            ->whereNull('deleted_at');

        $filteredq = CompanyJob::has('companyJobFunding')
            ->where('company_id', $userId)
            ->whereNull('deleted_at'); */

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
        //$query = $query->orderBy($orderby[$column], $order)->offset($start)->limit($length)->get();
        $query = $query->offset($start)->limit($length)->get();

        $data = [];
        foreach ($query as $key => $value) {
            //$data[] = ['date' => getFormatedDate($value->created_at), 'description' => $value->companyJob->title, 'amount' => $value->amount, 'receiptNumber' => $value->payment_id];
            $data[] = [
                "date" => getFormatedDate($value->created_at, 'd M Y'),
                "description" => $value->companyJob->title,
                "amount" => number_format((float) $value->amount, 2, '.', ''),
                "receiptNumber" => "<a href='" . $value->receipt_url . "' target='_blank'>" . $value->payment_id . "</a>"
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

    public function getSubscriptionView()
    {
        $data = [];
        return view('frontend.company.payment.subscription', compact('data'));
    }

    public function notificationSetting(Request $request)
    {
        try {
            $email = Auth::user()->email;
            $email = get_starred($email, 'email');
            $userId = Auth::user()->id;
            $notifications = NotificationSetting::getNotificationLabels('3');
            $userNotification = UserNotificationSetting::getUserNotification($userId);
            return view('frontend.company.notification-setting.index', compact('email', 'notifications', 'userNotification'));
        } catch (Exception $e) {
            return redirect()->route('showMyInfoCompany');
        }
    }

    public function updateNotificationSetting(Request $request)
    {
        $notificationId = $request->notificationId;
        $userId = Auth::user()->id;
        $userNotification = UserNotificationSetting::where('user_id', $userId)
            ->where('notification_ids', $notificationId)->first();
        if ($userNotification) {
            $userNotification->delete();
            return 'success';
        } else {
            $userNotification = new UserNotificationSetting();
            $userNotification->notification_ids = $notificationId;
            $userNotification->user_id = $userId;
            $userNotification->type = 3;
            $userNotification->save();
            return 'success';
        }
    }
}
