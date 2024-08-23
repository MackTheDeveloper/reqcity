@section('title', 'Recruiter Signup 4')
@extends('frontend.layouts.master')
@section('content')
    <div class="comp-signup4-payment">
        <div class="container">
            <div class="process-progress">
                <div class="info-progress done">
                    <div class="numbers" id="step1"><a href="{{ route('showRecruiterSignup') }}"
                            style="text-decoration: none; color:white;">1</a></div>
                    <p class="tm">Sign Up</p>
                </div>
                <div class="info-progress done">
                    <div class="numbers"><a href="{{ route('showSecondRecruiterSignup') }}"
                            style="text-decoration: none; color:white;">2</a></div>
                    <p class="tm">Information</p>
                </div>
                <div class="info-progress done">
                    <div class="numbers"><a href="{{ route('showThirdRecruiterSignup') }}"
                        style="text-decoration: none; color:white;">3</a></div>
                    <p class="tm">Pricing</p>
                </div>
                <div class="info-progress">
                    <div class="numbers">4</div>
                    <p class="tm">Payment</p>
                </div>
            </div>
            <div class="signup4-pay-inn">
                <div class="row">
                    <div class="col-12 col-sm-12 col-md-6 col-lg-6 offset-xl-1 col-xl-6">
                        <form action="{{ route('recruiterSignupFourth') }}" method="post" id="recruiterSignupFormFour">
                          @csrf
                        <div class="payin-left">
                            <h5>Payment</h5>
                            <p class="bm d-none">Choose from the following payment method</p>
                            <div class="pay-methodin">
                              <label class="rd">Stripe
                                  <input type="radio" checked>
                                  <span class="rd-checkmark"></span>
                                  <span class="payee-img">
                                      <img src="{{asset('public/assets/frontend/img/visa.svg')}}" alt="paymentmethod" />
                                      <img src="{{asset('public/assets/frontend/img/master.svg')}}" alt="paymentmethod" />
                                      <img src="{{asset('public/assets/frontend/img/american_express.svg')}}" alt="paymentmethod" />
                                      <img src="{{asset('public/assets/frontend/img/discover.svg')}}" alt="paymentmethod" />
                                  </span>

                              </label>
                          </div>
                            <div class="payment-box">
                              <div class="row">
                                <div class="col-12 col-sm-12">
                                  <div class="input-groups">
                                    <span>Name on Card</span>
                                    <input type="text" name="card_name" id="name" maxlength="20"/>
                                  </div>
                                </div>
                                <div class="col-12 col-sm-12">
                                  <div class="input-groups">
                                    <span>Card Number</span>
                                    <div class="card-field">
                                      <input type="text" class="input" name="card_no" id="cardnumber" inputmode="numeric" autocomplete="off"/>
                                      <img id="ccicon" class="ccicon" src="" />
                                    </div>
                                  </div>
                                </div>
                                <div class="col-7 col-sm-8">
                                  <div class="input-groups">
                                    <span>Expiration (mm/yy)</span>
                                    <input id="expirationdate" name="expiry_date" type="text" inputmode="numeric"/>
                                  </div>
                                </div>
                                <div class="col-5 col-sm-4">
                                  <div class="input-groups">
                                    <span>Security Code</span>
                                    <input id="securitycode" name="cvc_code" type="text" inputmode="numeric"/>
                                  </div>
                                </div>
                              </div>

                            </div>
                            <button type="submit" class="fill-btn">Proceed to Pay</button>

                        </div>
                        </form>
                    </div>
                    <div class="col-12 col-sm-12 col-md-6 col-lg-6 col-xl-4">
                        <div class="payin-right">
                            <div class="payin-summary">
                                <h6>Summary</h6>
                                <table>
                                    <tbody>
                                        <tr>
                                            <td>Cost of subscription</td>
                                            <td>${{$getCurrentSubscription->price}}/{{$getCurrentSubscription->plan_type == 'monthly' ? 'month' : 'year'}}</td>
                                          </tr>
                                          <tr>
                                            <td>Valid until: 
                                                {{getFormatedDate($untilDate)}}
                                                {{-- {{date('d M Y', strtotime(date('Y-m-d') . ' + 1 '.($getCurrentSubscription->plan_type == 'monthly' ? 'month' : 'year')))}} --}}
                                            </td>
                                            <td>(Incl Tax)</td>
                                          </tr>
                                    </tbody>
                                    <tfoot>
                                        <tr>
                                            <td>Total</td>
                                            <td>${{$getCurrentSubscription->price}}</td>
                                        </tr>
                                    </tfoot>
                                </table>
                                @if(!empty($getCurrentSubscription->trial_period))
                                <div class="payin-notes">
                                    <span>*Free trial ends on {{getFormatedDate($trialDates['trialEndDate'])}}, your card will be charged on {{getFormatedDate($trialDates['billingStartDate'])}}</span>
                                </div>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>



@endsection
@section('footscript')
<script src="{{ asset('public/assets/frontend/js/card.js') }}" data-base-url="{{ asset('public/assets/frontend/img') }}"></script>
<script src='https://cdnjs.cloudflare.com/ajax/libs/imask/3.4.0/imask.min.js'></script>
    <script type="text/javascript">
        $(document).ready(function() {
           
        });
        $("#recruiterSignupFormFour").validate({
          ignore: [],
          rules: {
            "card_name": "required",
            "card_no": "required",
            "expiry_date": "required",
            "cvc_code": "required",  
          },        
          submitHandler: function(form) {
            form.submit();
          }
        });
    </script>
    
@endsection
