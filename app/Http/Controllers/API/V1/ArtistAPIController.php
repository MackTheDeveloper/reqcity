<?php

namespace App\Http\Controllers\API\V1;

use App\Models\Artist;
use App\Models\Songs;
use App\Models\ArtistEvents;
use App\Models\ForumComments;
use Illuminate\Http\Request;
use App\Http\Controllers\API\BaseController as BaseController;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Models\Inquiries;
use App\Models\UserProfilePhoto;
use App\Models\User;
use App\Models\ArtistDetail;
use App\Models\ArtistViews;
use App\Models\ArtistLikes;
use App\Models\DynamicGroups;
use App\Models\Reviews;
use App\Models\FanFavouriteArtists;
use App\Models\FanFavouriteGroups;
use App\Models\FanFavouriteSongs;
use Validator;
use Mail;
use Hash;
use DB;

class ArtistAPIController extends BaseController
{
    public function index($id)
    {
        $artistData = Artist::getArtistDetailAPI($id);
        $artistnews = $artistData['artistDetail']['artistNews'];
        $artistSong = Songs::getSongs($id);
        $component =
                [
                    [
                        "componentId" => "artistImage",
                        "sequenceId" => "1",
                        "isActive" => "1",
                        "artistImageData" =>
                        [
                            "image" => UserProfilePhoto::getProfilePhoto($artistData['artistDetail']['id'],'round_312_312.png'),
                            "name" => $artistData['artistDetail']['name'],
                            "isFav" => $artistData['artistDetail']['liked'],

                        ]
                    ],
                    [
                        "componentId" => "banner",
                        "sequenceId" => "2",
                        "isActive" => "1",
                        "bannerData" => [
                            "list" =>   [
                                            [
                                                "Id" => "1",
                                                "image" => "http://localhost/php/clubfan/public/assets/frontend/img/placeholder/placeholder.jpg",
                                                "isVideo" => "1"
                                            ]
                                        ]
                                       ]
                    ],
                    [
                        "componentId" => "artistDetail",
                        "sequenceId" => "3",
                        "isActive" => "1",
                        "artistDetailData" => [
                                            "aboutTitle" => 'Bio' ,
                                            "slug" => $artistData['artistDetail']['slug'],
                                            "aboutDesc" => substr($artistData['artistDetail']['bio'], 0, 100),
                                            "aboutFullDesc" => $artistData['artistDetail']['bio'],
                                            "newsTitle" => "News",
                                            "newsSubTitle" => substr($artistData['artistDetail']['newsDetail'], 0, 100),
                                            "newsDesc" => $artistData['artistDetail']['newsDetail'],
                                            "newsFullDesc" => "Es un hecho establecido hace demasiado tiempo que un lector",
                                            "newsDate" => "Sep 20th, 2021",
                                            "numLikes" =>$artistData['artistDetail']['numLikes'],
                                            "numSongs" =>$artistData['artistDetail']['numSongs']
                                            ]

                    ],
                    [
                        "componentId" => "review",
                        "sequenceId" => "4",
                        "isActive" => "1",
                                    "reviewData" => [
                                        "title" => "Reviews",
                                        "allReviews" => "All Reviews",
                                        "rating" => "4",
                                        "list" => $artistData['artistDetail']['artistReviews']

                                ]
                    ],
                    [
                        "componentId" => "upcomingEvent",
                        "sequenceId" => "5",
                        "isActive" => "1",
                        "upcomingEventData" => [
                            "title" => "Upcoming Events",
                            "rating" => $artistData['artistDetail']['avgRating'],
                            "list" =>  $artistData['artistDetail']['artistEvents']

                        ]
                    ],
                    [
                        "componentId" => "news",
                        "sequenceId" => "5",
                        "isActive" => "1",
                        "newsData" => [
                            "title" => "News",
                            "list" =>  $artistData['artistDetail']['artistNews']

                        ]
                    ],
                    [
                        "componentId" => "searchComponent",
                        "sequenceId" => "6",
                        "isActive" => "1"
                    ],
                    [
                        "componentId" => "artistSongList",
                        "sequenceId" => "7",
                        "isActive" => "1",
                        "artistSongListData" => [
                            "title" => "",
                            "list" => $artistData['artistDetail']['artistSongs']

                        ]
                    ]
                ];
                // "componentId" => "artistDetail",
                // "sequenceId" => "1",
                // "isActive" => "1",
                // "artistDetailData" => $artistData['artistDetail'],

        return $this->sendResponse($component, 'Artist Detailed successfully.');
    }

