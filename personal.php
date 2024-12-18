<?php
session_start();
// Verificar si el usuario está logueado
if (!isset($_SESSION['user'])) {
    // Redirigir al index con el parámetro 'denegado=1'
    header("Location: index.php?denegado=1");
    exit; // Es importante salir luego de la redirección
}

// Verificar si el usuario es administrador (nivel 1)
if ($_SESSION['nivel'] != "administrador") {
    header("Location: index.php?denegado=1");
    exit;
}
// Incluir el archivo de conexión
require_once 'bd.php'; // Asegúrate de que este archivo existe y se conecta a tu base de datos

// Consulta SQL para obtener los registros de la tabla `usuario`
$sql = "SELECT idUsuario, dni, nombre, apellido, email, fecha_alta, tipo_de_usuario FROM usuario where tipo_de_usuario = 'gerente' ";
$stmt = $pdo->query($sql);
$error = isset($_GET['error']) && $_GET['error'] == '1';
$exito = isset($_GET['exito']) && $_GET['exito'] == '1';

// Obtener los resultados de la consulta
$rows = $stmt->fetchAll();
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Listado de Usuarios</title>

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
    <h2 class="text-center mb-4">Listado de Usuarios</h2>

    <!-- Botón para agregar un nuevo usuario, visible solo si hay sesión activa -->
    <?php if (isset($_SESSION['user'])): ?>
    <div class="d-flex justify-content-between mb-4">
        <a href="agregarUser.php" class="btn btn-success btn-add">Agregar Nuevo Usuario</a>
    </div>
    <?php endif; ?>

    <!-- Tabla con DataTables -->
    <div class="table-responsive">
        <table id="dataTable" class="table table-striped table-bordered" cellspacing="0" width="100%">
            <thead>
                <tr>
                    <th>#</th>
                    <th>DNI</th>
                    <th>Nombre</th>
                    <th>Apellido</th>
                    <th>Email</th>
                    <th>Fecha Alta</th>
                    <th>Tipo de Usuario</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($rows as $row): ?>
                <tr>
                    <td><?php echo $row['idUsuario']; ?></td>
                    <td><?php echo $row['dni']; ?></td>
                    <td><?php echo $row['nombre']; ?></td>
                    <td><?php echo $row['apellido']; ?></td>
                    <td><?php echo $row['email']; ?></td>
                    <td><?php echo $row['fecha_alta']; ?></td>
                    <td><?php echo $row['tipo_de_usuario']; ?></td>
                    <td>
                       
                        <a href="eliminarUser.php?id=<?php echo $row['idUsuario']; ?>" class="btn btn-danger btn-sm" onclick="return confirm('¿Estás seguro de eliminar este usuario?');">Eliminar</a>

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

  <!-- Modal de Error -->
  <div class="modal fade" id="errorModal" tabindex="-1" aria-labelledby="errorModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header bg-danger text-white">
                    <h5 class="modal-title" id="errorModalLabel">Error</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <p>Ocurrió un problema al procesar la solicitud. Por favor, verifica los datos e inténtalo de nuevo.</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                </div>
            </div>
        </div>
    </div>

<!-- Modal de Éxito -->
<div class="modal fade" id="successModal" tabindex="-1" aria-labelledby="successModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header bg-success text-white">
                    <h5 class="modal-title" id="successModalLabel">Éxito</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <p>La operación se realizó exitosamente.</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-primary" data-bs-dismiss="modal">Aceptar</button>
                </div>
            </div>
        </div>
    </div>

 <!-- Mostrar el Modal si hay error -->
 <script>
        <?php if ($error): ?>
            var errorModal = new bootstrap.Modal(document.getElementById('errorModal'));
            errorModal.show();
        <?php endif; ?>
        <?php if ($exito): ?>
    var successModal = new bootstrap.Modal(document.getElementById('successModal'));
    successModal.show();
<?php endif; ?>

    </script>
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
