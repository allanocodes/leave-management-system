<?php

class DepController extends Departments{

    private  $departmentName;
    private $departmentManager;
    private $id;


    public function __construct($departmentName,$departmentManager,$id)
    {
        $this->departmentName =$departmentName;
        $this->departmentManager = $departmentManager;
        $this->id = $id;

        
    }

    public function submitDep(){

        $emptyCheck = $this->emptyInputs();
        if($emptyCheck['condition']){
            $error = implode(",", $emptyCheck['errorInputs']);
            header("location: ../home.php?page=departments&error=emptyinput:{$error}");
            exit();
        }
        
        $invalidCheck = $this->invalidInput();
        if($invalidCheck['condition']){
            $error = implode(",", $invalidCheck['errorInputs']);
            header("location: ../home.php?page=departments&error=invalidinput:{$error}");
            exit();
        }

        $result = $this->insertOrUpdateDepartment($this->departmentName,$this->departmentManager,$this->id);

        if($result["function"] == "update" ){
            header("location: ../home.php?page=departments&message=updateSuccessful");
            exit();
        }

        if($result["function"] == "insert" ){
            header("location: ../home.php?page=departments&message=insertSuccessful");
            exit();
        }


        


    }



    public function Helper(){
        return [

            "department_name" => $this->departmentName,
            "department_manager" => $this->departmentManager,
            "id"=> $this->id
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

}