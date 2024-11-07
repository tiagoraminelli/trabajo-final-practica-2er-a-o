<?php
session_start(); // Inicia la sesión

// Verifica si la sesión está activa
if (isset($_SESSION['user'])) {
    // Destruye todas las variables de sesión
    $_SESSION = []; // Limpia las variables de sesión

    // Destruye la sesión
    session_destroy(); // Destruye la sesión

    // Redirige al usuario a la página de inicio o login
    header("Location: index.php");
    exit();
} else {
    // Si no hay sesión activa, redirige a la página de inicio
    header("Location: index.php");
    exit();
}
?>
