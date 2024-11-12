<?php
$usuario = $_SESSION["user_data"];
?>
<div class="container-fluid panel-actividad">
    <div class="row">
        <div class="col-12">
            <div class="panelLateralMovil d-md-none mb-3">
                <button class="btn btn-outline-primary btn-panel-lateral" id="btnDatos">Datos de Usuario</button>
                <button class="btn btn-outline-primary btn-panel-lateral active" id="btnActividad">Actividad</button>
                <?php if ( $usuario["rol"] == "admin" || $usuario["rol"] == "gestor" ): ?>
                    <button class="btn btn-outline-primary btn-panel-lateral" id="btnPanelControl">Panel de Control</button>
                <?php endif; ?>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-12">
            <div class="panel-botones-actividad mb-3">
                <button class="btnAc btnPanelActividad" id="btnPregunta">Preguntas</button>
                <button class="btnAc btnPanelActividad" id="btnRespuesta">Respuestas</button>
                <button class="btnAc btnPanelActividad" id="btnGuardado">Guardados</button>
                <input type="hidden" value="<?= $usuario["username"] ?>" id="username">
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-12">
            <div class="contenido-actividad" id="contenidoActividad">
                <!-- El contenido de la actividad se cargará aquí dinámicamente -->
            </div>
        </div>
    </div>
</div>