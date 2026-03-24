<?php
namespace App\Models;

use PDO;

class Documento {
    private $conn;
    private $table = "DOC_DOCUMENTO";

    public function __construct($db) {
        $this->conn = $db;
    }

    public function generarCodigo($id_tipo, $id_proceso) {
        // 1. Obtener los prefijos de las tablas maestras
        $sql = "SELECT 
                (SELECT TIP_PREFIJO FROM TIP_TIPO_DOC WHERE TIP_ID = :t) as t_pref,
                (SELECT PRO_PREFIJO FROM PRO_PROCESO WHERE PRO_ID = :p) as p_pref";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute(['t' => $id_tipo, 'p' => $id_proceso]);
        $prefs = $stmt->fetch(PDO::FETCH_ASSOC);

        // 2. Contar cuántos hay de esa combinación para el consecutivo
        $sqlCount = "SELECT COUNT(*) as total FROM " . $this->table . " 
                     WHERE DOC_ID_TIPO = :t AND DOC_ID_PROCESO = :p";
        $stmtCount = $this->conn->prepare($sqlCount);
        $stmtCount->execute(['t' => $id_tipo, 'p' => $id_proceso]);
        $count = $stmtCount->fetch(PDO::FETCH_ASSOC);
        
        $consecutivo = $count['total'] + 1;

        // Retorna: PREFIJO_TIPO-PREFIJO_PROCESO-CONSECUTIVO
        return $prefs['t_pref'] . "-" . $prefs['p_pref'] . "-" . $consecutivo;
    }

    public function guardar($datos, $codigo) {
        $sql = "INSERT INTO " . $this->table . " (DOC_NOMBRE, DOC_CODIGO, DOC_CONTENIDO, DOC_ID_TIPO, DOC_ID_PROCESO) 
                VALUES (:nom, :cod, :cont, :tipo, :proc)";
        $stmt = $this->conn->prepare($sql);
        return $stmt->execute([
            'nom'  => $datos['nombre'],
            'cod'  => $codigo,
            'cont' => $datos['contenido'],
            'tipo' => $datos['id_tipo'],
            'proc' => $datos['id_proceso']
        ]);
    }
}