var origin = window.location.href;
$(document).ready(function () {
    $(".web-filter").on("click", function () {
        $(".filter-section-wrapper").toggleClass("active", 300);
    });
    var $this = $('.ck-collapse');
    // If more than 2 Education items, hide the remaining
    $('.ck-collapse').each(function () {
        $(this).find('.ck').slice(0, 5).addClass('shown')
        $(this).find('.ck').not('.shown').hide();
        if ($(this).find('.ck').length > 5) {
            $(this).append('<div><a href="javascript:;" class="show-more a"></a></div>');
        }
    });
    // $('.ck-collapse .ck').slice(0,4).addClass('shown');
    // $('.ck-collapse .ck').not('.shown').hide();
    $('.ck-collapse .show-more').on('click', function () {
        $(this).closest('.ck-collapse').find('.ck').not('.shown').toggle(300);
        $(this).toggleClass('show-less');
    });
})
$(document).on('change', '.job-sort', function () {
    $('.loader-bg').removeClass('d-none');
    sortSearchFilterAjax('1', '', status);
    $('.clickLoadMore').show();
})

$(document).on('click', '.searchJob', function () {
    $('.loader-bg').removeClass('d-none');
    sortSearchFilterAjax('1', '', status);
    $('.clickLoadMore').show();
})

$(document).on('change keydown', '.search_text', function (e) {
    if (e.keyCode === 13) {
        $('.loader-bg').removeClass('d-none');
        sortSearchFilterAjax('1', '', status);
        $('.clickLoadMore').show();
    }
});

$(document).on('click', '.filterJob', function () {
    $('.loader-bg').removeClass('d-none');
    $('.web-filter').trigger('click');
    sortSearchFilterAjax('1', '', status);
    $('.clickLoadMore').show();
})


var parentCat = [];
var childCat = [];
var joblocation = [];
var empType = [];
var conType = [];

$('.checkallparentCat').on('change', function () {
    if ($(this).is(':checked')) {
        $('.parent_cat').prop('checked', false);
        $('.parent_cat').attr('disabled', 'disabled');
        parentCat = [];
    } else {
        $('.parent_cat').attr('disabled', false);
    }
});
$('.checkallchildCat').on('change', function () {
    if ($(this).is(':checked')) {
        $('.child_cat').prop('checked', false);
        $('.child_cat').attr('disabled', 'disabled');
        childCat = [];
    } else {
        $('.child_cat').attr('disabled', false);
    }
});
$('.checkallJobLocation').on('change', function () {
    if ($(this).is(':checked')) {
        $('.joblocation').prop('checked', false);
        $('.joblocation').attr('disabled', 'disabled');
        joblocation = [];
    } else {
        $('.joblocation').attr('disabled', false);
    }
});
$('.checkallEmpType').on('change', function () {
    if ($(this).is(':checked')) {
        $('.emp_type').prop('checked', false);
        $('.emp_type').attr('disabled', 'disabled');
        empType = [];
    } else {
        $('.emp_type').attr('disabled', false);
    }
});
$('.checkallConType').on('change', function () {
    if ($(this).is(':checked')) {
        $('.con_type').prop('checked', false);
        $('.con_type').attr('disabled', 'disabled');
        conType = [];
    } else {
        $('.con_type').attr('disabled', false);
    }
});

$(document).on('click', '.clearFilterJob', function () {
    $('.loader-bg').removeClass('d-none');
    $('.web-filter').trigger('click');
    document.querySelectorAll('input[type="checkbox"]')
        .forEach(el => el.checked = false);
    parentCat = [];
    childCat = [];
    joblocation = [];
    empType = [];
    conType = [];
    $('.parent_cat').attr('disabled', false);
    $('.child_cat').attr('disabled', false);
    $('.joblocation').attr('disabled', false);
    $('.emp_type').attr('disabled', false);
    $('.con_type').attr('disabled', false);
    sortSearchFilterAjax('1', '', status);
})


$('.parent_cat').on('change', function () {
    parentCat = [];
    var val = '';
    $("input:checkbox[class=parent_cat]:checked").each(function () {
        var val = this.value;
        parentCat.push(val);
    });
});

$('.child_cat').on('change', function () {
    childCat = [];
    var val = '';
    $("input:checkbox[class=child_cat]:checked").each(function () {
        var val = this.value;
        childCat.push(val);
    });
});

$('.joblocation').on('change', function () {
    joblocation = [];
    var val = '';
    $("input:checkbox[class=joblocation]:checked").each(function () {
        var val = this.value;
        joblocation.push(val);
    });
});

$('.emp_type').on('change', function () {
    empType = [];
    var val = '';
    $("input:checkbox[class=emp_type]:checked").each(function () {
        var val = this.value;
        empType.push(val);
    });
});

$('.con_type').on('change', function () {
    conType = [];
    var val = '';
    $("input:checkbox[class=con_type]:checked").each(function () {
        var val = this.value;
        conType.push(val);
    });
});

function sortSearchFilterAjax(page = "1", append = 0, status = "") {
    var search = $('.search_text').val();
    var sort = $('.job-sort').val();
    var status = status ? status : 0;
    $.ajax({
        url: origin + '../../../../ajax-job-list-recruiter',
        method: 'post',
        data: 'search=' + search + '&page=' + page + '&status=' + status + '&sort=' + sort + '&filter[parentCat]=' + parentCat + '&filter[childCat]=' + childCat + '&filter[joblocation]=' + joblocation + '&filter[empType]=' + empType + '&filter[conType]=' + conType + '&_token=' + token + '&recruiterId=' + recruiterId,
        success: function (response) {
            $('.loader-bg').addClass('d-none');
            if (append) {
                if (response.statusCode == '300') {
                    $('.clickLoadMore').hide();
                } else {
                    $('.ajaxJobList').append(response);
                }
            } else {
                if (response.statusCode == '300') {
                    $('.not-found').removeClass('d-none');
                    $('.clickLoadMore').hide();
                } else {
                    $('.not-found').addClass('d-none');
                }
                $('.ajaxJobList').html(response);
            }
            $('input[name="page_no"]').val(page);
        }
    })
}

$(document).on('click', '.clickLoadMore', function () {
    $('.loader-bg').removeClass('d-none');
    var pageNo = $('input[name="page_no"]').val();
    // pageNo+=1;
    pageNo = parseInt(pageNo) + 1;
    sortSearchFilterAjax(pageNo, 1, status);
})