
<?php


class Login extends Dbh{

protected function checkUser($username){

    $query = "select  * from employees where username = ?";
    $stmt = $this->connect()->prepare($query);
    
    if (!$stmt) {
        header("location: ../index.php?error=statementFailed");
        exit();
    }
    
    if(!$stmt->execute([$username])){
    header("location: ../index.php?error=executionFailed");
    exit();
    }
    
    $row = $stmt->fetchAll(PDO::FETCH_ASSOC);
    if(count($row) > 0){

        return [
            "condition"=> true,
            "row"=> $row
        ];
    }
    return [
        "condition"=> false,
        "row" => []
    ];
    
    }

    
function insertEmployees() {
    $employees = [
        ['Alice', 'M.', 'Johnson', 'alicej1', 'HR', 'user', 'michaelk', 'alicej@example.com', 'female', 30, 'no'],
        ['Brian', 'T.', 'Smith', 'brians1', 'Finance', 'user', 'lauraw', 'brians@example.com', 'male', 30, 'no'],
        ['Cynthia', 'L.', 'Adams', 'cynthiaa11', 'IT', 'manager', null, 'cynthiaa@example.com', 'female', 30, 'no'],
        ['Daniel', 'R.', 'Lee', 'daniell', 'IT', 'user', 'cynthiaa', 'daniell@example.com', 'male', 30, 'no'],
        ['Emily', 'K.', 'Brown', 'emilyb1', 'Marketing', 'user', 'johnh', 'emilyb@example.com', 'female', 30, 'no'],
        ['Frank', 'S.', 'Davis', 'frankd1', 'Operations', 'user', 'sarahm', 'frankd@example.com', 'male', 30, 'no'],
        ['Grace', 'A.', 'Taylor', 'gracet1', 'Finance', 'manager', null, 'gracet@example.com', 'female', 30, 'no'],
        ['Henry', 'W.', 'Wilson', 'henryw1', 'Operations', 'user', 'gracet', 'henryw@example.com', 'male', 30, 'no'],
        ['Isabelle', 'N.', 'Clark', 'isabellec1', 'HR', 'user', 'alicej', 'isabellec@example.com', 'female', 30, 'no'],
        ['Jack', 'Q.', 'Evans', 'jacke1', 'Marketing', 'manager', null, 'jacke@example.com', 'male', 30, 'no']
    ];
    
    
    

    $sql = "INSERT INTO employees (
                first_name, middle_name, sir_name, username,
                password, department, role, manager,
                email, gender, annual_balance, requested
            ) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";

    $stmt = $this->connect()->prepare($sql);

    $defaultPassword = password_hash("1234", PASSWORD_BCRYPT);
    $defaultBalance = 20;
    $requested = "yes";

    foreach ($employees as $e) {
        $stmt->execute([
            $e[0], // first_name
            $e[1], // middle_name
            $e[2], // sir_name
            $e[3], // username
            $defaultPassword, // hashed password
            $e[4], // department
            $e[5], // role
            $e[6], // manager
            $e[7], // email
            $e[8], // gender
            $defaultBalance,
            $requested
        ]);
    }


}





}