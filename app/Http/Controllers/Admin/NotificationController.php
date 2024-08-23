<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Notifications;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use Auth;
use DataTables;
use Carbon\Carbon;
use DB;
use Excel;
use Response;
use DateTime;
use DatePeriod;
use DateInterval;
use Symfony\Component\Console\Input\Input;

class NotificationController extends Controller
{
  public function index(Request $request)
  {
    $req = $request->all();
    $baseUrl = $this->getBaseUrl();
    //  $search = (isset($req['search']) ? $req['search'] : '');
    return view("admin.notifications.index", compact('baseUrl'));
  }
  public function list(Request $request)
  {
    if (Auth::guard('admin')->user()->role_id == config('app.superAdminRoleId'))
      $type = 4;
    elseif (Auth::guard('admin')->user()->role_id == config('app.candidateSpecialistRoleId'))
      $type = 5;
    $req = $request->all();
    $start = $req['start'];
    $length = $req['length'];
    $search = $req['search']['value'];
    $order = $req['order'][0]['dir'];
    $column = $req['order'][0]['column'];
    $orderby = ['id', 'message_type', 'message', 'created_at'];
    $sumAmount = 0;
    if ($type == 5) {
      $total = Notifications::selectRaw('count(*) as total')
        ->where('type', $type)
        ->whereNull('deleted_at')
        ->where('related_id', Auth::guard('admin')->user()->id)
        ->first();
    } else {
      $total = Notifications::selectRaw('count(*) as total')
        ->where('type', $type)
        ->whereNull('deleted_at')
        ->first();
    }

    $query = Notifications::where('type', $type)
      ->whereNull('deleted_at');

    $filteredq = Notifications::where('type', $type)
      ->whereNull('deleted_at');
    if ($type == 5) {
      $query = $query->where('related_id', Auth::guard('admin')->user()->id);
      $filteredq = $filteredq->where('related_id', Auth::guard('admin')->user()->id);
    }

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
    if (isset($request->is_active) && $request->is_active != 0) {
      $filteredq = $filteredq->where('status', $request->is_active);
      $query = $query->where('status', $request->is_active);
    }
    $filteredq = $filteredq->selectRaw('count(*) as total')->first();
    $totalfiltered = $filteredq->total;
    $query = $query->orderBy($orderby[$column], $order)->offset($start)->limit($length)->get();
    //$query = $query->limit($length)->get();
    $data = [];
    foreach ($query as $key => $value) {
      $check  = '<input name="id[]" value="' . $value->id . '" id="id_' . $value->id . '" type="checkbox" class="notificationCheck" />';
      $data[] = [$value->id, $check, $value->message_type, $value->message, getFormatedDate($value->created_at), $value->status];
    }
    $json_data = array(
      "draw" => intval($_REQUEST['draw']),
      "recordsTotal" => intval($total->total),
      "recordsFiltered" => intval($totalfiltered),
      "data" => $data,
      "sumAmount" => $sumAmount
    );
    return Response::json($json_data);
  }

  public function notificationReadUnread(Request $request)
  {
    $flag = 0;
    try {
      if ($request->status != 3) {
        $status = $request->status;
        if (!empty($request->checkedIds)) {
          foreach ($request->checkedIds as $ids) {
            $model = Notifications::where('id', $ids)->first();
            if ($model->status == 1) {
              $model->status = $status;
              $flag = 2;
            } else {
              $model->status = $status;
              $flag = 1;
            }
            $model->update();
          }
          $result['status'] = 'true';
          if ($flag == 2)
            $result['msg'] = "Notification(s) mark as read Successfully!";
          else
            $result['msg'] = "Notification(s) mark as unread Successfully!";
          return $result;
        } else {
          $result['status'] = 'false';
          $result['msg'] = 'Something went wrong!!';
          return $result;
        }
      } else {
        if (!empty($request->checkedIds)) {
          foreach ($request->checkedIds as $ids) {
            $model = Notifications::where('id', $ids)->first();
            $model->delete();
            // $result['status'] = 'true';
            // $result['msg'] = "Notification(s) deleted Successfully!";
            // return $result;
          }
          $result['status'] = 'true';
          $result['msg'] = "Notification(s) deleted Successfully!";
          return $result;
        } else {
          $result['status'] = 'false';
          $result['msg'] = 'Something went wrong!!';
          return $result;
        }
      }
    } catch (\Exception $ex) {
      return view('errors.500');
    }
  }
}
