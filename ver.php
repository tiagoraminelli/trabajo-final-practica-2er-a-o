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
        $sql = "SELECT * 
                FROM $tablaRelacionada
                WHERE Pieza_idPieza = ?";

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
        /* Personaliza aquí los colores y estilos según sea necesario */
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
    </style>
</head>
<body>
<?php include('./includes/navbar.php') ?>
<div class="container my-5">
    <?php
    if (!empty($resultados)) {
        // Mostrar una tabla con los detalles de la tabla relacionada (Arqueología, Osteología, etc.)
        echo "<h4 class='mt-4 text-center text-xl font-semibold text-gray-800'>Detalles de la Clasificación: " . ucfirst($clasificacion) . "</h4>";
        echo "<table class='table table-striped table-hover my-4'>";
        echo "<thead><tr>";

        // Mostrar encabezados de la tabla de la clasificación relacionada
        foreach ($resultados[0] as $campo => $valor) {
            echo "<th>" . ucfirst(str_replace('_', ' ', $campo)) . "</th>";
        }

        echo "</tr></thead><tbody>";

        // Mostrar los valores de cada columna solo de la tabla relacionada
        foreach ($resultados as $fila) {
            echo "<tr>";
            foreach ($fila as $campo => $valor) {
                echo "<td>" . htmlspecialchars($valor) . "</td>";
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
