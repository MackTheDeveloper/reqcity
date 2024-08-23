/** caompany transaction listing */
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

$(document).ready(function () {
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
            searchPlaceholder: "Search by Name, Job Title, City..."
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
                targets: [0],
                "orderable": false,
                class: "hide_column"
            },
            {
                targets: [1,2],
                orderable: false,
                className: "text-center"
            },
            {
                targets: [1, 2, 3, 4, 5, 6, 7, 8, 9],
                className: "text-left",
            },
            {
                targets: [10],
                className: "text-center",
                orderable: false,
            },
            {
                targets: [12],
                "render": function (data, type, row) {
                    if (data == 1)
                        return '<span style="color: #0ba360">Active</span>';
                    else if (data == 3)
                        return '<span style="color: red">Suspended</span>';
                    else if (data == 2)
                        return '<span style="color: #e0ce09">Inactive</span>'
                },
                className: "text-center",
            },
            // {
            //     targets: [ 5],
            //     className: "hide_column text-center",
            // },

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

    /** Active inactive Candidate */
    $('#Tdatatable').on('click', '.active-inactive-link', function () {
        var is_active = $(this).data("status");
        var candidate_id = $(this).data("id");
        var message = "Are you sure ?";
        $('#CandidateIsActiveModel').on('show.bs.modal', function(e){
            $('#CandidateIsActiveModel #candidate_id').val(candidate_id);
            $('#status').val(is_active);
            $('#message').text(message);
        });
        $('#CandidateIsActiveModel').modal('show');
    });

    $(document).on('click','#CandidateIsActive', function(e){
        var candidate_id = $('#candidate_id').val();
        var status = $('#status').val() == 1 ? 2 : 1;
        var origin = window.location.href;
        $.ajax({
            url: origin + '/../activate-deactivate',
            method: "POST",
            data:{
                "_token": $('#token').val(),
                "status":status,
                "candidate_id":candidate_id
            },
            success: function(response)
            {
                if(response.status == 'true')
                {
                    $('#CandidateIsActiveModel').modal('hide')
                    // table.ajax.reload();
                    toastr.clear();
                    toastr.options.closeButton = true;
                    toastr.success(response.msg);
                    // location.reload();
                    DatatableInitiate()
                }
            }
        })
        e.stopImmediatePropagation();
    });

}
