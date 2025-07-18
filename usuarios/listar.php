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
    <a href="agrega.php" class="btn btn-sm btn-primary">Agregar Usuario</a>




    <h2>Lista de Usuarios</h2>
    <table class="table table-bordered">
        <thead><tr><th>Nombre</th><th>Cedula</th><th>Email</th><th>Rol</th><th>Activo</th><th>Acciones</th></tr></thead>
        <tbody>
            <?php foreach ($usuarios as $u): ?>
            <tr>
                <td><?= ($u['nombre']) ?></td>
                <td><?= ($u['cedula']) ?></td>
                <td><?= ($u['email']) ?></td>
                <td><?= ($u['rol']) ?></td>
                <td><?= $u['activo'] ? 'Sí' : 'No' ?></td>
                <td>
                    <a href="agrega.php?editar=<?= $u['id'] ?>" class="btn btn-sm btn-warning">Editar</a>
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