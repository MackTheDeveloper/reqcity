@section('title','Company Jobs')
@extends('frontend.layouts.master')
@section('content')
<div class="company-job-details">
  <div class="container">
    <div class="row">
      <div class="col-md-12 order-2 order-lg-1 col-lg-8 col-xl-9">
        <div class="job-detail-data">
          <a href="{{url('/company-jobs')}}" class="back-to-link bm"><img src="{{ asset('public/assets/frontend/img/arrow-left.svg') }}" alt="" />Back to all
            jobs</a>
          @include('frontend.company.jobs.components.job-performance')
          <hr class="hr mtb-35">
            @include('frontend.company.jobs.components.candidate-data')
          <hr class="hr candi-hr">
            @include('frontend.company.jobs.components.job-description')
        </div>
      </div>
      <div class="col-md-12 order-1 order-lg-2 col-lg-4 col-xl-3">
        <div class="job-post-box">
          <p class="tl">{{$jobDetails->title}}</p>
          <p class="bm blur-color">{{$jobDetails->companyAddress->city}}{{ $jobDetails->companyAddress->state ? ', '.$jobDetails->companyAddress->state :''}}{{ $jobDetails->CompanyAddress->countries->name ? ', '.$jobDetails->CompanyAddress->countries->name :''}}</p>
          <p class="ll">{{$salary}} a {{$jobDetails->salary_type}}</p>
          <div class="dropdown status_dropdown" data-color="{{ $statusColor ? $statusColor : '' }}">
            <button
              class="btn dropdown-toggle w-100 d-flex align-items-center justify-content-between status__btn"
              type="button" id="dropdownMenuButton1" data-bs-toggle="dropdown" aria-expanded="false"
              data-bs-offset="0,12">
              {{$statusText}}
            </button>
            <ul class="dropdown-menu status_change" aria-labelledby="dropdownMenuButton1">
              @if($jobDetails->status === 3 || $jobDetails->status === 2)
              <li>
                <a class="dropdown-item job-change-status" data-class="open" data-status="1" data-id="{{$jobDetails->id}}" href="javascript:void(0)" data-toggle="modal" data-target="#ChageStatusModel">
                  <div class="status-round"></div>Open
                </a>
              </li>
              @endif
              @if($jobDetails->status === 1 )
              <li>
                <a class="dropdown-item job-change-status" data-class="paused" data-status="3" data-id="{{$jobDetails->id}}" href="javascript:void(0)" data-toggle="modal" data-target="#ChageStatusModel">
                  <div class="status-round"></div>Paused
                </a>
              </li>
              @endif
              @if($jobDetails->status === 1)
              <li>
                <a class="dropdown-item job-close" data-class="closed" data-id="{{$jobDetails->id}}" href="javascript:void(0)" data-toggle="modal"
                    data-target="#closeJob">
                    <div class="status-round"></div>Closed
                </a>
              </li>
              @endif

            </ul>
          </div>
          <table class="table-content-data last-blur">
            <tr>
              <td>Total Cost</td>
              <td>{{$totalCost}}</td>
            </tr>
            <tr>
              <td>Balance</td>
              <td>{{$balance}}</td>
            </tr>
          </table>
        </div>
      </div>
    </div>
  </div>
</div>
@include('frontend.company.jobs.modals.close-popup')
@include('frontend.company.jobs.modals.change-status')
@endsection
@section('footscript')
<script src="{{ asset('public/assets/frontend/js/amcharts5/index.js') }}"></script>
<script src="{{ asset('public/assets/frontend/js/amcharts5/xy.js') }}"></script>
<script src="{{ asset('public/assets/frontend/js/amcharts5/themes/Animated.js') }}"></script>
<script type="text/javascript">
$(document).ready(function () {
    //var divName="monthlychartdiv";
    displayCompanyJobGraph();

});

