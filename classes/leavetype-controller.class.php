
<?php 

class LeavetypeContr extends Leavetype{

    private  $leave_id;
    private $leave_name;
    private $leave_days;


    public function __construct($leave_id,$leave_name,$leave_days)
    {
        $this->leave_id =$leave_id;
        $this->leave_name = $leave_name;
        $this->leave_days = $leave_days;

        
    }

    public function submitLeavetype(){

        $emptyCheck = $this->emptyInputs();
        if($emptyCheck['condition']){
            $error = implode(",", $emptyCheck['errorInputs']);
            header("location: ../home.php?page=leave_type&error=emptyinput:{$error}");
            exit();
        }
        
        $invalidCheck = $this->invalidInput();
        if($invalidCheck['condition']){
            $error = implode(",", $invalidCheck['errorInputs']);
            header("location: ../home.php?page=leave_type&error=invalidinput:{$error}");
            exit();
        }

        $result = $this->insertOrUpdateLeaveType($this->leave_name,$this->leave_days,$this->leave_id);

        if($result["function"] == "update" ){
            header("location: ../home.php?page=leave_type&message=updateSuccessful");
            exit();
        }

        if($result["function"] == "insert" ){
            header("location: ../home.php?page=leave_type&message=insertSuccessful");
            exit();
        }


        


    }



    public function Helper(){
        return [

            "leave_id" => $this->leave_id,
            "leave_name" => $this->leave_name,
            "leave_days"=> $this->leave_days
        ];
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
              if(!preg_match("/^[a-zA-Z0-9_@ ]+$/",$value)){
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