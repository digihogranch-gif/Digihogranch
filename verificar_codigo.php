<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Verificación de Seguridad - DigiHog</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
    <div class="auth-wrapper">
        <main class="auth-card">
            <h2>Verificación en dos pasos</h2>
            <p>Ingresa el código de 6 dígitos que aparece en tu aplicación <strong>Google Authenticator</strong>:</p>
            
            <form action="validar_codigo.php" method="POST">
                <div class="form-group">
                    <input type="text" name="codigo_ingresado" class="form-input" placeholder="000000" required maxlength="6" autocomplete="off">
                </div>
                <button type="submit" class="btn-submit-form">Validar Código</button>
            </form>
        </main>
    </div>
</body>
</html>