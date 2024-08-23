<?php

namespace App\Http\Controllers\API\V1;

use Illuminate\Http\Request;
use App\Http\Controllers\API\BaseController as BaseController;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
// use App\Models\Blogs;
use App\Models\UserProfilePhoto;
use App\Models\UserCoverPhoto;
use App\Models\ProductCategories;
use App\Models\ProfessionalCategories;
use App\Models\LocationGroup;
use App\Models\UserCategoryPhoto;
use App\Models\UserLocationPhoto;
use App\Models\UserPortfolio;
use App\Models\Professionals;
use App\Models\Products;
use App\Models\Reviews;
use App\Models\User;
use Validator;
use Mail;
use Hash;

class ProfessionalAPIController extends BaseController
{

	public function index(Request $request)
    {
        $component = [];
        $page = ($request->page)?:1;
        $areaName = $request->area_name;
        $category_id = isset($request->category_id)?$request->category_id:'';
        
        // $categories = ProductCategories::getList();
        $categories = ProfessionalCategories::getList();
        // categoryComp
        $categoryComp = [
            'componentId'=>'category',
            'categoryData'=>[
                'title'=>'',
                'list'=>$categories,
            ]
        ];
        $component[] = $categoryComp;

        $locationGroupId = LocationGroup::getGroupByArea($areaName);
        $page = ($request->page)?:1;
        if ($category_id) {
            $locationAllocationSlot = LocationGroup::getCatAllocationSlot($locationGroupId,$category_id,$page);
        }else{
            $locationAllocationSlot = LocationGroup::getAllocationSlot($locationGroupId,$page);
        }
        
        foreach($locationAllocationSlot as $k => $v)
        {
            $getProfessionalData = Professionals::getProfessionalData($v['ad_hero']);
            $categoryPhoto = UserCategoryPhoto::getCategoryPhoto($v['ad_hero']);
            // profileComponent
            $profileComponent = [
                'componentId' => 'profileComponent',
                "imageHeight" => "546",
                "imageWidth" => "1077",
                // "imageHeight" => config('app.userCategoryHero.height'),
                // "imageWidth" => config('app.userCategoryHero.width'),
                'profileComponentData' => [
                    'title' => 'Squrespaces',
                    'list' => [
                        [
                            'id' => $v['ad_hero'], 
                            'isVerify' => User::GetVerifiedTick($v['ad_hero']), 
                            'title' => User::getUserOrCompName($v['ad_hero']),
                            'subTitle' => $getProfessionalData['about'], 
                            'image' => $categoryPhoto,
                            'profilePic' => UserProfilePhoto::getProfilePhoto($v['ad_hero']),
                        ],
                    ],
                ]
            ];

            $getProfessionalDataLocationHero1 = Professionals::getProfessionalData($v['location_hero_1']);
            $locationPhotoLocationHero1 = UserLocationPhoto::getLocationPhoto($v['location_hero_1']);

            $getProfessionalDataLocationHero2 = Professionals::getProfessionalData($v['location_hero_2']);
            $locationPhotoLocationHero2 = UserLocationPhoto::getLocationPhoto($v['location_hero_2']);

            $getProfessionalDataLocationHero3 = Professionals::getProfessionalData($v['location_hero_3']);
            $locationPhotoLocationHero3 = UserLocationPhoto::getLocationPhoto($v['location_hero_3']);

            $getProfessionalDataLocationHero4 = Professionals::getProfessionalData($v['location_hero_4']);
            $locationPhotoLocationHero4 = UserLocationPhoto::getLocationPhoto($v['location_hero_4']);

            // verticalSliderComponent
            $verticalSliderComponent = [
                'componentId' => 'verticalSliderComponent',
                'verticalSliderComponentData' => [
                    'title' => '',
                    // "imageHeight" => config('app.userLocationHero.height'),
                    // "imageWidth" => config('app.userLocationHero.width'),
                    'list' => [
                        [
                            'id' => $v['location_hero_1'], 
                            'isVerify' => User::GetVerifiedTick($v['location_hero_1']), 
                            'title' => User::getUserOrCompName($v['location_hero_1']),
                            'subTitle' => $getProfessionalDataLocationHero1['about'], 
                            'image' => $locationPhotoLocationHero1, 
                            "type" => "1",
                            'profilePic' => UserProfilePhoto::getProfilePhoto($v['location_hero_1']),
                        ],
                        [
                            'id' => $v['location_hero_2'], 
                            'isVerify' => User::GetVerifiedTick($v['location_hero_2']), 
                            'title' => User::getUserOrCompName($v['location_hero_2']),
                            'subTitle' => $getProfessionalDataLocationHero2['about'], 
                            'image' => $locationPhotoLocationHero2, 
                            "type" => "1",
                            'profilePic' => UserProfilePhoto::getProfilePhoto($v['location_hero_2']),
                        ],
                        [
                            'id' => $v['location_hero_3'], 
                            'isVerify' => User::GetVerifiedTick($v['location_hero_3']), 
                            'title' => User::getUserOrCompName($v['location_hero_3']),
                            'subTitle' => $getProfessionalDataLocationHero3['about'], 
                            'image' => $locationPhotoLocationHero3, 
                            "type" => "1",
                            'profilePic' => UserProfilePhoto::getProfilePhoto($v['location_hero_3']),
                        ],
                        [
                            'id' => $v['location_hero_4'], 
                            'isVerify' => User::GetVerifiedTick($v['location_hero_4']), 
                            'title' => User::getUserOrCompName($v['location_hero_4']),
                            'subTitle' => $getProfessionalDataLocationHero4['about'], 
                            'image' => $locationPhotoLocationHero4, 
                            "type" => "1",
                            'profilePic' => UserProfilePhoto::getProfilePhoto($v['location_hero_4']),
                        ],
                    ],
                ],
            ];
            $component[] = $profileComponent;
            $component[] = $verticalSliderComponent;
        }
        return $this->sendResponse($component, 'Professionals listed successfully.');
    }

