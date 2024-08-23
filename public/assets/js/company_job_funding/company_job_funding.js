/** caompany transaction listing */
$(document).ready(function () {
    var origin = window.location.href;
    DatatableInitiate();
});

$(document).on('click', '#search_job_funding', function () {
    var startDate = $('#daterange').data('daterangepicker').startDate;
    var endDate = $('#daterange').data('daterangepicker').endDate;
    var status = $('#is_active').val();
    var company = $('#company').val();
    var fromDate = startDate.format('YYYY-MM-DD');
    var toDate = endDate.format('YYYY-MM-DD');
    $('#exportCompanyJobFunding #startDate').val(fromDate);
    $('#exportCompanyJobFunding #endDate').val(toDate);
    $('#exportCompanyJobFunding #status').val(status);
    $('#exportCompanyJobFunding #company_name').val(company);
    DatatableInitiate(status, fromDate, toDate ,company);
});

$('#Tdatatable').on('search.dt', function () {
    var value = $('.dataTables_filter input').val();
    $('#exportCompanyJobFunding #search').val(value);
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


function DatatableInitiate(status = '', startDate = '', endDate = '', company = '') {
    var token = $('input[name="_token"]').val();
    table = $('#Tdatatable').DataTable({
        language: {
            searchPlaceholder: "Search by Company, Job Title, Payment ID ..."
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
            // {
            //     targets : [-1],
            //     "orderable": false
            // },
            // {
            //     targets: [4, 5],
            //     "orderable": false
            // },
            {
                targets: [0, 1, 2,3],
                className: "text-left",
            },
            {
                targets: [ 5],
                className: "text-center",
            },
            {
                targets: [4],
                "render": function (data, type, row) {
                    if (data == 1)
                        return '<span style="color: #0ba360">Completed</span>';
                    else if (data == 3)
                        return '<span style="color: red">Failed</span>';
                    else if (data == 2)
                        return '<span style="color: #f5e500">Pending</span>'
                },
                "orderable": false,
            },
            {
                targets: [4],
                className: "text-center",
            },
            {
                targets: [2],
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
                // plan: plan,
                company:company,
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
