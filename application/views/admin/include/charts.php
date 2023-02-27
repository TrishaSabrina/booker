
  
<!-- high charts js-->
<script src="https://code.highcharts.com/highcharts.js"></script>

<script>
  <?php if(is_admin()): ?>
    var incomeData = <?= $income_data; ?>;
    var incomeAxis = <?= $income_axis; ?>;

    Highcharts.chart('adminIncomeChart', {
        chart: {
            type: '<?= settings()->chart_style; ?>'
        },
        credits: {
            enabled: false
        },
        title: {
            text: ''
        },
        xAxis: {
            categories: incomeAxis
        },
        yAxis: {
            title: {
                text: ''
            },
            labels: {
                format: '<?php if(settings()->curr_locate == 0){echo $currency;} ?>{value} <?php if(settings()->curr_locate == 1){echo $currency;} ?>'
            },
        },
        legend: {
            enabled: true
        },
        plotOptions: {
            series: {
                borderWidth: 0,
                dataLabels: {
                    enabled: true,
                    format: '<?php if(settings()->curr_locate == 0){echo $currency;} ?>{point.y} <?php if(settings()->curr_locate == 1){echo $currency;} ?>'
                }
            }
        },

        tooltip: {
            headerFormat: '<span class="fs-14">{series.name}</span><br>',
            pointFormat: '<span>{point.name}</span> <b><?php echo html_escape($currency) ?>{point.y}</b><br/>'
        },

        series: [
            {
                name: '<?= trans('income') ?>',
                data: incomeData,
                color: '#2568ef'
            }
        ]
    });


    Highcharts.chart('packagePie', {
      chart: {
        plotBackgroundColor: null,
        plotBorderWidth: null,
        plotShadow: false,
        type: 'pie'
      },
      title: {
        text: ''
      },
      credits: {
          enabled: false
      },
      tooltip: {
        pointFormat: '{series.name}: <b>{point.percentage:.1f}%</b>'
      },
      plotOptions: {
        pie: {
          allowPointSelect: true,
          cursor: 'pointer',
          dataLabels: {
            enabled: true,
            format: '<b>{point.name}</b>: {point.percentage:.1f} %'
          }
        }
      },
      series: [{
        name: '<?php echo trans('users') ?>',
        colorByPoint: true,
        
        data: [
            <?php 
              foreach ($upackages as $upackage) {
                echo '{
                  name: "'.$upackage->name.'",
                  y: '.$upackage->total.'
                },';
              }
            ?>
          ]
      }]
    });
  <?php endif; ?>



  <?php if(is_user()): ?>
    var incomeData = <?= $income_data; ?>;
    var incomeAxis = <?= $income_axis; ?>;

    Highcharts.chart('userIncomeChart', {
        chart: {
            type: 'areaspline'
        },
        title: {
            text: ''
        },
        legend: {
            layout: 'vertical',
            align: 'left',
            verticalAlign: 'top',
            x: 150,
            y: 100,
            floating: true,
            borderWidth: 1,
            backgroundColor:
                Highcharts.defaultOptions.legend.backgroundColor || '#FFFFFF'
        },
        xAxis: {
            categories: incomeAxis
        },
        yAxis: {
            title: {
                text: ''
            },
            labels: {
                format: '<?php if($this->business->curr_locate == 0){echo $currency;} ?>{value} <?php if($this->business->curr_locate == 1){echo $currency;} ?>'
            },
        },
        tooltip: {
            headerFormat: '<span class="fs-14">{series.name}</span><br>',
            pointFormat: '<span>{point.name}</span> <b><?php if($this->business->curr_locate == 0){echo $currency;} ?>{point.y} <?php if($this->business->curr_locate == 1){echo $currency;} ?></b><br/>'
        },
        credits: {
            enabled: false
        },
        plotOptions: {
            areaspline: {
                fillOpacity: 0.2,
                dataLabels: {
                    enabled: true,
                    format: '<?php if($this->business->curr_locate == 0){echo $currency;} ?>{point.y} <?php if($this->business->curr_locate == 1){echo $currency;} ?>'
                }
            }
        },
        series: [{
            name: '<?php echo trans('income') ?>',
            data: incomeData,
            color: 'rgb(35, 199, 112)'
        }]
    });


  <?php endif; ?>

</script>
