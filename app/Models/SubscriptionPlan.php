<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use File;
use Image;

class SubscriptionPlan extends Model
{
    use HasFactory, SoftDeletes;
    protected $table = 'subscription_plans';
    protected $fillable = [
        'subscription_name',
        'type',
        'icon',
        'plan_type',
        'tag_line',
        'flag_recommended',
        'price',
        'trial_period',
        'stripe_price_id',
        'description',
    ];

    public static function getDetails($id)
    {
        return self::find($id);
    }

    public static function getList($type = "")
    {
        if (!empty($type))
            return self::where('type', $type)->whereNull('deleted_at')->pluck('subscription_name', 'id');
        else
            return self::whereNull('deleted_at')->pluck('subscription_name', 'id');
    }
    public function getImageAttribute($image)
    {
        $return = url('public/assets/frontend/img/' . config('app.default_image'));
        $path = public_path() . '/assets/images/subscription-plan/' . $image;
        if (file_exists($path) && $image) {
            $return = url('/public/assets/images/subscription-plan/' . $image);
        }
        return $return;
    }

    public static function uploadAndSaveImage($fileObject, $id = '')
    {
        $photo = $fileObject;
        $ext = $fileObject->extension();
        $filename = rand() . '_' . time() . '.' . $ext;
        $filePath = public_path() . '/assets/images/subscription-plan';
        if (!File::exists($filePath)) {
            File::makeDirectory($filePath);
        }

        $img = Image::make($photo->path());
        // $img->resize(50, 50, function ($const) {
        //     $const->aspectRatio();
        // })->save($filePath.'/'.$filename);
        $width = config('app.SubscriptionPlanIconDimension.width');
        $height = config('app.SubscriptionPlanIconDimension.height');
        if ($img->width() == $width && $img->height() == $height) {
            $photo->move($filePath . '/', $filename);
        } else {
            $img->resize($width, $height)->save($filePath . '/' . $filename);
        }
        if ($id) {
            $oldData = self::where('id', $id)->first();
            if ($oldData) {
                if (!empty($oldData->icon)) {
                    $path = public_path() . '/assets/images/category/' . $oldData->icon;
                    if (file_exists($path)) {
                        unlink($path);
                    }
                }
                $oldData->icon = $filename;
                $oldData->save();
            }
        }
        return $filename;
    }

    public static function getPlan($type, $planType)
    {
        $return = '';
        $dataSubscritpionPlan = self::where('type', $type)->where('plan_type', $planType)->where('status', 1)->first();
        if (!empty($dataSubscritpionPlan))
            $return = $dataSubscritpionPlan;
        return $return;
    }

    public static function getUntildate($type, $trialDays)
    {
        $nextDate = ($type=="monthly")?" +1 month":" +1 year";
        $today = date('Y-m-d');
        $billingStartDate = $trialDays?date('Y-m-d', strtotime($today . ' + ' . $trialDays . ' days')):$today;
        $newDateIncludingTrial = date('Y-m-d', strtotime($billingStartDate .$nextDate));
        return $newDateIncludingTrial;
    }

    public static function getTrialEnddate($trialDays="")
    {
        $today = date('Y-m-d');
        $trialEndDate = $trialDays?date('Y-m-d', strtotime($today . ' + ' . $trialDays . ' days')):$today;
        $billingStartDate = $trialDays?date('Y-m-d', strtotime($trialEndDate . ' +1 days')):$today;
        return ["trialEndDate"=>$trialEndDate,"billingStartDate"=>$billingStartDate];
    }

    public function companyTransaction()
    {
        return $this->hasOne(CompanyTransaction::class);
    }

    public static function getSubscriptionNotSubscribed($userId)
    {
        $currentSubscription = User::getAttrById($userId, 'current_subscription');
        $planType = self::find($currentSubscription);
        // pre($planType);
        $role = User::getAttrById($userId, 'role_id');
        $roleIs = ($role=='4')?"recruiter": "company";
        if ($planType && $planType->plan_type=='yearly') {
            $monthly = self::where('type', $roleIs)->where('plan_type', 'yearly')->first();
            $return = self::where('type', $roleIs)->where('plan_type', 'monthly')->first()->toArray();
            $return['saving'] = 0;
        }else{
            $monthly = self::where('type', $roleIs)->where('plan_type', 'monthly')->first();
            $return = self::where('type', $roleIs)->where('plan_type', 'yearly')->first()->toArray();
            $return['saving'] = ($monthly->price*12)- $return['price'];
        }
        // pre($return);
        return $return;
    }

    public static function getSubscriptionByPlanId($planId,$attr=""){
        $return = "";
        $data = self::where('stripe_price_id',$planId)->first();
        if($data){
            $return = $data->id;
            if ($attr) {
                $return = $data->$attr;
            }
        }
        return $return;
    }

    public static function getAttrById($id, $attr)
    {
        $return = "";
        $data = self::select($attr)->where('id', $id)->first();
        if ($data) {
            $return = $data->$attr;
        }
        return $return;
    }
}
