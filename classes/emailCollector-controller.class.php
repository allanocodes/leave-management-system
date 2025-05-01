<?php


class EmailCollectorCont extends registration{

    private $email;

public function __construct($email)
{
    $this->email = $email;
    
}
public function confirmUsername(){

    return $this->checkEmail($this->email);


    
}


public function updatePassword($password){

    return $this->updatePasswordByEmail($this->email,$password);
}
}


?>