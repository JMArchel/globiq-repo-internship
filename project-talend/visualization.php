<?php 
    include "header.html"; 
    include "connection.php";
    $edu ="";
    $edu_attrition ="";
    $total_employees = mysqli_fetch_array(mysqli_query($conn,"SELECT COUNT(*) AS total_employee FROM `retention_data`;"))['total_employee'];
    //total employees who left
    $attrition=mysqli_fetch_array(mysqli_query($conn,"SELECT COUNT(*) AS total_attrition FROM `retention_data`WHERE `left_employee`=1;"))['total_attrition'];
    //attrition rate
    $attrition_rate=number_format(($attrition/$total_employees)*100,2,".","");
    //active employees
    $active_employees=$total_employees-$attrition;
    //average age
    $average_age=round(mysqli_fetch_array(mysqli_query($conn,"SELECT AVG(`age`) as avg_age FROM `retention_data`;"))['avg_age']);
    //list of educations
    $education = mysqli_query($conn,"SELECT id, description FROM `education_list`;");
    //gender attrition
    $gender0 = mysqli_fetch_array(mysqli_query($conn,"SELECT COUNT(*) AS female FROM retention_data WHERE left_employee=1 AND gender=0;"))['female'];
    $gender0 = number_format(($gender0/$attrition)*100,2,'.','');
    $gender1 = number_format(100-$gender0,2,'.','');

    if(isset($_POST['pass'])){
        $edu =$_POST['education'];
        $edu_attrition=str_replace("WHERE", "AND", $edu);
        if ($edu===""){
            header("location: visualization.php");
        }
        //total employees
        $total_employees = mysqli_fetch_array(mysqli_query($conn,"SELECT COUNT(*) AS total_employee FROM `retention_data` $edu;"))['total_employee'];
        //total employees who left
        $attrition=mysqli_fetch_array(mysqli_query($conn,"SELECT COUNT(*) AS total_attrition FROM `retention_data`WHERE `left_employee`=1 $edu_attrition;"))['total_attrition'];
        //attrition rate
        $attrition_rate=number_format(($attrition/$total_employees)*100,2,".","");
        //active employees
        $active_employees=$total_employees-$attrition;
        //average age
        $average_age=round(mysqli_fetch_array(mysqli_query($conn,"SELECT AVG(`age`) as avg_age FROM `retention_data` $edu;"))['avg_age']);
        //list of educations
        $education = mysqli_query($conn,"SELECT id, description FROM `education_list`;");
        //gender attrition
        $gender0 = mysqli_fetch_array(mysqli_query($conn,"SELECT COUNT(*) AS female FROM retention_data WHERE left_employee=1 $edu_attrition AND gender=0;"))['female'];
        $gender0 = number_format(($gender0/$attrition)*100,2,'.','');
        $gender1 = number_format(100-$gender0,2,'.','');
    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.3.0/font/bootstrap-icons.css">
    <link rel="stylesheet" href="style.css">
    <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>

    <title>DASHBOARD</title>
</head>
<?php 
include "dashboards/donutchart0.php"; 
include "dashboards/donutchart1.php"; 
include "dashboards/donutchart2.php"; 
include "dashboards/donutchart3.php"; 
include "dashboards/donutchart4.php"; 
include "dashboards/donutchart5.php"; 
include "dashboards/donutchart6.php"; 
include "dashboards/donutchart7.php"; 
include "dashboards/donutchart8.php"; 
include "dashboards/donutchart9.php";
include "dashboards/barchart0.php";
include "dashboards/barchart1.php"; 
include "dashboards/barchart2.php"; 
include "dashboards/stackedchart0.php";
include "dashboards/piechart0.php";
?>
<body>
    <div class="visualization">
        <div class="row">
            <div class="col-9">
                <h2 class="bold">Dashboard
                <span>(
                    <?php 
                        if ($edu!=""){
                            $edu_list_change=str_replace("education LIKE", "id=", $edu);
                            $edu_list = strtoupper(mysqli_fetch_array(mysqli_query($conn,"SELECT description FROM `education_list` $edu_list_change;"))['description']);
                            echo $edu_list;
                        }
                        else{
                            echo"ALL";
                        }
                    ?>
                )</span>
                </h2>
                <p>Employee Overview & Summary</p>
            </div>
            <form method="POST" class="col-3" style="display: flex; align-items: center;">
                <div class="input-group">
                    <select class="form-select custom-select mb-3" name="education">
                        <option value="" selected>All</option>
                        <?php while ($educations=mysqli_fetch_assoc($education)){?>
                            <option value="WHERE education LIKE <?php echo $educations['id'];?>">
                                <?php echo $educations['description'];?>
                            </option>
                        <?php };?>
                    </select>
                    <div class="input-group-append">
                        <input class="btn btn-success mb-3" type="submit" value="submit" name="pass">
                    </div>
                </div>
            </form>
        </div>
        <section class="dashboard">
            <div class="row">
                <div class="col-2 single text-center"><p>Total Employees</p><h5><?php echo $total_employees; ?></h5></div>
                <div class="col-2 single text-center"><p>Attrition</p><h5><?php echo $attrition; ?></h5></div>
                <div class="col-2 single text-center"><p>Attrition Rate</p><h5><?php echo $attrition_rate,"%"; ?></h5></div>
                <div class="col-2 single text-center"><p>Active Employees</p><h5><?php echo $active_employees; ?></h5></div>
                <div class="col-2 single text-center"><p>Average Age</p><h5><?php echo $average_age; ?></h5></div>
            </div><br>
            <div class="row">
                <div class="col-1">&nbsp;</div>
                <div class="col-3 text-center">GENDER-WISE ATTRITION</div>
                <div class="col-7 text-center">DEPARTMENT-WISE ATTRITION</div>
                <div class="col-1">&nbsp;</div>
            </div><br>
            <div class="row">
                <div class="col-1">&nbsp;</div>
                <div class="col-3 out-big">
                    <div class="gender-div" style="background:#ba6816;"><img src="gender-01.svg" alt="" class="gender"><p><?php echo $gender1,"%"; ?></p></div>
                    <div class="gender-div" style="background:#e8821b;"><img src="gender-02.svg" alt="" class="gender"><p><?php echo $gender0,"%"; ?></p></div>
                </div>
                <div class="col-7 out-big back-chart"><div id="barchart0" class="chartbar"></div></div>
                <div class="col-1">&nbsp;</div>
            </div><br><br>
            <h4 class="text-center text-uppercase highlight">GENDER-DEPARTMENT WISE ATTRITION</h4>
            <div class="row">
                <div class="col-1">&nbsp;</div>
                <div class="col-2 text-center">ADMIN</div>
                <div class="col-2 text-center">ENGINEERING</div>
                <div class="col-2 text-center">FINANCE</div>
                <div class="col-2 text-center">INFORMATION TECH</div>
                <div class="col-2 text-center">LOGISTICS</div>
                <div class="col-1">&nbsp;</div>
            </div>
            <div class="row">
                <div class="col-1">&nbsp;</div>
                <div class="col-2 out"><div id="donutchart0" class="chart"></div><div class="data"><?php echo $donut0_count;?></div></div>
                <div class="col-2 out"><div id="donutchart1" class="chart"></div><div class="data"><?php echo $donut1_count;?></div></div>
                <div class="col-2 out"><div id="donutchart2" class="chart"></div><div class="data"><?php echo $donut2_count;?></div></div>
                <div class="col-2 out"><div id="donutchart3" class="chart"></div><div class="data"><?php echo $donut3_count;?></div></div>
                <div class="col-2 out"><div id="donutchart4" class="chart"></div><div class="data"><?php echo $donut4_count;?></div></div>
                <div class="col-1">&nbsp;</div>
            </div>
            <div class="row">
                <div class="col-1">&nbsp;</div>
                <div class="col-2 out"><div id="donutchart5" class="chart"></div><div class="data"><?php echo $donut5_count;?></div></div>
                <div class="col-2 out"><div id="donutchart6" class="chart"></div><div class="data"><?php echo $donut6_count;?></div></div>
                <div class="col-2 out"><div id="donutchart7" class="chart"></div><div class="data"><?php echo $donut7_count;?></div></div>
                <div class="col-2 out"><div id="donutchart8" class="chart"></div><div class="data"><?php echo $donut8_count;?></div></div>
                <div class="col-2 out"><div id="donutchart9" class="chart"></div><div class="data"><?php echo $donut9_count;?></div></div>
                <div class="col-1">&nbsp;</div>
            </div>
            <div class="row">
                <div class="col-1">&nbsp;</div>
                <div class="col-2 text-center">MARKETING</div>
                <div class="col-2 text-center">OPERATIONS</div>
                <div class="col-2 text-center">RETAIL</div>
                <div class="col-2 text-center">SALES</div>
                <div class="col-2 text-center">SUPPORT</div>
                <div class="col-1">&nbsp;</div>
            </div><br><br>
            <div class="row">
                <div class="col-1">&nbsp;</div>
                <div class="col-7 text-center text-uppercase">Gender-wise Attrition by Age Group</div>
                <div class="col-4 text-center text-uppercase">Gender-wise Average Salary</div>
            </div><br>
            <div class="row">
                <div class="col-1">&nbsp;</div>
                <div class="col-7 out-big back-chart"><div id="stackedchart0" class="chartbar"></div></div>
                <div class="col-3 out-big"><div id="piechart0" class="chart"></div>
                <div class="col-1">&nbsp;</div>
            </div>
            <div class="row">
                <div class="col-12 text-center text-uppercase" style="padding-top: 2rem;padding-bottom:1rem;">Employee Tenure by Department and Status</div>
            </div>
            <div class="row">
                <div class="col-10 out-big-long back-chart"><div id="barchart1" class="chartbar-long"></div>
                <div class="col-1">&nbsp;</div>
            </div>
            <div class="row">
                <div class="col-12 text-center text-uppercase" style="padding-top: 2rem;padding-bottom:1rem;"> Satisfaction Rate by Project Count and Gender</div>
            </div>
            <div class="row">
                <div class="col-10 out-big-long back-chart"><div id="barchart2" class="chartbar-long"></div>
                <div class="col-1">&nbsp;</div>
            </div>
        </section>
    </div>
</body>
</html>