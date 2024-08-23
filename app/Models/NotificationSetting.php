<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class NotificationSetting extends Model
{
    use HasFactory;
    protected $table = 'notification_settings';
    protected $fillable = [
        'id',
        'notification_type',
        'notification_code',
        'notification_label',
        'status',
    ];

    public static function getNotificationLabels($type)
    {
        $return = []; 
        $data = self::where('notification_type',$type)
          ->select('notification_label','id')
          ->where('status',1)->get();
        foreach ($data as $key => $value) {
            $return[] = ['id'=>$value->id,'label'=>$value->notification_label];
        }  
      return $return;
    }

    
  }
