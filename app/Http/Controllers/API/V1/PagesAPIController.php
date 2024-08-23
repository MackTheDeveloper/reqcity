<?php

namespace App\Http\Controllers\API\V1;

use Illuminate\Http\Request;
use App\Http\Controllers\API\BaseController as BaseController;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
// use App\Models\Blogs;
use Validator;
use Mail;
use Hash;
use App\Models\ProductCategories;
use App\Models\ProfessionalCategories;
use App\Models\LocationGroup;
use App\Models\Professionals;
use App\Models\User;
use App\Models\Country;
use App\Models\States;
use App\Models\UserCategoryPhoto;
use App\Models\UserLocationPhoto;
use App\Models\Products;
use App\Models\Variables;
use App\Models\UserProfilePhoto;
use Illuminate\Support\Facades\Session;

class PagesAPIController extends BaseController
{

	public function homePageComponent(Request $request){
        $component = [];
        // $baseUrl = 'http://103.129.98.170/kavalani/Images/BoxComponent/';
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

        // $defaultLocation = $request->defaultLocation;
        $areaName = $request->area_name;
        $city = (isset($request->city))?$request->city:'';
        $locationGroupId = LocationGroup::getGroupByArea($areaName,$city);
        $locationAllocationSlot = LocationGroup::getAllocationSlot($locationGroupId,1);
        // pre($locationAllocationSlot);
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

        // productComponent
        $params = [
            "locationGroupId"  => $locationGroupId,
        ];
        $productList = Products::getListForHomePageSecondLogic($params);
        $productComponent = [
            'componentId' => 'productComponent',
            'productComponentData' => [
                'title' => '',
                'list' => $productList,
            ]
        ];
        $component[] = $productComponent;
        return $this->sendResponse($component, 'Home Component retrived successfully.');
    }

    public function countryList(){
        $countries = Country::getListForDropdown();
        $component = [
            "componentId" => "country",
            "sequenceId" => "1",
            "isActive" => "1",
            "countryData" => ['list'=>$countries],
        ];
        return $this->sendResponse($component, 'Countries Listed Successfully.');
    }

    public function stateList(){
        $states = States::getListForDropdown();
        $component = [
            "componentId" => "states",
            "sequenceId" => "1",
            "isActive" => "1",
            "statesData" => ['list'=>$states],
        ];
        return $this->sendResponse($component, 'States Listed Successfully.');
    }


    public function variableList(){
        $variables = Variables::getVariables();
        return $this->sendResponse($variables, 'Variables Listed Successfully.');
    }

}