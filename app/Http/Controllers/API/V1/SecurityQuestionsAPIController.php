<?php

namespace App\Http\Controllers\API\V1;

use Illuminate\Http\Request;
use App\Http\Controllers\API\BaseController as BaseController;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Models\SecurityQuestions;
use App\Models\UserSecurityQuestions;
use App\Models\User;
use Validator;
use Mail;
use Hash;

class SecurityQuestionsAPIController extends BaseController
{
    // public function index(Request $request){
    //     $data = ContactUs::userAndStatusWiseData();
    //     return $this->sendResponse($data, 'Reviews listed successfully.');
    // }


    public function create(Request $request)
    {
      $input = $request->request->all();
      $authId = User::getLoggedInId();
      foreach($input['question'] as $key=>$value){
        $userQuestionDetails=UserSecurityQuestions::getSecurityQuestionDetails($authId,$value);
        if(!empty($input['answer_'.$value])){
          if(empty($userQuestionDetails)){
            $dataToInsert=array("user_id"=>$authId,
                                "security_question_id"=>$value,
                                "answer"=>$input['answer_'.$value],
                               );
            $data = UserSecurityQuestions::addNew($dataToInsert);
          }
          else{
            $dataToUpdate=array("answer"=>$input['answer_'.$value]);
            $data = UserSecurityQuestions::updateAnswer($dataToUpdate,$authId,$value);
          }
        }
        else{
          if(!empty($userQuestionDetails)){
            $data = UserSecurityQuestions::deleteAnswer($authId,$value);
          }
        }
      }
      if ($data['success']) {
        return $this->sendResponse($data['data'], "Your security question's details updated successfully.");
      }else{
        return $this->sendError($data['data'], 'Something went wrong.');
      }
    }

    public function check(Request $request)
    {
      $input = $request->request->all();
      $success = true;
      foreach($input['question'] as $key=>$value){
        $question=UserSecurityQuestions::where('security_question_id',$value)->first();
        if($question){
          $data=UserSecurityQuestions::checkSecurityQuestion($value,$input['answer_'.$value]);
          if ($data['success']==false) {
            $success = false;
          }
        }
      }
    if ($success) {
      return $this->sendResponse($data['data'], "Great! Your account information has been recovered.");
    }else{
      return $this->sendError($data['data'], 'Sorry, your answers are not matching with our system.Please give correct answer to recover your account information.');
    }
  }
}
