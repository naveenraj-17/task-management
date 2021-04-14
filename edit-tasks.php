<?php
session_start();
require_once "Main.php";
$main = new Main();
$id = $_GET['id'];
if(isset($_POST['task_name'])){
    $result = $main->edit_tasks($_POST,$id);
    if($result['status'] == "success") $success = "Tasks updated successfully";
    else $error = $result['message'];
}
$task = mysqli_fetch_assoc($main->get_tasks($id));
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
            <li class="breadcrumb-item"><a href="tasks.php"><span>Tasks</span></a></li>
            <li class="breadcrumb-item"><a href="#"><span>Manage Tasks</span></a></li>
        </ol>
    </div>
</section>
<div class="container">
    <div class="row">
        <div class="col-md-6 offset-md-3">
            <?include("alerts.php")?>
            <form action="edit-tasks.php?id=<?=$id?>" method="post">
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="name">Task Name <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" id="name" name="task_name" pattern="[a-zA-Z. ]+" value="<?=$task['task_name']?>" placeholder="Name" required>
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
                            <input type="text" class="form-control" id="taskcategory" name="category" value="<?=$task['category']?>" placeholder="Category" required>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="estimatedTime">Estimated Time <span class="text-danger">*</span></label>
                            <input type="number" class="form-control" id="estimatedTime" name="estimated_time" value="<?=$task['estimated_time']?>" placeholder="Estimated Time" required>
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
<script src="assets/js/jquery.min.js"></script>
<script src="assets/bootstrap/js/bootstrap.min.js"></script>
<script>
    $("select[name=employee_id]").val('<?=$task['employee_id']?>');
    $("select[name=task_status]").val('<?=$task['task_status']?>');
</script>
</body>
</html>


