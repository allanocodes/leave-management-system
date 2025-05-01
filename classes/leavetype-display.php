<?php

class LeavetypeDisplay extends Leavetype{

    public function showLeaveType(){
       return $this->getAllLeaveTypes();
    }


}