<?php
session_start(); // Iniciar la sesión
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mi Aplicación</title>
    <!-- Incluye Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Incluye Tailwind CSS -->
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@1.9.6/dist/tailwind.min.css" rel="stylesheet">
    <!-- Estilos personalizados -->
    <style>
        /* Carrusel */
        .carousel-inner img {
            width: 100%;
            height: 600px;
            object-fit: cover;
        }

        /* Tarjetas */
        .card-img-top {
            width: 100%;
            height: 200px;
            object-fit: cover;
            border-radius: 10px;
        }

        /* Colores personalizados */
        .bg-primary-custom {
            background-color: #1e3a8a; /* Azul oscuro */
        }
        .bg-secondary-custom {
            background-color: #10b981; /* Verde */
        }
        .text-primary-custom {
            color: #1e3a8a;
        }
        .text-secondary-custom {
            color: #10b981;
        }
    </style>
</head>
<body class="bg-gray-100">

<!-- Navbar -->
<?php include("./includes/navbar.php"); ?>

<!-- Carrusel -->
<div id="carouselExample" class="carousel slide" data-bs-ride="carousel">
    <div class="carousel-inner">
        <div class="carousel-item active">
            <img src="./assets/img/c1.jpg" class="d-block w-100" alt="...">
        </div>
        <div class="carousel-item">
            <img src="./assets/img/c2.jpg" class="d-block w-100" alt="...">
        </div>
        <div class="carousel-item">
            <img src="./assets/img/c3.jpg" class="d-block w-100" alt="...">
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

<!-- Sección de Bienvenida -->
<?php include("./includes/secciones/bienvenida.php"); ?>

<!-- Sección de Colecciones -->
<?php include("./includes/secciones/colecciones.php"); ?>

<!-- Sección de Horarios -->
<?php include("./includes/secciones/horarios.php"); ?>

<!-- Sección de Nuestro Personal -->
<?php include("./includes/secciones/personal.php"); ?>

<!-- Sección de Imagen Grande con Texto -->
<?php include("./includes/secciones/mural.php"); ?>

<!-- Sección de Eventos -->
<?php include("./includes/secciones/eventos.php"); ?>

<!-- Sección de Testimonios -->
<?php include("./includes/secciones/testimonios.php"); ?>

<!-- Sección Cómo Llegar -->
<?php include("./includes/secciones/como_llegar.php"); ?>

<!-- Pie de Página -->
<?php include("./includes/footer.php"); ?>

<!-- Bootstrap JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>