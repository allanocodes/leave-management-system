
<?php 

class Reqtable extends Dbh{


    protected function getRequest(){

            $query = "SELECT * FROM leave_requests";
            $stmt = $this->connect()->prepare($query);
        
            if (!$stmt) {
                header("location: ./home.php?page=leave_request&error=statementFailed");
                exit();
            }
        
            if (!$stmt->execute()) {
                header("location: ./home.php?page=leave_request&error=executionFailed");
                exit();
            }
        
            $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
        
            return $rows; 
        
        
    }
    protected function getRequestHr(){

        $query = "SELECT * FROM leave_requests";
        $stmt = $this->connect()->prepare($query);
    
        if (!$stmt) {
            header("location: ./home.php?page=requests&error=statementFailed");
            exit();
        }
    
        if (!$stmt->execute()) {
            header("location: ./home.php?page=requests&error=executionFailed");
            exit();
        }
    
        $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
    
        return $rows; 
    
    
}


}


?>