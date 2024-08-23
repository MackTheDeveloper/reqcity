<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use File;
use App\Models\CandidateResume;
use Exception;

class Candidate extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $table = 'candidates';
    protected $fillable = [
        'id',
        'user_id',
        'first_name',
        'last_name',
        'email',
        'password',
        'profile_pic',
        'dob',
        'about',
        'address_1',
        'address_2',
        'state',
        'city',
        'postcode',
        'linkedin_profile_link',
        'is_verify',
        'country',
        'phone_ext',
        'phone',
        'job_title',
        'deleted',
        'status',
        'created_at',
        'deleted_at',
    ];


    public static function getCandidateImage($id)
    {
        $return = url('/public/assets/frontend/img/user-img.svg');
        $data = self::where('id', $id)->first();
        if ($data && !empty($data->profile_pic)) {
            $return = url('public/assets/images/candidate-img/' .  $data->profile_pic);
        }
        return $return;
    }

    public static function getProfilePicAttribute($image)
    {
        $return = url('/public/assets/frontend/img/user-img.svg');
        $path = public_path() . '/assets/images/candidate-img/' . $image;
        if (file_exists($path) && $image) {
            $return = url('/public/assets/images/candidate-img/' . $image);
        }
        return $return;
    }

    public function Countrydata()
    {
        return $this->hasOne(Country::class, 'id', 'country');
    }

    public static function uploadCandidateImage($songIconBase64)
    {
        $image_parts = explode(";base64,", $songIconBase64);
        $ext = str_replace('data:image/', '', $image_parts[0]);
        $imageName = rand() . '_' . time() . '.' . $ext;
        $image_base64 = base64_decode($image_parts[1]);

        $imageFullPath = public_path() . '/assets/images/candidate-img/' . $imageName;
        $path = public_path() . '/assets/images/candidate-img/';
        if (!File::exists($path)) {
            File::makeDirectory($path);
        }
        file_put_contents($imageFullPath, $image_base64);

        return $imageName;
    }

    public static function uploadResume($candidateId, $fileObject)
    {
        $file = $fileObject;
        //$ext = $fileObject->extension();
        $ext = $fileObject->getClientOriginalExtension();
        $filename = rand() . '_' . time() . '.' . $ext;
        $filePath = public_path() . '/assets/candidate/resume/';
        if (!File::exists($filePath)) {
            File::makeDirectory($filePath);
        }
        $file->move($filePath . '/', $filename);
        if ($candidateId) {
            $oldData = CandidateResume::where('candidate_id', $candidateId)->first();
            if ($oldData) {
                $path = public_path() . '/assets/candidate/resume/' . $oldData->resume;
                if (file_exists($path)) {
                    unlink($path);
                }
            }
            $versions = CandidateResume::where('candidate_id', $candidateId)->orderBy('id', 'DESC')->first();
            $versionNumber = 1;
            if ($versions) {
                $versionNumber = $versions->version_num + 1;
            }
            $resume = new CandidateResume();
            $resume->candidate_id = $candidateId;
            $resume->resume = $filename;
            $resume->version_num = $versionNumber;
            $resume->created_at = Carbon::now();
            $resume->save();
        }
        return $filename;
    }

    public function User()
    {
        return $this->hasOne(User::class, 'id', 'user_id');
    }

    public function Country()
    {
        return $this->hasOne(Country::class, 'id', 'country');
    }

    public static function getCandidateDetailsById($id)
    {
        $data = Candidate::where('id', $id)->first();
        if ($data) {
            $data = self::formatCandidateList($data);
        }
        $return = $data;
        return $return;
    }
    public static function formatCandidateList($data)
    {
        $return = [];
        $return = [
            "candidateId" => $data->id,
            "candidateName" => $data->first_name . ' ' . $data->last_name,
            "candidatePhone" => $data->phone_ext . ' ' . $data->phone,
            "candidateEmail" => $data->email,
            "candidateAddress" => $data->address_1 . ', ' . $data->address_2 . ', ' . $data->city . ', ' . $data->Country->name,
        ];
        return $return;
    }

    public static function checkAddressDetailsUpdated($candidateId)
    {
        $return = 0;
        $data = self::find($candidateId);
        if (!empty($data->address_1) && !empty($data->city) && !empty($data->country))
            $return = 1;

        return $return;
    }
    public static function addData($data)
    {
        $return = 0;
        $success = true;
        // $authId = User::getLoggedInId();
        // $data['dob'] = date('Y-m-d',strtotime($data['dob']));
        // pre($data);
        // if (!empty($data['first_name']) || !empty($data['last_name'])) {
        //     $data['name'] = $data['first_name'] . ' ' . $data['last_name'];
        // }
        $allowed = ['first_name', 'last_name', 'email', 'city', 'address_1', 'address_2', 'state', 'country', 'phone_ext', 'phone', 'is_diverse_candidate', 'linkedin_profile_link'];
        $data = array_intersect_key($data, array_flip($allowed));
        $newEntry = new Candidate();
        try {
            foreach ($data as $key => $value) {
                $newEntry->$key = $value;
            }
            $newEntry->save();
            $return = $newEntry->id;
        } catch (\Exception $e) {
            $return = $e->getMessage();
            $success = false;
        }
        return ['data' => $return, 'success' => $success];
    }

    public static function editData($id, $data)
    {
        $return = 0;
        $success = true;
        // $authId = User::getLoggedInId();
        // $data['dob'] = date('Y-m-d',strtotime($data['dob']));
        // pre($data);
        // if (!empty($data['first_name']) || !empty($data['last_name'])) {
        //     $data['name'] = $data['first_name'] . ' ' . $data['last_name'];
        // }
        $allowed = ['first_name', 'last_name', 'email', 'city', 'address_1', 'address_2', 'state', 'country', 'phone_ext', 'phone', 'is_diverse_candidate', 'linkedin_profile_link'];
        $data['is_diverse_candidate'] = isset($data['is_diverse_candidate']) ? '1' : '0';
        $data = array_intersect_key($data, array_flip($allowed));
        $exist = self::where('id', $id)->first();
        if ($exist) {
            try {
                foreach ($data as $key => $value) {
                    $exist->$key = $value;
                }
                $exist->save();
                $return = $exist->id;
            } catch (\Exception $e) {
                $return = $e->getMessage();
                $success = false;
            }
        }
        return ['data' => $return, 'success' => $success];
    }

    //get candidate status by user id
    public static function getCandidateStatus($userid)
    {
        $candidate = self::where('user_id',$userid)->first();
        $status = (isset($candidate))?$candidate->status:"";
        return $status;
    }

    public static function getCountDashboard($from = "", $to = "")
    {
        $count = 0;
        $data = self::selectRaw('count(*) as total')->whereNull('deleted_at');
        if ($from != "" && $to != "") {
            $data->whereBetween('created_at', [$from, $to]);
        } else {
            $data->whereDate('created_at', Carbon::today());
        }
        $data = $data->first();
        if ($data) {
            $count = $data->total;
        }
        return $count;
    }

    public static function getCountDashboardGraph($type = "daily", $date)
    {
        $return = 0;
        $data = self::selectRaw('count(*) as total')->whereNull('deleted_at');
        if ($type == "daily") {
            $data->whereDate('created_at', $date);
        } elseif ($type == "monthly") {
            $month = date('m', strtotime($date));
            $year = date('Y', strtotime($date));
            $data->whereMonth('created_at', $month);
            $data->whereYear('created_at', $year);
        } elseif ($type == "yearly") {
            $year = date('Y', strtotime($date));
            $data->whereYear('created_at', $year);
        }
        $data = $data->first();
        if ($data) {
            $return = $data->total;
        }
        return $return;
    }

    public static function getUserId($id)
    {
        $return = 0;
        $data = self::where('id', $id)->first();
        if ($data) {
            $return = $data->user_id;
        }
        return $return;
    }
}
