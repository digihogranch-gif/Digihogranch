<?php
// 2. MANEJO DE ERRORES Y REGISTRO SEGURO (Desactivar errores en pantalla y registrar en log)
ini_set('display_errors', 0);
ini_set('display_startup_errors', 0);
error_reporting(E_ALL);
$log_dir = __DIR__ . '/logs';
if (!is_dir($log_dir)) { mkdir($log_dir, 0755, true); }
ini_set('error_log', $log_dir . '/app_security.log');

session_start();

// 5. MANEJO DE ESTADOS Y EXPIRACIÓN DE SESIÓN POR INACTIVIDAD (15 minutos = 900 segundos)
$tiempo_inactividad = 900; 
if (isset($_SESSION['ultimo_tiempo']) && (time() - $_SESSION['ultimo_tiempo'] > $tiempo_inactividad)) {
    session_unset();
    session_destroy();
    header('Location: registro.php?error=sesion_expirada');
    exit();
}
$_SESSION['ultimo_tiempo'] = time();

// 3. PROTECCIÓN DE RUTAS Y ROLES/PERMISOS
if (!isset($_SESSION['usuario_id'])) {
    header('Location: registro.php');
    exit();
}

// Control de roles autorizados para el módulo biométrico
$roles_permitidos = ['Administrador', 'Encargado', 'Operador', 'admin', 'usuario', 'Propietario'];
if (isset($_SESSION['rol']) && !in_array($_SESSION['rol'], $roles_permitidos)) {
    header('Location: index.php?error=acceso_denegado');
    exit();
}

// 4. DESARROLLO SEGURO: Generación de token anti-CSRF
if (empty($_SESSION['csrf_token'])) {
    $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
}

$db_host = 'localhost';
$db_name = 'digihog_ranch'; 
$db_user = 'root';
$db_pass = ''; 

$mensaje = "";
$tipo_alerta = "";

