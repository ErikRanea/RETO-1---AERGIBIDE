<?php
$usuario = $_SESSION["user_data"];
//print_r($usuario)
?>

<div class="user-profile-container">
    <div class="main-container">
        <!-- Panel lateral fijo -->
        <div class="side-panel">
            <div class="button-group">
            <button class="btn btnCrear btnPanelLateral" id="btnDatos">Datos de Usuario</button>
            <button class="btn btnCrear btnPanelLateral" id="btnActividad">Actividad</button>
            <?php if ( $usuario["rol"] == "admin" || $usuario["rol"] == "gestor" ): ?>
                <button class="btn btnCrear btnPanelLateral" id="btnPanelControl">Panel de Control</button>
            <?php endif; ?>
            </div>
        </div>

    <div id="panelPrincipalUsuario">
    </div>
    </div>
</div>