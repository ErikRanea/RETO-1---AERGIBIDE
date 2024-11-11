<?php
$usuario = $_SESSION["user_data"];
?>

<div class="panelActividad">
    <div class="panelLateralMovil">
        <button class="btn btnCrear btnPanelLateral " id="btnDatos">Datos de Usuario</button>
        <button class="btn btnCrear btnPanelLateral active" id="btnActividad">Actividad</button>
        <?php if ( $usuario["rol"] == "admin" || $usuario["rol"] == "gestor" ): ?>
            <button class="btn btnCrear btnPanelLateral" id="btnPanelControl">Panel de Control</button>
        <?php endif; ?>

    </div>

    <div class="panelBotones">
        <button class="btn btnCrear btnPanelActividad" id="btnPregunta">Preguntas</button>
        <button class="btn btnCrear btnPanelActividad" id="btnRespuesta">Respuestas</button>
        <button class="btn btnCrear btnPanelActividad" id="btnGuardado">Guardados</button>

        <input type="hidden" value="<?= $usuario["username"] ?>" id="username">
    </div>

    <div class="contenidoActividad" id="contenidoActividad">

    </div>

</div>
