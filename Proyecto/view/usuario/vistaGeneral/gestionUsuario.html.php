    <div class="containerPanel">
        <div class="botonesArriba">
            <a href="index.php?controller=usuario&action=mostrarGestionUsuario" class="lateralBoton <?php echo ($currentController === 'usuario' && $currentAction === 'mostrarGestionUsuario') ? 'active' : ''; ?>">
                Gestión Usuarios
            </a>
            <a href="index.php?controller=usuario&action=nuevoUsuario" class="lateralBoton <?php echo ($currentController === 'usuario' && $currentAction === 'nuevoUsuario') ? 'active' : ''; ?>">
                Nuevo Usuario
            </a>
        </div>

        <div>

        </div>
    </div>