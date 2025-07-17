<?php
session_start();

if (!isset($_SESSION['cliente'])) {
    header("Location: cibernauta/loginCiber.php");
    exit();
}

require_once 'clases/conexion.php';
require_once 'clases/Reserva.php';

$clienteId     = $_SESSION['cliente']['id'];
$hotelId       = isset($_POST['hotel_id']) ? intval($_POST['hotel_id']) : 0;
$fechaEntrada  = $_POST['fecha_entrada'] ?? '';
$fechaSalida   = $_POST['fecha_salida'] ?? '';
$personas      = isset($_POST['personas']) ? intval($_POST['personas']) : 1;

if (!$hotelId || !$fechaEntrada || !$fechaSalida || $personas < 1) {
    die("Datos inválidos.");
}

$pdo = BD::conectar();
$reservaModel = new Reserva($pdo);

$exito = $reservaModel->crear($clienteId, $hotelId, $fechaEntrada, $fechaSalida, $personas);

if ($exito) {
    header("Location: misReservas.php?ok=1");
    exit();
} else {
    die("Error al guardar la reserva.");
}
