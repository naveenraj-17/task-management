<?php
session_start();
require_once "Main.php";
$main = new Main();
$id = $_GET['id'];
if(isset($_POST['name'])){
    $result = $main->edit_employees($_POST,$id);
    if($result['status'] == "success") $success = "Employee updated successfully";
    else $error = $result['message'];
}
$employee = mysqli_fetch_assoc($main->get_employees($id));
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, shrink-to-fit=no">
    <title>Task Management - Login</title>
    <link rel="stylesheet" href="assets/bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="assets/css/styles.css">
</head>

<body>
<?include_once "navigation.php"?>
<section>
    <div class="container">
        <ol class="breadcrumb" style="margin-top: 20px;">
            <li class="breadcrumb-item"><a href="index.php"><span>Home</span></a></li>
            <li class="breadcrumb-item"><a href="employee.php"><span>Employees</span></a></li>
            <li class="breadcrumb-item"><a href="#"><span>Edit Employees</span></a></li>
        </ol>
    </div>
</section>
<div class="container">
    <div class="row">
        <div class="col-md-4 offset-md-4">
            <?include("alerts.php")?>
            <form action="edit-employee.php?id=<?=$employee['id']?>" method="post">
                <div class="row">
                    <div class="col-md-12">
                        <div class="form-group">
                            <label for="name">Name <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" id="name" name="name" value="<?=$employee['name']?>" pattern="[a-zA-Z. ]+" title="Name should only have text, space and dot" placeholder="Name" required>
                        </div>
                    </div>
                    <div class="col-md-12">
                        <div class="form-group">
                            <label for="email">Email <span class="text-danger">*</span></label>
                            <input type="email" class="form-control" id="email" name="email" value="<?=$employee['email']?>" placeholder="Email" required>
                        </div>
                    </div>
                    <div class="col-md-12">
                        <div class="form-group">
                            <label for="password">Password <span class="text-danger">*</span></label>
                            <input type="password" class="form-control" id="password" name="password" pattern=".{8,}" title="Password should have 8 or more characters" value="<?=$employee['password']?>" placeholder="Password" required>
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


