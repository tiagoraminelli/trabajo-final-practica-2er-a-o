<?php
$isLoggedIn = isset($_SESSION['user']);
$isLoggedInName = isset($_SESSION['name']);
$isLoggedInLvl = isset($_SESSION['nivel']);

?>
<!-- Navbar -->
<nav class="navbar navbar-expand-lg navbar-light bg-light">
    <div class="container-fluid">
        <a class="navbar-brand" href="index.php">Museo</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav mx-auto">
                <!-- Link al inicio -->
                <li class="nav-item">
                    <a class="nav-link active" href="index.php">Inicio</a>
                </li>

                <!-- Link de login cuando el usuario no está logueado -->
                <?php if (!$isLoggedIn): ?>
                <li class="nav-item">
                    <a class="nav-link" href="login.php">Login</a>
                </li>
                <?php endif; ?>

                <!-- Menú de usuario logueado -->
                <?php if ($isLoggedIn): ?>
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                        <?php echo htmlspecialchars($_SESSION['user']['nombre']); ?>
                    </a>
                    <ul class="dropdown-menu">
                        <li><a class="dropdown-item disabled"><?php echo htmlspecialchars($_SESSION['user']['idUsuario']); ?></a></li>
                        <li><a class="dropdown-item" href="perfil.php?id=<?php echo($_SESSION['user']['idUsuario']); ?>">Perfil</a></li>
                        <li><a class="dropdown-item" href="logout.php">Cerrar sesión</a></li>
                    </ul>
                </li>

                <!-- Menú de Listados -->
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" id="listadosDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                        Listados
                    </a>
                    <ul class="dropdown-menu" aria-labelledby="listadosDropdown">
                        <li><a class="dropdown-item" href="listados.php">Piezas</a></li>
                        <li><a class="dropdown-item" href="arqueologia.php">Arqueología</a></li>
                        <li><a class="dropdown-item" href="paleontologia.php">Paleontología</a></li>
                        <li><a class="dropdown-item" href="osteologia.php">Osteología</a></li>
                        <li><a class="dropdown-item" href="ictiologia.php">Ictiología</a></li>
                        <li><a class="dropdown-item" href="octologia.php">Octología</a></li>
                        <li><a class="dropdown-item" href="geologia.php">Geología</a></li>
                        <li><a class="dropdown-item" href="botanica.php">Botánica</a></li>
                        <li><a class="dropdown-item" href="zoologia.php">Zoología</a></li>
                    </ul>
                </li>

                <!-- Nivel de usuario -->
                <li class="nav-item">
                    <a class="nav-link active" href="#"><?php echo $_SESSION["nivel"]; ?></a>
                </li>
                <!-- Mostrar el nivel de usuario solo si es nivel 1 -->
        <?php if ($_SESSION['nivel'] == 1): ?>
            <li class="nav-item">
                <a class="nav-link active" href="agregarUser.php"></a>
            </li>
        <?php endif; ?>
                <?php endif; ?>
            </ul>
        </div>
    </div>
</nav>
