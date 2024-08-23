<?php

namespace App\Http\Controllers\FrontEnd\Company;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use App\Models\User;
use App\Models\Companies;
use App\Models\CompanyAddress;
use App\Models\CompanyJob;
use App\Models\CompanyJobApplications;
use App\Models\CompanyUser;
use App\Models\Country;
use App\Models\Notifications;
use App\Models\CompanyFaqsTemplates;
use App\Models\CompanyQuestionnaireTemplates;
use App\Models\Admin;
use Exception;
use Auth;
use Response;
use Mail;
use Illuminate\Support\Facades\Session;
use Illuminate\Routing\Route;
use Illuminate\Support\Facades\URL;

class CompanyDashboardController extends Controller
{

    public function showDashboard(Request $request)
    {
        $userId = Auth::user()->id;
        if ($userId) {
            try {
                $companyId=Auth::user()->companyUser->company_id;
                $companyData=Companies::getCompanyDetailsById($companyId);
                $activeJobs=CompanyJob::getActiveJobs($companyId,3);
                $activeJobsCount=CompanyJob::getJobsCountByStatus($companyId,1);
                $closedJobsCount=CompanyJob::getJobsCountByStatus($companyId,4);
                $pausedJobsCount=CompanyJob::getJobsCountByStatus($companyId,3);
                $unpublishedJobsCount=CompanyJob::getJobsCountByStatus($companyId,2);
                $notificationData= Notifications::where('type',1)
                                        ->where('related_id',$companyId)
                                        ->whereNull('deleted_at')->orderBy('created_at','DESC')->limit(4)->get();
                $faqTemplateCount=CompanyFaqsTemplates::getFaqsTemplatesCount($companyId);
                $questionnaireTemplatesCount=CompanyQuestionnaireTemplates::getQuestionnaireTemplatesCount($companyId);
                $firstJobCount=CompanyJob::getJobsCountByStatus($companyId);
                $maximumPoints  = 100;
                $hasVerifiedEmail=0;
                $createdCommunication=0;
                $createdQuesionnaire=0;
                $createdJobs=0;
                if(Auth::user()->is_verify==1){
                  $hasVerifiedEmail = 25;
                }
                if($faqTemplateCount!=0){
                  $createdCommunication = 25;
                }
                if($questionnaireTemplatesCount!=0){
                  $createdQuesionnaire = 25;
                }
                if($firstJobCount!=0){
                  $createdJobs = 25;
                }
               $percentage = ($hasVerifiedEmail+$createdCommunication+$createdQuesionnaire+$createdJobs)*$maximumPoints/100;
                return view('frontend.company.dashboard.dashboard', compact('companyData','notificationData','activeJobs','activeJobsCount','closedJobsCount','pausedJobsCount','unpublishedJobsCount','percentage','faqTemplateCount','questionnaireTemplatesCount','firstJobCount','hasVerifiedEmail'));
            } catch (Exception $e) {
              dd($e);
                return redirect()->route('showMyInfoCompany');
            }
        }
    }

    public function monthlyGraph($duration = '')
    {
        $totalClosedApplication = $totalSale = $totalFans = $dates = [];
        $companyId=Auth::user()->companyUser->company_id;
        if ($duration == 'monthly') {
            $lastSixMonths = Admin::getLastSixMonths();
            krsort($lastSixMonths);
            foreach ($lastSixMonths as $k => $v) {
                $month = date('m', strtotime($v));
                $year = date('Y', strtotime($v));
                //$dates[] = date('M y', strtotime($v));
                $totalClosedApplication[]=[
                    "dates"=>date('M y', strtotime($v)),
                    "totalClosed"=>CompanyJob::getMonthwiseClosedCount($companyId,$month, $year),
                    "totalSubmittals"=>CompanyJobApplications::getMonthwiseJobApplicationCount($companyId,$month, $year,1),
                    "totalApproved"=>CompanyJobApplications::getMonthwiseJobApplicationCount($companyId,$month, $year,3),
                    "totalRejected"=>CompanyJobApplications::getMonthwiseJobApplicationCount($companyId,$month, $year,4),
                    "amountSpent"=>CompanyJob::getMonthwiseAmountSpent($companyId,$month, $year),
                ];
            }
        }
        else if($duration == 'yearly') {
            $lastFiveYears = Admin::getLastFiveYears();
            krsort($lastFiveYears);
            foreach ($lastFiveYears as $k => $v) {
                $year = date('Y', strtotime($v));
                $totalClosedApplication[]=[
                    "dates"=>date('Y', strtotime($v)),
                    "totalClosed"=>CompanyJob::getYearwiseClosedCount($companyId, $year),
                    "totalSubmittals"=>CompanyJobApplications::getYearwiseJobApplicationCount($companyId,$year,1),
                    "totalApproved"=>CompanyJobApplications::getYearwiseJobApplicationCount($companyId,$year,3),
                    "totalRejected"=>CompanyJobApplications::getYearwiseJobApplicationCount($companyId ,$year,4),
                    "amountSpent"=>CompanyJob::getYearwiseAmountSpent($companyId,$year),
                ];
            }
          }
        else{
          $lifeTimeYears=Admin::getLifeTimeYears(Auth::user()->company->created_at);
          krsort($lifeTimeYears);
          foreach ($lifeTimeYears as $k => $v) {
              $year = date('Y', strtotime($v));
              $totalClosedApplication[]=[
                  "dates"=>date('Y', strtotime($v)),
                  "totalClosed"=>CompanyJob::getYearwiseClosedCount($companyId, $year),
                  "totalSubmittals"=>CompanyJobApplications::getYearwiseJobApplicationCount($companyId,$year,1),
                  "totalApproved"=>CompanyJobApplications::getYearwiseJobApplicationCount($companyId,$year,3),
                  "totalRejected"=>CompanyJobApplications::getYearwiseJobApplicationCount($companyId ,$year,4),
                  "amountSpent"=>CompanyJob::getYearwiseAmountSpent($companyId,$year),
              ];
          }
        }
        $json_data = [
            'total_closed_applications' => $totalClosedApplication,
            'status' => true,
        ];
        return Response::json($json_data);
    }
}
