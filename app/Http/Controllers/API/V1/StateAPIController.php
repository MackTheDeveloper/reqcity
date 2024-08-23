<?php

namespace App\Http\Controllers\API\V1;

use Illuminate\Http\Request;
use App\Http\Controllers\API\BaseController as BaseController;
use App\Http\Controllers\Controller;
use App\Models\States;
use Illuminate\Support\Facades\Auth;
use App\Models\Reviews;
use App\Models\ReviewUploads;
use Validator;
use Mail;
use Hash;

class StateAPIController extends BaseController
{

    public function index(Request $request)
    {
        $stateData = States::getListForDropdown();
        $component =
            [
                "componentId" => "stateList",
                "sequenceId" => "1",
                "isActive" => "1",
                "stateListData" => [
                    "countries" => $stateData,
                ],
            ];
        return $this->sendResponse($component, 'State listed successfully.');
    }

}
