<?php
session_start();

// Verificar si el usuario está logueado
if (!isset($_SESSION['user'])) {
    // Redirigir al index con el parámetro 'denegado=1'
    header("Location: index.php?denegado=1");
    exit; // Es importante salir luego de la redirección
}

// Verificar si el usuario es administrador (nivel 1)
if ($_SESSION['nivel'] != 1) {
    header("Location: index.php?denegado=1");
    exit;
}

require_once 'bd.php'; // Aquí se incluye el archivo de conexión a la base de datos

// Variables para el formulario
$nombre = $apellido = $email = $dni = $clave = $tipo_de_usuario = "";
$errores = [];

// Procesar formulario al enviarlo
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Recoger los datos del formulario
    $nombre = $_POST['nombre'];
    $apellido = $_POST['apellido'];
    $email = $_POST['email'];
    $dni = $_POST['dni'];
    $clave = $_POST['clave'];
    $tipo_de_usuario = $_POST['tipo_de_usuario'];

    // Validar los datos (puedes agregar más validaciones según lo necesario)
    if (empty($nombre) || empty($apellido) || empty($email) || empty($dni) || empty($clave) || empty($tipo_de_usuario)) {
        $errores[] = "Todos los campos son requeridos.";
    }

    if (count($errores) == 0) {
        // Encriptar la clave
        $clave_encriptada = password_hash($clave, PASSWORD_DEFAULT);

        // Insertar el nuevo usuario en la base de datos
        $sql = "INSERT INTO usuario (dni, nombre, apellido, email, clave, tipo_de_usuario) 
                VALUES ('$dni', '$nombre', '$apellido', '$email', '$clave_encriptada', '$tipo_de_usuario')";

        if ($conn->query($sql) === TRUE) {
            echo "Nuevo usuario agregado exitosamente.";
        } else {
            echo "Error al agregar usuario: " . $conn->error;
        }
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Agregar Usuario</title>
    <!-- Incluir Bootstrap CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
</head>
<body>

    <!-- Incluir Navbar -->
    <?php include("./includes/navbar.php"); ?>

    <!-- Contenedor principal -->
    <div class="container mt-5">
        <div class="card shadow-lg p-4 bg-white rounded-lg">
            <h2 class="card-title text-center text-primary mb-4">Agregar Nuevo Usuario</h2>
            <div class="card-body">

                <!-- Mostrar errores -->
                <?php if (!empty($errores)): ?>
                    <div class="alert alert-danger">
                        <ul>
                            <?php foreach ($errores as $error): ?>
                                <li><?php echo $error; ?></li>
                            <?php endforeach; ?>
                        </ul>
                    </div>
                <?php endif; ?>

                <!-- Formulario de agregar usuario -->
                <form action="agregarUser.php" method="POST">
                    <div class="mb-3">
                        <label for="nombre" class="form-label">Nombre</label>
                        <input type="text" class="form-control" id="nombre" name="nombre" value="<?php echo $nombre; ?>" required>
                    </div>
                    <div class="mb-3">
                        <label for="apellido" class="form-label">Apellido</label>
                        <input type="text" class="form-control" id="apellido" name="apellido" value="<?php echo $apellido; ?>" required>
                    </div>
                    <div class="mb-3">
                        <label for="email" class="form-label">Email</label>
                        <input type="email" class="form-control" id="email" name="email" value="<?php echo $email; ?>" required>
                    </div>
                    <div class="mb-3">
                        <label for="dni" class="form-label">DNI</label>
                        <input type="text" class="form-control" id="dni" name="dni" value="<?php echo $dni; ?>" required>
                    </div>
                    <div class="mb-3">
                        <label for="clave" class="form-label">Clave</label>
                        <input type="password" class="form-control" id="clave" name="clave" required>
                    </div>
                    <div class="mb-3">
                        <label for="tipo_de_usuario" class="form-label">Tipo de Usuario</label>
                        <select class="form-select" id="tipo_de_usuario" name="tipo_de_usuario" required>
                            <option value="1" <?php echo $tipo_de_usuario == '1' ? 'selected' : ''; ?>>Administrador</option>
                            <option value="2" <?php echo $tipo_de_usuario == '2' ? 'selected' : ''; ?>>Usuario</option>
                        </select>
                    </div>
                    <button type="submit" class="btn btn-primary">Agregar Usuario</button>
                </form>
            </div>
        </div>
    </div>

    <!-- Incluir Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>
