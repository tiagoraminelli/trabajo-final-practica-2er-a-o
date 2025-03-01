<?php
session_start();

require_once "bd.php"; // Asegúrate de que este archivo contiene la conexión a la BD

$breadcrumb = "Detalles";

if ($_SERVER['REQUEST_METHOD'] == 'GET') {
    $idPieza = isset($_GET['id']) ? intval($_GET['id']) : 0;
    $clasificacion = $_GET['clasificacion'];

    if ($idPieza > 0) {

        $clasificacionTablaMap = [
            'Paleontología' => 'Paleontologia',
            'Osteología' => 'Osteologia',
            'Ictiología' => 'Ictiologia',
            'Geología' => 'Geologia',
            'Botánica' => 'botanica',
            'Zoología' => 'Zoologia',
            'Arqueología' => 'Arqueologia',
            'Octología' => 'Octologia'
        ];

        // Verificar si la clasificación es válida
        if (!array_key_exists($clasificacion, $clasificacionTablaMap)) {
            throw new Exception("Clasificación no válida");
        }

        // Obtener el nombre de la tabla relacionada según la clasificación
        $tablaRelacionada = $clasificacionTablaMap[$clasificacion];

        // Construir la consulta SQL para obtener solo los datos de la tabla relacionada
        $sql = "SELECT p.imagen, r.* 
        FROM $tablaRelacionada r
        INNER JOIN pieza p ON r.Pieza_idPieza = p.idPieza
        WHERE r.Pieza_idPieza = ?";

        // Preparar la consulta
        $stmt = $pdo->prepare($sql);

        // Ejecutar la consulta
        $stmt->execute([$idPieza]);

        // Obtener los resultados
        $resultados = $stmt->fetchAll(PDO::FETCH_ASSOC);


        // Si no hay resultados
        if (empty($resultados)) {
            echo "No se encontraron resultados para la pieza con ID: $idPieza";
            header("Location: listados.php?encontrado=0");
            exit;
        }

    } else {
        echo "ID de pieza no válido.";
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detalles de la Pieza</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <link rel="stylesheet" href="../public/css/pieza.css">
    <style>
        /* Estilos personalizados */
        body {
            background-color: #f8f9fa;
        }
        .navbar {
            background-color: white;
        }
        .table th {
            background-color: #343a40;
            color: white;
        }
        .table td {
            background-color: #ffffff;
            color: #212529;
        }
        .img-frame {
            border: 5px solid #ddd; /* Borde para el marco */
            padding: 10px; /* Espacio interno */
            background-color: #fff; /* Fondo blanco */
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1); /* Sombra */
            max-width: 300px; /* Ancho máximo */
            margin: 0 auto; /* Centrar horizontalmente */
        }
        .img-frame img {
            width: 100%; /* Ajustar imagen al contenedor */
            height: auto; /* Mantener proporción */
        }
        .img-name {
            text-align: center; /* Centrar texto */
            margin-top: 10px; /* Espacio superior */
            font-size: 16px; /* Tamaño de fuente */
            font-weight: bold; /* Negrita */
            color: #333; /* Color del texto */
        }
    </style>
</head>
<body>
<?php include('./includes/navbar.php') ?>
<div class="container my-5">
    <?php
    if (!empty($resultados)) {
        // Obtener la imagen y su nombre
        $imagen = $resultados[0]['imagen']; // Ruta de la imagen
        $nombreImagen = basename($imagen); // Nombre del archivo de la imagen

        // Mostrar la imagen enmarcada con su nombre
        if (!empty($imagen)) {
            echo "<div class='text-center mb-4'>";
            echo "<div class='img-frame'>";
            echo "<img src='uploads/" . htmlspecialchars($imagen) . "' alt='Imagen de la pieza'>";
            echo "<div class='img-name'>" . htmlspecialchars($nombreImagen) . "</div>";
            echo "</div>";
            echo "</div>";
        }

        // Mostrar una tabla con los detalles de la tabla relacionada (Arqueología, Osteología, etc.)
        echo "<h4 class='mt-4 text-center text-xl font-semibold text-gray-800'>Detalles de la Clasificación: " . ucfirst($clasificacion) . "</h4>";
        echo "<table class='table table-striped table-hover my-4'>";
        echo "<thead><tr>";

        // Mostrar encabezados de la tabla de la clasificación relacionada
        foreach ($resultados[0] as $campo => $valor) {
            if ($campo !== 'imagen') { // Excluir la columna 'imagen' de la tabla
                echo "<th>" . ucfirst(str_replace('_', ' ', $campo)) . "</th>";
            }
        }

        echo "</tr></thead><tbody>";

        // Mostrar los valores de cada columna solo de la tabla relacionada
        foreach ($resultados as $fila) {
            echo "<tr>";
            foreach ($fila as $campo => $valor) {
                if ($campo !== 'imagen') { // Excluir la columna 'imagen' de la tabla
                    echo "<td>" . htmlspecialchars($valor) . "</td>";
                }
            }
            echo "</tr>";
        }

        echo "</tbody></table>";
    } else {
        echo "<p class='text-center text-gray-600'>No se encontraron resultados relacionados con la pieza.</p>";
    }
    ?>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>

<?php include('./includes/footer.php') ?>