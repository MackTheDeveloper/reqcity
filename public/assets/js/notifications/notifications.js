/** music cateogrys listing */
$(document).ready(function(){
    var origin = window.location.href;
    DatatableInitiate();

    /** delete music cateogry */
    $(document).on('click', '.notification-read-unread', function () {
        var status = $(this).data('status');
        var message = "Are you sure ?";
        var checkedIds = [];
        $('#Tdatatable').find('input[type="checkbox"]:checked').each(function () {
            if (this.checked) {
                checkedIds.push(this.value)
            }
        });
        if(checkedIds.length <=0 || checkedIds == ""){
            $('#NotificationAlertModel').on('show.bs.modal', function(e){
                $('#message_notification_alert').text("Please Select atleast one record");
            });
            $('#NotificationAlertModel').modal('show');    
        }else{

            $('#NotificationModel').on('show.bs.modal', function(e){
                $('#notification_status').val(status);
                $('#message_notification').text(message);
            });
            $('#NotificationModel').modal('show');
        }
    })

    $(document).on('click','#readUnreadNotification', function(){
      var status = $('#notification_status').val();
      var checkedIds = [];
      $('#Tdatatable').find('input[type="checkbox"]:checked').each(function () {
          if (this.checked) {
              checkedIds.push(this.value)
          }
      });
        $.ajax({
            url: baseUrl + '/securerccontrol/notifications/notificationReadUnread' ,
            method: "POST",
            data: {
                "_token": $('#token').val(),
                status: status,
                checkedIds: checkedIds,
            },
            success: function(response)
            {
                if(response.status == 'true')
                {
                    $('#NotificationModel').modal('hide')
                    DatatableInitiate();
                    toastr.clear();
                    toastr.options.closeButton = true;
                    toastr.success(response.msg);
                }
                else
                {
                    $('#NotificationModel').modal('hide')
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
        var job_field_id = $(this).data('id');
        var message = ($(this).attr('aria-pressed') === 'true') ? "Are you sure ?" : "Are you sure ?";
        if($(this).attr('aria-pressed') == 'false')
        {
            $(this).addClass('active');
        }
        if($(this).attr('aria-pressed') == 'true')
        {
            $(this).removeClass('active');
        }
        $('#JobFieldIsActiveModel').on('show.bs.modal', function(e){
            $('#job_field_id').val(job_field_id);
            $('#status').val(status);
            $('#message').text(message);
        });
        $('#JobFieldIsActiveModel').modal('show');
    });


    /** Activate or deactivate music cateogry */
    $(document).on('click','#JobFieldIsActive', function(){
        var job_field_id = $('#job_field_id').val();
        var status = $('#status').val();
        $.ajax({
            url: origin + '/../activeInactive',
            method: "POST",
            data:{
                "_token": $('#token').val(),
                "status": status,
                "job_field_id": job_field_id
            },
            success: function(response)
            {
                if(response.status == 'true')
                {
                    $('#JobFieldIsActiveModel').modal('hide')
                    DatatableInitiate();
                    toastr.clear();
                    toastr.options.closeButton = true;
                    toastr.success(response.msg);
                }
            }
        })
    });
})
$(document).on('click', '.notification_filter_btn', function () {
    var status = $(this).data('show_status');
    if(status==1)
    $('.show_status_btn').html('<button id="show_status" data-show_status="2" class="mb-2 mr-2 btn-icon btn-square btn btn-primary btn-sm notification_filter_btn">Show Read</button>');
    else if(status==2)
    $('.show_status_btn').html('<button id="show_status" data-show_status="0" class="mb-2 mr-2 btn-icon btn-square btn btn-primary btn-sm notification_filter_btn">Show All</button>');
    else
    $('.show_status_btn').html('<button id="show_status" data-show_status="1" class="mb-2 mr-2 btn-icon btn-square btn btn-primary btn-sm notification_filter_btn">Show Unread</button>');
    DatatableInitiate(status);
});

function DatatableInitiate(status="") {
    $('#Tdatatable').DataTable(
        {
            language: {
                searchPlaceholder: "Search by message... "
            },
            "bDestroy": true,
            "processing": true,
            "serverSide": true,
            "createdRow": function( row, data, dataIndex ) {
                $(row).addClass( data[0] );
                if( data[5] ==  1){
                    $(row).css("background-color", "#eeeeee");
                }
            },
            /* 'stateSave': true,
            stateSaveParams: function (settings, data) {
                delete data.order;
            }, */
            "columnDefs": [
                // {
                //     targets : [-1],
                //     "orderable": false
                // },
                {
                    targets: [0,5],
                    className: "hide_column"
                },
                {
                    targets : [1],
                    "orderable": false,
                    class :"text-center"
                },
                {
                    targets: [2,3],
                    className: "text-left",
                    "orderable": true
                 },
                // {
                //     targets: [2],
                //     className: "text-center",
                //     "render": function(data, type, row) {
                //         return '<img width="50" height="50" src="http://localhost/clubfan1/public/securefcbcontrol/music_language/'+data+'" />';
                //     },
                //     "orderable": true
                // },
                {
                    targets: [4],
                    className: "text-center",
                    "orderable": true
                },



            ],
            "order": [[3, "desc"]],
            "scrollX": true,
            "ajax": {
                url: 'list', // json datasource
                data: {is_active: status },
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

        // Select all checkbox at
        $('#selectAll').on('click', function () {
            var checked = $(this).is(':checked'); // Checkbox state

            // Select all
            if (checked) {
                $("#Tdatatable td input[type=checkbox]").prop('checked', true);
            } else {
                $("#Tdatatable td input[type=checkbox]").prop('checked', false);
            }
        });

        //uncheck checkbox
        $('#Tdatatable tbody').on('change', 'input[type="checkbox"]', function () {
            if (!this.checked) {
                var el = $('#selectAll').get(0);
                if (el && el.checked && ('indeterminate' in el)) {
                    el.indeterminate = true;
                }
            }
        });

        //remove select all from hidden input and add check id in global array
        $('#Tdatatable').on('click', 'input[type="checkbox"]', function() {
            $('#checked').val("");
            if($(this).is(':checked')){
                checkedId.push(this.value);
            }else{
                checkedId.pop(this.value);
            }
        });


}
