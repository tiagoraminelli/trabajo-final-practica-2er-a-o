<?php
// Configuración de la base de datos
$host = 'localhost'; // Cambia esto si tu base de datos está en otro host
$db = 'practica'; // Nombre de tu base de datos
$user = 'localhost'; // Tu usuario de base de datos
$pass = ''; // Tu contraseña de base de datos
$charset = 'utf8mb4';

// Configurar el DSN
$dsn = "mysql:host=$host;dbname=$db;charset=$charset";

$options = [
    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION, // Lanza excepciones en caso de error
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC, // Configura el modo de recuperación de datos
    PDO::ATTR_EMULATE_PREPARES => false, // Desactiva emulación de sentencias preparadas
];

try {
    // Crear la conexión
    $pdo = new PDO($dsn, $user, $pass, $options);
    echo "Conexión exitosa a la base de datos MariaDB.";
} catch (PDOException $e) {
    // Manejar el error
    echo "Error de conexión: " . $e->getMessage();
}
?>
