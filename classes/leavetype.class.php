<?php

class Leavetype extends Dbh{
    protected function insertOrUpdateLeaveType($leave_name, $leave_days, $leave_id) {
        $row = $this->getLeaveTypeById($leave_id);
    
        if (!empty($row)) {
            
            $query = "UPDATE leave_type SET leave_name = ?, leave_days = ? WHERE leave_id = ?";
            $stmt = $this->connect()->prepare($query);
    
            if (!$stmt) {
                header("location: ../home.php?page=leave_type&error=statementFailed");
                exit();
            }
    
            if (!$stmt->execute([$leave_name, $leave_days, $leave_id])) {
                header("location: ../home.php?page=leave_type&error=executionFailed");
                exit();
            }
    
            return [
                "condition" => true,
                "function" => "update"
            ];
        } else {
            
            $query = "INSERT INTO leave_type (leave_id, leave_name, leave_days) VALUES (?, ?, ?)";
            $stmt = $this->connect()->prepare($query);
    
            if (!$stmt) {
                header("location: ../home.php?page=leave_type&error=statementFailed");
                exit();
            }
    
            if (!$stmt->execute([$leave_id, $leave_name, $leave_days])) {
                header("location: ../home.php?page=leave_type&error=executionFailed");
                exit();
            }
    
            return [
                "condition" => true,
                "function" => "insert"
            ];
        }
    }
    
    protected function getLeaveTypeById($leave_id) {
        $query = "SELECT * FROM leave_type WHERE leave_id = ?";
    
        $stmt = $this->connect()->prepare($query);
    
        if (!$stmt) {
            header("location: ../home.php?page=leave_type&error=statementFailed");
            exit();
        }
    
        if (!$stmt->execute([$leave_id])) {
            header("location: ../home.php?page=leave_type&error=executionFailed");
            exit();
        }
    
        $leave_type = $stmt->fetch(PDO::FETCH_ASSOC);
        return $leave_type ? $leave_type : [];
    }
    
    protected function getAllLeaveTypes() {
        $query = "SELECT * FROM leave_type";
    
        $stmt = $this->connect()->prepare($query);
    
        if (!$stmt) {
            header("location: ./home.php?page=leave_type&error=statementFailed");
            exit();
        }
    
        if (!$stmt->execute()) {
            header("location: ./home.php?page=leave_type&error=executionFailed");
            exit();
        }
    
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    
    
}