/** caompany transaction listing */
$(document).ready(function () {
    var origin = window.location.href;
    DatatableInitiate();
});

$(document).on('click', '#search_details', function () {
    var startDate = $('#daterange').data('daterangepicker').startDate;
    var endDate = $('#daterange').data('daterangepicker').endDate;
    var status = $('#is_active').val();
    var type = $('#type').val();
    var fromDate = startDate.format('YYYY-MM-DD');
    var toDate = endDate.format('YYYY-MM-DD');
    DatatableInitiate(status, fromDate, toDate,type);
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


function DatatableInitiate(status = '0', startDate = '', endDate = '', type = '') {
    var token = $('input[name="_token"]').val();
    table = $('#Tdatatable').DataTable({
        language: {
            searchPlaceholder: "Search by Name, Email..."
        },
        searching: true,
        "bDestroy": true,
        "processing": true,
        "serverSide": true,
        "scrollX": true,
        "columnDefs": [
            {
                targets: [0],
                "orderable": false,
                className: "hide_column"
            },
            {
                targets: [1],
                "orderable": false,
                className: "text-center",
            },
            {
                targets: [2],
                "render": function (data, type, row) {
                    if (data == 1)
                        return 'Company';
                    else if (data == 2)
                        return 'Recruiter'
                },
                className: "text-center",
            },
            {
                targets: [3, 4, 5, 6],
                className: "text-left",
            },
            {
                targets: [5, 6, 8],
                "orderable": false
            },
            {
                targets: [6],
                "render": function (data, type, row) {
                    if(data.length > 15) {
                        data = data.substr(0, 15);
                        return data+"...";
                    }else{
                        return data;
                    }
                },
            },
            {
                targets: [8],
                "render": function (data, type, row) {
                    if (data == 1)
                        return '<span style="color: #0ba360">Completed</span>';
                    else if (data == 0)
                        return '<span style="color: #e0ce09">Pending</span>'
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
                type: type,
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


    
    $(document).on('click', 'tbody .view-link', function (e) {
        var origin = window.location.href;
        var id = $(this).data('id');
        $('#viewDetailsModel').on('show.bs.modal', function (e) {    
            $.ajax({
                type: "GET",
                url: "bank-detail",
                url: origin + '/../view-details',
                method: "POST",
                data: {
                    "_token": $('#token').val(),
                    id: id,
                },
                success: function (result) {
                    var type = (result.data.type == 1)? "Company" : "Recruiter";
                    var status = (result.data.status == 0)? "Pending" : "Completed";
                    $('#name').text(result.data.first_name);
                    $('#demo-type').text(type);
                    $('#email').text(result.data.email);
                    $('#phone').text(result.data.phone);
                    $('#demo-status').text(status);
                    $('#requirement').text(result.data.requirement);
                    $('#created_at').text(result.created_at);
                    
                    
                    
                },
                error: function (result) {
                    console.log('error in getting bank details');
                }

            });
            e.stopImmediatePropagation();
        });
        $('#viewDetailsModel').modal('show');

    });

    $('#Tdatatable').on('click', 'tbody .mark-complete', function () {
        var id = $(this).data('id');
        var message = "Are you sure ?";
        console.log(message);
        $('#demoCompletedModel').on('show.bs.modal', function(e){
            $('#demo-req-id').val(id);
            $('#message_approve').text(message);
        });
        $('#demoCompletedModel').modal('show');
    })

    $(document).on('click','#markAsCompleted', function(){
        var origin = window.location.href;
        var id = $('#demo-req-id').val();
        $.ajax({
            url: origin + '/../mark-completed',
            method: "POST",
            data: {
                "_token": $('#token').val(),
                id: id,
            },
            success: function(response)
            {
                if(response.status == 'true')
                {
                    $('#demoCompletedModel').modal('hide')
                    DatatableInitiate();
                    toastr.clear();
                    toastr.options.closeButton = true;
                    toastr.success(response.msg);
                }
                else
                {
                    $('#demoCompletedModel').modal('hide')
                    toastr.clear();
                    toastr.options.closeButton = true;
                    toastr.error(response.msg);
                }
            }
        });
    })

}
