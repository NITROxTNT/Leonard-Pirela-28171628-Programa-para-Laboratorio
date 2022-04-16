<?php

use PHPMailer\PHPMailer\PHPMailer;

require('../phpmailer/src/PHPMailer.php');
require('../phpmailer/src/Exception.php');
require('../phpmailer/src/SMTP.php');

function enviarPDF ($nombreArchivo, $destinatario, $resultadosExamen) {
 
    $mail = new PHPMailer();
        $mail->From = "laboratoriospirela@domain.com";
        $mail->FromName = "Laboratorios Leonard Pirela";
        $mail->Subject = "Resultado de examen de " . $resultadosExamen['examenSeleccionado'];
        $mail->Body = "Hola " . $destinatario['usuarioNombre'] . ", aqui te hacemos llegar los resultados de tu examen de " . $resultadosExamen['examenSeleccionado'] . " realizado el dia " . $resultadosExamen['resultFecha'];
        $mail->AddAddress($destinatario['usuarioMail'], $destinatario['usuarioNombre']);
        $mail->AddAttachment('../resultados/' . $nombreArchivo, $nombreArchivo);
        
           if ($mail->Send()) {
               return 'Los resultados han sido enviados al paciente con éxito';
           } else {
               return 'Los resultados no se han podido enviar al usuario con éxito';
           }

}


?>