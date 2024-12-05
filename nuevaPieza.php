<?php
var_dump($_POST);
$host = 'localhost'; // Cambia esto si tu base de datos está en otro host
$db_name = 'practica'; // Nombre de tu base de datos
$db_user = 'root'; // Tu usuario de base de datos
$db_pass = ''; // Tu contraseña de base de datos

try {
    // Crear la conexión
    $conection = new PDO('mysql:host=' . $host . ';dbname=' . $db_name, $db_user, $db_pass);
    $conection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION); // Configura el modo de error
} catch (PDOException $e) {
    // Manejar el error
    echo "Error de conexión: " . $e->getCode() . " ; " . $e->getMessage();
    exit();
}

$pieza = $_POST;
// Recoger los datos del formulario
$num_inventario = $_POST['num_inventario'];
$especie = $_POST['especieP'];
$estado_conservacion = $_POST['estado_conservacion'];
$fecha_ingreso = $_POST['fecha_ingreso'];
$cantidad_de_piezas = $_POST['cantidad_de_piezas'];
$clasificacion = $_POST['clasificacion'];
$observacion = $_POST['observacion'];

// Subir la imagen si existe
$imagen = null;
if (isset($_FILES['imagen']) && $_FILES['imagen']['error'] === UPLOAD_ERR_OK) {
    $imagen = 'images/' . basename($_FILES['imagen']['name']);
    move_uploaded_file($_FILES['imagen']['tmp_name'], $imagen);  // Guardar la imagen en el servidor
}

// Datos del donante (opcional)
$donante_nombre = isset($_POST['donante_nombre']) ? $_POST['donante_nombre'] : null;
$donante_apellido = isset($_POST['donante_apellido']) ? $_POST['donante_apellido'] : null;
$donante_idDonante = null;

// Insertar el donante en la tabla 'donante' (opcional)
if ($donante_nombre && $donante_apellido) {
    $sqlDonante = "INSERT INTO donante (nombre, apellido) VALUES (:donante_nombre, :donante_apellido)";
    $stmtDonante = $conection->prepare($sqlDonante);
    $stmtDonante->bindParam(':donante_nombre', $donante_nombre);
    $stmtDonante->bindParam(':donante_apellido', $donante_apellido);
    $stmtDonante->execute();
    $donante_idDonante = $conection->lastInsertId(); // Obtener el ID del donante recién insertado
}

// Insertar la pieza en la tabla 'pieza'
$sql = "INSERT INTO pieza (num_inventario, especie, estado_conservacion, fecha_ingreso, cantidad_de_piezas, clasificacion, observacion, imagen, Donante_idDonante) 
        VALUES (:num_inventario, :especie, :estado_conservacion, :fecha_ingreso, :cantidad_de_piezas, :clasificacion, :observacion, :imagen, :donante_idDonante)";
$stmt = $conection->prepare($sql);
$stmt->bindParam(':num_inventario', $num_inventario);
$stmt->bindParam(':especie', $especie);
$stmt->bindParam(':estado_conservacion', $estado_conservacion);
$stmt->bindParam(':fecha_ingreso', $fecha_ingreso);
$stmt->bindParam(':cantidad_de_piezas', $cantidad_de_piezas);
$stmt->bindParam(':clasificacion', $clasificacion);
$stmt->bindParam(':observacion', $observacion);
$stmt->bindParam(':imagen', $imagen);
$stmt->bindParam(':donante_idDonante', $donante_idDonante);

// Ejecutar la inserción de la pieza
$stmt->execute();

// Obtener el ID de la pieza recién insertada
$idPieza = $conection->lastInsertId();

// Asegúrate de que $idPieza no sea null
if (!$idPieza) {
    echo "Error: El ID de la pieza no se ha generado correctamente.";
    exit();
}

