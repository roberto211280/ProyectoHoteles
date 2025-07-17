<?php
require_once '../conexion.php';
include '../includes/header.php';
if (!isset($_GET['id'])) {
    die("Hotel no especificado.");
}

$id = (int) $_GET['id'];
$pdo = BD::conectar();

$stmt = $pdo->prepare("SELECT * FROM hoteles WHERE id = ? AND activo = 1");
$stmt->execute([$id]);
$hotel = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$hotel) {
    die("Hotel no encontrado.");
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title><?= $hotel['nombre'] ?></title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<div class="container mt-5">
    <h2><?= $hotel['nombre'] ?></h2>
    <img src="../<?= $hotel['imagen_grande'] ?>" alt="Imagen grande de <?= $hotel['nombre'] ?>" class="img-fluid mb-4">
    <p><strong>Dirección:</strong> <?= $hotel['direccion'] ?></p>
    <p><?= $hotel['descripcion'] ?></p>

    <a href="../index.php" class="btn btn-secondary mt-3">← Volver al listado</a>
</div>
<?php include '../includes/footer.php'; ?>
</body>
</html>
