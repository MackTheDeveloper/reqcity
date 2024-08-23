<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Auth;
class Notifications extends Model
{
    use HasFactory;
    protected $table = 'notifications';
    protected $fillable = [
        'id',
        'type',
        'related_id	',
        'notification_code',
        'message',
        'message_type',
        'status',
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    public static function deleteNotification($notificationId)
    {
        $notification = self::where('id', $notificationId)->first();
        if ($notification) {
            $notification->delete();
        }
    }
    public static function unreadNotificationCountByRole($type, $relatedId)
    {
        return self::where('type', $type)->where('related_id', $relatedId)->where('status', 1)->whereNull('deleted_at')->count();
    }

    public static function addNotification($data)
    {
        $return = 0;
        $success = true;
        $allowed = ['type', 'related_id', 'notification_code', 'message', 'message_type', 'status'];
        $data = array_intersect_key($data, array_flip($allowed));
        $newEntry = new Notifications();
        try {
            foreach ($data as $key => $value) {
                $newEntry->$key = $value;
            }
            $newEntry->save();
            $return = $newEntry->id;
        } catch (\Exception $e) {
            $return = $e->getMessage();
            $success = false;
        }
        return ['data' => $return, 'success' => $success];
    }

    public static function getNotifications($relatedId)
    {
        $roleId = Auth::user()->role_id;
        $type = '';
        if ($roleId == 5)
            $type = 3;

        $data =  self::where('type', $type)
            ->where('related_id', $relatedId)
            ->whereNull('deleted_at')->orderBy('created_at', 'DESC')->limit(4)->get();

        return $data;
    }
}
