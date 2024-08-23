<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class RecruiterCandidate extends Model
{
    use HasFactory;
    use SoftDeletes;
    protected $table = 'recruiter_candidates';
    protected $fillable = [
        'id',
        'first_name',
        'last_name',
        'name',
        'email',
        'recruiter_id',
        'address_1',
        'address_2',
        'state',
        'city',
        'postcode',
        'country',
        'phone_ext',
        'phone',
        'is_diverse_candidate',
        'linkedin_profile',
        'rejection_reason',
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    public function Countrydata()
    {
        return $this->hasOne(Country::class, 'id', 'country');
    }
    public static function getRecruiterCandidate($id)
    {
        $data = self::where('recruiter_id', $id)
            ->whereNull('deleted_at')->first();
        if ($data) {
            $data = $data;
        }
        $return = $data;
        return $return;
    }

    public static function addData($data)
    {
        $return = 0;
        $success = true;
        $authId = User::getLoggedInId();
        // $data['dob'] = date('Y-m-d',strtotime($data['dob']));
        // pre($data);
        $data['recruiter_id'] = $authId;
        if (!empty($data['first_name']) || !empty($data['last_name'])) {
            $data['name'] = $data['first_name'] . ' ' . $data['last_name'];
        }
        $allowed = ['first_name', 'last_name', 'name', 'email', 'recruiter_id', 'city', 'address_1', 'address_2', 'state', 'country', 'phone_ext', 'phone', 'is_diverse_candidate', 'linkedin_profile', 'postcode'];
        $data = array_intersect_key($data, array_flip($allowed));
        $newEntry = new RecruiterCandidate();
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
        $authId = User::getLoggedInId();
        // $data['dob'] = date('Y-m-d',strtotime($data['dob']));
        // pre($data);
        $data['recruiter_id'] = $authId;
        if (!empty($data['first_name']) || !empty($data['last_name'])) {
            $data['name'] = $data['first_name'] . ' ' . $data['last_name'];
        }
        $allowed = ['first_name', 'last_name', 'name', 'email', 'recruiter_id', 'city', 'address_1', 'address_2', 'state', 'country', 'phone_ext', 'phone', 'is_diverse_candidate', 'linkedin_profile', 'postcode'];
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

    public static function getCandidatesOfRecruiter($id)
    {
        $data = self::where('recruiter_id', $id)->limit(5)->orderBy('id', 'desc')->get();
        if ($data) {
            $data = self::formatCandidatesOfRecruiter($data);
        }
        return $data;
    }

    public static function formatCandidatesOfRecruiter($data)
    {
        $return = [];
        foreach ($data as $key => $value) {
            $resumeImage = '<img src="' . url('public/assets/frontend/img/pdf.svg') . '" alt="" />';
            $resume = RecruiterCandidateResume::getLatestResume($value->id);
            if (!empty($resume) && !empty($resume['cv']))
                $resumeCv = "<a class='pdf-link' href='" . $resume['cv'] . "' target='_blank'>" . $resumeImage . "</a>";
            else
                $resumeCv = '';

            $linkedInImage = '<img src="' . url('public/assets/frontend/img/Linkedin-btn.svg') . '" alt="" />';
            $linkedIn = !empty($value->linkedin_profile) ? "<a class='linkdin-link' href='" . $value->linkedin_profile . "' target='_blank'>" . $linkedInImage . "</a>" : '';
            $return[] = [
                "id" => $value->id,
                "name" => $value->name,
                "number" => $value->phone_ext . " " . $value->phone,
                "email" => $value->email,
                "city" => $value->city,
                "country" => $value->Countrydata->name,
                "resumeCv" => $resumeCv,
                "linkedIn" => $linkedIn,
            ];
        }
        return $return;
    }
}
