<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Bienvenido a DigiHog Ranch</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        body { 
            font-family: 'Inter', sans-serif; 
            margin: 0; 
            padding: 0; 
            background: linear-gradient(135deg, #f5f7fa 0%, #c3cfe2 100%); 
            min-height: 100vh; 
            color: #2d3748; 
        }
        
        /* Ajuste: Reduje el padding superior de 60px a 20px */
        .hero { 
            display: flex; 
            flex-direction: column; 
            align-items: center; 
            justify-content: center; 
            padding: 20px 20px 40px 20px; 
        }
        
        .hero-logo { margin-bottom: 5px; }
        .hero h2 { font-size: 2.5rem; margin: 10px 0; color: #1a202c; }
        
        .card-container { display: flex; justify-content: center; gap: 30px; margin-top: 40px; flex-wrap: wrap; width: 100%; max-width: 1000px; }
        
        .card-choice { background: white; padding: 40px; border-radius: 25px; width: 350px; box-shadow: 0 15px 35px rgba(0,0,0,0.1); text-align: center; transition: 0.3s; border-top: 8px solid #48bb78; }
        .card-choice:hover { transform: translateY(-15px); }
        .card-choice.proveedor { border-top-color: #4e54c8; }
        
        .btn-choice { display: block; margin-top: 25px; padding: 15px; color: white; text-decoration: none; border-radius: 12px; font-weight: 700; transition: 0.3s; }
        .icon-box { font-size: 3.5rem; margin-bottom: 20px; }
        ul { text-align: left; font-size: 0.9rem; color: #4a5568; margin: 20px 0; padding-left: 20px; }
        li { margin-bottom: 8px; }
    </style>
</head>
<body>
    <main class="container hero">
        <!-- Logo -->
        <div class="hero-logo">
            <img src="logo/logo.svg" alt="Logo" style="width: 100px; height: auto; display: block;">
        </div>
        
        <h2>DigiHog Ranch</h2>
        <p style="font-size: 1.2rem; color: #4a5568; margin-bottom: 0;">La plataforma integral para el ecosistema porcino</p>

        <div class="card-container">
            <div class="card-choice">
                <div class="icon-box" style="color: #48bb78;"><i class="fa-solid fa-tractor"></i></div>
                <h3>Para Granjeros</h3>
                <ul>
                    <li><i class="fa-solid fa-check"></i> Registro detallado de crianza.</li>
                    <li><i class="fa-solid fa-check"></i> Control estricto de dietas.</li>
                    <li><i class="fa-solid fa-check"></i> Bitácora de salud y medicación.</li>
                    <li><i class="fa-solid fa-check"></i> Acceso a Marketplace de insumos.</li>
                </ul>
                <a href="registro.php" class="btn-choice" style="background: #48bb78;">Unirme como Granjero</a>
            </div>

            <div class="card-choice proveedor">
                <div class="icon-box" style="color: #4e54c8;"><i class="fa-solid fa-truck-ramp-box"></i></div>
                <h3>Para Proveedores</h3>
                <ul>
                    <li><i class="fa-solid fa-check"></i> Publica tus productos al mercado.</li>
                    <li><i class="fa-solid fa-check"></i> Gestiona tu stock en tiempo real.</li>
                    <li><i class="fa-solid fa-check"></i> Alcanza a cientos de granjas.</li>
                    <li><i class="fa-solid fa-check"></i> Suscripciones premium para más alcance.</li>
                </ul>
                <a href="registro_proveedor.php" class="btn-choice" style="background: #4e54c8;">Unirme como Proveedor</a>
            </div>
        </div>
    </main>
</body>
</html>