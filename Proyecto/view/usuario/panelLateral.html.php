<?php
    $currentController = $_GET['controller'] ?? '';
    $currentAction = $_GET['action'] ?? '';
    $rolUsuario = $_SESSION['user_data']['rol'] ?? 'admin';
?>

<div class="panelLateral">
    <p><a href="index.php?controller=usuario&action=mostrarDatosUsuario&id=<?php echo $_SESSION["user_data"]["id"] ?>"
            class="lateralBoton <?php echo ($currentController === 'usuario' && $currentAction === 'mostrarDatosUsuario') ? 'active' : ''; ?>">
            Datos de usuario
        </a>
    </p>

    <p><a href="index.php?controller=usuario&action=vistaActividad"
    class="lateralBoton <?php echo ($currentController === 'usuario' && $currentAction === 'mostrarActividad') ? 'active' : ''; ?>">
            Actividad
        </a>
    </p>

    <?php if ($rolUsuario === 'admin' || $rolUsuario === 'gestor'): ?>
    <p><a href="index.php?controller=usuario&action=mostrarGestionUsuario"
    class="lateralBoton <?php echo ($currentController === 'usuario' && $currentAction === 'mostrarGestionUsuario' || $currentAction === 'nuevoUsuario') ? 'active' : ''; ?>">
            Panel de control
        </a>
    </p>
    <?php endif; ?>
</div>