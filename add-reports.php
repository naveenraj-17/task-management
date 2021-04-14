<?php
session_start();
require_once "EmployeeClass.php";
$employee = new EmployeeClass();
$id = $_GET['id'];
if(isset($_POST['report'])){
    $result = $employee->add_reports($id,$_POST['report']);
    if($result['status'] == "success") $success = "Reports added successfully";
    else $error = $result['message'];
}

$report = $employee->get_tasks($id);
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, shrink-to-fit=no">
    <title>Task Management - Tasks</title>
    <link rel="stylesheet" href="assets/bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="assets/css/styles.css">

    <script src="assets/js/jquery.min.js"></script>
</head>

<body>
<?include_once "navigation.php"?>
<section>
    <div class="container">
        <ol class="breadcrumb" style="margin-top: 20px;">
            <li class="breadcrumb-item"><a href="index.php"><span>Home</span></a></li>
            <li class="breadcrumb-item"><a href="employee-tasks.php"><span>Tasks</span></a></li>
            <li class="breadcrumb-item"><a href="#"><span>Add Reports</span></a></li>
        </ol>
    </div>
</section>
<div class="container">
    <div class="row">
        <div class="col-md-6 offset-md-3">
            <?include("alerts.php")?>
            <form action="add-reports.php?id=<?=$id?>" method="post">
                <div class="row">
                    <div class="col-md-12">
                        <div class="form-group">
                            <label for="report">Report <span class="text-danger">*</span></label>
                            <textarea type="text" class="form-control" id="report" name="report" placeholder="Make it simple as possible" required></textarea>
                        </div>
                    </div>
                </div>
                <div class="center">
                    <button type="submit" class="btn btn-primary"> Update</button>
                </div>
            </form>
        </div>
    </div>
</div>
<script src="assets/js/jquery.min.js"></script>
<script src="assets/bootstrap/js/bootstrap.min.js"></script>
</body>
</html>