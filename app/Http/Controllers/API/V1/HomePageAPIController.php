<?php

namespace App\Http\Controllers\API\V1;

use Illuminate\Http\Request;
use App\Http\Controllers\API\BaseController as BaseController;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Models\Fan;
use App\Models\User;
use App\Models\HomePageComponent;
use App\Models\HomePageBanner;
use App\Models\HowItWorksApp;
use App\Models\DynamicGroupItems;
use App\Models\FanFavouriteArtists;
use App\Models\FanFavouriteGroups;
use App\Models\FanFavouriteSongs;
use App\Models\FanPlaylist;
use App\Models\HowItWorks;
use Validator;
use Mail;
use Hash;

class HomePageAPIController extends BaseController
{
  public function homePageData()
  {
    $authId = User::getLoggedInId();

    // Home page header menu
    $homePageHeaderMenuData = HomePageComponent::getHomePageHeaderMenuData();
    $HomePageHeaderMenu = [
      "componentId" => "HomePageHeaderMenu",
      "sequenceId" => "1",
      "isActive" => "1",
      "isApp" => "1",
      "HomePageHeaderMenuData" => $homePageHeaderMenuData
    ];
    $result[] = $HomePageHeaderMenu;

    //home page banner data
    $HomePageBanner = HomePageBanner::getListApi();
    $HomePageBannerComponent = [
      "componentId" => "HomePageBannerComponent",
      "sequenceId" => "2",
      "isActive" => "1",
      "isApp" => "1",
      "HomePageBannerData" => $HomePageBanner
    ];
    $result[] = $HomePageBannerComponent;
    //End of home page banner data
    //home page how it works data
    $HowItWorksApp = HowItWorksApp::getListApi();
    $HowItWorksAppComponent = [
      "componentId" => "HowItWorksAppComponent",
      "sequenceId" => "3",
      "isActive" => "1",
      "isApp" => "1",
      //"HowItWorksAppData" => $HowItWorksApp
      "HowItWorksAppData" => [
        "label"=>[
          'mainLabel' => 'How It Works',
          'mainDescription' => 'Joining Fanclub is as simple as 1, 2, 3! Follow these easy steps to unlock a treasure trove of music and to discover a host of new artists. With access to all artists, you can create the perfect soundtrack to your life.',
          'fanLabel' => 'Fan',
          'fanDescription' => 'Join the fanclub community today. Follow these simple steps to unlock your exclusive access to all of your favourite artists',
          'artistLabel' => 'Artist',
          'artistDescription' => 'Join fanclub today and start building your fan base. Share your story, your music and your event calendar and earn $$',
        ],
        "list"=>$HowItWorksApp
      ],
    ];
    $result[] = $HowItWorksAppComponent;
    //End of home page how it works data

    if (!Auth::check()) {
      //home page how it works web data
      $HowItWorksWeb = HowItWorks::getListApi();
      $HowItWorksWebComponent = [
        "componentId" => "HowItWorksWebComponent",
        "sequenceId" => "3",
        "isActive" => "1",
        "isApp" => "0",
        "HowItWorksWebData" => [
          "label"=>[
            'mainLabel' => 'How It Works',
            'mainDescription' => 'Joining Fanclub is as simple as 1, 2, 3! Follow these easy steps to unlock a treasure trove of music and to discover a host of new artists. With access to all artists, you can create the perfect soundtrack to your life.',
            'fanLabel' => 'Fan',
            'fanDescription' => 'Join the fanclub community today. Follow these simple steps to unlock your exclusive access to all of your favourite artists',
            'artistLabel' => 'Artist',
            'artistDescription' => 'Join fanclub today and start building your fan base. Share your story, your music and your event calendar and earn $$',
          ],
          "list"=>$HowItWorksWeb
        ],
        //"HowItWorksWebData" => $HowItWorksWeb
      ];
      $result[] = $HowItWorksWebComponent;
      //End of home page how it works web data
    }

    $authId = User::getLoggedInId();
    if ($authId) {
      $myPlaylist = [
        "componentId" => "myPlaylist",
        "title" => "My Playlist",
        "sequenceId" => "4",
        "isActive" => "1",
        "isApp" => "1",
        "myPlaylistData" => FanPlaylist::getListApi($authId),
      ];
      $result[] = $myPlaylist;

      $favPlaylist = [
        "componentId" => "favPlaylist",
        "title" => "Favorite Playlists",
        "sequenceId" => "5",
        "isActive" => "1",
        "isApp" => "1",
        "favPlaylistData" => FanFavouriteGroups::getListApi($authId, 10),
      ];
      $result[] = $favPlaylist;

      $myCollections = [
        "componentId" => "myCollections",
        "title" => "My Collections",
        "sequenceId" => "6",
        "isActive" => "1",
        "isApp" => "1",
        "myCollectionsData" => FanFavouriteSongs::getListApi($authId, 10),
      ];
      $result[] = $myCollections;

      $favArtist = [
        "componentId" => "favArtist",
        "title" => "Favorite Artist",
        "sequenceId" => "7",
        "isActive" => "1",
        "isApp" => "1",
        "favArtistData" => FanFavouriteArtists::getListApi($authId, 10),
      ];
      $result[] = $favArtist;
    }

    //home page component data
    $HomePageComponentList = HomePageComponent::getListApi();
    $HomePageComponent = [
      "componentId" => "HomePageComponent",
      "sequenceId" => "8",
      "isActive" => "1",
      "isApp" => "1",
      "HomePageComponentData" => $HomePageComponentList
    ];
    $result[] = $HomePageComponent;
    //End of home page component data
    
    $return = $result;

    //pre($return);

    return $this->sendResponse($return, 'Home Page Data listed successfully.');
  }

  //To be call on view all
  public function getViewAll(Request $request)
  {
    $authId = User::getLoggedInId();
    $input = $request->all();
    $type = $input['type'];
    $related_id = $input['related_id'];
    $viewAll = DynamicGroupItems::getviewAll($type, $related_id);
    if ($viewAll) {
      $return = [
        "componentId" => "groupList",
        "sequenceId" => "1",
        "isActive" => "1",
        "groupListData" => $viewAll
      ];
    }
    return $this->sendResponse($return, 'View all Listed Successfully.');
  }
}
