<?php
// clases/Cliente.php
class Cibernauta {
    private $pdo;

    public function __construct($pdo) {
        $this->pdo = $pdo;
    }

    // Registrar un nuevo cliente
    public function registrar($nombre, $correo, $telefono, $clave) {
        $hash = password_hash($clave, PASSWORD_BCRYPT);

        $stmt = $this->pdo->prepare("
            INSERT INTO clientes (nombre, correo, telefono, contraseña)
            VALUES (?, ?, ?, ?)
        ");
        return $stmt->execute([$nombre, $correo, $telefono, $hash]);
    }

    // Verificar login
    public function verificarLogin($correo, $clave) {
        $stmt = $this->pdo->prepare("
            SELECT * FROM clientes WHERE correo = ?
        ");
        $stmt->execute([$correo]);
        $cliente = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($cliente && password_verify($clave, $cliente['contraseña'])) {
            return $cliente;
        }

        return false;
    }

    // Obtener cliente por ID (opcional)
    public function obtenerPorId($id) {
        $stmt = $this->pdo->prepare("
            SELECT * FROM clientes WHERE id = ?
        ");
        $stmt->execute([$id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
}
