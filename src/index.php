<?php
// index.php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

require_once __DIR__ . '/controllers/AuthController.php';
require_once __DIR__ . '/controllers/AnimalController.php';

$rota = $_GET['rota'] ?? 'home';

$authController   = new AuthController();
$animalController = new AnimalController();

function requerLogin(): void {
    if (empty($_SESSION['usuario_id'])) {
        header('Location: index.php?rota=login');
        exit;
    }
}

switch ($rota) {
    case 'login':
        $erros = [];
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $erros = $authController->login($_POST);
            if (empty($erros)) {
                header('Location: index.php');
                exit;
            }
        }
        require __DIR__ . '/views/auth/login.php';
        break;

    case 'register':
        $erros = [];
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $erros = $authController->registrar($_POST);
            if (empty($erros)) {
                header('Location: index.php');
                exit;
            }
        }
        require __DIR__ . '/views/auth/register.php';
        break;

    case 'logout':
        $authController->logout();
        break;

    case 'animais_criar':
        requerLogin();
        $erros = [];
        $data  = $_POST;
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $erros = $animalController->criar($_POST);
            if (empty($erros)) {
                header('Location: index.php?msg=criado');
                exit;
            }
        }
        require __DIR__ . '/views/animais/criar.php';
        break;

    case 'animais_editar':
        requerLogin();
        $id = isset($_GET['id']) ? (int) $_GET['id'] : 0;
        $animal = $animalController->buscar($id);
        if (!$animal) {
            header('Location: index.php');
            exit;
        }
        $erros = [];
        $data  = $_POST;
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $erros = $animalController->atualizar($id, $_POST);
            if (empty($erros)) {
                header('Location: index.php?msg=atualizado');
                exit;
            }
        }
        require __DIR__ . '/views/animais/editar.php';
        break;

    case 'animais_deletar':
        requerLogin();
        $id = isset($_GET['id']) ? (int) $_GET['id'] : 0;
        if ($id > 0) {
            $animalController->deletar($id);
        }
        header('Location: index.php?msg=deletado');
        break;

    case 'home':
    default:
        requerLogin();
        $animais = $animalController->listar();
        $mensagemSucesso = null;
        if (!empty($_GET['msg'])) {
            if ($_GET['msg'] === 'criado') {
                $mensagemSucesso = 'Registro criado com sucesso.';
            } elseif ($_GET['msg'] === 'atualizado') {
                $mensagemSucesso = 'Registro atualizado com sucesso.';
            } elseif ($_GET['msg'] === 'deletado') {
                $mensagemSucesso = 'Registro removido com sucesso.';
            }
        }
        require __DIR__ . '/views/animais/listar.php';
        break;
}
