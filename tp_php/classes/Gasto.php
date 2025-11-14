<?php
class Gasto {
    private $descripcion;
    private $monto;

    public function __construct($descripcion, $monto) {
        $this->descripcion = $descripcion;
        $this->monto = $monto;
    }

    public function getDescripcion() { return $this->descripcion; }
    public function getMonto() { return $this->monto; }

    public function setDescripcion($descripcion) { $this->descripcion = $descripcion; }
    public function setMonto($monto) { $this->monto = $monto; }

    public function toArray() {
        return [
            'descripcion' => $this->descripcion,
            'monto' => $this->monto
        ];
    }
    }
?>
