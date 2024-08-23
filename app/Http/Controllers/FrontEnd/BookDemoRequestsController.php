<?php

namespace App\Http\Controllers\FrontEnd;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Validator;
// use Illuminate\Support\Facades\Hash;
// use Illuminate\Support\Str;
use App\Models\BookDemoRequest;
use App\Models\EmailTemplates;
use Exception;
use Auth;
use Mail;
use Response;
// use Illuminate\Support\Facades\Session;

class BookDemoRequestsController extends Controller
{
    /* ###########################################
    // Function: store
    // Description: Submit Book demo requests page
    // ReturnType: view
    */ ###########################################
    public function bookRequest(Request $request){
      $validator = Validator::make(
          $request->all(),
          [
              'first_name' => 'required',
              'email' => 'required|email|max:255',
              'phone' => 'required',
              'requirement' => 'required',
              // 'phone' => 'required|unique:users,phone',
              // 'email' => 'required|email|unique:users',
              // 'role_id' => 'required',
          ]
      );
      if ($validator->fails()) {
          return $this->sendError('Validation Error.', $validator->errors(), 300);
      }
      unset($request['_token']);
      unset($request['phoneField1']);
      $input = $request->all();
      $success = array();
      $input['prefix'] = $request['phoneField1_phoneCode'];
      unset($input['phoneField1_phoneCode']);
      $input['status'] = 0;
      $bookDemoRequest = BookDemoRequest::addNew($input);
      if(!empty($bookDemoRequest)){
          try {
              $data = ['FIRST_NAME' => $bookDemoRequest['data']['first_name'], 'LAST_NAME' => $bookDemoRequest['data']['last_name'], 'LINK' => route('login'),];
              EmailTemplates::sendMail('book-demo-request', $data, $bookDemoRequest['data']['email']);
          } catch (\Exception $e) {
              pre($e->getMessage());
          }
          return $this->sendResponse([], config('message.BookDemoRequest.Add'));
      }
      else{
        return $this->sendError('Something went wrong!!', ['error' => 'Something went wrong!!'], 300);
      }
    }
}
