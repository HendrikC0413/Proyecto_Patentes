<?php
class Validaciones{
    public function __construct() {
    }
    /**
     * Valida si la placa viene con guion o sin guion en formato XX-000 XXX-000 etc.
     * @param string $placa se debe ingresar la placa correspondiente.
     * @return bool si todo es correcto true en caso contrario false.
     */
    public function ValidarPlaca(string $placa) {
        $valor = 0;
        $pattern = "/^[a-zA-Z]{1,4}[-]{1}[0-9]{2,4}$/";
        $valor = preg_match($pattern, $placa);
        $correcto = false;
        if ($valor == 1) {
            $correcto = true;
        }
        return $correcto;
    }
     /**
      * Si la placa viene sin guion se verifica que venga en formato XX000 o XXX000 etc
     * @param string $placa se debe ingresar la placa correspondiente.
     * @return bool si todo es correcto true en caso contrario false.
     */
    public function ValidarPlacasSinGuion($placa){
        $valor = 0;
        $pattern = "/^[A-Z]{1,4}[0-9]{2,4}$/";
        $valor = preg_match($pattern, $placa);
        $correcto = false;
        if ($valor == 1) {
            $correcto = true;
        }
        return $correcto;
    }
    /**
     * Busca la posicion y agrega el guion a la placa.
     * @param string $placa ingresar la placa sin guion
     * @return string devuelve la placa con el guion.
     */
    public function AgregarGuion(string $placa) {
        $tam = strlen($placa);
        $tamMitad = round($tam/2);
        $mitad = round($tam/2);
        $i = 0;
        $recuerdo = "";
        $patron = "/^[A-Z]$/";
        $patron2 = "/^[0-9]$/";
        $PlacaGuion = "";
        while($i<=$tamMitad){
            $dato = substr($placa,$mitad,1);
            $esLetra = preg_match($patron, $dato); 
            if($esLetra==1){
                if(preg_match($patron2, $recuerdo)==1){
                    $PlacaGuion = $this->concatenador($tam,$placa,$mitad+1);
                    break;
                }else{
                    $mitad = $mitad + 1;
                    $recuerdo = $dato;
                }
            }else{
                if(preg_match($patron, $recuerdo)==1){
                    $PlacaGuion = $this->concatenador($tam,$placa, $mitad);
                    break;
                }else{
                    $mitad = $mitad - 1;
                    $recuerdo = $dato;
                }
            }
            $i=$i+1;
        }
        return $PlacaGuion;
    }
    /**
     * Agrega el guion en la cadena.
     * @param int $tam corresponde al tamannio de la placa
     * @param string $placa corresponde a la placa.
     * @param int $mitad corresponde a la mitad del tamanio de la placa (debe estar redondeada).
     */
    public function concatenador($tam,$placa,$mitad){
        $z = 0;
        $final = "";
        while($z<$tam){
            $dato = substr($placa,$z,1);
            if($z==$mitad){
                $final =  $final."-";
            }
            $final = $final.$dato;
            $z=$z+1;
        }
        return $final;
    }
    /**
     * Valida el rut ingresado.
     * @param string $r corresponde al rut.
     * @return bool si el rut ingresado es valido.
     */
    public function runificador($r){
        $flag = false;
        $tam = strlen($r)-1;
        $run = [];
        $digitoVerificador = "";
        $ver = false;
        $i = 0;
        while($i<=$tam){
            if($ver==false){
                $digitoVerificador = substr($r,$tam,1);
                $ver = true;
            }else{
                if(substr($r,$tam,1)!="-"){
                      $run[] = substr($r,$tam,1);
                } 
            }
            $tam = $tam-1;
        }
        $i = 0;
        $tam = sizeof($run);
        $result = 0;
        $multiplicador = 2;
        while($i<$tam){
            $result = $result + intval($run[$i])*$multiplicador;
          $multiplicador = $multiplicador + 1;
          if($multiplicador > 7){
              $multiplicador = 2;
          }
          $i = $i+1;
        }
        $modulo = $result % 11;
        $dif = 11 - $modulo;
        $digCalculado = "";
        if ($dif<10) {
            $digCalculado = $dif;
        }elseif ($dif == 10) {
            $digCalculado = "K";
        }else {
            $digCalculado = "0";
        }
        if (strtoupper($digitoVerificador) == $digCalculado) {
            $flag = true;
        }
        return $flag;
    }

    /**
     * Valida el correo ingresado.
     * @param string $email
     */
    public function email ($email) {
        $valor = 0;
        $patron = "/^[\w-]+(\.[\w-]+)*@([\w-]+\.)+[a-zA-Z]{2,7}$/";
        $valor = preg_match($patron, $email);
        $correcto = false;
        if ($valor == 1) {
            $correcto = true;
        }
        return $correcto;
    }
    public function phone ($phone) {
        $valor = 0;
        $patron = "/^[0-9]{7,8}$/";
        $valor = preg_match($patron, $phone);
        $correcto = false;
        if ($valor == 1) {
            $correcto = true;
        }
        return $correcto;
    }
}