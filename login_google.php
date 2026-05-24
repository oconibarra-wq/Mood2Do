<?php
session_start();

if (isset($_POST['id_token'])) {
    $token = $_POST['id_token'];
    $parts = explode(".", $token);
    $payload = json_decode(base64_decode($parts[1]), true);
    
    $email = $payload['email'];
    $nombre = $payload['name'];

    $conexion = mysqli_connect("localhost", "root", "", "mood2do");

    if (!$conexion) {
        die("Error de conexión: " . mysqli_connect_error());
    }

    // 1. Buscamos usando el nombre exacto de tu columna: 'correo'
    $consulta = "SELECT * FROM usuarios WHERE correo = '$email'";
    $resultado = mysqli_query($conexion, $consulta);

    if (!$resultado) {
        die("Error en la consulta: " . mysqli_error($conexion));
    }

    if (mysqli_num_rows($resultado) > 0) {
        // El usuario ya existe
        $usuario_db = mysqli_fetch_assoc($resultado);
        $_SESSION['usuario'] = $usuario_db['usuario']; 
    } else {
        // 2. AUTO-REGISTRO
        // Enviamos 'usuario', 'correo', 'clave' y el obligatorio 'tipo'
        // He puesto 'Google' en tipo para que la base de datos lo acepte
        $query_insert = "INSERT INTO usuarios (usuario, correo, clave, tipo) 
                         VALUES ('$nombre', '$email', 'google_auth', 'Google')";
        
        if (mysqli_query($conexion, $query_insert)) {
            $_SESSION['usuario'] = $nombre;
        } else {
            die("Error al registrar: " . mysqli_error($conexion));
        }
    }

    $_SESSION['usuario_logueado'] = true;
    $_SESSION['correo'] = $email;

    mysqli_close($conexion);
    header("Location: user-index.php"); 
    exit();

} else {
    header("Location: no-user-index.php?error=Acceso denegado");
    exit();
}