<?php
session_start();
require_once "EmployeeClass.php";
$employee = new EmployeeClass();
$tasks = $employee->get_employee_tasks();
$overall = mysqli_fetch_assoc($employee->get_reports());
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
            <li class="breadcrumb-item"><a href="#"><span>Manage Tasks</span></a></li>
        </ol>
    </div>
</section>
<div class="container">
    <div class="row">
        <div class="col-md-3">
            <div class="card text-dark bg-light mb-3" style="max-width: 18rem;">
                <div class="card-body">
                    <div class="row">
                        <div class="col-4">
                            <h1 id="tasks-pending"><?=$overall['tasks_pending']?></h1>
                        </div>
                        <div class="col-8">
                            <h6>Number of tasks pending</h6>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card text-dark bg-light mb-3" style="max-width: 18rem;">
                <div class="card-body">
                    <div class="row">
                        <div class="col-4">
                            <h1 id="tasks-completed"><?=$overall['tasks_completed']?></h1>
                        </div>
                        <div class="col-8">
                            <h6>Number of tasks completed so far</h6>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card text-dark bg-light mb-3" style="max-width: 18rem;">
                <div class="card-body">
                    <div class="row">
                        <div class="col-4">
                            <h1 id="total-hrs"><?=$overall['total_worked_hrs']?></h1>
                        </div>
                        <div class="col-8">
                            <h6>Number of hours worked so far</h6>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card text-dark bg-light mb-3" style="max-width: 18rem;">
                <div class="card-body">
                    <div class="row">
                        <div class="col-4">
                            <h1 id="deadline"><?=$overall['deadline_not_met']?></h1>
                        </div>
                        <div class="col-8">
                            <h6>Number of tasks where deadline not met</h6>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<section>
    <div class="container" style="margin-top: 20px;margin-bottom: 20px;">
        <h2 style="padding: 10px 0">Manage Tasks</h2><table id="example" class="table table-striped table-bordered" cellspacing="0" width="100%">
            <thead>
            <tr>
                <th>Id</th>
                <th>Task Name</th>
                <th>Category</th>
                <th>Deadline</th>
                <th>Task Status</th>
                <th>Report</th>
                <th>Date Time</th>
                <th>Options</th>
            </tr>
            </thead>
            <tbody>
            <?if($tasks):?>
                <?while ($row = mysqli_fetch_assoc($tasks)):?>
                    <tr>
                        <td><?=$row['id']?></td>
                        <td><?=$row['task_name']?></td>
                        <td><?=$row['category']?></td>
                        <td><?=date("d-m-y h:i a",strtotime($row['date_time']." +".$row['estimated_time']." hour"))?></td>
                        <td>
                            <select id="taskstatus-<?=$row['id']?>" name="task_status" onchange="ChangeStatus(this,<?=$row['id']?>)">
                                <option value="todo">todo</option>
                                <option value="in-progress">In Progress</option>
                                <option value="testing">Testing</option>
                                <option value="completed">completed</option>
                            </select>
                            <script>$("#taskstatus-<?=$row['id']?>").val('<?=$row['task_status']?>')</script>
                        </td>
                        <td><?=(is_null($row['report']))?"-":$row['report']?></td>
                        <td><?=date("d-m-y h:i a",strtotime($row['date_time']))?></td>
                        <td><a class="table-links" href="add-reports.php?id=<?=$row['id']?>">add reports</a></td>
                    </tr>
                <?endwhile;?>
            <?endif;?>
            </tbody>
        </table>
    </div>
</section>
<script src="assets/bootstrap/js/bootstrap.min.js"></script>
<script>
    function ChangeStatus(e,id) {
        $.post("ajax-change-status.php",{id:id,value:$(e).val()},function (data,success) {
            data = jQuery.parseJSON(data);
            if(data.status === "success"){
                $("#tasks-completed").text(data.tasks_completed);
                $("#tasks-pending").text(data.tasks_pending);
                $("#deadline").text(data.deadline);
                $("#total-hrs").text(data.total_hrs);
                alert("task status updated Successfully");
            }
            else{
                alert(data.message);
            }
        });
    }
</script>
</body>
</html>

