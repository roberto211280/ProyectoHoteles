<?php
session_start();

if (!isset($_SESSION['cliente'])) {
    header("Location: cibernauta/loginCiber.php");
    exit();
}

require_once 'clases/conexion.php';
require_once 'clases/Reserva.php';

$clienteId = $_SESSION['cliente']['id'];
$hotelId = intval($_POST['hotel_id'] ?? 0);
$fechaEntrada = $_POST['fecha_entrada'] ?? '';
$fechaSalida = $_POST['fecha_salida'] ?? '';
$personas = intval($_POST['personas'] ?? 1);
$tipoHabitacion = trim($_POST['tipo_habitacion'] ?? '');

$habitaciones = 1; // O calcula según lógica tuya

if (!$hotelId || !$fechaEntrada || !$fechaSalida || $personas < 1 || empty($tipoHabitacion)) {
    die("Datos inválidos.");
}

$pdo = BD::conectar();
$reservaModel = new Reserva($pdo);

// Aquí puedes agregar validaciones según tipoHabitacion, personas, habitaciones, etc.

$exito = $reservaModel->crear($clienteId, $hotelId, $fechaEntrada, $fechaSalida, $personas, $habitaciones, $tipoHabitacion);

if ($exito) {
    header("Location: misReservas.php?ok=1");
    exit();
} else {
    die("Error al guardar la reserva.");
}
