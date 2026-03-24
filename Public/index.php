<?php
require_once __DIR__ . '/../vendor/autoload.php';

use App\Config\Database;
use App\Controllers\DocumentoController;

// 1. Iniciar sesión SIEMPRE al principio
session_start();

$db = (new Database())->getConnection();
$controller = new DocumentoController($db);

// 2. Capturar la acción
$action = $_GET['action'] ?? 'listar';

// 3. BLOQUEO DE SEGURIDAD: Si no hay sesión y no va a loguearse, al login.
if (!isset($_SESSION['usuario']) && !in_array($action, ['login', 'autenticar'])) {
    header("Location: /KAWAK_CRUD/public/index.php?action=login");
    exit();
}

// 4. Enrutador con todos los casos solicitados
switch ($action) {
    case 'login':
        include __DIR__ . '/../Views/login.php';
        break;

    case 'autenticar':
        // Validación simple como pide el requerimiento
        if ($_POST['usuario'] === 'admin' && $_POST['password'] === '1234') {
            $_SESSION['usuario'] = 'admin';
            header("Location: /KAWAK_CRUD/public/index.php?action=listar");
        } else {
            echo "Usuario o contraseña incorrectos. <a href='?action=login'>Volver</a>";
        }
        break;

    case 'logout':
        session_destroy();
        header("Location: /KAWAK_CRUD/public/index.php?action=login");
        exit();

    case 'crear':
        $controller->mostrarFormulario();
        break;

    case 'guardar':
        $controller->crear($_POST);
        break;

    case 'eliminar':
        $controller->borrar($_GET['id']);
        break;

    case 'listar':
    default:
        $busqueda = $_GET['buscar'] ?? null;
        $controller->listar($busqueda);
        break;

        case 'editar':
    $controller->editar($_GET['id']);
    break;
case 'actualizar':
    $controller->actualizar($_POST);
    break;
}