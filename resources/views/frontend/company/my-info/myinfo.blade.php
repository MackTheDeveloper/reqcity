@section('title','My Info')
@extends('frontend.layouts.master')
@section('content')
<section class="profiles-pages compnay-profile-pages">
    <div class="container">
        <div class="row">
            @include('frontend.company.include.sidebar')
            <div class="col-12 col-sm-12 col-md-8 col-lg-9">
                <div class="right-sides-items">
                    <div class="myinfo-page myinfo-compnaey">
                        <!-- Start Box Item Layout reusable -->
                        <div class="accounts-boxlayouts show" id="show-account-info">
                            <div class="ac-boclayout-header">
                                <div class="boxheader-title">
                                    <h6>Account Info</h6>
                                    <!-- <span>R01532</span> -->
                                </div>
                                <div class="boxlayouts-edit">
                                    <a><img src="{{asset('public/assets/frontend/img/pencil.svg')}}" id="edit-account" /></a>
                                </div>

                            </div>
                            <span class="full-hr-ac"></span>
                            <div class="ac-boxlayouts-desc">
                                <div class="row">
                                    <div class="col-md-12 col-lg-6">
                                        <div class="boxlayout-infoitem">
                                            <span>Your name</span>
                                            <p>{{$data->companyUserName}}</p>
                                        </div>
                                    </div>
                                    <div class="col-md-12 col-lg-6">
                                        <div class="boxlayout-infoitem">
                                            <span>Email</span>
                                            <p>{{$data->userEmail}}</p>
                                        </div>
                                    </div>
                                    <div class="col-md-12 col-lg-6">
                                        <div class="boxlayout-infoitem">
                                            <span>Company name</span>
                                            <p>{{$data->companyName}}</p>
                                        </div>
                                    </div>
                                    <div class="col-md-12 col-lg-6">
                                        <div class="boxlayout-infoitem">
                                            <span>Phone number</span>
                                            <p>{{$data->companyUserPhoneExt}}-{{$data->companyUserPhone}}</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- Ends Box Item Layout reusable -->
                        @include('frontend.company.my-info.components.account-info-edit')
                        <!-- Start Box Item Layout reusable -->
                        <div class="accounts-boxlayouts" id="show-company-form">
                            <div class="ac-boclayout-header">
                                <div class="boxheader-title">
                                    <h6>Company info</h6>
                                    <!-- <span>R01532</span> -->
                                </div>
                                <div class="boxlayouts-edit">
                                    @if($data->is_owner)
                                    <a><img src="{{asset('public/assets/frontend/img/pencil.svg')}}" id="edit-company" /></a>
                                    @endif
                                </div>

                            </div>
                            <span class="full-hr-ac"></span>
                            <div class="ac-boxlayouts-desc">
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="myinfo-compnaylogo">
                                            <img src="{{$logo}}" alt="" />
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="boxlayout-infoitem">
                                            <span>Website</span>
                                            <p>{{$data->website}}</p>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="boxlayout-infoitem">
                                            <span>Company size</span>
                                            <p>{{$data->strength}}</p>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="boxlayout-infoitem">
                                            <span>Email</span>
                                            <p>{{$data->companyEmail}}</p>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="boxlayout-infoitem">
                                            <span>Country</span>
                                            <p>{{$data->countryName}}</p>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="boxlayout-infoitem">
                                            <span>City</span>
                                            <p>{{$data->city}}</p>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="boxlayout-infoitem">
                                            <span>State</span>
                                            <p>{{$data->state?:'-'}}</p>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="boxlayout-infoitem">
                                            <span>Zip code</span>
                                            <p>{{$data->postcode}} </p>
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="myinfos-abt-work">
                                            <span>About company</span>
                                            <p>{{$data->about}}</p>
                                        </div>
                                        <div class="myinfos-abt-work">
                                            <span>Why work here?</span>
                                            <p>{{$data->why_work_here}}</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- Ends Box Item Layout reusable -->
                        @include('frontend.company.my-info.components.company-info-edit')
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="modal fade modal-structure close-job-popup" id="modal-crop-image">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">

                <!-- Modal Header -->
                <div class="modal-header">
                    <h6 class="modal-title">Crop</h6>
                    <button type="button" class="close cancelCrop" data-bs-dismiss="modal">
                        <img src="{{ asset('public/assets/frontend/img/close.svg') }}" alt="" />
                    </button>
                </div>

                <!-- Modal body -->
                <div class="modal-body">
                    <div class="img-container">
                        <div class="crop-img-wrapper">
                            <img id="image" src="https://avatars0.githubusercontent.com/u/3456749">
                            <div class="preview d-none"></div>
                        </div>
                    </div>
                </div>

                <!-- Modal footer -->
                <div class="modal-footer">
                    <button type="button" class="border-btn cancelCrop" data-bs-dismiss="modal">Cancel</button>
                    <button type="button" class="fill-btn" data-dismiss="modal" id="crop">Crop</button>
                </div>

            </div>
        </div>
    </div>
