<?php

namespace App\Http\Controllers\API\V1;

use Illuminate\Http\Request;
use App\Http\Controllers\API\BaseController as BaseController;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Models\ArtistNews;
use App\Models\User;
use App\Models\Artist;
use Validator;
use Mail;
use Hash;

class ArtistNewsAPIController extends BaseController
{

	public function index($id)
    {
        $authId = User::getLoggedInId();
    	$data = ArtistNews::getNewsByArtist($id);
        $artistData = Artist::getArtistDetailAPI($id);
        
        $return = [
            [
                "componentId"=> "artistDetail",
                "sequenceId"=> "1",
                "isActive"=> "1",
                "artistDetailData"=>$artistData['artistDetail']
            ],[
                "componentId"=> "news",
                "sequenceId"=> "1",
                "isActive"=> "1",
                "newsData"=>$data
            ]
        ];
        return $this->sendResponse($return, 'News listed successfully.');
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
			// 'date'=>'required',
        ]);
        if($validator->fails())
        {
            return $this->sendError('Validation Error.', $validator->errors(),300);
        }else{
            $input = $request->all();
            $insert = $input;
			$insert['status']='1';
            $response = ArtistNews::addNew($insert);
            return $this->sendResponse($response['data'], 'News added in your profile');
        }
    }
	
    public function edit($id)
    {
        $data = ArtistNews::getNewsById($id);
        return $this->sendResponse($data, 'News retrived successfully.');
    }

    public function update(Request $request)
    {
        $input = $request->all();
        $validator = Validator::make($input,
        [
            'news_id'=>'required',
            // 'artist_id' => 'required',
            'name' => 'required',
            'description'=>'required',
            // 'date'=>'required',
        ]);
        if($validator->fails())
        {
            return $this->sendError('Validation Error.', $validator->errors(),300);
        }else{
            $input = $request->all();
            $update = $input;
            $news_id = $request->news_id;
            $response = ArtistNews::updateData($update,$news_id);
            return $this->sendResponse($response['data'], 'News updated in your profile');
        }
    }

	public function delete(Request $request)
    {
        $model = ArtistNews::where('id', $request->id)->first();
        if (!empty($model)) {
            $model->delete();
            return $this->sendResponse([], 'News removed from your profile');
        } else {
            return $this->sendError([], 'Something went wrong!!');
        }
    }

}
