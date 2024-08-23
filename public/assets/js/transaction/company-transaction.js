/** caompany transaction listing */
$(document).ready(function () {
    var origin = window.location.href;
    DatatableInitiate();
});

$(document).on('click', '#search_company_transaction', function () {
    var startDate = $('#daterange').data('daterangepicker').startDate;
    var endDate = $('#daterange').data('daterangepicker').endDate;
    var status = $('#is_active').val();
    var plan = $('#plan').val();
    var fromDate = startDate.format('YYYY-MM-DD');
    var toDate = endDate.format('YYYY-MM-DD');
    $('#exportCompanyTransaction #startDate').val(fromDate);
    $('#exportCompanyTransaction #endDate').val(toDate);
    $('#exportCompanyTransaction #status').val(status);
    $('#exportCompanyTransaction #sub_plan').val(plan);
    DatatableInitiate(status, fromDate, toDate, plan);
});

$('#Tdatatable').on('search.dt', function () {
    var value = $('.dataTables_filter input').val();
    $('#exportTransaction #search').val(value);
});

$(document).ready(function() {
    var date = new Date();
    var firstDay = new Date(date.getFullYear(), date.getMonth(), 1);
    var lastDay = new Date();
    $('#daterange').daterangepicker({
        startDate: firstDay,
        endDate: lastDay
    });
});

function DatatableInitiate(status = '', startDate = '', endDate = '', plan = '') {
    var token = $('input[name="_token"]').val();
    table = $('#Tdatatable').DataTable({
        language: {
            searchPlaceholder: "Search by Name, Email, Payment ID ..."
        },
        'drawCallback': function(response) {
          $("#total").html('$'+response.json.sumAmount);
        },
        searching: false,
        "bDestroy": true,
        "processing": true,
        "serverSide": true,
        "scrollX": true,
        "columnDefs": [
            // {
            //     targets : [-1],
            //     "orderable": false
            // },
            // {
            //     targets: [4, 5],
            //     "orderable": false
            // },
            {
                targets: [0, 1, 2,3,4],
                className: "text-left",
            },
            {
                targets: [ 6, 7,8],
                className: "text-center",
            },
            {
                targets: [7],
                "render": function (data, type, row) {
                    if (data == 'paid')
                        return '<span style="color: #0ba360">Paid</span>';
                    else if (data == 'failed')
                        return '<span style="color: #cc0000">Failed</span>';
                    else
                        return '<span></span>';
                }
            },
            {
                targets: [5],
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
                plan: plan,
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
