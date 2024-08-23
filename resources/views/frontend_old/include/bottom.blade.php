<?php

use App\Models\GlobalSettings;
?>
<script src="{{asset('public/assets/frontend/js/jquery.min.js')}}"></script>
<script src="{{asset('public/assets/frontend/js/popper.min.js')}}"></script>
<script src="{{asset('public/assets/frontend/js/bootstrap.min.js')}}"></script>
<script src="{{asset('public/assets/frontend/js/owl.carousel.js')}}"></script>
<script src="{{asset('public/assets/frontend/js/aos.js')}}"></script>
<script src="{{asset('public/assets/frontend/js/script.js')}}"></script>
<script src="{{asset('public/assets/frontend/js/blockUI.js')}}"></script>
<script src="{{asset('public/assets/js/vendors/form-components/form-validation.js')}}"></script>
<script src="{{asset('/public/assets/custom/kartik-v-bootstrap-fileinput/js/fileinput.min.js')}}"></script>
<script src="{{asset('/public/assets/custom/kartik-v-bootstrap-fileinput/themes/fas/theme.min.js')}}" type="text/javascript"></script>
<script src="{{asset('public/assets/frontend/js/cropper.js')}}"></script>
<!-- Image Modal -->
<div class="modal fade" id="imageModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title modalImageTitle" id="exampleModalLabel">Modal title</h5>
        <button type="button" class="close" data-dismiss="modal">&times;</button>

      </div>
      <div class="modal-body">
        <img src="" class="imf-fluid modalImage" />
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>

<!-- Warning Modal -->
<div class="modal fade" id="warningModal" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title modalImageTitle">Warning</h5>
        <button type="button" class="close" data-dismiss="modal">&times;</button>

      </div>
      <div class="modal-body text-center">
        <i class="fas fa-exclamation-triangle fa-3x text-warning "></i>
        <p class="msg mt-3"></p>
        <a style="display: none" class="fill-btn" href="{{url('login')}}">Login</a>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>

<script>
  var imageModal = new bootstrap.Modal(document.getElementById('imageModal'), {});
  var warningModal = new bootstrap.Modal(document.getElementById('warningModal'), {});

  function openImageModal(src, title) {
    $(".modalImageTitle").text(title);
    $(".modalImage").attr('src', src);
    imageModal.show();
  }

  function openWarningModal(title) {
    $(".msg").text(title);
    warningModal.show();
  }

  function isUserLoggedIn(message = 'Please login to continue') {
    var isUserLogin = @json(auth()->check());
    if (isUserLogin) {
      return true;
    } else {
      openWarningModal(message);
      return false;
    }
  }

  function getLocation() {
    if (navigator.geolocation) {
      navigator.geolocation.getCurrentPosition(showPosition);
    } else {
      // x.innerHTML = "Geolocation is not supported by this browser.";
    }
  }

  function showPosition(position) {
    alert(position)
  }

  $(document).ready(function() {
    setTimeout(function() {
      $('.alert').fadeOut();
    }, 5000)
  })
</script>

<script type="text/javascript" src="https://maps.googleapis.com/maps/api/js?key={{ globalSettings::getSingleSettingVal('google_api_key') }}&libraries=places&callback=initialize" async></script>
<!--sunny's account-->
<!-- <script type="text/javascript" src="https://maps.googleapis.com/maps/api/js?key=AIzaSyDE_9RStdLVIi_CHCFeGquVvD1EVCswZyk&libraries=places"></script> -->
<script>
    // $(document).ready(function (){
    //     google.maps.event.addDomListener(window, 'load', initialize);
    // })
    function initialize() {
        var area = '';
        var city = '';
        var thirdParam = '';
        var input = document.getElementById('autocomplete_search');
        var autocomplete = new google.maps.places.Autocomplete(input);
        autocomplete.addListener('place_changed', function () {
          area = city = thirdParam = '';
            // show_page_block_loader();

            var place = autocomplete.getPlace();
            // place variable will have all the information you are looking for.
        
            var placeId = place.place_id;
            // console.log(place);
            for (var i = 0; i < place.address_components.length; i++) {
                for (var j = 0; j < place.address_components[i].types.length; j++) {
                    if (place.address_components[i].types[j] == "sublocality_level_1") {
                        area = place.address_components[i].long_name;
                    }
                    if (place.address_components[i].types[j] == "locality") {
                        city = place.address_components[i].long_name;
                    }

                    if (place.address_components[i].types[j] == "administrative_area_level_2") {
                        thirdParam = place.address_components[i].long_name;
                    }
                }
            }
            if(!area){
              area = city;
              city = thirdParam;
            }
            // hide_page_block_loader();
            searchArea(area,city);

        });
    }
  function searchArea(area,city='') {
    if (area) {
      $('#autocomplete_search').val(area);
      $.blockUI();
      $.ajax({
        url: '{{ route("searchArea") }}',
        method: 'get',
        data: {area:area,city:city},
        success: function(e) {
          // alert('success');
          window.location.reload();
        },
        error: function(e) {
          console.log();
          // openWarningModal('Area not found.');
          if (e.status == 300) {
            openWarningModal(e.responseJSON.message);
          }
        }
      }).always(function() {
        $.unblockUI();
      });
    } else {
      openWarningModal('Sorry, we are not providing service in your selected area. Please select another area.');
    }
  }

  $(document).on("click", ".productLike", function() {
    var token = @json(csrf_token());
    var id = $(this).data('product-id');
    $.ajax({
      url: "{{ route('professional.toggleLike') }}",
      method: 'post',
      data: 'product_id=' + id + '&_token=' + token,
      success: function(e) {}
    })
  });
  // $(document).on('keyup','#searchText',function (){
  //     var valueText = $(this).val();
  //     if(valueText.length > 2){
  //         $("#searchBtn").removeClass('d-none')
  //     }else{
  //         $("#searchBtn").addClass('d-none')
  //     }
  // })
  $("#searchForm").validate({
    ignore: [],
    rules: {
      search: {
        required: true,
        minlength: 4
      },
    },
    messages: {
      search: "Please enter a valid and at least 4 charactres long input."
    },
    errorPlacement: function(error, element) {
      if (element.attr("name") == "search") {
        $("#error-content").html(error);
      } else {
        error.insertAfter(element);

      }
    },
  })
</script>
@yield('footscript')