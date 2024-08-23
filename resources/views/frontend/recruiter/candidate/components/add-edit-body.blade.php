<form method="POST" action="{{ route('storeRecruiterCandidates') }}" id="formAddRecruiterCandidate" enctype="multipart/form-data">
    @csrf
    <div class="modal-body">
        <input type="hidden" id="model_id" name="candidate[id]" value="{{ $model->id }}" />
        <div class="row">
            <div class="col-12 col-sm-6 col-md-6">
                <div class="input-groups">
                    <span>First name</span>
                    <input type="text" class="suggest-candidate" value="{{ $model->first_name }}" name="candidate[first_name]" />
                </div>
            </div>
            <div class="col-12 col-sm-6 col-md-6">
                <div class="input-groups">
                    <span>Last name</span>
                    <input type="text" value="{{ $model->last_name }}" name="candidate[last_name]" />
                </div>
            </div>
            <div class="col-12 col-sm-6 col-md-6">
                <div class="number-groups">
                    <span>Phone Number</span>
                    <div class="number-fields">
                        <input type="text" id="phoneField1" class="phone-field" value="{{ $model->phone_ext }}" />
                        <input type="number" class="mobile-number" name="candidate[phone]" value="{{ $model->phone }}">
                    </div>
                </div>
            </div>
            <div class="col-12 col-sm-6 col-md-6">
                <div class="input-groups">
                    <span>Email</span>
                    <input type="email" name="candidate[email]" value="{{ $model->email }}" />
                </div>
            </div>
            <div class="col-12 col-sm-6 col-md-6">
                <div class="input-groups">
                    <span>Country</span>
                    <select name="candidate[country]">
                        @foreach ($countries as $items)
                        <option {{ !empty($model->id) && $model->country == $items['key'] ? 'selected="selected"' : '' }} value="{{ $items['key'] }}">{{ $items['value'] }}</option>
                        @endforeach
                    </select>
                </div>
            </div>
            <div class="col-12 col-sm-6 col-md-6">
                <div class="input-groups">
                    <span>State</span>
                    <input type="text" name="candidate[state]" value="{{ $model->state }}" />
                </div>
            </div>
            <div class="col-12 col-sm-6 col-md-6">
                <div class="input-groups">
                    <span>City</span>
                    <input type="text" name="candidate[city]" value="{{ $model->city }}" />
                </div>
            </div>
            <div class="col-12 col-sm-6 col-md-6">
                <div class="input-groups">
                    <span>Zip code</span>
                    <input type="text" name="candidate[postcode]" value="{{ $model->postcode }}" />
                </div>
            </div>
            <div class="col-12 col-sm-12 col-md-12">
                <div class="diversity-row">
                    <label class="ck">Diversity
                        <input type="checkbox" name="candidate[is_diverse_candidate]" value="1" {{ $model->is_diverse_candidate ? 'checked' : '' }} />
                        <span class="ck-checkmark"></span>
                    </label>
                </div>
            </div>
            <div class="col-12 col-sm-12 col-md-6">
                <div class="upload-resume">
                    <p class="tm">Upload resume</p>
                    <div class="upload-form-btn2">
                        <input type="file" id="upload-form-file" hidden="hidden" name="candidate_cv[cv]" />
                        <img src="{{ asset('public/assets/frontend/img/upload-icon.svg') }}" id="upload-form-img" alt="" />
                        <div>
                            <p class="tm" id="upload-form-text">Upload resume</p>
                            <span class="bs blur-color">Use a pdf, docx, doc, rtf and txt</span>
                        </div>
                    </div>
                    <label id="upload-form-file-error" class="error" for="upload-form-file"></label>
                    @if ($modelCv && $modelCv->cv)
                    <p><a target="_blank" href="{{$modelCv->cv}}">Download CV Version {{$modelCv->version_num}}</a></p>
                    @endif
                </div>
            </div>
            <div class="col-12 col-sm-12 col-md-6 linkdin-section">
                <p class="tm">LinkedIn</p>
                <div class="input-groups">
                    <span>LinkedIn profile link</span>
                    <input type="url" pattern="https://.*" name="candidate[linkedin_profile]" value="{{ $model->linkedin_profile }}" />
                </div>
            </div>
        </div>
    </div>
    <!-- Modal footer -->
    <div class="modal-footer">
        <button type="submit" class="fill-btn" data-dismiss="modal">{{ $model->id ? 'Update' : 'Add' }} Candidate</button>
    </div>
</form>



<script type="text/javascript">
    $("#phoneField1").CcPicker({
        dialCodeFieldName: "candidate[phone_ext]"
    });
    @if(!empty($model->phone_ext))
        var val = "{{ $model->phone_ext}}";
        setCountryFlagCcPicker(val);  
    @endif   
    var uploadFormFile = document.getElementById("upload-form-file");
    var uploadFormImg = document.getElementById("upload-form-img");
    var uploadFormText = document.getElementById("upload-form-text");
    uploadFormImg.addEventListener("click", function() {
        uploadFormFile.click();
    });
    uploadFormFile.addEventListener("change", function() {
        if (uploadFormFile.value) {
            uploadFormText.innerHTML = uploadFormFile.value.match(
                /[\/\\]([\w\d\s\.\-\(\)]+)$/
            )[1];
        } else {
            uploadFormText.innerHTML = "No file chosen, yet.";
        }
    });
    $("#formAddRecruiterCandidate").validate({
        ignore: [],
        //ignore: ":hidden",
        rules: {
            "candidate[first_name]": "required",
            "candidate[last_name]": "required",
            "candidate[phone]": "required",
            "candidate[email]": {
                recruiterCandidateUniqueEmail: true,
                required: true,
            },
            "candidate[country]": "required",
            "candidate[city]": "required",
            "candidate_cv[cv]": {
                required: function(ele) {
                    return $('#model_id').val() == ""
                },
                extension: "pdf|docx|doc|rtf|txt"
            }
        },
        messages: {
            "candidate_cv[cv]":"Please upload resume in .pdf,.docx,.doc,.rtf or .txt format",
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

    $.validator.addMethod('recruiterCandidateUniqueEmail', function(value, element) {
        //var result = false;
        var id = '{{ $model->id }}';
        $.ajax({
            async: false,
            url: "{{ route('checkUniqueEmailRecruiterCandidates') }}",
            method: 'post',
            data: {
                email: value,
                id: id,
                userId: '{{$userId}}',
                _token: "{{ csrf_token() }}",
            },
            dataType: 'json',
            success: function(response) {
                result = (response.data == true) ? true : false;
            }
        });
        return result;
    }, "This email is already exists");
</script>