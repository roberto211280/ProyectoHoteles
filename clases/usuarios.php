<?php
class Usuario {
    private $pdo;

    public function __construct($pdo) {
        $this->pdo = $pdo;
    }

    public function listar() {
        $stmt = $this->pdo->query("SELECT * FROM usuarios");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function obtener($id) {
        $stmt = $this->pdo->prepare("SELECT * FROM usuarios WHERE id = ?");
        $stmt->execute([$id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function crear($nombre, $email, $password, $rol, $cedula = 'usuario') {
        $hash = password_hash($password, PASSWORD_DEFAULT);
        $stmt = $this->pdo->prepare("INSERT INTO usuarios (nombre, email, password, activo, rol, cedula) VALUES (?, ?, ?, 1, ?, ?)");
        return $stmt->execute([$nombre, $email, $hash, $rol, $cedula]);
    }

    public function actualizar($id, $nombre, $email, $cedula = null, $password = null, $rol = null) {
    $stmt = $this->pdo->prepare("UPDATE usuarios SET nombre = ?, email = ?, cedula = ? WHERE id = ?");
    $stmt->execute([$nombre, $email, $cedula, $id]);

    if (!empty($password)) {
        $hash = password_hash($password, PASSWORD_DEFAULT);
        $stmt = $this->pdo->prepare("UPDATE usuarios SET password = ? WHERE id = ?");
        $stmt->execute([$hash, $id]);
    }

    if ($rol !== null) {
        $stmt = $this->pdo->prepare("UPDATE usuarios SET rol = ? WHERE id = ?");
        $stmt->execute([$rol, $id]);
    }
}


    public function cambiarEstado($id) {
        $stmt = $this->pdo->prepare("UPDATE usuarios SET activo = NOT activo WHERE id = ?");
        return $stmt->execute([$id]);
    }

}
