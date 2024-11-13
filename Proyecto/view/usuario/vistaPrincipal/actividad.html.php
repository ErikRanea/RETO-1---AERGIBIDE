<?php
$usuario = $_SESSION["user_data"];
?>
<div class="container panel-actividad">
    <div class="row justify-content-center">
        <div class="col-12 col-md-10 col-lg-8">
            <div class="panelLateralMovil mb-4">
                <button class="btn btnCrear btnPanelLateral" id="btnDatos">Datos de Usuario</button>
                <button class="btn btnCrear btnPanelLateral active" id="btnActividad">Actividad</button>
                <?php if ( $usuario["rol"] == "admin" || $usuario["rol"] == "gestor" ): ?>
                    <button class="btn btnCrear btnPanelLateral" id="btnPanelControl">Panel de Control</button>
                <?php endif; ?>
            </div>

            <div class="panel-botones-actividad mb-4">
                <button class="btnAc btnPanelActividad" id="btnPregunta">Preguntas</button>
                <button class="btnAc btnPanelActividad" id="btnRespuesta">Respuestas</button>
                <button class="btnAc btnPanelActividad" id="btnGuardado">Guardados</button>
                <input type="hidden" value="<?= $usuario["username"] ?>" id="username">
            </div>

            <div class="contenido-actividad" id="contenidoActividad">
                <!-- El contenido de la actividad se cargará aquí dinámicamente -->
            </div>
        </div>
    </div>
</div>