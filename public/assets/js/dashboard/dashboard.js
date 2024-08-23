var origin = window.location.href;
var baseUrl = document.currentScript.getAttribute("data-base-url");
$(document).ready(function () {
    $("#from_date").datepicker({
        format: "mm/dd/yyyy",
        autoclose: true,
        orientation: "top",
        endDate: "today",
    });

    $("#to_date").datepicker({
        format: "mm/dd/yyyy",
        autoclose: true,
        orientation: "top",
        endDate: "today",
    });

    $(".radioBtnGraph1Duration").click(function () {
        displayCustomerTrafficGraph($(this).val());
    });
    $(".radioBtnDuration").click(function () {
        displayRevenuePayoutGraph($(this).val());
    });

    displayCustomerTrafficGraph("daily");
    displayRevenuePayoutGraph("monthly");
    DatatableInitiate();
});

// var baseUrl = $('#baseUrl').val();
function displayCustomerTrafficGraph(duration) {
    $("#customer-traffic")
        .css("text-align", "center")
        .html('<img src="../public/images/wait.gif" />');
    $.ajax({
        url: "dashboard/monthly-graph/" + duration,
        method: "GET",
        success: function (response) {
            if (response.status) {
                var options777 = {
                    chart: {
                        height: 397,
                        type: "line",
                        toolbar: {
                            show: false,
                        },
                    },
                    series: [
                        {
                            name: "Total Companies",
                            type: "column",
                            data: response.total_companies,
                        },
                        {
                            name: "Total Recruiter",
                            type: "column",
                            data: response.total_recruiter,
                        },
                        {
                            name: "Total Candidates",
                            type: "column",
                            data: response.total_candidates,
                        },
                    ],
                    stroke: {
                        width: [1, 1, 1],
                    },
                    legend: {
                        position: "top",
                    },
                    labels: response.dates_array,
                    xaxis: {
                        //type: 'datetime',
                        type: "category",
                        categories: response.dates_array,
                        labels: {
                            show: true,
                            rotate: -45,
                            rotateAlways: duration == "daily" ? true : false,
                        },
                    },
                    yaxis: [
                        {
                            seriesName: "Total Counts",
                            opposite: false,
                            title: {
                                text: "Total Counts",
                                style: {
                                    color: "#298ffb",
                                },
                            },
                        },
                        // {
                        //     seriesName: "Total Recruiter",
                        //     opposite: true,
                        //     title: {
                        //         text: "Total Recruiter",
                        //         style: {
                        //             color: "#00e396",
                        //         },
                        //     },
                        // },
                        // {
                        //     seriesName: "Total Candidates",
                        //     opposite: true,
                        //     title: {
                        //         text: "Total Candidates",
                        //         style: {
                        //             color: "#FEB019",
                        //         },
                        //     },
                        // },
                    ],
                };

                var chart777 = new ApexCharts(
                    document.querySelector("#customer-traffic"),
                    options777
                );

                setTimeout(function () {
                    $("#customer-traffic").html("");
                    if (document.getElementById("customer-traffic")) {
                        chart777.render();
                    }
                }, 1000);
            }
        },
    });
}

function displayRevenuePayoutGraph(duration) {
    $("#revenue-vs-payout")
        .css("text-align", "center")
        .html('<img src="../public/images/wait.gif" />');
    $.ajax({
        url: "dashboard/revenue-graph/" + duration,
        method: "GET",
        success: function (response) {
            if (response.status) {
                var options777 = {
                    chart: {
                        height: 397,
                        type: "line",
                        toolbar: {
                            show: false,
                        },
                    },
                    series: [
                        {
                            name: "Job Funds",
                            type: "column",
                            data: response.count_job_funds,
                        },
                        {
                            name: "Company Subscription",
                            type: "column",
                            data: response.count_comp_subsc,
                        },
                        {
                            name: "Recruiter Subscription",
                            type: "column",
                            data: response.count_recr_subsc,
                        },
                        {
                            name: "ReqCity Commission",
                            type: "column",
                            data: response.count_admin_comm,
                        },
                        {
                            name: "Recruiter Payout",
                            type: "column",
                            data: response.count_payout,
                        },
                    ],
                    stroke: {
                        width: [1, 1, 1, 1, 1],
                    },
                    legend: {
                        position: "top",
                    },
                    labels: response.dates_array,
                    xaxis: {
                        //type: 'datetime',
                        type: "category",
                        categories: response.dates_array,
                        labels: {
                            show: true,
                            rotate: -45,
                            rotateAlways: duration == "daily" ? true : false,
                        },
                    },
                    yaxis: {
                        title: {
                            text: "Total Amount",
                            style: {
                                color: "#298ffb",
                            },
                        },
                        labels: {
                            formatter: function (val) {
                                return "$" + getFormatedAmount(val);
                            },
                        },
                    },
                    tooltip: {
                        y: {
                            formatter: function (val) {
                                return "$" + getFormatedAmount(val);
                            },
                        },
                    },
                    // yaxis: [
                    //     {
                    //         title: {
                    //             text: "Total Amount",
                    //             style: {
                    //                 color: "#298ffb",
                    //             },
                    //         },
                    //     },
                    //     // {
                    //     //     seriesName: "Total Recruiter",
                    //     //     opposite: true,
                    //     //     title: {
                    //     //         text: "Total Recruiter",
                    //     //         style: {
                    //     //             color: "#00e396",
                    //     //         },
                    //     //     },
                    //     // },
                    //     // {
                    //     //     seriesName: "Total Candidates",
                    //     //     opposite: true,
                    //     //     title: {
                    //     //         text: "Total Candidates",
                    //     //         style: {
                    //     //             color: "#FEB019",
                    //     //         },
                    //     //     },
                    //     // },
                    // ],
                };

                var chart777 = new ApexCharts(
                    document.querySelector("#revenue-vs-payout"),
                    options777
                );

                setTimeout(function () {
                    $("#revenue-vs-payout").html("");
                    if (document.getElementById("revenue-vs-payout")) {
                        chart777.render();
                    }
                }, 1000);
            }
        },
    });
}

