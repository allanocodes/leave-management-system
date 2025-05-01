<?php

session_start();

if(isset($_POST['login'])){
    $username = $_POST['username'];
    $password = $_POST['password'];

    include("../classes/Database.php");
    include("../classes/login-controller.class.php");

    

    $login = new LoginController($username,$password);
    $login->logUser();



}