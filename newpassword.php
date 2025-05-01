
<?php 

require_once "./classes/Database.php";
require_once "./classes/registration-class.php";
require_once "./classes/emailCollector-controller.class.php";
$message = $_GET['message'] ?? null;
$error = $_GET['error'] ?? null;

$email = $_GET['email'] ?? null;



if( isset($_POST['submit'])){

    $email = $_POST['email'] ?? null;
 $password = $_POST['password'];

 $contr = new EmailCollectorCont($email);

 $success = $contr->updatePassword($password);

 if($success){

    header("location: ./newpassword.php?message=updateSuccesful");
    exit();
 }



}

?>





<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>


    <link href="https://fonts.googleapis.com/css2?family=Nunito&display=swap" rel="stylesheet">

   <style>

    :root{
        --bodyBackground: whitesmoke;
       --formBackground: #fff;
       --buttonColor: blue;
    }

    *{
        padding: 0;
        margin: 0;
        box-sizing: border-box;
    }

    body{
        background-color: #2d67f7 ;
        width: 100vw;
        height: 100vh;
        font-family: 'Nunito', sans-serif;
    }
    .container{
        width: 450px;
       min-height: 200px;
        margin: 50px auto ;
        
    }

    form{
        width: 90%;
        display: flex;
        flex-flow: column nowrap;
        align-items: center;
        gap: 30px;
        border-radius: 4px;
        background: var(--formBackground);
        padding: 10px;
    }
    form input{
        padding: 10px 2px;
        border-radius: 3px;
        border: 0.5px solid grey;
        width: 90%;

    }
    .login, .submitsec a{
        padding: 10px 20px;
        border-radius: 3px;
        border: none;
        width: 100%;
        background:rgb(36, 96, 247);
        color: #fff;
    }
    .forgotPasswordSec a{
        text-decoration: none;
        color: blue;
    
    }

   .heading{
    text-align: center;
   }
   .submitsec{
    width: 70%;
    display: flex;
    justify-content: center;
    gap: 10px;
    
   }
   .forgotPasswordSec{
    display: flex;
    flex-flow: column nowrap;
    justify-content: center;
    align-items: center;
    padding: 10px 0;
   }
 .message{
    color: green;
 }
 .error{
    color: red;
 }

   </style>

</head>
<body>

    <div class="container">

        <form action="./newpassword.php" method="post">
             <h3>Write new password</h3>
             <?php   if(!empty($message)){?>
        <span class="message"> <?= $message?></span>


     <?php } ?>   

     <?php   if(!empty($error)){?>
        <span class = "error"><?=$error?></span>

     <?php } ?>  
             <input type="hidden" name="email" value="<?= htmlspecialchars($email) ?>">
             <input type="password" placeholder="Enter password" name="password" id="password">
          <input type="password" placeholder="repeat password" name="newpassword" id="confirmpassword">

          <span id="passwordMessage"></span>

          <div class="submitsec">
            <input type="submit" value="SUBMIT" name="submit" class="login">
           
          </div>

            <div class="forgotPasswordSec">
               <p>Go to login <a href="./index.php">Login</a></p>
            
              
            </div>
         
        </form>
    </div>

    <script>
        
document.addEventListener("DOMContentLoaded", function () {
    const password = document.getElementById("password");
    const confirmPassword = document.getElementById("confirmpassword");
    const message = document.getElementById("passwordMessage");

    function checkPasswordMatch() {
        const passVal = password.value.trim();
        const confirmVal = confirmPassword.value.trim();

        if (!passVal || !confirmVal) {
            message.textContent = "";
            return;
        }

        if (passVal === confirmVal) {
            message.textContent = "Passwords match!";
            message.style.color = "green";
        } else {
            message.textContent = "Passwords do not match.";
            message.style.color = "red";
        }
    }

    password.addEventListener("input", checkPasswordMatch);
    confirmPassword.addEventListener("input", checkPasswordMatch);
});
    </script>
    
</body>
</html>