// function DatatableInitiate(status = "", startDate = "", endDate = "") {
//     var token = $('input[name="_token"]').val();
//     table = $("#Tdatatable").DataTable({
//         bDestroy: true,
//         processing: true,
//         serverSide: true,
//         columnDefs: [
//             // {
//             //     targets : [-1],
//             //     "orderable": false
//             // },
//             // {
//             //     targets: [0],
//             //     className: "hide_column"
//             // },
//             {
//                 targets: [2, 3, 4, 5, 6],
//                 className: "text-left",
//             },
//             {
//                 targets: [0, 1, 7],
//                 className: "text-center",
//             },
//             {
//                 targets: [0, 3, 4, 5, 6],
//                 orderable: false,
//             },
//             {
//                 targets: [1, 2, 7],
//                 orderable: true,
//             },
//             // {
//             //     targets: [3],
//             //     className: "text-center",
//             //     "orderable": true
//             // },
//             {
//                 targets: [0],
//                 className: "text-center",
//                 orderable: false,
//                 searchable: false,
//             },
//         ],
//         order: [[6, "desc"]],
//         scrollX: true,
//         ajax: {
//             url: "artists/dashboard-list", // json datasource
//             data: {
//                 _token: token,
//                 is_active: status,
//                 startDate: startDate,
//                 endDate: endDate,
//             },
//             error: function () {
//                 // error handling
//                 $(".Tdatatable-error").html("");
//                 $("#Tdatatable").append(
//                     '<tbody class="Tdatatable-error"><tr><th colspan="3">No data found in the server</th></tr></tbody>'
//                 );
//                 $("#Tdatatable_processing").css("display", "none");
//             },
//         },
//         // "bStateSave": true,
//         // "fnStateSave": function (oSettings, oData) {
//         //     localStorage.setItem( 'DataTables_'+window.location.pathname, JSON.stringify(oData) );
//         // },
//         // "fnStateLoad": function (oSettings) {
//         //     return JSON.parse( localStorage.getItem('DataTables_'+window.location.pathname) );
//         // }
//     });
// }

