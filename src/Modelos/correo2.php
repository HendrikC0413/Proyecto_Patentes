<?php

//Import PHPMailer classes into the global namespace
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;

require 'Modelos/PHPMailer/src/Exception.php';
require 'Modelos/PHPMailer/src/PHPMailer.php';
require 'Modelos/PHPMailer/src/SMTP.php';

class Correo2{
    public function __construct() {
    }
    /**
     * Funcion que realiza el envio del correo.
     * @param string $placa , la patente del vehiculo
     * @param string $run
     * @param string $nombre, del propietario del vehículo.
     * @param string $regis, corresponde al numero del registro.
     * @param string $cel, corresponde al numero celular.
     * @param string $phone, corresponde al teléfono fijo.
     * @param string $email
     * @return bool Si el envio fue exitoso. 
     */
    public function EnviarCorreo(string $placa,string $run,string $nombre, string $regis, string $cel, string $phone, string $email){
        $correcto = false;
        try {
            $mail = new PHPMailer(true);
            $mail->CharSet = "UTF-8";
            //Server settings
            $mail->SMTPDebug = SMTP::DEBUG_OFF;                         //Activa el modo debug, que muestra el recorrido del msj
            $mail->isSMTP();                                            //Se espefcifica si es enviado con SMTP
            $mail->Host       = 'UN_SERVIDOR_DE_CORREOS';                       //El server smtp a enviar.
            $mail->SMTPAuth   = true;                                   //Activa la autenficacion a traves de smtp
            $mail->Username   = 'UN_CORREO';               //SMTP username
            $mail->Password   = 'UNA_PASSWORD';                     //SMTP password
            $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;            //Activa la encriptacion
            $mail->Port       = 'PORT';                                    //Indicar el puerto a ocupar; usar 587 si se tiene configurado como `SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS`
        
            //Recipients
            $mail->setFrom('CORREO_REMITENTE', 'NOMBRE REMITENTE');
            $mail->addAddress('ellen@example.com');                       //Add a recipient Name is optional
            //$mail->addReplyTo('info@example.com', 'Information');
            $contacto = "<b>Contacto entregado: </b><br>";
            if($email!= ""){
                $mail->addCC($email);
                $contacto = $contacto.'EMAIL: '.$email.'<br>';
            }
            if($cel!=""){
                $contacto = $contacto."TELÉFONO MÓVIL: +56 9 ".$cel."<br>";
            }

            if($phone!= ""){
                $contacto = $contacto."TELÉFONO: ".$phone."<br>";
            }
            //$mail->addBCC('bcc@example.com');
        
            //Attachments
            //$mail->addAttachment('/var/tmp/file.tar.gz');         //Add attachments
            //$mail->addAttachment('/tmp/image.jpg', 'new.jpg');    //Optional name
        
            //Content
            date_default_timezone_set('America/Santiago');
            $fecha_actual = date("d-m-Y H:i:s");
            $mail->isHTML(true);                                  //Set email format to HTML
             $asunto = "Nuevo registro N°".$regis." grabado de vehículos";
            $mail->Subject ="=?UTF-8?B?".base64_encode($asunto)."=?=";
            $mail->Body    = "Registro N°".$regis.", cuya patente es: <b>".$placa."</b>, propietario(a) <b>".$nombre."</b> ( ".$run." ) el día ".$fecha_actual."<br>".$contacto;
            $mail->AltBody = "Registro N°".$regis.", cuya patente es: ".$placa.", propietario(a) ".$nombre." ( ".$run." ) el día ".$fecha_actual." ".$contacto;
        
            $mail->send();
            $correcto = true;
        } catch (Exception $e) {
            echo "<h5>Ha ocurrido un error inesperado en el envío de sus datos</h5> {$mail->ErrorInfo}";
        }
        return $correcto;
    }
}