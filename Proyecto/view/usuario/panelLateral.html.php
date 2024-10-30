<?php
    $currentController = $_GET['controller'] ?? '';
    $currentAction = $_GET['action'] ?? '';
?>

<div class="panelLateral">
    <p><a href="index.php?controller=usuario&action=mostrarDatosUsuario"
            class="lateralBoton <?php echo ($currentController === 'usuario' && $currentAction === 'mostrarDatosUsuario') ? 'active' : ''; ?>">
            Datos de usuario
        </a>
    </p>

    <p><a href="index.php?controller=usuario&action=mostrarActividad"
    class="lateralBoton <?php echo ($currentController === 'usuario' && $currentAction === 'mostrarActividad') ? 'active' : ''; ?>">
            Actividad
        </a>
    </p>

    <p><a href="index.php?controller=usuario&action=mostrarPanelDeControl"
    class="lateralBoton <?php echo ($currentController === 'usuario' && $currentAction === 'mostrarPanelDeControl') ? 'active' : ''; ?>">
            Panel de control
        </a>
    </p>
</div>