@section('title', 'Job Review & Payment')
@extends('frontend.layouts.master')
@section('content')
    <div class="comp-jobpost4">
        <div class="container">
            <div class="process-progress">
                <div class="info-progress done">
                    <div class="numbers"><a href="{{ route('jobDetailsShow') }}"
                            style="text-decoration: none; color:white;">1</a></div>
                    <p class="tm">Job Details</p>
                </div>
                <div class="info-progress done">
                    <div class="numbers"><a href="{{ route('jobQuestionnaireShow') }}"
                            style="text-decoration: none; color:white;">2</a></div>
                    <p class="tm">Questionnaire</p>
                </div>
                <div class="info-progress done">
                    <div class="numbers"><a href="{{ route('jobCommunicationShow') }}"
                            style="text-decoration: none; color:white;">3</a></div>
                    <p class="tm">Communication</p>
                </div>
                <div class="info-progress">
                    <div class="numbers">4</div>
                    <p class="tm">Review & Payment</p>
                </div>
            </div>
            <div class="previews-jobpost">
                <div class="row mob-reverse">
                    <div class="offset-xl-1 col-xl-6 col-md-7 col-12">
                        <div class="prview-jobpost-left">
                            <div class="preview-jobpost-head">
                                <h5>Preview Job Post</h5>
                                <span><a href="{{ route('jobDetailsShow') }}">Edit Post</a></span>
                            </div>
                            <div class="previw-jobpost-in">
                                <div class="previewjob-in-head">
                                    <p class="tl job-name-previw">{{ $modelCompanyJob->title }}</p>
                                    <span>{{ $companyData->name }}</span>
                                    @if (isset($remoteWork) && $remoteWork == 'Remote')
                                        <span>{{ $remoteWork }} - {{$modelCompanyJob->companyAddress->countries->name}}</span>
                                    @else
                                        <span>{{ $companyAddressData }}</span>
                                    @endif
                                    <p class="ll jobprev-budget-name">
                                        ${{ number_format($modelCompanyJob->from_salary, 2) . ($modelCompanyJob->compensation_type == 'r' ? ' - $' . number_format($modelCompanyJob->to_salary, 2) : '') . ' ' . $modelCompanyJob->pay_duration }}
                                    </p>
                                    <a href="javascript:void(0)" class="fill-btn">Apply Now</a>
                                </div>

                                <div class="jobprev-detailed">
                                    {!! $modelCompanyJob->job_description !!}

                                    <!-- Ends job Feature Iteam -->
                                    <div class="preview-jobtiming">
                                        <table>
                                            <tbody>
                                                <tr>
                                                    <td>Employment type</td>
                                                    <td>{{ $employmentType }}</td>
                                                </tr>
                                                <tr>
                                                    <td>Schedule</td>
                                                    <td>{{ $schedule }}</td>
                                                </tr>
                                                <tr>
                                                    <td>Contract type</td>
                                                    <td>{{ $contractType }}</td>
                                                </tr>
                                                <tr>
                                                    <td>Contract duration</td>
                                                    <td>{{ $modelCompanyJob->contract_duration . ' ' . ($modelCompanyJob->contract_duration_type == 1 ? 'months' : 'years') }}
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>Remote work</td>
                                                    <td>{{ $remoteWork ? $remoteWork : 'No' }}</td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                            <div class="why-work-about why-about-mobo">
                                @if(isset($companyData->why_work_here) && !empty($companyData->why_work_here))
                                <div class="whywork-about-item">
                                    <p class="tl why-work-title">Why work here</p>
                                    <p class="bm">{{ $companyData->why_work_here }}</p>
                                </div>
                                @endif
                                @if(isset($companyData->about) && !empty($companyData->about))
                                <div class="whywork-about-item">
                                    <p class="tl why-work-title">About us</p>
                                    <p class="bm">{{ $companyData->about }}</p>
                                </div>
                                @endif
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-4 col-md-5 col-12">
                        <div class="prview-jobpost-sidebar">
                            <form id="companyJobPay" method="POST" action="{{ route('jobPayAdd') }}">
                                @csrf
                                <input type="hidden" name="amount" value="{{ $jobPostAmount }}">
                                <input type="hidden" class="total_amount_paid" name="total_amount_paid"
                                    value="{{ $totalAmount }}">
                                <input type="hidden" class="balance" name="balance" value="{{ $totalAmount }}">
                                <input type="hidden" name="recruiter_commission" value="{{ $recruiterCommission }}">
                                <input type="hidden" name="admin_commission" value="{{ $adminCommission }}">
                                <input type="hidden" name="job_post_amount" value="{{ $jobPostAmount }}">
                                <input type="hidden" name="status" value="1">
                                <div class="payfor-approval">
                                    <p class="tl">Pay for approval</p>
                                    <div class="payaprov-calc">
                                        <div class="input-groups">
                                            <p class="lm">Number of approved applicants you want to see</p>
                                            <div class="number-counter">
                                                <input type="number" name="vaccancy" id="vaccancy" class="vaccancy"
                                                    value="{{ $modelCompanyJob->vaccancy }}" />
                                                <button type="button" class="minus-vaccancy">
                                                    <img
                                                        src="{{ asset('public/assets/frontend/img/counter-minus.svg') }}" />
                                                </button>
                                                <button type="button" class="plus-vaccancy">
                                                    <img
                                                        src="{{ asset('public/assets/frontend/img/counter-plus.svg') }}" />
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="payfor-aprov-total">
                                        <table>
                                            <tbody>
                                                <tr>
                                                    <td>Total</td>
                                                    <td class="tdTotalAmt">${{ number_format($totalAmount, 2) }}</td>
                                                </tr>
                                            </tbody>
                                        </table>
                                        <span>You pay ${{ number_format($jobPostAmount, 2) }} per approved applicant</span>
                                    </div>
                                    <button type="submit" class="fill-btn">Continue to Payment</a>
                                </div>
                            </form>
                            <div class="why-work-about">
                                @if(isset($companyData->why_work_here) && !empty($companyData->why_work_here))
                                <div class="whywork-about-item">
                                    <p class="tl why-work-title">Why work here</p>
                                    <p class="bm">{{ $companyData->why_work_here }}</p>
                                </div>
                                @endif
                                @if(isset($companyData->about) && !empty($companyData->about))
                                <div class="whywork-about-item">
                                    <p class="tl why-work-title">About us</p>
                                    <p class="bm">{{ $companyData->about }}</p>
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
    <script>
        $(document).ready(function() {
            var vaccancy = '{{ $modelCompanyJob->vaccancy }}';
            var jobPostAmount = '{{ $jobPostAmount }}';
            $(document).on('click', '.plus-vaccancy', function() {
                var $input = $(this).parent().find('input');
                $input.val(parseInt($input.val()) + 1);

                $curVal = $input.val();
                $totalAmount = $curVal * jobPostAmount;
                $('.tdTotalAmt').text($totalAmount).formatCurrency({
                    negativeFormat: '-%s%n',
                    roundToDecimalPlace: 2,
                    symbol: '$'
                });

                $('.total_amount_paid').val($totalAmount);
                $('.balance').val($totalAmount);
                /* $input.change();
                return false; */
            }).on('click', '.minus-vaccancy', function() {
                var $input = $(this).parent().find('input');
                var count = parseInt($input.val()) - 1;
                count = count < 1 ? 1 : count;
                $input.val(count);

                $curVal = $input.val();
                $totalAmount = $curVal * jobPostAmount;
                $('.tdTotalAmt').text($totalAmount).formatCurrency({
                    negativeFormat: '-%s%n',
                    roundToDecimalPlace: 2,
                    symbol: '$'
                });

                $('.total_amount_paid').val($totalAmount);
                $('.balance').val($totalAmount);
                /* $input.change();
                return false; */
            }).on('keyup', '#vaccancy', function() {
                var $input = $(this);

                $curVal = $input.val();
                $totalAmount = $curVal * jobPostAmount;
                $('.tdTotalAmt').text($totalAmount).formatCurrency({
                    negativeFormat: '-%s%n',
                    roundToDecimalPlace: 2,
                    symbol: '$'
                });

                $('.total_amount_paid').val($totalAmount);
                $('.balance').val($totalAmount);
                /* $input.change();
                return false; */
            });

            $("#companyJobPay").validate({
                ignore: [],
                rules: {
                    vaccancy: "required",
                },
                messages: {

                },
                errorPlacement: function(error, element) {
                    if (element.hasClass("vaccancy")) {
                        error.insertAfter(element.parent());
                    } else {
                        error.insertAfter(element);
                    }
                },
                submitHandler: function(form) {
                    form.submit();
                }
            });


        })
    </script>

@endsection
