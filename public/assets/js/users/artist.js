var editorBio = CKEDITOR.replace( 'ckeditor-bio', {
    allowedContent: true
} );
var editorEvent = CKEDITOR.replace( 'ckeditor-event', {
    allowedContent: true
} );
var editorNews = CKEDITOR.replace( 'ckeditor-news_detail', {
    allowedContent: true
} );
/** add  music cateogry form validation */
$("#addArtistForm").validate({
    ignore: [], // ignore NOTHING
    rules: {
        "firstname": {
            required: true,
        },
        "lastname": {
            required: true,
        },
        "email": {
            required: true,
            email: true
        },
        "phone": {
            required: true,
            number: true
        },
        "user_profile_photos" : {
            extension: "png|jpg"
        }
    },
    messages: {
        "firstname": {
            required: "Please enter first name"
        },
        "lastname": {
            required: "Please enter last name"
        },
        "email": {
            required: "Please enter email"
        },
        "phone": {
            required: "Please enter phone"
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
    $('#Tdatatable').on('click', 'tbody .artist_delete', function () {
        var artist_id = $(this).data('id');
        var message = "Are you sure ?";
        console.log(message);
        $('#artistDeleteModel').on('show.bs.modal', function(e){
            $('#artist_id').val(artist_id);
            $('#message_delete').text(message);
        });
        $('#artistDeleteModel').modal('show');
    })

    $(document).on('click','#deleteartist', function(){
        var artist_id = $('#artist_id').val();
        $.ajax({
            url: origin + '/../delete/' + artist_id,
            method: "POST",
            data: {
                "_token": $('#token').val(),
                artist_id: artist_id,
            },
            success: function(response)
            {
                if(response.status == 'true')
                {
                    $('#artistDeleteModel').modal('hide')
                    DatatableInitiate();
                    toastr.clear();
                    toastr.options.closeButton = true;
                    toastr.success(response.msg);
                }
                else
                {
                    $('#artistDeleteModel').modal('hide')
                    toastr.clear();
                    toastr.options.closeButton = true;
                    toastr.error(response.msg);
                }
            }
        });
    })
 
    $('#Tdatatable').on('click', '.active-inactive-link', function () {
        var status = $(this).data('status');
        var artist_id = $(this).data('id');
        var message = "Are you sure ?";
        $('#artistIsActiveModel').on('show.bs.modal', function(e){
            $('#artist_id').val(artist_id);
            $('#status').val(status);
            $('#message').text(message);
        });
        $('#artistIsActiveModel').modal('show');
    });
    $('#Tdatatable').on('click', '.approve-unaprove-link', function () {
        var approve = $(this).data('status');
        var artist_id = $(this).data('id');
        var message = "Are you sure ?";
        $('#artistIsApproveModel').on('show.bs.modal', function(e){
            $('#artist_id').val(artist_id);
            $('#approve').val(approve);
            $('#messageApprove').text(message);
        });
        $('#artistIsApproveModel').modal('show');
    }); 
    /** toggle active switch and show confirmation */
    // $('#Tdatatable').on('click', 'tbody .toggle-is-active-switch', function () {
    //     var status = ($(this).attr('aria-pressed') === 'true') ? 0 : 1;
    //     var artist_id = $(this).data('id');
    //     var message = ($(this).attr('aria-pressed') === 'true') ? "Are you sure ?" : "Are you sure ?";
    //     if($(this).attr('aria-pressed') == 'false')
    //     {
    //         $(this).addClass('active');
    //     }
    //     if($(this).attr('aria-pressed') == 'true')
    //     {
    //         $(this).removeClass('active');
    //     }
    //     $('#artistIsActiveModel').on('show.bs.modal', function(e){
    //         $('#artist_id').val(artist_id);
    //         $('#status').val(status);
    //         $('#message').text(message);
    //     });
    //     $('#artistIsActiveModel').modal('show');
    // });


    /** Activate or deactivate music cateogry */
    $(document).on('click','#artistIsActive', function(){
        var artist_id = $('#artist_id').val();
        var status = $('#status').val();
        $.ajax({
            url: origin + '/../activeInactive',
            method: "POST",
            data:{
                "_token": $('#token').val(),
                "status": status,
                "artist_id": artist_id
            },
            success: function(response)
            {
                if(response.status == 'true')
                {
                    $('#artistIsActiveModel').modal('hide')
                    DatatableInitiate();
                    toastr.clear();
                    toastr.options.closeButton = true;
                    toastr.success(response.msg);
                }
            }
        })
    });

    // $('#Tdatatable').on('click', 'tbody .toggle-is-approve-switch', function () {
    //     var approve = ($(this).attr('aria-pressed') === 'true') ? 0 : 1;
    //     var artist_id = $(this).data('id');
    //     var message = ($(this).attr('aria-pressed') === 'true') ? "Are you sure ?" : "Are you sure ?";
    //     if($(this).attr('aria-pressed') == 'false')
    //     {
    //         $(this).addClass('active');
    //     }
    //     if($(this).attr('aria-pressed') == 'true')
    //     {
    //         $(this).removeClass('active');
    //     }
    //     $('#artistIsApproveModel').on('show.bs.modal', function(e){
    //         $('#artist_id').val(artist_id);
    //         $('#approve').val(approve);
    //         $('#messageApprove').text(message);
    //     });
    //     $('#artistIsApproveModel').modal('show');
    // });


    /** Activate or deactivate music cateogry */
    $(document).on('click','#artistIsApprove', function(){
        var artist_id = $('#artist_id').val();
        var approve = $('#approve').val();
        $.ajax({
            url: origin + '/../approve',
            method: "POST",
            data:{
                "_token": $('#token').val(),
                "approve": approve,
                "artist_id": artist_id
            },
            success: function(response)
            {
                if(response.status == 'true')
                {
                    $('#artistIsApproveModel').modal('hide')
                    DatatableInitiate();
                    toastr.clear();
                    toastr.options.closeButton = true;
                    toastr.success(response.msg);
                }
            }
        })
    });
})

$(document).on('click','#search_artist', function(){
    var startDate = $('#daterange').data('daterangepicker').startDate;
    var endDate = $('#daterange').data('daterangepicker').endDate;
    var status = $('#is_active').val();
    var approval = $('#is_verify').val();
    var country = $('#country_filter').val();
    fromDate = startDate.format('YYYY-MM-DD');
    toDate = endDate.format('YYYY-MM-DD');
    $('#exportArtist #startDate').val(fromDate);
    $('#exportArtist #endDate').val(toDate);
    $('#exportArtist #status').val(status);
    $('#exportArtist #country').val(country);
    $('#exportArtist #approval').val(approval);
    DatatableInitiate(status,fromDate,toDate,approval,country);
});

$('#Tdatatable').on('search.dt', function() {
    var value = $('.dataTables_filter input').val();
    $('#exportArtist #search').val(value);
});

// song list
$(document).on('click','.showSongsList',function(){
    var artistId = $(this).data('id');
    $('#clickArtistId').val(artistId);
    $('#postSongList').submit();
    
});

function DatatableInitiate(status='',startDate='',endDate='',approval='',country='') {
    var token = $('input[name="_token"]').val();
    table = $('#Tdatatable').DataTable({
        buttons: [
            {
                extend: 'csv',
            }
        ],
        language: {
            searchPlaceholder: "Search by Name, Email..."
        },
        "search": {
            "search": (dashboardSearch) ? dashboardSearch : ''
        },
        searching: false,
        "bDestroy": true,
        "processing": true,
        "serverSide": true,
        "createdRow": function( row, data, dataIndex ) {
            $(row).addClass( data[0] );
        },
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
                targets: [1],
                className: "opacity1 text-center"
            },
            {
                targets: [3,4,5,6,7],
                className: "text-left"
            },
            {
                targets: [1,2,8,9],
                className: "text-center"
            },
            {
                targets: [1,2,5,6],
                "orderable": false
            },
            {
                targets: [3,4,7,8,9],
                "orderable": true
            },
            // {
            //     targets: [3],
            //     className: "text-center",
            //     "orderable": true
            // },
            {
                targets: [1],
                className: "text-center", orderable: false, searchable: false
            }
        ],
        "order": [[9, "desc"]],
        "scrollX": true,
        "ajax": {
            url: "list", // json datasource
            data:{
                _token : token,
                is_active:status,
                startDate:startDate,
                endDate:endDate,
                country:country,
                approval:approval,
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
    $("#export").on("click", function() {
        table.button( '.buttons-csv' ).trigger();
    });
}
