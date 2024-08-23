<?php
namespace App\Helpers;

use App\Models\GlobalSettings;
use Stripe;

class StripeHelper {
     protected $response = [];

    // public static function test(){
    //     return $this->response = [
    //         'status' => 1,
    //         'data' => 'This is test',
    //         'error' => ''
    //     ];
    // }

    // public static function init(){
    //     Stripe\Stripe::setApiKey( env('STRIPE_SECRET'));  //set secret key for stripe
    // }
    public function __construct(){
        $stripeSecret = GlobalSettings::getSingleSettingVal('STRIPE_SECRET');
        Stripe\Stripe::setApiKey($stripeSecret);  //set secret key for stripe
        $this->response = [
            'status' => 0,
            'data' => '',
            'error' => 'Opps something went wrong while processing your request'
        ];
    }
    public function createCustomer($data){
         try{
            //try to create a customer using token and supplier email
            $customer = Stripe\Customer::create(array(
                "email" => $data['email'],
                "name" => $data['name'],
                "description" => $data['description'],                
            ));
            return $this->response = [
                'status' => 1,
                'data' => $customer,
                'error' => ''
            ];
         }catch (Stripe\Error\Card  $e) {
            return $this->response = [
                    'status' => 0,
                    'data' => '',
                    'error' => $e->getMessage()
                ];
        } catch( Stripe\Error\Base $e) {
            return $this->response = [
                    'status' => 0,
                    'data' => '',
                    'error' => $e->getMessage()
                ];

        } catch(\Exception $e){
            return $this->response = [
                    'status' => 0,
                    'data' => '',
                    'error' => $e->getMessage()
                ];
        }
    }
    public function changeSubscription($current_subscription_id, $new_subscription){
        try{
            $subscriptionDetail = Stripe\Subscription::retrieve($current_subscription_id);
            if($subscriptionDetail->status == 'active'){
                $subscriptionDetail->cancel(['prorate'=>true]);
            }

            $subscription = Stripe\Subscription::create(array(
              "customer" =>$new_subscription['stripe_customer_id'],
              "plan" => $new_subscription['stripe_plan_id']
           ));
            return $this->response = [
                'status' => 1,
                'data' => $subscription,
                'error' => ''
            ];
        }catch (Stripe\Error\Card  $e) {
            return $this->response = [
                    'status' => 0,
                    'data' => '',
                    'error' => $e->getMessage()
                ];
        } catch( Stripe\Error\Base $e){
            return $this->response = [
                    'status' => 0,
                    'data' => '',
                    'error' => $e->getMessage()
                ];
        } catch(\Exception $e){
            return $this->response = [
                    'status' => 0,
                    'data' => '',
                    'error' => $e->getMessage()
                ];
        }
    }

    public function createCardToken($card){
        try{  //try to create a token using card details of supplier
            $token = Stripe\Token::create(array(
                "card" => $card
             ));
            return $this->response = [
                'status' => 1,
                'data' => $token,
                'error' => ''
            ];
        } catch (Stripe\Error\Card $e ) {
            return $this->response = [
                    'status' => 0,
                    'data' => '',
                    'error' => $e->getMessage()
                ];
        }catch(Stripe\Error\Base $e){
            return $this->response = [
                    'status' => 0,
                    'data' => '',
                    'error' => $e->getMessage()
                ];
        }catch(\Exception $e){
            return $this->response = [
                    'status' => 0,
                    'data' => '',
                    'error' => $e->getMessage()
                ];
        }
    }

    public function addCardToCustomer($stripe_customer_id, $token_id, $is_default){
         try{ 
                $source = Stripe\Customer::createSource(
                  $stripe_customer_id,
                  ['source' => $token_id]
                );
                if($is_default){
                    $data2 = Stripe\Customer::update(
                      $stripe_customer_id,
                      ['default_source' => $source->id]
                    );
                }
                return $this->response = [
                    'status' => 1,
                    'data' => $source,
                    'error' => ''
                ];
             } catch (Stripe\Error\Card $e ) {
                return $this->response = [
                        'status' => 0,
                        'data' => '',
                        'error' => $e->getMessage()
                    ];
            }catch(Stripe\Error\Base $e){
                return $this->response = [
                        'status' => 0,
                        'data' => '',
                        'error' => $e->getMessage()
                    ];
            }catch(\Exception $e){
                return $this->response = [
                        'status' => 0,
                        'data' => '',
                        'error' => $e->getMessage()
                    ];
            }
    }
    public function changeDefaultCard($stripe_customer_id, $stripe_card_id){
         try{ 
                $data = Stripe\Customer::update(
                  $stripe_customer_id,
                  ['default_source' => $stripe_card_id]
                );
            
                return $this->response = [
                    'status' => 1,
                    'data' => $data,
                    'error' => ''
                ];
             } catch (Stripe\Error\Card $e ) {
                return $this->response = [
                        'status' => 0,
                        'data' => '',
                        'error' => $e->getMessage()
                    ];
            }catch(Stripe\Error\Base $e){
                return $this->response = [
                        'status' => 0,
                        'data' => '',
                        'error' => $e->getMessage()
                    ];
            }catch(\Exception $e){
                return $this->response = [
                        'status' => 0,
                        'data' => '',
                        'error' => $e->getMessage()
                    ];
            }
    }

    public function deleteCard($stripe_customer_id, $stripe_card_id){
        try{ 
                Stripe\Customer::deleteSource(
                  $stripe_customer_id,
                  $stripe_card_id
                );
            
                return $this->response = [
                    'status' => 1,
                    'data' => [],
                    'error' => ''
                ];
             } catch (Stripe\Error\Card $e ) {
                return $this->response = [
                        'status' => 0,
                        'data' => '',
                        'error' => $e->getMessage()
                    ];
            }catch(Stripe\Error\Base $e){
                return $this->response = [
                        'status' => 0,
                        'data' => '',
                        'error' => $e->getMessage()
                    ];
            }catch(\Exception $e){
                return $this->response = [
                        'status' => 0,
                        'data' => '',
                        'error' => $e->getMessage()
                    ];
            }
        
    }


