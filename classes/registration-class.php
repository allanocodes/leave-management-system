<?php


class registration extends Dbh{

protected function insertUser($first_name,$middle_name,$sir_name,$username,
$password,$department,$email,$gender){

    $query = "insert into employees(first_name,middle_name,sir_name,username,
 password,department,role,email,gender,annual_balance,requested)
SELECT ?, ?, ?, ?, ?, ?, ?, ?, ?, t.leave_days, ?
 FROM leave_type t
WHERE t.leave_name = 'Annual Leave';"
 ;
 $stmt = $this->connect()->prepare($query);
 if (!$stmt) {
    header("location: ../registration.php?error=statementFailed");
    exit();
}
$hashedPassword = password_hash($password,PASSWORD_DEFAULT);

$requested = "no";


if(!$stmt->execute([$first_name,$middle_name,$sir_name,$username,$hashedPassword,$department,"user",$email,$gender,$requested])){
header("location: ../registration.php?error=executionFailed");
exit();
}

return true;
}

protected function checkUser($username){

$query = "select  * from employees where username = ?";
$stmt = $this->connect()->prepare($query);

if (!$stmt) {
    header("location: ../registration.php?error=statementFailed");
    exit();
}

if(!$stmt->execute([$username])){
header("location: ../registration.php?error=executionFailed");
exit();
}

$row = $stmt->fetchAll(PDO::FETCH_ASSOC);
if(count($row) > 0){
    return true;
}
return false;

}


protected function updatePasswordByEmail($email, $newPassword) {
    $hashedPassword = password_hash($newPassword, PASSWORD_DEFAULT);
    $query = "UPDATE employees SET password = ? WHERE email = ?";
    $stmt = $this->connect()->prepare($query);

    if (!$stmt) {
        header("location: ./newpassword.php?error=statementFailed");
        exit();
    }

    if (!$stmt->execute([$hashedPassword, $email])) {
        header("location: ./newpassword.php?error=executionFailed");
        exit();
    }

    
    if ($stmt->rowCount() > 0) {
        return true;
    }


    header("location: ./newpassword.php?error=emailNotFound");
    exit();
}




protected function checkEmail($email) {
    $query = "SELECT * FROM employees WHERE email = ?";
    $stmt = $this->connect()->prepare($query);

    if (!$stmt) {
        header("location: ./newpassword.php?error=statementFailed");
        exit();
    }

    if (!$stmt->execute([$email])) {
        header("location: ./newpassword.php?error=executionFailed");
        exit();
    }

    $row = $stmt->fetchAll(PDO::FETCH_ASSOC);
    if (count($row) > 0) {
        return true;
    }
    return false;
}
}