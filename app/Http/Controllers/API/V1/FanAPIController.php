<?php

namespace App\Http\Controllers\API\V1;

use Illuminate\Http\Request;
use App\Http\Controllers\API\BaseController as BaseController;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Models\Fan;
use App\Models\Reviews;
use App\Models\User;
use App\Models\FanPlaylist;
use App\Models\FanPlaylistSongs;
use App\Models\FanFavouriteSongs;
use App\Models\FanFavouriteArtists;
use App\Models\UserProfilePhoto;
use App\Models\FanFavouriteGroups;
use Validator;
use Mail;
use Hash;

class FanAPIController extends BaseController
{

    public function index()
    {
        $user_id = Auth::user()->id;
        $data = Reviews::userWiseData($user_id);
        $return = [
            "componentId" => "myReviews",
            "sequenceId" => "1",
            "isActive" => "1",
            "myReviewsData" => $data
        ];
        return $this->sendResponse($return, 'Reviews listed successfully.');
    }


    public function detail()
    {
        $authId = User::getLoggedInId();
        $data = Fan::getDetailApi($authId);
        $return = [
            "componentId" => "profile",
            "sequenceId" => "1",
            "isActive" => "1",
            "profileData" => $data
        ];
        return $this->sendResponse($return, 'your profile retrived successfully.');
    }

    public function update(Request $request)
    {
        $input = $request->all();
        $authId = User::getLoggedInId();
        if ($request->hasFile('profile_pic')) {
            //$fileObject = $request->file('profile_pic');
            //UserProfilePhoto::uploadAndSaveProfilePhoto($fileObject, $authId);
            if (isset($input['hiddenPreviewImg'])) {
                $fileObject = $request->file('profile_pic');
                UserProfilePhoto::uploadAndSaveProfileViaCropped($fileObject,$authId,$input);
                unset($input['hiddenPreviewImg']);
            }else{
                $fileObject = $request->file('profile_pic');
                UserProfilePhoto::uploadAndSaveProfilePhoto($fileObject, $authId);
            }
        } else {
            if (isset($input['imageEncoded'])) {
                UserProfilePhoto::uploadAndSaveProfilePhotoApi($input['imageEncoded'], $authId);
                unset($input['imageEncoded']);
            }
        }
        $data = Fan::updateExist($input);
        if ($data['success']) {
            return $this->sendResponse([], 'Your profile details has been updated successfully.');
        } else {
            return $this->sendError($data['data'], 'Something went wrong.');
        }
    }

    public function playlistindex()
    {
        $authId = User::getLoggedInId();
        $data = FanPlaylist::getListApi($authId);
        $return = [
            "componentId" => "playlist",
            "sequenceId" => "1",
            "isActive" => "1",
            "playlistData" => $data
        ];
        return $this->sendResponse($return, 'Playlist listed successfully.');
    }


    public function playlistsongs($playlistId)
    {
        // $user_id = Auth::user()->id;
        $data = FanPlaylistSongs::getListApi($playlistId);
        $totalSongs = count($data).' '."Songs";
        $playlistData = FanPlaylist::where('id',$playlistId)->first();
        $playlistImage = FanPlaylistSongs::getPlaylistIcon($playlistId);
        $return = [
            [
                "componentId" => "playlistTopComponent",
                "sequenceId" => "1",
                "isActive" => "1",
                "playlistTopComponentData" =>
                    [
                        "image" => $playlistImage,
                        "name" => $playlistData['playlist_name'],
                        "desc" => isset($totalSongs) ? $totalSongs : "",
                        "isFav" => "1"                     
                    ],                                                  
                        
            ],
            [
                "componentId" => "playlistSongs",
                "sequenceId" => "1",
                "isActive" => "1",
                "playlistSongsData" => [
                    "list" => $data
                ]

            ]

        ];
        return $this->sendResponse($return, 'Playlist Songs listed successfully.');
    }

    public function playlistSongAdd(Request $request)
    {
        $input = $request->all();
        $validator = Validator::make(
            $input,
            [
                'song_id' => 'required',
                'playlist_id' => 'required',
            ]
        );
        if ($validator->fails()) {
            return $this->sendError('Validation Error.', $validator->errors(), 300);
        } else {
            // $user_id = Auth::user()->id;
            $input = $request->all();
            $data = FanPlaylistSongs::addSongToPlaylist($input);
            if ($data) {
                return $this->sendResponse([], 'Songs Added to Playlist successfully.');
            } else {
                return $this->sendError([], 'Something went wrong.');
            }
        }
    }

