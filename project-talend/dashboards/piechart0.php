<?php
$piechart0 = mysqli_query($conn,"SELECT gender, AVG(salary) AS avg_sal FROM retention_data WHERE left_employee = 1 $edu_attrition GROUP BY gender;");
?>
<script type="text/javascript">
    google.charts.load("current", {packages:["corechart"]});
    google.charts.setOnLoadCallback(drawChart);
    function drawChart() {
    var data = google.visualization.arrayToDataTable([
        ['Gender', 'Average Salary'],
        
        <?php
            while($data = mysqli_fetch_assoc($piechart0))
            {
                $gender = $data['gender'] == 0 ? 'Male' : 'Female';
                echo "['".$gender."',".$data['avg_sal']."],";
            }
        ?>
    ]);
    var colors = ['#e8821b', '#ba6816'];
    var options = {
        colors: colors,
        legend: 'none',
        backgroundColor: 'transparent',
        pieSliceTextStyle: {fontSize: 14},
    };

    var chart = new google.visualization.PieChart(document.getElementById('piechart0'));
    chart.draw(data, options);
    }
</script>