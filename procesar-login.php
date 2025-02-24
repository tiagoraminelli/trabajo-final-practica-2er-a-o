<?php
session_start();

// Configuración de la base de datos
$host = 'localhost'; // Cambia esto si tu base de datos está en otro host
$db_name = 'practica'; // Nombre de tu base de datos
$db_user = 'root'; // Tu usuario de base de datos
$db_pass = ''; // Tu contraseña de base de datos

try {
    // Crear la conexión
    $conection = new PDO('mysql:host=' . $host . ';dbname=' . $db_name, $db_user, $db_pass);
    $conection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION); // Configura el modo de error

    // echo "Conexión exitosa a la base de datos."; // Comentado para evitar mostrar en producción
} catch (PDOException $e) {
    // Manejar el error
    echo "Error de conexión: " . $e->getCode() . " ; " . $e->getMessage();
    exit();
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_POST['email']; // Cambiar de 'dni' a 'email'
    $clave = $_POST['clave'];
    var_dump($_POST);

    // Consulta SQL para buscar al usuario por su correo electrónico
    $stmt = $conection->prepare("SELECT * FROM usuario WHERE email = ?");
    $stmt->execute([$email]);
    $usuario = $stmt->fetch(PDO::FETCH_ASSOC);
    var_dump($usuario);

    if ($usuario) {
        // Verificar la contraseña
        if (password_verify($clave, $usuario['clave'])) {
            echo "Usuario entró con éxito";
            $_SESSION['user'] = $usuario;
            $_SESSION['id'] = $usuario['idUsuario'];
            $_SESSION['name'] = $usuario['nombre'];
            $_SESSION['nivel'] = $usuario['tipo_de_usuario'];
            header("Location: index.php?bienvenido=1"); // Redirige a la página principal
            exit();
        } elseif ($clave == $usuario['clave']) { // Comparación directa (no recomendado para producción)
            echo "Usuario entró con éxito";
            $_SESSION['user'] = $usuario;
            $_SESSION['id'] = $usuario['idUsuario'];
            $_SESSION['name'] = $usuario['nombre'];
            $_SESSION['nivel'] = $usuario['tipo_de_usuario'];
            header("Location: index.php?bienvenido=1"); // Redirige a la página principal
            exit();
        } else {
            $error = "Credenciales incorrectas. Inténtalo de nuevo.";
            header("Location: login.php?error=1"); // Redirige con un mensaje de error
            exit();
        }
    } else {
        $error = "Usuario no encontrado. Inténtalo de nuevo.";
        header("Location: login.php?error=1"); // Redirige con un mensaje de error
        exit();
    }
}
?>