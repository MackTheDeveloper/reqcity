<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Jetstream\HasProfilePhoto;
use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Contracts\Auth\PasswordBroker;
use Hash;
use DB;
use Carbon\Carbon;
// use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasProfilePhoto;
    use Notifiable;
    use SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'unique_id', 'firstname', 'lastname','prefix', 'phone', 'email', 'password', 'user_type', 'ip_address', 'os_name', 'browser_name', 'browser_version', 'area', 'city', 'handle', 'design_preferences', 'current_home', 'future_stay', 'otp_at', 'otp', 'is_active', 'is_verify', 'is_subscribed', 'is_professional', 'alternate_phone_number', 'role_id', 'country', 'slug', 'step', 'state', 'registration_complete', 'stripe_customer_id', 'current_subscription', 'subscription_expire_at', 'current_subscription_id', 'has_yearly_subscription', 'is_subscription_cancelled', 'login_link'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
        'two_factor_recovery_codes',
        'two_factor_secret',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    // /**
    //  * The accessors to append to the model's array form.
    //  *
    //  * @var array
    //  */
    // protected $appends = [
    //     'profile_photo_url',
    // ];
    public function company()
    {
        return $this->hasOne(Companies::class, 'user_id', 'id');
    }
    public function companyUser()
    {
        return $this->hasOne(CompanyUser::class, 'user_id', 'id');
    }
    public function recruiter()
    {
        return $this->hasOne(Recruiter::class, 'user_id', 'id');
    }
    public function candidate()
    {
        return $this->hasOne(Candidate::class, 'user_id', 'id');
    }
    public function role()
    {
        return $this->hasOne(RoleUser::class, 'admin_id', 'id');
    }

    public function designs()
    {
        return $this->hasMany(UserDesign::class);
    }

    public static function getRoleById($id)
    {
        $return = "";
        $roles = [
            '2' => "Candidate Specialist",
            '3' => "Company",
            '4' => "Recruiter",
            '5' => "Candidate"
        ];
        if (isset($roles[$id])) {
            $return = $roles[$id];
        }
        return $return;
    }

    public function Reviews()
    {
        return $this->hasMany(Reviews::class, 'user_id', 'id');
    }

    public function currentSubscription()
    {
        return $this->hasOne(SubscriptionPlan::class, 'id', 'current_subscription');
    }

    public function permissions()
    {
        return $this->belongsToMany('App\Models\Permission');
    }

    public static function changePassword($request, $authId)
    {
        $user = User::find($authId);
        $password = Hash::make($request->password);
        if ($user && Hash::check($request->old_password, Auth::user()->password)) {
            $updateUser = User::where('id', $authId)->first();
            $updateUser->password = $password;
            $updateUser->save();
            // Auth::login($updateUser);
            return 1;
        } else {
            return 0;
        }
    }

    public static function getProfileData($id)
    {
        $user = User::find($id, ['firstname', 'lastname', 'phone', 'email', 'otp']);
        return ($user) ?: [];
    }

    public static function updateProfileData($data)
    {
        $return = '';
        $success = true;
        $phoneChange = false;
        $authId = Auth::user()->id;
        $allowed = ['firstname', 'lastname', 'phone', 'area', 'city', 'handle', 'design_preferences', 'current_home', 'future_stay'];
        $data = array_intersect_key($data, array_flip($allowed));
        $user = User::find($authId);
        if ($user) {
            // if (isset($data['handle']) && $user->is_professional=='0') {
            //     unset($data['handle']);
            // }
            try {
                foreach ($data as $key => $value) {
                    if ($key == 'phone') {
                        if ($user->$key != $value) {
                            $phoneChange = true;
                            $user->otp = self::generateOTP();
                            $user->otp_at = date('Y-m-d H:i:s');
                            $user->otp_expire_at = self::expireAtOTP();
                            $user->is_verify = '0';
                            self::sendOTP($user->id);
                        }
                    }
                    $user->$key = $value;
                }
                $user->save();
                $return = $user;
                $return->profile_photo_path = UserProfilePhoto::getProfilePhoto($authId);
                $return['phoneChange'] = $phoneChange;
            } catch (\Exception $e) {
                $return = $e->getMessage();
                $success = false;
            }
        }
        return ['data' => $return, 'success' => $success];
    }

    public function getFullNameAttribute()
    {
        return $this->firstname . ' ' . $this->lastname;
    }

    public static function generateOTP()
    {
        return rand(1000, 9999);
        // return 1234;
    }
    public static function expireAtOTP()
    {
        $mins = GlobalSettings::getSingleSettingVal('otp_validity_min');
        $mins = ($mins) ?: 15;
        $extra = "+" . $mins . " minute";
        $extra .= ($mins > 1) ? "s" : "";
        return date("Y-m-d h:i:s", strtotime($extra));
    }

    public static function sendOTP($id, $type = 'phone')
    {
        // if ($type=='phone') {
        //     try {
        //         $userData = self::getProfileData($id);
        //         $key = GlobalSettings::getSingleSettingVal('sms_api_key');

        //         // Account details
        //         $apiKey = urlencode($key);

        //         // To Get Sender Name
        //         $data = array('apikey' => $apiKey);
        //         $ch = curl_init('https://api.textlocal.in/get_sender_names/');
        //         curl_setopt($ch, CURLOPT_POST, true);
        //         curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
        //         curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        //         $response = curl_exec($ch);
        //         curl_close($ch);
        //         $result = json_decode($response);
        //         // pre($result);
        //         if (isset($result->default_sender_name)) {
        //             $senderName = $result->default_sender_name;
        //             // Message details
        //             $mins = GlobalSettings::getSingleSettingVal('otp_validity_min');
        //             $mins = ($mins)?:15;
        //             $extra = $mins." min";
        //             $extra.= ($mins>1)?"s":"";

        //             $numbers = array('91'.$userData->phone);
        //             $sender = urlencode($senderName);
        //             $message = rawurlencode($userData->otp.' is your One Time Password (OTP) for logging into the Decorato app. The OTP is valid for '.$extra.'. Do not share it with anyone.');
        //             // $message = rawurlencode('DECORATO : Your code is:'. $userData->otp);

        //             $numbers = implode(',', $numbers);

        //             // Prepare data for POST request
        //             $data = array('apikey' => $apiKey, 'numbers' => $numbers, "sender" => $sender, "message" => $message);

        //             // Send the POST request with cURL
        //             $ch = curl_init('https://api.textlocal.in/send/');
        //             curl_setopt($ch, CURLOPT_POST, true);
        //             curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
        //             curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        //             $response = curl_exec($ch);
        //             curl_close($ch);
        //             // pre($response);
        //             // Process your response here
        //             // echo $response;
        //         }
        //     } catch (Exception $e) {

        //     }
        //     return 1;
        // }else{

        try {
            $mins = GlobalSettings::getSingleSettingVal('otp_validity_min');
            $mins = ($mins) ?: 15;
            $extra = $mins . " min";
            $extra .= ($mins > 1) ? "s" : "";
            $userData = self::getProfileData($id);
            $data = ['FIRST_NAME' => $userData->firstname, 'LAST_NAME' => $userData->lastname, 'OTP' => $userData->otp, 'OTP_VALID' => $extra];
            EmailTemplates::sendMail('otp-for-verification', $data, $userData->email);
        } catch (Exception $e) { }

        return 1;
        // }
    }

    public static function verifyOTP($data, $empty = '')
    {
        $return = 0;
        $user = User::where('phone', $data['input'])->where('otp', $data['otp'])->where('user_type', 'frontend')->first();
        if ($user) {
            $user->is_verify = 1;
            $user->otp = '';
            if (!$empty) {
                $user->save();
            }
            $return = 1;
        } else {
            $user = User::where('email', $data['input'])->where('otp', $data['otp'])->where('user_type', 'frontend')->first();
            if ($user) {
                $user->is_verify = 1;
                $user->otp = '';
                if (!$empty) {
                    $user->save();
                }
                $return = 1;
            } else {
                $return = 0;
            }
        }
        return $return;
    }

    public static function verifyOTPNew($data, $empty = '')
    {
        $return = 0;
        // $user = User::where('phone',$data['input'])->where('user_type','frontend')->first();
        // if (!$user) {
        $user = User::where('email', $data['input'])->where('user_type', 'frontend')->where('is_active', 1)->first();
        // }
        if ($user) {
            if ($user->otp == $data['otp']) {
                $currentTime = strtotime(date('Y-m-d h:i:s'));
                $expireTime = strtotime($user->otp_expire_at);
                if ($expireTime >= $currentTime) {
                    $user->is_verify = 1;
                    $user->otp = '';
                    if (!$empty) {
                        $user->save();
                    }
                    $return = 1;
                } else {
                    $return = 3;
                }
            } else {
                $return = 2;
            }
        }
        return $return;
    }

    // public static function SocialLoginUser($data,$provider){
    //     $return = 0;
    //     $findSocial = UserSocialLogin::leftjoin('users','users.id','user_social_login.user_id')->where('provider',$provider)
    //         ->where('is_deleted',0)
    //         ->whereNull('deleted_at')
    //         ->where('social_id', $data['socialId'])->first();
    //     // pre($findSocial);
    //     if ($findSocial) {
    //         $return = $findSocial->user_id;
    //     }else{
    //         if ($data['email']) {
    //             $existUser = User::where('email',$data['email'])->first();
    //             if ($existUser) {
    //                 $newLogin = new UserSocialLogin;
    //                 $newLogin->user_id = $existUser->id;
    //                 $newLogin->provider = $provider;
    //                 $newLogin->social_id = $data['socialId'];
    //                 $newLogin->save();

    //                 $return = $existUser->id;
    //             }else{
    //                 // $name =
    //                 $newUser = new User;
    //                 $newUser->email = $data['email'];
    //                 $newUser->firstname = (isset($data['firstname']))?$data['firstname']:'';
    //                 $newUser->lastname = (isset($data['lastname']))?$data['lastname']:'';
    //                 $newUser->user_type = 'frontend';
    //                 $newUser->is_verify = 1;
    //                 $newUser->is_active = 1;
    //                 // $newUser->save();
    //                 if ($newUser->save()) {
    //                     $newLogin = new UserSocialLogin;
    //                     $newLogin->user_id = $newUser->id;
    //                     $newLogin->provider = $provider;
    //                     $newLogin->social_id = $data['socialId'];
    //                     $newLogin->save();
    //                     // return user ID
    //                     $return = $newUser->id;
    //                 }


    //             }

    //         }else{
    //             $newUser = new User;
    //             // $newUser->email = (isset($data->email))?$data->email:'';
    //             $newUser->firstname = (isset($data['firstname']))?$data['firstname']:'';
    //             $newUser->lastname = (isset($data['lastname']))?$data['lastname']:'';
    //             $newUser->user_type = 'frontend';
    //             $newUser->is_verify = 1;
    //             $newUser->is_active = 1;
    //             // $newUser->save();
    //             if ($newUser->save()) {
    //                 $newLogin = new UserSocialLogin;
    //                 $newLogin->user_id = $newUser->id;
    //                 $newLogin->provider = $provider;
    //                 $newLogin->social_id = $data['socialId'];
    //                 $newLogin->save();

    //                 $return = $newUser->id;
    //             }
    //         }
    //     }
    //     return $return;
    // }

    public static function NameToFirstlast($name = '')
    {
        $return = ['firstname' => '', 'lastname' => ''];
        $name = explode(' ', $name);
        if (count($name) > 1) {
            $return['firstname'] = $name[0];
            $return['lastname'] = $name[1];
        } else {
            $return['firstname'] = $name[0];
            $return['lastname'] = '';
        }
        return $return;
    }


    public static function getLoggedInId()
    {
        $userId = (Auth::check()) ? Auth::user()->id : 0; //check in web
        // if (!$userId) {
        //     //check in API
        //     $userId = (auth('api')->user()) ? auth('api')->user()->id : 0;
        // }
        return $userId;
    }

    public static function getLoggedInCompanyId()
    {
        $companyId = (Auth::check()) ? CompanyUser::getCompanyIdByUserId(Auth::user()->id) : 0; //check in web
        return $companyId;
    }

    public static function checkExist($phone)
    {
        $data = self::where('phone', $phone)->get();
        return count($data);
    }

    public static function sendPasswordResetMail($email)
    {
        $user = self::where('email', $email)->first();
        if ($user) {
            $password_broker = app(PasswordBroker::class);
            $token = $password_broker->createToken($user);
            DB::table('password_resets')->insert(['email' => $user->email, 'token' => $token, 'created_at' => new Carbon]);
            // url('password/reset', $this->token)
            return $token;
        }
    }

    public static function getNextUniqueId($roleId)
    {
        $financialYear = date('Y');
        $prefix = ($roleId == 4) ? 'R' : 'C';
        $prefix .= date('y');
        $number = "1";
        $user = self::where('role_id', $roleId)->where('user_type', "frontend")->whereNotNull("unique_id")->orderBy("unique_id", "DESC")->whereYear('created_at', $financialYear)->first();
        if ($user) {
            $uniqueId = $user->unique_id;
            if ($uniqueId) {
                $number = substr($uniqueId, 3);
                $number = intval($number);
                $number += 1;
            }
        }
        $return = $prefix . sprintf("%04d", $number);
        return $return;
    }

    public static function getNameByIdForChat($id)
    {
        $fullname = 'Anonymous';
        $return = self::where('id', $id)->first();
        if ($return) {
            $fullname = $return->firstname . " " . $return->lastname;
        }
        return $fullname;
    }

    public static function getEmailById($id)
    {
        $email = '';
        $return = self::where('id', $id)->first();
        if ($return) {
            $email = $return->email;
        }
        return $email;
    }

    public static function getCandidateSpecialist()
    {
        // pre(config('app.candidateSpecialistRoleId'));
        // $return =  self::selectRaw("CONCAT(users.firstname,' ',users.lastname) AS name,users.id,users.*")->leftjoin('role_user', 'role_user.admin_id', 'users.id')->where('users.user_type','backend')->where('role_user.role_id', config('app.candidateSpecialistRoleId'))->whereNull('users.deleted_at')->get()->toArray();
        // pre($return);
        return self::select(DB::raw("CONCAT(users.firstname,' ',users.lastname) AS name"), 'users.id')->leftjoin('role_user', 'role_user.admin_id', 'users.id')->where('users.user_type','backend')->where('role_user.role_id', config('app.candidateSpecialistRoleId'))->whereNull('users.deleted_at')->pluck('name', 'id');
        //  return $email;
    }

    public static function getAccountManagers()
    {
        // pre(config('app.candidateSpecialistRoleId'));
        // $return =  self::selectRaw("CONCAT(users.firstname,' ',users.lastname) AS name,users.id,users.*")->leftjoin('role_user', 'role_user.admin_id', 'users.id')->where('users.user_type','backend')->where('role_user.role_id', config('app.candidateSpecialistRoleId'))->whereNull('users.deleted_at')->get()->toArray();
        // pre($return);
        $accountMngr = Role::getAccountManagerRole();
        // pre($accountMngr);
        if ($accountMngr) {
            return self::select(DB::raw("CONCAT(users.firstname,' ',users.lastname) AS name"), 'users.id')
            ->leftjoin('role_user', 'role_user.admin_id', 'users.id')
            ->where('users.user_type', 'backend')
            ->where('role_user.role_id', $accountMngr)->whereNull('users.deleted_at')->pluck('name', 'id');
        }
        return [];
        //  return $email;
    }

    public static function checkUniqueEmail($type, $email)
    {
        $check = self::where('user_type', $type)
            ->where('email', $email)
            ->first();
        return ($check) ? false : true;
    }

    public static function getAttrById($id, $attr)
    {
        $return = "";
        $data = self::select($attr)->where('id', $id)->first();
        if ($data) {
            $return = $data->$attr;
        }
        return $return;
    }

    public static function getUserForStripeCustomer($userId)
    {
        $return = "";
        $data = self::select('firstname', 'lastname', 'email', 'role_id')->where('id', $userId)->first();
        if ($data) {
            // getRoleById($id)
            $return = [
                'name' => $data['firstname'] . (($data['lastname']) ? ' ' . $data['lastname'] : ''),
                'email' => $data['email'],
                'role_id' => $data['role_id'],
                'role_name' => self::getRoleById($data['role_id']),
            ];
        }
        return $return;
    }

    public static function getUserByStripeCustomerId($stripe_customer_id)
    {
        $return = "";
        $data = self::select('firstname', 'lastname', 'email', 'role_id', 'id', 'current_subscription')->where('stripe_customer_id', $stripe_customer_id)->first();
        if ($data) {
            // getRoleById($id)
            $return = [
                'name' => $data['firstname'] . (($data['lastname']) ? ' ' . $data['lastname'] : ''),
                'email' => $data['email'],
                'role_id' => $data['role_id'],
                'id' => $data['id'],
                'role_name' => self::getRoleById($data['role_id']),
                'current_subscription' => $data['current_subscription'],
            ];
        }
        return $return;
    }

    public static function createOrUpdate($pk, $inputArray)
    {
        $user = User::updateOrCreate(
            [
                'id' => $pk
            ],
            $inputArray
        );
        return $user;
    }

    public static function deleteUser($user_id)
    {
        $user = self::where('id', $user_id)->first();
        if ($user) {
            $user->email = $user->email . 'deleted' . now();
            $user->phone = $user->phone . 'deleted' . now();
            $user->save();
            $user->delete();
        }
    }

    public static function getCompanyLogo()
    {
        $return = '';
        $userId = Auth::user()->id;
        $companyUserData = CompanyUser::where('user_id', $userId)->first();
        if ($companyUserData && isset($companyUserData->company))
            $return = $companyUserData->company->logo;

        return $return;
    }

    public static function getCandidateImage()
    {
        $userId = Auth::user()->id;
        $return = '';
        $candidateData = Candidate::where('user_id', $userId)->first();
        if ($candidateData && isset($candidateData->profile_pic))
            $return = $candidateData->profile_pic;

        return $return;
    }

    public static function getBackendRole()
    {
        $return = 0;
        $return = Auth::guard('admin')->user()->role->role_id;
        return $return;
    }
}
