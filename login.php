<?php
session_start();
if(isset($_POST['email'])){
    if($_POST['email'] == "admin@dckap.com"){
        if($_POST['password'] == "admin123"){
            $_SESSION['is_login'] = true;
            $_SESSION['is_admin'] = true;
            $_SESSION['login_type'] = "admin";
            header("Location: tasks.php");
        }
        else{
            $error = "Incorrect Password, Retry again";
        }
    }
    else{
        include_once "config/config.php";
        $employee = mysqli_fetch_array(mysqli_query($mysqli,"SELECT * FROM employees WHERE email = '$_POST[email]'"));
        if($employee){
            if ($employee['password'] == $_POST['password']){
                $_SESSION['is_login'] = true;
                $_SESSION['login_type'] = "employee";
                $_SESSION['employee_id'] = $employee['id'];
                $_SESSION['employee_name'] = $employee['name'];
                header("Location: employee-tasks.php");
            }
            else{
                $error = "Incorrect Password, Retry again";
            }
        }
        else{
            $error = "Employee not found retry again";
        }
    }
}

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

<body class="text-truncate">
<section style="margin-top: 130px;">
    <div class="container full-height" style="width: 100%;height: 100%;">
        <div class="row flex center v-center full-height">
            <div class="col-8 col-sm-4 col-xl-5">
                <?include "alerts.php"?>
                <div class="form-box">
                    <form action="login.php" method="post">
                        <fieldset>
                            <legend>Login in</legend>
                            <img id="avatar" class="avatar round" src="assets/img/avatar.png">
                            <input class="form-control" type="email" id="username" name="email" placeholder="email">
                            <input class="form-control" type="password" id="password" name="password" placeholder="password">
                            <button class="btn btn-primary btn-block" type="submit">LOGIN </button>
                        </fieldset>
                    </form>
                </div>
            </div>
        </div>
    </div>
</section>
<script src="assets/js/jquery.min.js"></script>
<script src="assets/bootstrap/js/bootstrap.min.js"></script>
</body>

</html>
