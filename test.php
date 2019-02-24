<?php

// Import PHPMailer classes into the global namespace
// These must be at the top of your script, not inside a function
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

//Load Composer's autoloader
require 'vendor/autoload.php';

$mail = new PHPMailer(true);                              // Passing `true` enables exceptions
try {
    //Server settings
    $mail->SMTPDebug = 3;                                 // Enable verbose debug output
    $mail->isSMTP();                                      // Set mailer to use SMTP
    $mail->Host = 'smtp.wp.pl';  // Specify main and backup SMTP servers
    $mail->SMTPAuth = true;                               // Enable SMTP authentication
    $mail->Username = 'adpanel@wp.pl';                 // SMTP username
    $mail->Password = '4Dmin70!';                           // SMTP password
    $mail->SMTPSecure = 'ssl'; 
    $mail->Port = 465;                                    // TCP port to connect to

    //Recipients
    $mail->setFrom('adpanel@wp.pl', 'no-replay');
    $mail->addAddress('qikcik@gmail.com');     // Add a recipient

    //Attachments
    //Content
    $mail->CharSet = "UTF-8";
    $mail->Encoding = "base64";
    $mail->isHTML(true);                                  // Set email format to HTML
    $mail->Subject = 'ADpanel: ZS1 Bochnia - Reset Hasła';
    $mail->Body    = 'kliknji to: <a href="google.com"> Przejdź dalej</a>';
    $mail->AltBody = 'no nie !!! nie przewidzieliśmy tego';

    $mail->send();
    echo 'Message has been sent';
} catch (Exception $e) {
    echo 'Message could not be sent. Mailer Error: ', $mail->ErrorInfo;
}
?>