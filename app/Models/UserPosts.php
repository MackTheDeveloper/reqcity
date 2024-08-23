<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use Google\Cloud\Vision\V1\ImageAnnotatorClient;

class UserPosts extends Model
{
    use SoftDeletes;

    protected $table = 'user_posts';
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'user_id', 'post_type', 'image', 'caption_text', 'category_id'
    ];

    public function getImageAttribute($image)
    {
        $return = "";
        $path = public_path() . '/assets/images/user_posts/' . $image;
        if (file_exists($path)) {
            $return = url('/public/assets/images/user_posts/' . $image);
        }
        return $return;
    }


    public static function getList($userId = 0, $page = 1, $search = "")
    {
        $posts = UserPosts::selectRaw('user_posts.caption_text, user_posts.user_id, user_posts.id,  user_posts.post_type, user_posts.image, product_categories.name as prodCat')
            ->leftjoin('users', 'users.id', 'user_posts.user_id')
            ->leftjoin('product_categories', 'product_categories.id', 'user_posts.category_id')
            ->whereNotNull('users.id')
            ->orderBy('user_posts.created_at', 'desc');
        if ($search) {
            $posts->where(function ($query) use ($search) {
                $query->where('users.firstname', 'like', '%' . $search . '%')
                    ->orWhere('users.lastname', 'like', '%' . $search . '%')
                    ->orWhere('users.handle', 'like', '%' . $search . '%')
                    ->orWhere('product_categories.name', 'like', '%' . $search . '%')
                    ->orWhere('user_posts.caption_text', 'like', '%' . $search . '%');
            });
        }
        if ($page) {
            $limit = 10;
            $offset = ($page - 1) * $limit;
            $posts->offset($offset);
            $posts->limit($limit);
        }
        $posts = $posts->get()->toArray();
        foreach ($posts as $key => $value) {
            if ($userId) {
                $posts[$key]['liked'] = UserPostsLike::userHasLiked($userId, $value['id']);
                $posts[$key]['deletable'] = ($userId == $posts[$key]['user_id']) ? 1:0;
            } else {
                $posts[$key]['liked'] = 0;
                $posts[$key]['deletable'] = 0;
            }
            
        }
        $posts = self::formatReviewList($posts);
        $return = ['posts' => $posts, 'page' => $page];
        return $return;
    }

    public static function uploadPostImage($fileObject)
    {
        $photo = $fileObject;
        $ext = $fileObject->extension();
        $filename = rand() . '_' . time() . '.' . $ext;
        $photo->move(public_path() . '/assets/images/user_posts/', $filename);
        return $filename;
    }

    public static function addNew($data)
    {
        $return = '';
        $success = true;
        try {
            $create = new UserPosts();
            foreach ($data as $key => $value) {
                $create->$key = $value;
            }
            $create->save();
            $return = $create;
        } catch (\Exception $e) {
            $return = $e->getMessage();
            $success = false;
        }
        return ['data' => $return, 'success' => $success];
    }


    public static function formatReviewList($data)
    {
        $return = [];
        foreach ($data as $key => $value) {
            $return[] = [
                "id" => $value['id'],
                // "title" => $value['user_name'],
                "title" => User::getUserOrCompName($value['user_id']),
                "isVerify" => User::GetVerifiedTick($value['user_id']),
                "profilePic" => UserProfilePhoto::getProfilePhoto($value['user_id']),
                "post" => $value['caption_text'],
                "image" => $value['image'],
                "category" => $value['prodCat'],
                "isWishlist" => $value['liked'],
                "isDeletable" => $value['deletable'],
                "imageHeight" => (string) config('app.userPostImageDimention.width'),
                "imageWidth" => (string) config('app.userPostImageDimention.width'),
            ];
        }
        return $return;
    }

    public static function checkSafeImage($imageFullPath)
    {
        $imageAnnotator = new ImageAnnotatorClient();
        # annotate the image
        $image = file_get_contents($imageFullPath);
        $response = $imageAnnotator->safeSearchDetection($image);
        $safe = $response->getSafeSearchAnnotation();
        $adult = $safe->getAdult();
        $violence = $safe->getViolence();

        # names of likelihood from google.cloud.vision.enums
        $likelihoodName = ['UNKNOWN', 'VERY_UNLIKELY', 'UNLIKELY',
        'POSSIBLE', 'LIKELY', 'VERY_LIKELY'];
        $adult = $likelihoodName[$adult];
        $violence = $likelihoodName[$violence];

        /* pre("Adult :" . $adult,1);
        pre("Violance :" . $violence); */

        //$res = json_decode($safe);
        if ($adult == 'POSSIBLE' || $adult == 'LIKELY' || $adult == 'VERY_LIKELY' || $violence == 'POSSIBLE' || $violence == 'LIKELY' || $violence == 'VERY_LIKELY') {
            //return '1';
            return ['data' => 'Your image is inappropriate. Please upload another image.', 'success' => false];
        } else {
            //return '0';
            return ['data' => 'valid', 'success' => true];
        }
    }
}
