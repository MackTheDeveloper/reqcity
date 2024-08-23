<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Admin;
use App\Models\AdminCommission;
use App\Models\Candidate;
use App\Models\User;
use App\Models\CmsPages;
use App\Models\Companies;
use App\Models\CompanyJob;
use App\Models\CompanyJobApplication;
use App\Models\CompanyJobFunding;
use App\Models\CompanyTransaction;
use App\Models\Recruiter;
use App\Models\RecruiterPayouts;
use App\Models\RecruiterTransaction;
use DB;
use Response;

class DashboardController extends Controller
{
    /* ###########################################
    // Function: Dashboard
    // Description: Display analytical data for admin
    // Parameter: No Parameter
    // ReturnType: view
    */ ###########################################
    public function dashboard()
    {
        try {
            $todayCounts = $this->getTodayCounts();
            $thisMonthCounts = $this->getRangeDateCounts();
            $topRecruiters = CompanyJobApplication::topRecruiters(5);
            $topCompanies = CompanyJobApplication::topCompanies(5);
            // pre($topCompanies);
            return view('admin.dashboard', [
                'todayCounts' => $todayCounts, 
                'thisMonthCounts' => $thisMonthCounts,
                'topRecruiters' => $topRecruiters,
                'topCompanies' => $topCompanies,
            ]);
        } catch (\Exception $e) {
            pre($e->getMessage());
        }
    }

    public function getTodayCounts()
    {
        $companyCount = Companies::getCountDashboard();
        $recruiterCount = Recruiter::getCountDashboard();
        $candidateCount = Candidate::getCountDashboard();
        $companyJobCount = CompanyJob::getCountDashboard();
        $approvedApp = CompanyJobApplication::getCountDashboard(3);
        $rejectedApp = CompanyJobApplication::getCountDashboard(4);
        $jobFunding = CompanyJobFunding::getCountDashboard();
        $paymentDue = AdminCommission::getCountDashboard();
        $array = [
            [
                "name" => "New Companies",
                "count" => getFormatedAmount($companyCount,0),
                "icon" => "fa fa-building"
            ], [
                "name" => "New Recruiters",
                "count" => getFormatedAmount($recruiterCount,0),
                "icon" => "fa fa-user-tie"
            ], [
                "name" => "New Candidates",
                "count" => getFormatedAmount($candidateCount,0),
                "icon" => "fa fa-users"
            ], [
                "name" => "New Jobs",
                "count" => getFormatedAmount($companyJobCount,0),
                "icon" => "fa fa-briefcase"
            ], [
                "name" => "Today's Approved Jobs",
                "count" => getFormatedAmount($approvedApp,0),
                "icon" => "fa fa-thumbs-up"
            ], [
                "name" => "Today's Rejected Jobs",
                "count" => getFormatedAmount($rejectedApp,0),
                "icon" => "fa fa-thumbs-down"
            ], [
                "name" => "Today's Job Funds",
                "count" => "$".getFormatedAmount($jobFunding,2),
                "icon" => "fa fa-dollar-sign"
            ], [
                "name" => "Total Payment Due",
                "count" => "$".getFormatedAmount($paymentDue,2),
                "icon" => "fa fa-credit-card"
            ]
        ];

        return $array;
    }

    public function getRangeDateCounts($from="",$to="")
    {
        if ($from=="" && $to=="") {
            $from = date('Y-m-').'01';
            $to = date('Y-m-d');
        }
        $to = date('Y-m-d', strtotime($to. ' + 1 days'));
        $companyCount = Companies::getCountDashboard($from, $to);
        $recruiterCount = Recruiter::getCountDashboard($from, $to);
        $candidateCount = Candidate::getCountDashboard($from, $to);
        $companyJobCount = CompanyJob::getCountDashboard($from, $to);
        $approvedApp = CompanyJobApplication::getCountDashboard(3,$from, $to);
        $rejectedApp = CompanyJobApplication::getCountDashboard(4,$from, $to);
        $jobFunding = CompanyJobFunding::getCountDashboard($from, $to);
        $paymentPaid = RecruiterPayouts::getCountDashboard($from, $to);
        $array = [
            [
                "id" => "countBox1",
                "name" => "Companies",
                "count" => getFormatedAmount($companyCount,0),
                "icon" => "fa fa-building"
            ], [
                "id" => "countBox2",
                "name" => "Recruiters",
                "count" => getFormatedAmount($recruiterCount,0),
                "icon" => "fa fa-user-tie"
            ], [
                "id" => "countBox3",
                "name" => "Candidates",
                "count" => getFormatedAmount($candidateCount,0),
                "icon" => "fa fa-users"
            ], [
                "id" => "countBox4",
                "name" => "Jobs",
                "count" => getFormatedAmount($companyJobCount,0),
                "icon" => "fa fa-briefcase"
            ], [
                "id" => "countBox5",
                "name" => "Approved Jobs",
                "count" => getFormatedAmount($approvedApp,0),
                "icon" => "fa fa-thumbs-up"
            ], [
                "id" => "countBox6",
                "name" => "Rejected Jobs",
                "count" => getFormatedAmount($rejectedApp,0),
                "icon" => "fa fa-thumbs-down"
            ], [
                "id" => "countBox7",
                "name" => "Job Funds",
                "count" => "$".getFormatedAmount($jobFunding,2),
                "icon" => "fa fa-dollar-sign"
            ], [
                "id" => "countBox8",
                "name" => "Payment Paid",
                "count" => "$".getFormatedAmount($paymentPaid,2),
                "icon" => "fa fa-money-bill"
            ]
        ];

        return $array;
    }

