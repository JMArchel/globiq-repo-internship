<?php 
$barchart2 = mysqli_query($conn,"SELECT projects, 
AVG(CASE WHEN gender = 1 THEN satisfaction END) AS female, 
AVG(CASE WHEN gender = 0 THEN satisfaction END) AS male 
FROM retention_data WHERE left_employee=1 $edu_attrition GROUP BY projects;");
?>
<script type="text/javascript">
      google.charts.load('current', {'packages':['bar']});
      google.charts.setOnLoadCallback(drawChart);
      function drawChart() {
        var data = google.visualization.arrayToDataTable([
          ['Projects', 'Male', 'Female'],
          
          <?php

              while($data = mysqli_fetch_assoc($barchart2))
              {
                echo "['".$data['projects']."',
                ".$data['male'].",
                ".$data['female']."],";
              }
          ?>
        ]);

        var colors = ['#ef9b1d'];
        var options = {
          bars: 'vertical',
          colors: colors,
          bar: {groupWidth: "85%"},
          backgroundColor: 'transparent',
          legend: { alignment: 'center',position: 'bottom' },
        };

        var chart = new google.charts.Bar(document.getElementById('barchart2'));

        chart.draw(data, google.charts.Bar.convertOptions(options));
      }
    </script>