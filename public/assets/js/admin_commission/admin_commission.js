/** caompany transaction listing */
$(document).ready(function () {
    var origin = window.location.href;
    DatatableInitiate();
});

$(document).on('click', '#search_admin_commission', function () {
    var startDate = $('#daterange').data('daterangepicker').startDate;
    var endDate = $('#daterange').data('daterangepicker').endDate;
    var company = $('#company').val();
    var fromDate = startDate.format('YYYY-MM-DD');
    var toDate = endDate.format('YYYY-MM-DD');
    $('#exportAdminCommission #startDate').val(fromDate);
    $('#exportAdminCommission #endDate').val(toDate);
    $('#exportAdminCommission #company_name').val(company);
    DatatableInitiate(fromDate, toDate ,company);
});

$('#Tdatatable').on('search.dt', function () {
    var value = $('.dataTables_filter input').val();
    $('#exportAdminCommission #search').val(value);
});

function DatatableInitiate(startDate = '', endDate = '', company = '' ) {
    var token = $('input[name="_token"]').val();
    table = $('#Tdatatable').DataTable({
        language: {
            searchPlaceholder: "Search by Company,Job Title..."
        },
        'drawCallback': function(response) {
          $("#total").html('$'+response.json.sumAmount);
        },
            searching: true,
            "bDestroy": true,
            "processing": true,
            "serverSide": true,
        "scrollX": true,
        "columnDefs": [
            {
                targets: [0],
                className: "hide_column",
            },
            {
                targets: [0, 1, 2],
                className: "text-left",
            },
            {
                targets: [4],
                className: "text-center",
                "render": function (data, type, row) {
                    return '$' + data;
                }
            },
            {
                targets: [3,5],
                className: "text-center",
            }
        ],
        "ajax": {
            url: 'list',
            data: {
                _token: token,
                startDate: startDate,
                endDate: endDate,
                company:company,
            },
            error: function () {  // error handling
                $(".Tdatatable-error").html("");
                $("#Tdatatable").append('<tbody class="Tdatatable-error"><tr><th colspan="3">No data found in the server</th></tr></tbody>');
                $("#Tdatatable_processing").css("display", "none");

            }
        },
        "select": {
            style:    'os',
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

}
