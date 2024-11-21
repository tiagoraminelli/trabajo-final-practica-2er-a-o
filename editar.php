<?php
require_once 'bd.php'; // Incluir la conexión a la base de datos
session_start();

// Verificar si la variable de sesión no está definida o está vacía
if (!isset($_SESSION['user'])) {
    // Redirigir al index con el parámetro 'denegado=1'
    header("Location: index.php?denegado=1");
    exit; // Es importante salir después de la redirección
}

// Obtener los datos de la pieza
if ($_SERVER['REQUEST_METHOD'] == 'GET') {
    $idPieza = isset($_GET['id']) ? intval($_GET['id']) : 0;
    $clasificacion = isset($_GET['clasificacion']) ? $_GET['clasificacion'] : '';

    if ($idPieza > 0) {
        $clasificacionTablaMap = [
            'Paleontología' => 'Paleontologia',
            'Osteología' => 'Osteologia',
            'Ictiología' => 'Ictiologia',
            'Geología' => 'Geologia',
            'Botánica' => 'Botanica',
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

        // Consultar los detalles de la pieza
        $sqlPieza = "SELECT * FROM pieza WHERE idPieza = ?";
        $stmtPieza = $pdo->prepare($sqlPieza);
        $stmtPieza->execute([$idPieza]);
        $pieza = $stmtPieza->fetch(PDO::FETCH_ASSOC);

        // Consultar detalles específicos según la clasificación
        $sqlClasificacion = "SELECT * FROM $tablaRelacionada WHERE Pieza_idPieza = ?";
        $stmtClasificacion = $pdo->prepare($sqlClasificacion);
        $stmtClasificacion->execute([$idPieza]);
        $clasificacionDetalles = $stmtClasificacion->fetch(PDO::FETCH_ASSOC);

        if (empty($pieza) || empty($clasificacionDetalles)) {
            echo "No se encontraron resultados para la pieza con ID: $idPieza";
            exit;
        }
    } else {
        echo "ID de pieza no válido.";
        exit;
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar Pieza</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>

<div class="container mt-5">
    <h2 class="mb-4">Editar Pieza - <?php echo htmlspecialchars($pieza['num_inventario']); ?></h2>
    
    <!-- Formulario genérico para la pieza -->
    <form action="guardar_pieza.php" method="POST" enctype="multipart/form-data">
        <input type="hidden" name="idPieza" value="<?php echo htmlspecialchars($pieza['idPieza']); ?>">
        
        <div class="mb-3">
            <label for="num_inventario" class="form-label">Número de Inventario</label>
            <input type="text" class="form-control" id="num_inventario" name="num_inventario" value="<?php echo htmlspecialchars($pieza['num_inventario']); ?>" required>
        </div>

        <div class="mb-3">
            <label for="especie" class="form-label">Especie</label>
            <input type="text" class="form-control" id="especie" name="especie" value="<?php echo htmlspecialchars($pieza['especie']); ?>" required>
        </div>

        <div class="mb-3">
            <label for="estado_conservacion" class="form-label">Estado de Conservación</label>
            <input type="text" class="form-control" id="estado_conservacion" name="estado_conservacion" value="<?php echo htmlspecialchars($pieza['estado_conservacion']); ?>" required>
        </div>

        <div class="mb-3">
            <label for="fecha_ingreso" class="form-label">Fecha de Ingreso</label>
            <input type="date" class="form-control" id="fecha_ingreso" name="fecha_ingreso" value="<?php echo htmlspecialchars($pieza['fecha_ingreso']); ?>" required>
        </div>

        <div class="mb-3">
            <label for="cantidad_de_piezas" class="form-label">Cantidad de Piezas</label>
            <input type="number" class="form-control" id="cantidad_de_piezas" name="cantidad_de_piezas" value="<?php echo htmlspecialchars($pieza['cantidad_de_piezas']); ?>" required>
        </div>

        <div class="mb-3">
            <label for="observacion" class="form-label">Observaciones</label>
            <textarea class="form-control" id="observacion" name="observacion"><?php echo htmlspecialchars($pieza['observacion']); ?></textarea>
        </div>

        <div class="mb-3">
            <label for="donante_idDonante" class="form-label">Donante</label>
            <input type="number" class="form-control" id="donante_idDonante" name="donante_idDonante" value="<?php echo htmlspecialchars($pieza['Donante_idDonante']); ?>" required>
        </div>

        <div class="mb-3">
            <label for="clasificacion" class="form-label">Clasificación</label>
            <input class="form-control" id="clasificacion" name="clasificacion" value="<?php echo htmlspecialchars($pieza['clasificacion']); ?>" readonly>
        </div>

        <div class="mb-3">
            <label for="imagen" class="form-label">Imagen</label>
            <input type="file" class="form-control" id="imagen" name="imagen" accept="image/*">
        </div>
        
        <hr>

        <!-- Formulario específico según la clasificación -->
        <?php if ($clasificacion == 'Arqueología'): ?>
            <h3>Detalles de Arqueología</h3>
            <div class="mb-3">
                <label for="integridad_historica" class="form-label">Integridad Histórica</label>
                <input type="text" class="form-control" id="integridad_historica" name="integridad_historica" value="<?php echo htmlspecialchars($clasificacionDetalles['integridad_historica']); ?>" required>
            </div>

            <div class="mb-3">
                <label for="estetica" class="form-label">Estética</label>
                <input type="text" class="form-control" id="estetica" name="estetica" value="<?php echo htmlspecialchars($clasificacionDetalles['estetica']); ?>" required>
            </div>

            <div class="mb-3">
                <label for="material" class="form-label">Material</label>
                <input type="text" class="form-control" id="material" name="material" value="<?php echo htmlspecialchars($clasificacionDetalles['material']); ?>" required>
            </div>

        <?php elseif ($clasificacion == 'Paleontología'): ?>
            <h3>Detalles de Paleontología</h3>
            <div class="mb-3">
                <label for="era" class="form-label">Era</label>
                <input type="text" class="form-control" id="era" name="era" value="<?php echo htmlspecialchars($clasificacionDetalles['era']); ?>" required>
            </div>

            <div class="mb-3">
                <label for="periodo" class="form-label">Periodo</label>
                <input type="text" class="form-control" id="periodo" name="periodo" value="<?php echo htmlspecialchars($clasificacionDetalles['periodo']); ?>" required>
            </div>

            <div class="mb-3">
                <label for="descripcion" class="form-label">Descripción</label>
                <textarea class="form-control" id="descripcionPal" name="descripcionPal" rows="3" required><?php echo htmlspecialchars($clasificacionDetalles['descripcion']); ?></textarea>
            </div>
        <?php endif; ?>

        <button type="submit" class="btn btn-primary">Guardar cambios</button>
    </form>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
