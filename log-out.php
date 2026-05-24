<?php
session_start();
session_destroy(); 
header("location:no-user-index.php"); 
exit();
?>