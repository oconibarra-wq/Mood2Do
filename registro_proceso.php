<?php
include('config.php');

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $Correo = mysqli_real_escape_string($config, $_POST['Correo']);
    $Usuario = mysqli_real_escape_string($config, $_POST['Usuario']);
    $Clave = md5($_POST['Clave']);
    $Tipo = $_POST['tipo-estudiante'];

    // Verificar si ya existe
    $check = mysqli_query($config, "SELECT * FROM usuarios WHERE Usuario='$Usuario' OR Correo='$Correo'");
    
    if (mysqli_num_rows($check) > 0) {
        header("Location: registro.php?error=El usuario o correo ya está registrado");
    } else {
        $query = "INSERT INTO usuarios (Usuario, Correo, Clave, Tipo) VALUES ('$Usuario', '$Correo', '$Clave', '$Tipo')";
        if (mysqli_query($config, $query)) {
            header("Location: no-user-index.php?success=¡Registro exitoso! Inicia sesión ahora.");
        } else {
            header("Location: registro.php?error=Error al guardar los datos");
        }
    }
}
?>