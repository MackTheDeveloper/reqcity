@section('title', 'Company Signup 2')
@extends('frontend.layouts.master')
@section('content')
    @php($countAddresses = $companyAddress ? count($companyAddress) : 0)
    @if ($countAddresses == 0)
        @php($countAddresses = 1)
    @endif
    <div class="company-signup-2">
        <div class="container">
            <div class="process-progress">
                <div class="info-progress done">
                    <div class="numbers" id="step1"><a href="{{ route('showCompanySignup') }}"
                            style="text-decoration: none; color:white;">1</a></div>
                    <p class="tm">Sign Up</p>
                </div>
                <div class="info-progress">
                    <div class="numbers">2</div>
                    <p class="tm">Information</p>
                </div>
                <div class="info-progress">
                    <div class="numbers">3</div>
                    <p class="tm">Pricing</p>
                </div>
                <div class="info-progress">
                    <div class="numbers">4</div>
                    <p class="tm">Payment</p>
                </div>
            </div>
            <div class="started-form-wrapper">
                <h5>Let's get started</h5>
                <div class="started-form">
                    <p class="tl">Account info</p>
                    <form id="companySignupFormTwo" method="POST" action="{{ url('/company-signup-2') }}"
                        enctype="multipart/form-data">
                        @csrf
                        <input type="hidden" id="company_id" name="company_id" value="{{ $companyId }}">
                        <input type="hidden" id="company_email" name="company_email" value="{{ $email }}">
                        <input type="hidden" id="company_user_id" name="company_user_id" value="{{ $companyUserId }}">
                        <div class="row">
                            <div class="col-12 col-sm-6 col-md-6">
                                <div class="input-groups">
                                    <span>Your name</span>
                                    <input type="text" name="company_user[name]" id="company_user_name"
                                        value="{{ $companyUser ? $companyUser->name : '' }}" />
                                </div>
                            </div>
                            <div class="col-12 col-sm-6 col-md-6">
                                <div class="input-groups">
                                    <span>Email</span>
                                    <input type="email" name="company[email]" id="company_email"
                                        value="{{ $company ? $company->email : '' }}" />
                                </div>
                            </div>
                            <div class="col-12 col-sm-6 col-md-6">
                                <div class="input-groups">
                                    <span>Company name</span>
                                    <input type="text" name="company[name]" id="company_name"
                                        value="{{ $company ? $company->name : '' }}" />
                                </div>
                            </div>
                            <div class="col-12 col-sm-6 col-md-6">
                                <div class="number-groups">
                                    <span>Phone Number</span>
                                    <div class="number-fields">
                                        <input type="text" id="phoneField1" name="company[phone_ext]" class="phone-field"
                                            value="{{ $company ? $company->phone_ext : '' }}" />
                                        <input type="number" class="mobile-number" name="company[phone]" id="company_phone"
                                            value="{{ $company ? $company->phone : '' }}">
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="company-info-sec">
                            <p class="tl">Company info</p>
                            <div class="drop-wrappers">
                                <div class="drop-zone">
                                    <input type="hidden" class="hiddenPreviewImg" name="hiddenPreviewImg" value="" />
                                    <input type="file" name="myFile" class="drop-zone__input image" id="imageUpload1">
                                    <img class="open-icon-select {{ $company && $company->logo ? '' : 'd-none' }}"
                                        src="{{ $company ? $company->logo : '' }}" alt="" />
                                    @if (!$company || empty($company->logo))
                                        <span class="drop-zone__prompt">Attach or <br> drop logo <br> here</span>
                                    @endif
                                </div>
                                <div class="drop-content">
                                    <p class="bl">Set the company profile image.</p>
                                    <span class="bl blur-color d-none">250x250 Min size/ 5 MB Max</span>
                                </div>
                            </div>
                            <label id="imageUpload1-error" class="error" for="imageUpload1"></label>
                        </div>

                        {{-- <div class="company-info-sec d-none">
                            <p class="tl">Company info</p>
                            <div class="drop-wrappers">
                                <div class="drop-zone">
                                    <input type="hidden" class="hiddenPreviewImg" name="hiddenPreviewImg" value="" />
                                    <span style="display: none" class="drop-zone__prompt">Attach or <br> drop logo <br> here</span>
                                    <img class="open-icon-select" src="{{ $company ? asset('public/assets/images/company-logo/'.$company->logo) : '' }}" alt="" />
                                    <input type="file" name="myFile" class="image d-none">
                                </div>
                                <div class="drop-content">
                                    <p class="bl">Set the company profile image.</p>
                                    <span class="bl blur-color">250x250 Min size/ 5 MB Max</span>
                                </div>
                            </div>
                        </div> --}}

                        <div class="row">
                            <div class="col-12 col-sm-6 col-md-6">
                                <div class="input-groups">
                                    <span>Website</span>
                                    <input type="text" name="company[website]" id="company_website"
                                        value="{{ $company ? $company->website : '' }}" />
                                </div>
                            </div>
                            <div class="col-12 col-sm-6 col-md-6">
                                <div class="input-groups">
                                    <span>Company size</span>
                                    <select name="company[strength]" id="company_strength">
                                        @if ($company)
                                            @foreach ($companySize as $key => $row)
                                                <option value="{{ $row['key'] }}"
                                                    {{ $row['value'] == $company->strength ? 'selected' : '' }}>
                                                    {{ $row['value'] }}</option>
                                            @endforeach
                                        @else
                                            @foreach ($companySize as $key => $row)
                                                <option value="{{ $row['key'] }}"
                                                    {{ $row['value'] == 'United States' ? 'selected' : '' }}>
                                                    {{ $row['value'] }}</option>
                                            @endforeach
                                        @endif
                                    </select>
                                </div>
                            </div>

                            <div class="cmp_address col-12">
                                @if ($company && count($companyAddress) > 0)
                                    @foreach ($companyAddress as $keyCompanyAddress => $rowCompanyAddress)
                                        <div class="section_branch" id="section_branch_{{ $keyCompanyAddress }}">
                                            <a href="javascript:void(0)" class="close-section"
                                                data-id="{{ $keyCompanyAddress }}">
                                                <img src="{{ asset('public/assets/frontend/img/close.svg') }}" alt="" />
                                            </a>
                                            <div class="row" id="cmp_address-{{ $keyCompanyAddress }}">
                                                <div class="col-12 col-sm-6 col-md-6">
                                                    <div class="input-groups">
                                                        <span>Address</span>
                                                        <input type="text"
                                                            name="company_address[{{ $keyCompanyAddress }}][address_1]"
                                                            id="company_address_address_1-{{ $keyCompanyAddress }}"
                                                            value="{{ $rowCompanyAddress->address_1 }}" />
                                                    </div>
                                                </div>
                                                <div class="col-12 col-sm-6 col-md-6">
                                                    <div class="input-groups">
                                                        <span>City</span>
                                                        <input type="text"
                                                            name="company_address[{{ $keyCompanyAddress }}][city]"
                                                            id="company_address_city-{{ $keyCompanyAddress }}"
                                                            value="{{ $rowCompanyAddress->city }}" />
                                                    </div>
                                                </div>
                                                <div class="col-12 col-sm-6 col-md-6">
                                                    <div class="input-groups">
                                                        <span>State</span>
                                                        <input type="text"
                                                            name="company_address[{{ $keyCompanyAddress }}][address_2]"
                                                            id="company_address_address_2-{{ $keyCompanyAddress }}"
                                                            value="{{ $rowCompanyAddress->address_2 }}" />
                                                    </div>
                                                </div>
                                                <div class="col-12 col-sm-6 col-md-6">
                                                    <div class="input-groups">
                                                        <span>Zip code</span>
                                                        <input type="text"
                                                            name="company_address[{{ $keyCompanyAddress }}][postcode]"
                                                            id="company_address_postcode-{{ $keyCompanyAddress }}"
                                                            value="{{ $rowCompanyAddress->postcode }}" />
                                                    </div>
                                                </div>
                                                <div class="col-12 col-sm-6 col-md-6">
                                                    <div class="input-groups">
                                                        <span>Country</span>
                                                        <select name="company_address[{{ $keyCompanyAddress }}][country]"
                                                            id="company_address_country-{{ $keyCompanyAddress }}">
                                                            @foreach ($countries as $key => $row)
                                                                <option value="{{ $row['key'] }}"
                                                                    {{ $row['key'] == $rowCompanyAddress->country ? 'selected' : '' }}>
                                                                    {{ $row['value'] }}</option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach
                                @else
                                    <div class="section_branch">
                                        <a href="javascript:void(0)" class="close-section">
                                            <img class="d-none"
                                                src="{{ asset('public/assets/frontend/img/close.svg') }}" alt="" />
                                        </a>
                                        <div class="row" id="cmp_address-0">
                                            <div class="col-12 col-sm-6 col-md-6">
                                                <div class="input-groups">
                                                    <span>Address</span>
                                                    <input type="text" name="company_address[0][address_1]"
                                                        id="company_address_address_1-0" value="" />
                                                </div>
                                            </div>
                                            <div class="col-12 col-sm-6 col-md-6">
                                                <div class="input-groups">
                                                    <span>City</span>
                                                    <input type="text" name="company_address[0][city]"
                                                        id="company_address_city-0" value="" />
                                                </div>
                                            </div>
                                            <div class="col-12 col-sm-6 col-md-6">
                                                <div class="input-groups">
                                                    <span>State</span>
                                                    <input type="text" name="company_address[0][address_2]"
                                                        id="company_address_address_2-0" value="" />
                                                </div>
                                            </div>
                                            <div class="col-12 col-sm-6 col-md-6">
                                                <div class="input-groups">
                                                    <span>Zip code</span>
                                                    <input type="text" name="company_address[0][postcode]"
                                                        id="company_address_postcode-0" value="" />
                                                </div>
                                            </div>
                                            <div class="col-12 col-sm-6 col-md-6">
                                                <div class="input-groups">
                                                    <span>Country</span>
                                                    <select name="company_address[0][country]"
                                                        id="company_address_country-0">
                                                        @foreach ($countries as $key => $row)
                                                            <option value="{{ $row['key'] }}"
                                                                {{ $row['value'] == 'United States' ? 'selected' : '' }}>
                                                                {{ $row['value'] }}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @endif
                            </div>

                        </div>

                        <div class="notes-and-btn">
                            <p class="bs">*Note: You can also add branch from your profile later.</p>
                            <button type="button" class="blue-btn add-branches"><img
                                    src="{{ asset('public/assets/frontend/img/blue-plus.svg') }}" alt="" />Add
                                branch</button>
                        </div>

                        <div class="row">
                            <div class="col-12">
                                <div class="input-groups mb-28">
                                    <span>About company</span>
                                    <textarea name="company[about]" id="about">{{ $company->about }}</textarea>
                                    <div class="max-note">
                                        {{-- <span class="bs">Must be at least 250 characters.</span> --}}
                                        {{-- <span class="bs">0/1000</span> --}}
                                        <p class="bs" id="char-count"></p>
                                    </div>
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="input-groups mb-24">
                                    <span>Why work here?</span>
                                    <textarea name="company[why_work_here]">{{ $company->why_work_here }}</textarea>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-12 text-right">
                                <button type="submit" class="fill-btn">Continue</button>
                            </div>
                        </div>

                </div>

                {{-- <p class="bs note">Dev note: Logo | Why work here are optional fields.</p> --}}

            </div>
        </div>
    </div>
    <div class="modal fade modal-structure close-job-popup" id="modal-crop-image">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">

                <!-- Modal Header -->
                <div class="modal-header">
                    <h6 class="modal-title">Crop</h6>
                    <button type="button" class="close" data-bs-dismiss="modal">
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
                    <button type="button" class="border-btn" data-bs-dismiss="modal">Cancel</button>
                    <button type="button" class="fill-btn" data-dismiss="modal" id="crop">Crop</button>
                </div>

            </div>
        </div>
    </div>

    {{-- <div class="modal fade edit-photo-popup" id="modal-crop-image" tabindex="-1" role="dialog" aria-labelledby="modalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLongTitle">Crop Image</h5>
                    <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true"><img
                                src="{{ asset('public/assets/frontend/img/cancel-popup.svg') }}"></img></span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="img-container">
                        <div class="crop-img-wrapper">
                            <img id="image" src="https://avatars0.githubusercontent.com/u/3456749">
                            <div class="preview d-none"></div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="fill-btn" id="crop">Crop</button>
                    <button type="button" class="border-btn" data-bs-dismiss="modal" aria-label="Close">Cancel</button>
                </div>
            </div>
        </div>
    </div> --}}
