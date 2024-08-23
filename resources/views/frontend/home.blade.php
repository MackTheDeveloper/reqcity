@section('title', $cms ? $cms->seo_title : 'Home page')
@section('metaKeywords', $cms ? $cms->seo_meta_keyword : '')
@section('metaDescription', $cms ? $cms->seo_description : '')
@extends('frontend.layouts.master')
@section('content')
    <!--------------------------
            HOME START
        --------------------------->
    <div class="home-page">
        <!--- banner starts here --->
        @include('frontend.homepage-component.banner', ['bannerData' => $homePageBanner])
        <!--- banner end here ---->
        <!--- how it works start here ---->
        <div class="CR-wrapper2">
            <div class="container">
                <div class="owl-carousel owl-theme">
                    @if ($howItWorksCompanyData)
                        <div class="item" data-dot="<button class='tl'>For Company</button>">
                            @include(
                                'frontend.homepage-component.how-it-works-for-company',
                                ['companyData' => $howItWorksCompanyData]
                            )
                        </div>
                    @endif
                    @if ($howItWorksRecruiterData)
                        <div class="item" data-dot="<button class='tl'>For Recruiter</button>">
                            @include(
                                'frontend.homepage-component.how-it-works-for-recruiter',
                                ['recruiterData' => $howItWorksRecruiterData]
                            )
                        </div>
                    @endif
                    @if ($howItWorksCandidateData)
                        <div class="item" data-dot="<button class='tl'>For Candidate</button>">
                            @include(
                                'frontend.homepage-component.how-it-works-for-candidate',
                                ['candidateData' => $howItWorksCandidateData]
                            )
                        </div>
                    @endif
                </div>
            </div>
        </div>
        <!--- how it works end here --->
        <!--- category starts here ---->
        {{-- <div class="browse-job">
            <div class="container">
                <h2>Browse job categories</h2>
                <div class="row">
                  @if (!empty($categoryList) && count($categoryList) > 0)
        					     @foreach ($categoryList as $cat)
                          @include('frontend.homepage-component.job-category',['categoryData' => $cat])
                       @endforeach
              		@endif
                  <a class="col-12 col-sm-4 col-md-4 col-lg-3 col-xl-2 browse-box" href="{{ route('categoryList')}}">
                      <img src="{{ asset('public/assets/frontend/img/Frame-11.svg') }}" alt="" />
                      <div>
                          <p class="tm">See All</p>
                          <span class="tm blur-color">{{$categoryJobCount}} Jobs</span>
                      </div>
                  </a>
                </div>
            </div>
        </div> --}}
        <!--- category end here ---->
        <!--- highligheted jobs start here ---->
        {{-- <div class="highlight-job">
            <div class="container">
                <div class="highlight-job-wrapper">
                    <h2>Highlighted Jobs</h2>
                    <div class="categories">
                        <h4>{{ $categoryCount }}</h4>
                        <p class="bl blur-color">Categories</p>
                    </div>
                    <a href="{{route('highlightedJobs')}}" class="tm view-all">View All <img src="{{ asset('public/assets/frontend/img/view-all-arrow.svg') }}" alt="" /></a>
                    <img src="{{ asset('public/assets/frontend/img/highlight.png') }}" alt="" class="highlight-bg" />
                    <div class="job-box-wrapper">
                        <div class="job-box-row">
                          @if (!empty($highlightedJobs) && count($highlightedJobs) > 0)
                              @php ($i = 1)
                               @foreach ($highlightedJobs as $jobs)
                                  @include('frontend.homepage-component.highlighted-jobs',['highlightedJobsData' => $jobs])
                                  @if ($i == 2)
                                   <div class="job-box-column"></div>
                                  @endif
                                  @php ($i++)
                               @endforeach
                          @endif
                        </div>
                    </div>
                </div>
            </div>
        </div> --}}
        <!--- highligheted jobs end here ---->
    </div>
    <!--------------------------
            HOME END
        --------------------------->

@endsection

@section('footscript')
    <!-- Start of HubSpot Embed Code -->
    <script type="text/javascript" id="hs-script-loader" async defer src="//js.hs-scripts.com/21856003.js"></script>
    <!-- End of HubSpot Embed Code -->
@endsection
