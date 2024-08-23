<?php

namespace App\Http\Controllers\FrontEnd;

use App\Http\Controllers\Controller;
use App\Helpers\StripeHelper;
use App\Models\Companies;
use App\Models\CompanySubscription;
use App\Models\CompanyTransaction;
use App\Models\EmailTemplates;
use App\Models\GlobalSettings;
use App\Models\Recruiter;
use App\Models\RecruiterSubscription;
use App\Models\RecruiterTransaction;
use App\Models\ScheduledSubscription;
use App\Models\SubscriptionPlan;
use App\Models\User;
use App\Models\UserCards;
use Illuminate\Http\Request;
use Stripe;

class StripeController extends Controller{

    public function index(){
        // // Create Customer
        // $email = "dilpesh.magneto@gmail.com";
        // $this->addCustomer($email,"recruiter");
        
        // // Create Subscription
        // $customerId = "cus_KtXH2Zo1LYIT8n";
        // $planId = "price_1KBXbhDMTFXBNFz5Dqx6htKb";
        // $this->addPlanToCustomer($customerId,$planId,10);

        $subscription = "sub_1KEoMXDMTFXBNFz5eGUBxStD";
        // $this->updateSubscription($subscription,1);
    }

    public function addCustomer($userId){
        $userData = User::getUserForStripeCustomer($userId);
        $stripeCustomer = User::getAttrById($userId, 'stripe_customer_id');
        if (empty($stripeCustomer)) {
            $data = [
                'email' => $userData['email'],
                'name' => $userData['name'],
                'description' => $userData['role_name']
            ];
            $stripeHelper = new StripeHelper;
            $customer = $stripeHelper->createCustomer($data);
            if ($customer['status']) {
                $customerId = $customer['data']->id;
                User::where('id', $userId)->update(['stripe_customer_id'=> $customerId]);
                return 'true';
            }else{
                return $customer['error'];
            }
        }else{
            return 'true';
        }
    }

    public function addPlanToCustomer($userId)
    {
        $stripeCustomer = User::getAttrById($userId, 'stripe_customer_id');
        $subscriptionPlanId = User::getAttrById($userId, 'current_subscription');
        $subscriptionPlan = SubscriptionPlan::where('id', $subscriptionPlanId)->first();
        $data = [
            'stripe_customer_id' => $stripeCustomer,
            'stripe_plan_id' => $subscriptionPlan->stripe_price_id,
            'trial_period_days' => $subscriptionPlan->trial_period?:'0',
        ];
        $stripeHelper = new StripeHelper;
        $subscription = $stripeHelper->createSubscription($data);
        // pre($subscription);
        if ($subscription['status'] == 0) {
            // Session::flash('invalid_card', $subscription['error']);
            // return redirect()->back()->withInput($request->all());
            return $subscription['error'];
            exit;
        }
        
        $subscriptionId = $subscription['data']->id;
        $subscriptionItem = $subscription['data']->items->data[0]->id;
        $trialStart = $subscription['data']->trial_start;
        $trialEnd = $subscription['data']->trial_end;
        $status = $subscription['data']->status;
        $amount = $subscription['data']->plan->amount;
        $amount = $amount/100;
        $interval = $subscription['data']->plan->interval;
        $periodStart = $subscription['data']->current_period_start;
        $periodEnd = $subscription['data']->current_period_end;

        $roleId = User::getAttrById($userId, 'role_id');
        $email = User::getAttrById($userId, 'email');
        // Insert in DB
        if ($roleId=="4") {
            $subscriptionNumber = RecruiterSubscription::getNewSubscriptionNumber();
            $subscriptionNew = new RecruiterSubscription();
            $subscriptionNew->plan_id = $subscriptionPlanId;
            $subscriptionNew->subscription_number = $subscriptionNumber;
            $subscriptionNew->recruiter_id = $userId;
            $subscriptionNew->email = $email;
            $subscriptionNew->plan_type = $interval;
            $subscriptionNew->amount = $amount;
            $subscriptionNew->status = 1;
            $subscriptionNew->payment_id = 1;
            $subscriptionNew->stripe_subscription_id = $subscriptionId;
            $subscriptionNew->stripe_item_id = $subscriptionItem;
            $subscriptionNew->trial_start = $trialStart;
            $subscriptionNew->trial_end = $trialEnd;
            $subscriptionNew->stripe_status = $status;
            $subscriptionNew->save();
        }else{
            $subscriptionNumber = CompanySubscription::getNewSubscriptionNumber();
            $subscriptionNew = new CompanySubscription();
            $subscriptionNew->plan_id = $subscriptionPlanId;
            $subscriptionNew->subscription_number = $subscriptionNumber;
            $subscriptionNew->company_id = $userId;
            $subscriptionNew->email = $email;
            $subscriptionNew->plan_type = $interval;
            $subscriptionNew->amount = $amount;
            $subscriptionNew->status = 1;
            $subscriptionNew->payment_id = 1;
            $subscriptionNew->stripe_subscription_id = $subscriptionId;
            $subscriptionNew->stripe_item_id = $subscriptionItem;
            $subscriptionNew->trial_start = $trialStart;
            $subscriptionNew->trial_end = $trialEnd;
            $subscriptionNew->stripe_status = $status;
            $subscriptionNew->save();
        }
        $user = User::find($userId);
        if ($user) {
            $user->has_yearly_subscription = 0;
            if ($interval == 'year') {
                $user->has_yearly_subscription=1;
            }
            $user->current_subscription_id = $subscriptionNew->id;
            $user->current_subscription = $subscriptionPlanId;
            $user->subscription_expire_at = date('Y-m-d', $periodEnd);
            $user->save();
        }
        // has_yearly_subscription
        // pre($subscription);
        // pre($subscriptionItem);
        // return $customer->id;
        return 'true';
    }

