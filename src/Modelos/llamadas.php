<?php
    require_once("Modelos/datos_vehiculo.php");
    require_once("Modelos/propietario.php");
    require_once("Modelos/permiso_circulacion.php");
    require_once("Modelos/conexion.php");
    class Llamadas{
        
        public function __construct(){}
        /**
         * Llena el formulario con la informacion del vehiculo
         * @param string $placa, la patente del vehidulo a buscar.
         * @return Array retorna un array con los datos de [1] Propietarios [2] Datos del vehiculo [3] Permiso de circulación
         */
        public function llenarInformacion($placa){
            $con = new conexion();
            $pdo = null;
            $Datos = Array();
            try {
                // Conexión a la base de datos
                $pdo = $con->conectar();
                
                if($pdo != null){
                    // Prepara la consulta con marcadores de posición
                    $stmt = $pdo->prepare("SELECT * from public.busqueda_placa(?)");
                
                    // Ejecuta la consulta con los valores de los parámetros
                    $stmt->execute([$placa]);
                
                    // Obtiene los resultados
                    $resultados = $stmt->fetchAll();
                    
                    $prop = null;
                    $Datos_Vehiculo = null;
                    $permiso_circ = null;
                    // Asigna los resultados a variables
                    foreach ($resultados as $fila) {
                        $prop = new propietario($fila['nomb'], $fila['rut'], $fila['phone'],$fila['cellphone'], $fila['email'], $fila['dir'],$fila['comuna'],$fila['solicitud_ingresada'],$fila['fecha_solicitud'] );
                        $Datos_Vehiculo = new datos_vehiculo($fila['plac'],$fila['marc'],$fila['model'],$fila['color'],$fila['fabr']);
                        $permiso_circ = new permiso_circulacion($fila['estado_pago'],$fila['fecha_pago'],$fila['periodo']);
                    }
                    $Datos = Array($prop,$Datos_Vehiculo,$permiso_circ);
                }
            } catch (PDOException $e) {
                echo '<h5>Ha ocurrido un error en realizar su solicitud.</h5>'. $e->getMessage() .'';
            }
            return $Datos;
        }
        /**
         * Trae el numero de registro asociado a la placa
         * @param string $placa, corresponde a la patente.
         * @return Array con los datos de [1] nombre del propietario [2] el numero de registro.
         */
        public function TraerRegistro($placa){
            $con = new conexion();
            $pdo = null;
            $Datos = Array();
            try {
                // Conexión a la base de datos
                $pdo = $con->conectar();
                if($pdo != null){
                    // Prepara la consulta con marcadores de posición
                    $stmt = $pdo->prepare("SELECT * from public.busqueda_registro(?)");
                
                    // Ejecuta la consulta con los valores de los parámetros
                    $stmt->execute([$placa]);
                
                    // Obtiene los resultados
                    $resultados = $stmt->fetchAll();
                    foreach ($resultados as $fila) {
                        $Datos[] = $fila['nomb'] ;
                        $Datos[] = $fila['registro'];
                    }
                }
            } catch (PDOException $e) {
                echo '<h5>Ha ocurrido un error al realizar su solicitud de registro.</h5>'. $e->getMessage() .'';
            }
            return $Datos;
        }
        /**
         * Se realiza el registro en la base de datos.
         * @param string $run
         * @param string $plc, corresponde al valor de la patente del vehículo.
         * @param string $cel, corresponde al numero móvil del propieatrio
         * @param string $phone, corresponde al numero fijo del propietario
         * @param string $email
         * @return bool TRUE or FALSE dependiendo del resultado de la operación.
         */
        public function realizar_registro($run,$plc,$cel,$phone,$email){
            date_default_timezone_set('America/Santiago');
            $fecha_actual = date("Y-m-d H:i:s");
            $correcto= false;
            try {
                // Conexión a la base de datos
                $con = new conexion();
                $pdo = $con->conectar();
                
                if($pdo != null){
                    // Inicia la transacción
                    $pdo->beginTransaction();
                
                    // Prepara y ejecuta la operación de UPDATE
                    $stmt = $pdo->prepare("UPDATE public.propietarios SET telefono = ? , telefono_movil = ?, mail = ?  WHERE rut = ?");
                    $stmt->execute([$phone, $cel,$email,$run]);

                    // Prepara y ejecuta la operación de INSERT
                    $stmt = $pdo->prepare("INSERT INTO public.grabado_de_vehiculos (placa, Rut, Fecha_Solicitud) VALUES (?, ?, ?)");
                    $stmt->execute([$plc, $run, $fecha_actual]);
                
                    // Si ambas operaciones se realizan correctamente, confirma la transacción
                    $pdo->commit();
                    $correcto = true;
                }
            } catch (Exception $e) {
                // Si ocurre un error, deshace la transacción
                $pdo->rollBack();
                echo '<h5>Ha ocurrido un error en actualizar su información de contacto.</h5>'. $e->getMessage() .'';
            }
            return $correcto;
        }
    }