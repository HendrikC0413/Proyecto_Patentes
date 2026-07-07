<?php
     class Correo{
        private $to_email = "Tu_Correo";
        private $subject = "";
        private $body = "";
        private $headers = "De: sender\'s email";
        public function __construct(){
        }

        public function enviar() {
            $correcto = false;
            try {
                if (mail($this->to_email, $this->subject, $this->body, $this->headers)) {
                    $correcto = true;
                } else {
                        $correcto = false;
                }
            } catch (Exception $e) {
                echo "ha ocurrido un problema en el envio del mensaje". $e->getMessage() ."";
            }
            return $correcto;
        }
        public function llenar_email($placa,$run,$phone,$mail,$cell) {
            $fecha_actual = date("d-m-Y H:i:s");
            $this->subject = "Nuevo registro ".$run." vehiculo ".$placa;
            $this->body = "Se ha registrado ".$run." cuya patente es: ".$placa." el dia ".$fecha_actual;
        }
     }
     

