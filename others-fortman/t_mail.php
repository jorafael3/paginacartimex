<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
use PHPMailer\PHPMailer\SMTP;

require 'PHPMailer/src/Exception.php';
require 'PHPMailer/src/PHPMailer.php';
require 'PHPMailer/src/SMTP.php';

$mail = new PHPMailer;
$mail->CharSet = "UTF-8";
$mail->Encoding = 'quoted-printable'; //$mail->Encoding = "16bit";
$mail->isSMTP();
$mail->SMTPDebug = SMTP::DEBUG_OFF; // 2;

$mail->Host = 'mail.cartimex.com';
$mail->Port = 465; //465 // 25 //587

//Set the encryption mechanism to use - STARTTLS or SMTPS
$mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;

$mail->SMTPOptions = array(
    'ssl' => [
        'verify_peer' => false,
        'verify_peer_name' => true,
		'peer_name' => 'mail.cartimex.com',
        'allow_self_signed' => true,
    ],
);

$mail->SMTPAuth = true;

$mail->Username = 'web';
$mail->Password = 'misato19X';

$mail->setFrom('web@cartimex.com', 'CARTIMEX'); // From
$mail->addAddress('romel.vera.cadena@gmail.com', 'Romel Vera'); // To

// Message
$mail->Subject = 'PHPMailer SMTP test';
$mail->Body    = 'This is the HTML message body.';

//send the message, check for errors
if (!$mail->send()) {
    echo 'Mailer Error: ' . $mail->ErrorInfo;
} else {
    echo 'Message sent!';
}
