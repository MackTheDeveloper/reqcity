<?php

namespace App\Http\Controllers\API\V1;

use Illuminatev\Http\Request;
use App\Http\Controllers\API\BaseController as BaseController;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Models\Reviews;
use App\Models\ReviewUploads;
use App\Models\DynamicGroups;
use App\Models\FanFavouriteSongs;
use App\Models\FanFavouriteArtists;
use App\Models\FanFavouriteGroups;
use App\Models\FanPlaylist;
use App\Models\FanSearches;
use App\Models\Artist;
use App\Models\Songs;
use App\Models\MusicGenres;
use App\Models\User;
use Validator;
use Mail;
use Hash;

class SearchAPIController extends BaseController
{

    public function search($request)
    {
        $fanclubPlaylistData = DynamicGroups::searchAPIDynamicGroups($request->search);
        $myCollectionData = FanFavouriteSongs::searchAPIFanFavouriteSong($request->search);
        $myPlaylistData = FanPlaylist::searchAPIFanPlaylist($request->search);
        $myArtistData = FanFavouriteArtists::searchAPIFanFavoriteArtist($request->search);
        // $artistData = DynamicGroups::searchAPIDynamicGroups($request->search);
        $artistData = Artist::searchAPIArtist($request->search);
        $songsData = Songs::searchAPISongs($request->search);
        $genreData = MusicGenres::searchAPIGenres($request->search);
        if(!empty($authId = User::getLoggedInId())){
          if(!empty($fanclubPlaylistData) || !empty($myCollectionData) || !empty($myPlaylistData) || !empty($myArtistData) || !empty($artistData) || !empty($genreData) || !empty($songsData) ){
            $data = FanSearches::apiAddFanSearch($request->search);
            }
        }
        $recentSearchdata = FanSearches::apiGetRecentSearches();
        $component =
        [
            "componentId" => "searchList",
            "sequenceId" => "1",
            "isActive" => "1",
            "searchListData" => [
                "fanclubPlaylistData" => $fanclubPlaylistData['groupDetail'],
                "myCollectionData" => $myCollectionData['songDetail'],
                "myPlaylistData" => $myPlaylistData['playlistDetail'],
                "myArtistData" => $myArtistData['artistDetail'],
                "recentSearchdata" => $recentSearchdata['recentSearches'],
                "artistData" => $artistData['artistDetail'],
                "songsData" => $songsData['songsDetails'],
                "genreData" => $genreData['genresDetails'],
                "recentSearchdata" => $recentSearchdata['recentSearches'],
            ],
        ];
        return $this->sendResponse($component, 'Search resulted successfully.');
    }

    public function searchTagRemove($request)
    {
        $input = $request->all();
        $fansearchId = $input['fansearchId'];
        $authId = User::getLoggedInId();
        $searchDetails = FanSearches::where('fan_id',$authId)->where('id',$fansearchId)->first();
        if ($searchDetails) {
            $searchDetails->status = 0;
            $searchDetails->update();
        }
        $recentSearchdata = FanSearches::apiGetRecentSearches();
        $component =
        [
            "componentId" => "recentSearchList",
            "sequenceId" => "1",
            "isActive" => "1",
            "recentSearchListData" => [
                "recentSearchdata" => $recentSearchdata['recentSearches'],
            ],
        ];
        return $this->sendResponse($component, 'Search tag removed successfully.');
    }
}
