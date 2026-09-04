<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>DigiHog Ranch - Acceso a la Plataforma</title>
    
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600&family=Plus+Jakarta+Sans:wght@700;800&display=swap" rel="stylesheet">
    
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    <link rel="stylesheet" href="css/style.css">
</head>
<body>

    <div class="auth-wrapper">
        
        <header class="auth-header">
            <div class="logo-icon" style="background: transparent !important; border: none !important; padding: 0 !important; box-shadow: none !important; margin: 0 !important;">
                <img src="logo/logo.svg" alt="Logo" style="width: 95px; height: auto; display: block;">
            </div>
            <h1>DigiHog Ranch</h1>
        </header>

        <main class="auth-card">
            
            <div class="auth-tabs">
                <button type="button" class="auth-tab active" id="tab-login" onclick="switchAuth('login')">
                    <i class="fa-solid fa-lock mr-1"></i> Iniciar Sesión
                </button>
                <button type="button" class="auth-tab" id="tab-register" onclick="switchAuth('register')">
                    <i class="fa-solid fa-user-plus mr-1"></i> Crear Cuenta
                </button>
            </div>

            <form action="procesar_login.php" method="POST" class="auth-form active" id="form-login">
                <div class="form-group">
                    <label class="form-label" for="login-email">Correo Electrónico Técnico</label>
                    <div class="input-wrapper">
                        <i class="fa-solid fa-envelope"></i>
                        <input type="email" id="login-email" name="email" class="form-input" placeholder="ejemplo@digihog.com" required>
                    </div>
                </div>

                <div class="form-group">
                    <label class="form-label" for="login-password">Contraseña de Seguridad</label>
                    <div class="input-wrapper">
                        <i class="fa-solid fa-key"></i>
                        <input type="password" id="login-password" name="password" class="form-input" placeholder="••••••••" required>
                    </div>
                </div>

                <div class="form-group" style="margin-top: 10px; font-size: 0.85rem; color: #4a5568;">
                     <i class="fa-solid fa-shield-halved" style="color: #4e54c8;"></i> 
                     Para acceder, ingrese el código generado por su aplicación Google Authenticator, si tiene activada esta opsion. Si no puede activarla en editar su Perfil
                       </div>

                <button type="submit" class="btn-submit-form">
                    <span>Ingresar al Panel</span> <i class="fa-solid fa-arrow-right"></i>
                </button>
            </form>

            <form action="procesar_registro.php" method="POST" class="auth-form" id="form-register-user">
                <div class="form-group">
                    <label class="form-label" for="reg-name">Nombre Completo del Operador</label>
                    <div class="input-wrapper">
                        <i class="fa-solid fa-user"></i>
                        <input type="text" id="reg-name" name="nombre_completo" class="form-input" placeholder="Juan Pérez" required>
                    </div>
                </div>

                <div class="form-group">
                    <label class="form-label" for="reg-farm">Nombre de la Granja / Empresa Porcina</label>
                    <div class="input-wrapper">
                        <i class="fa-solid fa-house-chimney-window"></i>
                        <input type="text" id="reg-farm" name="nombre_granja" class="form-input" placeholder="Granja El Porvenir" required>
                    </div>
                </div>

                <div class="form-group">
                    <label class="form-label" for="reg-email">Correo Electrónico Único</label>
                    <div class="input-wrapper">
                        <i class="fa-solid fa-envelope"></i>
                        <input type="email" id="reg-email" name="email" class="form-input" placeholder="juan.perez@granja.com" required>
                    </div>
                </div>

                <div class="form-group">
                    <label class="form-label" for="reg-telefono">Número de WhatsApp (+505...)</label>
                    <div class="input-wrapper">
                        <i class="fa-brands fa-whatsapp"></i>
                        <input type="tel" id="reg-telefono" name="telefono" class="form-input" placeholder="+505XXXXXXXX" required>
                    </div>
                </div>

                <div class="form-group">
                    <label class="form-label" for="reg-password">Establecer Contraseña Fuerte</label>
                    <div class="input-wrapper">
                        <i class="fa-solid fa-key"></i>
                        <input type="password" id="reg-password" name="password" class="form-input" placeholder="Mínimo 8 caracteres" required>
                    </div>
                </div>

                <button type="submit" class="btn-submit-form">
                    <span>Registrar Infraestructura</span> <i class="fa-solid fa-circle-check"></i>
                </button>
            </form>

        </main>

        <a href="inicio_registro.php" class="btn-back">
            <i class="fa-solid fa-arrow-left-long"></i> Volver a la vista principal
        </a>

    </div>

    <script>
        function switchAuth(mode) {
            const formLogin = document.getElementById('form-login');
            const formRegister = document.getElementById('form-register-user');
            const tabLogin = document.getElementById('tab-login');
            const tabRegister = document.getElementById('tab-register');

            if (mode === 'login') {
                formLogin.classList.add('active');
                formRegister.classList.remove('active');
                tabLogin.classList.add('active');
                tabRegister.classList.remove('active');
            } else {
                formRegister.classList.add('active');
                formLogin.classList.remove('active');
                tabRegister.classList.add('active');
                tabLogin.classList.remove('active');
            }
        }
    </script>
</body>
</html>