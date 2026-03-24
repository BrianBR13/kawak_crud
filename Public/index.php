<?php
require_once __DIR__ . '/../vendor/autoload.php';

use App\Config\Database;
use App\Controllers\DocumentoController;

$db = (new Database())->getConnection();
$controller = new DocumentoController($db);

$action = $_GET['action'] ?? 'listar';

if ($action === 'guardar') {
    $controller->crear($_POST);
} else {
    // Por ahora mostramos el formulario
    include __DIR__ . '/../Views/crear_documento.php';
}