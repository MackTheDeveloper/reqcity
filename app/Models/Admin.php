<?php

namespace App\Models;

// use Illuminate\Database\Eloquent\Factories\HasFactory;
// use Illuminate\Database\Eloquent\Model;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Fortify\TwoFactorAuthenticatable;
use Laravel\Jetstream\HasProfilePhoto;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use App\Models\User;
use App\Models\Subscription;
use App\Models\Transactions;

class Admin extends Authenticatable
{
    use HasFactory;
    use HasApiTokens;
    use HasProfilePhoto;
    use Notifiable;
    use TwoFactorAuthenticatable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'email',
        'password',
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

    /**
     * The accessors to append to the model's array form.
     *
     * @var array
     */
    protected $appends = [
        'profile_photo_url',
    ];

    protected static function getNewAccountsDashboard()
    {
        //return DB::table('users')->where('is_deleted',0)->where('created_at','like', '%' . date('Y-m-d') . '%')->count();
        return User::where('is_deleted', 0)
            //->where('is_active', 1)
            ->whereDate('created_at', Carbon::today())->count();
    }

    protected static function getTotalFans()
    {
        return User::where('is_deleted', 0)
            ->where('user_type', 'frontend')->where('role_id', '3')->count();
    }

    protected static function getTotalFansToday()
    {
        return User::where('is_deleted', 0)
            ->where('user_type', 'frontend')->where('role_id', '3')->whereDate('created_at', Carbon::today())->count();
    }

    protected static function filterTotalFans($startDate = null, $endDate = null)
    {
        $startDate = date('Y-m-d',strtotime($startDate));
        $endDate = date('Y-m-d',strtotime($endDate));

        return User::where('is_deleted', 0)
            ->where('user_type', 'frontend')->where('role_id', '3')
            ->whereBetween(DB::raw("date_format(created_at,'%Y-%m-%d')"), array($startDate, $endDate))
            ->count();

    }

    protected static function getTotalArtist()
    {
        return User::where('is_deleted', 0)
            ->where('user_type', 'frontend')->where('role_id', '2')->count();
    }

    protected static function getTotalArtistToday()
    {
        return User::where('is_deleted', 0)
            ->where('user_type', 'frontend')->where('role_id', '2')->whereDate('created_at', Carbon::today())->count();
    }

    protected static function filterTotalArtist($startDate = null, $endDate = null)
    {
        $startDate = date('Y-m-d',strtotime($startDate));
        $endDate = date('Y-m-d',strtotime($endDate));
        return User::where('is_deleted', 0)
            ->where('user_type', 'frontend')->where('role_id', '2')->whereBetween(DB::raw("date_format(created_at,'%Y-%m-%d')"), array($startDate, $endDate))->count();
    }

    protected static function getTotalArtistPending()
    {
        return User::where('is_deleted', 0)
            ->where('user_type', 'frontend')->where('role_id', '2')->where('is_verify', '0')->count();
    }

    protected static function getTotalSubscriptionSumToday()
    {
        /* $return = Subscription::selectRaw('SUM(amount) as total')->where('status', 1)->whereDate('created_at', Carbon::today())->first();
        return '$'.(!empty($return->total) ? $return->total : '0.00'); */

        $return = Transactions::selectRaw('SUM(amount) as total')->where('status', 1)->whereDate('created_at', Carbon::today())->first();
        return '$'.(!empty($return->total) ? $return->total : '0.00');
    }

    protected static function filterTotalSubscriptionSum($startDate = null, $endDate = null)
    {
        $startDate = date('Y-m-d',strtotime($startDate));
        $endDate = date('Y-m-d',strtotime($endDate));
        /* $return = Subscription::selectRaw('SUM(amount) as total')->where('status', 1)->whereBetween(DB::raw("date_format(created_at,'%Y-%m-%d')"), array($startDate, $endDate))->first(); */
        $return = Transactions::selectRaw('SUM(amount) as total')->where('status', 1)->whereBetween(DB::raw("date_format(created_at,'%Y-%m-%d')"), array($startDate, $endDate))->first();
        return '$'.(!empty($return->total) ? $return->total : '0.00');
    }

    protected static function getTotalSubscriptionToday()
    {
        return Subscription::where('status', 1)->whereDate('created_at', Carbon::today())->count();
    }

