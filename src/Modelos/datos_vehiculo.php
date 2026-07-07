<?php
    class datos_vehiculo {
        private $placa;
        private $marca;
        private $modelo;
        private $color;
        private $A_fabricacion;

        public function __construct($placa, $marca,$modelo,$color,$A_fabricacion) {
            $this->placa = $this->comprobarNulidad($placa);
            $this->marca = $this->comprobarNulidad($marca);
            $this->modelo = $this->comprobarNulidad($modelo);
            $this->color = $this->comprobarNulidad($color);
            $this->A_fabricacion = $A_fabricacion;
        }
        public function getPlaca() {
            return $this->placa;
        }
        public function getMarca() {
            return $this->marca;
        }
        public function getmodelo() {
            return $this->modelo;
        }
        public function getColor() {
            return $this->color;
        }
        public function getA_fabricacion() {
            return $this->A_fabricacion;
        }
        public function setPlaca($placa) {
            $this->placa = $placa;
        }
        public function setMarca($marca) {
            $this->marca = $marca;
        }
        public function setmodelo($modelo) {
            $this->modelo = $modelo;
        }
        public function setColor($color) {
            $this->color = $color;
        }
        public function setA_fabricacion($A_fabricacion) {
            $this->A_fabricacion = $A_fabricacion;
        }
        public function comprobarNulidad($comprobarNulidad) {
            if(is_null($comprobarNulidad)==true||$comprobarNulidad=="NULL"){
                $comprobarNulidad = "";
            }
            return $comprobarNulidad;
        }   
    }