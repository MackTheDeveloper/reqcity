<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Image;
use File;

class HowItWorks extends Model
{
    use SoftDeletes;

    protected $table = 'how_it_works';
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'id','title','type','image','feature_1','description_1','feature_2','description_2','feature_3','description_3','feature_4','description_4','sort_order',
    ];

    public function getImageAttribute($image){
        $return = url('public/assets/frontend/img/'.config('app.default_image'));
        $path = public_path().'/assets/images/how-it-works/'.$image;
        if(file_exists($path) && $image){
            $return = url('/public/assets/images/how-it-works/'.$image);
        }
        return $return;
    }

    public static function getSortOrder($type){
        // $return = self::selectRaw('sort_order')->orderBy('sort_order','desc')->first();
        $return = self::selectRaw('sort_order')->where('type',$type)->orderBy('sort_order','desc')->first();
        return $return?$return->sort_order+1:1;
    }

    public static function uploadAndSaveImage($fileObject,$id=''){
        $photo = $fileObject;
        $ext = $fileObject->extension();
        $filename = rand().'_'.time().'.'.$ext;
        $filePath = public_path().'/assets/images/how-it-works';
        if (! File::exists($filePath)) {
            File::makeDirectory($filePath);
        }

        $img = Image::make($photo->path());
        // $img->resize(50, 50, function ($const) {
        //     $const->aspectRatio();
        // })->save($filePath.'/'.$filename);
        $width = config('app.howitworks.width');
        $height = config('app.howitworks.height');
        if($img->width() == $width && $img->height() == $height){
            $photo->move($filePath.'/', $filename);
        }else{
            $img->resize($width, $height)->save($filePath.'/'.$filename);
        }
        if ($id) {
            $oldData = self::where('id', $id)->first();
            if ($oldData) {
                $path = public_path().'/assets/images/how-it-works/'.$oldData->image;
                if(file_exists($path)){
                    unlink($path);
                }
                $oldData->image = $filename;
                $oldData->save();
            }
        }
        return $filename;
    }

    public static function getHowItWorksData($type=""){
        $return = [];
        $data = self::whereNull('deleted_at');
        if(!empty($type))
        $data = $data->where('type',$type);
        $data = $data->get();
        $return = self::formatedList($data);
        return $return;
    }

    public static function formatedList($data)
    {
        $return = [];
        foreach ($data as $key => $value) {
            $return = [
                "Id" => $value['id'],
                "Type" => $value['type'],
                "feature_1" => $value['feature_1'],
                "description_1" => $value['description_1'],
                "feature_2" => $value['feature_2'],
                "description_2" => $value['description_2'],
                "feature_3" => $value['feature_3'],
                "description_3" => $value['description_3'],
                "feature_4" => $value['feature_4'],
                "description_4" => $value['description_4'],
                "title" => $value['title'],
                "Image" => $value['image'],
                "createdAt" => getFormatedDate($value['created_at']),
            ];
        }
        return $return;
    }
}
