<?php $this->load->view('includes/header'); ?>
<style>
  #attendance_list tbody td a {
    font-weight: bold;
    font-size: 12px;
  }

  #attendance_list tbody td {
    padding: 5px 10px;
  }

  #upcoming-events-column {
    display: flex;
    flex-direction: column;
    height: 100%;
    /* Ensure the column takes up full height */
  }

  .widget-media {
    flex-grow: 1;
    /* Allow the content to grow to fill the available space */
  }
</style>
<link href="<?= base_url('assets2/vendor/chartist/css/chartist.min.css') ?>" rel="stylesheet" type="text/css" />
</head>

<body>

  <!--*******************
        Preloader start
    ********************-->
  <div id="preloader">
    <div class="lds-ripple">
      <div></div>
      <div></div>
    </div>
  </div>
  <div id="loader">
    <div class="lds-ripple">
      <div></div>
      <div></div>
    </div>
  </div>
  <!--*******************
        Preloader end
    ********************-->
  <!--**********************************
        Main wrapper start
    ***********************************-->
  <div id="main-wrapper">
    <!--**********************************
    Sidebar start
***********************************-->
    <?php $this->load->view('includes/sidebar'); ?>
    <!--**********************************
    Sidebar end
***********************************--> <!--**********************************
	Content body start
***********************************-->
    <div class="content-body default-height">
      <div class="container-fluid">
        <div class="row">
          <div class="col-xl-4 col-sm-12">
            <div class="card">
              <div class="card-body">
                <div class="static-icon mx-5">
                  <div class="d-flex">
                    <h4><?= $this->lang->line('earnings') ? $this->lang->line('earnings') : 'Earnings' ?></h4>
                    <h4 class="count text-primary ms-auto mb-0"><?= htmlspecialchars(get_saas_currency('currency_symbol')) ?><?= htmlspecialchars(get_earnings()) ?></h4>
                  </div>
                  <div class="progress default-progress mt-2">
                    <div class="progress-bar bg-gradient1 progress-animated" style="width: <?= get_earnings() ?>; height:5px;" role="progressbar">
                      <span class="sr-only"><?= get_earnings() ?> Complete</span>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
          <div class="col-xl-4 col-sm-12">
            <div class="card">
              <div class="card-body">
                <div class="static-icon mx-5">
                  <div class="d-flex">
                    <h4><?= $this->lang->line('orders') ? $this->lang->line('orders') : 'Orders' ?></h4>
                    <h4 class="count text-primary ms-auto mb-0"><?= htmlspecialchars(get_count('id', 'orders', '')) ?></h4>
                  </div>
                  <div class="progress default-progress mt-2">
                    <div class="progress-bar bg-gradient1 progress-animated" style="width: <?= get_earnings() ?>; height:5px;" role="progressbar">
                      <span class="sr-only"><?= get_earnings() ?> Complete</span>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
          <div class="col-xl-4 col-sm-12">
            <div class="card">
              <div class="card-body">
                <div class="static-icon mx-5">
                  <div class="d-flex">
                    <h4><?= $this->lang->line('subscribers') ? htmlspecialchars($this->lang->line('subscribers')) : 'Subscribers' ?></h4>
                    <h4 class="count text-primary ms-auto mb-0"><?= get_count('saas_id', 'users', 'saas_id != 1 GROUP BY saas_id') ?></h4>
                  </div>
                  <div class="progress default-progress mt-2">
                    <div class="progress-bar bg-gradient1 progress-animated" style="width: <?= get_earnings() ?>; height:5px;" role="progressbar">
                      <span class="sr-only"><?= get_earnings() ?> Complete</span>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
        <div class="row">
          <div class="col-md-12 ">
            <div class="card">
              <div class="card-header">
                <h4><?= $this->lang->line('last_days_earning') ? $this->lang->line('last_days_earning') : 'Last 30 days earning' ?></h4>
              </div>
              <div class="card-body height370" style="overflow: hidden;">
                <div id="bi-polar-bar" class="ct-chart ct-golden-section chartlist-chart" height="auto"></div>
              </div>
            </div>
          </div>
          <div class="col-xl-6 col-lg-12">
            <div class="card">
              <div class="card-header">
                <h4><?= $this->lang->line('subscribers_statistics') ? htmlspecialchars($this->lang->line('subscribers_statistics')) : 'Subscriber Statistics' ?></h4>
              </div>
              <div class="card-body">
                <div id="animating-donut" class="ct-chart ct-golden-section chartlist-chart"></div>
              </div>
            </div>
          </div>
          <div class="col-xl-6 col-lg-12 col-sm-12">
            <div class="card">
              <div class="card-header">
                <h4><?= $this->lang->line('subscription_statistics') ? htmlspecialchars($this->lang->line('subscription_statistics')) : 'Subscription Statistics' ?></h4>
              </div>
              <div class="card-body">
                <canvas id="areaChart_1"></canvas>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
    <!--**********************************
	Content body end
