<?php
$usuario = $_SESSION["user_data"];
?>

<div class="panelActividad">
    <div class="panelLateralMovil">
        <button class="btn btnCrear btnPanelLateral " id="btnDatos">Datos de Usuario</button>
        <button class="btn btnCrear btnPanelLateral" id="btnActividad">Actividad</button>
        <?php if ( $usuario["rol"] == "admin" || $usuario["rol"] == "gestor" ): ?>
            <button class="btn btnCrear btnPanelLateral active" id="btnPanelControl">Panel de Control</button>
        <?php endif; ?>

    </div>

    <div class="panelGestion">
    <div class="botonesArriba">
        <button class="btn btnCrear btnPanelGestion" id="btnGestion">Gestión Usuarios</button>
        <button class="btn btnCrear btnPanelGestion" id="btnNuevousuario">Nuevo Usuario</button>
    </div>

    <div class="contenidoGestion" id="contenidoGestion">

    </div>
</div>

