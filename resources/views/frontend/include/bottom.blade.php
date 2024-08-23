<script src="{{ asset('public/assets/frontend/js/jquery.min.js') }}"></script>
<script src="{{ asset('public/assets/frontend/js/popper.min.js') }}"></script>
<script src="{{ asset('public/assets/frontend/js/bootstrap-4.5.min.js') }}"></script>
<script src="{{ asset('public/assets/frontend/js/bootstrap-5.1.bundle.min.js') }}"></script>
<script src="{{ asset('public/assets/frontend/js/owl.carousel.js') }}"></script>
<script src="{{ asset('public/assets/frontend/js/toastr.js') }}"></script>
{{-- <script src="{{ asset('public/assets/frontend/js/jquery-ui-1.12-1.min.js') }}"></script> --}}
<script src="{{ asset('public/assets/frontend/js/jquery-ui.js') }}"></script>
<script src="{{ asset('public/assets/frontend/js/script.js') }}"></script>
<script src="{{ asset('public/assets/frontend/js/script2.js') }}"></script>
<script src="{{ asset('public/assets/frontend/js/jquery.validate.min.js') }}"></script>
<script src="{{ asset('public/assets/frontend/js/additional-methods.min.js') }}"></script>
<script src="{{ asset('public/assets/frontend/js/cropper.js') }}"></script>
<script src="{{ asset('public/assets/frontend/js/developer.js') }}?r=20220222" data-base-url="{{ url('/') }}"></script>
<script src="{{ asset('public/assets/frontend/js/jquery.ccpicker.js') }}" data-json-path="{{ asset('public/assets/frontend/data.json') }}"></script>
<script src='https://cdnjs.cloudflare.com/ajax/libs/ckeditor/4.12.1/ckeditor.js'></script>
<script src="{{ asset('public/assets/frontend/js/jquery.formatCurrency-1.4.0.min.js') }}"></script>
<!-- Image Modal -->
<script type="text/javascript">
    $(document).ready(function(e) {
        $('#phoneField1').CcPicker();
        var val = "{{config('app.defaulCountryCode')}}";
        setCountryFlagCcPicker(val);
    });
      $(document).on("click", '.loginBeforeGo', function() { 
    //$('.loginBeforeGo').click(function() {
      var alertType = $(this).attr('data-type');
      toastr.clear();
      toastr.options.closeButton = true;
      if(alertType==='applyJob')
        toastr.success('{{config('message.frontendMessages.jobPostApply.jobAppliedLogin')}}');
      else
        toastr.success('{{config('message.frontendMessages.jobPost.jobFavouriteLogin')}}');
      return false;
    })
</script>
@yield('footscript')
