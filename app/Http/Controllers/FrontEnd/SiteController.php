<?php

namespace App\Http\Controllers\FrontEnd;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use App\Models\User;
use App\Http\Controllers\API\V1\AuthAPIController;
use App\Http\Controllers\API\V1\LocationAPIController;
use App\Http\Controllers\API\V1\SearchAPIController;
use App\Http\Controllers\API\V1\FaqAPIController;
use App\Http\Controllers\API\V1\DynamicGroupAPIController;
use Exception;
use Auth;
use Mail;
use Socialite;
use Response;
use Agent;
use App\Http\Controllers\API\V1\ArtistAPIController;
use App\Http\Controllers\API\V1\SongAPIController;
use Illuminate\Support\Facades\Session;
use App\Models\GlobalSettings;
use App\Models\CmsPages;
use App\Models\Country;
use App\Models\DynamicGroups;
use App\Models\HomePageComponent;
use Illuminate\Routing\Route;
use Illuminate\Support\Facades\URL;

class SiteController extends Controller
{
    /* ###########################################
    // Function: home
    // Description: Display front end home page
    // Parameter: No Parameter
    // ReturnType: view
    */ ###########################################
    public function faq(Request $request)
    {
        try {
            $api = new FaqAPIController();
            $data = $api->index($request);
            $data = $data->getData();
            $content = $data->component;
            $content = componentWithNameObject($content);
            // pre($content);
            return view('frontend.site.faq', compact('content'));
        } catch (\Exception $e) {
            pre($e->getMessage());
        }
    }

    public function themeToggle(Request $request)
    {
        try {
            $api = new AuthAPIController();
            $data = $api->themeToggle($request);
            $data = $data->getData();
            return Response::json($data);
        } catch (\Exception $e) {
            pre($e->getMessage());
        }
    }

    public function dymanicGroupSlug($slug)
    {
        $dynamicGroup = DynamicGroups::where('slug', $slug)->first();
        if ($dynamicGroup->type == 1)
            return redirect()->route('showContactUs');
    }

    public function collection(Request $request)
    {
        $currentPath = request()->path();
        $exploaded = explode('/', $currentPath);
        $dynamicGroup = DynamicGroups::where('slug', $exploaded[1])->first();
        if ($dynamicGroup) {
            if ($dynamicGroup->type == 1) // Artists
            {
                $api = new ArtistAPIController();
                $data = $api->getArtistsByDynamicGroup($dynamicGroup->id);
                $data = $data->getData();
                $content = $data->component;
                // pre($content);
                $title = str_replace('-',' ',$exploaded[1]);
                return view('frontend.artist.artist-all', compact('content','title'));
            } else if ($dynamicGroup->type == 2) // Songs
            {
                $api = new SongAPIController();
                $data = $api->getSongsByDynamicGroup($dynamicGroup->id);
                $data = $data->getData();
                $content = $data->component;
                //pre($content);
                $title = str_replace('-',' ',$exploaded[1]);
                return view('frontend.songs.song-all', compact('content','title'));
            }
        } else {
            abort(404, 'Page not found');
        }
    }
    public function fanclubPlaylist($search="")
    {
        //patch by nivedita for search page see all//
        if(!empty($search))
        $search=$search;
        else
        $search='';
        //patch by nivedita for search page see all//
        try {
            $api = new DynamicGroupAPIController();
            $data = $api->index($search);
            $data = $data->getData();
            $content = $data->component;
            $content = componentWithNameObject($content);
            // pre($content);
            return view('frontend.auth.fanclub-playlist', compact('content'));
        } catch (\Exception $e) {
            pre($e->getMessage());
        }
    }
}
