<?php

namespace App\Http\Controllers\API\V1;

use App\Models\ForumComments;
use App\Models\Forums;
use App\Models\MusicCategories;
use Illuminate\Http\Request;
use App\Http\Controllers\API\BaseController as BaseController;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Models\Reviews;
use App\Models\ReviewUploads;
use Validator;
use Mail;
use Hash;
use DB;

class MusicCategoryAPIController extends BaseController
{
    public function index(Request $request)
    {
        $input = $request->all();
        $search = isset($input['search']) ? $input['search'] : '';
        $data = MusicCategories::getMusicCategoryListApi($search);
        $component = [
            "componentId" => "MusicCategoryList",
            "sequenceId" => "1",
            "isActive" => "1",
            "MusicCategoryListData" => ["list" => $data['musicCategory']]
        ];
        return $this->sendResponse($component, 'Music Category Listed Successfully.');
    }


}
