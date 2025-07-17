<?php
require_once 'clases/conexion.php';
require_once 'clases/hoteles.php';

try {
    $pdo = BD::conectar();
    $hotelModel = new Hotel($pdo);

    $hoteles = $hotelModel->obtenerPublicados();

} catch (Exception $e) {
    $error = "Error al cargar hoteles: " . $e->getMessage();
}

?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Hoteles Disponibles</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <?php include 'includes/header.php'; ?>

    <div class="container mt-4">
        <div class="row">
            <div class="col-12">
                <h1 class="text-center mb-4">Hoteles Disponibles</h1>
                
                <?php if (isset($error)): ?>
                    <div class="alert alert-danger"><?= ($error) ?></div>
                <?php endif; ?>
                
                <?php if (empty($hoteles)): ?>
                    <div class="alert alert-info text-center">
                        <h4>No hay hoteles disponibles</h4>
                        <p>Vuelve más tarde para ver nuestras ofertas.</p>
                    </div>
                <?php else: ?>
                    <div class="row">
                        <?php foreach ($hoteles as $hotel): ?>
                            <div class="col-lg-4 col-md-6 mb-4">
                                <div class="card shadow-sm h-100">
                                    <!-- Imagen del hotel -->
                                    <?php if ($hotel['imagen_principal']): ?>
                                        <img src="<?= ($hotel['imagen_principal']) ?>" 
                                             class="card-img-top" 
                                             style="height: 200px; object-fit: cover;"
                                             alt="<?= ($hotel['titulo']) ?>">
                                    <?php else: ?>
                                        <div class="card-img-top bg-light d-flex align-items-center justify-content-center" 
                                             style="height: 200px;">
                                            <span class="text-muted">Sin imagen</span>
                                        </div>
                                    <?php endif; ?>
                                    
                                    <div class="card-body d-flex flex-column">
                                        <h5 class="card-title"><?= ($hotel['titulo']) ?></h5>
                                        
                                        <div class="mb-2">
                                            <small class="text-muted">
                                                📍 <?= ($hotel['ubicacion']) ?>, <?= ($hotel['provincia']) ?>
                                            </small>
                                        </div>
                                        
                                        <p class="card-text flex-grow-1">
                                            <?= (substr($hotel['descripcion'], 0, 100)) ?>
                                            <?= strlen($hotel['descripcion']) > 100 ? '...' : '' ?>
                                        </p>
                                        
                                        <?php if ($hotel['autor']): ?>
                                            <small class="text-muted mb-2">Por: <?= ($hotel['autor']) ?></small>
                                        <?php endif; ?>
                                        
                                        <div class="d-flex justify-content-between align-items-center mt-auto">
                                            <span class="badge bg-primary fs-6">$<?= number_format($hotel['costo'], 2) ?>/noche</span>
                                            <a href="detalleHotel.php?id=<?= $hotel['id'] ?>" class="btn btn-primary btn-sm">
                                                Ver Detalles
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <?php include 'includes/footer.php'; ?>
</body>
</html>