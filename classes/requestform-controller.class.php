<?php


class RequestformContr extends RequestForm{

    private $start_date ;
    private  $end_date ;
    private $leave_type;
    private $phone ;
    private $description ;
    private $username;

    private $created_at;
    private $leave_balance;
    private $department;
    private $leave_types=[];

    public function __construct( $start_date ,$end_date , $leave_type,$phone,$description, $username,$created_at,$leave_balance,$department,$leave_types)
    {

        $this->username = $username;
        $this->start_date =$start_date;
        $this->end_date = $end_date;
        $this->leave_type = $leave_type;
        $this->phone = $phone;
        $this->description = $description;
       
        $this->leave_balance = $leave_balance;
        $this->created_at = $created_at;
        $this->department= $department;
        $this->leave_types = $leave_types;
        
    }
    public function leaveHelper() {
        $leaveInputs = [
            'start_date'   => $this->start_date,
            'end_date'     => $this->end_date,
            'leave_type'   => $this->leave_type,
            'phone'        => $this->phone,
            'description'  => $this->description,
            'username'     => $this->username,
            'leave_balance' => $this->leave_balance,
            'department' => $this->department
        ];
    
        return $leaveInputs;
    }

    public function submitrequest(){
        if($this->emptyInputs()['condition']){
            $error = implode(",",$this->emptyInputs()['errorInputs']);
            header("location: ./home.php?page=request-leave&error=emptyInput:{$error}");
            exit();
        }

        if($this->invalidInput()['condition']){
            $error = implode(",",$this->invalidInput()['errorInputs']);
            header("location: ./home.php?page=request-leave&error=invalidInput:{$error}");
            exit();
        }

        if($this->checkRequest($this->username)){
            header("location: ./home.php?page=request-leave&error=user[{$this->username}]exists");
            exit(); 
        }
        $result = $this->handleDates();
        if(!empty($result['error'])){
            $_SESSION['error101'] = $result['error'];
            header("location: ./home.php?page=request-leave");
            exit();

        }


      $condition=  $this->insertRequest($this->start_date ,$this->end_date , $this->leave_type,$this->phone,
        $this->description, $this->username,$result['leave_days'],$this->created_at,$this->department);
        $this->updateRequestedStatus($this->username);

        if($condition){
            header("location: ./home.php?page=request-leave&message=insertSuccessful");
            exit(); 
        }
  
        

    }

    function confirmLeaveDays($days, $leavetype,$leave_balance) {
        $error = "";
        
        


        foreach ($this->leave_types as $leave) {
            
            if (isset($leave['leave_name']) && $leave['leave_name'] === $leavetype) {
             
                if($leave['leave_name'] == "Annual Leave"){
                    if ($days > $leave_balance) {
                        $error = "{$leave['leave_name']} leave balance is {$leave_balance}";
                        break;  
                    }

                }

                if ($days > $leave['leave_days']) {
                    $error = "{$leave['leave_name']} leave maximum is {$leave['leave_days']}";
                    break;  
                }
  
            }
        }
    
        return $error; 
    }

    private function handleDates(){
        $start_date = new DateTime($this->start_date) ;
        $end_date = new DateTime($this->end_date);


        $teststart = clone $start_date;
        $testend = clone $end_date;
    
        $testend->modify("+1 day");
        $interval = new DatePeriod($teststart,new DateInterval("P1D"),$end_date);
    
        $working_days = 0;
    
        foreach($interval as $date){
            $day_of_the_week = $date->format("N");
    
            if($day_of_the_week < 6){
                $working_days ++;
            }
        
        }
    
    
       return [ "error"=>$this->confirmLeaveDays($working_days,$this->leave_type,$this->leave_balance),
                "leave_days"=>$working_days ];

    }

    public function emptyInputs(){
        $isempty = false;
         $inputs = $this->leaveHelper();
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
          $inputs = $this->leaveHelper();
          $errorInputs= [];
          foreach($inputs as $key => $value){
           if( $key != "email"){
            if (!preg_match("/^[a-zA-Z0-9_@+\- ]+$/", $value)) {
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



}



?>