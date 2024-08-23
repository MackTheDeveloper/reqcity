/** caompany transaction listing */
var origin = window.location.href;
$(document).ready(function () {
    DatatableInitiate();
});


function DatatableInitiate() {
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
                targets: [1, 4, 5, 6],
                "orderable": false,
            },
        ],
        "ajax": {
            url: origin + '../../../candidate/list',
            data: {
                _token: token,
                userIdofRecruiter: userIdofRecruiter
            },
            error: function () {  // error handling
                $(".Tdatatable-error").html("");
                $("#Tdatatable").append('<tbody class="Tdatatable-error"><tr><th colspan="3">No data found in the server</th></tr></tbody>');
                $("#Tdatatable_processing").css("display", "none");

            }
        },
    });
}
