var origin = window.location.href;
$(document).ready(function () { });

$(document).on("click", ".clickLoadMore", function () {
    $(".loader-bg").removeClass("d-none");
    var pageNo = $('input[name="page_no"]').val();
    pageNo = parseInt(pageNo) + 1;
    sortSearchFilterAjax(pageNo, 1);
});

$(document).on("change keydown", ".search_text", function (e) {
    if (e.keyCode === 13) {
        /* $('.charSearch').removeClass('selectedChar');
        $('a.charSearch:first').addClass('selectedChar'); */
        $(".loader-bg").removeClass("d-none");
        sortSearchFilterAjax();
        $(".clickLoadMore").show();
    }
});

$(document).on("click", ".searchComapny", function () {
    $(".loader-bg").removeClass("d-none");
    sortSearchFilterAjax();
    $(".clickLoadMore").show();
});

$(document).on("click", ".charSearch", function () {
    $(".loader-bg").removeClass("d-none");
    $(".charSearch").removeClass("selectedChar");
    $(this).addClass("selectedChar");
    sortSearchFilterAjax();
    $(".clickLoadMore").show();
});

$(document).on("change", "select.sortBy", function () {
    sortSearchFilterAjax();
});

function sortSearchFilterAjax(page = "1", append = 0) {
    var search = $(".search_text").val();
    var searchChar = $(".selectedChar").data("char");
    var sortBy = $("select.sortBy").val();
    $.ajax({
        url: origin + "/../company-list",
        method: "post",
        data:
            "search=" +
            search +
            "&page=" +
            page +
            "&searchChar=" +
            searchChar +
            "&sortBy=" +
            sortBy +
            "&_token=" +
            token,
        success: function (response) {
            $(".loader-bg").addClass("d-none");
            if (append) {
                if (response.statusCode == "300") {
                    $(".clickLoadMore").hide();
                } else {
                    $(".ajaxComapnyList").append(response);
                }
            } else {
                if (response.statusCode == "300") {
                    $(".not-found").removeClass("d-none");
                    $(".clickLoadMore").hide();
                } else {
                    $(".not-found").addClass("d-none");
                }
                $(".ajaxComapnyList").html(response);
            }
            $('input[name="page_no"]').val(page);
        },
    });
}

$(document).on("click", ".assignManager", function () {
    var companyId = $(this).data("id");
    $.ajax({
        url: origin + "/../account-managers",
        method: "post",
        data: "companyId=" + companyId + "&_token=" + token,
        success: function (response) {
            $("#assignManagerModel select").html(response);
            $("#assignManagerModel #company_id").val(companyId);
            $("#assignManagerModel").modal("show");
        },
    });
});

$(document).on("submit", "#setSelectedManagerList", function (e) {
    e.preventDefault();
    var form = $(this);
    var actionUrl = form.attr("action");
    $.ajax({
        url: actionUrl,
        method: "post",
        data: form.serialize(), // serializes the form's elements.
        success: function (response) {
            if (response.success) {
                toastr.clear();
                toastr.options.closeButton = true;
                toastr.success(response.message);
            }
            $("#assignManagerModel").modal("hide");
        },
    });
});

$(document).on("click", ".getLoginLink", function (e) {
    var companyId = $(this).data("id");
    $.ajax({
        url: origin + "/../get-login-link",
        method: "post",
        data: "companyId=" + companyId + "&_token=" + token,
        success: function (response) {
            if (response.success) {
                navigator.clipboard.writeText(response.link);
                toastr.clear();
                toastr.options.closeButton = true;
                toastr.success(response.message);
            }
        },
    });
});

$(document).on('click', '.delete-company', function () {
    var module_id = $(this).data('id');
    var message = "Are you sure?";
    $('#deleteModel').on('show.bs.modal', function (e) {
        $('#deleteModel #module_id').val(module_id);
        $('#module').val('comapny');
        $('#message').text(message);
    });
    $('#deleteModel').modal('show');
})

$(document).on('click', '#deleteCompany', function () {
    var module_id = $('#module_id').val();
    $.ajax({
        url: origin + '/../delete/' + module_id,
        method: "POST",
        data: {
            "_token": $('#token').val(),
            module_id: module_id,
            module: 'comapny',
        },
        success: function (response) {
            //window.location.reload();
            if (response.status == 'true') {
                window.location.reload();
            }
            else {
                $('#deleteModel').modal('hide')
                toastr.clear();
                toastr.options.closeButton = true;
                toastr.error(response.msg);
            }
        }
    });
})
