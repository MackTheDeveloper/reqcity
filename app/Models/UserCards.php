<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserCards extends Model
{
    use HasFactory;
    protected $table = 'user_cards';
    protected $fillable = [
        'user_id',
        'card_name',
        'card_number',
        'exp_month',
        'exp_year',
        'brand',
        'card_id',
        'is_default'
    ];

    public static function getUserCardByCompanyId($companyId){
        $return = [];
        $company =  Companies::find($companyId);
        if ($company) {
            $companyOwner = $company->user_id;
            $userCard = self::where('user_id', $companyOwner)->first();
            if ($userCard) {
                $return = $userCard; 
            }
        }
        return $return;
    }
}
