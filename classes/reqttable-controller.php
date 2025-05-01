
<?php


class ReqTableContr extends Reqtable{

    public   function getRequests(){

        return $this->getRequest();
    }
    public function getAllReqHr(){
        return $this->getRequestHr();
    }

}
?>