function displayCompanyJobGraph() {
  var origin = window.location.href;
    //$('#monthly-sales-graph').css("text-align", "center").html('<img src="../public/images/wait.gif" />');
    $.ajax({
        url: '../company-job-details/monthly-graph/'+{{$jobDetails->id}},
        method: 'GET',
        success: function (response) {
            if (response.status) {
              am5.ready(function() {
              // Create root element
              // https://www.amcharts.com/docs/v5/getting-started/#Root_element
              var root = am5.Root.new('CompanyJobMonthDiv');


              // Set themes
              // https://www.amcharts.com/docs/v5/concepts/themes/
              root.setThemes([
                am5themes_Animated.new(root)
              ]);
              // Create chart
              // https://www.amcharts.com/docs/v5/charts/xy-chart/
              var chart = root.container.children.push(am5xy.XYChart.new(root, {
                panX: false,
                panY: false,
                wheelX: "panX",
                wheelY: "zoomX",
                layout: root.verticalLayout
              }));


              // Add legend
              // https://www.amcharts.com/docs/v5/charts/xy-chart/legend-xy-series/
              var legend = chart.children.push(
                am5.Legend.new(root, {
                  centerX: am5.p50,
                  x: am5.p50
                })
              );

              var data   = [];
              for (var i = 0, len = response.total_closed_applications.length; i < len; ++i) {
                   var dataValue = response.total_closed_applications[i];
                   data.push({
                     "year":dataValue.dates,
                     "totalSubmittals":dataValue.totalSubmittals,
                     "totalApproved":dataValue.totalApproved,
                     "totalRejected":dataValue.totalRejected,

                   });
                 }


              // Create axes
              // https://www.amcharts.com/docs/v5/charts/xy-chart/axes/
              var xAxis = chart.xAxes.push(am5xy.CategoryAxis.new(root, {
                categoryField: "year",
                renderer: am5xy.AxisRendererX.new(root, {
                  cellStartLocation: 0,
                  cellEndLocation: 1
                }),
                tooltip: am5.Tooltip.new(root, {})
              }));

              xAxis.data.setAll(data);

              var yAxis = chart.yAxes.push(am5xy.ValueAxis.new(root, {
                renderer: am5xy.AxisRendererY.new(root, {})
              }));


              // Add series
              // https://www.amcharts.com/docs/v5/charts/xy-chart/series/
              function makeSeries(name, fieldName) {
                var colorG='';
                switch(fieldName) {
                case 'totalSubmittals':
                  colorG=0xEEC200;
                break;
                case 'totalApproved':
                  colorG=0x50B83C;
                break;
                case 'totalRejected':
                  colorG=0xDE3618;
                break;
                default:
                  // code block
              }
                var series = chart.series.push(am5xy.ColumnSeries.new(root, {
                  name: name,
                  xAxis: xAxis,
                  yAxis: yAxis,
                  valueYField: fieldName,
                  categoryXField: "year",
                  fill: am5.color(colorG),

                }));

                series.columns.template.setAll({
                  tooltipText: "{name}, {categoryX}:{valueY}",
                  width: am5.percent(90),
                  tooltipY: 0
                });

                series.data.setAll(data);

                // Make stuff animate on load
                // https://www.amcharts.com/docs/v5/concepts/animations/
                series.appear();

                series.bullets.push(function () {
                  return am5.Bullet.new(root, {
                    locationY: 0,
                    sprite: am5.Label.new(root, {
                      text: "{valueY}",
                      fill: root.interfaceColors.get("alternativeText"),
                      centerY: 0,
                      centerX: am5.p50,
                      populateText: true
                    })
                  });
                });

                //legend.data.push(series);
              }
              makeSeries("Candidates", "totalSubmittals");
              makeSeries("Approved", "totalApproved");
              makeSeries("Rejected", "totalRejected");


chart.set("cursor", am5xy.XYCursor.new(root, {}));

// Add legend
// https://www.amcharts.com/docs/v5/charts/xy-chart/legend-xy-series/
var legend = chart.children.push(
  am5.Legend.new(root, {
    centerX: am5.p50,
    x: am5.p50
  })
);
legend.data.setAll(chart.series.values);
              // Make stuff animate on load
              // https://www.amcharts.com/docs/v5/concepts/animations/
              chart.appear(1000, 100);
              });
            }
          }
        })
}
$('.job-close').on('click', function (e) {
  var jobId=$(this).data("id");
  $.ajax({
    url: "{{ url('/company-jobs-list') }}",
    type: 'get',
    dataType: "json",
      data: {
          jobId: jobId,
      },
      success: function (result) {
        $('#toJobId').empty();
           jobTitle = result.jobTitle;
           balance = result.balance;
           $.each(result.jobList,function(index, value){
               $('#toJobId').append('<option value="'+value.jobId+'">'+value.jobTitle+'</option>');
           });
           $('.fromJob').html(jobTitle);
           $('.balanceVal').html('$'+balance);
           $('#balance').val(balance);
           $('#fromJobId').val(jobId);
      },
      error: function (result) {
          console.log('error in getting bank details');
      }

  });
  //e.stopImmediatePropagation();
 // var recruiterName = $("#recruiter option:selected").text();
 // $('#RecruiterPaymentHeaderLabel').text('Payout to ' + recruiterName);
});

// To Payment
$("#balanceRequestFromPopup").validate({
    ignore: [],
    rules: {
        toJobId: {
            required: true,
        },

    },

    submitHandler: function(form) {
        $('.loader-bg').removeClass('d-none');
        $.ajax({
            url: form.action,
            type: form.method,
            data: $(form).serialize(),
            success: function(response) {
                if (response.statusCode == '200') {
                    $('.loader-bg').addClass('d-none');
                    toastr.clear();
                    toastr.options.closeButton = true;
                    toastr.error(response.message);
                    $("#closeJob .close").click();
                    document.getElementById('balanceRequestFromPopup').reset();
                    setTimeout(function () {
                        toastr.clear();
                        window.location.reload();
                    }, 3000);
                } else {
                    $('.loader-bg').addClass('d-none');
                    toastr.clear();
                    toastr.options.closeButton = true;
                    toastr.error(response.component.error);
                }
            }
        });
    },
    errorPlacement: function(error, element) {
        if (element.hasClass("mobile-number")) {
            error.insertAfter(element.parent().append());
        } else {
            error.insertAfter(element);
        }

    },
});
$('.job-change-status').on('click', function (e) {
    var id = $(this).data('id');
    var status = $(this).data('status');
    $("#ChageStatusModel #changeStatusConfirmed input#id").val(id);
     $("#ChageStatusModel #changeStatusConfirmed input#status").val(status);
    //$("#ChageStatusModel").modal('show');
});
//for read unread
$(document).on("click", "#change-status-confirm", function (e) {
    e.preventDefault();
    $.ajax({
        url: "{{ url('/company-job-change-status') }}",
        type: "POST",
        data: $("#changeStatusConfirmed").serialize(),
        success: function (response) {
            $("#ChageStatusModel").modal("hide");
            toastr.clear();
            toastr.options.closeButton = true;
            toastr.success(response.message);
            setTimeout(function () {
                window.location.reload();
            }, 5000);
        },
    });
});
</script>
@endsection
