<?php
// Asegúrate de que el usuario esté logueado
session_start();
// Verificar si la variable de sesión no está definida o está vacía
if (!isset($_SESSION['user'])) {
    // Redirigir al index con el parámetro 'denegado=1'
    header("Location: index.php?denegado=1");
    exit; // Es importante salir después de la redirección
}
// Conexión a la base de datos (ajusta los datos de conexión según tu configuración)
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "practica"; // Cambia esto por tu base de datos

// Crear conexión
$conn = new mysqli($servername, $username, $password, $dbname);

// Verificar la conexión
if ($conn->connect_error) {
    die("Conexión fallida: " . $conn->connect_error);
}


if (!isset($_SESSION['user'])) {
    // Redirigir si no hay usuario activo en sesión
    header("Location: login.php");
    exit();
}

// Obtener el ID del usuario activo desde la sesión
$idUsuario = $_GET['id'];

// Consulta SQL para obtener los datos del usuario
$sql = "SELECT * FROM usuario WHERE idUsuario = $idUsuario";
$result = $conn->query($sql);

// Verificar si se obtuvo el usuario
if ($result->num_rows > 0) {
    // Obtener los datos del usuario
    $row = $result->fetch_assoc();
} else {
    echo "Usuario no encontrado.";
    exit();
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Carta de Presentación</title>
    
    <!-- Incluir Bootstrap CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    
    <!-- Enlazando con Tailwind CSS -->
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-light">

<?php include("./includes/navbar.php");?>
    <!-- Contenedor principal -->
    <div class="container mt-5">
        <div class="card shadow-lg p-4 bg-white rounded-lg">
            <h2 class="card-title text-center text-primary mb-4">Carta de Presentación</h2>
            <div class="card-body">
                <p><strong>ID Usuario:</strong> <?php echo $row['idUsuario']; ?></p>
                <p><strong>DNI:</strong> <?php echo $row['dni']; ?></p>
                <p><strong>Nombre:</strong> <?php echo $row['nombre']; ?></p>
                <p><strong>Apellido:</strong> <?php echo $row['apellido']; ?></p>
                <p><strong>Email:</strong> <?php echo $row['email']; ?></p>
                <p><strong>Fecha de Alta:</strong> <?php echo $row['fecha_alta']; ?></p>
                <p><strong>Tipo de Usuario:</strong> <?php echo $row['tipo_de_usuario']; ?></p>
            </div>
        </div>
    </div>

    <!-- Incluir jQuery -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    <!-- Incluir Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    
    <!-- Incluir el Footer -->
    <?php include("./includes/footer.php"); ?>

</body>
</html>
