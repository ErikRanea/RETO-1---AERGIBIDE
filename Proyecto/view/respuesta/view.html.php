<?php

    $pregunta = $dataToView["pregunta"];
    $respuestas = $dataToView["respuestas"];
    print_r($respuestas["datosRespuestas"]["id"]);
    die();
?>


<div class="contenedorPreguntasYRespuestas">
    <div class="contenedorPregunta">
        <div class="fotoUsuarioPregunta">
            <?php
                $fotoUsuarioPregunta = "assets/img/fotoPorDefecto.png";
                
                
            ?>
            <img src="assets/img/fotoPorDefecto.png" alt="Foto de usuario">
        </div>
        <div class="preguntaTitulo">
            Título de la Pregunta
        </div>
        <div class="descripcionPregunta">
            Descripción de la pregunta aquí.
        </div>
        <div class="panelDeBotones">
            Botones de acción
        </div>
    </div>
    <?php
    

    
    
    ?>
    <div class="contenedorRespuestaDivididor">
        <div class="fotoUsuarioRespuesta">
            <img src="assets/img/fotoPorDefecto.png" alt="Foto de usuario">
        </div>
        <div class="respuesta">
            Respuesta
        </div>
        <div class="panelDeBotones">
            Botones locos
        </div>

    </div>

</div>