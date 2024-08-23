<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\NotificationSetting;

class UserNotificationSetting extends Model
{
    use HasFactory;
    protected $table = 'user_notification_settings';
    protected $fillable = [
        'id',
        'type',
        'user_id',
        'notification_ids',
        'status',
    ];

    public static function getUserNotification($userId)
    {
        $notifications = self::where('user_id',$userId)->pluck('notification_ids')->toArray();
        return $notifications;
    }

    public static function checkPermission($userId,$code)
    {
        $return = false;
        $notification = NotificationSetting::where('notification_code',$code)->first();
        if ($notification) {
            $hasAllowed = self::where('user_id', $userId)->whereRaw("FIND_IN_SET(?, notification_ids) > 0", [$notification->id])->first();
            if ($hasAllowed) {
                $return = true;
            }
        }
        // $userPermissions = self::getUserNotification($userId);
        // $return = in_array($notification->id,$userPermissions);
        return $return; 
    }

    // public static function checkPermissionUsers($userArr, $code)
    // {
    //     $return = [];
    //     $notification = NotificationSetting::where('notification_code', $code)->first();
    //     if ($notification) {
    //         $hasAllowed = self::whereIn('user_id', $userArr)->whereRaw("FIND_IN_SET(?, notification_ids) > 0", [$notification->id])->pluck('user_id');
    //         if ($hasAllowed) {
    //             $return = $hasAllowed;
    //         }
    //     }
    //     // $userPermissions = self::getUserNotification($userId);
    //     // $return = in_array($notification->id,$userPermissions);
    //     return $return;
    // }
  }
