<?php
class conexion {
    private $host;
    private $basename;
    private $usuario;
    private $pass;

    public function __construct() {
        $this->host = "localhost";
        $this->basename = "TU_BASE";
        $this->usuario = "TU_USUARIO";
        $this->pass = "TU_PASSWORD";
    }
    /**
     * Conecta la aplicacion con la base de datos, con los datos ingresados con anterioridad.
     * @return PDO retorna una instancia de PDO
     */
    public function conectar(){
        $pdo = null;
        try {
            $pdo = new PDO('pgsql:host='.$this->host.';dbname='.$this->basename, $this->usuario,$this->pass);
        } catch (Exception $e) {
            echo '<h5>No se pudo realizar la conexión con la base de datos</h5>'. $e->getMessage() .'';
        }
        return $pdo;
    }
}