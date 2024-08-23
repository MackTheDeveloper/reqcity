/** caompany transaction listing */
$(document).ready(function () {
    var origin = window.location.href;
    DatatableInitiate();
});


$('#Tdatatable').on('search.dt', function () {
    var value = $('.dataTables_filter input').val();
    $('#exportCandidateListing #search').val(value);
});

function DatatableInitiate() {
    var token = $('input[name="_token"]').val();
    table = $('#Tdatatable').DataTable({
        language: {
            searchPlaceholder: "Search by Title, Sub Title..."
        },
        searching: false,
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
                targets: [1],
                className: "opacity1 text-center",
                orderable: false
            },
            {
                targets: [2, 3],
                className: "text-left",
                orderable:false,
            },
            {
                targets: [4],
                className: "text-center",
                orderable:false,
            },

        ],
        "ajax": {
            url: 'list',
            data: {},
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
// add category validation
$("#editHomePageBannerForm").validate({
    ignore: [], // ignore NOTHING
    rules: {
        "title": {
            required: true,
        },
        "sub_title": {
            required: true,
        },
        "main_banner": {
          required: function() {
              var origin = window.location.href;
              if (origin.indexOf("edit") != -1)
              return false;
              else
              return true;
          },
            accept: "jpg,jpeg,png"
        },
        "highlight_jobs_banner	" :{
            accept: "jpg,jpeg,png"
        },

    },
    messages: {
        "title": {
            required: "Please enter title"
        },
        "sub_title": {
            required: "Please enter sub title",
        },
        'main_banner' :{
            required: "Please select banner",
            accept: "Please upload file in these format only (png, jpg, jpeg)."
        },
        "highlight_jobs_banner	" :{
            accept: "Please upload file in these format only (png, jpg, jpeg)."
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
