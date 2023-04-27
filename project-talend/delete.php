<?php 
    include "connection.php";
    
if (isset($_POST['confirm'])) {
    $sql = "TRUNCATE TABLE retention_data";

    if (mysqli_query($conn, $sql)) {
        header("location: data.php");
    }

    mysqli_close($conn);
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
    <title>Delete DATA</title>
</head>
<?php 
    include "header.html"; 
?>
<body class="cartoon-bg">
    <div class="d-flex justify-content-center align-items-center h-100">
        <div>
        <center>
            <h4>Are you sure you want to delete all data?</h4>
            <h5>This action cannot be undone.</h5>
            <form method="post">
                <input type="submit" name="confirm" value="Confirm" class="btn btn-danger btn-md md-2">
                <a href="data.php" type="button" class="btn btn-outline-dark btn-md md-2">Cancel</a>
            </form>
        </center>
        </div>
    </div>
</body>
