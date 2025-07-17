<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
?>
<header>
  <nav class="navbar navbar-expand-lg navbar-dark bg-primary">
    <div class="container">
      <a class="navbar-brand" href="index.php">
        🏨 Hoteles Panamá
      </a>
      <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarContenido" aria-controls="navbarContenido" aria-expanded="false" aria-label="Menú">
        <span class="navbar-toggler-icon"></span>
      </button>

      <div class="collapse navbar-collapse" id="navbarContenido">
        <ul class="navbar-nav ms-auto">
          <li class="nav-item">
            <a class="nav-link active" aria-current="page" href="/ProyectoHoteles/index.php">Inicio</a>
          </li>
         
          
          <?php if (isset($_SESSION['cliente'])): ?>
            <li class="nav-item">
              <a class="nav-link" href="misReservas.php">Mis Reservas</a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="#">
                👤 <?= htmlspecialchars($_SESSION['cliente']['nombre']) ?>
              </a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="cibernauta/logout.php">Cerrar sesión</a>
            </li>
          <?php else: ?>
            <li class="nav-item">
              <a class="nav-link" href="cibernauta/loginCiber.php">Iniciar sesión</a>
            </li>
          <?php endif; ?>

        </ul>
      </div>
    </div>
  </nav>
</header>
