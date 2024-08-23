    /** add  music cateogry form validation */
$("#addMusicCategoryForm").validate({
    ignore: [], // ignore NOTHING
    rules: {
        title: {
            required: true,
        },
        type: {
            required: true,
        },
        image: {
            required: function() {
                var origin = window.location.href;
                if (origin.indexOf("edit") != -1)
                return false;
                else
                return true;
              },
        },

    },
    messages: {
        "title": {
            required: "Please enter name"
        },
        "image": {
            required: "Please enter image"
        },
        "type": {
            required: "Please select type"
        },
    },
    errorPlacement: function(error, element) {
        if ( element.is(":radio") ) {
            error.prependTo( element.parent().parent() );
        }
        else { // This is the default behavior of the script
            error.insertAfter( element );
        }
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

    $('.expand_collapse_filter').on('click', function() {
        $(".expand_filter").toggle();
    })

    /** delete music cateogry */
    $('#Tdatatable').on('click', 'tbody .how_it_works_delete', function () {
        var how_it_works_id = $(this).data('id');
        var message = "Are you sure ?";
        console.log(message);
        $('#howItWorksDeleteModel').on('show.bs.modal', function(e){
            $('#how_it_works_id').val(how_it_works_id);
            $('#message_delete').text(message);
        });
        $('#howItWorksDeleteModel').modal('show');
    })

    $(document).on('click','#deletehowItWorks', function(){
        var how_it_works_id = $('#how_it_works_id').val();
        $.ajax({
            url: origin + '/../delete/' + how_it_works_id,
            method: "POST",
            data: {
                "_token": $('#token').val(),
                how_it_works_id: how_it_works_id,
            },
            success: function(response)
            {
                if(response.status == 'true')
                {
                    $('#howItWorksDeleteModel').modal('hide')
                    DatatableInitiate();
                    toastr.clear();
                    toastr.options.closeButton = true;
                    toastr.success(response.msg);
                }
                else
                {
                    $('#howItWorksDeleteModel').modal('hide')
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
        var how_it_works_id = $(this).data('id');
        var message = ($(this).attr('aria-pressed') === 'true') ? "Are you sure ?" : "Are you sure ?";
        if($(this).attr('aria-pressed') == 'false')
        {
            $(this).addClass('active');
        }
        if($(this).attr('aria-pressed') == 'true')
        {
            $(this).removeClass('active');
        }
        $('#howItWorksIsActiveModel').on('show.bs.modal', function(e){
            $('#how_it_works_id').val(how_it_works_id);
            $('#status').val(status);
            $('#message').text(message);
        });
        $('#howItWorksIsActiveModel').modal('show');
    });


    /** Activate or deactivate music cateogry */
    $(document).on('click','#howItWorksIsActive', function(){
        var how_it_works_id = $('#how_it_works_id').val();
        var status = $('#status').val();
        $.ajax({
            url: origin + '/../activeInactive',
            method: "POST",
            data:{
                "_token": $('#token').val(),
                "status": status,
                "how_it_works_id": how_it_works_id
            },
            success: function(response)
            {
                if(response.status == 'true')
                {
                    $('#howItWorksIsActiveModel').modal('hide')
                    DatatableInitiate();
                    toastr.clear();
                    toastr.options.closeButton = true;
                    toastr.success(response.msg);
                }
            }
        })
    });
})

$(document).on('click','#search_type', function(){
    var type = $('#type').val();
    // $('#exportArtist #type').val(type);
    DatatableInitiate(type);
});

function DatatableInitiate(type='') {
    $('#Tdatatable').DataTable(
        {
            language: {
                searchPlaceholder: "Search by Title..."
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
                    targets: [0],
                    className: "hide_column"
                },
                {
                    targets: [4],
                    className: "text-left",
                },
                {
                    targets: [1,2,3],
                    className: "text-center",
                },
                {
                    targets: [2,4],
                    "orderable": true
                },
                {
                    targets: [1,3],
                    "orderable": false
                },
                {
                    targets: [1],
                    className: "text-center", orderable: false, searchable: false
                }
            ],
            "order": [[2, "asc"]],
            "scrollX": true,
            "ajax": {
                url: "list", // json datasource
                data: {type:type},
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
$(document).on('change','input[name="type"]',function(){
   $('#addHowItWorks').removeAttr('disabled');
    var val = $(this).val();
    $.ajax({
        type:'POST',
        url: baseUrl + '/securerccontrol/how-it-works/checkType',
          headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
        data: {  type: val},
        dataType : 'json',
        success:function(response)
        {
          if(response.status == 'true')
          {
              toastr.clear();
              toastr.options.closeButton = true;
              $('#addHowItWorks').attr('disabled','disabled');
              toastr.error(response.msg);
          }
        }
    });
});
