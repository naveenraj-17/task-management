<?php
session_start();
$post = $_POST;
require_once "Main.php";
$main = new Main();

$result = $main->delete_row($post['table'],$post['id']);

echo $result;
