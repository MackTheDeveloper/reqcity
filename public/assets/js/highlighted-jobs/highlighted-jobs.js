$(document).ready(function () {
    var origin = window.location.href;
    DatatableInitiate();
});

$(document).on('click', '#search_jobs', function () {
    var startDate = $('#daterange').data('daterangepicker').startDate;
    var endDate = $('#daterange').data('daterangepicker').endDate;
    var status = $('#is_active').val();
    var company = $('#company').val();
    var fromDate = startDate.format('YYYY-MM-DD');
    var toDate = endDate.format('YYYY-MM-DD');
    DatatableInitiate(status, fromDate, toDate ,company);
});

$('#Tdatatable').on('search.dt', function () {
    var value = $('.dataTables_filter input').val();
    $('#exportCandidateListing #search').val(value);
});

function DatatableInitiate(status = '1', startDate = '', endDate = '', company = '') {
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
                targets: [2,3],
                className: "text-left",
            },
            {
                targets: [1],
                className: "text-center",
                orderable:false,
            },
            {
                targets: [4,5,6],
                className: "text-center",
                orderable:true,
            },

        ],
        "ajax": {
            url: 'list',
            data: {
                _token: token,
                status: status,
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

    $('#Tdatatable').on('click', 'tbody .markRemoved', function () {
        var id = $(this).data('id');
        var message = "Are you sure ?";
        $('#jobRemoveModel').on('show.bs.modal', function(e){
            $('#jobId').val(id);
            $('#message_remove').text(message);
        });
        $('#jobRemoveModel').modal('show');
    });

    $(document).on('click','#removeJob', function(e){
        var origin = window.location.href;
        var id = $('#jobId').val();
        $.ajax({
            url: 'remove-job',
            method: "POST",
            data: {
                "_token": $('#token').val(),
                id: id,
            },
            success: function(response)
            {
                if(response.status == 'true')
                {
                    $('#jobRemoveModel').modal('hide')
                    DatatableInitiate();
                    toastr.clear();
                    toastr.options.closeButton = true;
                    toastr.success(response.msg);
                }
                else
                {
                    $('#JobBalanceRejectModel').modal('hide')
                    toastr.clear();
                    toastr.options.closeButton = true;
                    toastr.error(response.msg);
                }
            }
        });
        e.stopImmediatePropagation();
    });


}
