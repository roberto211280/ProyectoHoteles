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
    <meta charset="UTF-8" />
    <title>Iniciar sesión</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" />
</head>
<body class="bg-light d-flex align-items-center justify-content-center" style="height: 100vh;">

    <div class="card shadow-sm p-4" style="max-width: 400px; width: 100%;">
        <h2 class="text-center mb-4 text-primary fw-bold">Iniciar sesión</h2>

        <?php if ($error): ?>
            <div class="alert alert-danger"><?=($error) ?></div>
        <?php endif; ?>

        <form method="POST" novalidate>
            <div class="mb-3">
                <label for="correo" class="form-label">Correo electrónico</label>
                <input type="email" class="form-control" id="correo" name="correo" required autofocus>
            </div>

            <div class="mb-3">
                <label for="clave" class="form-label">Contraseña</label>
                <input type="password" class="form-control" id="clave" name="clave" required>
            </div>

            <button type="submit" class="btn btn-primary w-100 fw-semibold">Iniciar sesión</button>
        </form>

        <div class="mt-3 text-center">
            <a href="registro.php" class="text-decoration-none text-primary fw-semibold">¿No tienes cuenta? Regístrate</a>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
