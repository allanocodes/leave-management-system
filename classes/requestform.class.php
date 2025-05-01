<?php



class RequestForm extends Dbh{

protected function checkRequest($username){
$query = "select  * from leave_requests where username = ?";
$stmt = $this->connect()->prepare($query);

if (!$stmt) {
    header("location: ./home.php?page=request-leave&error=statementFailed");
    exit();
}

if(!$stmt->execute([$username])){
header("location: ./home.php?page=request-leave&error=executionFailed");
exit();
}

$row = $stmt->fetchAll(PDO::FETCH_ASSOC);
if(count($row) > 0){
    return true;
}
return false;
}

protected function insertRequest($start_date ,$end_date , $leave_type,
$phone,$description, $username,$leave_days,$created_at,$department){


    $query = "INSERT INTO leave_requests (
    start_date,
    end_date,
    leave_type,
    phone,
    description,
    username,
    leave_days,
    created_at,
    status,
    department
) VALUES (?, ?, ?, ?, ?, ?, ?, ?,?,?);";

$status = "pending";

$stmt = $this->connect()->prepare($query);
 if (!$stmt) {
    header("location: ./home.php?page=request-leave&error=statementFailed");
    exit();
}

if(!$stmt->execute([$start_date ,$end_date , $leave_type,
$phone,$description, $username,$leave_days,$created_at,$status,$department])){
    header("location: ./home.php?page=request-leave&error=executionFailed");
    exit();
    }
    
    return true;
    

}

protected function updateRequestedStatus($username) {
    $updateQuery = "UPDATE employees SET requested = 'yes' WHERE username = ?";
    $updateStmt = $this->connect()->prepare($updateQuery);

    if (!$updateStmt) {
        header("location: ../home.php?page=request-leave&error=updateStatementFailed");
        exit();
    }

    if (!$updateStmt->execute([$username])) {
        header("location: ../home.php?page=request-leave&error=updateExecutionFailed");
        exit();
    }

    return true;
}



}