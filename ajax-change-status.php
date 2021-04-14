<?php
session_start();
$post = $_POST;
require_once "EmployeeClass.php";
$employee = new EmployeeClass();

$result = $employee->change_status($post['value'],$post['id']);

echo $result;
