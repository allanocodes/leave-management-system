

<?php


require_once "./emailconfig.php";
require_once "./classes/Database.php";
require_once "./classes/registration-class.php";
require_once "./classes/emailCollector-controller.class.php";
$message = $_GET['message'] ?? null;
$error = $_GET['error'] ?? null;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = filter_input(INPUT_POST, 'email', FILTER_VALIDATE_EMAIL);


    $contr = new EmailCollectorCont($email);

    $is_present = $contr->confirmUsername();

    if($is_present){

    if($email){

        try {
            $mail = getMailer();
            $mail->addAddress($email, 'Student Name');
            $mail->Subject = 'Reset password';
            $mail->isHTML(true);
            $mail->Body = "<p>http://localhost/SCHOOL-PROJECT/newpassword.php?email={$email}</p>";
        
            $mail->send();
            header("location: ./emailCollection.php?message=EmailSent");
           
        } catch (Exception $e) {
            header("location: ./emailCollection.php?error=Emailfailed({$mail->ErrorInfo})");
            exit();
        }

    }
}


else{
    header("location: ./emailCollection.php?error=usernameNOtFound");
    exit();

}
}
?>






<!DOCTYPE html>
<html>
<head>
    <title>Email Form</title>

    <link href="https://fonts.googleapis.com/css2?family=Nunito&display=swap" rel="stylesheet">
    <style>
        body {
            width: 100%;
            height: 100%;
            font-family: 'Nunito', sans-serif;
            background-color:  #2d67f7;
            
        }

        .wrapper {
            width: 450PX;
            min-height: 200px;
            margin: 50px auto;
            box-shadow: 2px 2px 5px rgba(0, 0, 0, 0.1);
            display: flex;
            flex-flow: column nowrap;
            align-items: center;
            background:  whitesmoke;
            padding: 20px;
            border-radius: 8px;
        }

        h4 {
            color: #0d2187;
        }

        form {
            margin-top: 20px;
            display: flex;
            flex-direction: column;
            align-items: flex-start;
            width: 100%;
            max-width: 400px;
        }

        label {
            margin-bottom: 8px;
            font-weight: bold;
        }

        input{
            width: 100%;
            padding: 10px;
            margin-bottom: 15px;
            border: 1px solid #ccc;
            border-radius: 5px;
        }

        button {
            background: #0d2187;
            color: white;
            padding: 10px 20px;
            border: none;
            border-radius: 3px;
            cursor: pointer;
        }

        button:hover {
            background-color: #1a33b8;
        }
        .message{
            color: green;
        }
    </style>
</head>
<body>

<div class="wrapper">
    <h4>Email Collection Form</h4>

    <?php   if(!empty($message)){?>
        <span class="message"> <?= $message?></span>


     <?php } ?>   

     <?php   if(!empty($error)){?>
        <span class = "message"><?=$error?></span>

     <?php } ?>  

    <form method="POST" action="./emailCollection.php">
        <label for="email">Enter your email:</label>
        <input type="email" name="email" id="email" required placeholder="your@email.com">
        <button type="submit">Submit</button>

    </form>
</div>

</body>
</html>
