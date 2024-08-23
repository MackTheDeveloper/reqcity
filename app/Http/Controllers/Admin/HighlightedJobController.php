<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\HighlightedJob;
use App\Models\CompanyJob;
use Illuminate\Http\Request;
use Auth;
use DataTables;
use Carbon\Carbon;
use Response;
use DateTime;
use DatePeriod;
use DateInterval;
use Symfony\Component\Console\Input\Input;

class HighlightedJobController extends Controller
{
    public function index(Request $request)
    {
        $req = $request->all();
        //  $search = (isset($req['search']) ? $req['search'] : '');
        $company = HighlightedJob::getCompanyList();
        return view("admin.highlighted-jobs.index", compact('company'));
    }

    public function list(Request $request)
    {
        $req = $request->all();
        $isDeletable = whoCanCheck(config('app.arrWhoCanCheck'), 'admin_highlighted_jobs_remove');
        $start = $req['start'];
        $length = $req['length'];
        $search = $req['search']['value'];
        $order = $req['order'][0]['dir'];
        $column = $req['order'][0]['column'];
        $orderby = ['id','','companyName', 'jobCategory', 'jobTitle', 'start_date', 'end_date'];

        $total = HighlightedJob::selectRaw('count(*) as total')
            ->whereNull('highlited_jobs.deleted_at');
        $query = HighlightedJob::select('highlited_jobs.*', 'company_jobs.title as jobTitle', 'categories.title as jobCategory', 'companies.name as companyName')
            ->leftJoin("company_jobs", "highlited_jobs.company_job_id", "company_jobs.id")
            ->leftJoin("companies", "highlited_jobs.company_id", "companies.id")
            ->leftJoin("categories", "company_jobs.job_category_id", "categories.id")
            ->whereNull('highlited_jobs.deleted_at');

        $filteredq = HighlightedJob::select('highlited_jobs.*', 'company_jobs.title as jobTitle', 'categories.title as jobCategory', 'companies.name as companyName')
            ->leftJoin("company_jobs", "highlited_jobs.company_job_id", "company_jobs.id")
            ->leftJoin("companies", "highlited_jobs.company_id", "companies.id")
            ->leftJoin("categories", "company_jobs.job_category_id", "categories.id")
            ->whereNull('highlited_jobs.deleted_at');

        //$totalfiltered = $total->total;
        
        if ($search != '') {
            $query->where(function ($query2) use ($search) {
                $query2->where('companies.name', 'like', '%' . $search . '%')
                    ->orWhere('company_jobs.title', 'like', '%' . $search . '%')
                    ->orWhere('categories.title', 'like', '%' . $search . '%');
            });

            $filteredq->where(function ($query2) use ($search) {
                $query2->where('companies.name', 'like', '%' . $search . '%')
                    ->orWhere('company_jobs.title', 'like', '%' . $search . '%')
                    ->orWhere('categories.title', 'like', '%' . $search . '%');
            });
        }
        if (isset($request->company) && $request->company != 'all') {
            $total = $total->where('highlited_jobs.company_id', $request->company);
            $filteredq = $filteredq->where('highlited_jobs.company_id', $request->company);
            $query = $query->where('highlited_jobs.company_id', $request->company);
        }
        if (!empty($request->startDate) && !empty($request->endDate)) {
            $startDate = date($request->startDate);
            $endDate = date($request->endDate);
            $newDate = new DateTime($endDate);
            $newDate->add(new DateInterval('P1D'));

            $total = $total->where(function ($q) use ($startDate, $newDate) {
                $q->whereBetween('highlited_jobs.end_date', [$startDate, $newDate])
                    ->orWhere('highlited_jobs.end_date','=',null);
            });
            $filteredq = $filteredq->where(function ($q) use ($startDate, $newDate) {
                $q->whereBetween('highlited_jobs.end_date', [$startDate, $newDate])
                    ->orWhere('highlited_jobs.end_date','=',null);
            });
            $query = $query->where(function ($q) use ($startDate, $newDate) {
                $q->whereBetween('highlited_jobs.end_date', [$startDate, $newDate])
                    ->orWhere('highlited_jobs.end_date','=',null);;
            });
        }
        if (!empty($request->status) && $request->status != 'all') {
            $status = $request->status;
            if($request->status == 1){
                $total = $total->where(function ($q) use ($status) {
                    $q->where('highlited_jobs.end_date','>',Carbon::now())
                      ->orWhere('highlited_jobs.end_date','=',null);
                });
                $query = $query->where(function ($q) use ($status) {
                    $q->where('highlited_jobs.end_date','>',Carbon::now())
                      ->orWhere('highlited_jobs.end_date','=',null);
                });
                $filteredq = $filteredq->where(function ($q) use ($status) {
                    $q->where('highlited_jobs.end_date','>',Carbon::now())
                        ->orWhere('highlited_jobs.end_date','=',null);
                });
            }
            if($request->status == 2){
                $total = $total->where(function ($q) use ($status) {
                    $q->where('highlited_jobs.end_date','<',Carbon::now());
                });
                $query = $query->where(function ($q) use ($status) {
                    $q->where('highlited_jobs.end_date','<',Carbon::now());
                });
                $filteredq = $filteredq->where(function ($q) use ($status) {
                    $q->where('highlited_jobs.end_date','<',Carbon::now());
                });
            }
        }
        $total = $total->first();
        $recordCount = $filteredq->selectRaw('count(*) as total')->first();
        $totalfiltered = $recordCount->total;
        $query = $query->orderBy($orderby[$column], $order)->offset($start)->limit($length)->get();
        $data = [];
        foreach ($query as $key => $value) {
            $startDate = (!isset($value->start_date))? "N/A":getFormatedDate($value->start_date);
            $endDate   = (!isset($value->end_date))? "N/A":getFormatedDate($value->end_date);
            $action = '';
            $delete = ($isDeletable) ? '<li class="nav-item">'
                . '<a class="nav-link markRemoved" data-id="' . $value->id . '">Remove</a>'
                . '</li>' : '';
            if($delete){
                $action .= '<div class="d-inline-block dropdown">'
                    . '<button type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" class="btn-shadow dropdown-toggle btn btn-primary">'
                    . '<span class="btn-icon-wrapper pr-2 opacity-7">'
                    . '<i class="fa fa-cog fa-w-20"></i>'
                    . '</span>'
                    . '</button>'
                    . '<div tabindex="-1" role="menu" aria-hidden="true" class="dropdown-menu dropdown-menu-right">'
                    . '<ul class="nav flex-column">'
                    . $delete
                    . '</ul>'
                    . '</div>'
                    . '</div>';
            }
            $data[] = [$value->id,$action,$value->companyName, $value->jobCategory, $value->jobTitle, $startDate,$endDate];
        }
        $json_data = array(
            "draw" => intval($_REQUEST['draw']),
            "recordsTotal" => intval($total->total),
            "recordsFiltered" => intval($totalfiltered),
            "data" => $data,
        );
        return Response::json($json_data);
    }


