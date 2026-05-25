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

    // 1. Check if email already exists
    $consulta = "SELECT * FROM usuarios WHERE correo = '$email'";
    $resultado = mysqli_query($conexion, $consulta);

    if (!$resultado) {
        die("Error en la consulta: " . mysqli_error($conexion));
    }

    $new_user = false;

    if (mysqli_num_rows($resultado) > 0) {
        // Existing user → just log in
        $usuario_db = mysqli_fetch_assoc($resultado);
        $_SESSION['usuario'] = $usuario_db['usuario'];
    } else {
        // 2. New user: generate a unique username
        $base_username = $nombre;
        $username = $base_username;
        $counter = 1;

        // Keep trying until we find an unused username
        while (true) {
            $check_user = "SELECT id FROM usuarios WHERE usuario = '$username'";
            $res_user = mysqli_query($conexion, $check_user);
            if (mysqli_num_rows($res_user) == 0) {
                break; // username is free
            }
            $username = $base_username . $counter;
            $counter++;
        }

        // 3. Insert the new user
        $query_insert = "INSERT INTO usuarios (usuario, correo, clave, tipo) 
                         VALUES ('$username', '$email', 'google_auth', 'Google')";
        
        if (mysqli_query($conexion, $query_insert)) {
            $_SESSION['usuario'] = $username;
            $new_user = true;
        } else {
            // Log error and redirect with message
            error_log("Google register error: " . mysqli_error($conexion));
            header("Location: no-user-index.php?error=No se pudo crear tu cuenta. Por favor, intenta con otro método.");
            exit();
        }
    }

    $_SESSION['usuario_logueado'] = true;
    $_SESSION['correo'] = $email;
    
    // Store flags for welcome email (only for brand new users)
    if ($new_user) {
        $_SESSION['new_google_user'] = true;
        $_SESSION['google_user_email'] = $email;
        $_SESSION['google_user_name'] = $username; // use the generated unique username
    }

    mysqli_close($conexion);
    header("Location: user-index.php"); 
    exit();

} else {
    header("Location: no-user-index.php?error=Acceso denegado");
    exit();
}
?>
