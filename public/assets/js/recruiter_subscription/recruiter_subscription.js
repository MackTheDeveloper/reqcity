/** add  music cateogry form validation */
$("#addFanForm").validate({
    ignore: [], // ignore NOTHING
    rules: {
        "name": {
            required: true,
        },
        "status": {
            required: true,
        },
        "sort_order": {
            required: true,
        },
    },
    messages: {
        "name": {
            required: "Please enter name"
        },
        "status": {
            required: "Please enter name"
        },
        "sort_order": {
            required: "Please enter name"
        },
    },
    errorPlacement: function (error, element)
    {
        error.insertAfter(element)
    },
    submitHandler: function(form)
    {
        form.submit();
    }
});


/** music cateogrys listing */
$(document).ready(function(){
    var origin = window.location.href;
    DatatableInitiate();

    /** delete music cateogry */
    $('#Tdatatable').on('click', 'tbody .fan_delete', function () {
        var fan_id = $(this).data('id');
        var message = "Are you sure ?";
        console.log(message);
        $('#fanDeleteModel').on('show.bs.modal', function(e){
            $('#fan_id').val(fan_id);
            $('#message_delete').text(message);
        });
        $('#fanDeleteModel').modal('show');
    })

    $(document).on('click','#deletefan', function(){
        var fan_id = $('#fan_id').val();
        $.ajax({
            url: origin + '/../delete/' + fan_id,
            method: "POST",
            data: {
                "_token": $('#token').val(),
                fan_id: fan_id,
            },
            success: function(response)
            {
                if(response.status == 'true')
                {
                    $('#fanDeleteModel').modal('hide')
                    DatatableInitiate();
                    toastr.clear();
                    toastr.options.closeButton = true;
                    toastr.success(response.msg);
                }
                else
                {
                    $('#fanDeleteModel').modal('hide')
                    toastr.clear();
                    toastr.options.closeButton = true;
                    toastr.error(response.msg);
                }
            }
        });
    })

    $('#Tdatatable').on('click', '.active-inactive-link', function () {
        var toggleButton = $(this).closest('tr').find('.toggle-is-active-switch');
        toggleButton.trigger('click');
    });
    /** toggle active switch and show confirmation */
    $('#Tdatatable').on('click', 'tbody .toggle-is-active-switch', function () {
        var status = ($(this).attr('aria-pressed') === 'true') ? 0 : 1;
        var fan_id = $(this).data('id');
        var message = ($(this).attr('aria-pressed') === 'true') ? "Are you sure ?" : "Are you sure ?";
        if($(this).attr('aria-pressed') == 'false')
        {
            $(this).addClass('active');
        }
        if($(this).attr('aria-pressed') == 'true')
        {
            $(this).removeClass('active');
        }
        $('#fanIsActiveModel').on('show.bs.modal', function(e){
            $('#fan_id').val(fan_id);
            $('#status').val(status);
            $('#message').text(message);
        });
        $('#fanIsActiveModel').modal('show');
    });


    /** Activate or deactivate music cateogry */
    $(document).on('click','#fanIsActive', function(){
        var fan_id = $('#fan_id').val();
        var status = $('#status').val();
        $.ajax({
            url: origin + '/../activeInactive',
            method: "POST",
            data:{
                "_token": $('#token').val(),
                "status": status,
                "fan_id": fan_id
            },
            success: function(response)
            {
                if(response.status == 'true')
                {
                    $('#fanIsActiveModel').modal('hide')
                    DatatableInitiate();
                    toastr.clear();
                    toastr.options.closeButton = true;
                    toastr.success(response.msg);
                }
            }
        })
    });
})

$(document).on('click','#search_fan', function(){
    var startDate = $('#daterange').data('daterangepicker').startDate;
    var endDate = $('#daterange').data('daterangepicker').endDate;
    var status = $('#is_active').val();
    var subscription = $('#subscription_filter').val();
    var fromDate = startDate.format('YYYY-MM-DD');
    var toDate = endDate.format('YYYY-MM-DD');
    $('#exportSub #startDate').val(fromDate);
    $('#exportSub #endDate').val(toDate);
    $('#exportSub #status').val(status);
    $('#exportSub #subscription').val(subscription);
    DatatableInitiate(status,fromDate,toDate,subscription);
});

$('#Tdatatable').on('search.dt', function() {
    var value = $('.dataTables_filter input').val();
    $('#exportSub #search').val(value);
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


function DatatableInitiate(status='',startDate='',endDate='',subscription = '') {
    var token = $('input[name="_token"]').val();
    table = $('#Tdatatable').DataTable({
        language: {
            searchPlaceholder: "Search by Recruiter Name, Email, Subscription .."
        },
        "search": {
            "search": (dashboardSearch) ? dashboardSearch : ''
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
                targets: [2,3,5],
                "orderable": false
            },
            {
                targets: [0,1,2],
                className: "text-left",
            },
            {
                targets: [3,4,5,6,7],
                className: "text-center",
            },
            {
                targets: [4],
                "render": function (data, type, row) {
                       return '$'+ data;
                }
            },
            {
                targets: [5],
                "render": function (data, type, row) {
                        if (data == 1)
                            return '<span style="color: #0ba360">Paid</span>';
                        else
                            return '<span style="color: red">Unpaid</span>'
                }
            },

        ],
        "ajax": {
            url: 'list',
            data:{
                _token : token,
                is_active:status,
                startDate:startDate,
                endDate:endDate,
                subscription:subscription,
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
