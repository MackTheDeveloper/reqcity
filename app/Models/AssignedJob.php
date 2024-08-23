<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AssignedJob extends Model
{
    use HasFactory;
    protected $table = 'candidate_applications';
    protected $fillable = [
        'id',
        'candidate_id',
        'company_job_id',
        'candidate_cv_id',
        'specialist_user_id',
        'status',
        'rejection_reason',
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    public static function getAttrById($id, $attr)
    {
        $return = "";
        $data = self::select($attr)->where('id', $id)->first();
        if ($data) {
            $return = $data->$attr;
        }
        return $return;
    }
}
