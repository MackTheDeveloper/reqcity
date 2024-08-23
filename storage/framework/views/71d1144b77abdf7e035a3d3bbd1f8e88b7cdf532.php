<style>
#chartdiv {
  width: 100%;
  height: 200px;
}
#chartdivPie {
  width: 100%;
  height: 200px;
}
</style>

<div class="job-perfromance-payout-dashmain">
    <div class="row">
        <div class="col-md-12 col-lg-12 col-xl-6">
            <div class="job-pp-item">
                <div class="pp-dash-head">
                    <h6>Job Performance</h6>
                </div>
                <div class="pp-dash-detailed">
                    <div class="performance-dash-graphdata">

                            <div id="chartdivPie"></div>

                        <!-- <div class="perfo-status">
                            <div class="jd-progress-data">
                                <div class="jd-preogress-color yellow"></div>
                                <span class="bs">Candidates</span>
                            </div>
                            <div class="jd-progress-data">
                                <div class="jd-preogress-color green"></div>
                                <span class="bs">Approved</span>
                            </div>
                            <div class="jd-progress-data">
                                <div class="jd-preogress-color red"></div>
                                <span class="bs">Rejected</span>
                            </div>
                        </div> -->
                    </div>
                </div>

            </div>
        </div>
        <div class="col-md-12 col-lg-12 col-xl-6">
            <div class="job-pp-item">
                <div class="pp-dash-head">
                    <h6>Total Payout</h6>
                </div>
                <div class="pp-dash-detailed payout-dash-detail">
                  <div id="chartdiv"></div>
                    <!-- <div class="payout-graphed-data">
                        <div class="payout-graphed-item">
                            <p>Balance ($)</p>
                            <div class="progress-line-wrapper">
                                <div class="progress-line" style="background: #4C65FF;width: 20%;"></div>
                            </div>
                        </div>
                        <div class="payout-graphed-item">
                            <p>Payout ($)</p>
                            <div class="progress-line-wrapper">
                                <div class="progress-line" style="background: #47C1BF;width: 100%;"></div>
                            </div>
                        </div>
                    </div> -->
                </div>
            </div>
        </div>
    </div>
