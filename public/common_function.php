<?php

use App\Models\CompanyJobFunding;
use App\Models\Notifications;

function pre($array, $no = '')
{
    echo '<pre>';
    print_r($array);
    if (!$no)
        exit;
}

// MASTER ARRAY OF LANGUAGE

//$langArray = ['en'=>'English','ja'=>'Japanese'];
//pre($langArray);

function getFormatedDate($dateVal, $format = '')
{
    $return = $dateVal;
    if ($format) {
        $return = date($format, strtotime($dateVal));
    } else {
        if (strlen($dateVal) > 12) {
            $return = date('d M Y h:i A', strtotime($dateVal));
        } else {
            $return = date('d M Y', strtotime($dateVal));
        }
    }
    return $return;
}

function getFormatedDateForWeb($dateVal)
{

    $date = Carbon\Carbon::parse($dateVal);
    $now = Carbon\Carbon::now();

    $diff = $date->diff($now);
    if ($diff->y) {
        $year = $diff->y;
        return $year . ' year' . ($year > 1 ? 's' : '') . ' ago';
    } else if ($diff->m) {
        $month = $diff->m;
        return $month . ' month' . ($month > 1 ? 's' : '') . ' ago';
    } else if ($diff->d) {
        $day = $diff->d;
        return $day . ' day' . ($day > 1 ? 's' : '') . ' ago';
    } else if ($diff->h) {
        $hour = $diff->h;
        return $hour . ' hour' . ($hour > 1 ? 's' : '') . ' ago';
    }
}

function getDefaultFormat($type = 'datetime')
{
    $datetime = '%j%S %M %Y %h:%i:%s %A';
    $date = '%j%S %M %Y';
    return ($type == 'date') ? $date : $datetime;
}
function stringSlugify($string, $delimiter = "-")
{
    $slug = strtolower(trim(preg_replace('/[\s-]+/', $delimiter, preg_replace('/[^A-Za-z0-9-]+/', $delimiter, preg_replace('/[&]/', 'and', preg_replace('/[\']/', '', iconv('UTF-8', 'ASCII//TRANSLIT', $string))))), $delimiter));
    return $slug;
}
function getSlug($string, $loop = "", $table, $field, $id = "", $columnId = "id")
{
    $slug = $string;
    $exist = DB::table($table)->where($field, $slug);
    if ($id) {
        $exist->where($columnId, '!=', $id);
    }
    $exist = $exist->get();
    if ($exist && count($exist) > 0) {
        if ($loop != '') {
            $slug = $slug . $loop;
            return $slug;
        } else {
            $loop = ($loop) ? $loop + 1 : 2;
            return getSlug($string, $loop, $table, $field);
        }
        // // if ($id != '') {
        // //     $slug = $slug . $id;
        // //     return $slug;
        // // } else {

        // // }
        // $loop = ($loop) ? $loop + 1 : 2;
        // pre($loop);
        // return getSlug($string, $loop, $table, $field);
    } else {
        return $slug;
    }
}

function componentWithNameObject($content)
{
    $return = [];
    foreach ($content as $key => $value) {
        $key = checkDuplicateKey($return, $value->componentId);
        $return[$key] = $value;
    }
    return $return;
}

function checkDuplicateKey($array, $key, $i = 0)
{
    $return = $key;
    if ($i) {
        $return = $return . $i;
    }
    if (isset($array[$return])) {
        $i++;
        $return = checkDuplicateKey($array, $key, $i);
    }
    return $return;
}
function getResponseMessage($msg, $data = [])
{
    // $msg = config('message.frontendMessages.' . $msgKey);
    if ($data) {
        $msg = str_replace(['{PARAM}'], $data, $msg);
    } else {
        $msg = str_replace('{PARAM}', '', $msg);
    }
    return $msg;
}

function getPricingMessage($role, $msgKey, $data = [])
{
    $msg = config('message.pricingDetails.' . $role . '.labels.' . $msgKey);
    if (!empty($msg)) {
        if ($data) {
            $msg = str_replace(['{PARAM}'], $data, $msg);
        } else {
            $msg = str_replace('{PARAM}', '', $msg);
        }
    } else {
        $msg = '';
    }
    return $msg;
}

function getFormatedAmount($amountVal, $decimalNumber)
{
    $amountValNew = number_format($amountVal, $decimalNumber, '.', ',');
    return ($amountValNew) ? $amountValNew : $amountVal;
}

function removeWhiteSpaces($string)
{
    return preg_replace('/\s+/', '', $string);
}
function getUnreadNotificationCount()
{
    $roleId = Auth::user()->role_id;
    $userId = Auth::user()->id;
    if ($roleId == config('app.companyRoleId')) {
        $type = 1;
        $relatedId = Auth::user()->companyUser->company_id;
    } elseif ($roleId == config('app.recruiterRoleId')) {
        $type = 2;
        $relatedId = Auth::user()->recruiter->id;
    } elseif ($roleId == config('app.candidateRoleId')) {
        $type = 3;
        $relatedId = Auth::user()->candidate->id;
    }
    $data = Notifications::unreadNotificationCountByRole($type, $relatedId);
    return $data;
}

function get_starred($str, $type = 'string')
{
    $return = $str;
    if ($type == 'email') {
        $str2 = explode('@', $str);
        $strfinal = $str2[0];
        $len = strlen($strfinal);
        $return = substr($strfinal, 0, 1) . str_repeat('*', $len - 2) . substr($strfinal, $len - 1, 1) . '@' . $str2[1];
    } else {
        $len = strlen($str);
        $return = substr($str, 0, 1) . str_repeat('*', $len - 2) . substr($str, $len - 1, 1);
    }
    return $return;
}

function getMonth($month)
{
    $return  = $month;
    $arr = [1 => 'Jan', 2 => 'Feb', 3 => 'Mar', 4 => 'Apr', 5 => 'May', 6 => 'Jun', 7 => 'Jul', 8 => 'Aug', 9 => 'Sep', 10 => 'Oct', 11 => 'Nov', 12 => 'Dec'];
    if (isset($arr[$month])) {
        $return = $arr[$month];
    }
    return $return;
}

function getPaymentStatusByJobId($jobId){
    $return = 1;
    $data = CompanyJobFunding::where('company_job_id', $jobId)->first();
    if ($data && $data->status == 1) {
        $return = 0;
    }
    return $return;
}