    public function dashboardFilter(Request $request)
    {
        $startDate = date('Y-m-d', strtotime($request->from_date));
        $endDate = date('Y-m-d', strtotime($request->to_date));
        $return = $this->getRangeDateCounts($startDate, $endDate);
        return Response::json($return);
    }


    public function monthlyGraph($duration = '')
    {
        $totalCompanies = $totalCandidates = $totalRecruiters = $dates = [];
        if ($duration == 'daily') {
            $lastFifteenDays = Admin::getLastFifteenDays();
            krsort($lastFifteenDays);
            foreach ($lastFifteenDays as $k => $v) {
                $dates[] = date('d M', strtotime($v));
                $totalCompanies[]  = Companies::getCountDashboardGraph($duration,$v);
                $totalRecruiters[] = Recruiter::getCountDashboardGraph($duration, $v);
                $totalCandidates[] = Candidate::getCountDashboardGraph($duration, $v);
            }
        } else if ($duration == 'monthly') {
            $lastTwelveMonths = Admin::getLastTwelveMonths();
            krsort($lastTwelveMonths);
            foreach ($lastTwelveMonths as $k => $v) {
                $dates[] = date('M y', strtotime($v));
                $totalCompanies[]  = Companies::getCountDashboardGraph($duration, $v);
                $totalRecruiters[] = Recruiter::getCountDashboardGraph($duration, $v);
                $totalCandidates[] = Candidate::getCountDashboardGraph($duration, $v);
            }
        } else {
            $lastFiveYears = Admin::getLastFiveYears();
            krsort($lastFiveYears);
            foreach ($lastFiveYears as $k => $v) {
                $dates[] = date('Y', strtotime($v));
                $totalCompanies[]  = Companies::getCountDashboardGraph($duration, $v);
                $totalRecruiters[] = Recruiter::getCountDashboardGraph($duration, $v);
                $totalCandidates[] = Candidate::getCountDashboardGraph($duration, $v);
            }
        }
        $json_data = [
            'dates_array' => $dates,
            'total_companies' => $totalCompanies,
            'total_recruiter' => $totalRecruiters,
            'total_candidates' => $totalCandidates,
            'status' => true,
        ];

        return Response::json($json_data);
    }

    public function revenuePayoutGraph($duration = '')
    {
        $totalCompanies = $totalCandidates = $totalRecruiters = $dates = [];
        if ($duration == 'monthly') {
            $lastTwelveMonths = Admin::getLastTwelveMonths();
            krsort($lastTwelveMonths);
            foreach ($lastTwelveMonths as $k => $v) {
                $dates[] = date('M y', strtotime($v));
                $countJobFunds[]  = CompanyJobFunding::getCountDashboardGraph($duration, $v);
                $countCompSubsc[] = CompanyTransaction::getCountDashboardGraph($duration, $v);
                $countRecrSubsc[] = RecruiterTransaction::getCountDashboardGraph($duration, $v);
                $countAdminComm[] = AdminCommission::getCountDashboardGraph($duration, $v);
                $countPayout[] = RecruiterPayouts::getCountDashboardGraph($duration, $v);
            }
        } else {
            $lastFiveYears = Admin::getLastFiveYears();
            krsort($lastFiveYears);
            foreach ($lastFiveYears as $k => $v) {
                $dates[] = date('Y', strtotime($v));
                $countJobFunds[]  = CompanyJobFunding::getCountDashboardGraph($duration, $v);
                $countCompSubsc[] = CompanyTransaction::getCountDashboardGraph($duration, $v);
                $countRecrSubsc[] = RecruiterTransaction::getCountDashboardGraph($duration, $v);
                $countAdminComm[] = AdminCommission::getCountDashboardGraph($duration, $v);
                $countPayout[] = RecruiterPayouts::getCountDashboardGraph($duration, $v);
            }
        }
        $json_data = [
            'dates_array' => $dates,
            'count_job_funds' => $countJobFunds,
            'count_comp_subsc' => $countCompSubsc,
            'count_recr_subsc' => $countRecrSubsc,
            'count_admin_comm' => $countAdminComm,
            'count_payout' => $countPayout,
            'status' => true,
        ];

        return Response::json($json_data);
    }
}
