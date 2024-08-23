<?php

namespace App\Http\Controllers\API\V1;

use App\Models\Artist;
use App\Models\Forums;
use App\Models\Songs;
use App\Models\User;
use App\Models\SongViews;
use App\Models\FanPlaylist;
use App\Models\FanFavouriteGroups;
use App\Models\FanFavouriteArtists;
use App\Models\FanFavouriteSongs;
use Illuminate\Http\Request;
use App\Http\Controllers\API\BaseController as BaseController;
use App\Models\DynamicGroups;
use Validator;
use Mail;
use Hash;

class SongAPIController extends BaseController
{
    public function filteredList(Request $request)
    {
        $input = $request->all();
        $page = isset($input['page']) ? $input['page'] : 1;
        $search = isset($input['search']) ? $input['search'] : '';
        $filter = isset($input['filter']) ? $input['filter'] : [];
        $data = Songs::getFilteredList($page, $search, $filter);
        $component = [
            "componentId" => "songFiltered",
            "sequenceId" => "1",
            "isActive" => "1",
            "pageSize" => $data['limit'],
            "pageNo" => (string) $data['page'],
            "songFilteredData" => $data['data'],
        ];
        return $this->sendResponse($component, 'Song Listed Successfully.');
    }

    public function filteredReviewList(Request $request)
    {
        $input = $request->all();
        $page = isset($input['page']) ? $input['page'] : 1;
        $search = isset($input['search']) ? $input['search'] : '';
        $filter = isset($input['filter']) ? $input['filter'] : [];
        $data = Songs::getFilteredReviewList($page, $search, $filter);
        $component = [
            "componentId" => "songFiltered",
            "sequenceId" => "1",
            "isActive" => "1",
            "pageSize" => $data['limit'],
            "pageNo" => (string) $data['page'],
            "songFilteredData" => $data['data'],
        ];
        return $this->sendResponse($component, 'Song Listed Successfully.');
    }

    public function SongsDetails($id)
    {
        $data = Songs::getSongsAPIDetails($id);
        $component = [
            "componentId" => "SongsDetailsList",
            "sequenceId" => "1",
            "isActive" => "1",
            "SongsDetailsListData" => $data['songsDetails']
        ];
        return $this->sendResponse($component, 'Songs Details Listed Successfully.');
    }

    public function SongsIncreaseView(Request $request)
    {
        $input = $request->all();
        $songId = $input['song_id'];
        $authId = User::getLoggedInId();
        $songDetail = Songs::where('id', $songId)->first();
        if ($songDetail) {
            $songDetail->num_views = ($songDetail->num_views != NULL) ? $songDetail->num_views + 1 : 1;
            $songDetail->save();
            SongViews::create([
                "song_id" => $songId,
                "viewer_id" => $authId
            ]);
        }
        return $this->sendResponse([], 'Song view increased successfully.');
    }

    public function SongCreate(Request $request)
    {
        $input = $request->all();
        $input['icon'] = '';
        $input['file'] = '';
        $authId = User::getLoggedInId();
        $validator = Validator::make(
            $input,
            [
                //'post_type' => 'required',
                //'category_id' => 'required',
                // 'image' => 'required',
                'song_icon' => 'mimes:jpeg,jpg,png,gif',
                // 'icon' => 'required|mimes:jpeg,jpg,png,gif',
            ]
        );
        if ($validator->fails()) {
            return $this->sendError('Validation Error.', $validator->errors(), 300);
        } else {
            if (isset($input['songIconBase64'])) {
                $input['icon'] = Songs::uploadIconEncoded($input['songIconBase64']);
            } else {
                if ($request->hasFile('song_icon')) {
                    if (isset($input['hiddenPreviewImg'])) {
                        $iconObject = $request->file('song_icon');
                        $input['icon'] = Songs::uploadIconEncoded($input['hiddenPreviewImg']);
                        unset($input['hiddenPreviewImg']);
                    } /* else {
                        $iconObject = $request->file('song_icon');
                        $input['icon'] = Songs::uploadIcon($iconObject);
                    } */
                }
                if ($request->hasFile('song_file')) {
                        $iconObject = $request->file('song_file');
                        $input['file'] = Songs::uploadSong($iconObject);
                }
            }
            // if (isset($input['songFileBase64'])) {
            //     $input['icon'] = Songs::uploadIconEncoded($input['songIconBase64']);
            // }else{
            //     if ($request->file('song_file')) {
            //         $iconObject = $request->file('song_file');
            //         $input['icon'] = Songs::uploadIcon($fileObject);
            //     }
            // }
            $newSong = new Songs();

            $newSong->artist_id = $authId;
            $newSong->name = $input['name'];
            $newSong->slug = getSlug($input['name'], "", 'songs', 'slug');
            $newSong->genre = $input['genre'];
            // $newSong->tags = $input['tags'];
            $newSong->icon = $input['icon'];
            $newSong->file = $input['file'];
            $newSong->tag = $input['tag'];
            $newSong->release_date = date('Y-m-d');
            $newSong->save();

            return $this->sendResponse([], 'Song added successfully.');
        }
    }

    public function myMusic()
    {
        $authId = User::getLoggedInId();
        $myPlaylist = [
            "componentId" => "myPlaylist",
            "title" => "My Playlist",
            "sequenceId" => "1",
            "isActive" => "1",
            "myPlaylistData" => FanPlaylist::getListApi($authId, 10),
        ];
        $favPlaylist = [
            "componentId" => "favPlaylist",
            "title" => "Favorite Playlists",
            "sequenceId" => "1",
            "isActive" => "1",
            "favPlaylistData" => FanFavouriteGroups::getListApi($authId, 10),
        ];
        $favArtist = [
            "componentId" => "favArtist",
            "title" => "Favorite Artist",
            "sequenceId" => "1",
            "isActive" => "1",
            "favArtistData" => FanFavouriteArtists::getListApi($authId, 10),
        ];
        $myCollections = [
            "componentId" => "myCollections",
            "title" => "My Collections",
            "sequenceId" => "1",
            "isActive" => "1",
            "myCollectionsData" => FanFavouriteSongs::getListApi($authId, 10),
        ];
        $component = [$myPlaylist, $favPlaylist, $favArtist, $myCollections];
        return $this->sendResponse($component, 'My Music Listed Successfully.');
    }

    public function getSongsByDynamicGroup($id)
    {
        $songData = DynamicGroups::getDetailApi($id);
        $return = [
            "componentId" => "groupDetail",
            "sequenceId" => "1",
            "isActive" => "1",
            "groupDetailData" => $songData
        ];
        return $this->sendResponse($return, 'song data retrived successfully.');
    }

    public function allSongs($search='',$page="")
    {
        //patch by nivedita for search page see all//
        if(!empty($page))
        $page=$page;
        else
        $page=1;
        if(!empty($search))
        $search=$search;
        else
        $search='';
        //patch by nivedita for search page see all//
        $songdata = Songs::searchAPISongs($search,$page);
        $return = [
            "componentId"=> "songList",
            "sequenceId"=> "3",
            "isActive"=> "1",
            "songData"=>$songdata,
            "pageSize" => $songdata['limit'],
            "pageNo" => (string) $songdata['page'],
        ];
        return $this->sendResponse($return, 'songs data retrived successfully.');
    }
}
