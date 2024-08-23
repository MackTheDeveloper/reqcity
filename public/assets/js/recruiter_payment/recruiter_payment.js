/** caompany transaction listing */
$(document).ready(function () {
    var origin = window.location.href;
    var oTable = $('#Tdatatable').dataTable({
        stateSave: true
    });
    DatatableInitiate();
});
var checkedId = [];
$(document).on('click', '#search_recruiter_payment', function () {
    var startDate = $('#daterange').data('daterangepicker').startDate;
    var endDate = $('#daterange').data('daterangepicker').endDate;
    var status = $('#is_active').val();
    var company = $('#company').val();
    var recruiter = $('#recruiter').val();
    var fromDate = startDate.format('YYYY-MM-DD');
    var toDate = endDate.format('YYYY-MM-DD');
    $('#exportRecruiterPayment #startDate').val(fromDate);
    $('#exportRecruiterPayment #endDate').val(toDate);
    $('#exportRecruiterPayment #status').val(status);
    $('#exportRecruiterPayment #company_name').val(company);
    $('#exportRecruiterPayment #recruiter_name').val(recruiter);
    DatatableInitiate(status, fromDate, toDate, company, recruiter);
});

$('#Tdatatable').on('search.dt', function () {
    var value = $('.dataTables_filter input').val();
    $('#exportRecruiterPayment #search').val(value);
});

function DatatableInitiate(status = '', startDate = '', endDate = '', company = '', recruiter = '') {
    var token = $('input[name="_token"]').val();
    table = $('#Tdatatable').DataTable({
        language: {
            searchPlaceholder: "Search by Company, Recruiter,Job Title..."
        },
        'drawCallback': function (response) {
            $("#total").html('$' + response.json.sumAmount);
            var chkbox = document.getElementById('selectAll');
            var checked = $(chkbox).is(':checked');
            if (checked) {
                $("#Tdatatable td input[type=checkbox]").prop('checked', true);
            } else {
                $("#Tdatatable td input[type=checkbox]").prop('checked', false);
            }
        },
        searching: true,
        "bDestroy": true,
        "processing": true,
        "serverSide": true,
        "scrollX": true,
        "column": [

        ],
        "columnDefs": [
            {
                targets: [0],
                className: "hide_column",
            },
            {
                targets: [1],
                checkboxes: {
                    'selectRow': true
                },
                orderable: false,

            },
            {
                targets: [0, 1, 2, 3, 4],
                className: "text-left",
            },
            {
                targets: [5],
                className: "text-center",
            },
            {
                targets: [6],
                className: "text-center",
                "render": function (data, type, row) {
                    return '$' + data;
                }
            },
        ],
        "ajax": {
            url: 'list',
            data: {
                _token: token,
                is_active: status,
                startDate: startDate,
                endDate: endDate,
                recruiter: recruiter,
                company: company,
            },
            error: function () {  // error handling
                $(".Tdatatable-error").html("");
                $("#Tdatatable").append('<tbody class="Tdatatable-error"><tr><th colspan="3">No data found in the server</th></tr></tbody>');
                $("#Tdatatable_processing").css("display", "none");

            }
        },
        "select": {
            style: 'os',
            selector: 'td:first-child'
        },
        // "bStateSave": true,
        // "fnStateSave": function (oSettings, oData) {
        //     localStorage.setItem( 'DataTables_'+window.location.pathname, JSON.stringify(oData) );
        // },
        // "fnStateLoad": function (oSettings) {
        //     return JSON.parse( localStorage.getItem('DataTables_'+window.location.pathname) );
        // }
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

    //make checkbox visible on serch recruiter
    $(document).on('click', '#search_recruiter_payment', function () {
        var recr = $("#recruiter").val();
        if (recr != "") {
            var tbl = $('#Tdatatable');
            tbl.DataTable().column(1).visible(true);
            $("#recruiter_payment").show();
        }
        if (recr == "") {
            var tbl = $('#Tdatatable');
            tbl.DataTable().column(1).visible(false);
            $("#recruiter_payment").hide();
        }
    });

    //show model base on selected recrods
    $('#recruiter_payment').on('click', function (e) {
        var startDate = $('#daterange').data('daterangepicker').startDate;
        var endDate = $('#daterange').data('daterangepicker').endDate;
        var company = $('#company').val();
        var recruiter = $('#recruiter').val();
        var fromDate = startDate.format('YYYY-MM-DD');
        var toDate = endDate.format('YYYY-MM-DD');
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
            $('#RecruiterPaymentModel').on('show.bs.modal', function (e) {
                var token = $('input[name="_token"]').val();
                var recr = $("#recruiter").val();
                $('#rec_id').val(recr);
                var bankName = "";
                var acNumber = "";
                var swiftcode = "";
                var address = "";
                var city = "";
                var country = "";
                $.ajax({
                    type: "GET",
                    url: "bank-detail",
                    data: {
                        id: recr,
                        access_token: token,
                        startDate: fromDate,
                        endDate: toDate,
                        company: company,
                        recruiter: recruiter,
                        checkedIds: checkedIds,
                        search: search,
                    },
                    success: function (result) {
                        bankName = result['data']['bank_name'];
                        acNumber = result['data']['account_number'];
                        swiftcode = result['data']['swift_code'];
                        address = result['data']['bank_address'];
                        city = result['data']['bank_city'];
                        country = result['data']['bank_country'];
                        total = result['total'];
                        Ids = result['Ids'];
                        $('#bankName').text(bankName)
                        $('#accountNumber').text(acNumber);
                        $('#swiftCode').text(swiftcode);
                        $('#address').text(address);
                        $('#city').text(city);
                        $('#amount').val(total);
                        $('#country').text(country);
                        $('#checkedIds').val(Ids);
                    },
                    error: function (result) {
                        console.log('error in getting bank details');
                    }

                });
                e.stopImmediatePropagation();
                var recruiterName = $("#recruiter option:selected").text();
                $('#RecruiterPaymentHeaderLabel').text('Payout to ' + recruiterName);

            });
            $('#RecruiterPaymentModel').modal('show');
        }
    });

    // To Payment
    $(document).on('click', '#paynow', function (e) {
        $('.loader-bg').removeClass('d-none');
        var checkedValues = $('#checkedIds').val();
        // console.log(checkedValues);
        var amount = $('#amount').val();
        var paymentId = $('#paymentId').val();
        if (amount == "" || paymentId == "") {
            if (amount == "") {
                $('#required-amount').text("Amount is required...");
            }
            if (paymentId == "") {
                $('#required-paymentId').text("Payment Id is required...");
            }
        } else {
            // if ($('#selectAll').val($(this).is(':checked'))) {
            //     checkedValues.push('selectAll');
            // } else {
            //     $('#Tdatatable').find('input[type="checkbox"]:checked').each(function () {
            //         if (this.checked) {
            //             checkedValues.push(this.value)
            //         }
            //     });
            // }
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            $.ajax({
                url: 'make-payment',
                method: "POST",
                data: {
                    "_token": $('#token').val(),
                    "recId": $('#rec_id').val(),
                    "checkedValues": checkedValues,
                    "amount": $('#amount').val(),
                    "paymentId": $('#paymentId').val(),
                },
                success: function (response) {
                    $('.loader-bg').addClass('d-none');
                    if (response.status == 'true') {
                        toastr.clear();
                        toastr.options.closeButton = true;
                        toastr.success(response.msg);
                        setTimeout(function () {
                            location.reload();
                        }, 1000);
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
            e.stopImmediatePropagation();
            return false;
        }

    });

}


