var baseUrl = document.currentScript.getAttribute('data-base-url');

$(document).ready(function () {
  var divName = "monthlychartdiv";
  displayCompanyMonthlyGraph('monthly', divName);

});
$(document).on("click", "#pills-home-tab", function () {
  var divName = "monthlychartdiv";
  displayCompanyMonthlyGraph('monthly', divName);
});
$(document).on("click", "#pills-profile-tab", function () {
  var divName = "yearlychartdiv";
  displayCompanyMonthlyGraph('yearly', divName);
});
$(document).on("click", "#pills-contact-tab", function () {
  var divName = "lifetimechartdiv";
  displayCompanyMonthlyGraph('lifetime', divName);
});
function displayCompanyMonthlyGraph(duration, divName) {
  //$('#monthly-sales-graph').css("text-align", "center").html('<img src="../public/images/wait.gif" />');
  $.ajax({
    url: '../../company/monthly-graph/' + duration + '/' + companyId,
    method: 'GET',
    success: function (response) {
      if (response.status) {
        am5.ready(function () {
          // Create root element
          // https://www.amcharts.com/docs/v5/getting-started/#Root_element
          var root = am5.Root.new(divName);


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
              "totalClosed": dataValue.totalClosed,
              "totalSubmittals": dataValue.totalSubmittals,
              "totalApproved": dataValue.totalApproved,
              "totalRejected": dataValue.totalRejected,
              "amountSpent": dataValue.amountSpent
            });
          }


          // Create axes
          // https://www.amcharts.com/docs/v5/charts/xy-chart/axes/
          var xAxis = chart.xAxes.push(am5xy.CategoryAxis.new(root, {
            categoryField: "year",
            renderer: am5xy.AxisRendererX.new(root, {
              cellStartLocation: 0.1,
              cellEndLocation: 0.9
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
              case 'totalClosed':
                colorG = 0x9C6ADE;
                break;
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

          makeSeries("Closed Jobs", "totalClosed");
          makeSeries("Submittals", "totalSubmittals");
          makeSeries("Candidate Approved", "totalApproved");
          makeSeries("Candidate Rejected", "totalRejected");

          // Line chart
          var paretoAxisRenderer = am5xy.AxisRendererY.new(root, { opposite: true });
          var maxValue = 0;
          for (var i = 0, len = response.total_closed_applications.length; i < len; ++i) {
            var dataMaxValue = response.total_closed_applications[i].amountSpent;
            if (dataMaxValue > maxValue) {
              maxValue = dataMaxValue;
            }
          }
          var maxValue = parseInt(maxValue);
          var paretoAxis = chart.yAxes.push(am5xy.ValueAxis.new(root, {
            renderer: paretoAxisRenderer,
            min: 0,
            max: maxValue,
            extraMax: 0.1
          }));
          paretoAxisRenderer.grid.template.set("forceHidden", true);
          var series2 = chart.series.push(
            am5xy.LineSeries.new(root, {
              name: "Amount Spent",
              xAxis: xAxis,
              yAxis: paretoAxis,
              valueYField: "amountSpent",
              categoryXField: "year",
              tooltip: am5.Tooltip.new(root, {
                pointerOrientation: "horizontal",
                labelText: "{name} in {categoryX}: ${valueY} {info}"
              })
            })
          );
          series2.strokes.template.setAll({
            strokeWidth: 3,
            templateField: "strokeSettings",
          });


          series2.data.setAll(data);

          series2.bullets.push(function () {
            return am5.Bullet.new(root, {
              sprite: am5.Circle.new(root, {
                strokeWidth: 3,
                stroke: series2.get("stroke"),
                radius: 5,
                fill: root.interfaceColors.get("background")
              })
            });
          });
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
