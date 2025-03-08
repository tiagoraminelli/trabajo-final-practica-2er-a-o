<?php
session_start();

// Verificar si el usuario está logueado
if (!isset($_SESSION['user'])) {
    // Redirigir al index con el parámetro 'denegado=1'
    header("Location: index.php?denegado=1");
    exit; // Es importante salir luego de la redirección
}

// Verificar si el usuario es administrador
if ($_SESSION['nivel'] != "administrador") {
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

    // Validar los datos
    if (empty($nombre) || empty($apellido) || empty($email) || empty($dni) || empty($clave) || empty($tipo_de_usuario)) {
        $errores[] = "Todos los campos son requeridos.";
    }

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

    // Validar contraseña
    if (strlen($clave) < 3) {
        $errores[] = "La contraseña debe tener al menos 3 caracteres.";
    }

    // Verificar si el correo o DNI ya existen
    if ($email || $dni) {
        $sql = "SELECT idUsuario FROM usuario WHERE email = :email OR dni = :dni";
        $stmt = $pdo->prepare($sql);
        $stmt->execute(['email' => $email, 'dni' => $dni]);
        $usuarioExistente = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($usuarioExistente) {
            $errores[] = "El correo electrónico o DNI ya están registrados.";
        }
    }

    if (count($errores) == 0) {
        // Encriptar la clave
        $clave_encriptada = password_hash($clave, PASSWORD_DEFAULT);

        // Insertar el nuevo usuario en la base de datos
        $sql = "INSERT INTO usuario (dni, nombre, apellido, email, clave, tipo_de_usuario, fecha_alta) 
                VALUES (:dni, :nombre, :apellido, :email, :clave, :tipo_de_usuario, NOW())";
        $stmt = $pdo->prepare($sql);

        try {
            $stmt->execute([
                'dni' => $dni,
                'nombre' => $nombre,
                'apellido' => $apellido,
                'email' => $email,
                'clave' => $clave_encriptada,
                'tipo_de_usuario' => $tipo_de_usuario
            ]);

            // Redirigir con mensaje de éxito
            header("Location: personal.php?exito=1");
            exit;
        } catch (PDOException $e) {
            // Redirigir con mensaje de error
            header("Location: personal.php?error=1");
            exit;
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
    <!-- Estilos personalizados -->
    <style>
        .card {
            max-width: 600px;
            margin: 50px auto;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }
        .card-title {
            font-weight: bold;
            color: #333;
        }
        .form-label {
            font-weight: bold;
        }
        .btn-primary {
            width: 100%;
            padding: 10px;
            font-size: 16px;
        }
        .alert {
            margin-top: 20px;
        }
    </style>
</head>
<body>

    <!-- Incluir Navbar -->
    <?php include("./includes/navbar.php"); ?>

    <!-- Contenedor principal -->
    <div class="container">
        <div class="card">
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
                            <option value="gerente" <?php echo $tipo_de_usuario == 'gerente' ? 'selected' : ''; ?>>Gerente</option>
                            <option value="administrador" <?php echo $tipo_de_usuario == 'administrador' ? 'selected' : ''; ?>>Administrador</option>
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