<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Auth;
use App\User;
use Carbon\Carbon;

class BookDemoRequest extends Model
{
    protected $table = 'book_demo_requests';
    protected $fillable = [
        'id',
        'type',
        'first_name',
        'last_name',
        'email',
        'phone',
        'status',
        'requirement',
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    public static function addNew($data){
        $return = '';
        $success = true;

        try{
            $create = new BookDemoRequest();
            foreach ($data as $key => $value) {
                $create->$key = $value;
            }
            $create->save();
            $return = $create;
            try {
                $data = ['NAME'=>$create->first_name,'EMAIL'=>$create->email,'PHONE'=>$create->prefix.'-'.$create->phone,'MESSAGE'=>$create->requirement];
                $adminEmails = ['nivedita.magneto@gmail.com'];
                EmailTemplates::sendMail('book-demo-request-admin',$data,$adminEmails);

                $data = ['NAME'=>$create->first_name];
                EmailTemplates::sendMail('book-demo-request-users',$data,$create->email);

                $code='BOOKDEMO';
                $msg_type='Demo Request';
                $msg='A demo requested by a user '.$create->first_name;
                $notification=insertNotification(4,'',$code,$msg_type,$msg);
            } catch (\Exception $e) {

            }
        }catch(\Exception $e){
            $return = $e->getMessage();
            $success = false;
        }
        return ['data'=>$return,'success'=>$success];
    }
}
