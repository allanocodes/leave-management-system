

<?php 

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require_once '../vendor/autoload.php';

function getMailer(): PHPMailer {
    $mail = new PHPMailer(true);

    // Server settings
    $mail->isSMTP();
    $mail->Host       = 'smtp.gmail.com'; 
    $mail->SMTPAuth   = true;
    $mail->Username   = 'ndururiallan92@gmail.com';  
    $mail->Password   = 'yiwe jeea lsux mfgr';      
    $mail->SMTPSecure = 'tls'; 
    $mail->Port       = 587;  

    
    $mail->setFrom('ndururiallan92@gmail.com', 'Developer');

    return $mail;
}

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $firstName = $_POST['fname'] ?? '';
    $lastName = $_POST['lname'] ?? '';
    $email = $_POST['email'] ?? '';
    $message = $_POST['message'] ?? '';

try {
    $mail = getMailer();
    $mail->addAddress($email, $firstName);
    $mail->Subject = 'Contact For Services';
    $mail->isHTML(true);
    $mail->Body = "<p> {$message}</p>";

    $mail->send();
    header("location: ../home.php?messagex=EmailSent");
   
} catch (Exception $e) {

    header("location: ../home.php?errorx=Emailfailed({$mail->ErrorInfo})");
    exit();
}


        

}

?>