/** caompany transaction listing */
$(document).ready(function () {
    var origin = window.location.href;
    DatatableInitiate();
});

$(document).on('click', '#search_recruiter_transaction', function () {
    var startDate = $('#daterange').data('daterangepicker').startDate;
    var endDate = $('#daterange').data('daterangepicker').endDate;
    var fil_recruiter = $('#recruiter').val();
    var fromDate = startDate.format('YYYY-MM-DD');
    var toDate = endDate.format('YYYY-MM-DD');
    $('#exportRecruiterPayout #startDate').val(fromDate);
    $('#exportRecruiterPayout #endDate').val(toDate);
    $('#exportRecruiterPayout #fil_recruiter').val(fil_recruiter);
    var search = $('.dataTables_filter input[type="search"]').val();
    $('#exportRecruiterPayout #search').val(search);
    DatatableInitiate(search,fromDate, toDate, fil_recruiter);
});

$('#Tdatatable').on('search.dt', function () {
    var value = $('.dataTables_filter input').val();
    $('#exportRecruiterPayout #search').val(value);
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


function DatatableInitiate(search='',startDate = '', endDate = '', recruiter = '') {
    var token = $('input[name="_token"]').val();
    table = $('#Tdatatable').DataTable({
        language: {
            searchPlaceholder: "Search by Recruiter, Payment ID ..."
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
            {
                targets: [3, 4],
                "orderable": false
            },
            {
                targets: [0,3,4],
                className: "text-left",
            },
            {
                targets: [ 1, 2,5],
                className: "text-center",
            },
            {
                targets: [1],
                "render": function (data, type, row) {
                    return '$' + data;
                }
            },
        ],
        "ajax": {
            url: 'list',
            data: {
                _token: token,
                startDate: startDate,
                endDate: endDate,
                recruiter: recruiter,
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