// Aquí definimos la clasificación para cargar los datos según corresponda
switch ($pieza["clasificacion"]) {
    case "Paleontología":
        $sql = "INSERT INTO paleontologia (era, periodo, descripcion, Pieza_idPieza) VALUES (:era, :periodo, :descripcion, :Pieza_idPieza)";
        $stmt = $conection->prepare($sql);
        $stmt->bindParam(':era', $pieza["era"]);
        $stmt->bindParam(':periodo', $pieza["periodo"]);
        $stmt->bindParam(':descripcion', $pieza["descripcionPal"]);
        $stmt->bindParam(':Pieza_idPieza', $idPieza);
        break;
    case "Osteología":
        $sql = "INSERT INTO osteologia (especie, clasificacion, Pieza_idPieza) VALUES (:especie, :clasificacion, :Pieza_idPieza)";
        $stmt = $conection->prepare($sql);
        $stmt->bindParam(':especie', $pieza["especieOst"]);
        $stmt->bindParam(':clasificacion', $pieza["clasificacionOst"]);
        $stmt->bindParam(':Pieza_idPieza', $idPieza);
        break;
    case "Ictiología":
        $sql = "INSERT INTO ictiologia (clasificacion, especies, descripcion, Pieza_idPieza) VALUES (:clasificacion, :especies, :descripcion, :Pieza_idPieza)";
        $stmt = $conection->prepare($sql);
        $stmt->bindParam(':clasificacion', $pieza["clasificacionIct"]);
        $stmt->bindParam(':especies', $pieza["especiesIct"]);
        $stmt->bindParam(':descripcion', $pieza["descripcionIct"]);
        $stmt->bindParam(':Pieza_idPieza', $idPieza);
        break;
    case "Geología":
        $sql = "INSERT INTO geologia (tipo_rocas, descripcion, Pieza_idPieza) VALUES (:tipo_rocas, :descripcion, :Pieza_idPieza)";
        $stmt = $conection->prepare($sql);
        $stmt->bindParam(':tipo_rocas', $pieza["tipo_rocas"]);
        $stmt->bindParam(':descripcion', $pieza["descripcionGeo"]);
        $stmt->bindParam(':Pieza_idPieza', $idPieza);
        break;
    case "Botánica":
        $sql = "INSERT INTO botanica (reino, familia, especie, orden, division, clase, descripcion, Pieza_idPieza) VALUES (:reino, :familia, :especie, :orden, :division, :clase, :descripcion, :Pieza_idPieza)";
        $stmt = $conection->prepare($sql);
        $stmt->bindParam(':reino', $pieza["reinoBot"]);
        $stmt->bindParam(':familia', $pieza["familiaBot"]);
        $stmt->bindParam(':especie', $pieza["especieBot"]);
        $stmt->bindParam(':orden', $pieza["ordenBot"]);
        $stmt->bindParam(':division', $pieza["divisionBot"]);
        $stmt->bindParam(':clase', $pieza["claseBot"]);
        $stmt->bindParam(':descripcion', $pieza["descripcionBot"]);
        $stmt->bindParam(':Pieza_idPieza', $idPieza);
        break;
    case "Zoología":
        $sql = "INSERT INTO zoologia (reino, familia, especie, orden, phylum, clase, genero, descripcion, Pieza_idPieza) VALUES (:reino, :familia, :especie, :orden, :phylum, :clase, :genero, :descripcion, :Pieza_idPieza)";
        $stmt = $conection->prepare($sql);
        $stmt->bindParam(':reino', $pieza["reino"]);
        $stmt->bindParam(':familia', $pieza["familia"]);
        $stmt->bindParam(':especie', $pieza["especie"]);
        $stmt->bindParam(':orden', $pieza["orden"]);
        $stmt->bindParam(':phylum', $pieza["phylum"]);
        $stmt->bindParam(':clase', $pieza["clase"]);
        $stmt->bindParam(':genero', $pieza["genero"]);
        $stmt->bindParam(':descripcion', $pieza["descripcion"]);
        $stmt->bindParam(':Pieza_idPieza', $idPieza);
        break;
    case "Arqueología":
        $sql = "INSERT INTO arqueologia (integridad_historica, estetica, material, Pieza_idPieza) VALUES (:integridad_historica, :estetica, :material, :Pieza_idPieza)";
        $stmt = $conection->prepare($sql);
        $stmt->bindParam(':integridad_historica', $pieza["integridad_historica"]);
        $stmt->bindParam(':estetica', $pieza["estetica"]);
        $stmt->bindParam(':material', $pieza["material"]);
        $stmt->bindParam(':Pieza_idPieza', $idPieza);
        break;
    case "Octología":
        $sql = "INSERT INTO octologia (clasificacion, tipo, especie, descripcion, Pieza_idPieza) VALUES (:clasificacion, :tipo, :especie, :descripcion, :Pieza_idPieza)";
        $stmt = $conection->prepare($sql);
        $stmt->bindParam(':clasificacion', $pieza["clasificacionOct"]);
        $stmt->bindParam(':tipo', $pieza["tipoOct"]);
        $stmt->bindParam(':especie', $pieza["especieOct"]);
        $stmt->bindParam(':descripcion', $pieza["descripcionOct"]);
        $stmt->bindParam(':Pieza_idPieza', $idPieza);
        break;
}

if($stmt->execute()) {
    echo "Pieza y datos adicionales insertados correctamente.";
    header("Location: listados.php?insertado=1");
    exit();
}else{
    echo "Error al insertar los datos adicionales.";
    header("Location: listados.php?insertado=1");
    exit();
}

?>
