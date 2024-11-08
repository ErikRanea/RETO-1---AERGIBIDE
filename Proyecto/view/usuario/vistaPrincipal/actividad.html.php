<?php
$usuario = $_SESSION["user_data"];
?>

<div class="panelActividad">
    <div class="panelBotones">
        <button class="btn btnCrear btnPanelActividad" id="btnPregunta">Preguntas</button>
        <button class="btn btnCrear btnPanelActividad" id="btnRespuesta">Respuestas</button>
        <button class="btn btnCrear btnPanelActividad" id="btnGuardado">Guardados</button>

        <input type="hidden" value="<?= $usuario["username"] ?>" id="username">
    </div>

    <div class="contenidoActividad" id="contenidoActividad">

    </div>

</div>
