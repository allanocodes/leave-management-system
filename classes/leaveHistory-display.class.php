
<?php   


class HistoryDisplay extends LeaveHistory{


    private $username;

    public function __construct($username)
    {
       $this->username = $username;
    }

public function showRequests(){
return $this->getAllHistory($this->username);
}


public function displaystatus(){
return $this->getStatus($this->username);
}




}



