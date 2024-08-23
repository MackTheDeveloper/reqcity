@section('title', 'Communication Management')
@extends('frontend.layouts.master')
@section('content')
<section class="profiles-pages compnay-profile-pages">
    <div class="container">
        <div class="row">
            @include('frontend.company.include.sidebar')
            <div class="col-12 col-sm-12 col-md-8 col-lg-9">
                <div class="right-sides-items">
                    <div class="ac-payment-page questionnarire-management-page">
                        <!-- Start Box Item Layout reusable -->
                        <div class="accounts-boxlayouts">
                            <div class="ac-boclayout-header">
                                <div class="boxheader-title">
                                    <h6>Communication Management</h6>
                                    <!-- <span>R01532</span> -->
                                </div>
                                @if(whoCanCheckFront('company_communication_management_post'))
                                <div class="boxlayouts-edit">
                                    <div class="trans-date-update">
                                        <a href="{{route('createCompanyCommunicationManagment')}}" class="fill-btn">Create Template</a>
                                    </div>
                                </div>
                                @endif
                            </div>
                            <span class="full-hr-ac"></span>
                            <div class=" ">
                                <div class="row">
                                    <div class="col-md-12">
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
@include('frontend.components.delete-confirm',['title'=>'Remove Template','message'=>'Are you sure you want to remove the template?'])
@endsection
@section('footscript')
<script type="text/javascript" src=""></script>
<script src="{{ asset('/public/assets/frontend/js/magTable.js') }}"></script>
<script type="text/javascript">
    $(document).ready(function() {
        faqTemplatesList();
    });

    function faqTemplatesList() {
        $('#magTable').magTable({
            ajax: {
                "url": "{{ route('companyCommunicationManagmentList') }}",
                "type": "GET",
            },
            columns: [{
                    data: 'template',
                    name: 'template',
                    render: function(data) {
                        return '<p class="bm">' + data + '</p>';
                    },
                },
                {
                    data: 'createdBy',
                    name: 'createdBy',
                    render: function(data) {
                        return '<p class="bm">' + data + '</p>';
                    },
                },
                {
                    data: 'date',
                    name: 'date',
                    render: function(data) {
                        return '<p class="bm">' + data + '</p>';
                    },
                }
            ]
        })
    }
</script>
@endsection