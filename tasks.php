<?php
session_start();
require_once "Main.php";
$main = new Main();
if(isset($_POST['task_name'])){
    $result = $main->add_tasks($_POST);
    if($result['status'] == "success") $success = "Tasks added successfully";
    else $error = $result['message'];
}
if(isset($_GET['task_status'])) $tasks = $main->get_tasks_filter($_GET['task_status'],$_GET['category']);
else $tasks = $main->get_tasks();
$employees = $main->get_employees();
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, shrink-to-fit=no">
    <title>Task Management - Manage Tasks</title>
    <link rel="stylesheet" href="assets/bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="assets/css/styles.css">
</head>

<body>
<?include_once "navigation.php"?>
<section>
    <div class="container">
        <ol class="breadcrumb" style="margin-top: 20px;">
            <li class="breadcrumb-item"><a href="index.php"><span>Home</span></a></li>
            <li class="breadcrumb-item"><a href="#"><span>Manage Tasks</span></a></li>
        </ol>
    </div>
</section>
<div class="container">
    <div class="row">
        <div class="col-md-6 offset-md-3">
            <?include("alerts.php")?>
            <form action="tasks.php" method="post">
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="name">Task Name <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" id="name" name="task_name" pattern="[a-zA-Z. ]+" placeholder="Name" required>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="employee">Assign to <span class="text-danger">*</span></label>
                            <select id="employee" class="form-control" name="employee_id" required>
                                <?if($employees):?>
                                <?while($row = mysqli_fetch_assoc($employees)):?>
                                <option value="<?=$row['id']?>"><?=$row['name']?></option>
                                <?endwhile;?>
                                <?else:?>
                                <option>none</option>
                                <?endif;?>
                            </select>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="taskcategory">Category <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" id="taskcategory" name="category" placeholder="Category" required>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="estimatedTime">Estimated Time <span class="text-danger">*</span></label>
                            <input type="number" class="form-control" id="estimatedTime" name="estimated_time" placeholder="Estimated Time" required>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="task_status">Task Status <span class="text-danger">*</span></label>
                            <select id="task_status" class="form-control" name="task_status" required>
                                <option value="todo">todo</option>
                                <option value="in-progress">In Progress</option>
                                <option value="testing">testing</option>
                                <option value="completed">completed</option>
                            </select>
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
        <h2 style="padding: 10px 0">Manage Tasks</h2>
        <form class="row row-cols-lg-auto g-3 align-items-center" action="tasks.php" method="get" style="padding-bottom: 20px">

            <div class="col-5">
                <input type="text" class="form-control" name="category" id="category" placeholder="Category">
            </div>

            <div class="col-5">
                <select class="form-select form-control" name="task_status" id="taskstatus">
                    <option value="" selected>Choose task status...</option>
                    <option value="todo">Todo</option>
                    <option value="in-progress">In Progress</option>
                    <option value="testing">Testing</option>
                    <option value="completed">completed</option>
                </select>
            </div>

            <div class="col-2">
                <button type="submit" class="btn btn-primary">Get</button>
            </div>
        </form>
        <table id="example" class="table table-striped table-bordered" cellspacing="0" width="100%">
            <thead>
            <tr>
                <th>Id</th>
                <th>Task Name</th>
                <th>Assigned to</th>
                <th>Category</th>
                <th>Estimated Time</th>
                <th>Completed Time</th>
                <th>Task Status</th>
                <th>Report</th>
                <th>Created at</th>
                <th>Options</th>
            </tr>
            </thead>
            <tbody>
            <?if($tasks):?>
            <?while ($row = mysqli_fetch_assoc($tasks)):?>
                <tr>
                    <td><?=$row['id']?></td>
                    <td><?=$row['task_name']?></td>
                    <td><?=$row['employee_name']?></td>
                    <td><?=$row['category']?></td>
                    <td><?=$row['estimated_time']?> hrs</td>
                    <td><?if($row['task_status'] == "completed" and $row['completed_time'] == 0):?>
                            less than 1 hr
                        <?else:?>
                        <?=$row['completed_time']?> hrs
                    <?endif;?>
                    </td>
                    <td><?=$row['task_status']?></td>
                    <td><?=(is_null($row['report']))?"-":$row['report']?></td>
                    <td><?=date("d-m-y h:i a",strtotime($row['date_time']))?></td>
                    <td><a class="table-links" href="edit-tasks.php?id=<?=$row['id']?>">Edit</a>&nbsp;<a class="table-links" href="javascript:void(0)" onclick="Remove(this,<?=$row['id']?>,'tasks')">Delete</a></td>
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