@endsection
@section('footscript')
    <script type="text/javascript">
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


        function validateCompanyAddress() {
            var company_address = $('input[name^="company_address"]');

            company_address.filter('input[name$="[city]"]').each(function() {
                $(this).rules("add", {
                    required: true,
                });
            });

            company_address.filter('input[name$="[address_1]"]').each(function() {
                $(this).rules("add", {
                    required: true,
                });
            });

            company_address.filter('input[name$="[address_2]"]').each(function() {
                $(this).rules("add", {
                    required: true,
                });
            });

            company_address.filter('input[name$="[postcode]"]').each(function() {
                $(this).rules("add", {
                    required: true,
                });
            });
        }

        $(document).ready(function() {
            var countAddresses = '{{ $countAddresses }}';
            $('.add-branches').click(function() {
                $.ajax({
                    url: '{{ url('company-add-branches') }}',
                    type: 'post',
                    data: 'countAddresses=' + countAddresses + '&_token={{ csrf_token() }}',
                    success: function(response) {
                        $('.cmp_address').append(response);
                        countAddresses++;
                        validateCompanyAddress();
                    }
                });
            })

            validateCompanyAddress();

        });

        $(document).delegate('.close-section', 'click', function() {
            var id = $(this).data('id');
            $('#section_branch_' + id).remove();
        })

        $("#companySignupFormTwo").validate({
            ignore: [],
            rules: {
                "company[phone]": "required",
                "company_user[name]": "required",
                "company[email]": "required",
                "company[name]": "required",
                "myFile": {
                    extension: "png|jpg",
                    filesize: 2,
                },
                // "company[about]": {
                //     minlength: 250
                // }
                "company[about]": "required"
            },
            messages: {
                myFile: {
                    extension: "Please upload image in .png or .jpg format",
                },
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

        jQuery.validator.addMethod("minlength", function(value, element, param) {
            var editorcontent = value.replace(/<("[^"]*"|'[^']*'|[^'">])*>/gi, '').replace(/^\s+|\s+$/g, '')
                .replace(new RegExp('&nbsp;', 'g'), ' '); // strip tags
            return editorcontent.length >= param;
        }, $.validator.format("Please enter min {0} characters."));

        $.validator.addMethod('filesize', function(value, element, param) {
            return this.optional(element) || (element.files[0].size <= param * 1024 * 1024);
        }, 'File size must be less than {0} MB');
        /* function submitForm() {
            $("#companySignupFormTwo").submit();
        } */

        //     $(document).on('click', '.open-icon-select', function() {
        //     $('input[name="myFile"]').trigger('click');
        // });

        var $modal = $('#modal-crop-image');
        var image = document.getElementById('image');
        var cropper;

        $("body").on("change", ".image", function(e) {
            var validateIcon = $('#companySignupFormTwo').validate().element(':input[name="myFile"]');
            if (!validateIcon)
                return false;
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

        //show character count
        $(document).on('keyup', '#about', function() {
            var characterCount = $(this).val().length;
            $('#char-count').text(characterCount + "/1000");
        });
    </script>
@endsection
