@section('title','My Info')
@extends('frontend.layouts.master')
@section('content')
<section class="profiles-pages compnay-profile-pages">
        <div class="container">
            <div class="row">
                @include('frontend.company.include.sidebar')
                <div class="col-12 col-sm-12 col-md-8 col-lg-9">
                    <div class="right-sides-items">
                        <div class="questionnarire-management-page">
                            <!-- Start Box Item Layout reusable -->
                            <div class="accounts-boxlayouts" id="Divs1">
                                <div class="ac-boclayout-header">
                                    <div class="boxheader-title">
                                        <h6>Questionnaire Management</h6>
                                        <!-- <span>R01532</span> -->
                                    </div>
                                    @if(whoCanCheckFront('company_questionnaire_post'))
                                    <div class="boxlayouts-edit">
                                        <div class="trans-date-update">
                                            <a href="{{ route('companyQuestionnaireManagmentAdd') }}" class="fill-btn">Create Template</a>
                                        </div>
                                    </div>
                                    @endif
                                </div>
                                <span class="full-hr-ac"></span>
                                <div class=" ">
                                    <div class="row">
                                        <div class="col-md-12">
                                            <!-- Section -->
                                            <div class="questionarie-mangement-home">
                                                <div class="div-table-wrapper">
                                                    <div class="div-table" id="magTable">
                                                        <div class="div-row">
                                                            <div class="div-column">
                                                                <p class="ll blur-color">Template</p>
                                                            </div>
                                                            <div class="div-column">
                                                                <p class="ll blur-color">Created by</p>
                                                            </div>
                                                            <div class="div-column">
                                                                <p class="ll blur-color">Date</p>
                                                            </div>
                                                            @if($shoAction)
                                                            <div class="div-column">
                                                                <p class="ll blur-color">Action</p>
                                                            </div>
                                                            @endif

                                                        </div>
                                                        {{-- <div class="div-row">
                                                            <div class="div-column">
                                                                <p class="ll blur-color">Web Developer</p>
                                                            </div>
                                                            <div class="div-column">
                                                                <p class="ll blur-color">
                                                                    Maren Septimus</p>
                                                            </div>
                                                            <div class="div-column">
                                                                <p class="ll blur-color">22 Nov 2021</p>
                                                            </div>
                                                            <div class="div-column">
                                                                <div class="action-block">
                                                                    <a data-toggle="modal"
                                                                        data-target="#reqEditCandidate">
                                                                        <img src="assets/img/pencil.svg" alt="" />
                                                                    </a>
                                                                    <a href=""><img src="assets/img/delete.svg"
                                                                            alt="" /></a>
                                                                </div>
                                                                <div class="mobile-action show-991">
                                                                    <div
                                                                        class="dropdown c-dropdown my-playlist-dropdown">
                                                                        <button class="dropdown-toggle"
                                                                            data-bs-toggle="dropdown">
                                                                            <img src="assets/img/more-vertical.svg"
                                                                                class="c-icon" />
                                                                        </button>
                                                                        <div class="dropdown-menu">
                                                                            <a class="dropdown-item" data-toggle="modal"
                                                                                data-target="#reqEditCandidate">
                                                                                <img src="assets/img/pencil.svg"
                                                                                    alt="" />
                                                                                <span>Edit</span>
                                                                            </a>
                                                                            <a class="dropdown-item">
                                                                                <img src="assets/img/delete.svg"
                                                                                    alt="" />
                                                                                <span>Delete</span>
                                                                            </a>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div> --}}
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!-- Ends Box Item Layout reusable -->
                        </div>
                    </div>
                </div>
            </div>
        </div>
</section>
@include('frontend.components.delete-confirm',['title'=>'Remove Template','message'=>'Are you sure you want to remove the template ?'])
@endsection
@section('footscript')
    <script src="{{asset('/public/assets/frontend/js/magTable.js')}}"></script>
    <script type="text/javascript">
        $('#magTable').magTable({
            ajax: {
                "url": "{{route('companyQuestionnaireTemplateList')}}",
                "type": "GET"
                // "data": {"set":"test"}
            },
            columns: [
                {
                    data: 'title', name: 'title',
                    render: function(data){
                        return '<p class="bm">'+data+'</p>';
                    },
                },
                {
                    data: 'createdBy', name: 'createdBy',
                    render: function(data){
                        return '<p class="bm">'+data+'</p>';
                    },
                },
                {
                    data: 'date', name: 'date',
                    render: function(data){
                        return '<p class="bm">'+data+'</p>';
                    },
                }
            ]
        })
    </script>
@endsection