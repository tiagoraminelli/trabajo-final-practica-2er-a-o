<?php
var_dump($_POST);

// Verificar si se ha recibido la información del formulario
if (isset($_POST['idPieza'])) {
    // Recibir los valores del formulario
    $idPieza = $_POST['idPieza'];
    $num_inventario = $_POST['num_inventario']; 
    $especie = $_POST['especie'];
    $estado_conservacion = $_POST['estado_conservacion'];
    $fecha_ingreso = $_POST['fecha_ingreso'];
    $cantidad_de_piezas = $_POST['cantidad_de_piezas'];
    $clasificacion = $_POST['clasificacion'];
    $Donante_idDonante = $_POST['donante_idDonante']; // Corregir nombre del campo si es necesario
    $observacion = $_POST['observacion'];
    if($_POST['imagen']){
        $imagen = $_POST['imagen'];
    }


    // Establecer conexión con la base de datos
    $conexion = new mysqli("localhost", "root", "", "practica");
    
    // Verificar si la conexión fue exitosa
    if ($conexion->connect_error) {
        die("Error de conexión: " . $conexion->connect_error);
    }

    // Preparar la consulta SQL para actualizar los datos
    $sql = "UPDATE pieza 
            SET num_inventario = ?, especie = ?, estado_conservacion = ?, fecha_ingreso = ?, 
                cantidad_de_piezas = ?, clasificacion = ?, observacion = ?, imagen = ?, Donante_idDonante = ? 
            WHERE idPieza = ?";

    // Preparar la declaración
    $stmt = $conexion->prepare($sql);

    // Verificar si la declaración se preparó correctamente
    if ($stmt === false) {
        die("Error en la preparación de la consulta: " . $conexion->error);
    }

    // Asignar los tipos de datos correspondientes: "s" para string, "i" para entero
    $stmt->bind_param(
        "sssssssssi", // Tipos de datos: 9 parámetros string (s) y 1 parámetro entero (i)
        $num_inventario, $especie, $estado_conservacion, $fecha_ingreso, 
        $cantidad_de_piezas, $clasificacion, $observacion, $imagen, $Donante_idDonante, $idPieza
    );

    // Ejecutar la consulta
    if ($stmt->execute()) {
        echo "Se actualizó correctamente de la pieza";
    } else {
        echo "No se actualizó: " . $stmt->error;
    }

  // Verificar la clasificación de la pieza y actualizar la base de datos
switch ($clasificacion) {
    case "Arqueología":
        // Si la clasificación es Arqueología, actualizar los detalles
        $integridad_historica = $_POST['integridad_historica'];
        $estetica = $_POST['estetica'];
        $material = $_POST['material'];
        
        // Consulta SQL para actualizar la tabla arqueologia
        $sql = "UPDATE arqueologia 
                SET integridad_historica = ?, estetica = ?, material = ? 
                WHERE Pieza_idPieza = ?";
        
        // Preparar la declaración
        $stmt = $conexion->prepare($sql);
        $stmt->bind_param("sssi", $integridad_historica, $estetica, $material, $idPieza);
        
        // Ejecutar la consulta
        if ($stmt->execute()) {
            echo "Se actualizó correctamente la pieza de arqueología.";
        } else {
            echo "No se actualizó la pieza de arqueología: " . $stmt->error;
        }
        $stmt->close();
        break;
    
    case "Paleontología":
        // Si la clasificación es Paleontología, actualizar los detalles
        $era = $_POST['era'];
        $periodo = $_POST['periodo'];
        $descripcion = $_POST['descripcionPal']; // Asegúrate de que este campo está en el formulario

        // Consulta SQL para actualizar la tabla paleontologia
        $sql = "UPDATE paleontologia 
                SET era = ?, periodo = ?, descripcion = ? 
                WHERE Pieza_idPieza = ?";

        // Preparar la declaración
        $stmt = $conexion->prepare($sql);
        $stmt->bind_param("sssi", $era, $periodo, $descripcion, $idPieza);

        // Ejecutar la consulta
        if ($stmt->execute()) {
            echo "Se actualizó correctamente la pieza de paleontología.";
        } else {
            echo "No se actualizó la pieza de paleontología: " . $stmt->error;
        }
        $stmt->close();
        break;

    case "Osteología":
        // Si la clasificación es Osteología, actualizar los detalles
        $alimento = $_POST['alimento'];
        $habitat = $_POST['habitat'];
        $caracteristicas = $_POST['caracteristicas'];

        // Consulta SQL para actualizar la tabla osteologia
        $sql = "UPDATE osteologia 
                SET alimento = ?, habitat = ?, caracteristicas = ? 
                WHERE Pieza_idPieza = ?";

        // Preparar la declaración
        $stmt = $conexion->prepare($sql);
        $stmt->bind_param("sssi", $alimento, $habitat, $caracteristicas, $idPieza);

        // Ejecutar la consulta
        if ($stmt->execute()) {
            echo "Se actualizó correctamente la pieza de osteología.";
        } else {
            echo "No se actualizó la pieza de osteología: " . $stmt->error;
        }
        $stmt->close();
        break;

    // Otros casos según las clasificaciones que tengas
    case "Ictiología":
        // Actualización para Ictiología
        // Aquí va el código específico para Ictiología
        break;

    case "Geología":
        // Actualización para Geología
        // Aquí va el código específico para Geología
        break;

    // Si no se reconoce la clasificación
    default:
        echo "Clasificación no válida o no manejada.";
        break;
}




    // Cerrar la declaración y la conexión
    //die;
    $stmt->close();
    $conexion->close();

    // Redirigir a la página de listado después de la actualización
    header("Location: listados.php");
    exit();
}
?>
