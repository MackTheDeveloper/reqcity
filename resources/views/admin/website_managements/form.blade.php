@extends('admin.layouts.master')
<title><?php echo $model->id ? 'Edit Home Page Banner | '.config('app.name_show') : 'Add Home Page Banner | '.config('app.name_show'); ?></title>

@section('content')
    @include('admin.include.header')
    <div class="app-main">
        @include('admin.include.sidebar')
        <div class="app-main__outer">
            <div class="app-main__inner">
                <div class="app-page-title app-page-title-simple">
                    <div class="page-title-wrapper">
                        <div class="page-title-heading">
                            <div>
                                 <div class="page-title-head center-elem">
                                    <span class="d-inline-block pr-2">
                                        <i class="fa pe-7s-global"></i>
                                    </span>
                                    <span class="d-inline-block">Home Page Banner</span>
                                </div>
                                <div class="page-title-subheading opacity-10">
                                    <nav class="" aria-label="breadcrumb">
                                        <ol class="breadcrumb">
                                            <li class="breadcrumb-item">
                                                <a href="{{route('adminDashboard')}}">
                                                    <i aria-hidden="true" class="fa fa-home"></i>
                                                </a>
                                            </li>
                                            <li class="breadcrumb-item">
                                                <a href="javascript:void(0);">Home Page Banner</a>
                                            </li>
                                            <li class="breadcrumb-item">
                                                <a href="{{url(config('app.adminPrefix').'/home-page-banner/index')}}">List</a>
                                            </li>
                                            <li class="active breadcrumb-item" aria-current="page">
                                                <?php echo $model->id ? 'Edit' : 'Add'; ?>
                                            </li>
                                        </ol>
                                    </nav>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="main-card mb-3 card">
                    <div class="card-body">
                        <h5 class="card-title">HOME PAGE BANNER INFORMATION</h5>
                        <?php
                        if ($model->id)
                            $actionUrl = url(config('app.adminPrefix').'/home-page-banner/update', $model->id);
                        else
                            $actionUrl = url(config('app.adminPrefix').'/home-page-banner/store');
                        ?>
                        <form id="editHomePageBannerForm" enctype="multipart/form-data" class="" method="post" action="{{$actionUrl}}">
                            @csrf
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="title" class="font-weight-bold">Header</label>
                                        <span class="text-danger"></span>
                                        <div>
                                            <input type="text" class="form-control" id="header" name="header" placeholder="Enter Header" value="{{$model->header}}" />
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="title" class="font-weight-bold">Title</label>
                                        <span class="text-danger">*</span>
                                        <div>
                                            <input type="text" class="form-control" id="title" name="title" placeholder="Enter Title" value="{{$model->title}}" />
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="sub_title" class="font-weight-bold">Sub Title</label>
                                        <span class="text-danger">*</span>
                                        <div>
                                            <input type="text" class="form-control" id="sub_title" name="sub_title" placeholder="Enter Sub Title" value="{{$model->sub_title}}" />
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                              <div class="col-md-6">
                                  <div class="form-group">
                                      <label for="main_banner" class="font-weight-bold">Main Banner
                                          <span class="text-danger">*</span>
                                      </label>
                                      <div>
                                          <input name="main_banner" id="main_banner" type="file" class="form-control-file" value="{{old('main_banner')}}">
                                          <small class="form-text text-muted">Image size should be {{config('app.HomePageBannerDimension.width')}} X {{config('app.HomePageBannerDimension.height')}} px.</small>
                                      </div>
                                      <?php if (isset($model->main_banner)) { ?>
                                      <div style="float: left"><a href="javascript:void(0);" onclick="openImageModal('{{$MainBanner }}')"><img src="{{$MainBanner }}" width="50" height="50" alt="" /></a></div>
                                      <?php } ?>
                                  </div>
                              </div>
                              <div class="col-md-6">
                                  <div class="form-group">
                                      <label for="highlight_jobs_banner" class="font-weight-bold">Highlight Jobs Banner</label>
                                      <div>
                                          <input name="highlight_jobs_banner" id="highlight_jobs_banner" type="file" class="form-control-file" value="{{old('highlight_jobs_banner')}}">
                                          <small class="form-text text-muted">Image size should be {{config('app.HomePageBannerJobsDimension.width')}} X {{config('app.HomePageBannerJobsDimension.height')}} px.</small>
                                      </div>
                                      <?php if (isset($model->highlight_jobs_banner)) { ?>
                                      <div style="float: left"><a href="javascript:void(0);" onclick="openImageModal('{{$HighlightJobsBanner }}')"><img src="{{$HighlightJobsBanner }}" width="50" height="50" alt="" /></a></div>
                                      <?php } ?>
                                  </div>
                              </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="company_line" class="font-weight-bold">Company Line</label>                                        
                                        <div>
                                            <input type="text" class="form-control" id="company_line" name="company_line" placeholder="Company Line" value="{{$model->company_line}}" />
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="recruiter_line" class="font-weight-bold">Recruiter Line</label>
                                        <div>
                                            <input type="text" class="form-control" id="recruiter_line" name="recruiter_line" placeholder="Recruiter Line" value="{{$model->recruiter_line}}" />
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="candidate_line" class="font-weight-bold">Candidate Line</label>
                                        <div>
                                            <input type="text" class="form-control" id="candidate_line" name="candidate_line" placeholder="Candidate Line" value="{{$model->candidate_line}}" />
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <button type="submit" class="btn btn-primary" id="add_pkg_btn"><?php echo $model->id ? 'Update' : 'Add'; ?></button>
                                <a href="{{ url(config('app.adminPrefix').'/cms-page/list') }}">
                                    <button type="button" class="btn btn-light" name="cancel" value="Cancel">Cancel</button>
                                </a>
                            </div>

                        </form>
                    </div>
                </div>
            </div>
            @include('admin.include.footer')
        </div>
    </div>
@endsection

@push('scripts')
    <script src="{{asset('public/assets/js/website_management/home_page_banner.js')}}"></script>
@endpush
