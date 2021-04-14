<?php
session_start();
require_once "Main.php";
$main = new Main();
if(isset($_POST['name'])){
    $result = $main->add_employees($_POST);
    if($result['status'] == "success") $success = "Employee added successfully";
    else $error = $result['message'];
}
$employees = $main->get_employees();
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
            <li class="breadcrumb-item"><a href="#"><span>Manage Employees</span></a></li>
        </ol>
    </div>
</section>
<div class="container">
    <div class="row">
        <div class="col-md-4 offset-md-4">
            <?include("alerts.php")?>
            <form action="employee.php" method="post">
                <div class="row">
                    <div class="col-md-12">
                        <div class="form-group">
                            <label for="name">Name <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" id="name" name="name" pattern="[a-zA-Z. ]+" title="Name should only have text, space and dot" placeholder="Name" required>
                        </div>
                    </div>
                    <div class="col-md-12">
                        <div class="form-group">
                            <label for="email">Email <span class="text-danger">*</span></label>
                            <input type="email" class="form-control" id="email" name="email" placeholder="Email" required>
                        </div>
                    </div>
                    <div class="col-md-12">
                        <div class="form-group">
                            <label for="password">Password <span class="text-danger">*</span></label>
                            <input type="password" class="form-control" id="password" name="password" pattern=".{8,}" title="Password should have 8 or more characters" placeholder="Password" required>
                        </div>
                    </div>
                </div>
                <div class="center">
                    <button type="submit" class="btn btn-primary"> Add</button>
                </div>
            </form>
        </div>
    </div>
</div>
<section>
    <div class="container" style="margin-top: 20px;margin-bottom: 20px;">
        <h2 style="padding: 10px 0">Manage Employees</h2><table id="example" class="table table-striped table-bordered" cellspacing="0" width="100%">
            <thead>
            <tr>
                <th>Id</th>
                <th>Name</th>
                <th>Email</th>
                <th>Password</th>
                <th>Date Time</th>
                <th>Options</th>
            </tr>
            </thead>
            <tbody>
            <?if($employees):?>
            <?while ($row = mysqli_fetch_assoc($employees)):?>
                <tr>
                    <td><?=$row['id']?></td>
                    <td><?=$row['name']?></td>
                    <td><?=$row['email']?></td>
                    <td><?=$row['password']?></td>
                    <td><?=date("d-m-y h:i a",strtotime($row['date_time']))?></td>
                    <td><a class="table-links" href="edit-employee.php?id=<?=$row['id']?>">Edit</a>&nbsp;<a class="table-links" href="javascript:void(0)" onclick="Remove(this,<?=$row['id']?>,'employees')">Delete</a></td>
                </tr>
            <?endwhile;?>
            <?endif;?>
            </tbody>
        </table>
    </div>
</section>
<script src="assets/js/jquery.min.js"></script>
<script src="assets/bootstrap/js/bootstrap.min.js"></script>
<script>
    function Remove(e,id,table) {
        var c = confirm("Are you sure you want to delete this row, It can't be recovered??");
        if(c){
            $.post("ajax-delete.php",{id:id,table:table},function (data,success) {
                data = jQuery.parseJSON(data);
                if(data.status === "success"){
                    $(e).closest('tr').remove();
                }
                else{
                    alert(data.message);
                }
            });
        }
    }
</script>
</body>
</html>