    public function ArtistsIncreaseView(Request $request)
    {
        $input = $request->all();
        $artistId = $input['artist_id'];
        $authId = User::getLoggedInId();
        $artistDetail = ArtistDetail::where('user_id',$artistId)->first();
        if ($artistDetail) {
            $artistDetail->num_views = ($artistDetail->num_views!=NULL)?$artistDetail->num_views+1:1;
            $artistDetail->save();
            ArtistViews::create([
                "artist_id"=>$artistId,
                "viewer_id"=>$authId
            ]);
        }
        return $this->sendResponse([], 'Artist view increased successfully.');
    }

    // By Nivedita 13-10-2021
    public function ArtistsIncreaseLike(Request $request)
    {
        $input = $request->all();
        $artistId = $input['artist_id'];
        $authId = User::getLoggedInId();
        $msg='';
        $artistDetail = ArtistDetail::where('user_id',$artistId)->first();
        if ($artistDetail) {
            $artistLikeData = FanFavouriteArtists::where('artist_id',$artistId)->where('fan_id',$authId)->first();
            if(empty($artistLikeData)){
                $artistDetail->num_likes = ($artistDetail->num_likes!=NULL)?$artistDetail->num_likes+1:1;
                $artistDetail->save();
                FanFavouriteArtists::create([
                    "artist_id"=>$artistId,
                    "fan_id"=>$authId
                ]);
                $msg=Artist::getNameById($artistId)." added to favourites";
            }
            else{
                $artistDetail->num_likes = ($artistDetail->num_likes!=NULL)?$artistDetail->num_likes-1:0;
                $artistDetail->save();
                FanFavouriteArtists::where('artist_id',$artistId)->where("fan_id",$authId)->delete();;
                $msg=Artist::getNameById($artistId)." removed from favourites";
            }
        }
        $artistDetail = ArtistDetail::where('user_id',$artistId)->first();
        return $this->sendResponse([], $msg);
    }

    // By Dilpesh 17-11-2021
    public function SongsIncreaseLike(Request $request)
    {
        $input = $request->all();
        $songId = $input['song_id'];
        $authId = User::getLoggedInId();
        $msg='';
        $songDetail = Songs::where('id',$songId)->first();
        if ($songDetail) {
            $artistLikeData = FanFavouriteSongs::where('song_id',$songId)->where('fan_id',$authId)->first();
            if(empty($artistLikeData)){
                $songDetail->num_likes = ($songDetail->num_likes!=NULL)?$songDetail->num_likes+1:1;
                $songDetail->save();
                FanFavouriteSongs::create([
                    "song_id"=>$songId,
                    "fan_id"=>$authId
                ]);
                $msg=$songDetail->name." added to favourites";
            }
            else{
                $songDetail->num_likes = ($songDetail->num_likes!=NULL)?$songDetail->num_likes-1:0;
                $songDetail->save();
                FanFavouriteSongs::where('song_id',$songId)->where("fan_id",$authId)->delete();;
                $msg=$songDetail->name." removed from favourites";
            }
        }
        // $songDetail = Songs::where('id',$songId)->first();
        return $this->sendResponse([], $msg);
    }

    public function GroupIncreaseLike(Request $request)
    {
        $input = $request->all();
        $songId = $input['group_id'];
        $authId = User::getLoggedInId();
        $msg='';
        $groupDetail = DynamicGroups::where('id',$songId)->first();
        if ($groupDetail) {
            $artistLikeData = FanFavouriteGroups::where('group_id',$songId)->where('fan_id',$authId)->first();
            if(empty($artistLikeData)){
                // $groupDetail->num_likes = ($groupDetail->num_likes!=NULL)?$groupDetail->num_likes+1:1;
                // $groupDetail->save();
                FanFavouriteGroups::create([
                    "group_id"=>$songId,
                    "fan_id"=>$authId
                ]);
                $msg=$groupDetail->name." added to favourites";
            }
            else{
                // $groupDetail->num_likes = ($groupDetail->num_likes!=NULL)?$groupDetail->num_likes-1:0;
                // $groupDetail->save();
                FanFavouriteGroups::where('group_id',$songId)->where("fan_id",$authId)->delete();;
                $msg=$groupDetail->name." removed from favourites";
            }
        }
        return $this->sendResponse([], $msg);
    }

