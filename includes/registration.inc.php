
<?php

if(isset($_POST['submitform'])){

    $first_name = $_POST['fname'];
    $middle_name = $_POST['mname'];
    $sir_name = $_POST['sname'];
    $username = $_POST['username'];
    $password = $_POST['password'];
    $repeatPassword = $_POST['confirmPassword'];
    $department = $_POST['department'];
    $email =  $_POST['email'];
    $gender =  $_POST['gender'];


    include("../classes/Database.php");
    include("../classes/registration-controller.class.php");

    $regContr = new RegistrationContr($first_name,$middle_name,$sir_name,$username,
    $password,$repeatPassword,$department,$email,$gender);

    $regContr->logUserIn();


}





?>