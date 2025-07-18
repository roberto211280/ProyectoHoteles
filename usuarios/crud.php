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
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = $_POST['id'] ?? '';
    $accion = empty($id) ? 'registrar' : 'actualizar';

    $nombre = trim($_POST['nombre']);
    $email = trim($_POST['email']);
    $cedula = trim($_POST['cedula']);
    $password = $_POST['password'];
    $rol = $_POST['rol'];

    // Validaciones comunes
    if (empty($nombre) || empty($email) || ($accion === 'registrar' && empty($password))) {
        $mensaje = "❌ Todos los campos son obligatorios.";
    } elseif (!empty($password) && strlen($password) < 6) {
        $mensaje = "❌ La contraseña debe tener al menos 6 caracteres.";
    } else {
        try {
            switch ($accion) {
                case 'registrar':
                    $ok = $usuarioModel->crear($nombre, $email, $password, $rol, $cedula);
                    $mensaje = $ok ? "✅ Usuario '$nombre' creado exitosamente." : "❌ Error al crear el usuario.";
                    if ($ok) {
                        $usuario = ['id' => '', 'nombre' => '', 'email' => '', 'activo' => 1, 'cedula' => '', 'rol' => 'usuario'];
                        $modo = 'crear';
                    }
                    break;

                case 'actualizar':
                    $usuarioModel->actualizar($id, $nombre, $email, $cedula, !empty($password) ? $password : null, $rol);
                    $mensaje = "✅ Usuario '$nombre' actualizado exitosamente.";
                    $usuario = ['id' => '', 'nombre' => '', 'email' => '', 'activo' => 1, 'cedula' => '', 'rol' => 'usuario'];
                    $modo = 'crear';
                    break;

                default:
                    $mensaje = "❌ Acción no válida.";
                    break;
            }

        } catch (PDOException $e) {
            if ($e->getCode() == 23000) {
                $mensaje = "❌ Error: El email '$email' ya está registrado.";
            } else {
                $mensaje = "❌ Error en la base de datos: " . $e->getMessage();
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
