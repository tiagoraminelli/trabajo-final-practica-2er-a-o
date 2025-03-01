<?php
require_once 'bd.php'; // Incluir la conexión a la base de datos
session_start();

// Verificar si la variable de sesión no está definida o está vacía
if (!isset($_SESSION['user'])) {
    // Redirigir al index con el parámetro 'denegado=1'
    header("Location: index.php?denegado=1");
    exit; // Es importante salir después de la redirección
}

// Verificar si hay errores en la sesión

$errores = [];
if (isset($_SESSION['errores'])) {
    // Asegurarse de que $errores sea un array
    $errores = (array)$_SESSION['errores'];
    // Limpiar los errores después de obtenerlos
    unset($_SESSION['errores']);
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

        $_SESSION['idPieza'] = $idPieza;
        $_SESSION['clasificacion'] = $clasificacion;

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
    
 <!-- Mostrar errores si existen -->
 <?php if (!empty($errores)): ?>
        <div class="alert alert-danger">
            <ul>
                <?php foreach ($errores as $error): ?>
                    <li><?php echo htmlspecialchars($error); ?></li>
                <?php endforeach; ?>
            </ul>
        </div>
    <?php endif; ?>

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

<!-------------- Mostrar la imagen si existe -------->   
<!-- Campo oculto para almacenar la imagen actual -->
<input type="hidden" name="imagen_actual" value="<?php echo htmlspecialchars($pieza['imagen']); ?>">
<div class="mb-3">
    <label for="imagen" class="form-label">Imagen actual</label>
    <?php if (!empty($pieza['imagen'])): ?>
        <!-- Mostrar la imagen si existe -->
        <div>
            <img src="uploads/<?php echo htmlspecialchars($pieza['imagen']); ?>" alt="Imagen de la pieza" style="max-width: 200px; height: auto;">
            <!-- Opción para eliminar la imagen actual -->
            <div class="form-check mt-2">
                <input type="checkbox" class="form-check-input" id="eliminar_imagen" name="eliminar_imagen">
                <label class="form-check-label" for="eliminar_imagen">Eliminar imagen actual</label>
            </div>
        </div>
    <?php else: ?>
        <!-- Mostrar un mensaje si no hay imagen -->
        <div>
            <p>No hay imagen cargada.</p>
        </div>
    <?php endif; ?>
</div>

<div class="mb-3">
    <label for="imagen" class="form-label">Cambiar imagen</label>
    <input type="file" class="form-control" id="imagen" name="imagen" accept="image/*">
</div>
<!-------------- Mostrar la imagen si existe -------->   

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
        <input type="text" class="form-control" id="eraPal" name="eraPal" value="<?php echo htmlspecialchars($clasificacionDetalles['era']); ?>" required>
    </div>

    <div class="mb-3">
        <label for="periodo" class="form-label">Periodo</label>
        <input type="text" class="form-control" id="periodoPal" name="periodoPal" value="<?php echo htmlspecialchars($clasificacionDetalles['periodo']); ?>" required>
    </div>

    <div class="mb-3">
        <label for="descripcion" class="form-label">Descripción</label>
        <textarea class="form-control" id="descripcionPal" name="descripcionPal" rows="3" required><?php echo htmlspecialchars($clasificacionDetalles['descripcion']); ?></textarea>
    </div>

<?php elseif ($clasificacion == 'Osteología'): ?>
    <h3>Detalles de Osteología</h3>
    <div class="mb-3">
        <label for="especie_osteologia" class="form-label">Especie</label>
        <input type="text" class="form-control" id="especieOst" name="especieOst" value="<?php echo htmlspecialchars($clasificacionDetalles['especie']); ?>" required>
    </div>

    <div class="mb-3">
        <label for="clasificacion_osteologia" class="form-label">Clasificación</label>
        <input type="text" class="form-control" id="clasificacionOst" name="clasificacionOst" value="<?php echo htmlspecialchars($clasificacionDetalles['clasificacion']); ?>" required>
    </div>

<?php elseif ($clasificacion == 'Ictiología'): ?>
    <h3>Detalles de Ictiología</h3>
    <div class="mb-3">
        <label for="clasificacion_ictiologia" class="form-label">Clasificación</label>
        <input type="text" class="form-control" id="clasificacion_ictiologia" name="clasificacion_ictiologia" value="<?php echo htmlspecialchars($clasificacionDetalles['clasificacion']); ?>" required>
    </div>

    <div class="mb-3">
        <label for="especies_ictiologia" class="form-label">Especies</label>
        <input type="text" class="form-control" id="especies_ictiologia" name="especies_ictiologia" value="<?php echo htmlspecialchars($clasificacionDetalles['especies']); ?>" required>
    </div>

    <div class="mb-3">
        <label for="descripcion_ictiologia" class="form-label">Descripción</label>
        <textarea class="form-control" id="descripcion_ictiologia" name="descripcion_ictiologia" rows="3" required><?php echo htmlspecialchars($clasificacionDetalles['descripcion']); ?></textarea>
    </div>

<?php elseif ($clasificacion == 'Geología'): ?>
    <h3>Detalles de Geología</h3>
    <div class="mb-3">
        <label for="tipo_rocas" class="form-label">Tipo de Rocas</label>
        <input type="text" class="form-control" id="tipo_rocas" name="tipo_rocas" value="<?php echo htmlspecialchars($clasificacionDetalles['tipo_rocas']); ?>" required>
    </div>

    <div class="mb-3">
        <label for="descripcion_geologia" class="form-label">Descripción</label>
        <textarea class="form-control" id="descripcionGeo" name="descripcionGeo" rows="3" required><?php echo htmlspecialchars($clasificacionDetalles['descripcion']); ?></textarea>
    </div>

<?php elseif ($clasificacion == 'Botánica'): ?>
    <h3>Detalles de Botánica</h3>
    <div class="mb-3">
        <label for="reino" class="form-label">Reino</label>
        <input type="text" class="form-control" id="reino" name="reinoBot" value="<?php echo htmlspecialchars($clasificacionDetalles['reino']); ?>" required>
    </div>

    <div class="mb-3">
        <label for="familia" class="form-label">Familia</label>
        <input type="text" class="form-control" id="familia" name="familiaBot" value="<?php echo htmlspecialchars($clasificacionDetalles['familia']); ?>" required>
    </div>

    <div class="mb-3">
        <label for="especie" class="form-label">Especie</label>
        <input type="text" class="form-control" id="especie" name="especieBot" value="<?php echo htmlspecialchars($clasificacionDetalles['especie']); ?>" required>
    </div>

    <div class="mb-3">
        <label for="orden" class="form-label">Orden</label>
        <input type="text" class="form-control" id="orden" name="ordenBot" value="<?php echo htmlspecialchars($clasificacionDetalles['orden']); ?>" required>
    </div>

    <div class="mb-3">
        <label for="division" class="form-label">División</label>
        <input type="text" class="form-control" id="division" name="divisionBot" value="<?php echo htmlspecialchars($clasificacionDetalles['division']); ?>" required>
    </div>

    <div class="mb-3">
        <label for="clase" class="form-label">Clase</label>
        <input type="text" class="form-control" id="claseBot" name="claseBot" value="<?php echo htmlspecialchars($clasificacionDetalles['clase']); ?>" required>
    </div>

    <div class="mb-3">
        <label for="descripcion" class="form-label">Descripción</label>
        <textarea class="form-control" id="descripcion" name="descripcionBot" rows="3" required><?php echo htmlspecialchars($clasificacionDetalles['descripcion']); ?></textarea>
    </div>

    <?php elseif ($clasificacion == 'Zoología'): ?>
    <h3>Detalles de Zoología</h3>
    <div class="mb-3">
        <label for="reino" class="form-label">Reino</label>
        <input type="text" class="form-control" id="reinoZoo" name="reinoZoo" value="<?php echo htmlspecialchars($clasificacionDetalles['reino']); ?>" required>
    </div>

    <div class="mb-3">
        <label for="familia" class="form-label">Familia</label>
        <input type="text" class="form-control" id="familiaZoo" name="familiaZoo" value="<?php echo htmlspecialchars($clasificacionDetalles['familia']); ?>" required>
    </div>

    <div class="mb-3">
        <label for="especie" class="form-label">Especie</label>
        <input type="text" class="form-control" id="especieZoo" name="especieZoo" value="<?php echo htmlspecialchars($clasificacionDetalles['especie']); ?>" required>
    </div>

    <div class="mb-3">
        <label for="orden" class="form-label">Orden</label>
        <input type="text" class="form-control" id="ordenZoo" name="ordenZoo" value="<?php echo htmlspecialchars($clasificacionDetalles['orden']); ?>" required>
    </div>

    <div class="mb-3">
        <label for="phylum" class="form-label">Phylum</label>
        <input type="text" class="form-control" id="phylumZoo" name="phylumZoo" value="<?php echo htmlspecialchars($clasificacionDetalles['phylum']); ?>" required>
    </div>

    <div class="mb-3">
        <label for="clase" class="form-label">Clase</label>
        <input type="text" class="form-control" id="claseZoo" name="claseZoo" value="<?php echo htmlspecialchars($clasificacionDetalles['clase']); ?>" required>
    </div>

    <div class="mb-3">
        <label for="genero" class="form-label">Género</label>
        <input type="text" class="form-control" id="generoZoo" name="generoZoo" value="<?php echo htmlspecialchars($clasificacionDetalles['genero']); ?>" required>
    </div>

    <div class="mb-3">
        <label for="descripcion" class="form-label">Descripción</label>
        <textarea class="form-control" id="descripcionZoo" name="descripcionZoo" rows="3" required><?php echo htmlspecialchars($clasificacionDetalles['descripcion']); ?></textarea>
    </div>
<?php elseif ($clasificacion == 'Octología'): ?>
    <h3>Detalles de Octología</h3>
    <div class="mb-3">
        <label for="clasificacion_octologia" class="form-label">Clasificación</label>
        <input type="text" class="form-control" id="clasificacion_octologia" name="clasificacion_octologia" value="<?php echo htmlspecialchars($clasificacionDetalles['clasificacion']); ?>" required>
    </div>

    <div class="mb-3">
        <label for="tipo_octologia" class="form-label">Tipo</label>
        <input type="text" class="form-control" id="tipo_octologia" name="tipo_octologia" value="<?php echo htmlspecialchars($clasificacionDetalles['tipo']); ?>" required>
    </div>

    <div class="mb-3">
        <label for="especie_octologia" class="form-label">Especie</label>
        <input type="text" class="form-control" id="especie_octologia" name="especie_octologia" value="<?php echo htmlspecialchars($clasificacionDetalles['especie']); ?>" required>
    </div>

    <div class="mb-3">
        <label for="descripcion_octologia" class="form-label">Descripción</label>
        <textarea class="form-control" id="descripcion_octologia" name="descripcion_octologia" rows="3" required><?php echo htmlspecialchars($clasificacionDetalles['descripcion']); ?></textarea>
    </div>

<?php endif; ?>

     

        <button type="submit" class="btn btn-primary">Guardar cambios</button>
    </form>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
