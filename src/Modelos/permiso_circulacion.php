<?php
    class permiso_circulacion {
        private $estado_pago;
        private $fecha_pago;
        private $periodo;

        public function __construct($estado_pago, $fecha_pago, $periodo) {
            $this->estado_pago = $estado_pago;
            $this->fecha_pago = $fecha_pago;
            $this->periodo = $periodo;
        }
        public function setEstado($estado_pago){
            $this->estado_pago = $estado_pago;
        }
        public function getEstado(){
            return $this->estado_pago;
        }
        public function getFechaPago(){
            return $this->fecha_pago;
        }
        public function setFechaPago($fecha_pago){
            $this->fecha_pago = $fecha_pago;
        }
        public function getPeriodo(){
            return $this->periodo;
        }
        public function setPeriodo($periodo){
            $this->periodo = $periodo;
        }
    }