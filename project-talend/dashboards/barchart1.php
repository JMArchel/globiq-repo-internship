<?php 

$barchart1 = mysqli_query($conn,"SELECT department, COUNT(CASE WHEN tenure = '5' THEN 1 END) AS Five, 
COUNT(CASE WHEN tenure = '6' THEN 1 END) AS Six, 
COUNT(CASE WHEN tenure = '7' THEN 1 END) AS Seven,
COUNT(CASE WHEN tenure = '8' THEN 1 END) AS Eight, 
COUNT(CASE WHEN tenure = '9' THEN 1 END) AS Nine,
COUNT(department) AS counts
FROM retention_data WHERE left_employee = 1 $edu_attrition GROUP BY department ORDER BY counts DESC;");

$department_names = array(
  0 => 'Admin',
  1 => 'Engineering',
  2 => 'Finance',
  3 => 'Information Tech',
  4 => 'Logistics',
  5 => 'Marketing',
  6 => 'Operations',
  7 => 'Retail',
  8 => 'Sales',
  9 => 'Support',
);

?>
<script type="text/javascript">
  google.charts.load('current', {'packages':['bar']});
  google.charts.setOnLoadCallback(drawChart);
  function drawChart() {
    var data = google.visualization.arrayToDataTable([
      ['Department', 'Tenure(5)', 'Tenure(6)','Tenure(7)','Tenure(8)','Tenure(9)'],
      
      <?php

          while($data = mysqli_fetch_assoc($barchart1))
          {
            $department_name = $department_names[$data['department']];
            echo "['".$department_name."',
            ".$data['Five'].",
            ".$data['Six'].",
            ".$data['Seven'].",
            ".$data['Eight'].",
            ".$data['Nine']."],";
          }
      ?>
    ]);

    var colors = ['#ef9b1d'];
    var options = {
        bars: 'vertical',
        colors: colors,
        bar: {groupWidth: "95%"},
        backgroundColor: 'transparent',
        legend: { alignment: 'center',position: 'bottom' },
    };

    var chart = new google.charts.Bar(document.getElementById('barchart1'));

    chart.draw(data, google.charts.Bar.convertOptions(options));
  }
</script>