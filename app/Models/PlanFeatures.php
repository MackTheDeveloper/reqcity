<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Mail;
use Illuminate\Database\Eloquent\SoftDeletes;
use File;
use Image;

class PlanFeatures extends Model
{
    use SoftDeletes;
    protected $table = 'plan_features';

    protected $fillable = ['type', 'title', 'description', 'icon', 'sort_order', 'status', 'deleted', 'created_at', 'updated_at', 'deleted_at'];

    public function getIconAttribute($icon)
    {
        $return = '';
        $path = public_path() . '/assets/images/plan_feature_image/' . $icon;
        if (file_exists($path) && $icon) {
            $return = url('/public/assets/images/plan_feature_image/' . $icon);
        }
        return $return;
    }

    public static function getPlanFeatures($id)
    {
        $return = self::where('id', $id)->first();
        return ($return) ?: [];
    }

    public static function getSortOrder()
    {
        $return = self::selectRaw('sort_order')->where('status', 1)
            ->where('deleted', 0)
            ->orderBy('sort_order', 'desc')->first();
        return $return ? $return->sort_order + 1 : 1;
    }

    public static function uploadAndSaveImage($fileObject, $id = '')
    {
        $photo = $fileObject;
        $ext = $fileObject->extension();
        $filename = rand() . '_' . time() . '.' . $ext;
        $filePath = public_path() . '/assets/images/plan_feature_image';
        if (!File::exists($filePath)) {
            File::makeDirectory($filePath);
        }

        $img = Image::make($photo->path());
        // $img->resize(50, 50, function ($const) {
        //     $const->aspectRatio();
        // })->save($filePath.'/'.$filename);
        $width = config('app.PlanFeatureIconDimension.width');
        $height = config('app.PlanFeatureIconDimension.height');
        if ($img->width() == $width && $img->height() == $height) {
            $photo->move($filePath . '/', $filename);
        } else {
            $img->resize($width, $height)->save($filePath . '/' . $filename);
        }
        if ($id) {
            $oldData = self::where('id', $id)->first();
            if ($oldData) {
                if (!empty($oldData->icon)) {
                    $path = public_path() . '/assets/images/plan_feature_image/' . $oldData->icon;
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

    public static function getList($type)
    {
        $return = self::where('status', 1)->where('type', $type)->orderBy('sort_order', 'asc')->get();
        return $return;
    }
}
