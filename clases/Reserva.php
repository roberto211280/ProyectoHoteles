<?php
class Reserva {
    private $pdo;

    public function __construct($pdo) {
        $this->pdo = $pdo;
    }

    public function crear($clienteId, $hotelId, $fechaEntrada, $fechaSalida, $personas, $tipoHabitacion) {
    $stmt = $this->pdo->prepare("
        INSERT INTO reservas (cliente_id, hotel_id, fecha_entrada, fecha_salida, personas, fecha_reserva, tipo_habitacion)
        VALUES (?, ?, ?, ?, ?, NOW(), ?)
    ");
    return $stmt->execute([$clienteId, $hotelId, $fechaEntrada, $fechaSalida, $personas, $tipoHabitacion]);
    }


    public function obtenerPorCliente($clienteId) {
        $stmt = $this->pdo->prepare("
            SELECT r.*, h.titulo, h.costo, h.ubicacion, h.provincia
            FROM reservas r
            JOIN hoteles h ON r.hotel_id = h.id
            WHERE r.cliente_id = ?
            ORDER BY r.fecha_reserva DESC
        ");
        $stmt->execute([$clienteId]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}
?>
