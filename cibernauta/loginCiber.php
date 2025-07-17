<?php
session_start();
require_once '../clases/conexion.php';
require_once '../clases/cibernauta.php';
require_once '../clases/sanitizar.php';

$pdo = BD::conectar();
$clienteModel = new Cibernauta($pdo);

$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $correo = Sanitizer::sanitizeEmail($_POST['correo']);
    $clave  = $_POST['clave'];

    if (!Sanitizer::isValidEmail($correo)) {
        $error = 'Correo no válido.';
    } else {
        $cliente = $clienteModel->verificarLogin($correo, $clave);

        if ($cliente) {
            $_SESSION['cliente'] = $cliente;

            if (isset($_SESSION['redirigir_despues'])) {
                $destino = $_SESSION['redirigir_despues'];
                unset($_SESSION['redirigir_despues']);
                header("Location: $destino");
                exit();
            }

            header('Location: ../index.php');
            exit();
        } else {
            $error = 'Correo o contraseña incorrectos.';
        }
    }
}
?>


<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Iniciar sesión</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
<div class="container py-5">
    <h2 class="mb-4">Iniciar sesión</h2>

    <?php if ($error): ?>
        <div class="alert alert-danger"><?= htmlspecialchars($error) ?></div>
    <?php endif; ?>

    <form method="POST">
        <div class="mb-3">
            <label>Correo electrónico</label>
            <input type="email" name="correo" class="form-control" required>
        </div>
        <div class="mb-3">
            <label>Contraseña</label>
            <input type="password" name="clave" class="form-control" required>
        </div>
        <button type="submit" class="btn btn-primary">Iniciar sesión</button>
        <a href="registro.php" class="btn btn-link">¿No tienes cuenta? Regístrate</a>
    </form>
</div>
</body>
</html>
