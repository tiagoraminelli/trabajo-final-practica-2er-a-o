<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Formulario de Registro</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <?php include("./includes/navbar.php");?>
    <div class="container mt-5">
        <h1 class="text-center mb-4">Registro de Usuario</h1>
        <form action="registro.php" method="POST">
            <div class="mb-3">
                <label for="dni" class="form-label">DNI</label>
                <input type="text" class="form-control" id="dni" name="dni" maxlength="8" placeholder="Ingrese su DNI" required>
            </div>
            <div class="mb-3">
                <label for="nombre" class="form-label">Nombre</label>
                <input type="text" class="form-control" id="nombre" name="nombre" placeholder="Ingrese su nombre" required>
            </div>
            <div class="mb-3">
                <label for="apellido" class="form-label">Apellido</label>
                <input type="text" class="form-control" id="apellido" name="apellido" placeholder="Ingrese su apellido" required>
            </div>
            <div class="mb-3">
                <label for="email" class="form-label">Correo Electrónico</label>
                <input type="email" class="form-control" id="email" name="email" placeholder="Ingrese su correo electrónico" required>
            </div>
            <div class="mb-3">
                <label for="clave" class="form-label">Clave</label>
                <input type="password" class="form-control" id="clave" name="clave" placeholder="Ingrese su clave" required>
            </div>

            <button type="submit" class="btn btn-primary w-100">Registrar</button>
        </form>
    </div>

        <!-- Modal -->
        <div class="modal fade" id="errorModal" tabindex="-1" aria-labelledby="errorModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title text-danger" id="errorModalLabel">Error en el Registro</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <!-- Mensaje de error dinámico -->
                    <p id="errorMessage"></p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        // Mostrar el modal si existe un parámetro "denegado" en la URL
        const urlParams = new URLSearchParams(window.location.search);
        const denegado = urlParams.get('denegado');

        if (denegado) {
            let mensaje = "";

            switch (denegado) {
                case "1":
                    mensaje = "Todos los campos son obligatorios.";
                    break;
                case "2":
                    mensaje = "El correo electrónico o DNI no es válido.";
                    break;
                case "4":
                    mensaje = "Error al registrar el usuario.";
                    break;
                case "5":
                    mensaje = "Error en la base de datos.";
                    break;
                case "6":
                    mensaje = "Acceso no permitido.";
                    break;
                default:
                    mensaje = "Ha ocurrido un error desconocido.";
            }

            document.getElementById('errorMessage').innerText = mensaje;
            const modal = new bootstrap.Modal(document.getElementById('errorModal'));
            modal.show();
        }
    </script>
</body>
<?php include("./includes/footer.php");?>
</html>
