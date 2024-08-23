<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use DB;

class CompanyFaqs extends Model
{
    use HasFactory, SoftDeletes;
    protected $table = 'company_faqs';
    protected $fillable = [
        'faq_template_id',
        'question',
        'answer',
        'sort_order',
        'status',
    ];

    public static function createOrUpdate($templateId, $inputArray)
    {
        DB::table('company_faqs')->where('faq_template_id', $templateId)->delete();
        foreach ($inputArray as $k => $v) {
            $inputArray[$k]['faq_template_id'] = $templateId;
            self::create($inputArray[$k]);
        }
    }

    public static function addData($data)
    {
        $return = 0;
        $success = true;
        $allowed = ['faq_template_id', 'question', 'answer', 'sort_order'];
        $data = array_intersect_key($data, array_flip($allowed));
        $newEntry = new CompanyFaqs();
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
        $allowed = ['faq_template_id', 'question', 'answer', 'sort_order'];
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

    public static function removeData($templateId, $data)
    {
        $return = 0;
        $success = true;
        $data = array_filter(array_map(function ($ar) {
            return isset($ar['id']) ? $ar['id'] : '';
        }, $data));
        $dataAll = self::where('faq_template_id', $templateId)->pluck('id')->toArray();
        $removedData = array_merge(array_diff($data, $dataAll), array_diff($dataAll, $data));
        if ($removedData) {
            try {
                DB::table('company_faqs')->whereIn('id', $removedData)->delete();
                $return = 1;
            } catch (\Exception $e) {
                $return = $e->getMessage();
                $success = false;
            }
        }
        return ['data' => $return, 'success' => $success];
    }

    public static function addUpdateData($templateId, $data)
    {

        $removeData = self::removeData($templateId, $data);
        foreach ($data as $key => $value) {
            $value['faq_template_id'] = $templateId;
            if (!empty($value['id'])) {
                $result1 = self::editData($value['id'], $value);
            } else {
                $result1 = self::addData($value);
            }
        }
        return true;
    }

}
