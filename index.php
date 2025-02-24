<?php
session_start(); // Iniciar la sesión


//var_dump($_SESSION);
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mi Aplicación</title>
    <!-- Incluye Bootstrap CSS para el modal -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@1.9.6/dist/tailwind.min.css" rel="stylesheet">
    <link rel="stylesheet" href="styles.css"> <!-- Tu hoja de estilos personalizada -->
</head>
<style>
        /* Carrusel */
        .carousel-inner img {
            width: 100%;
            height: 900px;
            object-fit: cover;
        }

        /* Tarjetas */
        .card-img-top {
            width: 100%;
            height: 200px;
            object-fit: cover;
            border-radius: 10px;
        }
    </style>
<body>

<?php include("./includes/navbar.php") ?>

<!-- Carrusel -->
<div id="carouselExample" class="carousel slide" data-bs-ride="carousel">
    <div class="carousel-inner">
        <div class="carousel-item active">
            <img src="./assets/img/c1.webp" class="d-block w-100" alt="...">
        </div>
        <div class="carousel-item">
            <img src="./assets/img/c2.webp" class="d-block w-100" alt="...">
        </div>
        <div class="carousel-item">
            <img src="./assets/img/c3.webp" class="d-block w-100" alt="...">
        </div>
        <div class="carousel-item">
            <img src="./assets/img/c4.jpg" class="d-block w-100" alt="...">
        </div>
        <div class="carousel-item">
            <img src="./assets/img/c5.jpg" class="d-block w-100" alt="...">
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
    <h2 class="mb-4 text-center">Nuestra Coleccion de Piezas</h2>
    <div class="row">
        <div class="col-md-4 mb-3">
            <div class="card">
                <img src="https://via.placeholder.com/300" class="card-img-top" alt="Imagen 1">
                <div class="card-body">
                    <h5 class="card-title">Título 1</h5>
                    <p class="card-text">Descripción breve del contenido 1.</p>
              
                </div>
            </div>
        </div>
        <div class="col-md-4 mb-3">
            <div class="card">
                <img src="https://via.placeholder.com/300" class="card-img-top" alt="Imagen 2">
                <div class="card-body">
                    <h5 class="card-title">Título 2</h5>
                    <p class="card-text">Descripción breve del contenido 2.</p>
                    
                </div>
            </div>
        </div>
        <div class="col-md-4 mb-3">
            <div class="card">
                <img src="https://via.placeholder.com/300" class="card-img-top" alt="Imagen 3">
                <div class="card-body">
                    <h5 class="card-title">Título 3</h5>
                    <p class="card-text">Descripción breve del contenido 3.</p>
                   
                </div>
            </div>
        </div>
    </div>
</div>


<!-- Sección de Horarios -->
<div class="container mx-auto my-12 px-4">
    <h2 class="text-3xl font-bold text-center text-gray-800 mb-6">Horarios de Apertura</h2>
    <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
        <div class="bg-white p-6 rounded-lg shadow-lg">
            <h3 class="text-xl font-semibold text-gray-700 mb-4">Lunes a Viernes</h3>
            <p class="text-lg text-gray-600">8:00 AM - 12:00 PM</p>
        </div>
        <div class="bg-white p-6 rounded-lg shadow-lg">
            <h3 class="text-xl font-semibold text-gray-700 mb-4">Sábados y Domingos</h3>
            <p class="text-lg text-gray-600">Solo si es posible algun evento especial</p>
        </div>
    </div>
</div>

