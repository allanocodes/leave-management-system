
<?php


class LeaveHistory extends Dbh{

    public function handleHistoryTable() {
        try {
            $conn = $this->connect();
    
            // Begin SQL transaction
            $conn->beginTransaction();
    
            // 1. Move historical leave requests to history
            $query1 = "
                INSERT INTO leave_requests_history (start_date, end_date, leave_type, phone, description, username, leave_days, created_at, status, department)
                SELECT start_date, end_date, leave_type, phone, description, username, leave_days, created_at, status, department
                FROM leave_requests
                WHERE start_date <= CURRENT_DATE AND status IN ('declined', 'approved')
            ";
            $stmt1 = $conn->prepare($query1);
            $stmt1->execute();
    
            // 2. Update employee on_leave status to 'yes' if currently on approved leave
            $query2 = "UPDATE employees e
            JOIN leave_requests r ON e.username = r.username
            SET 
              e.on_leave = 'yes',
              e.annual_balance = e.annual_balance - IFNULL(r.leave_days, 0)
            WHERE 
              r.status = 'approved'
              AND r.start_date <= CURRENT_DATE;
            ";
            $stmt2 = $conn->prepare($query2);
            $stmt2->execute();


         
            
    
            // 3. Delete outdated leave requests from main table
            $query3 = "
                DELETE FROM leave_requests
                WHERE start_date <= CURRENT_DATE AND status IN ('approved', 'declined')
            ";
            $stmt3 = $conn->prepare($query3);
            $stmt3->execute();
    
            // Commit all changes
            $conn->commit();
    
            // Optional session message
            $_SESSION['message'] = "Leave history successfully processed.";
    
        } catch (PDOException $e) {
            // Rollback in case of error
            if ($conn->inTransaction()) {
                $conn->rollBack();
            }
    
            $_SESSION['error'] = "Transaction failed: " . $e->getMessage();
            header("Location: ./home.php?error=DatabaseError");
            exit();
        }
    
      return true;
    }


    public function getAllHistory($username){
        $query = "SELECT * FROM leave_requests_history where username = ?";
        $stmt = $this->connect()->prepare($query);

        if (!$stmt) {
            header("location: ../home.php?page=leave_history&error=updateStatementFailed");
            exit();
        }
    
        if (!$stmt->execute([$username])) {
            header("location: ../home.php?page=leave_history&error=updateExecutionFailed");
            exit();
        }

        $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);

        return $rows?:[];
    }


    public function getStatus($username){
        $query = "SELECT * FROM leave_requests where username = ?";
        $stmt = $this->connect()->prepare($query);

        if (!$stmt) {
            header("location: ../home.php?page=leave_status&error=updateStatementFailed");
            exit();
        }
    
        if (!$stmt->execute([$username])) {
            header("location: ../home.php?page=leave_status&error=updateExecutionFailed");
            exit();
        }

        $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);

        return $rows?:[];
    }



}



?>

