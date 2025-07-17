<?php
require_once '../clases/conexion.php';
require_once '../clases/usuarios.php';
$pdo = BD::conectar();                 // conexión a la BD
$usuarioModel = new Usuario($pdo);    // objeto de tu clase

$modo = 'crear';
$usuario = ['id' => '', 'nombre' => '', 'email' => '', 'activo' => 1];
$mensaje = '';

if (isset($_GET['mensaje'])) {
    $mensaje = $_GET['mensaje'];
}

// Editar
if (isset($_GET['editar'])) {
    $usuario = $usuarioModel->obtener($_GET['editar']);
    $modo = 'editar';
}

// Guardar nuevo
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['guardar'])) {
    $nombre = trim($_POST['nombre']);
    $email = trim($_POST['email']);
    $password = $_POST['password'];
    $rol = $_POST['rol'];

    // Validaciones
    if (empty($nombre) || empty($email) || empty($password)) {
        $mensaje = "❌ Todos los campos son obligatorios.";
    } elseif (strlen($password) < 6) {
        $mensaje = "❌ La contraseña debe tener al menos 6 caracteres.";
    } else {
        try {
            $resultado = $usuarioModel->crear($nombre, $email, $password, $rol);

            if ($resultado) {
                $mensaje = "✅ Usuario '$nombre' creado exitosamente.";
                // Limpiar el formulario después de guardar
                $usuario = [
                    'id' => '',
                    'nombre' => '',
                    'email' => '',
                    'activo' => 1
                ];
                $modo = 'crear';
            }

        } catch (PDOException $e) {
            if ($e->getCode() == 23000) {
                $mensaje = "❌ Error: El email '$email' ya está registrado.";
            } else {
                $mensaje = "❌ Error al crear usuario: " . $e->getMessage();
            }
        }
    }
}



// Actualizar
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['actualizar'])) {
    $id = $_POST['id'];
    $nombre = trim($_POST['nombre']);
    $email = trim($_POST['email']);
    $password = !empty($_POST['password']) ? $_POST['password'] : null;
    $rol = $_POST['rol'];
    
    // Validaciones
    if (empty($nombre) || empty($email)) {
        $mensaje = "❌ Nombre y email son obligatorios.";
    } elseif (!empty($password) && strlen($password) < 6) {
        $mensaje = "❌ La contraseña debe tener al menos 6 caracteres.";
    } else {
        try {
            $resultado = $usuarioModel->actualizar($id, $nombre, $email, $password, $rol);
            if ($resultado) {
    header("Location: listar.php?mensaje=" . urlencode("✅ Usuario actualizado."));
    exit();
}

        } catch (PDOException $e) {
            if ($e->getCode() == 23000) {
                $mensaje = "❌ Error: El email '$email' ya está registrado por otro usuario.";
            } else {
                $mensaje = "❌ Error al actualizar usuario: " . $e->getMessage();
            }
        }
    }
}

// Cambiar estado
if (isset($_GET['cambiar'])) {
    $usuarioModel->cambiarEstado($_GET['cambiar']);
    header("Location: listar.php");
    exit;
}

// Listar
$usuarios = $usuarioModel->listar();
