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
        <link rel="stylesheet" href="assets/css/temasDark.css"> <!-- Estilos adicionales modo oscuro -->
    <?php endif; ?>

</head>
<body>
<div class="container">
    <!-- Comienzo Header -->
    <header class="header">
            <div class="logo" id="logoBtn">
                <img src="assets/img/LogoVectorizado.svg" alt="Logo">
            </div>

            <div class="busqueda">
                <div class="iconos lupa">
                    <i class="bi bi-search"></i>
                </div>
                <input class="barra-busq" type="text" name="" placeholder="Busqueda...">
                <div class="filtro">
                    <button id="btnFiltro" class="iconos">
                        <i class="bi bi-funnel-fill"></i>
                    </button>
                </div>
            </div>
                
            <div class="iconos panel-botones">
                <i class="bi bi-chat-left-fill"></i>
                <i class="bi bi-bell-fill"></i>
                <i id = "person" class="bi bi-person-fill"></i>
                <!-- Formulario para cambiar entre modo oscuro y claro -->
                <form method="POST" action="">
                    <button type="submit" name="toggleDarkMode" class="iconosDark">
                        <!-- Cambiar el icono dependiendo del modo activo -->
                        <i class="bi <?= $darkModeEnabled ? 'bi-moon-stars-fill' : 'bi-moon-stars'; ?>"></i>
                    </button>
                </form>
            </div>
        </header>
    <script src="assets/js/redirect.js"></script>
        <!-- Fin Header -->