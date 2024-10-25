<?php
// Incluir el archivo del controlador que maneja el modo oscuro
include 'controller/DarkModeController.php';

// Comprobar si la cookie de modo oscuro está habilitada
$darkModeEnabled = isset($_COOKIE['darkMode']) && $_COOKIE['darkMode'] === 'enabled';
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>AERGIBIDE</title>
    <link rel="stylesheet" href="assets/css/style.css">
    <link rel="stylesheet" href="assets/css/tema.css">
    <link rel="stylesheet" href="assets/css/pregunta.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">

    <!-- Cargar los estilos de modo oscuro si la cookie está habilitada -->
    <?php if ($darkModeEnabled): ?>
        <link rel="stylesheet" href="assets/css/darkModeStyle.css"> <!-- Estilos base modo oscuro -->
    <?php endif; ?>
</head>
<body>
<div class="wrapper">
    <div class="container">
        <!-- Comienzo Header -->
        <header class="header">
            <div class="logo" id="logoBtn">
                <img src="assets/img/LogoVectorizado.svg" alt="Logo">
            </div>

            <div class="busqueda">
                <form method="GET" action="index.php" style="display: flex; align-items: center; width: 100%;">
                    <input type="hidden" name="controller" value="Busqueda">
                    <input type="hidden" name="action" value="buscar">

                    <div class="iconos lupa">
                        <button id="btnLupa" class="iconos">
                            <i class="bi bi-search"></i>
                        </button>
                    </div>

                    <input class="barra-busq" type="text" name="termino" placeholder="Busqueda...">

                    <div class="filtro">
                        <button id="btnFiltro" class="iconos">
                            <i class="bi bi-funnel-fill"></i>
                        </button>
                    </div>

                    <button type="submit" style="display: none;"></button> <!-- Este botón se usará para enviar el formulario -->
                </form>
            </div>


            <div class="iconos panel-botones">
                <i class="bi bi-chat-left-fill"></i>
                <i class="bi bi-bell-fill"></i>
                <i id="person" class="bi bi-person-fill"></i>

                <!-- Menú desplegable -->
                <div id="dropdown" class="dropdown-content">
                    <a id="person1" href="index.php?controller=usuario&action=mostrardatosusuario">Configuración</a>
                    <a href="index.php?controller=usuario&action=cerrarSesion">Cerrar sesión</a>
                </div>

                <!-- Formulario para cambiar entre modo oscuro y claro -->
                <form method="POST" action="">
                    <button type="submit" name="toggleDarkMode" class="iconosDark">
                        <i class="bi <?= $darkModeEnabled ? 'bi-moon-stars-fill' : 'bi-moon-stars'; ?>"></i>
                    </button>
                </form>
            </div>
        </header>

        <!-- Fin Header -->