    public function addCardToCustomer($card,$userId){

        $card2 =  array(
            "number" => $card['card_no'], //"4242424242424242",
            "exp_month" => $card['expiry_month'], //Future date
            "exp_year" => $card['expiry_year'], //Future date
            "cvc" => $card['cvc_code'],  // any 3 digit
            "name" => $card['card_name'],
        );
        $stripeHelper = new StripeHelper;
        $token = $stripeHelper->createCardToken($card2);
        if ($token['status'] == 0) {
            // Session::flash('invalid_card', $token['error']);
            // return redirect()->back()->withInput($request->all());
            return $token['error'];
            exit;
        }
        $stripeCustomer = User::getAttrById($userId, 'stripe_customer_id');
        $source = $stripeHelper->addCardToCustomer($stripeCustomer, $token['data']->id, true);
        if ($source['status'] == 0) {
            // Session::flash('invalid_card', $source['error']);
            // return redirect()->back()->withInput($request->all());
            return $token['error'];
            exit;
        }

        // if ($supplier->card &&  $supplier->card->stripe_card_id) {
        //     $StripeHelper->deleteCard($supplier->stripe_customer_id, $supplier->card->stripe_card_id);
        //     \App\SupplierCard::where('supplier_id', $supplier->supplier_id)->delete();
        // }
        $supplierCard = new UserCards();
        $supplierCard->user_id = $userId;
        $supplierCard->card_name = $card['card_name'];
        $supplierCard->card_number = $token['data']->card->last4;
        $supplierCard->exp_month = $token['data']->card->exp_month;
        $supplierCard->exp_year = $token['data']->card->exp_year;
        $supplierCard->brand = $token['data']->card->brand;
        $supplierCard->card_id = $token['data']->card->id;
        $supplierCard->is_default = '1';
        $supplierCard->save();
        // Session::flash('success', "Card saved successfully.");
        return 'true';
    }

