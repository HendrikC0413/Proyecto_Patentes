<?php
    class propietario {
        private $nombre;
        private $rut;
        private $phone;
        private $cellphone;
        private $email;
        private $direccion;
        private $comuna;
        private $ingresada;
        private $fecha_ingreso;

        public function __construct($nombre, $rut,$phone,$cellphone,$email,$direccion,$comuna,$ingresada,$fecha_ing) {
            $this->nombre = $this->comprobarNulidad($nombre);
            $this->rut = $this->comprobarNulidad($rut);
            $this->phone = $this->comprobarNulidad($phone);
            $this->cellphone = $this->comprobarNulidad($cellphone);
            $this->email = $this->comprobarNulidad($email);
            $this->direccion = $this->comprobarNulidad($direccion);
            $this->comuna = $this->comprobarNulidad($comuna);
            $this->ingresada = $ingresada;
            $this->fecha_ingreso = $fecha_ing;
        }
        
        public function getNombre() {
            return $this->nombre;
        }
        public function setNombre($nombre){
            $this->nombre = $nombre;
        }
        public function setRut($rut) {
            $this->rut = $rut;
        }
        public function getRut() {
            return $this->rut;
        }
        public function setPhone($phone) {
            $this->phone = $phone; 
        }
        public function getPhone() {
            return $this->phone;
        }
        public function setCellphone($cellphone) {
            $this->cellphone = $cellphone;
        }
        public function getCellphone() {
            return $this->cellphone;
        }
        public function setEmail($email) {
            $this->email = $email;
        }
        public function getEmail() {
            return $this->email;
        }
        public function setDireccion($direccion) {
            $this->direccion = $direccion;
        }
        public function getDireccion(){
            return $this->direccion;
        }
        public function setComuna($comuna) {
            $this->comuna = $comuna;
        }
        public function getComuna(){
            return $this->comuna;
        }
        public function setIngresada($ingresada) {
            $this->ingresada = $ingresada;
        }
        public function getIngresada() {
            return $this->ingresada;
        }
        public function setFecha_ingresa($fecha_ingresa) {
            $this->fecha_ingreso = $fecha_ingresa;
        }
        public function getFecha_ingresa() {
            $fechaMod = date(' j-m-Y \a \l\a\s H:i:s', strtotime($this->fecha_ingreso));
            return $fechaMod;
        }

        public function comprobarNulidad($comprobarNulidad) {
            if(is_null($comprobarNulidad)==true||$comprobarNulidad=="NULL"){
                $comprobarNulidad = "";
            }
            return $comprobarNulidad;
        }
    }