    public function jobList(Request $request)
    {
        $req = $request->all();
        $start = $req['start'];
        $length = $req['length'];
        $search = $req['search']['value'];
        $order = $req['order'][0]['dir'];
        $column = $req['order'][0]['column'];
        $orderby = ['id', 'companyName', 'jobCategory', 'jobTitle', 'start_date', 'end_date'];
        $existHighlightedJobs = HighlightedJob::getCompanyJobIds();

        $total = CompanyJob::selectRaw('count(*) as total')
            ->where('status',1)
            ->whereNull('company_jobs.deleted_at')
            ->whereNotIn('company_jobs.id',$existHighlightedJobs)
            ->first();
        $query = CompanyJob::select('company_jobs.*', 'company_jobs.title as jobTitle', 'categories.title as jobCategory', 'companies.name as companyName')
            ->leftJoin("companies", "company_jobs.company_id", "companies.id")
            ->leftJoin("categories", "company_jobs.job_category_id", "categories.id")
            ->where("company_jobs.status", 1)
            ->whereNotIn('company_jobs.id',$existHighlightedJobs)
            ->whereNull('company_jobs.deleted_at');

        $filteredq = CompanyJob::select('company_jobs.*', 'company_jobs.title as jobTitle', 'categories.title as jobCategory', 'companies.name as companyName')
            ->leftJoin("companies", "company_jobs.company_id", "companies.id")
            ->leftJoin("categories", "company_jobs.job_category_id", "categories.id")
            ->where("company_jobs.status", 1)
            ->whereNotIn('company_jobs.id',$existHighlightedJobs)
            ->whereNull('company_jobs.deleted_at');

        $totalfiltered = $total->total;
        if ($search != '') {
            $query->where(function ($query2) use ($search) {
                $query2->where('companies.name', 'like', '%' . $search . '%')
                    ->orWhere('company_jobs.title', 'like', '%' . $search . '%')
                    ->orWhere('categories.title', 'like', '%' . $search . '%');
            });

            $filteredq->where(function ($query2) use ($search) {
                $query2->where('companies.name', 'like', '%' . $search . '%')
                    ->orWhere('company_jobs.title', 'like', '%' . $search . '%')
                    ->orWhere('categories.title', 'like', '%' . $search . '%');
            });
        }
        if (isset($request->company) && $request->company != 'all') {
            $filteredq = $filteredq->where('company_jobs.company_id', $request->company);
            $query = $query->where('company_jobs.company_id', $request->company);
        }

        $recordCount = $filteredq->selectRaw('count(*) as total')->first();
        $totalfiltered = $recordCount->total;

        $query = $query->orderBy($orderby[$column], $order)->offset($start)->limit($length)->get();
        $data = [];
        foreach ($query as $key => $value) {
            $check  = '<input name="id[]" value="' . $value->id . '" id="id_' . $value->id . '" type="checkbox" class="recruiterCheck" />';
            $data[] = [$value->id,$check,$value->companyName, $value->jobCategory, $value->jobTitle];
        }
        $json_data = array(
            "draw" => intval($_REQUEST['draw']),
            "recordsTotal" => intval($total->total),
            "recordsFiltered" => intval($totalfiltered),
            "data" => $data,
        );
        return Response::json($json_data);
    }


