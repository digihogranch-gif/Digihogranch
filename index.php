<?php

session_start(); 
require_once 'sesion_segura.php'; 
require_once 'config/conexion.php'; 

if (!isset($_SESSION['usuario_id'])) {
    header('Location: registro.php');
    exit();
}

$id_granja = $_SESSION['granja_id'];

try {
    $pdo = new PDO("mysql:host=$db_host;dbname=$db_name;charset=utf8mb4", $db_user, $db_pass);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    
    require_once 'controllers/CicloVidaController.php';
    $controller = new CicloVidaController($pdo, $id_granja);
    $controller->procesar();

} catch (PDOException $e) {
    error_log("Error de conexión BD: " . $e->getMessage());
    die("Error en el sistema: " . $e->getMessage());
}