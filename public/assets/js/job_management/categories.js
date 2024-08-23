/** add  music cateogry form validation */
$("#addCategoryForm").validate({
    ignore: [], // ignore NOTHING
    rules: {
        title: {
            required: true,
        },
        slug: {
            required: true,
        },
    },
    messages: {
        "title": {
            required: "Please enter title"
        },
        "slug": {
            required: "Please enter slug"
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
    DatatableInitiate(catId);

    /** delete music cateogry */
    $('#Tdatatable').on('click', 'tbody .category_delete', function () {
        var categories_id = $(this).data('id');
        var message = "Are you sure ?";
        console.log(message);
        $('#CategoriesDeleteModel').on('show.bs.modal', function(e){
            $('#categories_id').val(categories_id);
            $('#message_delete').text(message);
        });
        $('#CategoriesDeleteModel').modal('show');
    })

    $(document).on('click','#deleteCategories', function(){
        var categories_id = $('#categories_id').val();
        $.ajax({
            url: baseUrl + '/securerccontrol/category/delete/' + categories_id,
            method: "POST",
            data: {
                "_token": $('#token').val(),
                categories_id: categories_id,
            },
            success: function(response)
            {
                if(response.status == 'true')
                {
                    $('#CategoriesDeleteModel').modal('hide')
                    DatatableInitiate(catId);
                    toastr.clear();
                    toastr.options.closeButton = true;
                    toastr.success(response.msg);
                }
                else
                {
                    $('#CategoriesDeleteModel').modal('hide')
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
        var categories_id = $(this).data('id');
        var message = ($(this).attr('aria-pressed') === 'true') ? "Are you sure ?" : "Are you sure ?";
        if($(this).attr('aria-pressed') == 'false')
        {
            $(this).addClass('active');
        }
        if($(this).attr('aria-pressed') == 'true')
        {
            $(this).removeClass('active');
        }
        $('#CategoriesIsActiveModel').on('show.bs.modal', function(e){
            $('#categories_id').val(categories_id);
            $('#status').val(status);
            $('#message').text(message);
        });
        $('#CategoriesIsActiveModel').modal('show');
    });


    /** Activate or deactivate music cateogry */
    $(document).on('click','#CategoriesIsActive', function(){
        var categories_id = $('#categories_id').val();
        var status = $('#status').val();
        $.ajax({
            url: baseUrl + '/securerccontrol/category/activeInactive',
            method: "POST",
            data:{
                "_token": $('#token').val(),
                "status": status,
                "categories_id": categories_id
            },
            success: function(response)
            {
                if(response.status == 'true')
                {
                    $('#CategoriesIsActiveModel').modal('hide')
                    DatatableInitiate(catId);
                    toastr.clear();
                    toastr.options.closeButton = true;
                    toastr.success(response.msg);
                }
            }
        })
    });
})
// Generate slug based on title entered
function generateSlug()
{
    var titleValue = $("#title").val();

    $("#slug").val(titleValue.replace(/\W+/g, '-').toLowerCase());
}

function DatatableInitiate(catId="") {
    if(catId == null)
    {
        url = "list"
    }
    else
    {
        url = "list?catId="+ catId
    }
    $('#Tdatatable').DataTable(
        {
            language: {
                searchPlaceholder: "Search by title,slug ... "
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
                    className: "text-center", orderable: true, searchable: false
                }
            ],
            "scrollX": true,
            "ajax": {
                url: "list?catId="+ catId, // json datasource
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
