<?php

session_start();


if (!isset($_SESSION['usuario_id'])) {
    header('Location: registro.php');
    exit();
}


require_once 'config/conexion.php';
/** @var PDO $pdo */


require_once 'gestor_planes.php';
restringirAcceso(2, $pdo, $_SESSION['granja_id']);


require_once 'controllers/RentabilidadController.php';
$controller = new RentabilidadController($pdo);
$controller->procesar();