    public function updateSubscription($subscriptionId,$userId,$planId){
        $stripeHelper = new StripeHelper;
        $oldSubscription = $stripeHelper->cancelSubscription($subscriptionId);
        if ($oldSubscription['status'] == 0) {
            // Session::flash('invalid_card', $oldSubscription['error']);
            // return redirect()->back()->withInput($request->all());
            return $oldSubscription['error'];
            exit;
        }
        $endDate = $oldSubscription['data']->current_period_end +1;

        $stripeCustomer = User::getAttrById($userId, 'stripe_customer_id');
        // $subscriptionPlanId = User::getAttrById($userId, 'current_subscription');
        $subscription = $stripeHelper->scheduleSubscription($stripeCustomer, $endDate, $planId);
        // ScheduledSubscription
        $subscriptionPlanId = SubscriptionPlan::getSubscriptionByPlanId($planId);
        $subscriptionAmount = SubscriptionPlan::getSubscriptionByPlanId($planId, 'price');
        $subscriptionType = SubscriptionPlan::getSubscriptionByPlanId($planId, 'plan_type');
        $sched = new ScheduledSubscription();
        $sched->shed_sub_id = $subscription['data']->id;
        $sched->user_id = $userId;
        $sched->scheduled_date = $endDate;
        $sched->amount = $subscriptionAmount;
        $sched->type = ($subscriptionType == 'yearly') ? 'year' : 'month';
        $sched->subscription_plan_id = $subscriptionPlanId;
        if ($sched->save()) {
            $user = User::find($userId);
            if ($user) {
                $user->has_yearly_subscription = ($subscriptionType=='yearly')?1:0;
                $user->save();
            }
        }
        return true;
    }

    public function cancelSubscription($subscriptionId,$userId)
    {
        $stripeHelper = new StripeHelper;
        $subscription = $stripeHelper->cancelSubscription($subscriptionId);
        if ($subscription['status'] == 0) {
            // Session::flash('invalid_card', $subscription['error']);
            // return redirect()->back()->withInput($request->all());
            return $subscription['error'];
            exit;
        }
        $endDate = $subscription['data']->current_period_end;
        $user = User::find($userId);
        if ($user) {
            $user->subscription_expire_at = date('Y-m-d', $endDate);
            $user->is_subscription_cancelled = 1;
            $user->save();
        }

        // $subscriptionId = $subscription['data']->id;

        return true;
    }

    public function cancelScheduledSubscription($subscriptionId)
    {
        $stripeHelper = new StripeHelper;
        $subscription = $stripeHelper->cancelScheduledSubscription($subscriptionId);
        if ($subscription['status'] == 0) {
            // Session::flash('invalid_card', $subscription['error']);
            // return redirect()->back()->withInput($request->all());
            return $subscription['error'];
            exit;
        }
        // $endDate = $subscription['data']->current_period_end;
        $subsc = ScheduledSubscription::where('shed_sub_id', $subscriptionId)->first();
        if ($subsc) {
            $subsc->activated = 2;
            $subsc->save();
            $user = User::find($subsc->user_id);
            // $subsc->subscription_expire_at = date('Y-m-d', $endDate);
            if ($user) {
                $user->is_subscription_cancelled = 1;
                $user->save();
            }
        }
        return true;
    }

