<?php

session_start();

require_once 'clases/conexion.php';
require_once 'clases/hoteles.php';

$hotelId = isset($_GET['id']) ? intval($_GET['id']) : 0;

if ($hotelId == 0) {
    header('Location: index.php');
    exit();
}

try {
    $pdo = BD::conectar();
    $hotelModel = new Hotel($pdo);

    $hotel = $hotelModel->obtenerHotelPorId($hotelId);

    if (!$hotel) {
        header('Location: index.php');
        exit();
    }

    $imagenes = $hotelModel->obtenerImagenes($hotelId);

} catch (Exception $e) {
    $error = "Error al cargar el hotel: " . $e->getMessage();
}
?>


<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= ($hotel['titulo']) ?> - Detalles</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

</head>
<body>
    <?php include 'includes/header.php'; ?>

    <div class="container mt-4">
        <?php if (isset($error)): ?>
            <div class="alert alert-danger"><?= ($error) ?></div>
        <?php else: ?>
            <div class="row">
                <!-- Columna izquierda: Imágenes -->
                <div class="col-lg-8">
                    <?php if (!empty($imagenes)): ?>
                        <!-- Carousel principal -->
                        <div id="hotelCarousel" class="carousel slide mb-3" data-bs-ride="carousel">
                            <div class="carousel-inner">
                                <?php foreach ($imagenes as $index => $imagen): ?>
                                    <div class="carousel-item <?= $index == 0 ? 'active' : '' ?>">
                                        <img src="<?= ($imagen['ruta']) ?>" 
                                             class="d-block w-100" 
                                             style="height: 400px; object-fit: cover;"
                                             alt="<?= ($hotel['titulo']) ?>">
                                    </div>
                                <?php endforeach; ?>
                            </div>
                            
                            <?php if (count($imagenes) > 1): ?>
                                <button class="carousel-control-prev" type="button" data-bs-target="#hotelCarousel" data-bs-slide="prev">
                                    <span class="carousel-control-prev-icon"></span>
                                </button>
                                <button class="carousel-control-next" type="button" data-bs-target="#hotelCarousel" data-bs-slide="next">
                                    <span class="carousel-control-next-icon"></span>
                                </button>
                            <?php endif; ?>
                        </div>
                        
                        <!-- Thumbnails -->
                        <?php if (count($imagenes) > 1): ?>
                            <div class="row">
                                <?php foreach ($imagenes as $index => $imagen): ?>
                                    <div class="col-2 mb-2">
                                        <img src="<?= ($imagen['ruta']) ?>" 
                                             class="img-thumbnail w-100" 
                                             style="height: 80px; object-fit: cover; cursor: pointer;"
                                             onclick="goToSlide(<?= $index ?>)">
                                    </div>
                                <?php endforeach; ?>
                            </div>
                        <?php endif; ?>
                    <?php else: ?>
                        <div class="bg-light d-flex align-items-center justify-content-center" 
                             style="height: 400px;">
                            <span class="text-muted">Sin imágenes disponibles</span>
                        </div>
                    <?php endif; ?>
                    <div class="row mt-2">
                    <div class="col-12">
                        <div class="card shadow-sm">
                            <div class="card-body">
                                <h3 class="card-title">📝 Descripción</h3>
                                <p class="card-text lh-lg">
                                    <?= nl2br(($hotel['descripcion'])) ?>
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
                </div>
                
                <!-- Columna derecha: Información -->
                <div class="col-lg-4">
                    <div class="card shadow-sm">
                        <div class="card-body">
                            <h1 class="card-title"><?= ($hotel['titulo']) ?></h1>
                            
                            <div class="mb-3">
                                <strong>📍 Ubicación:</strong><br>
                                <?= ($hotel['ubicacion']) ?>, <?= ($hotel['provincia']) ?>
                            </div>
                            
                            <div class="mb-3">
                                <strong>💰 Precio:</strong><br>
                                <span class="fs-2 fw-bold text-primary">$<?= number_format($hotel['costo'], 2) ?></span>
                                <small class="text-muted">por noche</small>
                            </div>
                            <div class="mb-3">
                                <strong>Servicios:</strong><br>
                                <?php 
                                $servicios = [];
                                if (!empty($hotel['wifi'])) $servicios[] = 'WiFi';
                                if (!empty($hotel['piscina'])) $servicios[] = 'Piscina';
                                if (!empty($hotel['parking'])) $servicios[] = 'Parking';
                                if (!empty($hotel['gimnasio'])) $servicios[] = 'Gimnasio';
                                if (!empty($hotel['restaurante'])) $servicios[] = 'Restaurante';
                                if (!empty($hotel['servicio_habitaciones'])) $servicios[] = 'Servicio de habitaciones';

                                if (count($servicios) > 0) {
                                    echo implode(', ', $servicios);
                                } else {
                                    echo 'No hay servicios disponibles';
                                }
                                ?>
                            </div>

                            
                            <?php if ($hotel['autor']): ?>
                                <div class="mb-3">
                                    <strong>👤 Publicado por:</strong><br>
                                    <?= ($hotel['autor']) ?>
                                </div>
                            <?php endif; ?>
                            
                            <?php if ($hotel['fecha_creacion']): ?>
                                <div class="mb-3">
                                    <strong>📅 Fecha de publicación:</strong><br>
                                    <?= date('d/m/Y', strtotime($hotel['fecha_creacion'])) ?>
                                </div>
                            <?php endif; ?>

                            <div class="d-grid mt-4">
                                <?php if (isset($_SESSION['usuario']) || isset($_SESSION['cliente'])): ?>
                                    <a href="reservar.php?hotel_id=<?= $hotel['id'] ?>" class="btn btn-success btn-lg">
                                        🛎️ Reservar ahora
                                    </a>
                                <?php else: ?>
                                    <a href="cibernauta/loginCiber.php" class="btn btn-success btn-lg">
                                        🛎️ Reservar ahora
                                    </a>
                                <?php endif; ?>
                            </div>

                        </div>
                    </div>
                </div>   
                <!-- Botón de regreso -->
                <div class="row mt-4 mb-5">
                    <div class="col-12 text-center">
                        <a href="index.php" class="btn btn-secondary">
                            ← Volver a la lista de hoteles
                        </a>
                    </div>
                </div>
            <?php endif; ?>
        </div>
    </div>
    <?php include 'includes/footer.php'; ?>
                            
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    
    
</body>
</html>