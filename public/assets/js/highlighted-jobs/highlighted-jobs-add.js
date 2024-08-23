/** caompany transaction listing */
$(document).ready(function () {
    var origin = window.location.href;
    DatatableInitiate();
});
var checkedId = [];
$(document).on('click', '#search_company', function () {
    // var startDate = $('#daterange').data('daterangepicker').startDate;
    // var endDate = $('#daterange').data('daterangepicker').endDate;
    // var status = $('#is_active').val();
    var company = $('#company').val();
    // var fromDate = startDate.format('YYYY-MM-DD');
    // var toDate = endDate.format('YYYY-MM-DD');
    DatatableInitiate(company);
});

$('#Tdatatable').on('search.dt', function () {
    var value = $('.dataTables_filter input').val();
    $('#exportCandidateListing #search').val(value);
});

function DatatableInitiate(company = '') {
    var token = $('input[name="_token"]').val();
    table = $('#Tdatatable').DataTable({
        language: {
            searchPlaceholder: "Search by Company, Job Title, Category..."
        },
        searching: true,
        "bDestroy": true,
        "processing": true,
        "serverSide": true,
        "scrollX": true,
        "columnDefs": [
            // {
            //     targets : [-1],
            //     "orderable": false
            // },
            {
                targets : [0],
                "orderable": false,
                class :"hide_column"
            },
            {
                targets : [1],
                "orderable": false,
                class :"text-center"
            },
            {
                targets: [2,3,4],
                className: "text-left",
            },
            // {
            //     targets: [ 5],
            //     className: "hide_column text-center",
            // },

        ],
        "ajax": {
            url: 'job-list',
            data: {
                _token: token,
                company:company,
                // plan: plan,
            },
            error: function () {  // error handling
                $(".Tdatatable-error").html("");
                $("#Tdatatable").append('<tbody class="Tdatatable-error"><tr><th colspan="3">No data found in the server</th></tr></tbody>');
                $("#Tdatatable_processing").css("display", "none");

            }
        },
    });


    // Select all checkbox at
    $('#selectAll').on('click', function () {
        var checked = $(this).is(':checked'); // Checkbox state

        // Select all
        if (checked) {
            $("#Tdatatable td input[type=checkbox]").prop('checked', true);
        } else {
            $("#Tdatatable td input[type=checkbox]").prop('checked', false);
        }
    });

    //uncheck checkbox
    $('#Tdatatable tbody').on('change', 'input[type="checkbox"]', function () {
        if (!this.checked) {
            var el = $('#selectAll').get(0);
            if (el && el.checked && ('indeterminate' in el)) {
                el.indeterminate = true;
            }
        }
    });

    //remove select all from hidden input and add check id in global array
    $('#Tdatatable').on('click', 'input[type="checkbox"]', function() {
        $('#checked').val("");
        if($(this).is(':checked')){
            checkedId.push(this.value);
        }else{
            checkedId.pop(this.value);
        }
    });

    $('#add_highlated_job').on('click', function (e) {
        var company = $('#company').val();
        var checkedIds = [];
        var total = "";
        var search = $('.dataTables_filter input').val();
        var check = $('#checked').val();
        if (check == 'selectAll') {
            checkedIds.push('selectAll');
        } else {
            $('#Tdatatable').find('input[type="checkbox"]:checked').each(function () {
                if (this.checked) {
                    checkedIds.push(this.value)
                }
            });
        }

        if (checkedIds.length <= 0) {
            $('#showMessageModel').on('show.bs.modal', function (e) {
                $('#message').text("Please Select at least one record.");
            });
            $('#showMessageModel').modal('show');
        } else {
            $('#highlatedJobAddModel').on('show.bs.modal', function (e) {
                var token = $('input[name="_token"]').val();
                $.ajax({
                    type: "GET",
                    url: "get-job-ids",
                    data: {
                        access_token: token,
                        company: company,
                        checkedIds: checkedIds,
                        search: search,
                    },
                    success: function (result) {
                        $('#checkedIds').val(result.Ids);
                        console.log($('#checkedIds').val());
                    },
                    error: function (result) {
                        console.log('error in getting bank details');
                    }

                });
                e.stopImmediatePropagation();

            });
            $('#highlatedJobAddModel').modal('show');
        }
    });

    //datepicker validation based on start & enddate
    $('#startDatepicker').datepicker({
        minDate:new Date(),
        changeMonth: true,
        changeYear: true,
        yearRange: "0:+3",
        autoHide: true,
        startDate: new Date(),
        pick:function(e){
            $("#endDatepicker").datepicker('setStartDate',e.date);
        }
    }).on('change', function () {   
        $('#required-startDate').text('');
    });

    $('#endDatepicker').datepicker({
        autoHide: true,
        startDate:$('#startDatepicker').val()
    }).on('change', function () {   
        $('#required-endDate').text('');
    });

    $(document).on('click', '#addnow', function (e) {
        e.stopImmediatePropagation();
        var checkedValues = $('#checkedIds').val();
        // var startDate = $('#startDatepicker').data('datepicker').date;
        var startDate = $('#startDatepicker').val();
        // var endDate = $('#endDatepicker').data('datepicker').date;
        var endDate = $('#endDatepicker').val();
        var company = $('#company').val();
        var fromDate = startDate?moment(startDate).format('YYYY-MM-DD'):'';
        var toDate = endDate?moment(endDate).format('YYYY-MM-DD'):'';

        if(fromDate=='' && toDate!=''){
            $('#required-endDate').text('');
            $('#required-startDate').text('Please Select Start Date.')
        }
        else if(fromDate !='' && toDate==''){
            $('#required-startDate').text('');
            $('#required-endDate').text('Please Select End Date.')
        }
        else if(fromDate =='' && toDate==''){
            $('#required-startDate').text('Please Select Start Date.')
        }
        else if (fromDate > toDate){
            $('#required-startDate').text('');
            $('#required-endDate').text('End Date must be greater then Start Date')
        }
        else{
            $('#required-startDate').text('');
            $('#required-endDate').text('');
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            $.ajax({
                url: 'store-job-ids',
                method: "POST",
                data: {
                    "_token": $('#token').val(),
                    "checkedValues": checkedValues,
                    "fromDate": startDate==""? null:fromDate,
                    "toDate": endDate==""? null:toDate
                },
                success: function (response) {
                    if (response.status == 'true') {
                        toastr.clear();
                        toastr.options.closeButton = true;
                        toastr.success(response.msg);
                        setTimeout(function () {
                            location.reload();
                        }, 1000);
                        var origin = window.location.href;

                        window.location = origin + '/../index';
                    }
                    else {
                        toastr.clear();
                        toastr.options.closeButton = true;
                        toastr.error(response.msg);
                        setTimeout(function () {
                            location.reload();
                        }, 1000);
                    }
                }
            });
        }
    });
}
