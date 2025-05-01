
<?php

$message = $_GET['message'] ?? null;
$error = $_GET['error'] ?? null;
$error2 = $_GET['error2'] ?? null;
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
   .error,.error2{
    color: red;
   }


   </style>

</head>
<body>

    <div class="container">

        <form action="includes/login.inc.php" method="post">
             <h3>Login</h3>

             <?php   if(!empty($message)){?>
        <span class="message"> <?= $message?></span>


     <?php } ?>   

     <?php   if(!empty($error)){?>
        <span class = "error"><?=$error?></span>

     <?php } ?>  
          <input type="text" placeholder="Enter Username" name="username">
          <input type="password" placeholder="Enter password" name="password">

          
     <?php   if(!empty($error2)){?>
        <span class="error2">wrong password</span>

     <?php } ?>  
          

          <div class="submitsec">
            <input type="submit" value="LOGIN" name="login" class="login">
           
          </div>

            <div class="forgotPasswordSec">
               <p>Forgot password?     <a href="./emailCollection.php">password</a></p>
               <p>Dont have an Account <a href="./registration.php">Sign Up</a></p>
              
            </div>
         
        </form>
    </div>
    
</body>
</html>