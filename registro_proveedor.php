<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>DigiHog Ranch - Acceso de Proveedores</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600&family=Plus+Jakarta+Sans:wght@700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="css/style.css"> <!-- Asegúrate de que este CSS contenga las clases auth-wrapper, auth-card, etc -->
</head>
<body>

    <div class="auth-wrapper">
        <header class="auth-header">
           <div class="logo-icon" style="background: transparent !important; border: none !important; padding: 0 !important; box-shadow: none !important; margin: 0 !important;">
                <img src="logo/logo.svg" alt="Logo" style="width: 70px; height: auto; display: block;">
            </div>
            <h1>DigiHog Ranch</h1>
        </header>

        <main class="auth-card">
            <div class="auth-tabs">
                <button type="button" class="auth-tab active" id="tab-login" onclick="window.location.href='login_proveedor.php'">
                    <i class="fa-solid fa-lock mr-1"></i> Iniciar Sesión Proveedor
                </button>
                <button type="button" class="auth-tab active" id="tab-register">
                    <i class="fa-solid fa-user-plus mr-1"></i> Registro Proveedor
                </button>
            </div>

            <form action="registro_proveedor.php" method="POST" class="auth-form active" id="form-register-prov">
                <div class="form-group">
                    <label class="form-label">Nombre de la Empresa Proveedora</label>
                    <div class="input-wrapper">
                        <i class="fa-solid fa-building"></i>
                        <input type="text" name="empresa" class="form-input" placeholder="Nombre de tu empresa" required>
                    </div>
                </div>

                <div class="form-group">
                    <label class="form-label">Correo Electrónico de Negocios</label>
                    <div class="input-wrapper">
                        <i class="fa-solid fa-envelope"></i>
                        <input type="email" name="email" class="form-input" placeholder="contacto@empresa.com" required>
                    </div>
                </div>

                <div class="form-group">
                    <label class="form-label">Contraseña de Seguridad</label>
                    <div class="input-wrapper">
                        <i class="fa-solid fa-key"></i>
                        <input type="password" name="password" class="form-input" placeholder="••••••••" required>
                    </div>
                </div>

                <div class="form-group">
                    <label class="form-label">Selecciona tu Plan</label>
                    <div class="input-wrapper">
                        <i class="fa-solid fa-tag"></i>
                        <select name="plan" class="form-input">
                            <option value="1">Plan Básico (Gratis)</option>
                            <option value="2">Plan Premium ($19.99/mes)</option>
                        </select>
                    </div>
                </div>

                <button type="submit" class="btn-submit-form">
                    <span>Registrar Cuenta de Proveedor</span> <i class="fa-solid fa-circle-check"></i>
                </button>
            </form>
        </main>

        <a href="inicio_registro.php" class="btn-back">
            <i class="fa-solid fa-arrow-left-long"></i> Volver al Inicio
        </a>
    </div>

</body>
</html>