    public function ArtistsReviewList(Request $request)
    {
        $input = $request->all();
        $artistId = $input['artist_id'];
        $page = isset($input['page']) ? $input['page'] : 1;
        $data = Reviews::getReviewsListByArtist($artistId,$page);
        $component = [
            "componentId" => "reviewList",
            "sequenceId" => "1",
            "isActive" => "1",
            "pageSize" => $data['limit'],
            "pageNo" => (string) $data['page'],
            "reviewData" => $data['data'],
        ];
        return $this->sendResponse($component, 'Reviews Listed Successfully.');
    }


    public function detail()
    {
        $authId = User::getLoggedInId();
        $data = Artist::getDetailApi($authId);
        $return = [
            "componentId"=> "profile",
            "sequenceId"=> "1",
            "isActive"=> "1",
            "profileData"=>$data
        ];
        return $this->sendResponse($return, 'your profile retrived successfully.');
    }

    public function update(Request $request)
    {
        $input = $request->all();
        $authId = User::getLoggedInId();
        if($request->hasFile('profile_pic')) {
            //$fileObject = $request->file('profile_pic');
            //UserProfilePhoto::uploadAndSaveProfilePhoto($fileObject,$authId);
            if (isset($input['hiddenPreviewImg'])) {
                $fileObject = $request->file('profile_pic');
                UserProfilePhoto::uploadAndSaveProfileViaCropped($fileObject,$authId,$input);
                unset($input['hiddenPreviewImg']);
            }else{
                $fileObject = $request->file('profile_pic');
                UserProfilePhoto::uploadAndSaveProfilePhoto($fileObject, $authId);
            }
        }else{
            if (isset($input['imageEncoded'])) {
                UserProfilePhoto::uploadAndSaveProfilePhotoApi($input['imageEncoded'],$authId);
                unset($input['imageEncoded']);
            }
        }
        $data = Artist::updateExist($input);
        if($data['success']) {
            return $this->sendResponse([], 'Your profile details has been updated successfully.');
        }else{
            return $this->sendError($data['data'], 'Something went wrong.');
        }
    }

    public function getProfile(){
        $authId = User::getLoggedInId();
        $artistDetail = ArtistDetail::getArtistDetail($authId);
        $artist = Artist::find($authId);
        $interest = Interest::getInteres($artistDetail->interest);
        $return = [
            "componentId"=> "artistProfile",
            "sequenceId"=> "1",
            "isActive"=> "1",
            "artistProfileData"=>[
                "artistName"=> $artist->firstname.' '.$artist->lastname,
                "artistPhoto"=> UserProfilePhoto::getProfilePhoto($authId),
                "numLikes"=> $artistDetail->num_likes,
                "numSoungs"=> Songs::getCountByArtist($authId),
                "about"=> $artistDetail->bio,
                "news"=> $artistDetail->news_detail,
                "interest"=> $interest,
                "collection"=> '',
                "events"=> '',
            ]
        ];

        return $this->sendResponse($return, 'Artist Profile retrived successfully.');
    }

    public function updateDetails(Request $request)
    {
        $input = $request->all();
        $data = ArtistDetail::updateExist($input);
        if($data['success']) {
            return $this->sendResponse([], 'Your profile details has been updated successfully.');
        }else{
            return $this->sendError($data['data'], 'Something went wrong.');
        }

    }
    public function getEventListByArtist($id)
    {
        $artistData = ArtistEvents::getListByArtistId($id);
        $component =[
            "componentId" => "artistEvents",
            "sequenceId" => "1",
            "isActive" => "1",
            "artistEventData" => $artistData,
        ];
        return $this->sendResponse($component, 'Artist Detailed successfully.');
    }

