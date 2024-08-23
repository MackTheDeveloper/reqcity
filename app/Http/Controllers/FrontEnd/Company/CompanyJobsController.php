<?php

namespace App\Http\Controllers\FrontEnd\Company;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use App\Models\User;
use App\Models\Artist;
use App\Http\Controllers\API\V1\AuthAPIController;
use App\Http\Controllers\API\V1\LocationAPIController;
use App\Http\Controllers\API\V1\SearchAPIController;
use Exception;
use Auth;
use Mail;
use Socialite;
use Response;
use Agent;
use App\Helpers\StripeHelper;
use Illuminate\Support\Facades\Session;
use App\Traits\ReuseFunctionTrait;
use App\Http\Controllers\API\V1\BlogsAPIController;
use App\Http\Controllers\API\V1\HomePageAPIController;
use App\Http\Controllers\API\V1\PagesAPIController;
use App\Models\Candidate;
use App\Models\Category;
use App\Models\GlobalSettings;
use App\Models\CmsPages;
use App\Models\Companies;
use App\Models\CompanyAddress;
use App\Models\CompanyFaqsTemplates;
use App\Models\CompanyJob;
use App\Models\CompanyJobCommunications;
use App\Models\CompanyJobApplicationQuestionnaire;
use App\Models\CompanyJobFunding;
use App\Models\CompanyJobQuestionnaires;
use App\Models\CompanyQuestionnaires;
use App\Models\CompanyQuestionnaireTemplates;
use App\Models\CompanyQuestionnaireType;
use App\Models\CompanySubscription;
use App\Models\CompanyUser;
use App\Models\Country;
use App\Models\EmailTemplates;
use App\Models\JobFieldOption;
use App\Models\PlanFeatures;
use App\Models\SubscriptionPlan;
use App\Models\UserCards;
use Redirect;

class CompanyJobsController extends Controller
{
    use ReuseFunctionTrait;

    public function showJobDetails()
    {
        /* $companyJob = [
            'id' => 12,
        ];
        Session::put('company_job', $companyJob); */

        $model = new CompanyJob;
        $companyJobId = Session::get('company_job.id');
        $childCategories = array();
        if (isset($companyJobId)) {
            // pre($companyJobId);
            $model = CompanyJob::where('id', $companyJobId)->first();
            $childCategories = Category::getChildCategories($model->job_category_id);
        }
        $userId = Auth::user()->id;
        $companyId = CompanyUser::getCompanyIdByUserId($userId);
        // $companyId = Auth::user()->company->id;
        $jobLocations = CompanyAddress::getAddress($companyId);
        $parentCategories = Category::getParentCategories();
        $jobIndustries = JobFieldOption::getOptions('JOBIN');
        $employmentType = JobFieldOption::getOptions('EMPTY');
        $jobSchedule = JobFieldOption::getOptions('JOBSC');
        $contractType = JobFieldOption::getOptions('CONTY');
        $remoteWork = JobFieldOption::getOptions('REMWK');
        $payOffered = JobFieldOption::getOptions('PAYOF');
        $benifitsOffered = JobFieldOption::getOptions('BENOF');
        $model->job_schedule_ids = explode(',', $model->job_schedule_ids);
        $model->supplemental_pay_offered_ids = explode(',', $model->supplemental_pay_offered_ids);
        $model->benefits_offered_ids = explode(',', $model->benefits_offered_ids);
        $countries = Country::getListForDropdown();
        return view('frontend.company.job.form_job_details', compact('model', 'jobLocations', 'parentCategories', 'childCategories', 'jobIndustries', 'employmentType', 'jobSchedule', 'contractType', 'remoteWork', 'payOffered', 'benifitsOffered', 'countries'));
    }

    public function showJobCommunication()
    {
        $model = new CompanyJobCommunications();
        $modelCompanyJob = new CompanyJob();
        $companyFaqsTemplates = new CompanyFaqsTemplates();
        $companyJobId = Session::get('company_job.id');
        if ($companyJobId) {
            $selectedQuestions = array();
            if (isset($companyJobId)) {
                $userId = Auth::user()->id;
                $companyId = CompanyUser::getCompanyIdByUserId($userId);
                $modelCompanyJob = CompanyJob::where('id', $companyJobId)->first();
                $companyFaqsTemplates = CompanyFaqsTemplates::find($modelCompanyJob->job_communication_template_id);
                if (empty($companyFaqsTemplates))
                    $companyFaqsTemplates = new CompanyFaqsTemplates();
                $model = CompanyJobCommunications::where('company_job_id', $companyJobId)->where('company_faq_id', 0)->get();

                $selectedQuestions = CompanyJobCommunications::getSelectedQuestions($companyJobId);
            }
            $faqTemplates = CompanyFaqsTemplates::getTemplates($companyId);
            return view('frontend.company.job.form_job_communication', compact('model', 'modelCompanyJob', 'companyFaqsTemplates', 'faqTemplates', 'selectedQuestions'));
        } else {
            abort(404, 'Not Found');
        }
    }

