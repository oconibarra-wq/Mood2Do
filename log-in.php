<?php
include('conexion.php');
session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // 1. Recibimos y limpiamos los datos del formulario
    $login_data = mysqli_real_escape_string($conexion, $_POST['login_data']);
    $clave_ingresada = md5($_POST['Clave']); 

    // 2. HACEMOS LA CONSULTA (Esta es la línea que faltaba)
    // Nota: Usamos minúsculas para coincidir con tu imagen de phpMyAdmin
    $consulta = "SELECT * FROM usuarios WHERE (usuario = '$login_data' OR correo = '$login_data') AND clave = '$clave_ingresada'";
    
    $resultado = mysqli_query($conexion, $consulta);

    // 3. Verificamos si la consulta funcionó
    if (!$resultado) {
        die("Error en la consulta: " . mysqli_error($conexion));
    }

    // 4. Ahora sí, contamos las filas
    if (mysqli_num_rows($resultado) > 0) {
        $datos = mysqli_fetch_array($resultado);
        
        // Guardamos el usuario en la sesión (usando el nombre de columna de tu BD)
        $_SESSION['usuario'] = $datos['usuario']; 
        
        header("location:user-index.php");
        exit(); 
    } else {
        // Si no hay coincidencias, regresamos con error
        header("location:no-user-index.php?error=Usuario o contraseña incorrectos");
        exit();
    }
}
?>