try {
    $pdo = new PDO("mysql:host=$db_host;dbname=$db_name;charset=utf8mb4", $db_user, $db_pass);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    $granja_id = $_SESSION['granja_id'] ?? 1;

    // Procesar el formulario cuando se guarda el pesaje
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        
        // Validación estricta de Token CSRF
        if (!isset($_POST['csrf_token']) || !hash_equals($_SESSION['csrf_token'], $_POST['csrf_token'])) {
            throw new Exception("Fallo de validación de seguridad CSRF.");
        }

        // 1. VALIDACIÓN Y SANITIZACIÓN DE ENTRADAS
        $arete = trim($_POST['arete'] ?? '');
        $id_lote = filter_input(INPUT_POST, 'id_lote', FILTER_VALIDATE_INT);
        $peso_registrado = filter_input(INPUT_POST, 'peso_registrado', FILTER_VALIDATE_FLOAT);
        $observaciones = trim($_POST['observaciones'] ?? '');

        // Comprobación rigurosa de tipos y rangos lógicos
        if (empty($arete) || $id_lote === false || $peso_registrado === false || $peso_registrado <= 0) {
            $mensaje = "Error de validación: Los datos ingresados no tienen el formato numérico o de arete correcto.";
            $tipo_alerta = "danger";
        } else {
            // Sanitización contra XSS en texto libre
            $observaciones = htmlspecialchars($observaciones, ENT_QUOTES, 'UTF-8');

            // Buscar el ID del cerdo usando sentencias preparadas (Protección contra Inyección SQL)
            $stmtCerdo = $pdo->prepare("SELECT id FROM cerdos WHERE codigo_arete = ? AND id_granja = ?");
            $stmtCerdo->execute([$arete, $granja_id]);
            $cerdo = $stmtCerdo->fetch(PDO::FETCH_ASSOC);

            if ($cerdo) {
                $id_cerdo = $cerdo['id'];
                
                // Se insertar en historial biométrico mediante PDO preparado
                $stmtInsert = $pdo->prepare("INSERT INTO historial_biometrico (id_cerdo, fecha_pesaje, peso_kg, observaciones) VALUES (?, NOW(), ?, ?)");
                $stmtInsert->execute([$id_cerdo, $peso_registrado, $observaciones]);

                $mensaje = "¡Pesaje registrado correctamente para el arete " . htmlspecialchars($arete, ENT_QUOTES, 'UTF-8') . "!";
                $tipo_alerta = "success";
            } else {
                $mensaje = "Error: No se encontró un cerdo registrado con el arete especificado en esta granja.";
                $tipo_alerta = "danger";
            }
        }
    }

    // Cargar lotes activos con PDO seguro
    $stmtLotes = $pdo->prepare("SELECT id, nombre_lote, etapa_actual FROM lotes WHERE id_granja = ? AND estado = 1");
    $stmtLotes->execute([$granja_id]);
    $lotes = $stmtLotes->fetchAll(PDO::FETCH_ASSOC);

} catch (Exception $e) {
    // Registro interno y silencioso del error técnico
    error_log("Error crítico en lecturapeso.php: " . $e->getMessage());
    $mensaje = "Ocurrió un error interno en el servidor al procesar la operación.";
    $tipo_alerta = "danger";
    $lotes = [];
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lectura de Peso | DigiHog Ranch</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600&family=Plus+Jakarta+Sans:wght@700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="css/style.css">
    <style>
        body { font-family: 'Inter', sans-serif; background: #f7fafc; margin: 0; }
        .weight-display {
            background: #1e293b;
            color: #38bdf8;
            font-family: 'Courier New', Courier, monospace;
            border-radius: 12px;
            padding: 20px;
            text-align: center;
            box-shadow: inset 0 4px 6px rgba(0,0,0,0.3);
        }
        .weight-value { font-size: 4rem; font-weight: bold; }
        .card-custom { border: none; border-radius: 12px; box-shadow: 0 4px 12px rgba(0,0,0,0.05); background: white; padding: 30px; }
    </style>
</head>
<body>

    <!-- Encabezado Principal -->
    <header class="main-header">
        <div class="container header-wrap">
            <div class="logo-area">
                <div class="logo-icon" style="background: transparent !important; border: none !important; padding: 0 !important; box-shadow: none !important; margin: 0 !important;">
                    <img src="logo/logo.svg" alt="Logo" style="width: 70px; height: auto; display: block;">
                </div>
                <div class="logo-text">
                    <h1>DigiHog Ranch</h1>
                    <p class="logo-status"><span class="pulse-dot"></span> Módulo de Báscula de: <?php echo htmlspecialchars($_SESSION['granja_nombre'] ?? 'Granja', ENT_QUOTES, 'UTF-8'); ?></p>
                </div>
            </div>
            <div></div>
        </div>
    </header>

    <!-- Menú centralizado -->
    <?php include 'menu.php'; ?>

    <!-- Contenido Principal -->
    <div class="container py-4" style="max-width: 1100px;">
        
        <div class="d-flex justify-content-between align-items-center mb-4">
            <div>
                <h2><i class="fas fa-weight text-success"></i> Módulo de Báscula Digital</h2>
                <p class="text-muted mb-0">Captura de peso en tiempo real y registro biométrico</p>
            </div>
            <div>
                <button id="btnConectar" class="btn btn-outline-primary fw-semibold">
                    <i class="fab fa-bluetooth-b"></i> Conectar Báscula Bluetooth
                </button>
            </div>
        </div>

        <?php if (!empty($mensaje)): ?>
            <div class="alert alert-<?php echo $tipo_alerta; ?> alert-dismissible fade show" role="alert">
                <?php echo $mensaje; ?>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        <?php endif; ?>

        <div class="row g-4">
            <!-- Panel Izquierdo: Display y Conexión -->
            <div class="col-lg-6">
                <div class="card card-custom h-100">
                    <h5 class="card-title mb-3 text-dark fw-bold"><i class="fas fa-microchip"></i> Pantalla de Báscula</h5>
                    
                    <div class="weight-display mb-4">
                        <span class="text-light fs-6 text-uppercase tracking-wider">Peso Actual Capturado</span>
                        <div class="weight-value" id="displayPeso">0.00</div>
                        <span class="text-light fs-5">KG</span>
                    </div>

                    <div class="d-grid gap-3">
                        <button type="button" class="btn btn-warning btn-lg text-dark fw-bold" id="btnSimular">
                            <i class="fas fa-sync-alt"></i> Simular Lectura de Báscula
                        </button>
                        <button type="button" class="btn btn-success btn-lg fw-bold text-white" id="btnCapturar">
                            <i class="fas fa-download"></i> Usar Este Peso en el Formulario
                        </button>
                    </div>
                </div>
            </div>

            <!-- Panel Derecho: Formulario de Registro Seguro -->
            <div class="col-lg-6">
                <div class="card card-custom h-100">
                    <h5 class="card-title mb-3 text-dark fw-bold"><i class="fas fa-clipboard-list text-primary"></i> Registrar Pesaje al Cerdo</h5>
                    
                    <form method="POST" action="lecturapeso.php">
                        <!-- Token CSRF oculto para desarrollo seguro -->
                        <input type="hidden" name="csrf_token" value="<?php echo $_SESSION['csrf_token']; ?>">

                        <div class="mb-3">
                            <label class="form-label fw-semibold">Código de Arete del Cerdo</label>
                            <div class="input-group">
                                <span class="input-group-text"><i class="fas fa-tag"></i></span>
                                <input type="text" class="form-control" id="arete" name="arete" placeholder="Ej. A-1024" required>
                            </div>
                        </div>

                        <div class="mb-3">
                            <label class="form-label fw-semibold">Lote Actual</label>
                            <select class="form-select" name="id_lote" required>
                                <option value="" selected disabled>Seleccione el lote...</option>
                                <?php foreach ($lotes as $lote): ?>
                                    <option value="<?php echo $lote['id']; ?>">
                                        <?php echo htmlspecialchars($lote['nombre_lote'] . ' (' . $lote['etapa_actual'] . ')', ENT_QUOTES, 'UTF-8'); ?>
                                    </option>
                                <?php endforeach; ?>
                            </select>
                        </div>

                        <div class="mb-3">
                            <label class="form-label fw-semibold">Peso Registrado (KG)</label>
                            <input type="number" step="0.01" min="0.1" class="form-control form-control-lg fw-bold text-success" id="peso_registrado" name="peso_registrado" placeholder="0.00" required>
                        </div>

                        <div class="mb-3">
                            <label class="form-label fw-semibold">Observaciones Sanitarias / Condición</label>
                            <textarea class="form-control" name="observaciones" rows="2" placeholder="Ej. Animal activo, sin novedades..."></textarea>
                        </div>

                        <div class="d-grid">
                            <button type="submit" class="btn btn-primary btn-lg fw-semibold" style="background: #4e54c8; border: none; padding: 12px;">
                                <i class="fas fa-save"></i> Guardar en Historial Biométrico
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Script de Integración Bluetooth y Simulación -->
    <script>
        const displayPeso = document.getElementById('displayPeso');
        const inputPesoRegistrado = document.getElementById('peso_registrado');
        const btnConectar = document.getElementById('btnConectar');
        const btnSimular = document.getElementById('btnSimular');
        const btnCapturar = document.getElementById('btnCapturar');
        
        let bluetoothDevice = null;

        btnSimular.addEventListener('click', () => {
            let pesoAleatorio = (Math.random() * (115.00 - 45.00) + 45.00).toFixed(2);
            displayPeso.textContent = pesoAleatorio;
        });

        btnCapturar.addEventListener('click', () => {
            let pesoActual = displayPeso.textContent;
            if(pesoActual === "0.00") {
                alert("Primero debe capturar o simular un peso en la báscula.");
                return;
            }
            inputPesoRegistrado.value = pesoActual;
            inputPesoRegistrado.style.backgroundColor = "#e6fffa";
            setTimeout(() => inputPesoRegistrado.style.backgroundColor = "white", 600);
        });

        btnConectar.addEventListener('click', async () => {
            try {
                btnConectar.textContent = "Buscando báscula...";
                bluetoothDevice = await navigator.bluetooth.requestDevice({
                    acceptAllDevices: true,
                    optionalServices: ['battery_service']
                });

                const server = await bluetoothDevice.gatt.connect();
                btnConectar.innerHTML = `<i class="fas fa-check-circle"></i> Conectado: ${bluetoothDevice.name || 'Báscula Ganadera'}`;
                btnConectar.classList.remove('btn-outline-primary');
                btnConectar.classList.add('btn-success');
            } catch (error) {
                console.log('Error de conexión Bluetooth: ', error);
                btnConectar.innerHTML = `<i class="fab fa-bluetooth-b"></i> Conectar Báscula Bluetooth`;
                alert("No se pudo conectar con la báscula. Verifique que esté encendida y el Bluetooth activo.");
            }
        });
    </script>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>