/** caompany transaction listing */
$(document).ready(function () {
    var origin = window.location.href;
    DatatableInitiate();
});
$(document).on('click', '#search_recruiter_tax_forms', function () {
  var startDate = $('#daterange').data('daterangepicker').startDate;
  var endDate = $('#daterange').data('daterangepicker').endDate;
  var fil_recruiter = $('#recruiter').val();
  var fromDate = startDate.format('YYYY-MM-DD');
  var toDate = endDate.format('YYYY-MM-DD');
    DatatableInitiate(fil_recruiter,fromDate,toDate);
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


function DatatableInitiate(recruiter = '',startDate='',endDate='') {
    var token = $('input[name="_token"]').val();
    table = $('#Tdatatable').DataTable({
        language: {
            searchPlaceholder: "Search by Recruiter, Payment ID ..."
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
            {
                targets: [2],
                "orderable": false
            },
            {
                targets: [0,1],
                className: "text-left",
            },
            {
                targets: [ 2,3],
                className: "text-center",
            },
        ],
        "ajax": {
            url: 'list',
            data: {
                _token: token,
                recruiter: recruiter,
                startDate:startDate,
                endDate:endDate,
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