    //showing a view for add a job
    public function addJob(Request $request)
    {
        $req = $request->all();
        $company = CompanyJob::getCompanyList();
        return view("admin.highlighted-jobs.addJobs", compact('company'));
    }

    //Get Job Ids for save through checkbox
    public function getJobIds(Request $request)
    {
        $checkedIds = $request['checkedIds'];
        $retunIds = "";
        $search = $request['search'];
        $company = $request['company'];
        $returnIds = "";
        $existHighlightedJobs = HighlightedJob::getCompanyJobIds();

        $query = CompanyJob::select('company_jobs.*', 'company_jobs.title as jobTitle', 'categories.title as jobCategory', 'companies.name as companyName')
            ->leftJoin("companies", "company_jobs.company_id", "companies.id")
            ->leftJoin("categories", "company_jobs.job_category_id", "categories.id")
            ->where("company_jobs.status", 1)
            ->whereNotIn('company_jobs.id',$existHighlightedJobs)
            ->whereNull('company_jobs.deleted_at');

        if ($search != '') {
            $query->where(function ($query2) use ($search) {
                $query2->where('companies.name', 'like', '%' . $search . '%')
                    ->orWhere('company_jobs.title', 'like', '%' . $search . '%')
                    ->orWhere('categories.title', 'like', '%' . $search . '%');
            });
        }
        if (isset($company) && $company != 'all') {
            $query = $query->where('company_jobs.company_id', $company);
        }

        if ($checkedIds[0] == "selectAll") {
            $retunIds = $query->pluck('company_jobs.id')->toArray();
        } else {
            $retunIds = $query->whereIn('company_jobs.id', $checkedIds)->pluck('company_jobs.id')->toArray();
        }
        $json_data = array(
            "Ids" => $retunIds,
        );
        return $json_data;
        
    }

    // save records of highlighted Jobs
    public function storeHighlightedJob(Request $request)
    {
        $req = $request->all();
        $ids = $request['checkedValues'];
        if(isset($ids)){
            $ids =  explode(",",$ids);
        }
        $fromDate = $request['fromDate'];
        $toDate = $request['toDate'];
        foreach($ids as $id){
            $companyJobs = CompanyJob::where('id',$id)->first();
            $model = new HighlightedJob;
            $model->company_id = $companyJobs->company_id;
            $model->company_job_id = $id;
            $model->start_date = $fromDate;
            $model->end_date = $toDate;
            $model->created_at = Carbon::now();
            $model->created_by = Auth::guard('admin')->user()->id;
            $model->save();
        }
        if($ids){
            $result['status'] = 'true';
            $result['msg'] = "Highlighted Jobs Added successfully!";
            return $result;
        }else{
            $result['status'] = 'false';
            $result['msg'] = "Something went wrong!!";
            return $result;
        }
    }    

    //make soft delete highlight jobs (remove) 
    public function markAsRemove(Request $request)
    {
        $model = HighlightedJob::where('id', $request->id)->first();
        if (!empty($model)) {
            $model->updated_at = Carbon::now();
            $model->deleted_at = Carbon::now();
            $model->save();
            $result['status'] = 'true';
            $result['msg'] = "Highlighted Job Remove successfully!";
            return $result;
        } else {
            $result['status'] = 'false';
            $result['msg'] = "Something went wrong!!";
            return $result;
        }
    }
}

