<?php


    $pregunta = $dataToView["pregunta"]["datosPregunta"];
    $usuarioPregunta = $dataToView["pregunta"]["usuarioPregunta"];


    $respuestas = $dataToView["respuestas"];

?>


<div class="contenedorPreguntasYRespuestas">
    <div class="contenedorPregunta">
        <div class="fotoUsuarioPregunta">
            <?php

                $fotoUsuarioPorDefecto = "assets/img/fotoPorDefecto.png";
               
                
            ?>
            <img src="<?php echo file_exists($usuarioPregunta["foto_perfil"]) ? $usuarioPregunta["foto_perfil"] : $fotoUsuarioPorDefecto;?>" alt="Foto de usuario">
        </div>

        <div class="preguntaTitulo">
            <?php echo isset($pregunta["titulo"]) ? $pregunta["titulo"] : "Titulo no encontrado";?>
        </div>
    

        <div class="descripcionPregunta">
            <?php echo isset($pregunta["texto"]) && $pregunta["texto"] != null ? $pregunta["texto"] : "";?>
        </div>
        <div class="panelDeBotones">
            <button class="botonPanel">
                <i class="bi bi-airplane"></i>
            </button>
            <p>
                <?php echo isset($pregunta["votos"]) ? $pregunta["votos"] : 0;?>
            </p>
            <button class="botonPanel">
                <i class="bi bi-airplane airplane-down"></i>
            </button>
            <button class="botonPanel">
                <i class="bi bi-bookmark-fill"></i>
            </button>
        </div>
    </div>
    
    <div class="contenedorRespuesta">

    
    <?php

    if(count($respuestas["datosRespuestas"]) > 0)
    {
        for ($i=0; $i < count($respuestas["datosRespuestas"]); $i++) { 
            $usuarioRespuesta = $respuestas["usuariosRespuestas"][$i];
            $datosRespuesta = $respuestas["datosRespuestas"][$i];
            ?>
            <div class="contenedorRespuestaDivididor">
                <div class="fotoUsuarioRespuesta">
                    <img src="<?php echo file_exists($usuarioRespuesta["foto_perfil"]) ? $usuarioRespuesta["foto_perfil"] : $fotoUsuarioPorDefecto;?>" alt="Foto de usuario">
                </div>
                <div class="respuesta">
                    <?php echo $datosRespuesta["texto"]; ?>
                    <?php if($datosRespuesta["imagen"] != null){?>
                        <img class="imagenRespuesta" src="<?php echo $datosRespuesta["imagen"];?>" alt="Imagen de respuesta">
                    <?php }?>
                </div>
                <div class="panelDeBotones">
                    <button class="botonPanel">
                        <i class="bi bi-airplane"></i>
                    </button>
                    <p>
                        <?php echo isset($datosRespuesta["votos"]) ? $datosRespuesta["votos"] : 0;?>
                    </p>
                    <button class="botonPanel">
                        <i class="bi bi-airplane airplane-down"></i>
                    </button>
                    <button class="botonPanel">
                        <i class="bi bi-bookmark-fill"></i>
                    </button>
                </div>
            </div>
    <?php

        }
    }
    

    ?>
    </div>
    <div class="publicarRespuesta">
        <form action="index.php?controller=respuesta&action=create&id_pregunta=<?php echo $pregunta["id"];?>" method="post" enctype="multipart/form-data">
        <div class="contenedorRespuestaDivididor">
                <div class="fotoUsuarioRespuesta">
                    <img src="<?php echo file_exists($_SESSION["user_data"]["foto_perfil"]) ? $_SESSION["user_data"]["foto_perfil"] : $fotoUsuarioPorDefecto;?>" alt="Foto de usuario">
                </div>
                <div class="respuesta">
                    <textarea class="textAreaRespuesta"name="texto" id=""></textarea>
                    <input type="file" name="imagen" id="" accept="image/*">
                </div>
                <div class="panelDeBotones">
                    <button class="botonPanel" type="submit">
                        <i class="bi bi-send"></i>
                    </button>
                </div>
            </div>
        </form>
    </div>


</div>