    public function addJobDetails(Request $request)
    {
        $data = [];
        $input = $request->all();

        if (!isset($input['hide_compensation_details_to_candidates']))
            $input['hide_compensation_details_to_candidates'] = 'no';
        else
            $input['hide_compensation_details_to_candidates'] = 'yes';

        if (!isset($input['job_schedule_ids']))
            $input['job_schedule_ids'] = array();

        if (!isset($input['supplemental_pay_offered_ids']))
            $input['supplemental_pay_offered_ids'] = array();

        if (!isset($input['benefits_offered_ids']))
            $input['benefits_offered_ids'] = array();


        $companyJobId = Session::get('company_job.id');
        if ($companyJobId) {
            $data = CompanyJob::updateJobDetails($companyJobId, $input);
        }else{
        $data = CompanyJob::addJobDetails($input);
        }
        if (!empty($data['success'])) {
            $companyJob = [
                'id' => $data['companyJobId'],
            ];
            Session::put('company_job', $companyJob);

            $notification = array(
                'message' => config('message.frontendMessages.jobPost.addJobDetails'),
                'alert-type' => 'success'
            );

            if ($input['submit_type'] == '1') {
                $notification = array(
                    'message' => config('message.frontendMessages.jobPost.saveAsDraft'),
                    'alert-type' => 'success'
                );
                return redirect()->route('showDashboard')->with($notification);
            } else {
                return redirect()->route('jobQuestionnaireShow')->with($notification);
            }
        }
    }

    public function updateJobCommunication(Request $request)
    {
        $input = $request->all();
        $companyJobId = Session::get('company_job.id');
        if (isset($input['companyJob']) && isset($input['CompanyJobCommunications'])) {
            $data = CompanyJob::updateJobDetails($companyJobId, $input['companyJob']);
            if ($data['success']) {
                CompanyJobCommunications::addUpdateData($companyJobId, $input['CompanyJobCommunications']);
            }
        }
        $notification = array(
            'message' => config('message.frontendMessages.jobPost.updateJobCommunication'),
            'alert-type' => 'success'
        );

        if ($input['submit_type'] == '1') {
            $notification = array(
                'message' => config('message.frontendMessages.jobPost.saveAsDraft'),
                'alert-type' => 'success'
            );
            return redirect()->route('showDashboard')->with($notification);
        } else {
            return redirect()->route('jobJobReviewAndPaymentShow')->with($notification);
        }
    }

    public function updateJobDetails(Request $request, $id)
    {
        $input = $request->all();
        //pre($input);

        if (!isset($input['hide_compensation_details_to_candidates']))
            $input['hide_compensation_details_to_candidates'] = 'no';
        else
            $input['hide_compensation_details_to_candidates'] = 'yes';

        if (!isset($input['job_schedule_ids']))
            $input['job_schedule_ids'] = array();

        if (!isset($input['supplemental_pay_offered_ids']))
            $input['supplemental_pay_offered_ids'] = array();

        if (!isset($input['benefits_offered_ids']))
            $input['benefits_offered_ids'] = array();

        $data = CompanyJob::updateJobDetails($id, $input);
        
        $notification = array(
            'message' => config('message.frontendMessages.jobPost.updateJobDetails'),
            'alert-type' => 'success'
        );

        if ($input['submit_type'] == '1') {
            $notification = array(
                'message' => config('message.frontendMessages.jobPost.saveAsDraft'),
                'alert-type' => 'success'
            );
            return redirect()->route('showDashboard')->with($notification);
        } else {
            return redirect()->route('jobQuestionnaireShow')->with($notification);
        }
    }

    public function getCommunicationTemplateData(Request $request)
    {
        $input = $request->all();
        $companyJobId = Session::get('company_job.id');
        $templateId = $input['templateId'];
        if (!empty($templateId)) {
            $companyFaqsTemplates = CompanyFaqsTemplates::find($templateId);
            $selectedQuestions = CompanyJobCommunications::getSelectedQuestions($companyJobId);
        } else {
            $companyFaqsTemplates = new CompanyFaqsTemplates();
            $selectedQuestions = array();
        }
        return view('frontend.company.job.components.communication_template_data', compact('companyFaqsTemplates', 'selectedQuestions'));
    }

