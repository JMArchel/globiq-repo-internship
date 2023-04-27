<?php 
    include "header.html"; 
    include "connection.php";
    
    //submit the data
    if (isset($_POST['submit'])) {
        // Get file extension
        $file_extension = strtolower(pathinfo($_FILES['file']['name'], PATHINFO_EXTENSION));
    
        // Check if file is CSV
        if ($file_extension == 'csv') {
            // Get file data
            $file = $_FILES['file']['tmp_name'];
            $handle = fopen($file, "r");
    
            // Loop through file data and insert into database
            while (($data = fgetcsv($handle, 1000, ";")) != FALSE) {
                $age = mysqli_real_escape_string($conn, $data[0]);
                $gender = mysqli_real_escape_string($conn, $data[1]);
                $department = mysqli_real_escape_string($conn, $data[2]);
                $education = mysqli_real_escape_string($conn, $data[3]);
                $promoted = mysqli_real_escape_string($conn, $data[4]);
                $review = mysqli_real_escape_string($conn, $data[5]);
                $projects = mysqli_real_escape_string($conn, $data[6]);
                $salary = mysqli_real_escape_string($conn, $data[7]);
                $tenure = mysqli_real_escape_string($conn, $data[8]);
                $satisfaction = mysqli_real_escape_string($conn, $data[9]);
                $bonus = mysqli_real_escape_string($conn, $data[10]);
                $avg_hrs_month = mysqli_real_escape_string($conn, $data[11]);
                $left_employee = mysqli_real_escape_string($conn, $data[12]);
    
                $sql = "INSERT INTO retention_data( age, gender, department, education, promoted, review, projects, salary, tenure, satisfaction, bonus, avg_hrs_month, left_employee) VALUES ( '$age', '$gender', '$department', '$education', '$promoted', '$review', '$projects', '$salary', '$tenure', '$satisfaction', '$bonus', '$avg_hrs_month', '$left_employee')";
                $do = mysqli_query($conn, $sql);
            }
    
            fclose($handle);
    
            ?>
            <div class="alert alert-success text-center" role="alert">
                File uploaded and data loaded into database successfully!
            </div>
            <?php
        } else {
            ?>
            <div class="alert alert-warning text-center" role="alert">
                Invalid file type. Please upload a CSV file.
            </div>
            <?php
        }
    }

    //delete the data
    if (isset($_POST['confirm'])) {
        header("location: delete.php");
    }

    //count total rows of data
    $sql_total = mysqli_query($conn,"SELECT COUNT(*) FROM `retention_data`");
    $row = mysqli_fetch_row($sql_total);
    $total_rows = $row[0];
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
    <title>DATA</title>
</head>
<body>
    <div class="d-flex justify-content-center">
        <div>
            <div class="row">
                <div class="col-md-4">&nbsp;</div>
                <div class="col-md-4 text-center">
                    <h1>DATA RECORD</h1>
                </div>
                <div class="col-md-4 text-end">
                    <form method="post" enctype="multipart/form-data">
                        <button class="btn btn-danger" type="submit" name="confirm">Delete</button>
                    </form>
                </div>
            </div>
            <div class="row">
                <div class="col-md-3">&nbsp;</div>
                    <form class="col-md-6" method="post" enctype="multipart/form-data">
                        <div class="input-group mb-3">
                            <input type="file" class="form-control" name="file" aria-describedby="inputGroupFileAddon">
                            <button class="btn btn-success" type="submit" name="submit" id="inputGroupFileAddon">Submit</button>
                        </div>
                    </form>
                <div class="col-md-3">&nbsp;</div>
            </div>
            <div class="col-md-12 text-right">
                Total rows: <?php echo $total_rows; ?>
            </div>
            <table class="table table-stripped table-hover">
                <thead>
                    <tr>
                        <th class="left">ID</th>
                        <th>Age</th>
                        <th>Gender</th>
                        <th>Department</th>
                        <th>Education</th>
                        <th>Promoted</th>
                        <th>Review</th>
                        <th>Projects</th>
                        <th>Salary ($)</th>
                        <th>Tenure</th>
                        <th>Satisfaction</th>
                        <th>Bonus</th>
                        <th>Avg. Hrs./Month</th>
                        <th class="right">Left</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    if ($total_rows<=0){
                        ?>
                        <tr>
                            <td colspan="14" class="text-center">No Data</td>
                        </tr>
                        <?php
                    }else{
                        $sql = mysqli_query($conn,"SELECT * FROM `retention_data` LIMIT 50");
                        if (!$sql) {
                            die("Query failed: " . mysqli_error($conn));
                        }
                        while ($row=mysqli_fetch_array($sql)){
                    ?>
                    <tr>
                        <td> <?php echo $row["id"]; ?> </td>
                        <td> <?php echo $row["age"]; ?></td>
                        <td> <?php 
                            if ($row["gender"] == 0) {
                                echo "male";
                            } else {
                                echo "female";
                            }
                            ?>
                        </td>
                        <td> <?php 
                            switch ($row["department"]) {
                                case 0:
                                    echo "admin";
                                    break;
                                case 1:
                                    echo "engineering";
                                    break;
                                case 2:
                                    echo "finance";
                                    break;
                                case 3:
                                    echo "it";
                                    break;
                                case 4:
                                    echo "logistics";
                                    break;
                                case 5:
                                    echo "marketing";
                                    break;
                                case 6:
                                    echo "operations";
                                    break;
                                case 7:
                                    echo "retail";
                                    break;
                                case 8:
                                    echo "sales";
                                    break;
                                case 9:
                                    echo "support";
                                    break;
                                default:
                                    echo "Unknown department";
                            }?>
                        </td>
                        <td> <?php
                            switch ($row["education"]) {
                                case 0:
                                    echo "bachelor";
                                    break;
                                case 1:
                                    echo "below college";
                                    break;
                                case 2:
                                    echo "college";
                                    break;
                                case 3:
                                    echo "doctorate";
                                    break;
                                case 4:
                                    echo "masters";
                                    break;
                                default:
                                    echo "Unknwn Education";}
                        ?></td>
                        <td> <?php 
                            if ($row["promoted"] == 0) {
                                echo "no";
                            } else {
                                echo "yes";
                            }
                            ?>
                        </td>
                        <td> <?php echo $row["review"]; ?></td>
                        <td> <?php echo $row["projects"]; ?></td>
                        <td> <?php 
                            if ($row["salary"]!=null){echo number_format($row["salary"],0,'.',',');}
                            ?>
                        </td>
                        <td> <?php echo $row["tenure"]; ?></td>
                        <td> <?php echo $row["satisfaction"]; ?></td>
                        <td> <?php 
                            if ($row["bonus"] == 0) {
                                echo "no";
                            } else {
                                echo "yes";
                            }
                            ?>
                        </td>
                        <td> <?php 
                            echo number_format($row["avg_hrs_month"],2,'.',',');
                            ?>
                        </td>
                        <td> <?php 
                            if ($row["left_employee"] == 0) {
                                echo "no";
                            } else {
                                echo "yes";
                            }
                            ?>
                        </td>
                    </tr>
                    <?php
                        }}
                    ?>
                </tbody>
            </table>
        </div>            
    </div>
</body>
</html>