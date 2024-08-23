<?php

use App\Http\Controllers\API\V1\ArtistAPIController;
use App\Http\Controllers\API\V1\ForumAPIController;
use App\Http\Controllers\API\V1\MusicCategoryAPIController;
use App\Http\Controllers\API\V1\MusicGenreAPIController;
use App\Http\Controllers\API\V1\MusicLanguageAPIController;
use App\Http\Controllers\API\V1\SongAPIController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\API\V1\AuthAPIController;
use App\Http\Controllers\API\V1\ReviewAPIController;
use App\Http\Controllers\API\V1\InquiriesAPIController;
use App\Http\Controllers\API\V1\BlogsAPIController;
use App\Http\Controllers\API\V1\PagesAPIController;
use App\Http\Controllers\API\V1\LocationAPIController;
use App\Http\Controllers\API\V1\SearchAPIController;
use App\Http\Controllers\API\V1\FanAPIController;
use App\Http\Controllers\API\V1\FanClubPlaylistController;
use App\Http\Controllers\API\V1\HomePageAPIController;

use App\Http\Controllers\API\V1\ContactUsAPIController;
use App\Http\Controllers\API\V1\FaqAPIController;
use App\Http\Controllers\API\V1\ArtistEventAPIController;
use App\Http\Controllers\API\V1\CountryAPIController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

// Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//     return $request->user();
// });
Route::group(['prefix' => 'v1'], function () {
	Route::post('register', [AuthAPIController::class, 'register']);
    Route::post('login', [AuthAPIController::class,'login']);
    Route::post('verify-user', [AuthAPIController::class,'verifyUser']);
    Route::post('forgot-password', [AuthAPIController::class,'forgotPassword']);
    Route::post('verify-otp', [AuthAPIController::class,'verifyOTP']);
    Route::post('send-otp', [AuthAPIController::class,'resendOTP']);
    Route::post('reset-password', [AuthAPIController::class,'resetPassword']);
    Route::post('login-with-otp', [AuthAPIController::class,'LoginWithOTP']);

    // FAN STEPS
    Route::get('register/fan/{step}', [AuthAPIController::class, 'signupFan']);
    Route::get('register/artist', [AuthAPIController::class, 'signupArtist']);
    Route::post('register/fan/second', [AuthAPIController::class, 'secondStepFan']);
    Route::post('register/fan/third', [AuthAPIController::class, 'thirdStepFan']);

    // Blog API
    Route::get('country/list', [PagesAPIController::class,'countryList']);
    Route::get('state/list', [PagesAPIController::class,'stateList']);

    // Blog API
    Route::get('blog/list/{limit?}/{blogCategory?}', [BlogsAPIController::class,'index']);
    Route::get('blog/recent', [BlogsAPIController::class,'recentBlogs']);
    Route::get('blog/detail/{id}', [BlogsAPIController::class,'blogDetail']);

    // homepage API
    Route::post('pages/homepage', [PagesAPIController::class,'homePageComponent']);

    // Blog Category API
    Route::get('blog-categories/list', [BlogsAPIController::class,'blogCategories']);

    // Route::get('account/list', [AuthAPIController::class,'getAccountLists']);

    // forum API
    Route::any('forums/list',[ForumAPIController::class,'index']);
    Route::any('forum-detail/{id}',[ForumAPIController::class,'commentIndex']);


    
    //Route::post('forum-create',[ForumAPIController::class,'createNewTopic']);
    //Route::any('forum-detail/{id?}',[ForumAPIController::class,'detailIndex']);

    // Artist API
    Route::get('artist-detail/{id}',[ArtistAPIController::class,'index']);
	Route::post('artist-likedislike',[ArtistAPIController::class,'ArtistsIncreaseLike']);
	Route::post('artist-reviews-list',[ArtistAPIController::class,'ArtistsReviewList']);

    // Search API
    Route::post('search',[SearchAPIController::class,'search']);

    // Setting Key and value
    Route::post('setting', [AuthAPIController::class,'getSetting']);

    // Songs Detail
    Route::post('song/create',[SongAPIController::class,'SongCreate']);
    Route::get('song/detail/{id}',[SongAPIController::class,'SongsDetails']);

    // Music Management
    Route::get('music-category/list',[MusicCategoryAPIController::class,'index']);
    Route::get('music-genre/list',[MusicGenreAPIController::class,'index']);
    Route::get('music-language/list',[MusicLanguageAPIController::class,'index']);


    // Contact Us API
    Route::post('contact-us', [ContactUsAPIController::class,'create']);
    Route::get('faq', [FaqAPIController::class,'index']);

    Route::get('countries', [CountryAPIController::class,'index'])->name('getCountries');
    Route::get('home-page-components', [HomePageAPIController::class,'homePageData']);
    Route::get('variables', [PagesAPIController::class,'variableList'])->name('variableList');
});