    protected static function filterTotalSubscription($startDate = null, $endDate = null)
    {
        $startDate = date('Y-m-d',strtotime($startDate));
        $endDate = date('Y-m-d',strtotime($endDate));
        return Subscription::where('status', 1)->whereBetween(DB::raw("date_format(created_at,'%Y-%m-%d')"), array($startDate, $endDate))->count();
    }

    protected static function getTotalPositiveReview()
    {
        $totalReview = DB::table('reviews')
            ->whereNull('deleted_at')
            ->count();

        $totalPReview = DB::table('reviews')
            ->whereNull('deleted_at')
            ->where('reviews', '>', 3)
            ->count();
        return $totalPReview * 100 / $totalReview;
    }

    protected static function getLastFifteenDays()
    {
        $lastFifteenDays = array();
        for ($i = 0; $i < 15; $i++)
            $lastFifteenDays[] = date("Y-m-d", strtotime('-' . $i . ' days'));

        return $lastFifteenDays;
    }

    protected static function getLastTwelveMonths()
    {
        $lastTwelveMonths = array();
        for ($i = 0; $i < 12; $i++)
            $lastTwelveMonths[] = date("Y-m-d", strtotime('-' . $i . ' months'));

        return $lastTwelveMonths;
    }
    protected static function getLastSixMonths()
    {
        $lastTwelveMonths = array();
        for ($i = 0; $i < 6; $i++)
            $lastTwelveMonths[] = date("Y-m-d", strtotime('-' . $i . ' months'));

        return $lastTwelveMonths;
    }

    protected static function getLastFiveYears()
    {
        $lastFiveYears = array();
        for ($i = 0; $i < 5; $i++)
            $lastFiveYears[] = date("Y-m-d", strtotime('-' . $i . ' years'));

        return $lastFiveYears;
    }
    protected static function getLifeTimeYears($createDate)
    {
        $lifetTimeYears = array();
        $now = time();
        $createDate = strtotime($createDate);
        $datediff = $now - $createDate;
        $years = floor($datediff / (365*60*60*24));
        if($years==0)
        $years=1;
        for ($i = 0; $i <=$years; $i++)
            $lifetTimeYears[] = date("Y-m-d", strtotime('-' . $i . ' years'));

        return $lifetTimeYears;
    }
    protected static function getLifeTimeMonths($createDate)
    {
        $lifetTimeMonths = array();
        $now = time();
        $createDate = strtotime($createDate);
        $datediff = $now - $createDate;
        $years = floor($datediff / (365*60*60*24));
        $months= floor(($datediff-$years * 365 * 60 * 60 * 24) / (30 * 60 * 60 * 24));
        if($months==0)
        $months=1;
        for ($i = 0; $i <=$months; $i++)
            $lifetTimeMonths[] = date("Y-m-d", strtotime('-' . $i . ' months'));

        return $lifetTimeMonths;
    }

    protected static function getTotalFrontendUsersInLastFifteenDays($lastFifteenDays)
    {
        foreach ($lastFifteenDays as $k => $v) {
            $totalFrontendUsersInLastFifteenDays[] = DB::table('users')->where('is_deleted', 0)
                //->where('is_active', 1)
                ->where('user_type', 'frontend')->where('created_at', 'like', '%' . $v . '%')->count();
        }
        return $totalFrontendUsersInLastFifteenDays;
    }

    protected static function getTotalProfessionalsInLastFifteenDays($lastFifteenDays)
    {
        foreach ($lastFifteenDays as $k => $v) {
            $totalProfessionalsInLastFifteenDays[] = DB::table('professionals')
                ->join('users', 'users.id', '=', 'professionals.user_id')
                ->where('users.is_deleted', 0)
                //->where('users.is_active', 1)
                ->where('users.is_professional', 1)
                ->where('users.created_at', 'like', '%' . $v . '%')
                ->count();
        }
        return $totalProfessionalsInLastFifteenDays;
    }

    protected static function getTopSongs()
    {
        /* return Songs::select('songs.id','users.firstname','users.lastname','songs.name','songs.num_likes','songs.icon')
        ->leftjoin('users','songs.artist_id','users.id')
        ->orderBy('num_likes','desc')->limit(5)->get()->toArray(); */
        return Songs::has('artist')->orderBy('num_likes','desc')->limit(5)->get();
    }

    protected static function getTopArtists()
    {
        return Artist::select('users.*','artist_detail.no_subscription')->leftJoin('artist_detail','artist_detail.user_id','users.id')->whereNull('artist_detail.deleted_at')->where('role_id', '2')->orderBy('no_subscription','desc')->limit(5)->get();
    }
}