    public function dashboard()
    {
        $authId = User::getLoggedInId();
        $data = Artist::getDashboardApi($authId);
        // pre($data);

        $artistComponent = [
            "componentId"=> "artistComponent",
            "sequenceId"=> "1",
            "isActive"=> "1",
            "artistComponentData"=> [
                "id"=> "1",
                "image"=> $data['profilePic'],
                "title"=> "Welcome ".$data['firstname']."!",
                "name"=> $data['name']
            ]
        ];

        $artistAnalystics = [
            "componentId"=> "artistAnalystics",
            "sequenceId"=> "1",
            "isActive"=> "1",
            "artistAnalysticsData"=> [
                "title"=> "Check out your analytics below",
                "progress"=> $data['profileCompleted'],
                "progressText"=> $data['profileCompleted']."%",
                "progressDesc"=> "Achieve more milestones to complete your profile.",
                "image"=> "http://localhost/php/clubfan/public/assets/frontend/img/placeholder/placeholder.jpg",
                "list"=> $data['milestones']

            ]
        ];

        $artistSubscription = [
            "componentId"=> "artistSubscription",
            "sequenceId"=> "1",
            "isActive"=> "1",
            "artistSubscriptionData"=> [
                "list" => [
                    [
                            "id"=> "1",
                            "title"=> "Monthly Active Subscriptions",
                            "count"=> $data['monthlyActSubs']
                    ],
                    [
                            "id"=> "2",
                            "title"=> "Annual Active Subscriptions",
                            "count"=> $data['yearlyActSubs']
                    ]
                ]

            ]
        ];

        $songsStatus = [
            "componentId"=> "songsStatus",
            "sequenceId"=> "1",
            "isActive"=> "1",
            "songsStatusData"=> [
                "likeText"=> "Likes",
                "likeCount"=> $data['numLikes'],
                "songText"=> "Songs",
                "songCount"=> $data['numSongs']

            ]
        ];

        $songsSlider1 = [
            "componentId"=> "songsSlider",
            "sequenceId"=> "1",
            "isActive"=> "1",
            "songsSliderData"=> [
                "title"=> "Recent Uploads",
                "list"=> $data['recentSongs']

            ]
        ];

        $songsSlider2 = [
            "componentId"=> "songsSlider",
            "sequenceId"=> "1",
            "isActive"=> "1",
            "songsSliderData"=> [
                "title"=> "My Top 5",
                "list"=> $data['topFiveSongs']

            ]
        ];

        $return = [
            $artistComponent,
            $artistAnalystics,
            $artistSubscription,
            $songsStatus,
            $songsSlider1,
            $songsSlider2
        ];

        // $return = [
        //     "componentId"=> "dashboard",
        //     "sequenceId"=> "1",
        //     "isActive"=> "1",
        //     "dashboardData"=>$data
        // ];
        // pre($return);
        return $this->sendResponse($return, 'your profile retrived successfully.');
    }
    public function getSongDetail($request)
    {

    }

    public function allArtists($search='')
    {
        //patch by nivedita for search page see all//
        if(!empty($search))
        $search=$search;
        else
        $search='';
        //patch by nivedita for search page see all//
        $artistdata = Artist::getallArtistsListApi($search);
        $return = [
            "componentId"=> "artistList",
            "sequenceId"=> "3",
            "isActive"=> "1",
            "artistData"=>$artistdata
        ];
        return $this->sendResponse($return, 'artist data retrived successfully.');
    }

    public function myArtists($search)
    {
        $authId = User::getLoggedInId();
        $return = [
            "componentId" => "favArtist",
            "title" => "Favorite Artist",
            "sequenceId" => "1",
            "isActive" => "1",
            "artistData" => FanFavouriteArtists::getListApi($authId, 10,$search),
          ];
        return $this->sendResponse($return, 'artist data retrived successfully.');
    }

    public function getArtistsByDynamicGroup($id)
    {
        $artistdata = Artist::getArtistsByDynamicGroup($id);
        $return = [
            "componentId"=> "allArtist",
            "sequenceId"=> "1",
            "isActive"=> "1",
            "artistData"=>$artistdata
        ];
        return $this->sendResponse($return, 'artist data retrived successfully.');
    }

}
