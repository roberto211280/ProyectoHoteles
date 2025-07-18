<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
?>

<nav class="navbar navbar-expand-lg navbar-dark bg-dark mb-4">
    <div class="container">
        <a class="navbar-brand" href="/ProyectoHoteles/dashboard.php">Proyecto Hoteles</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav ms-auto">
                <?php if (isset($_SESSION['usuario_rol']) && $_SESSION['usuario_rol'] === 'admin'): ?>
                    <li class="nav-item">
                        <a class="nav-link" href="/ProyectoHoteles/usuarios/listar.php">👤Gestionar Usuarios</a>
                    </li>
                <?php endif; ?>

                <?php if (isset($_SESSION['usuario_id'])): ?>
                    <li class="nav-item">
                        <a class="nav-link" href="/ProyectoHoteles/usuarios/menu.php">👤 Usuarios</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="/ProyectoHoteles/hoteles/menu.php">🏨 Hoteles</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="/ProyectoHoteles/logout.php">🚪 Cerrar sesión</a>
                    </li>
                <?php else: ?>
                    <li class="nav-item">
                        <a class="nav-link" href="/ProyectoHoteles/login.php">🔐 Iniciar sesión</a>
                    </li>
                <?php endif; ?>
            </ul>
        </div>
    </div>
</nav>

