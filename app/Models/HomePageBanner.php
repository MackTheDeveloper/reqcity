<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Auth;
use File;
use Image;

class HomePageBanner extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $table = 'home_page_banners';
    protected $fillable = [
        'id',
        'title',
        'header',
        'sub_title',
        'main_banner',
        'highlight_jobs_banner',
        'company_line',
        'recruiter_line',
        'candidate_line',
        'status',
        'created_at',
        'deleted_at',
        'updated_at'
    ];

    public static function getBannerImage($id)
    {
      $return = url('public/assets/frontend/img/' . config('app.default_image'));
      $data = self::where('id', $id)->first();
      if ($data && !empty($data->main_banner)) {
        $return =url('public/assets/images/home-page-banner/' .  $data->main_banner);
      }
      return $return;
    }
    public static function getHighlightJobsBannerImage($id)
    {
      $return = url('public/assets/frontend/img/' . config('app.default_image'));
      $data = self::where('id', $id)->first();
      if ($data && !empty($data->highlight_jobs_banner)) {
        $return =url('public/assets/images/home-page-banner/' .  $data->highlight_jobs_banner);
      }
      return $return;
    }
    public static function uploadAndSaveImage($fileObject,$id=''){
        $photo = $fileObject;
        $ext = $fileObject->extension();
        $filename = rand().'_'.time().'.'.$ext;
        $filePath = public_path().'/assets/images/home-page-banner';
        if (! File::exists($filePath)) {
            File::makeDirectory($filePath);
        }

        $img = Image::make($photo->path());
        // $img->resize(50, 50, function ($const) {
        //     $const->aspectRatio();
        // })->save($filePath.'/'.$filename);
        $width = config('app.HomePageBannerDimension.width');
        $height = config('app.HomePageBannerDimension.height');
        if($img->width() == $width && $img->height() == $height){
            $photo->move($filePath.'/', $filename);
        }else{
            $img->resize($width, $height)->save($filePath.'/'.$filename);
        }
        if ($id) {
            $oldData = self::where('id', $id)->first();
            if ($oldData) {
                $path = public_path().'/assets/images/home-page-banner/'.$oldData->main_banner;
                if(file_exists($path)){
                    unlink($path);
                }
                $oldData->main_banner = $filename;
                $oldData->save();
            }
        }
        return $filename;
    }
    public static function uploadAndSaveJobImage($fileObject,$id=''){
        $photo = $fileObject;
        $ext = $fileObject->extension();
        $filename = rand().'_'.time().'.'.$ext;
        $filePath = public_path().'/assets/images/home-page-banner';
        if (! File::exists($filePath)) {
            File::makeDirectory($filePath);
        }

        $img = Image::make($photo->path());
        // $img->resize(50, 50, function ($const) {
        //     $const->aspectRatio();
        // })->save($filePath.'/'.$filename);
        $width = config('app.HomePageBannerJobsDimension.width');
        $height = config('app.HomePageBannerJobsDimension.height');
        if($img->width() == $width && $img->height() == $height){
            $photo->move($filePath.'/', $filename);
        }else{
            $img->resize($width, $height)->save($filePath.'/'.$filename);
        }
        if ($id) {
            $oldData = self::where('id', $id)->first();
            if (!empty($oldData) && $oldData->highlight_jobs_banner!='') {
                $path = public_path().'/assets/images/home-page-banner/'.$oldData->highlight_jobs_banner;
                if(file_exists($path)){
                    unlink($path);
                }
                $oldData->highlight_jobs_banner = $filename;
                $oldData->save();
            }
        }
        return $filename;
    }
    public static function getHomePageBannerData()
    {
        $data = HomePageBanner::whereNull('deleted_at')->first()->toArray();
        $return = self::formatedList($data);
        return $return;
    }
    public static function formatedList($data)
    {
        $return = [
          "Id" => $data['id'],
          "Header" => $data['header'],
          "Title" => $data['title'],
          "SubTitle" =>  $data['sub_title'],
          "MainBanner" => self::getBannerImage($data['id']),
          "HighlightedJobBanner" =>  self::getHighlightJobsBannerImage($data['id']),
          "createdAt" => getFormatedDate($data['created_at']),
          "CompanyLine" =>   !(Auth::check()) ? str_ireplace('Companies','<a href="'.url('/company-signup').'">Companies</a>',$data['company_line']) : $data['company_line'] ,
          "RecruiterLine" => !(Auth::check()) ? str_ireplace('Recruiters','<a href="'.url('/recruiter-signup').'">Recruiters</a>',$data['recruiter_line']) : $data['recruiter_line'],
          "CandidateLine" => !(Auth::check()) ? str_ireplace('Candidates','<a href="'.url('/candidate-signup').'">Candidates</a>',$data['candidate_line']) : $data['candidate_line'],
        ];
        return $return;
    }
}
