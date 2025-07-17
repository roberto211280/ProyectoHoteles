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
        $datos = [
            'titulo' => $titulo,
            'descripcion' => $descripcion,
            'ubicacion' => $ubicacion,
            'provincia' => $provincia,
            'costo' => $costo,
            'autor' => $autor,
            'publicar' => $publicar
        ];

        $resultado = $hotel->agregar($datos, $_FILES['imagenes']);

        if ($resultado['ok']) {
            $mensaje = $resultado['mensaje'];
            $_POST = []; // limpiar formulario
        } else {
            throw new Exception($resultado['error']);
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
                            <?= htmlspecialchars($mensaje) ?>
                            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                        </div>
                    <?php endif; ?>

                    <?php if ($error): ?>
                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                            <?= htmlspecialchars($error) ?>
                            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                        </div>
                    <?php endif; ?>

                    <form method="POST" enctype="multipart/form-data" id="hotelForm">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label class="form-label">Título del Hotel <span class="text-danger">*</span></label>
                                    <input name="titulo" class="form-control" required 
                                           value="<?= htmlspecialchars($_POST['titulo'] ?? '') ?>">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label class="form-label">Costo por noche <span class="text-danger">*</span></label>
                                    <div class="input-group">
                                        <span class="input-group-text">$</span>
                                        <input name="costo" class="form-control" type="number" step="0.01" min="0" required
                                               value="<?= htmlspecialchars($_POST['costo'] ?? '') ?>">
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Descripción <span class="text-danger">*</span></label>
                            <textarea name="descripcion" class="form-control" rows="4" required 
                                      placeholder="Describe las características y servicios del hotel..."><?= htmlspecialchars($_POST['descripcion'] ?? '') ?></textarea>
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label class="form-label">Ubicación <span class="text-danger">*</span></label>
                                    <input name="ubicacion" class="form-control" required 
                                           value="<?= htmlspecialchars($_POST['ubicacion'] ?? '') ?>"
                                           placeholder="Dirección exacta del hotel">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label class="form-label">Provincia <span class="text-danger">*</span></label>
                                    <input name="provincia" class="form-control" required 
                                           value="<?= htmlspecialchars($_POST['provincia'] ?? '') ?>">
                                </div>
                            </div>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Autor (opcional)</label>
                            <input name="autor" class="form-control" 
                                   value="<?= htmlspecialchars($_POST['autor'] ?? '') ?>"
                                   placeholder="Nombre del autor o fuente">
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Imágenes del Hotel <span class="text-danger">*</span></label>
                            <input type="file" name="imagenes[]" class="form-control" multiple required
                                   accept="image/*" id="imageInput">
                            <div class="form-text">Formatos permitidos: JPG, PNG, GIF, WEBP. Máximo 5MB por imagen.</div>
                            <div id="imagePreview" class="d-flex flex-wrap gap-2 mt-2"></div>
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
<script>
// Función para confirmar publicación
function confirmarPublicacion() {
    const respuesta = confirm("¿Desea publicar el hotel inmediatamente?\n\nPresione 'Aceptar' para publicar ahora o 'Cancelar' para guardar como borrador.");
    
    // Establecer el valor según la respuesta
    document.getElementById('publicarField').value = respuesta ? '1' : '0';
    
    // Enviar el formulario
    document.getElementById('hotelForm').submit();
}

// Preview de imágenes
document.getElementById('imageInput').addEventListener('change', function(e) {
    const preview = document.getElementById('imagePreview');
    preview.innerHTML = '';
    
    for (let i = 0; i < e.target.files.length; i++) {
        const file = e.target.files[i];
        const reader = new FileReader();
        
        reader.onload = function(e) {
            const div = document.createElement('div');
            div.className = 'position-relative';
            div.style.width = '150px';
            div.style.height = '150px';
            div.innerHTML = `
                <img src="${e.target.result}" alt="Preview" class="w-100 h-100 object-fit-cover border rounded">
                <button type="button" class="btn btn-sm btn-danger position-absolute top-0 end-0 m-1 p-1 lh-1" 
                        onclick="removeImage(this)" style="width: 25px; height: 25px;">&times;</button>
            `;
            preview.appendChild(div);
        };
        
        reader.readAsDataURL(file);
    }
});

function removeImage(btn) {
    btn.parentElement.remove();
}
</script>

<?php include '../includes/footer.php'; ?>
</body>
</html>