<!-- Sección de Nuestro Personal -->
<div class="container mx-auto my-12 px-4">
    <h2 class="text-3xl font-bold text-center text-gray-800 mb-8">Conoce a Nuestro Equipo</h2>
    <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-8">
        <!-- Miembro 1 -->
        <div class="bg-white p-6 rounded-lg shadow-lg hover:shadow-xl transition-shadow duration-300">
            <img class="w-32 h-32 rounded-full mx-auto mb-4" src="https://via.placeholder.com/150" alt="Foto del miembro 1">
            <h3 class="text-xl font-semibold text-gray-800 text-center mb-2">Personal</h3>
            <p class="text-gray-600 text-center">Directora de Exposiciones</p>
            <p class="text-gray-500 text-center mt-2">María es responsable de la organización y curaduría de todas las exposiciones temporales y permanentes del museo.</p>
        </div>

        <!-- Miembro 2 -->
        <div class="bg-white p-6 rounded-lg shadow-lg hover:shadow-xl transition-shadow duration-300">
            <img class="w-32 h-32 rounded-full mx-auto mb-4" src="https://via.placeholder.com/150" alt="Foto del miembro 2">
            <h3 class="text-xl font-semibold text-gray-800 text-center mb-2">Personal</h3>
            <p class="text-gray-600 text-center">Curador de Arte Contemporáneo</p>
            <p class="text-gray-500 text-center mt-2">Juan se encarga de la selección y adquisición de obras para la colección de arte contemporáneo del museo.</p>
        </div>

        <!-- Miembro 3 -->
        <div class="bg-white p-6 rounded-lg shadow-lg hover:shadow-xl transition-shadow duration-300">
            <img class="w-32 h-32 rounded-full mx-auto mb-4" src="https://via.placeholder.com/150" alt="Foto del miembro 3">
            <h3 class="text-xl font-semibold text-gray-800 text-center mb-2">Personal</h3>
            <p class="text-gray-600 text-center">Jefa de Educación y Programas Públicos</p>
            <p class="text-gray-500 text-center mt-2">Ana coordina programas educativos y visitas guiadas, ayudando a acercar el arte a nuestra comunidad.</p>
        </div>

        <!-- Miembro 4 -->
        <div class="bg-white p-6 rounded-lg shadow-lg hover:shadow-xl transition-shadow duration-300">
            <img class="w-32 h-32 rounded-full mx-auto mb-4" src="https://via.placeholder.com/150" alt="Foto del miembro 4">
            <h3 class="text-xl font-semibold text-gray-800 text-center mb-2">Personal </h3>
            <p class="text-gray-600 text-center">Responsable de Comunicaciones</p>
            <p class="text-gray-500 text-center mt-2">Carlos se encarga de las relaciones públicas, marketing y difusión de las actividades del museo.</p>
        </div>
    </div>
</div>
<!-- Sección Cómo Llegar -->
<div class="container mx-auto my-12 px-4">
    <h2 class="text-3xl font-semibold text-center text-gray-800 mb-6">Cómo Llegar</h2>
    
    <!-- Contenedor para mapa y texto -->
    <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
        <!-- Mapa de Google -->
        <div class="w-full h-96 rounded-lg shadow-lg overflow-hidden">
            <iframe
                class="w-full h-full"
                src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d1722.3024939965837!2d-61.23558934628762!3d-30.305450861353897!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x944a79585c650f09%3A0xac8f5cfe4eb19f9e!2sLiceo%20Municipal%20%C3%81ngela%20Peralta%20Pino!5e0!3m2!1ses!2sar!4v1727321544657!5m2!1ses!2sar"
                style="border:0;" allowfullscreen="" loading="lazy"></iframe>
        </div>

        <!-- Apartado de Indicaciones a la Derecha -->
        <div class="bg-white p-6 rounded-lg shadow-lg">
            <h3 class="text-2xl font-semibold text-gray-700 mb-4">Liceo Municipal Ángela Peralta Pino</h3>
            <p class="text-lg text-gray-600 mb-4">Nuestro museo se encuentra en una ubicación central y accesible. Disponible a todo publico dentro de nuestros horarios de apertura.</p>
            
            <ul class="list-disc pl-6 text-gray-600 space-y-3">
                Lorem ipsum dolor sit amet consectetur adipisicing elit. Libero, doloremque illum aperiam est, facilis labore nisi ipsam incidunt autem voluptates unde eligendi rem. Hic commodi at, natus consequatur sed nulla!
                Lorem ipsum dolor sit amet consectetur adipisicing elit. Doloremque, non exercitationem qui fugiat repellat sint possimus sed ipsum corrupti praesentium repudiandae. Possimus temporibus doloribus iure ipsam repellendus? Dolorum, repellat modi!
            </ul>
        </div>
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
<!-- Modal de acceso denegado -->
<div class="modal fade" id="denegadoModal" tabindex="-1" aria-labelledby="denegadoModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="denegadoModalLabel">Acceso Denegado</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <p>Has intentado acceder a una página sin autorización. Tu intento ha sido denegado.</p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
            </div>
        </div>
    </div>
</div>


<!-- Pie de Página -->
<?php include("./includes/footer.php") ?>

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