Route::group(['prefix' => 'v1' , 'middleware'=>'auth:api'], function () {
    // Auth API
    Route::post('register-professional', [AuthAPIController::class,'RegisterAsProfessional']);
    Route::post('change-password', [AuthAPIController::class,'changePassword']);
    Route::get('fetch-profile', [AuthAPIController::class,'fetchProfile']);
    Route::post('update-profile', [AuthAPIController::class,'updateProfile']);
    Route::post('logout', [AuthAPIController::class,'logout']);


    // List all Account Menu

    // Review API
    /* Route::get('reviews/list', [ReviewAPIController::class,'index']);
    Route::post('reviews/add', [ReviewAPIController::class,'create']); */
    Route::get('reviews/song/{id}', [ReviewAPIController::class,'indexReviewSongs']);
    Route::get('reviews/artist/{id}', [ReviewAPIController::class,'indexReviewArtists']);
    Route::post('reviews/add', [ReviewAPIController::class,'create']);
    Route::post('reviews/delete', [ReviewAPIController::class,'deleteReview']);
    Route::get('reviews/edit/{id}', [ReviewAPIController::class,'editReview']);
    Route::get('reviews/my-reviews', [ReviewAPIController::class,'index']);
    Route::get('reviews/song-list', [ReviewAPIController::class,'getListOfAllReviews']);


	// Artist Events API
    Route::get('artist-event/list', [ArtistEventAPIController::class,'index']);
    Route::post('artist-event/add', [ArtistEventAPIController::class,'create']);
	Route::post('artist-event/edit', [ArtistEventAPIController::class,'update']);
	Route::post('artist-event/delete', [ArtistEventAPIController::class,'delete']);



    // Inquiry API
    Route::get('inquiries/list', [InquiriesAPIController::class,'index']);
    Route::post('inquiries/add', [InquiriesAPIController::class,'create']);

    // Blog Comment API
    Route::post('blog-comment/add', [BlogsAPIController::class,'addComments']);

    // User Posts API
    Route::post('user-posts/add', [UserPostsAPIController::class,'create']);
    Route::post('user-posts/toggle_like', [UserPostsAPIController::class,'addLikes']);
    Route::post('filtered-songs', [SongAPIController::class,'filteredList']);


    // Artist
    Route::get('artist-profile', [ArtistAPIController::class,'detail']);
    // Route::get('artist-profile-detail', [ArtistAPIController::class,'getProfile']);
    // Route::post('artist-profile-detail', [ArtistAPIController::class,'updateDetails']);
    Route::post('artist-profile', [ArtistAPIController::class,'update']);
    Route::get('artist-dashboard', [ArtistAPIController::class,'dashboard']);

    // Fan & It's Playlist & It's favourite songs & It's favourite artist
    Route::get('fan-profile', [FanAPIController::class,'detail']);
    Route::post('fan-profile', [FanAPIController::class,'update']);
    Route::get('fan-playlist', [FanAPIController::class,'playlistindex']);
    Route::post('fan-playlist-with-song/create', [FanAPIController::class,'playlistCreateSongAdd']);
    Route::post('fan-playlist-songs/insert', [FanAPIController::class,'playlistSongAdd']);
    Route::get('fan-playlist-songs/remove/{id}', [FanAPIController::class,'playlistSongRemove']);
    Route::get('fan-playlist-songs/{id}', [FanAPIController::class,'playlistsongs']);
    Route::get('fan-favourite-songs', [FanAPIController::class,'favouriteSongs']);
    Route::post('fan-favourite-song-action', [FanAPIController::class,'favouriteSongAction']);

    Route::get('fan-favourite-artists', [FanAPIController::class,'favouriteArtists']);
    Route::post('fan-favourite-artist-action', [FanAPIController::class,'favouriteArtistAction']);

    // My Music
    Route::get('my-music', [SongAPIController::class,'myMusic']);

    // Songs List
    Route::post('filtered-songs', [SongAPIController::class,'filteredList']);

		// Artist List
    Route::get('/all-artists/{search?}', [ArtistAPIController::class, 'allArtists']);

    // Fan & It's Playlist & It's favourite songs & It's favourite artist
    Route::post('add-song-view', [SongAPIController::class,'SongsIncreaseView']);
    Route::post('add-artist-view', [ArtistAPIController::class,'ArtistsIncreaseView']);

	// Fan club plalists
    Route::get('fanclub-playlists-details/{id}', [FanClubPlaylistController::class,'detail']);
	  Route::get('fanclub-playlists', [FanClubPlaylistController::class,'playlistindex']);

	// Home Page Components
	Route::post('view-all', [HomePageAPIController::class,'getViewAll']);

    //Forum
    Route::post('forum-create',[ForumAPIController::class,'createTopic']);
    Route::post('forum-comment-create',[ForumAPIController::class,'createCommentMain']);
    Route::post('forum-likedislike',[ForumAPIController::class,'ForumIncreaseLike']);
    Route::post('forum-likedislike-comment',[ForumAPIController::class,'ForumCommentIncreaseLike']);
});
