<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class CompanyFaqsTemplates extends Model
{
    use HasFactory, SoftDeletes;
    protected $table = 'company_faqs_templates';
    protected $fillable = [
        'company_id',
        'title',
        'status',
        'created_by',
    ];

    public function companyUser()
    {
        return $this->hasOne(User::class, 'id', 'created_by');
    }

    public function companyFaqs()
    {
        return $this->hasMany(CompanyFaqs::class, 'faq_template_id', 'id');
    }

    public static function getList()
    {
        $data = self::where('status', 1);
        return $data;
    }

    public static function getTemplates($companyId = ''){
        return self::where('status',1)->where('company_id',$companyId)->pluck('title','id');
    }

    public static function createOrUpdate($pk, $inputArray)
    {
        $companyFaqTemplate = self::updateOrCreate(
            [
                'id' => $pk
            ],
            $inputArray
        );
        return $companyFaqTemplate;
    }

    public static function addTemplate($data)
    {
        $return = 0;
        $success = true;
        $authId = User::getLoggedInId();
        $companyId = User::getLoggedInCompanyId();
        $data['created_by'] = $authId;
        $data['company_id'] = $companyId;
        $allowed = ['company_id', 'title', 'status', 'created_by'];
        $data = array_intersect_key($data, array_flip($allowed));
        $newEntry = new CompanyFaqsTemplates();
        try {
            foreach ($data as $key => $value) {
                $newEntry->$key = $value;
            }
            $newEntry->save();
            $return = $newEntry->id;
        } catch (\Exception $e) {
            //$return = $e->getMessage();
            $success = false;
        }
        return ['templateId' => $return, 'success' => $success];
    }

    public static function editTemplate($id, $data)
    {
        $return = 0;
        $success = true;
        $allowed = ['title'];
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
                //$return = $e->getMessage();
                $success = false;
            }
        }
        return ['templateId' => $return, 'success' => $success];
    }
    public static function getFaqsTemplatesCount($companyId)
    {
      return self::where('company_id',$companyId)->where('status',1)->whereNull('deleted_at')->count();
    }
}