    public function getSubCategories(Request $request)
    {
        $data['subCategories'] = Category::getChildCategories($request->categoryId);
        return response()->json($data);
    }

    public function addJobFaqs()
    {
        $countFaqs = $_POST['countFaqs'];
        return view('frontend.company.job.components.add-more-faqs', compact('countFaqs'));
    }

    public function showJobReviewAndPayment()
    {
        $userId = Auth::user()->id;
        $companyId = CompanyUser::getCompanyIdByUserId($userId);
        $companyJobId = Session::get('company_job.id');
        if ($companyJobId) {
            $modelCompanyJob = CompanyJob::where('id', $companyJobId)->first();
            // pre($modelCompanyJob->companyAddress->countries->name);
            $companyData = Companies::find($companyId);
            $companyAddressData = CompanyAddress::getSelectedAddress($modelCompanyJob->company_address_id);
            // $companyAddressData = CompanyAddress::getDefaultAddress($companyId);
            $employmentType =  JobFieldOption::getAttrById($modelCompanyJob->job_employment_type_id, 'option');
            $schedule =  JobFieldOption::getAttrById($modelCompanyJob->job_schedule_ids, 'option');
            $contractType =  JobFieldOption::getAttrById($modelCompanyJob->job_contract_id, 'option');
            $remoteWork =  JobFieldOption::getAttrById($modelCompanyJob->job_remote_work_id, 'option');
            $jobPostAmount = GlobalSettings::getSingleSettingVal('job_post_amount');
            $recruiterCommission = GlobalSettings::getSingleSettingVal('job_recruiter_commission');
            $adminCommission = GlobalSettings::getSingleSettingVal('job_admin_comission');
            $totalAmount = $jobPostAmount * $modelCompanyJob->vaccancy;
            return view('frontend.company.job.form_job_review_payment', compact('modelCompanyJob', 'companyData', 'companyAddressData', 'employmentType', 'schedule', 'contractType', 'remoteWork', 'jobPostAmount', 'totalAmount', 'recruiterCommission', 'adminCommission'));
        } else {
            abort(404, 'Not Found');
        }
    }

    public function addJobPay(Request $request)
    {
        $input = $request->all();
        $id = Session::get('company_job.id');
        $input['created_at'] = date("Y-m-d H:i:s");
        $input['updated_at'] = date("Y-m-d H:i:s");
        $data = CompanyJob::updateJobDetails($id, $input);

        $notification = array(
            'message' => config('message.frontendMessages.jobPost.jobPay'),
            'alert-type' => 'success'
        );
        return redirect()->route('jobPaymentConfirmShow')->with($notification);
    }

    public function showJobQuestionnaire()
    {
        $companyJobId = Session::get('company_job.id');
        if ($companyJobId) {
            $companyJobTemplate = "";
            $userId = Auth::user()->id;
            $company_id = CompanyUser::getCompanyIdByUserId($userId);
            $questionnaireTemplate = CompanyQuestionnaireTemplates::where('company_id', $company_id)->get();
            $types = CompanyQuestionnaireType::getData();
            $companyJob = CompanyJob::where('id', $companyJobId)->first();
            if ($companyJob) {
                $companyJobTemplate = $companyJob->job_questionnaire_template_id;
            }
            $model = CompanyJobQuestionnaires::where('company_job_id', $companyJobId)->where('company_questionnaire_id', '0')->get();
            // pre($model);
            $typeChoices = CompanyQuestionnaireType::getHasChoicesType();
            return view('frontend.company.job.form_questionnaire', compact('questionnaireTemplate', 'types', 'model', 'companyJobTemplate', 'typeChoices'));
        } else {
            return abort(404);
        }
    }

    public function getQuestionnaireData(Request $request)
    {
        $input = $request->all();
        $companyJobId = Session::get('company_job.id');
        if ($companyJobId) {
            $templateId = $input['templateId'];
            $data = CompanyQuestionnaires::where('cqt_id', $templateId)->get();
            $selected = CompanyJobQuestionnaires::where('company_job_id', $companyJobId)->where('company_questionnaire_id', '!=', '0')->pluck('company_questionnaire_id')->toArray();
            // pre($selected);
            $types = CompanyQuestionnaireType::getData();
            return view('frontend.company.job.components.questionnaire_template_data', compact('data', 'selected', 'types'));
        } else {
            return abort(404);
        }
    }

