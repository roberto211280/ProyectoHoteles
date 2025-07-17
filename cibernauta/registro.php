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
    <meta charset="UTF-8" />
    <title>Registro</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" />
</head>
<body class="bg-light d-flex align-items-center justify-content-center" style="min-height: 100vh;">
    

    <div class="card shadow-sm p-4" style="max-width: 450px; width: 100%;">
        <h2 class="text-center mb-4 text-primary fw-bold">Registro de usuario</h2>

        <?php if ($mensaje): ?>
            <div class="alert alert-info"><?=($mensaje) ?></div>
        <?php endif; ?>

        <form method="POST" novalidate>
            <div class="mb-3">
                <label for="nombre" class="form-label">Nombre completo</label>
                <input type="text" class="form-control" id="nombre" name="nombre" required autofocus>
            </div>

            <div class="mb-3">
                <label for="correo" class="form-label">Correo electrónico</label>
                <input type="email" class="form-control" id="correo" name="correo" required>
            </div>

            <div class="mb-3">
                <label for="telefono" class="form-label">Teléfono</label>
                <input type="text" class="form-control" id="telefono" name="telefono" required>
            </div>

            <div class="mb-3">
                <label for="clave" class="form-label">Contraseña</label>
                <input type="password" class="form-control" id="clave" name="clave" required>
            </div>

            <div class="mb-3">
                <label for="clave_confirmar" class="form-label">Confirmar contraseña</label>
                <input type="password" class="form-control" id="clave_confirmar" name="clave_confirmar" required>
            </div>

            <button type="submit" class="btn btn-primary w-100 fw-semibold">Registrarme</button>
        </form>

        <div class="mt-3 text-center">
            <a href="loginCiber.php" class="text-decoration-none text-primary fw-semibold">¿Ya tienes cuenta? Inicia sesión</a>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>

