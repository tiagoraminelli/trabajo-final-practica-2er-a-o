<?php
require_once 'bd.php'; // Incluir la conexión a la base de datos
session_start();

// Verificar si el usuario está autenticado
if (!isset($_SESSION['user'])) {
    // Redirigir al index si no está autenticado
    header("Location: index.php?denegado=1");
    exit;
}



//eliminmar pieza

if (isset($_GET['id'])) {
    $idPieza = $_GET['id'];
    $sql = "DELETE FROM pieza WHERE idPieza = ?";
    $stmt = $pdo->prepare($sql);
    if($stmt->execute([$idPieza])){
        echo "Pieza eliminada correctamente.";
        header("Location: listados.php?eliminado=1");
        exit;

    }else{
        echo "Error al eliminar la pieza.";
        header("Location: listados.php?eliminado=0");
        exit;
    }
   


}