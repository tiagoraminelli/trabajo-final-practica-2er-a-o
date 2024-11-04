<?php
session_start(); // Iniciar la sesión

// Verificar si el usuario está logueado
$isLoggedIn = isset($_SESSION['user']);
$isLoggedInName = isset($_SESSION['name']);
$isLoggedInLvl = isset($_SESSION['nivel']);
//var_dump($_SESSION);
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mi Aplicación</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@1.9.6/dist/tailwind.min.css" rel="stylesheet">
    <link rel="stylesheet" href="styles.css"> <!-- Tu hoja de estilos personalizada -->
</head>
<body>

<!-- Navbar -->
<nav class="navbar navbar-expand-lg navbar-light bg-light">
    <div class="container-fluid">
        <a class="navbar-brand" href="#">Museo</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav mx-auto">
                <li class="nav-item">
                    <a class="nav-link active" href="#">Inicio</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#">Listado</a>
                </li>
                <?php if ($isLoggedIn): ?>
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                        <?php echo htmlspecialchars($_SESSION['user']['nombre']); ?>
                    </a>
                    <ul class="dropdown-menu">
                        <li><a class="dropdown-item" href="#">Perfil</a></li>
                        <li><a class="dropdown-item" href="logout.php">Cerrar sesión</a></li>
                    </ul>
                </li>

                <li class="nav-item">
                    <a class="nav-link active" href="#"><?php echo $_SESSION["nivel"]; ?></a>
                </li>
                <?php endif; ?>
            </ul>
        </div>
    </div>
</nav>

<!-- Carrusel -->
<div id="carouselExample" class="carousel slide" data-bs-ride="carousel">
    <div class="carousel-inner">
        <div class="carousel-item active">
            <img src="https://via.placeholder.com/800x400?text=Imagen+1" class="d-block w-100" alt="...">
        </div>
        <div class="carousel-item">
            <img src="https://via.placeholder.com/800x400?text=Imagen+2" class="d-block w-100" alt="...">
        </div>
        <div class="carousel-item">
            <img src="https://via.placeholder.com/800x400?text=Imagen+3" class="d-block w-100" alt="...">
        </div>
        <div class="carousel-item">
            <img src="https://via.placeholder.com/800x400?text=Imagen+4" class="d-block w-100" alt="...">
        </div>
        <div class="carousel-item">
            <img src="https://via.placeholder.com/800x400?text=Imagen+5" class="d-block w-100" alt="...">
        </div>
    </div>
    <button class="carousel-control-prev" type="button" data-bs-target="#carouselExample" data-bs-slide="prev">
        <span class="carousel-control-prev-icon" aria-hidden="true"></span>
        <span class="visually-hidden">Previous</span>
    </button>
    <button class="carousel-control-next" type="button" data-bs-target="#carouselExample" data-bs-slide="next">
        <span class="carousel-control-next-icon" aria-hidden="true"></span>
        <span class="visually-hidden">Next</span>
    </button>
</div>

<div class="container mt-5">
    <h2 class="mb-4 text-center">Nuestras Tarjetas</h2>
    <div class="row">
        <div class="col-md-4 mb-3">
            <div class="card">
                <img src="https://via.placeholder.com/300" class="card-img-top" alt="Imagen 1">
                <div class="card-body">
                    <h5 class="card-title">Título 1</h5>
                    <p class="card-text">Descripción breve del contenido 1.</p>
                    <a href="#" class="btn btn-primary">Ir a...</a>
                </div>
            </div>
        </div>
        <div class="col-md-4 mb-3">
            <div class="card">
                <img src="https://via.placeholder.com/300" class="card-img-top" alt="Imagen 2">
                <div class="card-body">
                    <h5 class="card-title">Título 2</h5>
                    <p class="card-text">Descripción breve del contenido 2.</p>
                    <a href="#" class="btn btn-primary">Ir a...</a>
                </div>
            </div>
        </div>
        <div class="col-md-4 mb-3">
            <div class="card">
                <img src="https://via.placeholder.com/300" class="card-img-top" alt="Imagen 3">
                <div class="card-body">
                    <h5 class="card-title">Título 3</h5>
                    <p class="card-text">Descripción breve del contenido 3.</p>
                    <a href="#" class="btn btn-primary">Ir a...</a>
                </div>
            </div>
        </div>
    </div>
</div>


<!-- Horarios -->
<div class="container mt-5">
    <h2 class="mb-4 text-center">Horarios</h2>
    <p class="text-center">Lunes a Viernes: 9:00 AM - 5:00 PM</p>
    <p class="text-center">Sábados y Domingos: 10:00 AM - 4:00 PM</p>
</div>

<!-- Personal -->
<div class="container mt-5">
    <h2 class="mb-4 text-center">Personal</h2>
    <p class="text-center">Contamos con un equipo altamente capacitado para brindarte la mejor atención.</p>
</div>

<!-- Cómo llegar -->
<div class="container mt-5">
    <h2 class="mb-4 text-center">Cómo llegar</h2>
    <div class="w-full h-96">
        <iframe
            class="w-full h-full"
            src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3151.8354345096235!2d144.95373531561776!3d-37.81627987975189!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x6ad642af0f11c355%3A0x5045675218ceed31!2sFederation%20Square!5e0!3m2!1sen!2sau!4v1616362030426!5m2!1sen!2sau"
            width="600"
            height="450"
            style="border:0;"
            allowfullscreen=""
            loading="lazy"></iframe>
    </div>
</div>
<!-- Modal -->
<div class="modal fade" id="welcomeModal" tabindex="-1" aria-labelledby="welcomeModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="welcomeModalLabel">Bienvenido a Nuestra Museo 
               </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                Nos alegra tenerte aquí. Explora nuestras funciones y disfruta de la experiencia de gestion de usuario.
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                <button type="button" class="btn btn-primary">Comenzar</button>
            </div>
        </div>
    </div>
</div>




<!-- Pie de Página -->
<footer class="bg-light text-center py-3 mt-5">
    <p>&copy; <?php echo date('Y'); ?> Mi Aplicación. Todos los derechos reservados.</p>
</footer>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
<script>
    // Verifica si el parámetro 'bienvenido' está presente en la URL
    const urlParams = new URLSearchParams(window.location.search);
    if (urlParams.get('bienvenido') === '1') {
        // Muestra el modal al cargar la página
        var welcomeModal = new bootstrap.Modal(document.getElementById('welcomeModal'));
        welcomeModal.show();
    }
</script>
</html>
