<?php
require_once("Modelos/llamadas.php");
require_once("Modelos/correo2.php");
require_once("Validaciones.php");
class ControlTest {
    public function __construct() {}
    /**
     * Llama al modelo, para traer la informacion y pasarsela a la vista.
     * @param string $patente
     * @return Array() con los datos para llenar la información.
     */
    public function SeleccionarDatos(string $patente) {
        $datos = new Llamadas();
        try {
            $Arreglo = $datos->llenarInformacion($patente);
        } catch (Exception $e) {
            echo "No se ha podido encontrar información". $e->getMessage() ."";
        }finally {
            return $Arreglo;
        }
    }
    public function PatenteRevisar(string $patente) {
        $Validador = new Validaciones();
        $flag = 0;
        try {
            if($Validador->ValidarPlaca($patente)==true) {
                $flag = 1;
            }else if($Validador->ValidarPlacasSinGuion($patente)==true) {
                $flag = 2;
            }
        }catch(Exception $e) {
            $flag = 0;
            echo "<h5>Ha ocurrido un error al revisar su patente</h5>".$e->getMessage();
        }finally {
            return $flag;
        }
    }
    public  function FaltaGuion(string $patente) {
        $nuevaPatente = "";
        $Validador = new Validaciones();
        try {
            $nuevaPatente = $Validador->AgregarGuion($patente);
        }catch(Exception $e) {
            echo   "<h5>Ha ocurrido un problema con la digitación de su patente.</h5>".$e->getMessage();
        }
        return $nuevaPatente;
    }
    public function revisadorRun(string $rn){
        $correcto = false;
        try {
            $Validador = new Validaciones();
            $correcto = $Validador->runificador($rn);
        } catch (Exception $e) {
            echo "<h5>Ocurrió un problema al ingresar su RUN.</h5>".$e->getMessage();
        }
        return $correcto;
    }
    public function revisadorMail(string $ml){
        $correcto = false;
        try {
            $Validador = new Validaciones();
            $correcto = $Validador->email($ml);
        } catch (Exception $e) {
            echo "<h5>Ocurrió un problema al ingresar su correo electrónico.</h5>".$e->getMessage();
        }
        return $correcto;
    }
    public function revisadorPhone(string $ph){
        $correcto = false;
        try {
            $Validador = new Validaciones();
            $correcto = $Validador->phone($ph);
        } catch (Exception $e) {
            echo "<h5>Ocurrió un problema al ingresar su número telefónico.</h5>".$e->getMessage();
        }
        return $correcto;
    }
    public function registrar (string $run,string $plc,string $cel, string $phone, string $email){
        $datos = new Llamadas();
        $correcto = false;
        try {
            if($datos->realizar_registro($run, $plc, $cel, $phone, $email)==true){
                $correo = new Correo2();
                $registro = $datos->TraerRegistro($plc);
                $nomb = $registro[0];
                $regis = $registro[1];
                if($correo->EnviarCorreo($plc,$run,$nomb,$regis,$cel,$phone,$email)== true){
                    $correcto = true;
                }
            }
        } catch (Exception $e) {
            echo "<h5>No se ha podido realizar el registro</h5>".$e->getMessage();
        }
        return $correcto;
    }
}