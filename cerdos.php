<?php

session_start();

if (!isset($_SESSION['usuario_id'])) {
    header('Location: registro.php');
    exit();
}

$db_host = 'localhost';
$db_name = 'digihog_ranch'; 
$db_user = 'root';
$db_pass = ''; 

try {
    $pdo = new PDO("mysql:host=$db_host;dbname=$db_name;charset=utf8mb4", $db_user, $db_pass);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    
    require_once 'controllers/CerdoController.php';
    $controller = new CerdoController($pdo, $_SESSION['granja_id']);
    $controller->procesar();

} catch (PDOException $e) {
    die("Error de infraestructura al cargar el inventario genético.");
}