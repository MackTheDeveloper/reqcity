/** Assigned Job listing */
$(document).ready(function () {
    var origin = window.location.href;
    DatatableInitiate();
});

$(document).on('click', '#search_candidate', function () {
    var startDate = $('#daterange').data('daterangepicker').startDate;
    var endDate = $('#daterange').data('daterangepicker').endDate;
    var status = $('#is_active').val();
    // var company = $('#company').val();
    var fromDate = startDate.format('YYYY-MM-DD');
    var toDate = endDate.format('YYYY-MM-DD');
    $('#exportCandidateListing #startDate').val(fromDate);
    $('#exportCandidateListing #endDate').val(toDate);
    $('#exportCandidateListing #status').val(status);
    // $('#exportCandidateListing #company_name').val(company);
    DatatableInitiate(status, fromDate, toDate);
});

$('#Tdatatable').on('search.dt', function () {
    var value = $('.dataTables_filter input').val();
    $('#exportCandidateListing #search').val(value);
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


function DatatableInitiate(status = '1', startDate = '', endDate = '', company = '') {
    var token = $('input[name="_token"]').val();
    table = $('#Tdatatable').DataTable({
        language: {
            searchPlaceholder: "Search by Candidate, Job Title, Company..."
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
                targets: [1,5,6],
                orderable:false,
                className: "text-center"
            },
            {
                targets: [1,2,3,4,7],
                className: "text-left",
            },
            {
                targets: [8,9],
                className: "text-center",
            },
            {
                targets: [6],
                "render": function (data, type, row) {
                    if (data == 0)
                        return '<span style="color:#e0ce09 ">Pending</span>';
                    else if (data == 1)
                        return '<span style="color: #4C65FF">Assigned</span>';
                    else if (data == 2)
                        return '<span style="color: #0ba360">Submitted</span>';
                    else if (data == 3)
                        return '<span style="color: #3ac47d">Accepted</span>';    
                    else if (data == 4)
                        return '<span style="color: red">Rejected</span>';
                },
                className: "text-center",
            },
            {
                targets: [7],
                "render": function (data, type, row) {
                    if (data == "" || data == null)
                        return '<center>N/A</center>';
                    else
                        if(data.length > 15) {
                            data = data.substr(0, 15);
                            return data+"...";
                        }else{
                            return data
                        } 
                },
                className: "text-left",
                orderable: false
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
                // company:company,
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


    //show a confirmation message on submit candidate
    $('#Tdatatable').on('click', 'tbody .submit-candidate', function () {
        var id = $(this).data('id');
        var message = "Are you sure ?";
        $('#submitCandidateModel').on('show.bs.modal', function(e){
            $('#candidate_id').val(id);
            $('#message').text(message);
        });
        $('#submitCandidateModel').modal('show');
    });

}
