<?php
require_once 'bd.php'; // Incluir la conexión a la base de datos
session_start();

// Verificar si el usuario está autenticado
if (!isset($_SESSION['user'])) {
    // Redirigir al index si no está autenticado
    header("Location: index.php?denegado=1");
    exit;
}

// Verificar si se ha enviado el formulario
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Obtener los datos enviados por el formulario
    $idPieza = isset($_POST['idPieza']) ? intval($_POST['idPieza']) : 0;
    $num_inventario = isset($_POST['num_inventario']) ? $_POST['num_inventario'] : '';
    $especie = isset($_POST['especie']) ? $_POST['especie'] : '';
    $estado_conservacion = isset($_POST['estado_conservacion']) ? $_POST['estado_conservacion'] : '';
    $fecha_ingreso = isset($_POST['fecha_ingreso']) ? $_POST['fecha_ingreso'] : '';
    $cantidad_de_piezas = isset($_POST['cantidad_de_piezas']) ? $_POST['cantidad_de_piezas'] : '';
    $observacion = isset($_POST['observacion']) ? $_POST['observacion'] : '';
    $donante_idDonante = isset($_POST['donante_idDonante']) ? $_POST['donante_idDonante'] : 0;
    $clasificacion = isset($_POST['clasificacion']) ? $_POST['clasificacion'] : '';
    $imagen = isset($_FILES['imagen']) ? $_FILES['imagen'] : null;

    // Verificar si la imagen fue cargada
    if ($imagen && $imagen['error'] == UPLOAD_ERR_OK) {
        // Generar un nombre único para la imagen
        $imagenNombre = time() . "_" . basename($imagen['name']);
        $destinoImagen = "uploads/" . $imagenNombre;

        // Mover la imagen al directorio de destino
        move_uploaded_file($imagen['tmp_name'], $destinoImagen);
    } else {
        // Si no se cargó una nueva imagen, mantener la imagen anterior
        $imagenNombre = isset($_POST['imagen_actual']) ? $_POST['imagen_actual'] : '';
    }

    // Actualizar los datos de la pieza
    $sqlPieza = "UPDATE pieza SET 
                    num_inventario = ?, 
                    especie = ?, 
                    estado_conservacion = ?, 
                    fecha_ingreso = ?, 
                    cantidad_de_piezas = ?, 
                    observacion = ?, 
                    Donante_idDonante = ?, 
                    imagen = ? 
                 WHERE idPieza = ?";
    $stmtPieza = $pdo->prepare($sqlPieza);
    $stmtPieza->execute([$num_inventario, $especie, $estado_conservacion, $fecha_ingreso, $cantidad_de_piezas, $observacion, $donante_idDonante, $imagenNombre, $idPieza]);

    // Actualizar los detalles de la clasificación (según la clasificación seleccionada)
    $tablaRelacionada = '';
    $sqlClasificacion = '';

    switch ($clasificacion) {
        case 'Paleontología':
            $tablaRelacionada = 'Paleontologia';
            $era = isset($_POST['eraPal']) ? $_POST['eraPal'] : '';
            $periodo = isset($_POST['periodoPal']) ? $_POST['periodoPal'] : '';
            $descripcion = isset($_POST['descripcionPal']) ? $_POST['descripcionPal'] : '';
            $sqlClasificacion = "UPDATE Paleontologia SET 
                                    era = ?, 
                                    periodo = ?, 
                                    descripcion = ? 
                                 WHERE Pieza_idPieza = ?";
            $stmtClasificacion = $pdo->prepare($sqlClasificacion);
            $stmtClasificacion->execute([$era, $periodo, $descripcion, $idPieza]);
            break;

        case 'Osteología':
            $tablaRelacionada = 'Osteologia';
            $especie_osteologia = isset($_POST['especieOst']) ? $_POST['especieOst'] : '';
            $clasificacion_osteologia = isset($_POST['clasificacionOst']) ? $_POST['clasificacionOst'] : '';
            
            // Actualizar los detalles de la clasificación en la base de datos
            $sqlClasificacion = "UPDATE Osteologia SET 
                                    especie = ?, 
                                    clasificacion = ? 
                                 WHERE Pieza_idPieza = ?";
            $stmtClasificacion = $pdo->prepare($sqlClasificacion);
            $stmtClasificacion->execute([$especie_osteologia, $clasificacion_osteologia, $idPieza]);
            break;

        case 'Arqueología':
            $tablaRelacionada = 'Arqueologia';
            $integridad_historica = isset($_POST['integridad_historica']) ? $_POST['integridad_historica'] : '';
            $estetica = isset($_POST['estetica']) ? $_POST['estetica'] : '';
            $material = isset($_POST['material']) ? $_POST['material'] : '';
            $sqlClasificacion = "UPDATE Arqueologia SET 
                                    integridad_historica = ?, 
                                    estetica = ?, 
                                    material = ? 
                                 WHERE Pieza_idPieza = ?";
            $stmtClasificacion = $pdo->prepare($sqlClasificacion);
            $stmtClasificacion->execute([$integridad_historica, $estetica, $material, $idPieza]);
            break;

        case 'Ictiología':
            $tablaRelacionada = 'Ictiologia';
            $clasificacion_ictiologia = isset($_POST['clasificacion_ictiologia']) ? $_POST['clasificacion_ictiologia'] : '';
            $especies = isset($_POST['especies_ictiologia']) ? $_POST['especies_ictiologia'] : '';
            $descripcion_ictiologia = isset($_POST['descripcion_ictiologia']) ? $_POST['descripcion_ictiologia'] : '';
            $sqlClasificacion = "UPDATE Ictiologia SET 
                                    clasificacion = ?, 
                                    especies = ?, 
                                    descripcion = ? 
                                 WHERE Pieza_idPieza = ?";
            $stmtClasificacion = $pdo->prepare($sqlClasificacion);
            $stmtClasificacion->execute([$clasificacion_ictiologia, $especies, $descripcion_ictiologia, $idPieza]);
            break;

        case 'Geología':
            $tablaRelacionada = 'Geologia';
            $tipo_rocas = isset($_POST['tipo_rocas']) ? $_POST['tipo_rocas'] : '';
            $descripcion_geologia = isset($_POST['descripcionGeo']) ? $_POST['descripcionGeo'] : '';
            $sqlClasificacion = "UPDATE Geologia SET 
                                    tipo_rocas = ?, 
                                    descripcion = ? 
                                 WHERE Pieza_idPieza = ?";
            $stmtClasificacion = $pdo->prepare($sqlClasificacion);
            $stmtClasificacion->execute([$tipo_rocas, $descripcion_geologia, $idPieza]);
            break;

        case 'Botánica':
            $tablaRelacionada = 'Botanica';
            $reino = isset($_POST['reinoBot']) ? $_POST['reinoBot'] : '';
            $familia = isset($_POST['familiaBot']) ? $_POST['familiaBot'] : '';
            $orden = isset($_POST['ordenBot']) ? $_POST['ordenBot'] : '';
            $especie_botanica = isset($_POST['especieBot']) ? $_POST['especieBot'] : '';
            $division = isset($_POST['divisionBot']) ? $_POST['divisionBot'] : '';
            $clase = isset($_POST['claseBot']) ? $_POST['claseBot'] : '';
            $descripcion_botanica = isset($_POST['descripcionBot']) ? $_POST['descripcionBot'] : '';
            $sqlClasificacion = "UPDATE Botanica SET 
                                    reino = ?, 
                                    familia = ?, 
                                    orden = ?, 
                                    especie = ?, 
                                    division = ?, 
                                    clase = ?, 
                                    descripcion = ? 
                                 WHERE Pieza_idPieza = ?";
            $stmtClasificacion = $pdo->prepare($sqlClasificacion);
            $stmtClasificacion->execute([$reino, $familia, $orden, $especie_botanica, $division, $clase, $descripcion_botanica, $idPieza]);
            break;

        case 'Zoología':
            $tablaRelacionada = 'Zoologia';
            $reino_zoologia = isset($_POST['reinoZoo']) ? $_POST['reinoZoo'] : '';
            $familia_zoologia = isset($_POST['familiaZoo']) ? $_POST['familiaZoo'] : '';
            $especie_zoologia = isset($_POST['especieZoo']) ? $_POST['especieZoo'] : '';
            $orden_zoologia = isset($_POST['ordenZoo']) ? $_POST['ordenZoo'] : '';
            $phylum_zoologia = isset($_POST['phylumZoo']) ? $_POST['phylumZoo'] : '';
            $clase_zoologia = isset($_POST['claseZoo']) ? $_POST['claseZoo'] : '';
            $genero_zoologia = isset($_POST['generoZoo']) ? $_POST['generoZoo'] : '';
            $descripcion_zoologia = isset($_POST['descripcionZoo']) ? $_POST['descripcionZoo'] : '';
            $sqlClasificacion = "UPDATE Zoologia SET 
                                    reino = ?, 
                                    familia = ?, 
                                    especie = ?, 
                                    orden = ?, 
                                    phylum = ?, 
                                    clase = ?, 
                                    genero = ?, 
                                    descripcion = ? 
                                 WHERE Pieza_idPieza = ?";
            $stmtClasificacion = $pdo->prepare($sqlClasificacion);
            $stmtClasificacion->execute([$reino_zoologia, $familia_zoologia, $especie_zoologia, $orden_zoologia, $phylum_zoologia, $clase_zoologia, $genero_zoologia, $descripcion_zoologia, $idPieza]);
            break;

        case 'Octología':
            $tablaRelacionada = 'Octologia';
            $clasificacion_octologia = isset($_POST['clasificacion_octologia']) ? $_POST['clasificacion_octologia'] : '';
            $tipo_octologia = isset($_POST['tipo_octologia']) ? $_POST['tipo_octologia'] : '';
            $especie_octologia = isset($_POST['especie_octologia']) ? $_POST['especie_octologia'] : '';
            $descripcion_octologia = isset($_POST['descripcion_octologia']) ? $_POST['descripcion_octologia'] : '';
            $sqlClasificacion = "UPDATE Octologia SET 
                                    clasificacion = ?, 
                                    tipo = ?, 
                                    especie = ?, 
                                    descripcion = ? 
                                 WHERE Pieza_idPieza = ?";
            $stmtClasificacion = $pdo->prepare($sqlClasificacion);
            $stmtClasificacion->execute([$clasificacion_octologia, $tipo_octologia, $especie_octologia, $descripcion_octologia, $idPieza]);
            break;
        default:
        echo "Clasificación no reconocida.";
        break;
    }
    header("Location: listados.php?exito=$idPieza");
}
?>
