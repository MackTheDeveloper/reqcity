<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class JobBalanceTransferRequests extends Model
{
    use HasFactory;
    protected $table = 'job_balance_transfer_requests';
    protected $fillable = [
        'id',
        'company_id',
        'from_company_job_id	',
        'to_company_job_id',
        'balance',
        'status',
        'reject_reason',
        'created_at',
        'created_by',
        'updated_at',
        'updated_by',
        'deleted_at',
    ];

    public static function addNew($data){
        $return = '';
        $success = true;

        try{
            $create = new JobBalanceTransferRequests();
            $create->company_id	=$data['company_id'];
            $create->from_company_job_id	=$data['fromJobId'];
            $create->to_company_job_id	=$data['toJobId'];
            $create->balance	=$data['balance'];
            $create->status	=$data['status'];
            $create->created_by	=$data['created_by'];

            //pre($create);
            $create->save();
            $return = $create;

        }catch(\Exception $e){
            $return = $e->getMessage();
            $success = false;
        }
        return ['data'=>$return,'success'=>$success];
    }
}
