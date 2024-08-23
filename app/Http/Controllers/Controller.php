<?php

namespace App\Http\Controllers;

use App\Models\FooterLinks;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Support\Facades\View;
use Illuminate\Http\Request;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    /*
    *
    	Define base url commonly to use anywhere in application
    *
    */
    // public $baseUrl = "";

    function __construct()
    {
        $footerData = FooterLinks::getFooterData();
        View::share('frontendFooter', $footerData);
        //$this->baseUrl = url('/');
    }

    public function getBaseUrl()
    {
        return url('/');
    }

    public function sendResponse($result, $message,$code = 200)
    {
    	$response = [
            'statusCode' => (string)$code,
            'success' => true,
            // 'component'    => $result,
            // 'data'    => $result,
            'message' => $message,
        ];
        if ($result) {
            $response['component'] = $result;
        }
        return response()->json($response, $code);
    }


    public function sendError($error, $errorMessages = [], $code = 404)
    {
        $response =[
            'statusCode' => (string)$code,
        	'success' => false,
        	'message' => $error,
        ];

        if(!empty($errorMessages))
        {
            $response['component'] = $errorMessages;
            if ($error=='Validation Error.') {
                if ($errorMessages->getMessages()) {
                    $messages = $errorMessages->getMessages();
                    $messages = reset($messages);
                    if ($messages[0]) {
                        $response['message'] = $messages[0];
                    }
                }
            }
        }
        return response()->json($response, 200);
    }
}
