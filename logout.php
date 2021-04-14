<?php
session_start();
unset($_SESSION['employee_name'],$_SESSION['employee_id'],$_SESSION['is_login'],$_SESSION['is_admin']);
session_unset();
session_destroy();
header("Location: login.php");