    public function createSubscription($subscription){
        try{ 
            $subscription = Stripe\Subscription::create(array(
                "customer" => $subscription['stripe_customer_id'],
                "plan" => $subscription['stripe_plan_id'],
                "trial_period_days" => $subscription['trial_period_days'],
                // "coupon" => $subscription['coupon']
            ));
            return $this->response = [
                'status' => 1,
                'data' => $subscription,
                'error' => ''
            ];
         } catch (Stripe\Error\Card $e ) {
            return $this->response = [
                    'status' => 0,
                    'data' => '',
                    'error' => $e->getMessage()
                ];
        }catch(Stripe\Error\Base $e){
            return $this->response = [
                    'status' => 0,
                    'data' => '',
                    'error' => $e->getMessage()
                ];
        }catch(\Exception $e){
            return $this->response = [
                    'status' => 0,
                    'data' => '',
                    'error' => $e->getMessage()
                ];
        }
    }

    public function retriveSubscription($id){
          try{
                $subscriptionDetail = Stripe\Subscription::retrieve($id);
                return $this->response = [
                    'status' => 1,
                    'data' => $subscriptionDetail,
                    'error' => ''
                ];
             } catch (Stripe\Error\Card $e ) {
                return $this->response = [
                        'status' => 0,
                        'data' => '',
                        'error' => $e->getMessage()
                    ];
            }catch(Stripe\Error\Base $e){
                return $this->response = [
                        'status' => 0,
                        'data' => '',
                        'error' => $e->getMessage()
                    ];
            }catch(\Exception $e){
                return $this->response = [
                        'status' => 0,
                        'data' => '',
                        'error' => $e->getMessage()
                    ];
            }
    }

    public function retriveCoupon($coupon){
        try {
            $coupon = Stripe\Coupon::retrieve($coupon);
            return $this->response = [
                    'status' => 1,
                    'data' => $coupon,
                    'error' => ''
                ];
        } catch(\Exception $e){
            return $this->response = [
                    'status' => 0,
                    'data' => '',
                    'error' => $e->getMessage()
                ];
        }
    }
    public function retriveInvoice($invoice_id){
        try {
            $in = Stripe\Invoice::retrieve($invoice_id);
            return $this->response = [
                    'status' => 1,
                    'data' => $in,
                    'error' => ''
                ];
        } catch(\Exception $e){
            return $this->response = [
                    'status' => 0,
                    'data' => '',
                    'error' => $e->getMessage()
                ];
        }
    }

    public function cancelSubscription($subscriptionId)
    {
        try {
            $subscription = Stripe\Subscription::update($subscriptionId,array(
                "cancel_at_period_end" => true
            ));
            return $this->response = [
                'status' => 1,
                'data' => $subscription,
                'error' => ''
            ];
        } catch (\Exception $e) {
            return $this->response = [
                'status' => 0,
                'data' => '',
                'error' => $e->getMessage()
            ];
        }
    }

    public function scheduleSubscription($customerId,$startDate,$planId)
    {
        try {
            $subscription = Stripe\SubscriptionSchedule::create([
                'customer' => $customerId,
                'start_date' => $startDate,
                // 'start_date' => $endDate,
                // "plan" => "price_1KBXaIDMTFXBNFz5HkFRMxig" //monthly
                'phases' => [
                    [
                        'items' => [
                            [
                                'price' => $planId,
                                'quantity' => 1,
                            ],
                        ],
                    ],
                ]
            ]);
            return $this->response = [
                'status' => 1,
                'data' => $subscription,
                'error' => ''
            ];
        } catch (\Exception $e) {
            return $this->response = [
                'status' => 0,
                'data' => '',
                'error' => $e->getMessage()
            ];
        }
    }

    public function cancelScheduledSubscription($subscriptionId)
    {
        try {
            $stripeSecret = GlobalSettings::getSingleSettingVal('STRIPE_SECRET');
            $stripe = new \Stripe\StripeClient(
                $stripeSecret
            );
            $subscription = $stripe->subscriptionSchedules->cancel(
                $subscriptionId,
                []
            );
            // $subscription = new Stripe\SubscriptionSchedule;
            // $subscription = $subscription->cancel(
            //     $subscriptionId,
            //     []
            // );
            return $this->response = [
                'status' => 1,
                'data' => $subscription,
                'error' => ''
            ];
        } catch (\Exception $e) {
            return $this->response = [
                'status' => 0,
                'data' => '',
                'error' => $e->getMessage()
            ];
        }
    }

    public function createDirectCharge($amount, $currency, $customer, $description)
    {
        try {
            // $charge = Stripe\PaymentIntent::create(
            //     [
            //         'payment_method_types' => ['card'],
            //         'amount' => $amount,
            //         'currency' => $currency,
            //         'customer' => $customer,
            //         'payment_method' => $source,
            //         'description' => $description,
            //     ]
            // );
            $charge = Stripe\Charge::create(
                [
                    'amount' => $amount,
                    'currency' => $currency,
                    // 'source' => $source,
                    'customer' => $customer,
                    'description' => $description,
                ]
            );
            return $this->response = [
                'status' => 1,
                'data' => $charge,
                'error' => ''
            ];
        } catch (\Exception $e) {
            return $this->response = [
                'status' => 0,
                'data' => '',
                'error' => $e->getMessage()
            ];
        }
    }
}
