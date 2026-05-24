<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="glass-style.css">
    <script src="https://accounts.google.com/gsi/client" async defer></script>
    <title>Mood2Do: Registro</title>
</head>
<body>
    <header class="header-capsule">
    <nav class="menu-principal">
        <div class="logo">
            <a href="index.html">Mood2Do</a>
        </div>
        <div class="botones">
            <a href="registro.php" class="btn-pill">Registrarme</a> 
            <a href="no-user-index.php" class="btn-pill dark">Iniciar Sesión</a>
        </div>
    </nav>
</header>

<video autoplay muted loop id="bg-video" style="
    position: fixed;
    right: 0;
    bottom: 0;
    min-width: 100%;
    min-height: 100%;
    z-index: -1;
    object-fit: cover;
">
    <source src="vids/Option_2.mp4" type="video/mp4">
</video>

<main class="login-container">
    <div class="login-card">
        <h1>Únete a la familia Mood</h1>
        
        <?php if (isset($_GET["error"])): ?>
            <p class="error"><?php echo $_GET["error"]; ?></p>
        <?php endif; ?>

        <form action="registro_proceso.php" method="POST">
            <input type="email" name="Correo" placeholder="Correo..." class="input-pill" required>
            <input type="text" name="Usuario" placeholder="Nombre de usuario..." class="input-pill" required>
            <input type="password" name="Clave" placeholder="Contraseña..." class="input-pill" required>
            
            <div class="selector-estudiante">
                <input type="radio" name="tipo-estudiante" id="colegio" value="colegio" checked>
                <label for="colegio">Estudiante de colegio</label>

                <input type="radio" name="tipo-estudiante" id="universidad" value="universidad">
                <label for="universidad">Estudiante de universidad</label>
            </div>
            
            <div class="button-row">
    <div id="g_id_onload"
         data-client_id="1062060794783-rd924lqdpil8mbemg9oq83424q8hojsj.apps.googleusercontent.com"
         data-callback="handleCredentialResponse">
    </div>
    <div class="g_id_signin" data-type="standard"></div>

    <button type="submit" class="btn-pill-dark">Registrarse</button>
</div>
<a href="no-user-index.php" class="alt-link">Ya tengo una cuenta</a>
<script>
function handleCredentialResponse(response) {
    const form = document.createElement('form');
    form.method = 'POST';
    form.action = 'login_google.php'; 

    const input = document.createElement('input');
    input.type = 'hidden';
    input.name = 'id_token';
    input.value = response.credential;

    form.appendChild(input);
    document.body.appendChild(form);
    form.submit();
}
</script>
</body>
</html>

