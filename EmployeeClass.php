<?php

require_once "Main.php";

class EmployeeClass extends Main
{
    public function __construct()
    {
        include 'config/config.php';
        $this->mysqli = $mysqli;
        if(!isset($_SESSION['employee_id'])){
            header("Location: login.php");
        }
    }

    public function get_employee_tasks(){
        $id = $_SESSION['employee_id'];
        $tasks = mysqli_query($this->mysqli,"Select * from tasks where employee_id = '$id' order by id desc");
        return $tasks;
    }

    public function add_reports($id,$report){
        $query = "update tasks set report = '$report' where id = '$id'";
        $result = mysqli_query($this->mysqli,$query);
        if($result) $data['status'] = "success";
        else $data = ['status'=>'error','message'=>mysqli_error($this->mysqli)];
        return $data;
    }

    public function get_reports(){
        $id = $_SESSION['employee_id'];
        $query = "Select 
                  sum(case when task_status != 'completed' then 1 else 0 end) as tasks_pending,
                  sum(case when task_status = 'completed' then 1 else 0 end) as tasks_completed,
                  sum(completed_time) as total_worked_hrs,
                  sum(case when completed_time > estimated_time then 1 else 0 end) as deadline_not_met 
                  from tasks where employee_id = '$id'";
        $report = mysqli_query($this->mysqli,$query);
        return $report;
    }

    public function change_status($value,$id){
        if($value == 'completed'){
            $task = mysqli_fetch_assoc($this->get_tasks($id));
            $start = strtotime($task['date_time']);
            $end = strtotime("now");

            $completed = ($end - $start)/60/60;



        }
        else{
            $completed = 0;
        }
        $query = "update tasks set task_status = '$value',completed_time = '$completed' where id = '$id'";
        $result = mysqli_query($this->mysqli,$query);
        if($result){
            $report = mysqli_fetch_assoc($this->get_reports());
            $data = [
                'status' => 'success',
                'tasks_completed' => $report['tasks_completed'],
                'tasks_pending' => $report['tasks_pending'],
                'total_hrs' => $report['total_worked_hrs'],
                'deadline' => $report['deadline_not_met']
            ];
        }
        else $data = ['status'=>'error','message'=>mysqli_error($this->mysqli)];
        return json_encode($data);
    }
}