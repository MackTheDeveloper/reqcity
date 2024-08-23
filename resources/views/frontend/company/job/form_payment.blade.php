@section('title', 'Candidate Signup')
@extends('frontend.layouts.master')
@section('content')
<div class="comp-signup4-payment comp-jobpost4">
    <div class="container">
    <div class="process-progress">
            <div class="info-progress done">
                <div class="numbers"><a href="{{ route('jobDetailsShow') }}" style="text-decoration: none; color:white;">1</a></div>
                <p class="tm">Job Details</p>
            </div>
            <div class="info-progress done">
                <div class="numbers"><a href="{{ route('jobQuestionnaireShow') }}" style="text-decoration: none; color:white;">2</a></div>
                <p class="tm">Questionnaire</p>
            </div>
            <div class="info-progress done">
                <div class="numbers"><a href="{{ route('jobCommunicationShow') }}" style="text-decoration: none; color:white;">3</a></div>
                <p class="tm">Communication</p>
            </div>
            <div class="info-progress">
                <div class="numbers">4</div>
                <p class="tm">Review & Payment</p>
            </div>
        </div>
        <div class="signup4-pay-inn">
            <div class="row">
                <div class="offset-xl-1 col-xl-6 col-md-6 col-lg-7 col-12">
                    <div class="payin-left">
                        <h5>Payment</h5>
                        <p class="bm">Choose from the following payment method</p>
                        <div class="pay-methodin">
                            <label class="rd">Stripe
                                <input type="radio" name="signup" checked>
                                <span class="rd-checkmark"></span>
                                <span class="payee-img">
                                    <img src="{{asset('public/assets/frontend/img/visa.svg')}}" alt="paymentmethod" />
                                    <img src="{{asset('public/assets/frontend/img/master.svg')}}" alt="paymentmethod" />
                                    <img src="{{asset('public/assets/frontend/img/american_express.svg')}}" alt="paymentmethod" />
                                    <img src="{{asset('public/assets/frontend/img/discover.svg')}}" alt="paymentmethod" />
                                </span>

                            </label>
                        </div>
                        {{-- <div class="pay-methodin">
                                <label class="rd">Paypal
                                    <input type="radio" name="signup">
                                    <span class="rd-checkmark"></span>
                                    <span class="payee-img payee-img-paypal">
                                        <img src="assets/img/paypal.svg" alt="paymentmethod" />
                                    </span>
                                </label>
                            </div> --}}
                        <form method="POST" action="{{route('jobPaymentConfirmPost')}}">
                            @csrf
                            <button class="fill-btn">Proceed to Pay</button>
                            <form>

                    </div>
                </div>
                <div class="col-xl-4 col-md-6 col-lg-5  col-12">
                    <div class="payin-right">
                        <div class="payin-summary">
                            <h6>Summary</h6>
                            <table>
                                <tbody>
                                    <tr>
                                        <td>Amount Due</td>
                                        <td>${{number_format($model->total_amount_paid,2)}}</td>
                                    </tr>
                                    <tr>
                                        <td>{{$model->vaccancy}} Qualified applicants <br> (${{$model->job_post_amount}} x {{$model->vaccancy}})</td>
                                        <td>(Incl Tax)</td>
                                    </tr>
                                </tbody>
                                <tfoot>
                                    <tr>
                                        <td>Total</td>
                                        <td>${{number_format($model->total_amount_paid,2)}}</td>
                                    </tr>
                                </tfoot>
                            </table>
                            {{-- <p class="bs blur-color">*Free trial ends on 15 Feb 2022, your card will be charged on 16 Feb 2022</p> --}}
                        </div>
                    </div>
                </div>
            </div>


        </div>
    </div>
</div>
@endsection
@section('footscript')
<script>
</script>

@endsection