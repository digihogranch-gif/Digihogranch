<?php
session_start();
if (!isset($_SESSION['rol']) || $_SESSION['rol'] !== 'admin') {
    header('Location: index.php');
    exit();
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Panel Administrativo - DigiHog Ranch</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600&family=Plus+Jakarta+Sans:wght@700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="css/style.css">
    <style>
        .admin-grid { display: grid; grid-template-columns: repeat(auto-fit, minmax(300px, 1fr)); gap: 20px; margin: 40px 0; }
        .admin-card { padding: 30px; background: #fff; border-radius: 12px; border: 1px solid #eee; text-align: center; box-shadow: 0 4px 6px rgba(0,0,0,0.03); transition: 0.3s; }
        .admin-card:hover { transform: translateY(-5px); border-color: #4e54c8; }
        .admin-card i { font-size: 3rem; color: #4e54c8; margin-bottom: 20px; }
        .admin-card h3 { margin-bottom: 15px; color: #2d3436; }
        .btn-admin { display: inline-block; padding: 10px 20px; background: #4e54c8; color: #fff; text-decoration: none; border-radius: 6px; font-weight: 600; margin-top: 15px; }
    </style>
</head>
<body>

    <header class="main-header">
        <div class="container header-wrap">
            <div class="logo-area">
                <div class="logo-icon"><i class="fa-solid fa-shield-halved"></i></div>
                <div class="logo-text">
                    <h1>DigiHog Admin</h1>
                    <p class="logo-status"><span class="pulse-dot"></span> Administrador: <?php echo htmlspecialchars($_SESSION['usuario_nombre']); ?></p>
                </div>
            </div>
            <a href="logout.php" class="btn-auth" style="background: #ff5e62;"><i class="fa-solid fa-right-from-bracket"></i> Cerrar Sesión</a>
        </div>
    </header>

    <nav class="main-nav">
        <div class="container">
            <div class="nav-links">
                
                <a href="gestionar_usuarios.php" class="nav-item"><i class="fa-solid fa-users"></i> Gestión Usuarios</a>
                <a href="gestionar_proveedores.php" class="nav-item"><i class="fa-solid fa-truck-field"></i> Gest. Proveedores</a>
                <a href="admin_marketplace.php" class="nav-item"><i class="fa-solid fa-store"></i> Marketplace</a>
                <a href="gestionar_planes.php" class="nav-item"><i class="fa-solid fa-store"></i> Gestion de planes</a>
               
            </div>
        </div>
    </nav>

    <main class="container main-content">
        <div class="welcome-banner">
            <span class="banner-tag">Consola de Administración</span>
            <h2>Control Centralizado</h2>
            <p>Bienvenido al panel maestro. Desde aquí puedes gestionar suscripciones y parámetros globales de DigiHog Ranch.</p>
        </div>

        <div class="admin-grid">
            <div class="admin-card">
                <i class="fa-solid fa-users-gear"></i>
                <h3>Gestión de Usuarios</h3>
                <p>Administrar cuentas de granjas activas y permisos de sistema.</p>
                <a href="gestionar_usuarios.php" class="btn-admin">Gestionar</a>
            </div>
            <div class="admin-card">
                <i class="fa-solid fa-handshake"></i>
                <h3>Gestión de Proveedores</h3>
                <p>Asignar planes Básico o Premium a los proveedores del marketplace.</p>
                <a href="gestionar_proveedores.php" class="btn-admin">Gestionar Planes</a>
            </div>
            <div class="admin-card">
                <i class="fa-solid fa-store"></i>
                <h3>Marketplace</h3>
                <p>Gestionar catálogo de insumos y servicios para los granjeros.</p>
                <a href="admin_marketplace.php" class="btn-admin">Administrar</a>
            </div>
            <div class="admin-card">
                <i class="fa-solid fa-database"></i>
                <h3>Mantenimiento BD</h3>
                <p>Ejecutar optimizaciones y respaldos de seguridad.</p>
                <a href="#" class="btn-admin">Ejecutar</a>
            </div>
        </div>
    </main>

    <footer class="main-footer">
        <div class="container">
            <p>&copy; <?php echo date('Y'); ?> DigiHog Ranch. Panel Administrativo de Control.</p>
        </div>
    </footer>

</body>
</html>