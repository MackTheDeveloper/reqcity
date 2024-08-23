$("#addSubscriptionPlanForm").validate({
    ignore: [], // ignore NOTHING
    rules: {
        subscription_name: {
            required: true,
        },
        price: {
            required: true,
        },
        description: {
              required: function(textarea) {
            CKEDITOR.instances[textarea.id].updateElement(); // update textarea
            var editorcontent = textarea.value.replace(/<[^>]*>/gi, ''); // strip tags
            return editorcontent.length === 0;
          }
        },
        tag_line: {
            required: true,
        },
        icon: {
            required: function() {
                var origin = window.location.href;
                if (origin.indexOf("edit") != -1)
                return false;
                else
                return true;
              },
        },
        trial_period: {
            number: true,
            min:1
        },
    },
    messages: {
        "subscription_name": {
            required: "Please enter name"
        },
        "price": {
            required: "Please enter price"
        },
        "description": {
            required: "Please enter description"
        },
        "tag_line": {
            required: "Please enter tag line"
        },
        "icon":{
            required: "Please add icon with size 800 X 580 px"
        }

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
    $('#Tdatatable').on('click', 'tbody .subscription_plan_delete', function () {
        var subscription_plan_id = $(this).data('id');
        var message = "Are you sure ?";
        console.log(message);
        $('#SubscriptionPlanDeleteModel').on('show.bs.modal', function(e){
            $('#subscription_plan_id').val(subscription_plan_id);
            $('#message_delete').text(message);
        });
        $('#SubscriptionPlanDeleteModel').modal('show');
    })

    $(document).on('click','#deleteSubscriptionPlan', function(){
        var subscription_plan_id = $('#subscription_plan_id').val();
        $.ajax({
            url: origin + '/../delete/' + subscription_plan_id,
            method: "POST",
            data: {
                "_token": $('#token').val(),
                subscription_plan_id: subscription_plan_id,
            },
            success: function(response)
            {
                if(response.status == 'true')
                {
                    $('#SubscriptionPlanDeleteModel').modal('hide')
                    DatatableInitiate();
                    toastr.clear();
                    toastr.options.closeButton = true;
                    toastr.success(response.msg);
                }
                else
                {
                    $('#SubscriptionPlanDeleteModel').modal('hide')
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
        var subscription_plan_id = $(this).data('id');
        var message = ($(this).attr('aria-pressed') === 'true') ? "Are you sure ?" : "Are you sure ?";
        if($(this).attr('aria-pressed') == 'false')
        {
            $(this).addClass('active');
        }
        if($(this).attr('aria-pressed') == 'true')
        {
            $(this).removeClass('active');
        }
        $('#SubscriptionPlanIsActiveModel').on('show.bs.modal', function(e){
            $('#subscription_plan_id').val(subscription_plan_id);
            $('#status').val(status);
            $('#message').text(message);
        });
        $('#SubscriptionPlanIsActiveModel').modal('show');
    });


    /** Activate or deactivate music cateogry */
    $(document).on('click','#SubscriptionPlanIsActive', function(){
        var subscription_plan_id = $('#subscription_plan_id').val();
        var status = $('#status').val();
        $.ajax({
            url: origin + '/../activeInactive',
            method: "POST",
            data:{
                "_token": $('#token').val(),
                "status": status,
                "subscription_plan_id": subscription_plan_id
            },
            success: function(response)
            {
                if(response.status == 'true')
                {
                    $('#SubscriptionPlanIsActiveModel').modal('hide')
                    DatatableInitiate();
                    toastr.clear();
                    toastr.options.closeButton = true;
                    toastr.success(response.msg);
                }
            }
        })
    });
})


function DatatableInitiate() {
    $('#Tdatatable').DataTable(
        {
            language: {
                searchPlaceholder: "Search by name... "
            },            
            "bDestroy": true,
            "processing": true,
            "serverSide": true,
            "createdRow": function( row, data, dataIndex ) {
                $(row).addClass( data[0] );
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
                    targets: [0,7],
                    className: "hide_column"
                },
                {
                    targets: [1],
                    className: "opacity1 text-center",
                    "orderable": false
                },
                {
                    targets: [2,3,5],
                    className: "text-left",
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
                    "orderable": false
                },
                {
                    targets: [6],
                    className: "text-center",
                    "orderable": true
                },
                {
                    targets: [6],
                    "render": function (data, type, row) {
                        return '$' + data;
                    }
                },

            ],
            "scrollX": true,
            "ajax": {
                url: 'list', // json datasource
                data: { },
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
