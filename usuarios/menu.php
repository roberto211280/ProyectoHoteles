<?php
session_start();
if (!isset($_SESSION['usuario_id'])) {
    header("Location: login.php");
    exit;
}
$rol = $_SESSION['usuario_rol'];
$nombre = $_SESSION['usuario_nombre'];
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Panel Principal</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>

<?php include '../includes/nav.php'; ?>

<div class="container">
    <div class="text-center mb-4">
        <h2>Bienvenido, <?= htmlspecialchars($nombre) ?> 👋</h2>
        <p class="lead">Tu rol es: <strong><?= $rol ?></strong></p>
    </div>

    <?php if ($rol === 'admin'): ?>
        <div class="row">
            <div class="col-md-6">
                <div class="card text-bg-info mb-3">
                    <div class="card-body">
                        <h5 class="card-title">Gestión de Usuarios</h5>
                        <p class="card-text">Administra los usuarios registrados.</p>
                        <a href="listar.php" class="btn btn-light">Ir al módulo</a>
                    </div>
                </div>
            </div>
        </div>
    <?php endif; ?>

    <div class="row">
        <div class="col-md-6">
            <div class="card text-bg-success mb-3">
                <div class="card-body">
                    <h5 class="card-title">Gestión de Hoteles</h5>
                    <p class="card-text">Consulta o agrega información de hoteles.</p>
                    <a href="../hoteles/menu.php" class="btn btn-light">Ir al módulo</a>
                </div>
            </div>
        </div>
    </div>
</div>

</body>
</html>
