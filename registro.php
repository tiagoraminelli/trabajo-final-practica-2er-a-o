<?php
require_once 'bd.php'; // Incluir la conexión a la base de datos
session_start();

var_dump($_POST);
// Verificar si la variable de sesión no está definida o está vacía
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Obtener los datos del formulario
    $dni = trim($_POST['dni']);
    $nombre = trim($_POST['nombre']);
    $apellido = trim($_POST['apellido']);
    $email = trim($_POST['email']);
    $clave = trim($_POST['clave']);
    $fecha_alta = date('Y-m-d');
    $tipo_de_usuario = 'gerente';
     // Hashear la clave
    $hashedClave = password_hash($clave, PASSWORD_DEFAULT);
    echo $dni, $nombre, $apellido, $email, $clave,$hashedClave, $fecha_alta, $tipo_de_usuario;

    // Validaciones básicas
    if (empty($dni) || empty($nombre) || empty($apellido) || empty($email) || empty($clave)) {
        echo "Todos los campos son obligatorios.";
        header("Location: register.php?denegado=1");
        exit;
    }

    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        echo "El correo electrónico no es válido.";
        header("Location: register.php?denegado=2");
        exit;
    }

    if (strlen($dni) != 8 || !ctype_digit($dni)) {
        echo "El DNI debe ser un número de 8 dígitos.";
        header("Location: register.php?denegado=2");
        exit;
    }

   


    try {
        // Insertar los datos en la tabla
        $sql = "INSERT INTO usuario (idUsuario, dni, nombre, apellido, email, clave, fecha_alta, tipo_de_usuario) VALUES (null,:dni, :nombre, :apellido, :email, :clave, :fecha_alta, :tipo_de_usuario)";
        $stmt = $pdo->prepare($sql);

        $stmt->bindParam(':dni', $dni, PDO::PARAM_STR);
        $stmt->bindParam(':nombre', $nombre, PDO::PARAM_STR);
        $stmt->bindParam(':apellido', $apellido, PDO::PARAM_STR);
        $stmt->bindParam(':email', $email, PDO::PARAM_STR);
        $stmt->bindParam(':clave', $hashedClave, PDO::PARAM_STR);
        $stmt->bindParam(':fecha_alta', $fecha_alta, PDO::PARAM_STR);
        $stmt->bindParam(':tipo_de_usuario', $tipo_de_usuario, PDO::PARAM_STR);

        if ($stmt->execute()) {
            echo "Usuario registrado exitosamente.";
            $_SESSION['user'] = $dni; // Aquí podrías usar el DNI como identificador
            $_SESSION['name'] = $nombre;
            $_SESSION['nivel'] = $tipo_de_usuario;

            // Redirigir al index.php
            header("Location: index.php?bienvenido=1");
            exit;
        } else {
            echo "Error al registrar el usuario.";
            header("Location: register.php?denegado=4");
        }
    } catch (PDOException $e) {
        echo "Error en la base de datos: " . $e->getMessage();
        header("Location: register.php?denegado=5");
    }
} else {
    echo "Acceso no permitido.";
    header("Location: register.php?denegado=6");
}