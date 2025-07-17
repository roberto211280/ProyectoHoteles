<?php
session_start();

if (!isset($_SESSION['cliente'])) {
    header("Location: cibernauta/loginCiber.php");
    exit();
}

require_once 'clases/conexion.php';
require_once 'clases/Reserva.php';

$clienteId = $_SESSION['cliente']['id'];
$pdo = BD::conectar();
$reservaModel = new Reserva($pdo);
$reservas = $reservaModel->obtenerPorCliente($clienteId);
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Mis reservas</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<?php include 'includes/header.php'; ?>
<div class="container py-5">
    <h2 class="mb-4">Mis Reservas</h2>

    <?php if (isset($_GET['ok'])): ?>
        <div class="alert alert-success">✅ Reserva realizada con éxito.</div>
    <?php endif; ?>

    <?php if (empty($reservas)): ?>
        <div class="alert alert-info">No tienes reservas registradas aún.</div>
    <?php else: ?>
        <div class="table-responsive">
            <table class="table table-bordered table-hover align-middle">
                <thead class="table-dark">
                    <tr>
                        <th>Hotel</th>
                        <th>Ubicación</th>
                        <th>Entrada</th>
                        <th>Salida</th>
                        <th>Personas</th>
                        <th>Reservado el</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($reservas as $reserva): ?>
                        <tr>
                            <td><?= htmlspecialchars($reserva['titulo']) ?></td>
                            <td><?= htmlspecialchars($reserva['ubicacion']) ?>, <?= htmlspecialchars($reserva['provincia']) ?></td>
                            <td><?= date('d/m/Y', strtotime($reserva['fecha_entrada'])) ?></td>
                            <td><?= date('d/m/Y', strtotime($reserva['fecha_salida'])) ?></td>
                            <td><?= $reserva['personas'] ?></td>
                            <td><?= date('d/m/Y H:i', strtotime($reserva['fecha_reserva'])) ?></td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    <?php endif; ?>

    <a href="index.php" class="btn btn-secondary mt-3">Volver al inicio</a>
</div>
    <?php include 'includes/footer.php'; ?>

</body>
</html>
