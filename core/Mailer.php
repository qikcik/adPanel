<?php

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;


class Mailer
{
    private static $host =  'smtp.wp.pl';
    private static $method =  'ssl';
    private static $port =  465;

    public static $login =  'mail@wp.pl';
    private static $pass =  'verySecurePassword';

    public static function send($to,$tittle,$body)
    {
        $mail = new PHPMailer(true);                              
        try {
            //$mail->SMTPDebug = 3;                                 
            $mail->isSMTP();                                   
            $mail->Host = self::$host; 
            $mail->SMTPAuth = true;                           
            $mail->Username = self::$login;                        
            $mail->Password = self::$pass;                      
            $mail->SMTPSecure = self::$method; 
            $mail->Port = self::$port;                                   

    
            $mail->setFrom(self::$login, 'no-replay');
            $mail->addAddress($to);  

            $mail->CharSet = "UTF-8";
            $mail->Encoding = "base64";
            $mail->isHTML(true);                                  
            $mail->Subject = $tittle;
            $mail->Body    = $body;
            $mail->AltBody = 'no nie !!! nie przewidziałem tego';

            @$mail->send();
        } catch (Exception $e) {
            return false;
        }
        return true;
    }
}

?>
