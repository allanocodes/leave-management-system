
<?php

class ActionContr extends Action{
private $username;
private $status;

public function __construct($username,$status)
{
    $this->username =$username;
    $this->status= $status;
      
}

public function helper(){
    return [
      "username"  => $this->username,
      "status"  => $this->status
    ];
}

public function submitChange(){

    if($this->isempty()['condition']){
        $error = implode(",",$this->isempty()['errorInputs']);
        header("location: ../home.php?page=leave_request&error=emptyInput:{$error}");
        exit();
    }
    if($this->updateLeaveStatus($this->username,$this->status)){
        header("location:../home.php?page=leave_request&message=statusUpdated");
    }
    

}

public  function isempty(){
    $condition = false;
    $result = $this->helper();
    $errorInput = [];
foreach($result as $key=> $value){
if(empty($value)){
    $condition = true;
  $errorInput[] = $key;
}
   
}
return [
    "condition" => $condition,
     "errorInputs"=> $errorInput
];

}

}


?>