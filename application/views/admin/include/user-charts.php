
  
<!-- charts js-->
<script src="https://code.highcharts.com/highcharts.js"></script>
<script src="https://code.highcharts.com/modules/exporting.js"></script>

<script>
    Highcharts.chart('customersPie', {
        chart: {
            plotBackgroundColor: null,
            plotBorderWidth: null,
            plotShadow: false,
            type: 'pie'
        },
        credits: {
            enabled: false
        },
        title: {
            text: ''
        },
        tooltip: {
            pointFormat: '{series.name}: <b>{point.percentage:.0f}%</b>'
        },
        accessibility: {
            point: {
                valueSuffix: '%'
            }
        },
        plotOptions: {
            pie: {
                allowPointSelect: true,
                cursor: 'pointer',
                dataLabels: {
                    enabled: false
                },
                showInLegend: true
            }
        },
        series: [{
            name: '<?= trans('appointments') ?>',
            colorByPoint: true,
            data: [
            <?php
              foreach ($customers as $customer) {
                echo '{
                  name: "'.$customer->customer_name.' ('. $customer->total.')",
                  y: '.$customer->total.'
                },';
              }
            ?>
          ]
        }]
    });


    Highcharts.chart('staffPie', {
        chart: {
            plotBackgroundColor: null,
            plotBorderWidth: null,
            plotShadow: false,
            type: 'pie'
        },
        credits: {
            enabled: false
        },
        title: {
            text: ''
        },
        tooltip: {
            pointFormat: '<b>{point.percentage:.0f}%</b>'
        },
        accessibility: {
            point: {
                valueSuffix: '%'
            }
        },
        plotOptions: {
            pie: {
                allowPointSelect: true,
                cursor: 'pointer',
                dataLabels: {
                    enabled: false
                },
                showInLegend: true
            }
        },
        series: [{
            name: '<?= trans('appointments') ?>',
            colorByPoint: true,
            data: [
            <?php
              foreach ($staffs as $staff) {
                echo '{
                  name: "'.$staff->staff_name.' ('. $staff->total.')",
                  y: '.$staff->total.'
                },';
              }
            ?>
          ]
        }]
    });
  

    var serviceData = <?= $service_data; ?>;
    var serviceAxis = <?= $service_axis; ?>;

    Highcharts.chart('serviceChart', {
        chart: {
            type: 'areaspline'
        },
        credits: {
            enabled: false
        },
        title: {
            text: ''
        },
        xAxis: {
            categories: serviceAxis
        },
        yAxis: {
            title: {
                text: ''
            },
            labels: {
                format: '{value}'
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
                    format: '{point.y} <?= trans('appointments') ?>'
                }
            }
        },

        tooltip: {
            headerFormat: '<span class="fs-14">{series.name}</span><br>',
            pointFormat: '<span>{point.name}</span> <b>{point.y}</b><br/>'
        },

        series: [
            {
                name: '<?= trans('services') ?>',
                data: serviceData,
                color: 'rgb(35, 199, 112, .5)'
            }
        ]
    });


    var netData = <?= $net_data; ?>;
    var netAxis = <?= $net_axis; ?>;

    Highcharts.chart('netIncomeChart', {
        chart: {
            type: 'column'
        },
        credits: {
            enabled: false
        },
        title: {
            text: ''
        },
        xAxis: {
            categories: netAxis
        },
        yAxis: {
            title: {
                text: ''
            },
            labels: {
                format: '<?php if($this->business->curr_locate == 0){echo $currency;} ?>{value}<?php if($this->business->curr_locate == 1){echo $currency;} ?>'
            }
        },
        legend: {
            enabled: true
        },
        plotOptions: {
            series: {
                pointPadding: 0.4,
                groupPadding: 0,
                borderWidth: 0,
                dataLabels: {
                    enabled: true,
                    format: '<?php if($this->business->curr_locate == 0){echo $currency;} ?>{point.y}<?php if($this->business->curr_locate == 1){echo $currency;} ?>'
                }
            }
        },

        tooltip: {
            headerFormat: '<span class="fs-14">{series.name}</span><br>',
            pointFormat: '<span>{point.name}</span> <b><?php if($this->business->curr_locate == 0){echo $currency;} ?>{point.y}<?php if($this->business->curr_locate == 1){echo $currency;} ?></b><br/>'
        },

        series: [
            {
                name: '<?= trans('net-income') ?>',
                data: netData,
                color: '#007bff'
            }
        ]
    });
</script>
