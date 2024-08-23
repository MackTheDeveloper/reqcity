<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RecruiterTaxForms extends Model
{
    use HasFactory;
    protected $table = 'recruiter_tax_forms';
    protected $fillable = [
        'id',
        'recruiter_id',
        'form_name',
        'tax_form',
        'status',
    ];

    public static function getFormFile($id)
    {
      $return = '';
      $data = self::where('id', $id)->first();
      if ($data && !empty($data->tax_form)) {
        $return =url('public/assets/tax-forms/' .  $data->tax_form);;
      }
      return $return;
    }
    public static function getRecruiterW9Forms($id)
    {
      $data = self::where('recruiter_id', $id)
          ->whereNull('deleted_at')->first();
        if ($data)
        {
            $data =$data;
        }
        $return = $data;
        return $return;
    }
}
