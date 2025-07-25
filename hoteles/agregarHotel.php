<?php
session_start();
require_once '../clases/conexion.php';
require_once '../clases/hoteles.php';

$pdo = BD::conectar();
$mensaje = '';
$error = '';

// Crear instancia de la clase Hotel
$hotel = new Hotel($pdo);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    try {
        // Validar campos requeridos manualmente antes de enviar a la clase
        $titulo = trim($_POST['titulo'] ?? '');
        $descripcion = trim($_POST['descripcion'] ?? '');
        $ubicacion = trim($_POST['ubicacion'] ?? '');
        $provincia = trim($_POST['provincia'] ?? '');
        $costo = $_POST['costo'] ?? '';
        $autor = trim($_POST['autor'] ?? '');
        $publicar = isset($_POST['publicar']) ? (int)$_POST['publicar'] : 0;
        $tiposHabitacion = trim($_POST['tipos_habitacion'] ?? '');
        $wifi = isset($_POST['wifi']) ? 1 : 0;
        $piscina = isset($_POST['piscina']) ? 1 : 0;
        $parking = isset($_POST['parking']) ? 1 : 0;
        $gimnasio = isset($_POST['gimnasio']) ? 1 : 0;
        $restaurante = isset($_POST['restaurante']) ? 1 : 0;
        $servicio_habitaciones = isset($_POST['servicio_habitaciones']) ? 1 : 0;

        if ($tiposHabitacion === '') {
            throw new Exception("Debe ingresar al menos un tipo de habitación.");
        }


        if (empty($titulo) || empty($descripcion) || empty($ubicacion) || empty($provincia) || $costo === '') {
            throw new Exception("Todos los campos obligatorios deben ser completados");
        }

        if (!is_numeric($costo) || $costo < 0) {
            throw new Exception("El costo debe ser un número válido mayor a 0");
        }

        if (!isset($_FILES['imagenes']) || empty($_FILES['imagenes']['tmp_name'][0])) {
            throw new Exception("Debe subir al menos una imagen");
        }

        // Preparar datos para enviar a la clase
      // Preparar datos para enviar a la clase
        $datos = [
            'titulo' => $titulo,
            'descripcion' => $descripcion,
            'ubicacion' => $ubicacion,
            'provincia' => $provincia,
            'costo' => $costo,
            'autor' => $autor,
            'publicar' => $publicar,
            'tipos_habitacion' => $tiposHabitacion,
            'wifi' => $wifi,
            'piscina' => $piscina,
            'parking' => $parking,
            'gimnasio' => $gimnasio,
            'restaurante' => $restaurante,
            'servicio_habitaciones' => $servicio_habitaciones,
        ];



        $resultado = $hotel->agregar($datos, $_FILES['imagenes']);

        if ($resultado['ok']) {
            $_SESSION['mensaje'] = $resultado['mensaje'];
            header("Location: menu.php");
            exit(); 
        }


    } catch (Exception $e) {
        $error = "❌ Error: " . $e->getMessage();
    }
}
?>


<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Agregar Hotel</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

