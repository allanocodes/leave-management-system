
<?php



class Departments extends Dbh{

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
    
            return  true;
            
        }
        return false;
        
        }


    protected function getDepartmentById($id) {
        $query = "SELECT * FROM departments WHERE id = ?";
        $stmt = $this->connect()->prepare($query);
        $stmt->execute([$id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }


    protected function checkEmployeeExists($username) {
        $query = "SELECT * FROM employees WHERE username = ?";
        $stmt = $this->connect()->prepare($query);
        $stmt->execute([$username]);
        return $stmt->fetch(PDO::FETCH_ASSOC) !== false;
    }

    protected function insertOrUpdateDepartment($department_name, $department_manager, $id = null) {
        
        if (empty($department_name) || empty($department_manager)) {
            throw new Exception("Department name and manager are required.");
        }
        if ($id !== null && (!is_numeric($id) || $id <= 0)) {
            throw new Exception("Invalid department ID.");
        }
        // if (!$this->checkEmployeeExists($department_manager)) {
        //     throw new Exception("Department manager username does not exist in employees.");
        // }

        
        $row = $this->getDepartmentById($id);

        if ($row !== false) {
            
            $query = "UPDATE departments SET department_name = ?, department_manager = ? WHERE id = ?";
            $stmt = $this->connect()->prepare($query);

            if (!$stmt) {
                throw new Exception("Failed to prepare update statement.");
            }

            if (!$stmt->execute([$department_name, $department_manager, $id])) {
                throw new Exception("Failed to execute update statement.");
            }

            return [
                "condition" => true,
                "function" => "update"
            ];
        } else {
        
            $conn = $this->connect();
            try {
                $conn->beginTransaction();

                $dep_manager = $department_manager;

            
                $query = "INSERT INTO departments (department_name, department_manager) VALUES (?, ?)";
                $stmt = $conn->prepare($query);

                if (!$stmt) {
                    throw new Exception("Failed to prepare insert statement.");
                }

                if (!$stmt->execute([$department_name, $department_manager])) {
                    throw new Exception("Failed to execute insert statement.");
                }


                if($this->checkUser($dep_manager)){
                    $this->updateRole($dep_manager,$conn);



            }

                $conn->commit();
                return [
                    "condition" => true,
                    "function" => "insert"
                ];
            } catch (Exception $e) {
                $conn->rollBack();
                throw $e;
            }
        }
    }

    protected function updateRole($department_manager,$conn){
                     
        $role = 'manager'; 
        $query2 = "UPDATE employees SET role = ? WHERE username = ?";
        $stmt2 = $conn->prepare($query2);

        if (!$stmt2) {
            throw new Exception("Failed to prepare employee update statement.");
        }

        if (!$stmt2->execute([$role, $department_manager])) {
            throw new Exception("Failed to execute employee update statement.");

        }
        $rowsAffected = $stmt2->rowCount();
        if ($rowsAffected === 0) {
            error_log("No rows updated for username: $department_manager");
            throw new Exception("No employee found with username: $department_manager");
        }
        return true;

    }

    // protected function insertOrUpdateDepartment($department_name, $department_manager, $id) {
    
    //     $row = $this->getDepartmentById($id);
    
    //     if (count($row) > 0) {
            
    //         $query = "UPDATE departments SET department_name = ?, department_manager = ? WHERE id = ?";
    //         $stmt = $this->connect()->prepare($query);
    
    //         if (!$stmt) {
    //             header("location: ../home.php?page=departments&error=statementFailed");
    //             exit();
    //         }
    
    //         if (!$stmt->execute([$department_name, $department_manager, $id])) {
    //             header("location: ../home.php?page=departments&error=executionFailed");
    //             exit();
    //         }
    
    //         return [
    //             "condition" => true,
    //             "function" => "update"
    //         ];
    //     } else {
    //         // If department doesn't exist, perform an INSERT
    //         $query = "INSERT INTO departments(id,department_name, department_manager) VALUES (?, ?,?)";
    //         $stmt = $this->connect()->prepare($query);

            
    
    //         if (!$stmt) {
    //             header("location: ../home.php?page=departments&error=statementFailed");
    //             exit();
    //         }
    
    //         if (!$stmt->execute([$id,$department_name, $department_manager])) {
    //             header("location: ../home.php?page=departments&error=executionFailed");
    //             exit();
    //         }

    //         $query2 = "update employees set role ='manager' where username = ?";

    //          $stmt2 = $this->connect()->prepare($query2);


            
    //          if (!$stmt2) {
    //             header("location: ../home.php?page=departments&error=statementFailed");
    //             exit();
    //         }
    
    //         if (!$stmt2->execute([$department_manager])) {
    //             header("location: ../home.php?page=departments&error=executionFailed");
    //             exit();
    //         }


    
    //         return [
    //             "condition" => true,
    //             "function" => "insert"
    //         ];
    //     }
    // }
    


    // protected function getDepartmentById($department_id) {
    //     $query = "SELECT * FROM departments WHERE id = ?";
        
    //     $stmt = $this->connect()->prepare($query);
    
    //     if (!$stmt) {
    //         header("location: ../home.php?page=departments&error=statementFailed");
    //         exit();
    //     }
    
    //     if (!$stmt->execute([$department_id])) {
    //         header("location: ../home.php?page=departments&error=executionFailed");
    //         exit();
    //     }
       
          
    //         $department = $stmt->fetch(PDO::FETCH_ASSOC);

    //         if($department){
    //             return $department;
    //         }

    //         else{
    //             return [];
    //         }
           
        
       
    // }

    protected function getAllDepartments() {
        $query = "SELECT * FROM departments";
    
        $stmt = $this->connect()->prepare($query);
    
        if (!$stmt) {
            header("location: ./home.php?page=departments&error=statementFailed");
            exit();
        }
    
        if (!$stmt->execute()) {
            header("location: ./home.php?page=departments&error=executionFailed");
            exit();
        }
    
        $departments = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $departments;
    }
    
    
    
}




?>