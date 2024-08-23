<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use File;
use Image;

class Category extends Model
{
    use SoftDeletes;

    protected $table = 'categories';
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'id','parent_id','title','description','icon','slug','status','sort_order',
    ];
    public function companyJobs() {
       return $this->hasMany(CompanyJob::class,'job_category_id','id')->where('company_jobs.deleted_at');
     }
    public function companySubcategoryJobs() {
        return $this->hasMany(CompanyJob::class,'job_subcategory_id','id')->where('company_jobs.deleted_at');
    }

    public static function getList(){
        $return = self::selectRaw('id,title,icon,description,sort_order')->where('status',1)->get();
        return $return;
    }

    public static function getCount(){
        $return = self::selectRaw('id,title,icon,description,sort_order')->where('parent_id',0)->where('status',1)->count();
        return $return;
    }

    public static function getSortOrder(){
        $return = self::selectRaw('sort_order')->where('status',1)->orderBy('sort_order','desc')->first();
        return $return?$return->sort_order+1:1;
    }

    public function getImageAttribute($image){
        $return = url('public/assets/frontend/img/'.config('app.default_image'));
        $path = public_path().'/assets/images/category/'.$image;
        if(file_exists($path) && $image){
            $return = url('/public/assets/images/category/'.$image);
        }
        return $return;
    }

    public static function uploadAndSaveImage($fileObject,$id=''){
        $photo = $fileObject;
        $ext = $fileObject->extension();
        $filename = rand().'_'.time().'.'.$ext;
        $filePath = public_path().'/assets/images/category';
        if (! File::exists($filePath)) {
            File::makeDirectory($filePath);
        }

        $img = Image::make($photo->path());
        // $img->resize(50, 50, function ($const) {
        //     $const->aspectRatio();
        // })->save($filePath.'/'.$filename);
        $width = config('app.CategoryIconDimension.width');
        $height = config('app.CategoryIconDimension.height');
        if($img->width() == $width && $img->height() == $height){
            $photo->move($filePath.'/', $filename);
        }else{
            $img->resize($width, $height)->save($filePath.'/'.$filename);
        }
        if ($id) {
            $oldData = self::where('id', $id)->first();
            if (!empty($oldData) && $oldData->icon!='') {
                $path = public_path().'/assets/images/category/'.$oldData->icon;
                if(file_exists($path)){
                    unlink($path);
                }
                $oldData->icon = $filename;
                $oldData->save();
            }
        }
        return $filename;
    }

    public static function getCategoryList($limit = "")
    {
        $return = [];
        $data = Category::withCount(['companyJobs']);
        $data=$data->havingRaw('company_jobs_count > 0');
        $data=$data->where('categories.parent_id',0);
        $data=$data->where('categories.status',1);
        $data=$data->whereNull('categories.deleted_at');
        if(!empty($limit))
        $data = $data->limit($limit);
        $data = $data->get();
        if ($data)
        {
            $data = self::formatCategoryList($data);
        }
        $return = $data;
        return $return;
    }
    public static function getChildCategoriesHaveJob($limit = "")
    {
        $return = [];
        $data = Category::withCount(['companySubcategoryJobs']);
        $data=$data->havingRaw('company_subcategory_jobs_count > 0');
        $data=$data->where('categories.parent_id','!=',0);
        $data=$data->where('categories.status',1);
        $data=$data->whereNull('categories.deleted_at');
        if(!empty($limit))
        $data = $data->limit($limit);
        $data = $data->get();
        if ($data)
        {
            $data = self::formatCategoryList($data);
        }
        $return = $data;
        return $return;
    }
    public static function formatCategoryList($data){
        $return = [];
        foreach ($data as $key => $value) {
            $return[] = [
                "id"=>$value['id'],
                "name"=>$value['title'],
                "slug"=>$value['slug'],
                "icon"=>self::getCategoryIcon($value['id']),
                "status"=>$value['status'],
                "sortOrder"=>$value['sort_order'],
                "jobCount"=>$value['company_jobs_count'],
            ];
        }
        return $return;
    }

    public static function getCategoryIcon($id)
    {
      $return = url('public/assets/frontend/img/' . config('app.default_image'));
      $data = self::where('id', $id)->first();
      if ($data && !empty($data->icon)) {
        $return =url('public/assets/images/category/' .  $data->icon);;
      }
      return $return;
    }

    public static function getDataForFooter($ids)
    {
        $data = self::selectRaw('id,title,slug')->whereNull('deleted_at')->whereIn('id', explode(',', $ids))->get();
        $return = array();
        foreach($data as $k => $v)
        {
            $return[$v->title] = route('searchFront',$v->slug);
        }
        return $return;
    }

    public static function getParentCategories(){
        return self::where('parent_id',0)->where('status',1)->pluck('title','id');
    }

    public static function getChildCategories($id){
        return self::where('parent_id',$id)->where('status',1)->get(['title','id']);
    }


}
