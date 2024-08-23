<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use File;
use Image;

class ScheduledSubscription extends Model
{
    use HasFactory, SoftDeletes;
    protected $table = 'scheduled_subscription';
    protected $fillable = [
        'shed_sub_id',
        'subscription_id',
        'user_id',
        'activated',
        'scheduled_date',
        'subscription_plan_id',
        'type',
        'amount',
    ];

    public static function getScheduledSubscriptionByUser($userId)
    {
        $return = [];
        $data  = self::where('user_id', $userId)->where('activated','!=', '1')->orderBy('created_at', 'desc')->first();
        if ($data) {
            $return = $data->toArray();
            $return['scheduled_date'] = date('Y-m-d', $return['scheduled_date']);
        }
        return $return;
    }   
}
