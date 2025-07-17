<?php require 'crud.php'; ?>

<!DOCTYPE html>
<html lang="es">
<head>
    <title>Usuarios</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body >
    <?php include '../includes/nav.php'; ?>
    <div class="container mt-5">
    <?php if (!empty($mensaje)): ?>
        <div class="alert alert-info"><?= $mensaje ?></div>
    <?php endif; ?>

    <hr>
    <h3><?= $modo === 'editar' ? 'Editar Usuario' : 'Agregar Usuario' ?></h3>

    <form method="POST" action="">
        <input type="hidden" name="id" value="<?= $usuario['id'] ?>">
        <div class="mb-2">
            <label>Nombre:</label>
            <input type="text" name="nombre" class="form-control" required value="<?= ($usuario['nombre']) ?>">
        </div>
        <div class="mb-2">
            <label>Rol:</label>
            <select name="rol" class="form-control" required>
                <option value="admin" <?= ($usuario['rol'] ?? '') === 'admin' ? 'selected' : '' ?>>Administrador</option>
                <option value="usuario" <?= ($usuario['rol'] ?? '') === 'usuario' ? 'selected' : '' ?>>Usuario</option>
            </select>
        </div>

        <div class="mb-2">
            <label>Email:</label>
            <input type="email" name="email" class="form-control" required value="<?= ($usuario['email']) ?>">
        </div>
        <div class="mb-2">
            <label><?= $modo === 'editar' ? 'Nueva Contraseña (opcional):' : 'Contraseña:' ?></label>
            <input type="password" name="password" class="form-control" <?= $modo === 'crear' ? 'required' : '' ?>>
        </div>
        <button type="submit" name="<?= $modo === 'editar' ? 'actualizar' : 'guardar' ?>" class="btn btn-primary">
            <?= $modo === 'editar' ? 'Actualizar' : 'Guardar' ?>
        </button>
    </form>


    <h2>Lista de Usuarios</h2>
    <table class="table table-bordered">
        <thead><tr><th>Nombre</th><th>Email</th><th>Activo</th><th>Acciones</th></tr></thead>
        <tbody>
            <?php foreach ($usuarios as $u): ?>
            <tr>
                <td><?= ($u['nombre']) ?></td>
                <td><?= ($u['email']) ?></td>
                <td><?= $u['activo'] ? 'Sí' : 'No' ?></td>
                <td>
                    <a href="?editar=<?= $u['id'] ?>" class="btn btn-sm btn-warning">Editar</a>
                    <a href="?cambiar=<?= $u['id'] ?>" class="btn btn-sm <?= $u['activo'] ? 'btn-danger' : 'btn-success' ?>">
                        <?= $u['activo'] ? 'Dar de baja' : 'Activar' ?>
                    </a>
                </td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
    </div>
</body>
</html>