</div>
<?php $__env->startSection('footscript'); ?>
<script src="<?php echo e(asset('public/assets/frontend/js/amcharts5/index.js')); ?>"></script>
<script src="<?php echo e(asset('public/assets/frontend/js/amcharts5/xy.js')); ?>"></script>
<script src="<?php echo e(asset('public/assets/frontend/js/amcharts5/percent.js')); ?>"></script>
<script src="<?php echo e(asset('public/assets/frontend/js/amcharts5/themes/Animated.js')); ?>"></script>
<script>
am5.ready(function() {

// Create root element
// https://www.amcharts.com/docs/v5/getting-started/#Root_element
var root = am5.Root.new("chartdiv");


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
var legend = chart.children.push(am5.Legend.new(root, {
  centerX: am5.p50,
  x: am5.p50
}))


// Data
var data = [{
  year: "Lifetime",
  balance: <?php echo e($balance); ?>,
  payout: <?php echo e($payouts); ?>,
}];


// Create axes
// https://www.amcharts.com/docs/v5/charts/xy-chart/axes/
var yAxis = chart.yAxes.push(am5xy.CategoryAxis.new(root, {
  categoryField: "year",
  renderer: am5xy.AxisRendererY.new(root, {
    inversed: false,
    cellStartLocation: 0.1,
    cellEndLocation: 0.9
  })
}));

yAxis.data.setAll(data);

var xAxis = chart.xAxes.push(am5xy.ValueAxis.new(root, {
  renderer: am5xy.AxisRendererX.new(root, {}),
  min: 0
}));


// Add series
// https://www.amcharts.com/docs/v5/charts/xy-chart/series/
function createSeries(field, name) {
  var colorG='';
  switch(field) {
  case 'balance':
    colorG=0x4C65FF;
  break;
  case 'payout':
    colorG=0x47C1BF;
  break;
  default:
    // code block
}
  var series = chart.series.push(am5xy.ColumnSeries.new(root, {
    name: name,
    xAxis: xAxis,
    yAxis: yAxis,
    valueXField: field,
    categoryYField: "year",
    fill: am5.color(colorG),
    sequencedInterpolation: true,
  }));

  series.columns.template.setAll({
    height: am5.p100
  });


  series.bullets.push(function() {
    return am5.Bullet.new(root, {
      locationX: 1,
      locationY: 0.5,
      sprite: am5.Label.new(root, {
        centerY: am5.p50,
        text: "$"+"{valueX}",
        populateText: true
      })
    });
  });

  series.bullets.push(function() {
    return am5.Bullet.new(root, {
      locationX: 1,
      locationY: 0.5,
      sprite: am5.Label.new(root, {
        centerX: am5.p100,
        centerY: am5.p50,
        text: "{name}",
        fill: am5.color(0xffffff),
        populateText: true
      })
    });
  });

  series.data.setAll(data);
  series.appear();

  return series;
}
createSeries("payout", "Payout");
createSeries("balance", "Balance");



// Add legend
// https://www.amcharts.com/docs/v5/charts/xy-chart/legend-xy-series/
var legend = chart.children.push(am5.Legend.new(root, {
  centerX: am5.p50,
  x: am5.p50
}));

legend.data.setAll(chart.series.values);


// Add cursor
// https://www.amcharts.com/docs/v5/charts/xy-chart/cursor/
var cursor = chart.set("cursor", am5xy.XYCursor.new(root, {
  behavior: "zoomY"
}));
cursor.lineY.set("forceHidden", true);
cursor.lineX.set("forceHidden", true);


// Make stuff animate on load
// https://www.amcharts.com/docs/v5/concepts/animations/
chart.appear(1000, 100);

var root1 = am5.Root.new("chartdivPie");


// Set themes
// https://www.amcharts.com/docs/v5/concepts/themes/
root1.setThemes([
  am5themes_Animated.new(root1)
]);


// Create chart
// https://www.amcharts.com/docs/v5/charts/percent-charts/pie-chart/
var chart1 = root1.container.children.push(am5percent.PieChart.new(root1, {
  layout: root.verticalLayout,
  innerRadius: am5.percent(50)
}));


// Create series
// https://www.amcharts.com/docs/v5/charts/percent-charts/pie-chart/#Series
var series1 = chart1.series.push(am5percent.PieSeries.new(root1, {
  valueField: "value",
  categoryField: "category",
  alignLabels: true,
}));




// Set data
// https://www.amcharts.com/docs/v5/charts/percent-charts/pie-chart/#Setting_data
series1.data.setAll([
  { value: <?php echo e($candidateCount); ?>, category: "Candidates" ,colorB:0xeec200},
  { value: <?php echo e($candidateApprovedCount); ?>, category: "Approved",colorB:0x50b83c},
  { value: <?php echo e($candidateRejectedCount); ?>, category: "Rejected" ,colorB:0xde3618},
]);

// Create legend
// https://www.amcharts.com/docs/v5/charts/percent-charts/legend-percent-series/
var legend = chart1.children.push(am5.Legend.new(root1, {
  centerX: am5.percent(50),
  x: am5.percent(50),
  marginTop: 15,
  marginBottom: 15,
}));

legend.data.setAll(series1.dataItems);
// Configuring slices
    

    series1.get("colors").set("colors", [
      am5.color("#FFD3D1"),
      am5.color("#FFE664"),
      am5.color("#A6D6F5"),
    ]);
// Play initial series animation
// https://www.amcharts.com/docs/v5/concepts/animations/#Animation_of_series
series1.appear(1000, 100);

}); // end am5.ready()
</script>

<?php $__env->stopSection(); ?>
<?php /**PATH /var/www/html/php/reqcity/resources/views/frontend/recruiter/dashboard/components/recruiter-performance.blade.php ENDPATH**/ ?>