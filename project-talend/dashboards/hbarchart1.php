<?php require_once 'connection.php' ?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
        content="width=device-widht, user-scalable=no, initial-scale=1.0, maxiumum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.8.1/font/bootstrap-icons.css">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.7.2/Chart.bundle.min.js"></script>
    <title>BAR CHART</title>
</head>
<body>

<?php 

$query = "SELECT gender, left_employee , COUNT(bonus) AS Count FROM retention_data GROUP BY gender, left_employee;";
$result = mysqli_query($conn,$query);

?>

<html>
  <head>
  <script type="text/javascript">
    google.charts.load('current', {'packages':['bar']});
    google.charts.setOnLoadCallback(drawChart);

    function drawChart() {
      var data = google.visualization.arrayToDataTable([
        ['Gender', 'Bonus', 'Count'],
        <?php
          while($row = mysqli_fetch_assoc($result)){
            echo "['" . $row['gender'] . "', '" . $row['bonus'] . "', " . $row['Count'] . "]";
          }
        ?>
      ]);

      var options = {
        chart: {
          title: 'Retention Data by Gender and Bonus',
        },
        bars: 'horizontal',
        legend: { position: 'none' },
        hAxis: {
          title: 'Count',
        },
        vAxis: {
          title: 'Gender and Bonus'
        },
        colors: ['#1b9e77', '#d95f02', '#7570b3']
      };

      var chart = new google.charts.Bar(document.getElementById('barchart_material'));

      chart.draw(data, google.charts.Bar.convertOptions(options));
    }
  </script>

  </head>
  <body>
    <div id="barchart_material" style="width: 900px; height: 500px;"></div>
  </body>
</html>