
<?php 

class Employees extends Dbh{


    protected function getAllEmployees() {
        $query = "SELECT * FROM employees";
        $stmt = $this->connect()->prepare($query);
    
        if (!$stmt) {
            header("location: ./home.php?page=department_employees&error=statementFailed");
            exit();
        }
    
        if (!$stmt->execute()) {
            header("location: ./home.php?page=department_employees&error=executionFailed");
            exit();
        }
    
        $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $rows;
    }

    protected function getOnLeaveEmployees() {
        $query = "SELECT * FROM employees WHERE on_leave = 'yes'";
        $stmt = $this->connect()->prepare($query);
    
        if (!$stmt) {
            header("location: ./home.php?page=on_leave&error=statementFailed");
            exit();
        }
    
        if (!$stmt->execute()) {
            header("location: ./home.php?page=on_leave&error=executionFailed");
            exit();
        }
    
        $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $rows;
    }

    protected function getAllEmployeesHr() {
        $query = "SELECT * FROM employees";
        $stmt = $this->connect()->prepare($query);
    
        if (!$stmt) {
            header("location: ./home.php?page=employees&error=statementFailed");
            exit();
        }
    
        if (!$stmt->execute()) {
            header("location: ./home.php?page=employees&error=executionFailed");
            exit();
        }
    
        $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $rows;
    }

    protected function getOnLeaveEmployeesHr() {
        $query = "SELECT * FROM employees WHERE on_leave = 'yes'";
        $stmt = $this->connect()->prepare($query);
    
        if (!$stmt) {
            header("location: ./home.php?page=On_leave&error=statementFailed");
            exit();
        }
    
        if (!$stmt->execute()) {
            header("location: ./home.php?page=On_leave&error=executionFailed");
            exit();
        }
    
        $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $rows;
    }
    
    

}


?>