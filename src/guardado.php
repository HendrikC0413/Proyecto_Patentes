<!DOCTYPE html>
<html>
    <head>
    </head>
    <body>
<?php
    require_once("Controlador/ControlTest.php");
    $paramR = "";
    $paramPH = "";
    $paramCL = "";
    $paramM = "";
    $paramPL = "";
    $vacios = 0;
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        if(!empty($_POST['paramR'])) {
            $paramR = $_POST['paramR'];
        }else{
            $vacios = $vacios +1;  
        }
        if(!empty($_POST['paramPH'])) {
            $paramPH = $_POST['paramPH'];
        }else{
            $vacios = $vacios +1;  
        }
        if(!empty($_POST['paramCL'])) {
            $paramCL = $_POST['paramCL'];
        }else{
            $vacios = $vacios +1;  
        }
        if(!empty($_POST['paramM'])) {
            $paramM = $_POST['paramM'];
        }else{
            $vacios = $vacios +1;  
        }
        if(!empty($_POST['paramPL'])) {
            $paramPL = $_POST['paramPL'];
        }else{
            $vacios = $vacios +1;  
        }
        
        if($vacios < 3){
             if(ValidarDatos($paramR, $paramM, $paramPH,$paramCL,$paramPL)==true){
                $control = new ControlTest();
                if($control->registrar($paramR,$paramPL,$paramCL,$paramPH,$paramM)==true) {
                    ?>
                    <div class="alert alert-success alert-dismissible" role="alert">
                        <button type="button" class="btn-close" title="cerrar" data-bs-dismiss="alert"></button>
                        <i class="bi bi-check2-square"></i>&nbsp<?php echo("Se ha realizado su registro correctamente");?>
                    </div>
                    <?php
                }else{
                    ?>
                    <div class="alert danger-success alert-dismissible" role="alert">
                        <button type="button" title="cerrar" class="btn-close" data-bs-dismiss="alert"></button>
                        <i class="bi bi-exclamation-octagon"></i>&nbsp<?php echo("Ha ocurrido un problema al realizar el registro<br>");?>
                    </div>
                    <?php
                }
             }
        }else{
            ?>
            <div class="alert alert-danger alert-dismissible" role="alert">
                <button type="button" title="cerrar" class="btn-close" data-bs-dismiss="alert"></button>
                <i class="bi bi-exclamation-octagon"></i>&nbsp<?php echo("Ha ingresado muchos campos vacíos<br>");?>
            </div>
            <?php
        }
    }

    function ValidarDatos($RUN,$MAIL,$PHONE,$CELL,$PLC){
        $ControlTest = new ControlTest();
        $contador = 0;
        $correcto = false; 
        if($ControlTest->revisadorRun($RUN)==true){
            $contador = $contador + 1;
        }else{
            ?>
            <div class="alert alert-danger alert-dismissible" role="alert">
                <button type="button" title="cerrar" class="btn-close" data-bs-dismiss="alert"></button>
                <i class="bi bi-exclamation-octagon"></i>&nbsp<?php echo("Ha ocurrido un problema al validar su RUT<br>");?>
            </div>
            <?php
        }
        if($ControlTest->revisadorMail($MAIL)==true||$MAIL == "") {
            $contador = $contador + 1;
        }else{
            ?>
            <div class="alert alert-danger alert-dismissible" role="alert">
                <button type="button" title="cerrar" class="btn-close" data-bs-dismiss="alert"></button>
                <i class="bi bi-exclamation-octagon"></i>&nbsp<?php echo("Ha ocurrido un problema al validar su Correo Electronico<br>");?>
            </div>
            <?php
        }
        if($ControlTest->revisadorPhone($PHONE)==true || $PHONE==""){
            $contador = $contador + 1;
        }else{
            ?>
            <div class="alert alert-danger alert-dismissible" role="alert">
                <button type="button" title="cerrar" class="btn-close" data-bs-dismiss="alert"></button>
                <i class="bi bi-exclamation-octagon"></i>&nbsp<?php echo("Ha ocurrido un problema al validar su numero telefónico<br>");?>
            </div>
            <?php
        }
        if($ControlTest->PatenteRevisar($PLC)==1) {
            $contador = $contador + 1;
        }else{
            ?>
            <div class="alert alert-danger alert-dismissible" role="alert">
                <button type="button" title="cerrar" class="btn-close" data-bs-dismiss="alert"></button>
                <i class="bi bi-exclamation-octagon"></i>&nbsp<?php echo("Ha ocurrido un problema al validar su patente<br>");?>
            </div>
            <?php
        }
        if($ControlTest->revisadorPhone($CELL)==true|| $CELL=="") {
            $contador = $contador + 1;
        }else{
            ?>
            <div class="alert alert-danger alert-dismissible" role="alert">
                <button type="button" title="cerrar" class="btn-close" data-bs-dismiss="alert"></button>
                <i class="bi bi-exclamation-octagon"></i>&nbsp<?php echo("Ha ocurrido un problema al validar su número de celular<br>");?>
            </div>
            <?php
        }
        if($contador==5){
            $correcto = true;
        }
        return $correcto;
    }
     ?> 
     </body>
</html>