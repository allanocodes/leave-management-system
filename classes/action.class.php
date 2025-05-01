
<?php 


class Action extends Dbh{

    public function updateLeaveStatus($username, $status) {
        $query = "UPDATE leave_requests SET status = ? WHERE username = ?";
    
        $stmt = $this->connect()->prepare($query);
    
        if (!$stmt) {
            header("location: ./home.php?page=leave_request&error=statementFailed");
            exit();
        }
    
        if (!$stmt->execute([$status, $username])) {
            header("location: ./home.php?page=leave_request&error=executionFailed");
            exit();
        }
    
        return true; 
    }
    

}