<?php
namespace App\Controllers;

use App\Models\Documento;

class DocumentoController {
    private $db;
    private $modelo;

    public function __construct($db) {
        $this->db = $db;
        $this->modelo = new Documento($db);
    }

    // Para cargar la pagina de crear documento
    public function mostrarFormulario() {
        $queryTipos = "SELECT TIP_ID, TIP_NOMBRE FROM TIP_TIPO_DOC";
        $queryProcesos = "SELECT PRO_ID, PRO_NOMBRE FROM PRO_PROCESO";
        
        $tipos = $this->db->query($queryTipos)->fetchAll(\PDO::FETCH_ASSOC);
        $procesos = $this->db->query($queryProcesos)->fetchAll(\PDO::FETCH_ASSOC);
        
        include __DIR__ . '/../../Views/crearDocumento.php';
    }

    // Para guardar la informacion del formulario
    public function crear($datos) {
        $codigoGenerado = $this->modelo->generarCodigo($datos['id_tipo'], $datos['id_proceso']);
        
        if ($this->modelo->guardar($datos, $codigoGenerado)) {
            header("Location: /KAWAK_CRUD/public/index.php?action=listar&success=1");
            exit();
        } else {
            echo "Error al intentar guardar el documento.";
        }
    }

    // Para mostrar la lista de documentos
    public function listar($busqueda = null) {
        $documentos = $this->modelo->leerTodo($busqueda);
        include __DIR__ . '/../../Views/documento_lista.php';
    }

    // Para abrir el formulario de edicion
    public function editar($id) {
        $documento = $this->modelo->buscarPorId($id);
        $tipos = $this->db->query("SELECT * FROM TIP_TIPO_DOC")->fetchAll(\PDO::FETCH_ASSOC);
        $procesos = $this->db->query("SELECT * FROM PRO_PROCESO")->fetchAll(\PDO::FETCH_ASSOC);
        
        include __DIR__ . '/../../Views/editarDocumento.php';
    }

    // Para guardar los cambios hechos al editar
    public function actualizar($datos) {
        if ($this->modelo->actualizar($datos)) {
            header("Location: /KAWAK_CRUD/public/index.php?action=listar");
        }
    }

    // Para borrar un documento
    public function borrar($id) {
        if ($this->modelo->eliminar($id)) {
            header("Location: /KAWAK_CRUD/public/index.php?action=listar");
        }
    }
}