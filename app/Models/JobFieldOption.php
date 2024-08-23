<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Models\JobField;
use File;
use Illuminate\Support\Facades\DB;
use Image;

class JobFieldOption extends Model
{
    use HasFactory;
    protected $table = 'job_field_options';
    protected $fillable = [
        'id',
        'job_field_id',
        'option',
        'sort_order',
        'status',
    ];
    public static function getDetails($id)
    {
        return self::find($id);
    }

    public static function getList()
    {
        return self::pluck('option', 'id', 'sort_order');
    }
    public static function getSortOrder()
    {
        $return = self::selectRaw('sort_order')->where('status', 1)->orderBy('sort_order', 'desc')->first();
        return $return ? $return->sort_order + 1 : 1;
    }

    public static function getOptions($code)
    {
        $return = [];
        $data = self::select('option', 'job_field_options.id')
            ->leftJoin('job_fields', 'job_field_options.job_field_id', 'job_fields.id')
            ->where('job_fields.code', $code)
            ->where('job_field_options.status', 1)
            ->whereNull('job_field_options.deleted_at')
            ->orderBy('job_field_options.sort_order')
            ->get();
        foreach ($data as $key => $value) {
            $return[] = ['key' => $value->id, 'value' => $value->option];
        }
        return $return;
    }

    public static function getIdsOfJobFieldByOption($code)
    {
        $return = [];
        $data = self::leftJoin('job_fields', 'job_field_options.job_field_id', 'job_fields.id')
            ->where('job_fields.code', $code)
            ->where('job_field_options.status', 1)
            ->whereNull('job_field_options.deleted_at')
            ->pluck('job_field_options.id')->toArray();
        if ($data)
            $return = $data;
        return $return;
    }

    public static function getAttrById($id, $attr)
    {
        $exploadedIds = explode(',', $id);
        if (count($exploadedIds) <= 1) {
            $return = "";
            $data = self::select($attr)->where('id', $id)->first();
            if ($data) {
                $return = $data->$attr;
            }
        } else {
            $return = "";
            $attrAl = 'options';
            $data = self::select(DB::raw('group_concat(`' . $attr . '`) as ' . $attrAl . ''))->whereIn('id', $exploadedIds)->first();
            if ($data) {
                $return = $data->$attrAl;
            }
        }
        return $return;
    }
}
