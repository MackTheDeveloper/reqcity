<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Image;
use File;


class UserSecurityQuestions extends Model
{
    //use SoftDeletes;

    protected $table = 'users_security_questions';
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'id','user_id','security_question_id','answer','created_at'
    ];

    public static function getSecurityQuestionDetails($authId,$questionId){
      $data=UserSecurityQuestions::where('user_id',$authId)->where('security_question_id',$questionId)->orderBy('created_at','DESC')->first();
      return ($data) ?: [];
    }
    public static function addNew($data){
        $return = '';
        $success = true;

        try{
            $create = new UserSecurityQuestions();
            foreach ($data as $key => $value) {
                $create->$key = $value;
            }
            $create->save();
            $return = $create;
        }catch(\Exception $e){
            $return = $e->getMessage();
            $success = false;
        }
        return ['data'=>$return,'success'=>$success];
    }
    public static function updateAnswer($data,$authId,$questionId){
        $return = '';
        $success = true;

        try{
            $update = UserSecurityQuestions::where('user_id',$authId)->where('security_question_id',$questionId)->orderBy('created_at','DESC')->first();
            foreach ($data as $key => $value) {
                $update->$key = $value;
            }
            $update->update();
            $return = $update;
        }catch(\Exception $e){
            $return = $e->getMessage();
            $success = false;
        }
        return ['data'=>$return,'success'=>$success];
    }
    public static function deleteAnswer($authId,$questionId){
        $return = '';
        $success = true;
        try{
            $update = UserSecurityQuestions::where('user_id',$authId)->where('security_question_id',$questionId)->delete();
            $return = 1;
        }catch(\Exception $e){
            $return = $e->getMessage();
            $success = false;
        }
        return ['data'=>$return,'success'=>$success];
    }
    public static function checkSecurityQuestion($questionID,$answer){
      $return = '';
      $success = true;

      try{
          $data=UserSecurityQuestions::where('security_question_id',$questionID)->where('answer',$answer)->first();
          if(empty($data))
          $success = false;
          $return = $data;
      }catch(\Exception $e){
          $return = $e->getMessage();
          $success = false;
      }
      return ['data'=>$return,'success'=>$success];
    }
}