</section>
@endsection
@section('footscript')
<script type="text/javascript">
    $('#edit-account').click(function() {
        $('#show-account-info').addClass("d-none");
        $('#account-edit-form').removeClass("d-none");
    });

    $('#edit-company').click(function() {
        $('#show-company-form').addClass("d-none");
        $('#company-info-edit').removeClass("d-none");
    });


    document.querySelectorAll(".drop-zone__input").forEach((inputElement) => {
        const dropZoneElement = inputElement.closest(".drop-zone");

        dropZoneElement.addEventListener("click", (e) => {
            inputElement.click();
        });

        inputElement.addEventListener("change", (e) => {
            if (inputElement.files.length) {
                updateThumbnail(dropZoneElement, inputElement.files[0]);
            }
        });

        dropZoneElement.addEventListener("dragover", (e) => {
            e.preventDefault();
            dropZoneElement.classList.add("drop-zone--over");
        });

        ["dragleave", "dragend"].forEach((type) => {
            dropZoneElement.addEventListener(type, (e) => {
                dropZoneElement.classList.remove("drop-zone--over");
            });
        });

        dropZoneElement.addEventListener("drop", (e) => {
            e.preventDefault();

            if (e.dataTransfer.files.length) {
                inputElement.files = e.dataTransfer.files;
                // updateThumbnail(dropZoneElement, e.dataTransfer.files[0]);
                $('.image').trigger('change');
            }

            dropZoneElement.classList.remove("drop-zone--over");
        });
    });


    function updateThumbnail(dropZoneElement, file) {
        let thumbnailElement = dropZoneElement.querySelector(".drop-zone__thumb");

        // First time - remove the prompt
        if (dropZoneElement.querySelector(".drop-zone__prompt")) {
            dropZoneElement.querySelector(".drop-zone__prompt").hide();
        }

        // First time - there is no thumbnail element, so lets create it
        if (!thumbnailElement) {
            thumbnailElement = document.createElement("div");
            thumbnailElement.classList.add("drop-zone__thumb");
            // dropZoneElement.appendChild(thumbnailElement);
        }

        thumbnailElement.dataset.label = file.name;

        // Show thumbnail for image files
        if (file.type.startsWith("image/")) {
            const reader = new FileReader();

            reader.readAsDataURL(file);
            reader.onload = () => {
                thumbnailElement.style.backgroundImage = `url('${reader.result}')`;
            };
        } else {
            thumbnailElement.style.backgroundImage = null;
        }
    }


    $("#updateMyInfo1").validate({
        ignore: [],
        rules: {
            "companyUser[yourName]": "required",
            "companyUser[companyName]": "required",
            "companyUser[email]": {
                companyUserUniqueEmail: true,
                required: true,
            },
            "companyUser[phoneNumber]": "required",
        },
        messages: {

        },
        errorPlacement: function(error, element) {
            if (element.hasClass("mobile-number")) {
                error.insertAfter(element.parent().append());
            } else {
                error.insertAfter(element);
            }

        },
        submitHandler: function(form) {
            form.submit();
        }
    });

    $("#updateMyInfo2").validate({
        ignore: [],
        rules: {
            "company[website]": "required",
            "company[strength]": "required",
            "company[email]": {
                companyUniqueEmail: true,
                required: true,
            },
            "companyAddress[city]": "required",
            "companyAddress[country]": "required",
            "companyAddress[postcode]": "required",
            "company[about]": "required",
            "myFile" : {
                extension: "png|jpg"
            },
        },
        messages: {
            myFile:"Please upload image in .png or .jpg format",
        },
        errorPlacement: function(error, element) {
            if (element.hasClass("mobile-number")) {
                error.insertAfter(element.parent().append());
            } else {
                error.insertAfter(element);
            }

        },
        submitHandler: function(form) {
            form.submit();
        }
    });

    $.validator.addMethod('companyUniqueEmail', function(value, element) {

        var email = $('#email_company').val();
        var company_id = $('#company_id').val();
        //var result = false;
        $.ajax({
            async: false,
            url: "{{ route('companyUniqueEmail') }}",
            method: 'post',
            data: {
                email: email,
                company_id: company_id,
                _token: "{{ csrf_token() }}",
            },
            dataType: 'json',
            success: function(response) {
                result = (response.data == true) ? true : false;
            }
        });
        return result;
    }, "This email is already exists");

    $.validator.addMethod('companyUserUniqueEmail', function(value, element) {

        var email = $('#email').val();
        var user_id = $('#company_user_id').val();
        //var result = false;
        $.ajax({
            async: false,
            url: "{{ route('companyUserUniqueEmail') }}",
            method: 'post',
            data: {
                email: email,
                user_id: user_id,
                _token: "{{ csrf_token() }}",
            },
            dataType: 'json',
            success: function(response) {
                result = (response.data == true) ? true : false;
            }
        });
        return result;
    }, "This email is already exists");

    var $modal = $('#modal-crop-image');
    var image = document.getElementById('image');
    var cropper;

    $("body").on("click", ".image", function(e) {
        $('input[type="file"]').val('');
    });
    $("body").on("change", ".image", function(e) {
        var validateIcon = $('#updateMyInfo2').validate().element(':input[name="myFile"]');
        if (!validateIcon)
            return false;
        var ext = $(this).val().substring($(this).val().lastIndexOf('.') + 1).toLowerCase();
        /*  if (ext != 'png' && ext != 'jpg' && ext != 'jpeg') {
             $(this).val('');
             alert('Please select valid file (png,jpg,jpeg)');
             return false;
         } */

        var files = e.target.files;
        var done = function(url) {
            image.src = url;
            $modal.modal('show');
        };
        var reader;
        var file;
        var url;
        if (files && files.length > 0) {
            file = files[0];
            if (URL) {
                done(URL.createObjectURL(file));
            } else if (FileReader) {
                reader = new FileReader();
                reader.onload = function(e) {
                    done(reader.result);
                };
                reader.readAsDataURL(file);
            }
        }
    });

    $modal.on('shown.bs.modal', function() {
        cropper = new Cropper(image, {
            aspectRatio: 1,
            //autoCropArea: 0,
            responsive: true,
            dragMode: 'none',
            strict: true,
            guides: false,
            rounded: true,
            highlight: true,
            viewMode: 3,
            preview: '.preview',
            movable: false,
            resizable: false,
            cropBoxResizable: true,
            data: {
                width: 250,
                height: 250,
            },
            dragCrop: false,
        });
    }).on('hidden.bs.modal', function() {
        cropper.destroy();
        cropper = null;
    });

    $("#crop").click(function() {
        canvas = cropper.getCroppedCanvas({
            /* width: 1000,
            height: 1000, */
        });
        canvas.toBlob(function(blob) {
            url = URL.createObjectURL(blob);
            var reader = new FileReader();
            reader.readAsDataURL(blob);
            reader.onloadend = function() {
                var base64data = reader.result;
                //$('.drop-zone__thumb').css('display', 'block');
                //$('.drop-zone__thumb').css('background-image', 'url(' + base64data + ')');
                $('.open-icon-select').attr('src', base64data).removeClass('d-none');
                $('.drop-zone__prompt').addClass('d-none');
                $('.hiddenPreviewImg').val(base64data);
                //console.log(base64data);
                $modal.modal('hide');
            }
        });
    })

    $(".cancelCrop").on("click", function() {
        $('input[type="file"]').val('');
    });
</script>
@endsection