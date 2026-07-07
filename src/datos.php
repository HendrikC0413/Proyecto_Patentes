<!DOCTYPE html>
<html>
<head>
<style>
</style>
</head>
<body>

<?php
require_once("Controlador/ControlTest.php");
$q = strtoupper($_GET['q']);
$ControlTest = new ControlTest();
$control = null;
$flag = false;

//######################################
// INGRESAR 10: PARA TODOS LOS PERIODOS
// INGRESAR 12: PARA LOS PERIODOS 1 y 2
// INGRESAR 13: PARA PERIODOS 1 Y 3
// INGRESAR 23: PARA PERIODOS 2 Y 3
// PARA DEJAR SOLO 1 PERIODO DISPONIBLE INGRESAR PERIODO
// CAMBIAR AQUI PARA MODIFICAR EL PERIODO
$periodoActual = 1;
//######################################

$Validada = $ControlTest->PatenteRevisar($q);
switch ($Validada) {
    case 1: 
        $control = $ControlTest->SeleccionarDatos($q);
        $flag = true;
        break;
    case 2: 
        $nuevaPatente = $ControlTest->FaltaGuion($q);
        $control = $ControlTest->SeleccionarDatos($nuevaPatente);
        $flag = true;
        break;
    }

$expandido = "true";
if($flag == true){
    if ($control[0]==null){
        SinDatos(1);
    }else{
        $valor = 0;
        if($control[0]->getIngresada()>0){
            $valor = 1 ;
        }else{
            switch ($periodoActual){
                case 12:
                    if($control[2]->getPeriodo()==3){
                        $valor = 2;
                    }break;
                case 13:
                    if($control[2]->getPeriodo()== 2){
                        $valor = 2;
                    }break;
                case 23:
                    if($control[2]->getPeriodo()== 1){
                        $valor = 2;
                    }break;
                default:
                    if($control[2]->getPeriodo()!= $periodoActual && $periodoActual != 10){
                        $valor = 2;
                    }else{
                        $valor = 0; 
                    }
                    break;
            }
        }
        $borde = "border-danger";
        $display = "block";
        $mailBorder = "border-success";
        $mailVisible = "none";
        $celBorder = "border-success";
        $celVisible = "none";
        $phoBorder = "border-success";
        $phoVisible = "none";
        if($ControlTest->revisadorMail($control[0]->getEmail())==false){
           if($control[0]->getEmail()== ""){
            $mailBorder = "";
           }else{
                $mailBorder = $borde;
                $mailVisible =$display;
           }
        }
        if($ControlTest->revisadorPhone($control[0]->getCellphone())==false){
            if($control[0]->getCellphone()== ""){
                $celBorder = "";
               }else{
                    $celBorder = $borde;
                    $celVisible = $display;
               }
        }
        if($ControlTest->revisadorPhone($control[0]->getPhone())==false){
            if($control[0]->getPhone()== ""){
                $phoBorder = "";
               }else{
                    $phoBorder = $borde;
                    $phoVisible = $display;
               }
        }
        MostrarDatos($control,$valor,$mailBorder,$mailVisible,$celBorder,$celVisible,$phoBorder,$phoVisible);
    }  
}else{
    SinDatos(0);
} 

function SinDatos($opcion){
    $mensaje = "";
    if($opcion== 0){
        $mensaje = "El formato de su patente no se ha reconocido";
    }elseif($opcion== 1){
        $mensaje = " Su patente no fue encontrada.";
    }
    ?>
<br>
    <div class="alert alert-info" role="alert">
    <i class="bi bi-exclamation-octagon"></i></i>&nbsp<?php echo $mensaje;?>
    </div>
<?php
}

