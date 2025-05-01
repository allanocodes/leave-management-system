<?php

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require_once './vendor/autoload.php';

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

