<?php

namespace App\Http\Controllers\FrontEnd;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use App\Models\Notifications;
use Exception;
use Auth;
use Response;
use Mail;
use Illuminate\Support\Facades\Session;
use Illuminate\Routing\Route;
use Illuminate\Support\Facades\URL;

class NotificationController extends Controller
{

    public function index(Request $request)
    {
        $userId = Auth::user()->id;
        $roleId = Auth::user()->role_id;
        if($roleId==config('app.companyRoleId')){
          $roleText='company';
        }
        elseif($roleId==config('app.recruiterRoleId')){
          $roleText='recruiter';
        }
        elseif($roleId==config('app.candidateRoleId')){
          $roleText='candidate';
        }
        $isEditable = 1;
        $isDeletable = 1;

        if(Auth::user()->role_id == 3){
            $isEditable = whoCanCheckFront('company_notifications_edit');
            $isDeletable = whoCanCheckFront('company_notifications_delete');
        }

        $shoAction = ($isEditable || $isDeletable);
        if ($userId) {
            try {
                return view('frontend.notifications.index',compact('shoAction','roleText'));
            } catch (Exception $e) {
              dd($e);
                return redirect()->route('showMyInfoCompany');
            }
        }
    }

    public function getList(Request $request)
    {
        $roleId = Auth::user()->role_id;
        $userId = Auth::user()->id;
        if($roleId==config('app.companyRoleId')){
          $type=1;
          $relatedId=Auth::user()->companyUser->company_id;
        }
        elseif($roleId==config('app.recruiterRoleId')){
          $type=2;
          $relatedId=Auth::user()->recruiter->id;
        }
        elseif($roleId==config('app.candidateRoleId')){
          $type=3;
          $relatedId=Auth::user()->candidate->id;
        }
        $req = $request->all();
        $page = !empty($req['page']) ? $req['page'] : 1;
        if ($page) {
            $length = \Config::get('app.dataTable')['length'];
            $start = ($page - 1) * $length;
        }
        $search = "";

        $total = Notifications::selectRaw('count(*) as total')
                    ->where('type',$type)
                    ->where('related_id',$relatedId)
                    ->whereNull('deleted_at')
                    ->first();
        $query = Notifications::where('type',$type)
                                ->where('related_id',$relatedId)
                                ->whereNull('deleted_at');

        $filteredq = Notifications::where('type',$type)
                                ->where('related_id',$relatedId)
                                ->whereNull('deleted_at');
        $totalfiltered = $total->total;
        if ($search != '') {
            $query->where(function ($query2) use ($search) {
                $query2->where('message_type', 'like', '%' . $search . '%')
                    ->orWhere('message', 'like', '%' . $search . '%');
            });

            $filteredq->where(function ($query2) use ($search) {
                $query2->where('message_type', 'like', '%' . $search . '%')
                    ->orWhere('message', 'like', '%' . $search . '%');
            });
        }
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
        $query = $query->offset($start)->limit($length)->orderBy('created_at','DESC')->get();

        $data = [];
        foreach ($query as $key => $value) {
            $id = $value->id;
            $isRead = $value->status;

            $isEditable = 1;
            $isDeletable = 1;

            if(Auth::user()->role_id == 3){
                $isEditable = whoCanCheckFront('company_notifications_edit');
                $isDeletable = whoCanCheckFront('company_notifications_delete');
            }
            // $isEditable = whoCanCheckFront('company_notifications_edit');
            // $isDeletable = whoCanCheckFront('company_notifications_delete');
            $module = 'notifications';
            $action = view('frontend.notifications.components.action', compact('id', 'module', 'isRead', 'isEditable', 'isDeletable'))->render();
            $dataSingle = [
                "date" => getFormatedDate($value->created_at, 'd M Y'),
                "message" => $value->message,
                //   "action" => $action,
            ];
            if ($isEditable || $isDeletable) {
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
    public function delete($id)
    {
        try {
            $modelId = $id;
            $delete = Notifications::deleteNotification($modelId);
            $json_data = array(
                "message" => config('message.frontendMessages.notification.delete'),
            );
            return Response::json($json_data);
        } catch (Exception $e) {
            $notification = array(
                'message' => config('message.frontendMessages.error.wrong'),
                'alert-type' => 'success'
            );
            return redirect()->route('index')->with($notification);
        }
    }

    public function notificationReadUnread(Request $request)
    {
        $flag = 0;
        try {
            $id = $request->id;
            $model = Notifications::where('id', $id)->first();
            if ($model->status == 1) {
                $model->status = 2;
                $flag = 2;
            } else {
                $model->status = 1;
                $flag = 1;
            }
            if ($model->update()) {
                $result['status'] = 'true';
                if ($flag == 2)
                    $result['message'] = config('message.frontendMessages.notification.read');
                else
                    $result['message'] = config('message.frontendMessages.notification.unread');
                return $result;
            } else {
                $result['status'] = 'false';
                $result['message'] = 'Something went wrong!!';
                return $result;
            }
        } catch (\Exception $ex) {
            return view('errors.500');
        }
    }
}
