var baseUrl = document.currentScript.getAttribute('data-base-url');


$( ".datepicker" ).datepicker({ dateFormat: 'dd/mm/yy' });
$(".datetimepicker").datepicker({ dateFormat: "dd/mm/yy" });
$(document).on('click', '#btnAddToPlayList', function(){
    $('#addToPlaylistModal').modal('show').find('#modalContentAddToPlayList').load($(this).attr('value'));
});

$(document).on('click','#imageUpload1',function(){
    $('#imageUpload1').val('');
});

function getFormatedDate(date){
    var dateArr = date.split('/');
    return dateArr[2]+'-'+dateArr[1]+'-'+dateArr[0]
}

function setCountryFlagCcPicker(val){
    var defaultCountry = val;
    var countryCode = $('#phoneField1').val();
    if($('#phoneField1').val() == ''){
        countryCode = (defaultCountry)?defaultCountry:'+1';
    }

    $("#phoneField1").CcPicker("setCountryByPhoneCode", countryCode);
}


$(document).on("click", ".delete-module-item", function () {
    var modules = $(this).data('module')
    var id = $(this).data('id')
    var deleteUrl = baseUrl +'/'+ modules + "/delete/" + id;
    $("#ConfirmModel #deleteConfirmed").attr("action", deleteUrl);
    $("#ConfirmModel #deleteConfirmed input#id").val(id);
    $("#ConfirmModel").modal('show');
});
$(document).on("submit", "#deleteConfirmed", function (e) {
    e.preventDefault();
    $.ajax({
        url: $(this).attr("action"),
        type: $(this).attr("method"),
        data: $("#deleteConfirmed").serialize(),
        success: function (response) {
            $("#ConfirmModel").modal("hide");
            toastr.clear();
            toastr.options.closeButton = true;
            toastr.success(response.message);
            setTimeout(function () {
                window.location.reload();
            }, 500);
        },
    });
});

$(document).on('click', '#btnAddRecruiterCandidate', function(){
    $('#addRecruiterCandidate .modal-title').text($(this).data('title'));
    $('#addRecruiterCandidate').modal('show').find('#modalContentAddRecruiterCandidate').load($(this).attr('value'));
});
