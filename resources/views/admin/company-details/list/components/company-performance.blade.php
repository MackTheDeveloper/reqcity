<div class="comp-performance-detailed">
    <div class="copm-perfromance-graph">
        <div class="req-cspanel">
            <ul class="nav " id="pills-tab" role="tablist">
                <li class="nav-item" role="presentation">
                    <a class="tab-link active" id="pills-home-tab" data-toggle="pill"
                        href="#pills-home" role="tab" aria-controls="pills-home"
                        aria-selected="true">Monthly</a>
                </li>
                <li class="nav-item" role="presentation">
                    <a class="tab-link" id="pills-profile-tab" data-toggle="pill"
                        href="#pills-profile" role="tab" aria-controls="pills-profile"
                        aria-selected="false">Yearly</a>
                </li>
                <li class="nav-item" role="presentation">
                    <a class="tab-link" id="pills-contact-tab" data-toggle="pill"
                        href="#pills-contact" role="tab" aria-controls="pills-contact"
                        aria-selected="false">Lifetime</a>
                </li>
            </ul>
            <div class="tab-content" id="pills-tabContent">
                @include('admin.company-details.list.components.cluster-chart')
                @include('admin.company-details.list.components.pi-chart')
            </div>
        </div>
    </div>
</div>
@push('scripts')
<script> let companyId = '{{$company->id}}'; </script>
<script src="{{ asset('public/assets/frontend/js/amcharts5/index.js') }}"></script>
<script src="{{ asset('public/assets/frontend/js/amcharts5/xy.js') }}"></script>
<script src="{{ asset('public/assets/frontend/js/amcharts5/percent.js') }}"></script>
<script src="{{ asset('public/assets/frontend/js/amcharts5/themes/Animated.js') }}"></script>
<script src="{{ asset('public/assets/js/companies/dashboard.js') }}"></script>
@endpush
