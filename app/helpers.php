<?php

use App\Models\CompanyPermission;
use App\Models\CompanyUser;
use App\Models\CompanyUserPermission;
use App\Models\Role;
use App\Models\Permission;
use App\Models\PermissionRole;
use App\Models\PermissionUser;
use App\Models\Notifications;
use Carbon\Carbon;

/**
 * This function is use to checked role based permissions
 * @param array $role_type
 * @param $permission_slug
 * @return bool
 */
function whoCanCheck($role_type = array(), $permission_slug)
{
    // if (Auth::guard('admin')->user()->parent_id == 0 && Auth::guard('admin')->user()->user_type == 'backend') {
    if (Auth::guard('admin')->user()->role_id == 1 && Auth::guard('admin')->user()->user_type == 'backend') {
        return true;
    }else{
        $current_user = (Auth::guard('admin')->check()) ? Auth::guard('admin')->user()->id : Auth::guard('users')->user()->id;
        $obj = new Role;
        $role_type = $obj->getCurrentRole('role_type');
        $role_id = $obj->getCurrentRole('id');
        $permission = Permission::getIdBySlug($permission_slug);
        if ($permission) {
            $hasAccess = false;
            $userPermission = PermissionUser::where('user_id',$current_user)->first();
            if ($userPermission) {
                $rolePermission = PermissionUser::where('user_id',$current_user)->where('permission_id',$permission['id'])->first();
                if ($rolePermission) {
                    $hasAccess = true;
                }
            }else{
                $rolePermission = PermissionRole::where('role_id',$role_id)->where('permission_id',$permission['id'])->first();
                if ($rolePermission) {
                    $hasAccess = true;
                }
            }

            if ($hasAccess) {
                return true;
            } else {
                return false;
            }
        }
    }
}

/**
 * This function is used to generate Unique Id by getting last id from database table
 * @param $last_unique_id
 * @param string $prefix
 * @return mixed|string
 */
function getIdByLastUniqueId($last_unique_id, $prefix = '')
{
    if (!empty($last_unique_id)) {
        $uniqueId = preg_replace("/[^0-9]/", "", $last_unique_id);
        $uniqueId = $prefix . str_pad($uniqueId + 1, 5, '0', STR_PAD_LEFT);
    } else {
        $uniqueId = $prefix . str_pad(1, 5, '0', STR_PAD_LEFT);
    }
    return $uniqueId;
}

/**
 * This function is used to insert notification in notification table
 * @param int $type
 * @param int $realtedID
 * @param string $code
 * @param string $msg
 * @return bool
 */
function insertNotification($type,$realtedID,$code,$msg_type,$msg)
{
      $notification= new Notifications;
      $notification->type=$type;
      $notification->related_id=$realtedID;
      $notification->message_type=$msg_type;
      $notification->notification_code=$code;
      $notification->message=$msg;
      $notification->created_at= Carbon::now();
      if($notification->save())
      return true;
      else
      return false;
}
function getNotificationCount($type,$loggedInId=""){
  $notificationCount=Notifications::where('type',$type)->where("status",1);
  if(!empty($loggedInId))
  $notificationCount=$notificationCount->where('related_id',$loggedInId);
  $notificationCount=$notificationCount->count();
  return $notificationCount;
}
function getNotifications($type,$limit="",$loggedInId=""){
    $notifications=Notifications::where('type',$type)->where("status",1);
    if(!empty($loggedInId))
    $notifications=$notifications->where('related_id',$loggedInId);
    if(!empty($limit))
    $notifications=$notifications->limit($limit);
    $notifications=$notifications->orderBy('created_at','DESC')->get();
    return $notifications;
}

function whoCanCheckFront($permission_slug)
{
    $user_id = Auth::user()->id;
    $isOwner = CompanyUser::checkIsOwner($user_id);
    if (!$isOwner) {
        $existPermission = CompanyPermission::select('id')->where('permission_slug', $permission_slug)->first();
        if ($existPermission) {
            $userHasPermission = CompanyUserPermission::select('id')->where('company_permission_id', $existPermission->id)
                ->where('user_id', $user_id)->first();
            if ($userHasPermission) {
                return true;
            }else{
                return false;
            }
        }
        return true;
    }
    return true;
}
