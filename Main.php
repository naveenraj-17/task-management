<?php


class Main
{
    protected $mysqli;
    public function __construct()
    {
        include 'config/config.php';
        $this->mysqli =$mysqli;
        if(!isset($_SESSION['is_login'])){
            header("Location: login.php");
        }
    }

    public function get_employees($id = null){
        if(is_null($id)){
            $result = mysqli_query($this->mysqli,"SELECT * FROM employees order by id desc");
        }
        else{
            $result = mysqli_query($this->mysqli,"SELECT * FROM employees where id = '$id'");
        }
        return $result;
    }

    public function get_tasks($id = null){
        if(is_null($id)) $result = mysqli_query($this->mysqli,"SELECT t.*,e.name as employee_name FROM tasks as t left join employees as e on t.employee_id = e.id order by t.id desc");
        else $result = mysqli_query($this->mysqli,"SELECT t.*,e.name as employee_name FROM tasks as t left join employees as e on t.employee_id = e.id where t.id = '$id'");
        return $result;
    }

    public function get_tasks_filter($status,$category){
        $query = "SELECT t.*,e.name as employee_name FROM tasks as t left join employees as e on t.employee_id = e.id";
        if(!empty($status) and !empty($category)) $query .= " where t.task_status = '$status' and t.category = '$category'";
        else{
            if(!empty($status)) $query .= " where t.task_status = '$status'";
            else $query .= " where t.category = '$category'";
        }
        $result = mysqli_query($this->mysqli,$query);
        return $result;
    }

    public function add_employees($data){
        $check = mysqli_num_rows(mysqli_query($this->mysqli,"SELECT * FROM employees WHERE email = '$data[email]'"));
        if(!$check){
            $date = date('Y-m-d H:i:s');
            $result = mysqli_query($this->mysqli,"INSERT into employees(name,email,password,date_time) values ('$data[name]','$data[email]','$data[password]','$date')");
            if($result) $return['status'] = "success";
            else $return = ['status'=>'error','message'=>mysqli_error($this->mysqli)];
        }
        else{
            $return = [
                'status' => 'error',
                'message' => "Email already exist"
            ];
        }
        return $return;
    }

    public function add_tasks($data){
        $date = date('Y-m-d H:i:s');
        switch ($data['task_status']){
            case "completed":{
                $completed = 0;
                break;
            }
            default:{
                $completed = null;
                break;
            }
        }
        $result = mysqli_query($this->mysqli,"INSERT into tasks(task_name,employee_id,estimated_time,category,completed_time,task_status,date_time) values ('$data[task_name]','$data[employee_id]','$data[estimated_time]','$data[category]','$completed','$data[task_status]','$date')");
        if($result) $return['status'] = "success";
        else $return = ['status'=>'error','message'=>mysqli_error($this->mysqli)];
        return $return;
    }

    public function edit_employees($data,$id){
        $query = "UPDATE employees SET name = '$data[name]',email = '$data[email]', password = '$data[password]' where id = '$id'";
        $result = mysqli_query($this->mysqli,$query);
        if($result) $return['status'] = "success";
        else $return = ['status'=>'error','message'=>mysqli_error($this->mysqli)];
        return $return;
    }

    public function edit_tasks($data,$id){
        $date = date('Y-m-d H:i:s');
        switch ($data['task_status']){
            case "completed":{
                $completed = 0;
                break;
            }
            default:{
                $completed = null;
                break;
            }
        }
        $query = "UPDATE tasks SET task_name = '$data[task_name]',employee_id = '$data[employee_id]', estimated_time = '$data[estimated_time]',category = '$data[category]',completed_time = '$completed',task_status = '$data[task_status]',date_time = '$date' where id = '$id'";
        $result = mysqli_query($this->mysqli,$query);
        if($result) $return['status'] = "success";
        else $return = ['status'=>'error','message'=>mysqli_error($this->mysqli)];
        return $return;
    }

    public function delete_row($table,$id){
        if($table == "employees"){
            $result1 = mysqli_query($this->mysqli,"Delete from tasks where employee_id = '$id'");
            $result = mysqli_query($this->mysqli,"Delete from employees where id = '$id'");
        }
        elseif ($table == "tasks"){
            $result = mysqli_query($this->mysqli,"Delete from tasks where id = '$id'");
        }
        if($result) $data = ['status' => 'success'];
        else $data = ['status' => 'error','message' => mysqli_error($this->mysqli)];
        return json_encode($data);
    }

}