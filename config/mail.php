<?php


use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;


require_once __DIR__ . '/../PHPMailer-master/src/Exception.php';
require_once __DIR__ . '/../PHPMailer-master/src/PHPMailer.php';
require_once __DIR__ . '/../PHPMailer-master/src/SMTP.php';


function enviarCorreoRecuperacion($destinatario, $contrasena) {
    $mail = new PHPMailer(true);

    try {
       
        $mail->isSMTP();
        $mail->Host       = 'smtp.gmail.com';        
        $mail->SMTPAuth   = true;
        $mail->Username   = 'sergiodaw2026@gmail.com';   
        $mail->Password   = 'ovpe ykck toop nfmj';  
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
        $mail->Port       = 587;
        
        
        
        $mail->CharSet = 'UTF-8';

       
        $mail->setFrom('sergiodaw2026@gmail.com', 'El Hobbyte - Recuperación');
        $mail->addAddress($destinatario);

        // Contenido del correo
        $mail->isHTML(true);
        $mail->Subject = 'Recuperación de contraseña - El Hobbyte';
        $mail->Body    = "
            <h2>¡Hola!</h2>
            <p>Hemos generado una nueva contraseña para tu cuenta en <strong>El Hobbyte</strong>.</p>
            <p><strong>Tu nueva contraseña es:</strong> <code>$contrasena</code></p>
            <hr>
            <small>Este mensaje se envía automáticamente. No respondas a este correo.</small>
        ";

        $mail->send();
        return true;

    } catch (Exception $e) {
        
        return false;
    }
}