<?php

session_start();

// Verificar si la variable de sesión no está definida o está vacía
if (!isset($_SESSION['user'])) {
    // Redirigir al index con el parámetro 'denegado=1'
    header("Location: index.php?denegado=1");
    exit; // Es importante salir después de la redirección
}

// Incluir el archivo de conexión
require_once 'bd.php'; // Aquí se incluye el archivo de conexión a la base de datos

// Consulta SQL para obtener los registros de la tabla octologia
$sql = "SELECT idOctologia, clasificacion, tipo, especie, descripcion, Pieza_idPieza FROM octologia"; 
$stmt = $pdo->query($sql);

// Obtener los resultados de la consulta
$rows = $stmt->fetchAll();
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Listado de Octología</title>

    <!-- Incluir Bootstrap CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">

    <!-- Incluir DataTables CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/datatables.net-bs5@1.11.3/css/dataTables.bootstrap5.min.css">

    <style>
        .table-responsive {
            margin-top: 20px;
        }
        .dataTables_wrapper {
            padding: 20px;
        }
    </style>
</head>
<body>

<?php include("./includes/navbar.php"); ?>

<div class="container mt-5">
    <h2 class="text-center mb-4">Listado de Octología</h2>

    <!-- Tabla con DataTables -->
    <div class="table-responsive">
        <table id="dataTable" class="table table-striped table-bordered" cellspacing="0" width="100%">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Clasificación</th>
                    <th>Tipo</th>
                    <th>Especie</th>
                    <th>Id Pieza</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($rows as $row): ?>
                <tr>
                    <td><?php echo $row['idOctologia']; ?></td>
                    <td><?php echo $row['clasificacion']; ?></td>
                    <td><?php echo $row['tipo']; ?></td>
                    <td><?php echo $row['especie']; ?></td>
                    <td><?php echo $row['Pieza_idPieza']; ?></td>
                    <td>
                        <a href="verOctologia.php?id=<?php echo $row['idOctologia']; ?>" class="btn btn-info btn-sm">Ver</a>
                        <a href="editar.php?id=<?php echo $row['Pieza_idPieza']; ?>&clasificacion=Octología" class="btn btn-warning btn-sm">Editar</a>
                        <a href="eliminar.php?id=<?php echo $row['Pieza_idPieza']; ?>" class="btn btn-danger btn-sm" onclick="return confirm('¿Estás seguro de eliminar esta entrada?');">Eliminar</a>
                    </td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div>

<?php include("./includes/footer.php"); ?>

<!-- Incluir jQuery -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<!-- Incluir Bootstrap JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

<!-- Incluir DataTables JS -->
<script src="https://cdn.jsdelivr.net/npm/datatables.net@1.11.3/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/datatables.net-bs5@1.11.3/js/dataTables.bootstrap5.min.js"></script>

<!-- Activar DataTable -->
<script>
    $(document).ready(function() {
        $('#dataTable').DataTable({
            "paging": true,
            "searching": true,
            "ordering": true,
            "info": true,
            "lengthMenu": [5, 10, 25, 50],
            "language": {
                "url": "https://cdn.datatables.net/plug-ins/1.11.3/i18n/Spanish.json"
            }
        });
    });
</script>

</body>
</html>
