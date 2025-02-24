<?php
session_start();

// Verificar si el usuario está logueado y es administrador
if (!isset($_SESSION['user']) || $_SESSION['nivel'] != "administrador") {
    header("Location: index.php?denegado=1");
    exit;
}

// Incluir el archivo de conexión
require_once 'bd.php';


$idUsuario = $_GET['id'];

// Obtener los datos del usuario a editar
$sql = "SELECT idUsuario, dni, nombre, apellido, email, fecha_alta, tipo_de_usuario FROM usuario WHERE idUsuario = :idUsuario";
$stmt = $pdo->prepare($sql);
$stmt->execute(['idUsuario' => $idUsuario]);
$usuario = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$usuario) {
    header("Location: listadoUsuarios.php?error=1");
    exit;
}

// Procesar el formulario de edición
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $dni = $_POST['dni'];
    $nombre = $_POST['nombre'];
    $apellido = $_POST['apellido'];
    $email = $_POST['email'];
    $tipo_de_usuario = $_POST['tipo_de_usuario'];

    // Validar los datos (puedes agregar más validaciones según sea necesario)
    if (empty($dni) || empty($nombre) || empty($apellido) || empty($email) || empty($tipo_de_usuario)) {
        $error = "Todos los campos son obligatorios.";
    } else {
        // Actualizar el usuario en la base de datos
        $sql = "UPDATE usuario SET dni = :dni, nombre = :nombre, apellido = :apellido, email = :email, tipo_de_usuario = :tipo_de_usuario WHERE idUsuario = :idUsuario";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([
            'dni' => $dni,
            'nombre' => $nombre,
            'apellido' => $apellido,
            'email' => $email,
            'tipo_de_usuario' => $tipo_de_usuario,
            'idUsuario' => $idUsuario
        ]);

        // Redirigir al listado con un mensaje de éxito
        header("Location: listadoUsuarios.php?exito=1");
        exit;
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar Usuario</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
</head>
<body>

<?php include("./includes/navbar.php"); ?>

<div class="container mt-5">
    <h2 class="text-center mb-4">Editar Usuario</h2>

    <?php if (isset($error)): ?>
        <div class="alert alert-danger"><?php echo $error; ?></div>
    <?php endif; ?>

    <form method="POST" action="funcionEditarUser.php">
    <input type="hidden" name="idUsuario" value="<?php echo $usuario['idUsuario']; ?>">
        <div class="mb-3">
            <label for="dni" class="form-label">DNI</label>
            <input type="text" class="form-control" id="dni" name="dni" value="<?php echo $usuario['dni']; ?>" required>
        </div>
        <div class="mb-3">
            <label for="nombre" class="form-label">Nombre</label>
            <input type="text" class="form-control" id="nombre" name="nombre" value="<?php echo $usuario['nombre']; ?>" required>
        </div>
        <div class="mb-3">
            <label for="apellido" class="form-label">Apellido</label>
            <input type="text" class="form-control" id="apellido" name="apellido" value="<?php echo $usuario['apellido']; ?>" required>
        </div>
        <div class="mb-3">
            <label for="email" class="form-label">Email</label>
            <input type="email" class="form-control" id="email" name="email" value="<?php echo $usuario['email']; ?>" required>
        </div>
        <div class="mb-3">
            <label for="tipo_de_usuario" class="form-label">Tipo de Usuario</label>
            <select class="form-select" id="tipo_de_usuario" name="tipo_de_usuario" required>
                <option value="gerente" <?php echo ($usuario['tipo_de_usuario'] == 'gerente') ? 'selected' : ''; ?>>Gerente</option>
            </select>
        </div>
        <button type="submit" class="btn btn-primary">Guardar Cambios</button>
        <a href="personal.php" class="btn btn-secondary">Cancelar</a>
    </form>
</div>

<?php include("./includes/footer.php"); ?>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>