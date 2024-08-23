/** add  music cateogry form validation */
$("#addJobFieldForm").validate({
    ignore: [], // ignore NOTHING
    rules: {
        code: {
            required: true,
            minlength: 5,
            maxlength: 5
        },
        field_name: {
            required: true,
        },

    },
    messages: {
        "code": {
            required: "Please enter code"
        },
        "field_name": {
            required: "Please enter field name"
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
    $('#Tdatatable').on('click', 'tbody .job_field_delete', function () {
        var job_field_id = $(this).data('id');
        var message = "Are you sure ?";
        console.log(message);
        $('#JobFieldDeleteModel').on('show.bs.modal', function(e){
            $('#job_field_id').val(job_field_id);
            $('#message_delete').text(message);
        });
        $('#JobFieldDeleteModel').modal('show');
    })

    $(document).on('click','#deleteJobField', function(){
        var job_field_id = $('#job_field_id').val();
        $.ajax({
            url: origin + '/../delete/' + job_field_id,
            method: "POST",
            data: {
                "_token": $('#token').val(),
                job_field_id: job_field_id,
            },
            success: function(response)
            {
                if(response.status == 'true')
                {
                    $('#JobFieldDeleteModel').modal('hide')
                    DatatableInitiate();
                    toastr.clear();
                    toastr.options.closeButton = true;
                    toastr.success(response.msg);
                }
                else
                {
                    $('#JobFieldDeleteModel').modal('hide')
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


function DatatableInitiate() {
    $('#Tdatatable').DataTable(
        {
            language: {
                searchPlaceholder: "Search by name,code... "
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
                    targets: [0,5],
                    className: "hide_column"
                },
                {
                    targets: [1],
                    className: "opacity1 text-center",
                    "orderable": false
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
