<?php

class Dbh{


    public function connect(){
        $host = "localhost";
        $username = "root";
        $password = "";
        $dbname = "Employee";

       
        try{
         $pdo = new Pdo("mysql:host=".$host.";dbname=".$dbname,$username,$password);
         $pdo->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);
         return $pdo;
        } catch(PDOException $e){
            print("error". $e->getMessage());
            return null;
        }

        
    }

    
}