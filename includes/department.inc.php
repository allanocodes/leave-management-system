<?php

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    
    $department_id = isset($_POST['department_id']) ? trim($_POST['department_id']) : null;
    $department_name = isset($_POST['department_name']) ? trim($_POST['department_name']) : null;
    $manager = isset($_POST['manager']) ? trim($_POST['manager']) : null;



  include("../classes/Database.php");
  include("../classes/department.class.php");
  include("../classes/department-controller.class.php");


  $saveContr = new  DepController($department_name,$manager,$department_id);
  $saveContr->submitDep();
 


   
}
?>