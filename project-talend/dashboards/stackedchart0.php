<?php 
$stackedchart0 = mysqli_query($conn,"SELECT CONCAT(FLOOR(age/5)*5, '-', FLOOR(age/5)*5 + 4) AS age_group, COUNT(CASE WHEN gender = '0' THEN 1 END) AS num_female, COUNT(CASE WHEN gender = '1' THEN 1 END) AS num_male, COUNT(*) AS total FROM retention_data WHERE left_employee = 1 $edu_attrition GROUP BY FLOOR(age/5)*5 ORDER BY total DESC;
");
?>
<script type="text/javascript">
    google.charts.load('current', {'packages':['bar']});
    google.charts.setOnLoadCallback(drawChart);

    function drawChart() {
    var data = google.visualization.arrayToDataTable([
        ['Age Group', 'Male', 'Female'],
        
        <?php

            while($data = mysqli_fetch_assoc($stackedchart0))
            {
            echo "['".$data['age_group']."',".$data['num_male'].",".$data['num_female']."],";
            }
        ?>
    ]);

    var colors = ['#e8821b', '#ba6816'];
    var options = {
        bars: 'horizontal',
        colors: colors,
        bar: { groupWidth: '95%' },
        backgroundColor: 'transparent',
        isStacked: true,
        legend: { alignment: 'center',position: 'bottom' },
    };

    var chart = new google.charts.Bar(document.getElementById('stackedchart0'));

    chart.draw(data, google.charts.Bar.convertOptions(options));
    }
</script>

