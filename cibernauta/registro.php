<?php
session_start();
require_once '../clases/conexion.php';
require_once '../clases/cibernauta.php';
require_once '../clases/sanitizar.php';

$pdo = BD::conectar();
$clienteModel = new Cibernauta($pdo);

$mensaje = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nombre   = Sanitizer::sanitizeString($_POST['nombre']);
    $correo   = Sanitizer::sanitizeEmail($_POST['correo']);
    $telefono = Sanitizer::sanitizeString($_POST['telefono']);
    $clave    = $_POST['clave'];
    $clave2   = $_POST['clave_confirmar'];

    // Validaciones
    if (!Sanitizer::isValidEmail($correo)) {
        $mensaje = "El correo no es válido.";
    } elseif (!Sanitizer::passwordsMatch($clave, $clave2)) {
        $mensaje = "Las contraseñas no coinciden.";
    } else {
        if ($clienteModel->registrar($nombre, $correo, $telefono, $clave)) {
            $mensaje = 'Registro exitoso. Ahora puedes iniciar sesión.';
        } else {
            $mensaje = 'Error al registrarse. ¿El correo ya está registrado?';
        }
    }
}
?>


<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Registro</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
<div class="container py-5">
    <h2 class="mb-4">Registro de usuario</h2>

    <?php if ($mensaje): ?>
        <div class="alert alert-info"><?= htmlspecialchars($mensaje) ?></div>
    <?php endif; ?>

    <form method="POST">
        <div class="mb-3">
            <label>Nombre completo</label>
            <input type="text" name="nombre" class="form-control" required>
        </div>
        <div class="mb-3">
            <label>Correo electrónico</label>
            <input type="email" name="correo" class="form-control" required>
        </div>
        <div class="mb-3">
            <label>Teléfono</label>
            <input type="text" name="telefono" class="form-control" required>
        </div>
        <div class="mb-3">
            <label>Contraseña</label>
            <input type="password" name="clave" class="form-control" required>
        </div>
        <div class="mb-3">
            <label>Confirmar contraseña</label>
            <input type="password" name="clave_confirmar" class="form-control" required>
        </div>

        <button type="submit" class="btn btn-primary">Registrarme</button>
        <a href="loginCiber.php" class="btn btn-link">¿Ya tienes cuenta? Inicia sesión</a>
    </form>
</div>
</body>
</html>
