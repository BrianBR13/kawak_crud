<?php
namespace App\Controllers;

use App\Models\Documento;

class DocumentoController {
    private $modelo;

    public function __construct($db) {
        $this->modelo = new Documento($db);
    }

    public function guardar($datos) {
        // 1. Generar el código único antes de insertar [cite: 22, 31]
        $nuevoCodigo = $this->modelo->generarNuevoCodigo($datos['id_tipo'], $datos['id_proceso']);
        
        // 2. Insertar en la base de datos [cite: 30]
        return $this->modelo->crear($datos, $nuevoCodigo);
    }
}