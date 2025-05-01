
<?php

include("../classes/login-class.php");
class LoginController extends Login {

    private $username;
    private $password;

    public function __construct($username,$password)
    {
        $this->username = $username;
        $this->password = $password;
    }


    public function logUser(){

        if ($this->invalidInput()) {
            header("location: ../index.php?error=invalidUsernameFormat");
            exit();
        }

        $result = $this->checkUser($this->username);
        if($result["condition"]){
            $hashedPassword= $result["row"][0]["password"];
            if(password_verify($this->password,$hashedPassword)){
                $_SESSION["username"] = $this->username;
                $_SESSION["role"] = $result["row"][0]["role"];
                $_SESSION["requested"] = $result["row"][0]["requested"];
                $_SESSION["annual_balance"] =$result["row"][0]["annual_balance"];
                $_SESSION['department'] = $result["row"][0]["department"];
                header("location: ../home.php");
                exit();

            }

            else{
                header("location: ../index.php?error2=wrongPassword");
                exit();
            }
        }

        else{
            header("location: ../index.php?error=usernameNotFound");
                exit(); 
        }
  
       
    }


    private function invalidInput(){
        $results = false;
        if(!preg_match("/^[a-zA-Z0-9_@]+$/",$this->username)){
            $results = true;
        }
        return $results;
    }



}