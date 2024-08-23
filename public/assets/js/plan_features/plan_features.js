
/** add  template form validation */
$("#addPlanFeaturesForm").validate({
    ignore: [], // ignore NOTHING
    debug: false,
    rules: {
        "title": {
            required: true,
        },
        "description": {
            required:function(textarea){
                // CKEDITOR.instances.ckeditorBody.updateElement();
                CKEDITOR.instances[textarea.id].updateElement(); // update textarea
                var editorcontent = textarea.value.replace(/<[^>]*>/gi, ''); // strip tags
                return editorcontent.length === 0;
            },
            // required: true,
        },  
        "type": {
            required: true,
        },
        "icon": {
            required: function() {
                var origin = window.location.href;
                if (origin.indexOf("edit") != -1)
                return false;
                else
                return true;
            },
        },
        // "body": {
        //     required: function(){
        //         CKEDITOR.instances.ckeditorBody.updateElement();
        //     },
        // },
    },
    messages: {
        "title": {
            required: "Please enter title"
        },
        "description": {
            required: "Please enter description"
        },
        "type": {
            required: "Please enter type"
        },
        "icon": {
            required: "Please add icon"
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
 
/* $(".ckeditor").each(function(){
    $(this).rules("add", { 
        required:true,
        messages:{required:'Please write template body'}
    });
}); */

// $('.ckeditorBody').ckeditor();
var editor = CKEDITOR.replace( 'ckeditorBody', {
    allowedContent: true
} );


/** templates listing */
$(document).ready(function(){
    var origin = window.location.href;
    DatatableInitiate();

    /** delete template */
    $('#Tdatatable').on('click', 'tbody .template_delete', function () {
        var template_id = $(this).data('id');  
        var message = "Are you sure ?";   
        console.log(message);
        $('#templateDeleteModel').on('show.bs.modal', function(e){
            $('#template_id').val(template_id);
            $('#message_delete').text(message);
        });
        $('#templateDeleteModel').modal('show');              
    })

    $(document).on('click','#deleteTemplate', function(){
        var template_id = $('#template_id').val();
        console.log(template_id); 
        $.ajax({
            url: origin + '/../delete/' + template_id,
            method: "POST",    
            data: {
                "_token": $('#token').val(),
                id: template_id,
            },            
            success: function(response)
            {
                if(response.status == 'true')
                {
                    $('#templateDeleteModel').modal('hide')
                    DatatableInitiate();
                    toastr.clear();
                    toastr.options.closeButton = true;
                    toastr.success(response.msg);
                }
                else
                {
                    $('#templateDeleteModel').modal('hide')                  
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
        console.log(123);           
        var is_active = ($(this).attr('aria-pressed') === 'true') ? 0 : 1;         
        var template_id = $(this).data('id');
        var message = ($(this).attr('aria-pressed') === 'true') ? "Are you sure ?" : "Are you sure ?";        
        if($(this).attr('aria-pressed') == 'false')
        {
            $(this).addClass('active');
        }
        if($(this).attr('aria-pressed') == 'true')
        {
            $(this).removeClass('active');
        }                        
        $('#templateIsActiveModel').on('show.bs.modal', function(e){
            $('#template_id').val(template_id);
            $('#is_active').val(is_active);
            $('#message').text(message);
        });
        $('#templateIsActiveModel').modal('show');                                         
    });    

    
    /** Activate or deactivate template */
    $(document).on('click','#templateIsActive', function(){ 
        var template_id = $('#template_id').val();
        var is_active = $('#is_active').val(); 
        console.log(is_active);                           
        $.ajax({
            url: origin + '/../activeInactive',
            method: "POST",
            data:{
                "_token": $('#token').val(),
                "status":is_active,
                "id":template_id                  
            },
            success: function(response)
            {
                if(response.status == 'true')
                {                    
                    $('#templateIsActiveModel').modal('hide')
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
                searchPlaceholder: "Search by Title,Type,Sort Order,Des..."
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
            "columnDefs": [{
                "targets": [-1,5],
                "orderable": false
            },
            {
                targets: [4],
                orderable:false,
                "render": function (data, type, row) {
                        if (data)
                            return "<img class='img-rounded' style='max-width:50px;max-height:50px;min-width:50px;min-height:50px;' src='"+ data +"' />";
                        else
                            return '<span style="color: red"></span>'
                },
                className: "text-center"
            },
            {
                targets: [0,7],
                className: "hide_column"
            },
            {
                targets: [1],
                className: "opacity1 text-center",
                orderable: false
            },
            {
                targets: [6],
                className: "text-center"
            },
            {
                targets: [5],
                orderable: false
            },
            {
                targets: [1,2,3,4,5,6],
                className: "text-left"
            },
            {
                targets: [1],
                className: "text-center", orderable: false, searchable: false
            }],
            "order": [[0, "desc"]],
            "scrollX": true,
            "ajax": {
                url: "list", // json datasource
                data: { },
                error: function () {  // error handling
                    $(".Tdatatable-error").html("");
                    $("#Tdatatable").append('<tbody class="Tdatatable-error"><tr><th colspan="3">No data found in the server</th></tr></tbody>');
                    $("#Tdatatable_processing").css("display", "none");

                }
            },
            "bStateSave": true,
            "fnStateSave": function (oSettings, oData) {
                localStorage.setItem( 'DataTables_'+window.location.pathname, JSON.stringify(oData) );
            },
            "fnStateLoad": function (oSettings) {
                return JSON.parse( localStorage.getItem('DataTables_'+window.location.pathname) );
            }
        });
}

$(document).on("click", ".addmore", function (e) {
    countCc = countCc + 1;
    
    if (countCc == 0) {
        countCc = 1;
    }
    e.preventDefault();
    var str = '<div class="col-md-12" id="add-' + countCc + '"><div class="col-md-7 row"><div class="col-md-10"><div class="form-group"><div><input class="form-control" name = "emailCc[email_cc][' + countCc + ']" type = "email" value = "" style = "" data-temp-mail- org="0" /></div></div></div><div class="col-md-2"><div class="form-group" style = "margin-top:15px" ><div><a href = "javascript:void(0)" class="btn btn-success btn-xs addmore" style="margin-right:5px">+</a><a style="" href="javascript:void(0)" class="btn btn-danger btn-xs removemore" id="' + countCc + '">-</a></div></div></div></div></div>';
    $('.rowForCc').append(str);
});

$(document).on("click", ".removemore", function (e) {
    e.preventDefault();
    var id = $(this).attr('id');
    $("#add-" + id).remove();
});
