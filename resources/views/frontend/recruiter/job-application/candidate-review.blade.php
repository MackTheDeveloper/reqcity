@section('title', 'Recruiter Jobs')
@extends('frontend.layouts.master')
@section('content')
<div class="req-submit-candidate">
        <div class="container">
            <div class="row">
                <div class="col-12 col-lg-8 col-md-12">
                    <div class="process-progress">
                        <div class="info-progress done">
                            <div class="numbers">1</div>
                            <p class="tm">Candidate Details</p>
                        </div>
                        <div class="info-progress done">
                            <div class="numbers">2</div>
                            <p class="tm">Questionnaire</p>
                        </div>
                        <div class="info-progress ">
                            <div class="numbers">3</div>
                            <p class="tm">Review Submittal</p>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row margins-62 flex-reverse-mobo">
                <div class="col-md-8">
                    <div class="candidate-submital-main">
                        <div class="review-submital-head">
                            <h5>Review Submittal</h5>
                            <a href="{{route('recruiterCandidateSubmit')}}" class="blue-btn">Edit Submittal</a>
                        </div>

                        <div class="candidate-submital-in">
                            <p class="tl">Contact information</p>

                            <!-- Developer Note :- below First DIV contain unique class for all 4 submital candidate pages -->
                            <div class="submittal-candidate-form review-submital-form">
                                <form action="{{route('postRecruiterCandidateSubmitReview')}}" method="POST">
                                    @csrf
                                    <div class="row">
                                        <div class="col-12 col-sm-6 col-md-6">
                                            <div class="review-submittal-item">
                                                <span>First name</span>
                                                <p>{{$model->first_name}}</p>
                                            </div>
                                        </div>
                                        <div class="col-12 col-sm-6 col-md-6">
                                            <div class="review-submittal-item">
                                                <span>Last name</span>
                                                <p>{{$model->last_name}}</p>
                                            </div>
                                        </div>
                                        <div class="col-12 col-sm-6 col-md-12 col-lg-6">
                                            <div class="review-submittal-item">
                                                <span>Phone Number</span>
                                                <p>{{$model->phone_ext.' '.$model->phone}}</p>
                                            </div>
                                        </div>
                                        <div class="col-12 col-sm-6 col-md-6">
                                            <div class="review-submittal-item">
                                                <span>Email</span>
                                                <p>{{$model->email}}</p>
                                            </div>
                                        </div>
                                        <div class="col-12 col-sm-12 col-md-15 submital-usernotice">
                                            <span>Contact
                                                information will be hidden from
                                                company until they pay for
                                                qualified applicants.</span>
                                        </div>

                                        <div class="col-12 col-sm-6 col-md-6">
                                            <div class="review-submittal-item">
                                                <span>Country</span>
                                                <p>{{$model->countrydata->name}}</p>
                                            </div>
                                        </div>
                                        <div class="col-12 col-sm-6 col-md-6">
                                            <div class="review-submittal-item">
                                                <span>City</span>
                                                <p>{{$model->city}}</p>
                                            </div>
                                        </div>
                                        @if ($model->is_diverse_candidate)
                                            <div class="col-12 col-sm-12 col-md-12">
                                                <div class="review-submittal-item">
                                                    <div class="diversity-labels">
                                                        <span>Diversity</span>
                                                    </div>
                                                </div>
                                            </div>
                                        @endif
                                        @if($modelCv)
                                        <div class="col-12 col-sm-6 col-md-6">
                                            <div class="review-submittal-item">
                                                <span class="tm">Resume</span>
                                                <div class="upload-form-btn">
                                                    <a target="_blank" href="{{$modelCv->cv}}"><img src="{{asset('public/assets/frontend/img/pdf-orange.svg')}}" id="upload-form-img" alt="" /></a>
                                                    <p class="tm" id="upload-form-text">CV Version {{$modelCv->version_num}}</p>
                                                </div>
                                            </div>
                                        </div>
                                        @endif
                                        <div class="col-12 col-sm-6 col-md-6">
                                            <div class="review-submittal-item">
                                                <span>LinkedIn</span>
                                                <p><a href="{{$model->linkedin_profile}}" target="_blank">{{$model->linkedin_profile}}</a></p>
                                            </div>
                                        </div>
                                        <div class="col-md-12 employer-ques-ans">
                                            <p class="employ-queans-title tl">Employer questions</p>
                                            @foreach ($templateQuestions as $key=>$value)
                                                @php($val = !empty($questionnaire['templateQuestions'][$value->id])?$questionnaire['templateQuestions'][$value->id]:'')
                                                @php($val=gettype($val) == 'array' ? implode(',',$val) : $val)
                                                @if($val)
                                                <div class="employ-ansques-item">
                                                    <span>{{$value->question}}</span>
                                                    @if (in_array($types[$value->question_type]['type'],['upload document','upload image']))
                                                        <p><a target="_blank" href="{{$val}}">Click Here</a> to download or view.</p>
                                                    @else
                                                        <p>{{gettype($val) == 'array' ? implode(',',$val) : $val}}</p>
                                                    @endif
                                                </div> 
                                                @endif   
                                            @endforeach
                                            @foreach ($extraQuestions as $key=>$value)
                                                @php($val = !empty($questionnaire['extraQuestions'][$value->id])?$questionnaire['extraQuestions'][$value->id]:'')
                                                @php($val=gettype($val) == 'array' ? implode(',',$val) : $val)
                                                @if($val)
                                                <div class="employ-ansques-item">
                                                    <span>{{$value->question}}</span>
                                                    @if (in_array($types[$value->question_type]['type'],['upload document','upload image']))
                                                        <p><a target="_blank" href="{{$val}}">Click Here</a> to download or view.</p>
                                                    @else
                                                        <p>{{$val}}</p>
                                                    @endif
                                                </div> 
                                                @endif   
                                            @endforeach
                                        </div>
                                        <div class="col-12 col-sm-12 col-md-12">
                                            <div class="reqsubmit-candidate-btns">
                                                <a href="{{route('recruiterCandidateQuestionnaire')}}" class="border-btn">Back</a>
                                                <button class="fill-btn">Submit</button>
                                            </div>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    @include('frontend.recruiter.job-application.job-desc-sidebar',['companyJob'=>$companyJob])
                </div>
            </div>
        </div>
    </div>
@endsection