    public function updateJobQuestionnaire(Request $request)
    {
        $input = $request->all();
        $companyJobId = Session::get('company_job.id');
        if ($companyJobId) {
            $hasExtraQuestion = $input['hasExtraQuestion'];
            $questionnaireTemplateId = $input['questionnaire_template_id'];
            $companyQuestionnaireId = isset($input['company_questionnaire_id']) ? $input['company_questionnaire_id'] : array();
            $question = $input['question'];
            $option = $input['option'];

            // pre($input);
            $model = CompanyJob::where('id', $companyJobId)->first();
            if ($model) {
                $model->job_questionnaire_template_id = $questionnaireTemplateId;
                $model->save();
                CompanyJobQuestionnaires::addUpdateQuestion($companyJobId, $companyQuestionnaireId, $hasExtraQuestion, $question, $option);
                $notification = array(
                    'message' => config('message.frontendMessages.jobPost.updateJobQuestionnaire'),
                    'alert-type' => 'success'
                );
                if ($input['submit_type'] == '1') {
                    $notification = array(
                        'message' => config('message.frontendMessages.jobPost.saveAsDraft'),
                        'alert-type' => 'success'
                    );
                    return redirect()->route('showDashboard')->with($notification);
                } else {
                    return redirect()->route('jobCommunicationShow')->with($notification);
                }
            }
        } else {
            return abort(404);
        }
    }

    public function showJobPaymentConfirm()
    {
        $companyJobId = Session::get('company_job.id');
        if ($companyJobId) {
            $model = CompanyJob::where('id', $companyJobId)->first();
            return view('frontend.company.job.form_payment', compact('model'));
        } else {
            return abort(404);
        }
    }

    public function jopPostSuccessPayment()
    {
        $companyJobId = Session::get('company_job.id');
        if ($companyJobId) {
            Session::forget('company_job.id');
            $model = CompanyJob::where('id', $companyJobId)->first();
            $payment = CompanyJobFunding::where('company_job_id', $companyJobId)->first();
            $paymentId = $payment->payment_id;
            return view('frontend.company.job.success', compact('paymentId'));
        } else {
            return abort(404);
        }
    }

    public function postJobPaymentConfirm(Request $request)
    {
        $companyJobId = Session::get('company_job.id');
        if ($companyJobId) {
            $userId = Auth::user()->id;
            $companyId = CompanyUser::getCompanyIdByUserId($userId);
            $cardData = CompanyUser::getStripeCustomerIdByUserId($userId);
            // $cardData = UserCards::getUserCardByCompanyId($companyId);
            $model = CompanyJob::where('id', $companyJobId)->first();
            if ($cardData) {
                // pre($cardData);
                $fingerprint = "";
                $url = "";
                $status = '3';
                $amount = $model->total_amount_paid;
                $currency = 'usd';
                // $source = $cardData->card_id;
                $description = "Payment for job post : " . $model->title;
                $customer = User::getAttrById($cardData, 'stripe_customer_id');
                $charge = new StripeHelper;
                $amountCharge = $amount * 100;
                $charge = $charge->createDirectCharge($amountCharge, $currency, $customer, $description);
                if ($charge['status']) {
                    $fingerprint = $charge['data']->source->fingerprint;
                    $url = $charge['data']->receipt_url;
                    $status = '1';
                }
                $insertData = [
                    "company_job_id" => $companyJobId,
                    "amount" => $amount,
                    "payment_id" => $fingerprint,
                    "status" => $status,
                    "receipt_url" => $url,
                ];
                CompanyJobFunding::addData($insertData);
                $input['created_at'] = date("Y-m-d H:i:s");
                $input['updated_at'] = date("Y-m-d H:i:s");
                $data = CompanyJob::updateJobDetails($companyJobId, $input);
                if ($status == '1') {
                    $notification = array(
                        'message' => config('message.frontendMessages.jobPost.paymentConfirmSuccess'),
                        'alert-type' => 'success'
                    );
                    return redirect()->route('jopPostSuccessPayment')->with($notification);
                }
                $notification = array(
                    'message' => config('message.frontendMessages.jobPost.paymentConfirmFailed'),
                    'alert-type' => 'success'
                );
                return redirect()->back()->with($notification);
            }
        } else {
            return abort(404);
        }
    }

    public function getJobDescription(Request $request){
        $data = $request->all();
        $id = $data['id'];
        $job = CompanyJob::where('id', $id)->first();
        $jobDesc = $job->job_description;
        return $jobDesc;
    }

    public function changeJobDescription(Request $request){
        $data = $request->all();
        // pre($data);
        $id = $data['id'];
        CompanyJob::where('id', $id)->update(['job_description' => $data['description']]);
        return Response::json(['success' => true, 'message' => 'Job description updated successfully']);
    }
}
