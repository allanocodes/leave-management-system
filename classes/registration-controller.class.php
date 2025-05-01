<?php

include("../classes/registration-class.php");

class RegistrationContr extends registration{

    
 private  $first_name ;
 private   $middle_name ;
 private  $sir_name ;
 private  $username ;
 private   $password ;
 private   $repeatPassword ;
 private   $department ;
 private   $email ;
 private  $gender;


 public function __construct($first_name,$middle_name,$sir_name,$username,
 $password,$repeatPassword,$department,$email,$gender)
 {
    $this->first_name = $first_name;
    $this->middle_name = $middle_name;
    $this->sir_name = $sir_name;
    $this->username = $username;
    $this->password = $password;
    $this->repeatPassword = $repeatPassword;
    $this->department = $department;
  
    $this->email = $email;
    $this->gender = $gender;

    
 }


 public function logUserIn(){
        if($this->emptyInputs()['condition']){
            $error = implode(",",$this->emptyInputs()['errorInputs']);
            header("location: ../registration.php?error=emptyinput:{$error}");
            exit();
        }

        if($this->invalidInput()['condition']){
            $error = implode(",",$this->invalidInput()['errorInputs']);
            header("location: ../registration.php?error=invalidinput:{$error}");
            exit();
        }
        if($this->invalidEmail()){
            header("location: ../registration.php?error=invalidEmail");
            exit();
        }
        if($this->checkUser($this->username)){
            header("location: ../registration.php?error=user[{$this->username}]exists");
            exit(); 
        }
     
     $condition = $this->insertUser($this->first_name,$this->middle_name,$this->sir_name,$this->username,
        $this->password,$this->department,$this->email,$this->gender);

        if($condition){

            header("location: ../index.php?message=RegistrationSuccessful");
            exit();
        }

 }




 public function Helper(){

    $reginputs = [
        'first_name'=> $this->first_name,
        'middle_name'=>$this->middle_name,
        'sir_name' => $this->sir_name,
        'username'=>$this->username,
        'password'=>$this->password,
        'repeatPassword'=>$this->repeatPassword,
        'department'=> $this->department,
        'email'=>$this->email,
        "gender"=> $this->gender
    ];
    return $reginputs;
 }


public function emptyInputs(){
$isempty = false;
 $inputs = $this->Helper();
 $errorInputs= [];
  foreach($inputs as $key=> $value){
    if(empty($value)){
        $isempty = true;
        $errorInputs[] = $key;
    }
  }

  $result = [
   'condition'=> $isempty,
   'errorInputs'=> $errorInputs
  ];

  return  $result;

 }
 public function invalidInput(){
  $condition = false;  
  $inputs = $this->Helper();
  $errorInputs= [];
  foreach($inputs as $key => $value){
   if( $key != "email"){
        if(!preg_match("/^[a-zA-Z0-9_@]+$/",$value)){
          $errorInputs[] = $key;
          $condition = true;

        }

   }
  }

  return [
    'condition' => $condition,
    'errorInputs'=> $errorInputs

  ];

 }


 private function invalidEmail(){
    $result = false;
    if(!filter_var($this->email,FILTER_VALIDATE_EMAIL)){
        $result = true;
    }

    return $result;
 }


}