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

if ($hotelId === 0) {
    header('Location: index.php');
    exit();
}

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
    <meta charset="UTF-8" />
    <title>Reservar hotel</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" />
</head>
<body>
<?php include 'includes/header.php'; ?>

<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-md-8 col-lg-6">
            <div class="card shadow">
                <div class="card-header bg-primary text-white">
                    <h4 class="mb-0">Reservar: <?= ($hotel['titulo']) ?></h4>
                </div>
                <div class="card-body">
                    <form method="POST" action="procesarReserva.php">
    <input type="hidden" name="hotel_id" value="<?= $hotel['id'] ?>">

    <div class="mb-3">
        <label for="tipo_habitacion" class="form-label">Tipo de habitación</label>
        <select name="tipo_habitacion" id="tipo_habitacion" class="form-control" required>
            <?php
            $tipos = explode(',', $hotel['tipos_habitacion']);
            foreach ($tipos as $tipo) {
                echo "<option value='" . (trim($tipo)) . "'>" . (trim($tipo)) . "</option>";
            }
            ?>
        </select>
    </div>


    <div class="mb-3">
        <label for="fecha_entrada" class="form-label">Fecha de entrada</label>
        <input type="date" name="fecha_entrada" id="fecha_entrada" class="form-control" required />
    </div>

    <div class="mb-3">
        <label for="fecha_salida" class="form-label">Fecha de salida</label>
        <input type="date" name="fecha_salida" id="fecha_salida" class="form-control" required />
    </div>

    <div class="mb-3">
        <label for="personas" class="form-label">Personas</label>
        <input type="number" name="personas" id="personas" min="1" max="2" value="1" class="form-control" required />
    </div>

    <button type="submit" class="btn btn-primary">Confirmar reserva</button>
</form>
                </div>
            </div>
        </div>
    </div>
</div>

<?php include 'includes/footer.php'; ?>

</body>
</html>

