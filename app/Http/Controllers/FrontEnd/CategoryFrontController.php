<?php

namespace App\Http\Controllers\FrontEnd;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
// use Illuminate\Support\Facades\Hash;
// use Illuminate\Support\Str;
use App\Models\User;
use App\Models\Category;
use App\Models\CmsPages;
use App\Http\Controllers\API\V1\ContactUsAPIController;
use Exception;
use Auth;
use Mail;
// use Illuminate\Support\Facades\Session;

class CategoryFrontController extends Controller
{
  public function index(){
    $categoryList=Category::getCategoryList();
    return view('frontend.category.index',compact('categoryList'));
  }

  public function showDetails($slug){
    return redirect()->route('home');
  }
}