</head>
<body>
<?php include '../includes/nav.php'; ?>
<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card shadow">
                <div class="card-header">
                    <h2 class="mb-0">🏨 Agregar Nuevo Hotel</h2>
                </div>
                <div class="card-body">
                    <?php if ($mensaje): ?>
                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                            <?= ($mensaje) ?>
                            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                        </div>
                    <?php endif; ?>

                    <?php if ($error): ?>
                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                            <?= ($error) ?>
                            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                        </div>
                    <?php endif; ?>

                    <form method="POST" enctype="multipart/form-data" id="hotelForm">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label class="form-label">Título del Hotel <span class="text-danger">*</span></label>
                                    <input name="titulo" class="form-control" required 
                                           value="<?= ($_POST['titulo'] ?? '') ?>">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label class="form-label">Costo por noche <span class="text-danger">*</span></label>
                                    <div class="input-group">
                                        <span class="input-group-text">$</span>
                                        <input name="costo" class="form-control" type="number" step="0.01" min="0" required
                                               value="<?= ($_POST['costo'] ?? '') ?>">
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Descripción <span class="text-danger">*</span></label>
                            <textarea name="descripcion" class="form-control" rows="4" required 
                                      placeholder="Describe las características y servicios del hotel..."><?= ($_POST['descripcion'] ?? '') ?></textarea>
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label class="form-label">Ubicación <span class="text-danger">*</span></label>
                                    <input name="ubicacion" class="form-control" required 
                                           value="<?= ($_POST['ubicacion'] ?? '') ?>"
                                           placeholder="Dirección exacta del hotel">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label class="form-label">Provincia <span class="text-danger">*</span></label>
                                    <input name="provincia" class="form-control" required 
                                           value="<?= ($_POST['provincia'] ?? '') ?>">
                                </div>
                            </div>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Autor (opcional)</label>
                            <input name="autor" class="form-control" 
                                   value="<?= ($_POST['autor'] ?? '') ?>"
                                   placeholder="Nombre del autor o fuente">
                        </div>
                        <div class="mb-3">
                            <label for="tipos_habitacion" class="form-label">Tipos de habitación (separados por coma)</label>
                            <input type="text" name="tipos_habitacion" id="tipos_habitacion" class="form-control" placeholder="Ejemplo: Sencilla,Doble,Suite" required>
                            <small class="form-text text-muted">Ingrese los tipos separados por coma</small>
                        </div>
                        <div class="d-flex flex-wrap gap-3 align-items-center">
                            <div class="form-check d-flex align-items-center">
                                <input type="checkbox" class="form-check-input" id="wifi" name="wifi" value="1" onchange="toggleInfo('wifi-info')">
                                <label class="form-check-label ms-1" for="wifi">Wifi</label>
                            </div>

                            <div class="form-check d-flex align-items-center">
                                <input type="checkbox" class="form-check-input" id="piscina" name="piscina" value="1" onchange="toggleInfo('piscina-info')">
                                <label class="form-check-label ms-1" for="piscina">Piscina</label>
                                
                            </div>

                            <div class="form-check d-flex align-items-center">
                                <input type="checkbox" class="form-check-input" id="parking" name="parking" value="1" onchange="toggleInfo('parking-info')">
                                <label class="form-check-label ms-1" for="parking">Parking</label>
                                
                            </div>

                            <div class="form-check d-flex align-items-center">
                                <input type="checkbox" class="form-check-input" id="gimnasio" name="gimnasio" value="1" onchange="toggleInfo('gimnasio-info')">
                                <label class="form-check-label ms-1" for="gimnasio">Gimnasio</label>
                                
                            </div>

                            <div class="form-check d-flex align-items-center">
                                <input type="checkbox" class="form-check-input" id="restaurante" name="restaurante" value="1" onchange="toggleInfo('restaurante-info')">
                                <label class="form-check-label ms-1" for="restaurante">Restaurante</label>
                            
                            </div>

                            <div class="form-check d-flex align-items-center">
                                <input type="checkbox" class="form-check-input" id="servicio_habitaciones" name="servicio_habitaciones" value="1" onchange="toggleInfo('servicio_habitaciones-info')">
                                <label class="form-check-label ms-1" for="servicio_habitaciones">Servicio de habitaciones</label>
                            
                            </div>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Imágenes del Hotel <span class="text-danger">*</span></label>

                            <div id="camposImagenes">
                                <div class="input-con-preview mb-3">
                                    <input type="file" name="imagenes[]" class="form-control" accept="image/*" required onchange="mostrarPrevia(event, this)">
                                    <div class="preview-img mt-2"></div>
                                </div>
                            </div>

                            <button type="button" class="btn btn-outline-primary btn-sm" onclick="agregarCampoImagen()">➕ Agregar otra imagen</button>

                            <div class="form-text mt-1">Puedes subir varias imágenes. Se permite JPG, PNG, GIF, WEBP. Máx. 5MB por imagen.</div>
                        </div>



                        <!-- Campo oculto para el estado de publicación -->
                        <input type="hidden" name="publicar" id="publicarField" value="0">

                        <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                            <button type="reset" class="btn btn-secondary">Limpiar</button>
                            <button type="button" class="btn btn-primary" onclick="confirmarPublicacion()">
                                💾 Guardar Hotel
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script src="../assets/js/agregarHotel.js"></script>

<?php include '../includes/footer.php'; ?>
</body>
</html>