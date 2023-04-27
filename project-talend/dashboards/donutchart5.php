<?php
$donut5 = mysqli_query($conn,"SELECT gender, department, COUNT(id) AS total_resigned FROM retention_data WHERE left_employee=1 AND department=5 $edu_attrition GROUP BY gender;");
$donut5_count = mysqli_fetch_array(mysqli_query($conn,"SELECT  COUNT(*) AS total FROM retention_data WHERE left_employee=1 AND department=5 $edu_attrition;"))['total'];
?>
<script type="text/javascript">
    google.charts.load("current", {packages:["corechart"]});
    google.charts.setOnLoadCallback(drawChart);
    function drawChart() {
        var data = google.visualization.arrayToDataTable([
            ['Gender', 'Total Number of Resigned Employees'],
            
            <?php
            while($data = mysqli_fetch_assoc($donut5))
            {
                $gender = $data['gender'] == 0 ? 'Male' : 'Female';
                echo "['".$gender."',".$data['total_resigned']."],";
            }
            ?>
        ]);
        var colors = ['#e8821b', '#ba6816'];
        var options = {
            pieHole: 0.4,
            colors: colors,
            legend: 'none',
            backgroundColor: 'transparent',
            pieSliceTextStyle: {fontSize: 14},
        };

        var chart = new google.visualization.PieChart(document.getElementById('donutchart5'));
        chart.draw(data, options);
    }
</script>