function DatatableInitiate() {
    var token = $('input[name="_token"]').val();
    var COLDEFS = [
        {
            targets: [6],
            orderable: false,
            visible: false,
        },
        {
            targets: [1, 2, 3],
            className: "text-left",
        },
        {
            targets: [0, 4, 5, 7],
            className: "text-center",
        },
        {
            targets: [5],
            render: function (data, type, row) {
                if (data == 2)
                    return '<span style="color: #0ba360">Approved</span>';
                else if (data == 3)
                    return '<span style="color: red">Rejected</span>';
                else if (data == 1)
                    return '<span style="color: #f5e500">Pending</span>';
            },
            orderable: true,
        },
        {
            targets: [4],
            render: function (data, type, row) {
                return "$" + data;
            },
        },
    ];
    table = $("#Tdatatable").DataTable({
        initComplete: function (settings, json) {
            if (settings.jqXHR.responseJSON.status == 3) {
                oTable.columns([5]).removeClass("hide_column");
            }
        },

        language: {
            searchPlaceholder: "Search by Company, Job Title ...",
        },
        drawCallback: function (response) {
            $("#total").html("$" + response.json.sumAmount);
        },
        searching: true,
        bDestroy: true,
        processing: true,
        serverSide: true,
        scrollX: true,
        columnDefs: COLDEFS,
        ajax: {
            url: "job-balance-transfer-requests/list",
            data: {
                _token: token,
                is_active: 1,
            },
            error: function () {
                // error handling
                $(".Tdatatable-error").html("");
                $("#Tdatatable").append(
                    '<tbody class="Tdatatable-error"><tr><th colspan="3">No data found in the server</th></tr></tbody>'
                );
                $("#Tdatatable_processing").css("display", "none");
            },
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

$(document).on("click", "#filter_dashboard_count", function () {
    $("#filterDashboardForm").valid();
    var token = $('input[name="_token"]').val();
    var from_date = $("#from_date").val();
    var to_date = $("#to_date").val();
    if (Date.parse(from_date) > Date.parse(to_date)) {
        $("#from_date_error").html(
            "<p>From date should be less then to To date</p>"
        );
    } else {
        $("#from_date_error").html("");
    }
    $.ajax({
        url: "dashboard/dashboard-filter", // json datasource
        method: "POST",
        data: {
            _token: token,
            from_date: from_date,
            to_date: to_date,
        },
        success: function (response) {
            if (response.length) {
                response.forEach((element) => {
                    $("#" + element.id).html(element.count);
                });
            }
        },
    });
});

$("#Tdatatable").on("click", ".approve-unaprove-link", function () {
    var approve = $(this).data("status");
    var artist_id = $(this).data("id");
    var message = "Are you sure ?";
    $("#artistIsApproveModel").on("show.bs.modal", function (e) {
        $("#artistIsApproveModel #artist_id").val(artist_id);
        $("#approve").val(approve);
        $("#messageApprove").text(message);
    });
    $("#artistIsApproveModel").modal("show");
});

/** Activate or deactivate music cateogry */
$(document).on("click", "#artistIsApprove", function () {
    var origin = window.location.href;
    var artist_id = $("#artist_id").val();
    var approve = $("#approve").val();
    $.ajax({
        url: origin + "/../artists/approve",
        method: "POST",
        data: {
            _token: $("#token").val(),
            approve: approve,
            artist_id: artist_id,
        },
        success: function (response) {
            if (response.status == "true") {
                $("#artistIsApproveModel").modal("hide");
                DatatableInitiate();
                toastr.clear();
                toastr.options.closeButton = true;
                toastr.success(response.msg);
            }
        },
    });
});

/** approve balance request */
$("#Tdatatable").on("click", "tbody .approve-link", function () {
    var job_balance_id = $(this).data("id");
    var message = "Are you sure?";
    console.log(message);
    $("#JobBalanceApproveModel").on("show.bs.modal", function (e) {
        $("#job_balance_id").val(job_balance_id);
        $("#message_approve").text(message);
    });
    $("#JobBalanceApproveModel").modal("show");
});

$(document).on("click", "#approveJobBalance", function () {
    var job_balance_id = $("#job_balance_id").val();
    $.ajax({
        url:
            baseUrl +
            "/securerccontrol/job-balance-transfer-requests/approve/" +
            job_balance_id,
        method: "POST",
        data: {
            _token: $("#tokenAccept").val(),
            job_balance_id: job_balance_id,
        },
        success: function (response) {
            if (response.status == "true") {
                $("#JobBalanceApproveModel").modal("hide");
                DatatableInitiate();
                toastr.clear();
                toastr.options.closeButton = true;
                toastr.success(response.msg);
            } else {
                $("#JobBalanceApproveModel").modal("hide");
                toastr.clear();
                toastr.options.closeButton = true;
                toastr.error(response.msg);
            }
        },
    });
});

/** reject balance request */
$("#Tdatatable").on("click", "tbody .reject-link", function () {
    var job_balance_id = $(this).data("id");
    var message = "Please give reson for reject";
    console.log(message);
    $("#JobBalanceRejectModel").on("show.bs.modal", function (e) {
        $("#job_balance_id").val(job_balance_id);
        $("#message_reject").text(message);
    });
    $("#JobBalanceRejectModel").modal("show");
});

$(document).on("click", "#rejectJobBalance", function (event) {
    var job_balance_id = $("#job_balance_id").val();
    var reject_reason = document.getElementById("reject_reason").value;
    if (!reject_reason) {
        $("#required-reject_reason").text("This field is required");
        event.preventDefault();
    } else {
        $("#JobBalanceRejectModel").modal("hide");
        $.ajax({
            url:
                baseUrl +
                "/securerccontrol/job-balance-transfer-requests/reject/" +
                job_balance_id,
            method: "POST",
            data: {
                _token: $("#token").val(),
                job_balance_id: job_balance_id,
                reject_reason: reject_reason,
            },
            success: function (response) {
                if (response.status == "true") {
                    $("#JobBalanceRejectModel").modal("hide");
                    DatatableInitiate();
                    toastr.clear();
                    toastr.options.closeButton = true;
                    toastr.success(response.msg);
                } else {
                    $("#JobBalanceRejectModel").modal("hide");
                    toastr.clear();
                    toastr.options.closeButton = true;
                    toastr.error(response.msg);
                }
            },
        });
    }
});

function getFormatedAmount(amount) {
    let dollarUSLocale = Intl.NumberFormat("en-US");
    return dollarUSLocale.format(amount);
}