<?php
require_once 'bd.php'; // Incluir la conexión a la base de datos
session_start();

// Verificar si el usuario está autenticado
if (!isset($_SESSION['user'])) {
    // Redirigir al index si no está autenticado
    header("Location: index.php?denegado=1");
    exit;
}

// Verificar si el usuario es administrador
if ($_SESSION['nivel'] != "administrador") {
    header("Location: index.php?denegado=1");
    exit;
}

// Verificar si se recibieron datos por POST
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Obtener los datos del formulario
    $idUsuario = $_POST['idUsuario'];
    $dni = $_POST['dni'];
    $nombre = $_POST['nombre'];
    $apellido = $_POST['apellido'];
    $email = $_POST['email'];
    $tipo_de_usuario = $_POST['tipo_de_usuario'];

    // Preparar la consulta SQL para actualizar el usuario
    $sql = "UPDATE usuario SET 
            dni = :dni, 
            nombre = :nombre, 
            apellido = :apellido, 
            email = :email, 
            tipo_de_usuario = :tipo_de_usuario 
            WHERE idUsuario = :idUsuario";

    $stmt = $pdo->prepare($sql);

    // Ejecutar la consulta con los datos del formulario
    try {
        $stmt->execute([
            'dni' => $dni,
            'nombre' => $nombre,
            'apellido' => $apellido,
            'email' => $email,
            'tipo_de_usuario' => $tipo_de_usuario,
            'idUsuario' => $idUsuario
        ]);

        // Redirigir con un mensaje de éxito
        header("Location: personal.php?exito=1");
        exit;
    } catch (PDOException $e) {
        // Redirigir con un mensaje de error si ocurre una excepción
        header("Location: editarUser.php?id=$idUsuario&error=2");
        exit;
    }
} else {
    // Redirigir si no se recibieron datos por POST
    header("Location: personal.php");
    exit;
}