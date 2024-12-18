<?php
session_start();
// Verificar si el usuario está logueado
if (!isset($_SESSION['user'])) {
    // Redirigir al index con el parámetro 'denegado=1'
    header("Location: index.php?denegado=1");
    exit; // Es importante salir luego de la redirección
}

// Verificar si el usuario es administrador (nivel 1)
if ($_SESSION['nivel'] != "administrador") {
    header("Location: index.php?denegado=1");
    exit;
}

// Incluir el archivo de conexión
require_once 'bd.php'; // Asegúrate de que este archivo existe y se conecta a tu base de datos

// Verificar si se ha recibido un parámetro de ID para eliminar
if (isset($_GET['id']) && is_numeric($_GET['id'])) {
    $idUsuario = intval($_GET['id']);

    try {
        // Preparar la consulta SQL con un parámetro vinculado
        $sql = "DELETE FROM usuario WHERE idUsuario = ?";
        $stmt = $pdo->prepare($sql);
        
        // Ejecutar la consulta con el ID proporcionado
        if ($stmt->execute([$idUsuario])) {
            // Redirigir con éxito
            header("Location: personal.php?exito=1");
        } else {
            // Redirigir con error
            header("Location: personal.php?error=1");
        }
    } catch (PDOException $e) {
        // Manejar errores de la base de datos
        error_log("Error al eliminar usuario: " . $e->getMessage());
        header("Location: personal.php?error=1");
    }
} else {
    // Si no se recibe un ID válido, redirigir con error
    header("Location: personal.php?error=1");
    exit;
}
?>
