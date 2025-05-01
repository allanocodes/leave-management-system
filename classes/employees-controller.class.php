
<?php 


class EmployeesContr extends Employees{


    public function showEmp(){
        return $this->getAllEmployees();
    }

    public function showOnLeave(){
        return $this->getOnLeaveEmployees();
    }

    public function showAllEmp(){
        return $this->getAllEmployeesHr();
    }

    public function showAllOnLeave(){
        return $this->getOnLeaveEmployeesHr();
    }
} 




?>