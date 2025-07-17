<?php
session_start();
require_once 'clases/conexion.php';
require_once 'clases/hoteles.php';

if (!isset($_SESSION['cliente'])) {
    $_SESSION['redirigir_despues'] = $_SERVER['REQUEST_URI'];
    header('Location: cibernauta/loginCiber.php');
    exit();
}

$hotelId = isset($_GET['hotel_id']) ? intval($_GET['hotel_id']) : 0;

$pdo = BD::conectar();
$hotelModel = new Hotel($pdo);
$hotel = $hotelModel->obtenerHotelPorId($hotelId);

if (!$hotel) {
    header('Location: index.php');
    exit();
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Reservar hotel</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<?php include 'includes/header.php'; ?>
<div class="container py-5">
    <h2>Reservar: <?= htmlspecialchars($hotel['titulo']) ?></h2>

    <form method="POST" action="procesarReserva.php">
        <input type="hidden" name="hotel_id" value="<?= $hotel['id'] ?>">

        <div class="mb-3">
            <label>Fecha de entrada</label>
            <input type="date" name="fecha_entrada" class="form-control" required>
        </div>

        <div class="mb-3">
            <label>Fecha de salida</label>
            <input type="date" name="fecha_salida" class="form-control" required>
        </div>

        <div class="mb-3">
            <label>Personas</label>
            <input type="number" name="personas" min="1" class="form-control" value="1" required>
        </div>

        <button type="submit" class="btn btn-primary">Confirmar reserva</button>
        <a href="detalleHotel.php?id=<?= $hotelId ?>" class="btn btn-secondary">Cancelar</a>
    </form>
</div>
    <?php include 'includes/footer.php'; ?>

</body>
</html>