    public function playlistCreateSongAdd(Request $request)
    {
        $input = $request->all();
        $validator = Validator::make(
            $input['playlist'],
            [
                'playlist_name' => 'required'
            ]
        );
        if ($validator->fails()) {
            return $this->sendError('Validation Error.', $validator->errors(), 300);
        } else {
            // $user_id = Auth::user()->id;
            $input = $request->all();
            $data = FanPlaylistSongs::createPlaylistAddSongs($input);
            if ($data) {
                return $this->sendResponse([], 'Playlist created successfully.');
            } else {
                return $this->sendError([], 'Something went wrong.');
            }
        }
    }

    public function playlistSongRemove($playlistSongId)
    {
        // $user_id = Auth::user()->id;
        $data = FanPlaylistSongs::where('id', $playlistSongId)->first();
        if ($data) {
            $data->delete();
            return $this->sendResponse([], 'Song Removed from your playlist.');
        } else {
            return $this->sendError([], 'Something went wrong.');
        }
    }

    public function favouriteSongs()
    {
        $authId = User::getLoggedInId();
        $data = FanFavouriteSongs::getListApi($authId);
        $return = [
            "componentId" => "favSongs",
            "sequenceId" => "1",
            "isActive" => "1",
            "favSongsData" => $data
        ];
        return $this->sendResponse($return, 'Favourite Songs listed successfully.');
    }

    public function favouriteSongAction(Request $request)
    {
        $songId = $request->song_id;
        if ($songId) {
            $authId = User::getLoggedInId();
            $data = FanFavouriteSongs::where('fan_id', $authId)->where('song_id', $songId)->first();
            if ($data) {
                $data->delete();
                return $this->sendResponse([], 'Song Removed from your favourites successfully.');
            } else {
                FanFavouriteSongs::create([
                    'fan_id' => $authId,
                    'song_id' => $songId
                ]);
                return $this->sendResponse([], 'Song added to your favourites successfully.');
            }
        } else {
            return $this->sendError([], 'Missing Song for make it favourite.');
        }
    }


    public function favouriteArtists()
    {
        $authId = User::getLoggedInId();
        $data = FanFavouriteArtists::getListApi($authId);
        $return = [
            "componentId" => "favArtists",
            "sequenceId" => "1",
            "isActive" => "1",
            "favArtistsData" => $data
        ];
        return $this->sendResponse($return, 'Favourite Artist listed successfully.');
    }

    public function favouriteArtistAction(Request $request)
    {
        $artistId = $request->artist_id;
        if ($artistId) {
            $authId = User::getLoggedInId();
            $data = FanFavouriteArtists::where('fan_id', $authId)->where('artist_id', $artistId)->first();
            if ($data) {
                $data->delete();
                return $this->sendResponse([], 'Artist Removed from your favourites successfully.');
            } else {
                FanFavouriteArtists::create([
                    'fan_id' => $authId,
                    'artist_id' => $artistId
                ]);
                return $this->sendResponse([], 'Artist added to your favourites successfully.');
            }
        } else {
            return $this->sendError([], 'Missing Artist for make it favourite.');
        }
    }

    public function playlistSongsNew($playlistId)
    {
        // $user_id = Auth::user()->id;
        $data = FanPlaylistSongs::getListApiNew($playlistId);
        $return = [
            "componentId" => "playlistSongs",
            "sequenceId" => "1",
            "isActive" => "1",
            "playlistSongsData" => $data
        ];
        return $this->sendResponse($return, 'Playlist Songs listed successfully.');
    }

    public function favouriteSongsNew($search="")
    {
        //patch by nivedita for search page see all//
        if(!empty($search))
        $search=$search;
        else
        $search='';
        //patch by nivedita for search page see all//
        $authId = User::getLoggedInId();
        $data = FanFavouriteSongs::getListApiNew($authId,'',$search);
        $return = [
            "componentId" => "favSongs",
            "sequenceId" => "1",
            "isActive" => "1",
            "favSongsData" => $data
        ];
        return $this->sendResponse($return, 'Favourite Songs listed successfully.');
    }

    public function favouritePlaylist($search)
    {
        $authId = User::getLoggedInId();
        $return = [
            "componentId" => "favPlaylist",
            "title" => "Favorite Playlists",
            "sequenceId" => "1",
            "isActive" => "1",
            "favPlaylistData" => FanFavouriteGroups::getListApi($authId,'',$search),
        ];
        return $this->sendResponse($return, 'Favourite Songs listed successfully.');
    }
    public function myFavouritePlaylist($search)
    {
        $authId = User::getLoggedInId();
        $return = [
            "componentId" => "myPlaylist",
            "title" => "My Playlists",
            "sequenceId" => "1",
            "isActive" => "1",
            "PlaylistData" => FanPlaylist::getListApi($authId,'',$search),
        ];
        return $this->sendResponse($return, 'Fan Playlist listed successfully.');
    }
}
