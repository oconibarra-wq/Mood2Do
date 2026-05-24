<?php
session_start();

if (isset($_POST['index']) && isset($_SESSION['active_plan'])) {
    $index = (int)$_POST['index'];
    
    // Cambiamos el estado de true a false o viceversa
    if (isset($_SESSION['active_plan']['activities'][$index])) {
        $current_state = $_SESSION['active_plan']['activities'][$index]['done'];
        $_SESSION['active_plan']['activities'][$index]['done'] = !$current_state;
        
        echo json_encode(['done' => !($current_state)]);
        exit;
    }
}
echo json_encode(['error' => 'No se pudo actualizar']);