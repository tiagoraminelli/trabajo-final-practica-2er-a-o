<?php

session_start();

// Incluir el archivo de conexión
require_once 'bd.php'; // Aquí se incluye el archivo de conexión a la base de datos

// Consulta SQL para obtener los registros
$sql = "SELECT idPieza, num_inventario, especie, estado_conservacion, fecha_ingreso, cantidad_de_piezas, clasificacion, observacion, imagen, Donante_idDonante FROM pieza"; // Reemplaza 'tu_tabla' por el nombre real de tu tabla
$stmt = $pdo->query($sql);

// Obtener los resultados de la consulta
$rows = $stmt->fetchAll();
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Listado de Piezas</title>

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
        .btn-add {
            margin-bottom: 20px;
        }
    </style>
</head>
<body>

<?php include("./includes/navbar.php"); ?>

<div class="container mt-5">
    <h2 class="text-center mb-4">Listado de Piezas</h2>

   <!-- Botón para agregar una nueva pieza, visible solo si hay sesión activa -->
   <?php if (isset($_SESSION['user'])): ?>
    <div class="d-flex justify-content-between mb-4">
        <a href="cargarPieza.php" class="btn btn-success btn-add">Agregar Nueva Pieza</a>
    </div>
    <?php endif; ?>


    <!-- Tabla con DataTables -->
    <div class="table-responsive">
        <table id="dataTable" class="table table-striped table-bordered" cellspacing="0" width="100%">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Num Inventario</th>
                    <th>Especie</th>
                    <th>Estado Conservación</th>
                    <th>Fecha Ingreso</th>
                    <th>Cantidad de Piezas</th>
                    <th>Clasificación</th>
                    <th>Donante</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($rows as $row): ?>
                <tr>
                    <td><?php echo $row['idPieza']; ?></td>
                    <td><?php echo $row['num_inventario']; ?></td>
                    <td><?php echo $row['especie']; ?></td>
                    <td><?php echo $row['estado_conservacion']; ?></td>
                    <td><?php echo $row['fecha_ingreso']; ?></td>
                    <td><?php echo $row['cantidad_de_piezas']; ?></td>
                    <td><?php echo $row['clasificacion']; ?></td>
                    <td><?php echo $row['Donante_idDonante']; ?></td>
                    <td>
                        <a href="ver.php?id=<?php echo $row['idPieza']; ?>&clasificacion=<?php echo $row['clasificacion']; ?>" class="btn btn-info btn-sm">Ver</a>
                        <?php if (isset($_SESSION['user'])): ?>
                    
                        <a href="editar.php?id=<?php echo $row['idPieza']; ?>&clasificacion=<?php echo $row['clasificacion']; ?>" class="btn btn-warning btn-sm">Editar</a>
                        <a href="eliminar.php?id=<?php echo $row['idPieza']; ?>" class="btn btn-danger btn-sm" onclick="return confirm('¿Estás seguro de eliminar esta entrada?');">Eliminar</a>
                        <?php endif; ?>
                    </td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div>

<!-- modales -->
<!-- Modal -->
<div class="modal fade" id="modalPiezaNoEncontrada" tabindex="-1" role="dialog" aria-labelledby="modalPiezaNoEncontradaLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modalPiezaNoEncontradaLabel">Pieza no encontrada</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body text-center">
                <img src="./assets/img/404.webp" alt="Pieza no encontrada" class="img-fluid" style="max-width: 400px; height: auto;">
                <p class="mt-3">Lo sentimos, no hemos podido encontrar la pieza solicitada. Por favor, verifique los detalles o intente nuevamente más tarde.</p>
            </div>
            <div class="modal-footer">
            <p class="mt-3">Haz click para cerrar.</p>
            </div>
        </div>
    </div>
</div>

<!-- Modal -->
<div class="modal fade" id="modalInsercionExitosa" tabindex="-1" role="dialog" aria-labelledby="modalInsercionExitosaLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modalInsercionExitosaLabel">Inserción exitosa</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body text-center">
                <img src="./assets/img/succes.webp" alt="Inserción exitosa" class="img-fluid" style="max-width: 400px; height: auto;border-radius: 20px;">
                <p class="mt-3">La pieza se ha insertado correctamente. Puede continuar con el siguiente proceso.</p>
            </div>
            <div class="modal-footer">
            <p class="mt-3">Haz click en cualquier lugar para cerrar.</p>
            </div>
        </div>
    </div>
</div>

<!-- Modal -->
<div class="modal fade" id="modalEliminacionExitosa" tabindex="-1" role="dialog" aria-labelledby="modalEliminacionExitosaLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modalEliminacionExitosaLabel">Eliminación exitosa</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body text-center">
                <img src="./assets/img/delete.webp" alt="Eliminación exitosa" class="img-fluid" style="max-width: 400px; height: auto;border-radius: 20px;">
                <p class="mt-3">La pieza ha sido eliminada exitosamente.</p>
            </div>
            <div class="modal-footer">
                <p class="mt-3">Haz click en cualquier lugar para cerrar.</p>
            </div>
        </div>
    </div>
</div>

<!-- Modal -->
<div class="modal fade" id="modalEliminacionNoExitosa" tabindex="-1" role="dialog" aria-labelledby="modalEliminacionNoExitosaLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modalEliminacionNoExitosaLabel">Eliminación exitosa</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body text-center">
                <img src="./assets/img/404.webp" alt="Eliminación no exitosa" class="img-fluid" style="max-width: 400px; height: auto;border-radius: 20px;">
                <p class="mt-3">La pieza no ha sido eliminada exitosamente, por favor intente nuevamente.</p>
            </div>
            <div class="modal-footer">
                <p class="mt-3">Haz click en cualquier lugar para cerrar.</p>
            </div>
        </div>
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
<script>
    $(document).ready(function() {
    // Verificar si la variable "encontrado" es 0 en la URL
    const urlParams = new URLSearchParams(window.location.search);
    if (urlParams.get('encontrado') == '0') {
        // Mostrar el modal cuando la pieza no se encuentra
        $('#modalPiezaNoEncontrada').modal('show');
    }
});
</script>
<script>
    $(document).ready(function() {
    // Verificar si la variable "insertado" es 1 en la URL
    const urlParams = new URLSearchParams(window.location.search);
    if (urlParams.get('insertado') == '1') {
        // Mostrar el modal cuando la inserción fue exitosa
        $('#modalInsercionExitosa').modal('show');
    }
});
</script>
<script>
    $(document).ready(function() {
    // Verificar si la variable "eliminado" es 1 en la URL
    const urlParams = new URLSearchParams(window.location.search);
    if (urlParams.get('eliminado') == '1') {
        // Mostrar el modal cuando la eliminación fue exitosa
        $('#modalEliminacionExitosa').modal('show');
    }else if(urlParams.get('eliminado') == '0'){
        // Mostrar el modal cuando la eliminación no fue exitosa    
        $('#modalEliminacionNoExitosa').modal('show');
        
    }
});
</script>
</body>
</html>
