var baseUrl = document.currentScript.getAttribute('data-base-url');

$(document).ready(function () {
  displayCompanyJobGraph();
});

function displayCompanyJobGraph() {
  var origin = window.location.href;
  //$('#monthly-sales-graph').css("text-align", "center").html('<img src="../public/images/wait.gif" />');
  $.ajax({
    url: '../../../company/job/monthly-graph/' + jobDetailId,
    method: 'GET',
    success: function (response) {
      if (response.status) {
        am5.ready(function () {
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

          var data = [];
          for (var i = 0, len = response.total_closed_applications.length; i < len; ++i) {
            var dataValue = response.total_closed_applications[i];
            data.push({
              "year": dataValue.dates,
              "totalSubmittals": dataValue.totalSubmittals,
              "totalApproved": dataValue.totalApproved,
              "totalRejected": dataValue.totalRejected,

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
            var colorG = '';
            switch (fieldName) {
              case 'totalSubmittals':
                colorG = 0xEEC200;
                break;
              case 'totalApproved':
                colorG = 0x50B83C;
                break;
              case 'totalRejected':
                colorG = 0xDE3618;
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