***********************************-->
    <?php $this->load->view('includes/footer'); ?>
  </div>
  <?php


  $users_values = array(count($this->ion_auth->where('users.active', 1)->where('users.id = users.saas_id')->users(1)->result()), count($this->ion_auth->where('users.active', 0)->where('users.id = users.saas_id')->users(1)->result()), get_count('id', 'users_plans', 'plan_id=1'), get_count('id', 'users_plans', 'plan_id!=1'));

  if ($transaction_chart) {
    foreach ($transaction_chart as $transaction) {
      $tmpT[] = htmlspecialchars(format_date($transaction['date'], system_date_format()));
      $tmpTV[] = htmlspecialchars($transaction['amount']);
    }
  } else {
    $tmpT[] = '';
    $tmpTV[] = '';
  }

  $tmpP[] = $this->lang->line('expired') ? $this->lang->line('expired') : 'Expired';
  $tmpPV[] = get_count('id', 'users_plans', 'expired=0');
  foreach ($plans as $plan) {
    $tmpP[] = htmlspecialchars($plan['title']);
    $tmpPV[] = get_count('id', 'users_plans', 'expired=1 AND plan_id=' . htmlspecialchars($plan['id']));
  }

  ?>

  <?php $this->load->view('includes/scripts'); ?>
  <script src="<?= base_url('assets2/vendor/chart-js/chart.bundle.min.js') ?>"></script>
  <script src="<?= base_url('assets2/vendor/apexchart/apexchart.js') ?>"></script>
  <script src="<?= base_url('assets2/vendor/chartist/js/chartist.min.js') ?>"></script>
  <script src="<?= base_url('assets2/vendor/chartist-plugin-tooltips/js/chartist-plugin-tooltip.min.js') ?>"></script>
  <script>
    users_values = '<?= json_encode($users_values) ?>';
    plans = '<?= json_encode($tmpP) ?>';
    plans_values = '<?= json_encode($tmpPV) ?>';
    trans = '<?= json_encode($tmpT) ?>';
    trans_values = '<?= json_encode($tmpTV) ?>';
    Users_Statistics = '<?= $this->lang->line('subscribers_statistics') ? $this->lang->line('subscribers_statistics') : 'Subscriber Statistics' ?>';
    Active = '<?= $this->lang->line('active') ? $this->lang->line('active') : 'Active' ?>';
    Deactive = '<?= $this->lang->line('deactive') ? $this->lang->line('deactive') : 'Deactive' ?>';
    Free = '<?= $this->lang->line('free') ? $this->lang->line('free') : 'Free' ?>';
    Paid = '<?= $this->lang->line('paid') ? $this->lang->line('paid') : 'Paid' ?>';
  </script>
  <script>
    var animatingDonutChart = function() {
      //Animating a Donut with Svg.animate

      var chart = new Chartist.Pie('#animating-donut', {
        series: JSON.parse(users_values),
        labels: [Active, Deactive, Free, Paid],
      }, {
        donut: true,
        showLabel: false,
        plugins: [
          Chartist.plugins.tooltip()
        ]
      });

      chart.on('draw', function(data) {
        if (data.type === 'slice') {
          // Get the total path length in order to use for dash array animation
          var pathLength = data.element._node.getTotalLength();

          // Set a dasharray that matches the path length as prerequisite to animate dashoffset
          data.element.attr({
            'stroke-dasharray': pathLength + 'px ' + pathLength + 'px'
          });

          // Create animation definition while also assigning an ID to the animation for later sync usage
          var animationDefinition = {
            'stroke-dashoffset': {
              id: 'anim' + data.index,
              dur: 1000,
              from: -pathLength + 'px',
              to: '0px',
              easing: Chartist.Svg.Easing.easeOutQuint,
              // We need to use `fill: 'freeze'` otherwise our animation will fall back to initial (not visible)
              fill: 'freeze'
            }
          };

          // If this was not the first slice, we need to time the animation so that it uses the end sync event of the previous animation
          if (data.index !== 0) {
            animationDefinition['stroke-dashoffset'].begin = 'anim' + (data.index - 1) + '.end';
          }

          // We need to set an initial value before the animation starts as we are not in guided mode which would do that for us
          data.element.attr({
            'stroke-dashoffset': -pathLength + 'px'
          });

          // We can't use guided mode as the animations need to rely on setting begin manually
          // See http://gionkunz.github.io/chartist-js/api-documentation.html#chartistsvg-function-animate
          data.element.animate(animationDefinition, false);
        }
      });

      // For the sake of the example we update the chart every time it's created with a delay of 8 seconds
      chart.on('created', function() {
        if (window.__anim21278907124) {
          clearTimeout(window.__anim21278907124);
          window.__anim21278907124 = null;
        }
        window.__anim21278907124 = setTimeout(chart.update.bind(chart), 10000);
      });

    }
    function hexToRGBA(hex, alpha) {
    // Parse the hexadecimal color code
    var r = parseInt(hex.slice(1, 3), 16);
    var g = parseInt(hex.slice(3, 5), 16);
    var b = parseInt(hex.slice(5, 7), 16);

    // Ensure alpha value is within range [0, 1]
    if (alpha < 0 || alpha > 1) {
        alpha = 1;
    }

    // Return the RGBA string
    return 'rgba(' + r + ', ' + g + ', ' + b + ', ' + alpha + ')';
}

    var areaChart1 = function() {
      var color = hexToRGBA(theme_color, 0.3);
      var color2 = hexToRGBA(theme_color, 1);
      //basic area chart
      if (jQuery('#areaChart_1').length > 0) {
        const areaChart_1 = document.getElementById("areaChart_1").getContext('2d');

        areaChart_1.height = 100;

        new Chart(areaChart_1, {
          type: 'line',
          data: {
            defaultFontFamily: 'Poppins',
            labels: JSON.parse(plans),
            datasets: [{
                label: "Total",
                data: JSON.parse(plans_values),
                borderColor: color,
                borderWidth: "2",
                backgroundColor: color2,
                fill: true,
                pointBackgroundColor: color,
                tension: 0.5,
              }

            ]
          },
          options: {
            plugins: {
              legend: false,
            },

            scales: {
              y: {
                max: 100,
                min: 0,
                ticks: {
                  beginAtZero: true,
                  stepSize: 20,
                  padding: 10
                }
              },
              x: {
                ticks: {
                  padding: 5
                }
              }
            }
          }
        });
      }
    }
    var biPolarBarChart = function() {
      //Bi-polar bar chart
      var data = {
        labels: JSON.parse(trans),
        series: JSON.parse(trans_values)
      };

      var options = {
        high: 10,
        low: -10,
        axisX: {
          labelInterpolationFnc: function(value, index) {
            return index % 2 === 0 ? value : null;
          }
        },
        plugins: [
          Chartist.plugins.tooltip()
        ],
        width: '100%', // Setting the width to 100%
        height: 300 // Setting the height to 300 pixels

      };

      new Chartist.Bar('#bi-polar-bar', data, options);

    }
    $(document).ready(function() {
      animatingDonutChart();
      biPolarBarChart();
      areaChart1();
    });
  </script>
</body>

</html>