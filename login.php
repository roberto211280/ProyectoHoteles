<?php
session_start();
require_once 'clases/conexion.php';

$mensaje = "";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $pdo = BD::conectar();
    $email = trim($_POST['email']);
    $password = $_POST['password'];
    
    if (empty($email) || empty($password)) {
        $mensaje = "Por favor complete todos los campos.";
    } else {
        $stmt = $pdo->prepare("SELECT * FROM usuarios WHERE email = ? AND activo = 1");
        $stmt->execute([$email]);
        $usuario = $stmt->fetch(PDO::FETCH_ASSOC);
        
        // DEBUG: Estas líneas te ayudarán a ver qué está pasando
        echo "Email recibido: " . $email . "<br>";
        echo "Contraseña escrita: '" . $password . "'<br>";
        
        if ($usuario) {
            echo "Usuario encontrado: " . $usuario['nombre'] . "<br>";
            echo "Hash en base de datos: '" . $usuario['password'] . "'<br>";

            
            if (password_verify($password, $usuario['password'])) {
                echo "✅ La contraseña coincide<br>";
                
                // Guardamos datos en sesión
                $_SESSION['usuario_id'] = $usuario['id'];
                $_SESSION['usuario_nombre'] = $usuario['nombre'];
                $_SESSION['usuario_rol'] = $usuario['rol'];
                
                // Redireccionamos según el rol
                if ($usuario['rol'] === 'admin') {
                    header("Location: usuarios/menu.php");
                } else {
                    header("Location: usuarios/menu.php");
                }
                exit;
            } else {
                echo "❌ La contraseña NO coincide<br>";
                $mensaje = "Correo o contraseña incorrectos.";
            }
        } else {
            echo "❌ Usuario no encontrado o inactivo<br>";
            $mensaje = "Correo o contraseña incorrectos.";
        }
        
        echo "<br><a href='login.php'>Volver a intentar</a>";
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Iniciar Sesión</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<div class="container mt-5" style="max-width: 400px;">
    <h3 class="text-center mb-4">Iniciar sesión</h3>
    
    <?php if (!empty($mensaje)): ?>
        <div class="alert alert-danger"><?= $mensaje ?></div>
    <?php endif; ?>
    
    <form method="POST" action="login.php">
        <div class="mb-3">
            <label for="email" class="form-label">Correo electrónico:</label>
            <input type="email" class="form-control" name="email" 
                   value="<?= isset($_POST['email']) ? ($_POST['email']) : '' ?>" required>
        </div>
        
        <div class="mb-3">
            <label for="password" class="form-label">Contraseña:</label>
            <input type="password" class="form-control" name="password" required>
        </div>
        
        <button type="submit" class="btn btn-primary w-100">Entrar</button>
    </form>
</div>
</body>
</html>