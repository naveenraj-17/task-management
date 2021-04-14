<?php
session_start();
if(isset($_SESSION['is_login'])){
    if(isset($_SESSION['employee_id'])){
        header("Location: employee-tasks.php");
    }
    else header("Location: tasks.php");
}
else header("Location: login.php");
