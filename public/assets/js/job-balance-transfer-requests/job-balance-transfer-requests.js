/** caompany transaction listing */
var baseUrl = document.currentScript.getAttribute("data-base-url");
$(document).ready(function () {
    var date = new Date();
    var firstDay = new Date(date.getFullYear(), date.getMonth(), 1);
    var lastDay = new Date();
    $("#daterange").daterangepicker({
        startDate: firstDay,
        endDate: lastDay,
    });
    
    DatatableInitiate();
    var origin = window.location.href;
    /** approve balance request */
    $('#Tdatatable').on('click', 'tbody .approve-link', function () {
        var job_balance_id = $(this).data('id');
        var message = "Are you sure?";
        console.log(message);
        $('#JobBalanceApproveModel').on('show.bs.modal', function (e) {
            $('#job_balance_id').val(job_balance_id);
            $('#message_approve').text(message);
        });
        $('#JobBalanceApproveModel').modal('show');
    })

    $(document).on('click', '#approveJobBalance', function () {
        var job_balance_id = $('#job_balance_id').val();
        $.ajax({
            url: baseUrl + '/securerccontrol/job-balance-transfer-requests/approve/' + job_balance_id,
            method: "POST",
            data: {
                "_token": $('#token').val(),
                job_balance_id: job_balance_id,
            },
            success: function (response) {
                if (response.status == 'true') {
                    $('#JobBalanceApproveModel').modal('hide')
                    DatatableInitiate();
                    toastr.clear();
                    toastr.options.closeButton = true;
                    toastr.success(response.msg);
                }
                else {
                    $('#JobBalanceApproveModel').modal('hide')
                    toastr.clear();
                    toastr.options.closeButton = true;
                    toastr.error(response.msg);
                }
            }
        });
    });

    /** reject balance request */
    $('#Tdatatable').on('click', 'tbody .reject-link', function () {
        var job_balance_id = $(this).data('id');
        var message = "Please give reson for reject";
        console.log(message);
        $('#JobBalanceRejectModel').on('show.bs.modal', function (e) {
            $('#job_balance_id').val(job_balance_id);
            $('#message_reject').text(message);
        });
        $('#JobBalanceRejectModel').modal('show');
    })

    $(document).on('click', '#rejectJobBalance', function (event) {
        var job_balance_id = $('#job_balance_id').val();
        var reject_reason = document.getElementById("reject_reason").value;
        if (!reject_reason) {
            $('#required-reject_reason').text("This field is required");
            event.preventDefault();
        } else {
            $('#JobBalanceRejectModel').modal('hide');
            $.ajax({
                url: baseUrl + '/securerccontrol/job-balance-transfer-requests/reject/' + job_balance_id,
                method: "POST",
                data: {
                    "_token": $('#token').val(),
                    job_balance_id: job_balance_id,
                    reject_reason: reject_reason,
                },
                success: function (response) {
                    if (response.status == 'true') {
                        $('#JobBalanceRejectModel').modal('hide')
                        DatatableInitiate();
                        toastr.clear();
                        toastr.options.closeButton = true;
                        toastr.success(response.msg);
                    }
                    else {
                        $('#JobBalanceRejectModel').modal('hide')
                        toastr.clear();
                        toastr.options.closeButton = true;
                        toastr.error(response.msg);
                    }
                }
            });
        }
    })
});

$(document).on('click', '#search_job_balance_request', function () {
    var startDate = $('#daterange').data('daterangepicker').startDate;
    var endDate = $('#daterange').data('daterangepicker').endDate;
    var status = $('#is_active').val();
    var company = $('#company').val();
    var fromDate = startDate.format('YYYY-MM-DD');
    var toDate = endDate.format('YYYY-MM-DD');
    DatatableInitiate(status, fromDate, toDate, company);
});

function DatatableInitiate(status = 1, startDate = '', endDate = '', company = '') {
    var token = $('input[name="_token"]').val();
    if (status == 3) {
        var COLDEFS = [

            {
                title: 'Reject Reason',
                targets: [6],
                "orderable": false,
                "visible": true
            },
            {
                targets: [1, 2, 3],
                className: "text-left",
            },
            {
                targets: [0, 4, 5, 7],
                className: "text-center",
            },
            {
                targets: [5],
                "render": function (data, type, row) {
                    if (data == 2)
                        return '<span style="color: #0ba360">Approved</span>';
                    else if (data == 3)
                        return '<span style="color: red">Rejected</span>';
                    else if (data == 1)
                        return '<span style="color: #e0ce09">Pending</span>'
                },
                "orderable": true,

            },
            {
                targets: [4],
                "render": function (data, type, row) {
                    return '$' + data;
                }
            },
        ];
    }
    else {
        var COLDEFS = [

            {
                targets: [6],
                "orderable": false,
                "visible": false
            },
            {
                targets: [1, 2, 3],
                className: "text-left",
            },
            {
                targets: [0, 4, 5, 7],
                className: "text-center",
            },
            {
                targets: [5],
                "render": function (data, type, row) {
                    if (data == 2)
                        return '<span style="color: #0ba360">Approved</span>';
                    else if (data == 3)
                        return '<span style="color: red">Rejected</span>';
                    else if (data == 1)
                        return '<span style="color: #f5e500">Pending</span>'
                },
                "orderable": true,

            },
            {
                targets: [4],
                "render": function (data, type, row) {
                    return '$' + data;
                }
            },
        ];
    }
    table = $('#Tdatatable').DataTable({
        "initComplete": function (settings, json) {
            if (settings.jqXHR.responseJSON.status == 3) {
                oTable.columns([5]).removeClass('hide_column');
            }
        },

        language: {
            searchPlaceholder: "Search by Company, Job Title ..."
        },
        'drawCallback': function (response) {
            $("#total").html('$' + response.json.sumAmount);
        },
        searching: true,
        "bDestroy": true,
        "processing": true,
        "serverSide": true,
        "scrollX": true,
        "columnDefs": COLDEFS,
        "ajax": {
            url: 'list',
            data: {
                _token: token,
                is_active: status,
                startDate: startDate,
                endDate: endDate,
                // plan: plan,
                company: company,
            },
            error: function () {  // error handling
                $(".Tdatatable-error").html("");
                $("#Tdatatable").append('<tbody class="Tdatatable-error"><tr><th colspan="3">No data found in the server</th></tr></tbody>');
                $("#Tdatatable_processing").css("display", "none");

            }
        },
        // "bStateSave": true,
        // "fnStateSave": function (oSettings, oData) {
        //     localStorage.setItem( 'DataTables_'+window.location.pathname, JSON.stringify(oData) );
        // },
        // "fnStateLoad": function (oSettings) {
        //     return JSON.parse( localStorage.getItem('DataTables_'+window.location.pathname) );
        // }
    });

}
