<?php
namespace App\Models;

use PDO;

class Documento {
    private $conn;
    private $table = "DOC_DOCUMENTO";

    public function __construct($db) {
        $this->conn = $db;
    }

    // Funcion para armar el codigo automatico (ej: INS-ING-1)
    public function generarCodigo($id_tipo, $id_proceso) {
        // Traigo los prefijos de las tablas de tipos y procesos
        $sql = "SELECT 
                (SELECT TIP_PREFIJO FROM TIP_TIPO_DOC WHERE TIP_ID = :t) as t_pref,
                (SELECT PRO_PREFIJO FROM PRO_PROCESO WHERE PRO_ID = :p) as p_pref";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute(['t' => $id_tipo, 'p' => $id_proceso]);
        $prefijos = $stmt->fetch(PDO::FETCH_ASSOC);

        // Cuento cuantos registros hay de ese tipo y proceso para el numero final
        $sqlCount = "SELECT COUNT(*) as total FROM " . $this->table . " 
                     WHERE DOC_ID_TIPO = :t AND DOC_ID_PROCESO = :p";
        $stmtCount = $this->conn->prepare($sqlCount);
        $stmtCount->execute(['t' => $id_tipo, 'p' => $id_proceso]);
        $conteo = $stmtCount->fetch(PDO::FETCH_ASSOC);
        
        $numero = $conteo['total'] + 1;

        // Devuelve el codigo completo unido por guiones
        return $prefijos['t_pref'] . "-" . $prefijos['p_pref'] . "-" . $numero;
    }

    // Funcion para insertar el nuevo documento
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

    // Funcion para traer los documentos y que se vean en la tabla
    public function leerTodo($busqueda = "") {
        $query = "SELECT d.*, t.TIP_NOMBRE, p.PRO_NOMBRE 
                  FROM DOC_DOCUMENTO d
                  JOIN TIP_TIPO_DOC t ON d.DOC_ID_TIPO = t.TIP_ID
                  JOIN PRO_PROCESO p ON d.DOC_ID_PROCESO = p.PRO_ID";
        
        // Si el usuario escribio algo en el buscador
        if (!empty($busqueda)) {
            $query .= " WHERE d.DOC_NOMBRE LIKE :b OR d.DOC_CODIGO LIKE :b";
        }

        $stmt = $this->conn->prepare($query);
        if (!empty($busqueda)) {
            $termino = "%$busqueda%";
            $stmt->bindParam(':b', $termino);
        }
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Funcion para buscar un solo documento por su ID para editarlo
    public function buscarPorId($id) {
        $sql = "SELECT * FROM " . $this->table . " WHERE DOC_ID = :id";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute(['id' => $id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    // Funcion para guardar los cambios que se hicieron al editar
    public function actualizar($datos) {
        $sql = "UPDATE " . $this->table . " 
                SET DOC_NOMBRE = :nom, DOC_CONTENIDO = :cont 
                WHERE DOC_ID = :id";
        $stmt = $this->conn->prepare($sql);
        return $stmt->execute([
            'nom'  => $datos['nombre'],
            'cont' => $datos['contenido'],
            'id'   => $datos['id']
        ]);
    }

    // Funcion para borrar el registro
    public function eliminar($id) {
        $sql = "DELETE FROM " . $this->table . " WHERE DOC_ID = :id";
        $stmt = $this->conn->prepare($sql);
        return $stmt->execute(['id' => $id]);
    }
}