    public function professionalProfile($id)
    {
        $user = User::find($id);
        if ($user) {
            $professional = Professionals::getProfessionalData($id);
            if ($user->is_professional && $professional && $professional['status']) {
                $usrProfPhoto = UserProfilePhoto::getProfilePhoto($id);
                $usrCoverPhoto = UserCoverPhoto::getCoverPhoto($id);
                $professionalReviewsAvg = Reviews::reviewAvgAndCountByProfessional($id);
                $professionalReviews = Reviews::professionalProductsReviewList($id);
                $relatedProducts = Products::getRelatedProductsByUsers($id);
                $portfolio = UserPortfolio::getFile($id);
                $profileName = User::getUserOrCompName($id);
                $data = [
                    [
                        "componentId"=>"profileImage",
                        "profileImageData"=>[
                            "imageWidth"=> (String)config('app.userImageDimention.width'),
                            "imageHeight"=> (String)config('app.userImageDimention.height'),
                            "coverImageWidth"=> (String)config('app.userCoverDimention.width'),
                            "coverImageHeight"=> (String)config('app.userCoverDimention.height'),
                            "image"=>$usrCoverPhoto,
                            "profileImg"=>$usrProfPhoto
                        ]
                    ],
                    [
                        "componentId"=>"profileDetailsComponent",
                        "shareURL"=>route('professional.details',$id),
                        "profileDetailsComponentData"=>[
                            "profileName"=>$profileName,
                            "profileId"=>$id,
                            "subTitleText"=>"",
                            "categoryTitle"=>"Category",
                            "designsTitle"=>"Designs",
                            "isSubscribed"=>$professional['is_subscribed'],
                            "portfolio"=>$portfolio,
                            "companyName"=>$professional['company_name'],
                            "about"=>$professional['about']?:"",
                            "workExp"=>$professional['work_exp']?:"",
                            "team_members"=>$professional['team_members']?:"",
                            "categorylist"=>$professional['categorylist'],
                            "designsImagelist"=>$professional['designsImagelist'],
                            "technicalSkillsList"=>$professional['technicalSkillsList'],
                        ]
                    ],
                    [
                        "componentId"=>"review",
                        "addReviewFlag"=>"1",
                        "showAllReviewFlag"=>($professionalReviewsAvg['avg_reviews']!=null)?"1":"0",
                        "reviewData"=>[
                            "rating"=>($professionalReviewsAvg['avg_reviews']!=null)?number_format($professionalReviewsAvg['avg_reviews'],1):"0",
                            "list"=>$professionalReviews,
                        ]
                    ],
                    [
                        "componentId"=>"productListComponent",
                        "productListComponentData"=>[
                            "title"=>"Related Products",
                            "list"=>$relatedProducts,
                        ]
                    ],
                ];
                return $this->sendResponse($data, 'Profile Data fetched successfully.');
            }else{
                return $this->sendError(['User is not a professional'], ['error'=>'User is not a professional.'],300);
            }
        }else{
            return $this->sendError(['User not found'], ['error'=>'User not found.'],300);
        }
    }

    public function seeMore(Request $request)
    {
        $limit = 24;
        $page = $request->page?:1;
        $filter = $request->all();
        $filter['only_other_professionals'] = 1;
        $professionals = Professionals::getByFilter($filter, $page, $limit);
        $list = [];
        foreach ($professionals as $key => $p) {
           $list[] = [
                'id' => $p->user_id, 
                'isVerify' => User::GetVerifiedTick($p->user_id), 
                'title' => User::getUserOrCompName($p->user_id), 
                'subTitle' => $p->about, 
                'image' => UserLocationPhoto::getLocationPhoto($p->user_id),
                'profilePic' => UserProfilePhoto::getProfilePhoto($p->user_id),
            ];
        }
        $response[] = [
            "componentId"=>"verticalSliderComponent",
            "verticalSliderComponentData"=>[
                "title"=>"",
                "imageHeight" => config('app.userImageDimention.height'),
                "imageWidth" => config('app.userImageDimention.width'),
                "list"=>$list
            ]
        ];
        return $this->sendResponse($response, 'Professionals listed successfully.');
    }

    public function professionalCategories(Request $request)
    {
        $data = ProfessionalCategories::getList();
        return $this->sendResponse($data, 'Professional Categories listed successfully.');
    }

}