    public function webhook(Request $request)
    {
        // Set your secret key. Remember to switch to your live secret key in production!
        // See your keys here: https://dashboard.stripe.com/account/apikeys
        $stripeSecret = GlobalSettings::getSingleSettingVal('STRIPE_SECRET');
        Stripe\Stripe::setApiKey($stripeSecret);

        // If you are testing your webhook locally with the Stripe CLI you
        // can find the endpoint's secret by running `stripe listen`
        // Otherwise, find your endpoint's secret in your webhook settings in the Developer Dashboard
        // $endpoint_secret = env('STRIPE_ENDPOINT_SECRET');
        $endpoint_secret = GlobalSettings::getSingleSettingVal('STRIPE_ENDPOINT_SECRET');

        $payload = @file_get_contents('php://input');

        // $myfile = fopen("stripe.txt", "w") or die("Unable to open file!");
        // $txt = $payload;
        // fwrite($myfile, $txt);
        // fclose($myfile);

        $sig_header = $_SERVER['HTTP_STRIPE_SIGNATURE'];
        $event = null;

        try {
            $event = \Stripe\Webhook::constructEvent(
                $payload,
                $sig_header,
                $endpoint_secret
            );
        } catch (\UnexpectedValueException $e) {
            // Invalid payload
            http_response_code(400);
            exit();
        } catch (\Stripe\Exception\SignatureVerificationException $e) {
            // Invalid signature
            http_response_code(400);
            exit();
        }

        if (in_array($event->type,['invoice.payment_succeeded', 'invoice.payment_failed'])) {
            $eventData = $event->data->object;
    
            $invoiceId = $eventData->id;
            $customerId = $eventData->customer;
            $currency = $eventData->currency;
            $amount_due = $eventData->amount_due / 100;
            $amount_paid = $eventData->amount_paid / 100;
            $billing_reason = $eventData->billing_reason;
            $charge = $eventData->charge;
            $status = $eventData->status;
            $subscription = $eventData->subscription;
            $invoice_pdf = $eventData->invoice_pdf;
            $invoice_number = $eventData->number;
            $invoice_date = date('Y-m-d H:i:s', $eventData->created);
            $userData = User::getUserByStripeCustomerId($customerId);
            $periodEnd = $eventData->lines->data[0]->period->end;
            $planDesc = $eventData->lines->data[0]->description;
            $planDesc = explode(' × ', $planDesc);
            $planDesc = end($planDesc);
            // $eventData = customer
            if ($userData) {
                if ($userData['role_id'] == "4") {
                    $transaction = RecruiterTransaction::where('invoice_id', $invoiceId)->first();
                    if(empty($transaction)){
                        $transaction = new RecruiterTransaction();    
                    }                    
                    $transaction->recruiter_id = $userData['id'];
                    $transaction->name = $userData['name'];
                    $transaction->email = $userData['email'];
                    // $transaction->payment_id = $subscriptionPlanId;
                    $transaction->subscription_plan_id = $userData['current_subscription'];
                    $transaction->invoice_id = $invoiceId;
                    $transaction->invoice_number = $invoice_number;
                    $transaction->invoice_date = $invoice_date;
                    $transaction->amount = $amount_due;
                    $transaction->amount_due = $amount_due;
                    $transaction->amount_paid = $amount_paid;
                    $transaction->billing_reason = $billing_reason;
                    $transaction->currency = $currency;
                    $transaction->charge_id = $charge;
                    $transaction->payment_status = $status;
                    $transaction->subscription_id = $subscription;
                    $transaction->invoice_pdf_url = $invoice_pdf;
                    $transaction->save();

                    // Send Notification Mail to Recruiter
                    $slug = 'recruiter-subscription-related-event';
                    $data = ['recruiterId'=>Recruiter::getReruiterIdByUserId($userData['id']),
                        'plan_name'=> $planDesc,
                        'subscription'=>$subscription,
                        'invoice_url'=> $invoice_pdf,
                    ];
                    EmailTemplates::sendNotificationMailRecruiter($slug,$data);
                } else {
                    $transaction = CompanyTransaction::where('invoice_id', $invoiceId)->first();
                    if(empty($transaction)){
                        $transaction = new CompanyTransaction();    
                    }
                    $transaction->company_id = $userData['id'];
                    $transaction->name = $userData['name'];
                    $transaction->email = $userData['email'];
                    // $transaction->payment_id = $subscriptionPlanId;
                    $transaction->subscription_plan_id = $userData['current_subscription'];
                    $transaction->invoice_id = $invoiceId;
                    $transaction->invoice_number = $invoice_number;
                    $transaction->invoice_date = $invoice_date;
                    $transaction->amount = $amount_due;
                    $transaction->amount_due = $amount_due;
                    $transaction->amount_paid = $amount_paid;
                    $transaction->billing_reason = $billing_reason;
                    $transaction->currency = $currency;
                    $transaction->charge_id = $charge;
                    $transaction->payment_status = $status;
                    $transaction->subscription_id = $subscription;
                    $transaction->invoice_pdf_url = $invoice_pdf;
                    $transaction->save();

                    // Send Notification Mail to Company
                    $slug = 'company-subscription-related-event';
                    $data = [
                        'companyID' => Companies::getCompanyIdByUserId($userData['id']),
                        'plan_name' => $planDesc,
                        'subscription' => $subscription,
                        'invoice_url' => $invoice_pdf,
                    ];
                    EmailTemplates::sendNotificationMailCompany($slug, $data);
                }
                // subscription_expire_at
                $user = User::find($userData['id']);
                if ($user && $event->type== "invoice.payment_succeeded") {
                    $user->subscription_expire_at = date('Y-m-d',$periodEnd);
                    $user->save();
                }
            }
        }

        if ($event->type=='customer.subscription.created') {
            $eventData = $event->data->object;
            $customerId = $eventData->customer;
            $userData = User::getUserByStripeCustomerId($customerId);

            $roleId = $userData['role_id'];
            $email = $userData['email'];
            $userId = $userData['id'];
            // $planId = $eventData->items->data[0]->price->id;
            $subscriptionId = $eventData->id;
            $subscriptionItem = $eventData->items->data[0]->id;
            $trialStart = $eventData->trial_start;
            $trialEnd = $eventData->trial_end;
            $status = $eventData->status;
            $amount = $eventData->plan->amount;
            $amount = $amount / 100;
            $interval = $eventData->plan->interval;
            $planId = $eventData->plan->id;
            $schedule = $eventData->schedule;

            if (!empty($schedule)) {
                $scheduleData = ScheduledSubscription::where('shed_sub_id', $schedule)->first();
                if ($scheduleData) {
                    $scheduleData->subscription_id = $subscriptionId;
                    $scheduleData->activated = 1;
                    $scheduleData->save();
                    $subscriptionPlanId = SubscriptionPlan::getSubscriptionByPlanId($planId);
                    // Insert in DB
                    if ($roleId == "4") {
                        $subscriptionNumber = RecruiterSubscription::getNewSubscriptionNumber();
                        $subscriptionNew = new RecruiterSubscription();
                        $subscriptionNew->recruiter_id = $userId;
                    } else {
                        $subscriptionNumber = CompanySubscription::getNewSubscriptionNumber();
                        $subscriptionNew = new CompanySubscription();
                        $subscriptionNew->company_id = $userId;
                    }
        
                    $subscriptionNew->plan_id = $subscriptionPlanId;
                    $subscriptionNew->subscription_number = $subscriptionNumber;
                    $subscriptionNew->email = $email;
                    $subscriptionNew->plan_type = $interval;
                    $subscriptionNew->amount = $amount;
                    $subscriptionNew->status = 1;
                    $subscriptionNew->payment_id = 1;
                    $subscriptionNew->stripe_subscription_id = $subscriptionId;
                    $subscriptionNew->stripe_item_id = $subscriptionItem;
                    $subscriptionNew->trial_start = $trialStart;
                    $subscriptionNew->trial_end = $trialEnd;
                    $subscriptionNew->stripe_status = $status;
                    $subscriptionNew->save();
        
                    $user = User::find($userId);
                    if ($user) {
                        $user->has_yearly_subscription = 0;
                        if ($interval == 'year') {
                            $user->has_yearly_subscription = 1;
                        }
                        $user->current_subscription_id = $subscriptionNew->id;
                        $user->current_subscription = $subscriptionPlanId;
                        $user->save();
                    }
                }
            }
        }
        http_response_code(200);
    }

}