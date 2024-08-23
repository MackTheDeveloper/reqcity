<?php

namespace App\Http\Controllers\API\V1;

use Illuminate\Http\Request;
use App\Http\Controllers\API\BaseController as BaseController;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Models\ArtistEvents;
use App\Models\User;
// use App\Models\ArtistNews;
use Validator;
use Mail;
use Hash;

class ArtistEventAPIController extends BaseController
{

    public function index()
    {
        $authId = User::getLoggedInId();
        $data = ArtistEvents::getListByArtistId($authId);
        $return = [
            "componentId"=> "event",
            "sequenceId"=> "1",
            "isActive"=> "1",
            "eventData"=>$data
        ];
        return $this->sendResponse($return, 'Artist Event listed successfully.');
    }


    public function create(Request $request)
    {
        $input = $request->all();
        $validator = Validator::make($input,
        [
            // 'category_id' => 'required',
            // 'artist_id' => 'required',
            'name' => 'required',
            'description'=>'required',
            'date'=>'required',
            'location'=>'required',
            'time'=>'required',
            'banner_images' => 'mimes:jpg,jpeg,png|max:20000'
        ]);
        if($validator->fails())
        {
            return $this->sendError('Validation Error.', $validator->errors(),300);
        }else{
            $input = $request->all();
            $insert = $input;
            $insert['status']='1';
            if($request->hasFile('banner_image')) {
                $fileObject = $request->file('banner_image');
                $insert['banner_image'] = ArtistEvents::uploadAndSaveImage($fileObject);
            }else{
                if (isset($input['imageEncoded'])) {
                    $insert['banner_image'] = ArtistEvents::uploadAndSaveImageApi($input['imageEncoded']);
                    unset($input['imageEncoded']);
                }
            }
            $response = ArtistEvents::addNew($insert);
            return $this->sendResponse($response['data'], 'Event added in your profile');
        }
    }

    public function edit($id)
    {
        $data = ArtistEvents::getEventById($id);
        return $this->sendResponse($data, 'Event retrived successfully.');
    }
    
    public function update(Request $request)
    {
        $input = $request->all();
        $validator = Validator::make($input,
        [
            'event_id'=>'required',
            'name' => 'required',
            'description'=>'required',
            'date'=>'required',
            'location'=>'required',
            'time'=>'required',
            'banner_images' => 'mimes:jpg,jpeg,png|max:20000'
        ]);
        if($validator->fails())
        {
            return $this->sendError('Validation Error.', $validator->errors(),300);
        }else{
            $input = $request->all();
            $update = $input;
            $event_id = $request->event_id;
            if($request->hasFile('banner_image')) {
                $fileObject = $request->file('banner_image');
                $insert['status'] = ArtistEvents::uploadAndSaveImage($fileObject,$event_id);
            }else{
                if (isset($input['imageEncoded'])) {
                    $insert['status'] = ArtistEvents::uploadAndSaveImageApi($input['imageEncoded'],$event_id);
                    unset($input['imageEncoded']);
                }
            }
            $response = ArtistNews::updateData($update,$event_id);
            return $this->sendResponse($response['data'], 'Event updated in your profile');
        }
    }

    public function delete(Request $request)
    {
        $model = ArtistEvents::where('id', $request->id)->first();
        if (!empty($model)) {
            $model->delete();
            return $this->sendResponse([], 'Event removed from your profile');
        } else {
            return $this->sendError([], 'Something went wrong!!');
        }
    }
}
