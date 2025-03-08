<?php
session_start();

// Verificar si el usuario está logueado y es administrador
if (!isset($_SESSION['user']) || $_SESSION['nivel'] != "administrador") {
    header("Location: index.php?denegado=1");
    exit;
}

// Incluir el archivo de conexión
require_once 'bd.php';

// Obtener el ID del usuario a editar
$idUsuario = $_POST['idUsuario'];

// Obtener los datos del formulario
$dni = $_POST['dni'];
$nombre = $_POST['nombre'];
$apellido = $_POST['apellido'];
$email = $_POST['email'];
$password = $_POST['password']; // Nueva contraseña (opcional)
$tipo_de_usuario = $_POST['tipo_de_usuario'];

$errores = [];

// Validar DNI
if (strlen($dni) != 8 || !ctype_digit($dni)) {
    $errores[] = "El DNI debe tener 8 dígitos numéricos.";
}

// Validar nombres y apellidos
if (strlen($nombre) < 3 || !preg_match('/^[a-zA-Z\s]+$/', $nombre) || substr_count($nombre, ' ') > 2) {
    $errores[] = "El nombre debe tener al menos 3 caracteres, solo puede contener letras y espacios, y no más de 2 espacios en blanco.";
}

if (strlen($apellido) < 3 || !preg_match('/^[a-zA-Z\s]+$/', $apellido) || substr_count($apellido, ' ') > 2) {
    $errores[] = "El apellido debe tener al menos 3 caracteres, solo puede contener letras y espacios, y no más de 2 espacios en blanco.";
}

// Validar contraseña (si se proporciona)
if (!empty($password) && strlen($password) < 3) {
    $errores[] = "La contraseña debe tener al menos 3 caracteres.";
}

// Validar el formato del correo electrónico
if (strlen($email) <= 11 || !filter_var($email, FILTER_VALIDATE_EMAIL) ) {
    $errores[] = "El correo electrónico no tiene un formato válido.";
}
// Validar que el dominio del correo electrónico exista
else {
    $dominio = substr(strrchr($email, "@"), 1); // Extraer el dominio del correo
    if (!checkdnsrr($dominio, "MX")) { // Verificar si el dominio tiene registros MX
        $errores[] = "El dominio del correo electrónico no es válido o no existe.";
    }
}


// Verificar si el correo o DNI ya existen
if (count($errores) == 0) {
    $sql = "SELECT idUsuario FROM usuario WHERE (email = :email OR dni = :dni) AND idUsuario != :idUsuario";
    $stmt = $pdo->prepare($sql);
    $stmt->execute(['email' => $email, 'dni' => $dni, 'idUsuario' => $idUsuario]);
    $usuarioExistente = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($usuarioExistente) {
        $errores[] = "El correo electrónico o DNI ya está registrado.";
    }
}

// Si hay errores, redirigir con los errores
if (count($errores) > 0) {
    $_SESSION['errores'] = $errores;
    header("Location: editarUser.php?id=$idUsuario");
    exit;
}

// Si no hay errores, actualizar el usuario
if (empty($password)) {
    // Si no se proporciona una nueva contraseña, no se actualiza
    $sql = "UPDATE usuario SET 
            dni = :dni, 
            nombre = :nombre, 
            apellido = :apellido, 
            email = :email, 
            tipo_de_usuario = :tipo_de_usuario 
            WHERE idUsuario = :idUsuario";
    $params = [
        'dni' => $dni,
        'nombre' => $nombre,
        'apellido' => $apellido,
        'email' => $email,
        'tipo_de_usuario' => $tipo_de_usuario,
        'idUsuario' => $idUsuario
    ];
} else {
    // Si se proporciona una nueva contraseña, se hashea y se actualiza
    $passwordHash = password_hash($password, PASSWORD_DEFAULT);
    $sql = "UPDATE usuario SET 
            dni = :dni, 
            nombre = :nombre, 
            apellido = :apellido, 
            email = :email, 
            clave = :passwordHash, 
            tipo_de_usuario = :tipo_de_usuario 
            WHERE idUsuario = :idUsuario";
    $params = [
        'dni' => $dni,
        'nombre' => $nombre,
        'apellido' => $apellido,
        'email' => $email,
        'clave' => $passwordHash,
        'tipo_de_usuario' => $tipo_de_usuario,
        'idUsuario' => $idUsuario
    ];
}
//die($sql);
$stmt = $pdo->prepare($sql);

try {
    $stmt->execute($params);

    // Redirigir con un mensaje de éxito
    header("Location: personal.php?exito=1");
    exit;
} catch (PDOException $e) {
    // Redirigir con un mensaje de error si ocurre una excepción
    header("Location: editarUser.php?id=$idUsuario&error=2");
    exit;
}