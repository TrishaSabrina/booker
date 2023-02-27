<!-- high charts js-->
<script src="https://code.highcharts.com/highcharts.js"></script>

<script>

  var incomeData = <?= $income_data; ?>;
  var incomeAxis = <?= $income_axis; ?>;

  Highcharts.chart('userIncomeChart', {
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
          categories: incomeAxis
      },
      yAxis: {
          title: {
              text: ''
          }

      },
      legend: {
          enabled: true
      },
      plotOptions: {
          series: {
              borderWidth: 0,
              dataLabels: {
                  enabled: true,
                  format: '<?php echo html_escape($currency) ?>{point.y}'
              }
          }
      },

      tooltip: {
          headerFormat: '<span style="font-size:11px">{series.name}</span><br>',
          pointFormat: '<span style="color:{point.color}">{point.name}</span> <b><?php echo html_escape($currency) ?>{point.y}</b><br/>'
      },

      series: [
          {
              name: "Income",
              data: incomeData,
              color: '#2568ef'
          }
      ]
  });

</script>