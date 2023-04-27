<?php
$barchart0 = mysqli_query($conn,"SELECT department , COUNT(gender) AS Gender FROM retention_data WHERE left_employee=1 $edu_attrition GROUP BY department ORDER BY COUNT(gender)DESC; ");
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
    ['Department', 'Employees'],
    
    <?php
        while($data = mysqli_fetch_assoc($barchart0))
        {
            $department_name = $department_names[$data['department']];
            echo "['".$department_name."',".$data['Gender']."],";
        }
    ?>
    ]);

    var colors = ['#ef9b1d'];
    var options = {
        bars: 'horizontal',
        colors: colors,
        bar: {groupWidth: "95%"},
        backgroundColor: 'transparent',
        legend: { position: "none" },
        hAxis: {title: 'no. of Employee'},
    };

    var chart = new google.charts.Bar(document.getElementById('barchart0'));

    chart.draw(data, google.charts.Bar.convertOptions(options));
}
</script>