function MostrarDatos($control,$valor,$mailBorder,$mailVisible,$celBorder,$celVisible,$phoBorder,$phoVisible){
    $disable = "";
    $read = "";
    $texto = "";
    if($valor==1){
        $texto = "Usted ya registró esta patente, el día". $control[0]->getFecha_ingresa();
        $disable = "disabled";
        $read = "readonly";
        ?>
        <br>
        <div class="alert alert-info alert-dismissible" role="alert">
            <button type="button" class="btn-close" title="cerrar" data-bs-dismiss="alert"></button>
            <i class="bi bi-exclamation-octagon"></i>&nbsp<?php echo($texto);?>
        </div>
      <?php  
    }elseif($valor==2) {
        $texto = "No se encuentra disponible para este periodo.";
        $disable = "disabled";
        $read = "readonly";
        ?>
        <br>
        <div class="alert alert-info alert-dismissible" role="alert">
            <button type="button" class="btn-close" title="cerrar" data-bs-dismiss="alert"></button>
            <i class="bi bi-info-circle"></i>&nbsp&nbsp<?php echo($texto);?>
        </div>
        <?php  
    }
?>
<div class="accordion" id="AcordeonMuestra">
    <div class="accordion-item">
        <h2 class="accordion-header" id="DatosPropietarios">
        <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
        <i class="bi bi-person-fill"></i>&nbsp-&nbspDatos del propietario
        </button>
        </h2>
        <div id="collapseOne" class="accordion-collapse collapse show" aria-labelledby="DatosPropietarios" data-bs-parent="#AcordeonMuestra">
            <div class="accordion-body">
                <div class="row aling-item-center">
                    <div class="col-sm-6">
                        RUT:
                        <input class="form-control text-center"type="text" id="rin" value="<?php echo($control[0]->getRut());?>" readonly></input>
                    </div>
                    <div class="col-sm-6">
                        NOMBRE:
                        <input class="form-control text-center"type="text" value="<?php echo($control[0]->getNombre());?>" readonly></input>
                    </div>
                </div><!-- fin fila 1-->
                <div class="row">
                    <div class="col-sm-6">
                        DIRECCION:
                        <input class="form-control text-center"type="text" value="<?php echo($control[0]->getDireccion());?>" readonly></input>
                    </div>
                    <div class="col-sm-6">
                        COMUNA:
                        <input class="form-control text-center"type="text" value="<?php echo($control[0]->getComuna());?>" readonly></input>
                    </div>
                </div><!-- fin fila 2-->
            </div>
        </div>
    </div><!-- fin acordeon item1-->
    <div class="accordion-item">
        <h2 class="accordion-header" id="DatosVehiculo">
            <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#collapseTwo" aria-expanded="true" aria-controls="collapseTwo">
            <i class="bi bi-car-front-fill"></i>&nbsp-&nbspDatos del Vehiculo
            </button>
        </h2>
        <div id="collapseTwo" class="accordion-collapse collapse show" aria-labelledby="DatosVehiculo" data-bs-parent="#AcordeonMuestra2">
            <div class="accordion-body">
                <div class="row aling-item-center">
                        <div class="col-sm-6">
                            PLACA:
                            <input class="form-control text-center"type="text" id="plc" value="<?php echo($control[1]->getPlaca());?>" readonly></input>
                        </div>
                        <div class="col-sm-6">
                            MARCA:
                            <input class="form-control text-center"type="text" value="<?php echo($control[1]->getMarca());?>" readonly></input>
                        </div>
                    </div><!-- fin fila 1-->
                    <div class="row">
                        <div class="col-sm-4">
                            MODELO:
                            <input class="form-control text-center"type="text" value="<?php echo($control[1]->getmodelo());?>" readonly></input>
                        </div>
                        <div class="col-sm-4">
                            COLOR:
                            <input class="form-control text-center"type="text" value="<?php echo($control[1]->getColor());?>" readonly></input>
                        </div>
                        <div class="col-sm-4">
                            AÑO:
                            <input class="form-control text-center"type="text" value="<?php echo($control[1]->getA_fabricacion());?>" readonly></input>
                        </div>
                    </div>
                </div>
            </div>
    </div><!-- fin acordeon item2-->
    <div class="accordion-item">
        <h2 class="accordion-header" id="headingThree">
            <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#collapseThree" aria-expanded="true" aria-controls="collapseThree">
            <i class="bi bi-person-vcard-fill"></i>&nbsp-&nbspDatos de contacto:
            </button>
        </h2>
        <div id="collapseThree" class="accordion-collapse collapse show" aria-labelledby="headingThree" data-bs-parent="#AcordeonMuestra3">
            <div class="accordion-body">
                <div class="row aling-item-center">
                    <div class="alert alert-warning" role="alert">
                    <i class="bi bi-info-circle"></i>&nbsp&nbspPor favor, proporcione <strong> al menos </strong> un método de contacto para programar el servicio de su vehículo.
                    </div>
                    <div class="col-sm-4">
                        CORREO:
                        <input class="form-control text-center  <?php echo($mailBorder);?>" maxlength="90" type="email" onchange="ValidarEmail()" data-toggle="tooltip" id="mail" value="<?php echo($control[0]->getEmail());?>"  <?php echo($read);?> ></input>
                        <label class="text-danger" id="Lemail" for="mail" style="display:<?php echo($mailVisible);?>;"><small><i class="bi bi-exclamation-circle"></i> El formato del email ingresado no es valido. tucorreo@tudominio.com</small></label>
                    </div>
                    <div class="col-sm-4">
                        TELEFONO FIJO:
                        <input class="form-control text-center <?php echo($phoBorder);?>"type="text" onchange="ValidarTelefono()" data-toggle="tooltip" id="phone" value="<?php echo($control[0]->getPhone());?>"  <?php echo($read);?> ></input>
                        <label class="text-danger" id="Lphone" for="phone" style="display:<?php echo($phoVisible);?>;"><small><i class="bi bi-exclamation-circle"></i> El formato del telefono ingresado no es valido. 7722233 solo 7 u 8 digitos</small></label>
                    </div>
                    <div class="col-sm-4">
                        CELULAR:
                        <div class="input-group">
                            <div class="input-group-prepend">
                                <span class="input-group-text border border-dark">+569</span>
                            </div>
                        <input class="form-control text-center <?php echo($celBorder);?>"type="text" onchange="ValidarCelular()" data-toggle="tooltip" id="cellphone" value="<?php echo($control[0]->getCellphone());?>"  <?php echo($read);?> ></input>
                        </div>
                        <label class="text-danger" id="LCphone" for="cellphone" style="display:<?php echo($celVisible);?>;"> <small><i class="bi bi-exclamation-circle"></i> El formato del telefono ingresado no es valido. 11223344 solo 8 digitos</small></label>
                    </div>
                </div><!-- fin fila 1-->
                <div class="row justify-content-center">
                    <br>
                    <?php if ($valor==0) { ?>
                        <div class="col-sm-6">
                            <button type="button" onclick="comprobarDatos()" class="btn btn-primary" title="Registrar" <?php echo($disable);?> >Realizar solicitud</button>
                        </div>
                    <?php } ?>
                    <div class="alert alert-danger " role="alert" id="alerta" style="display:none;">
                        <i class="bi bi-exclamation-octagon"></i></i>&nbsp<p id="AlertaP"></p>
                    </div>
                </div>
            </div>
        </div>
  </div><!-- fin acordeon item3-->
</div>
<?php }?>
</body>
</html>