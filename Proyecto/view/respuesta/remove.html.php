<?php

$datosRespuesta = $dataToView["respuesta"];
$usuarioRespuesta = $dataToView["usuario"]; 



?>
<div style="display: flex; flex-direction: column;justify-content: center; align-items:center;">
    <h1><strong>Estás seguro de que quieres eliminar la siguiente respuesta?</strong></h1>

    <div class="contenedorRespuestaDivididor">
                <div class="fotoUsuarioRespuesta">
                    <img src="<?php echo file_exists($usuarioRespuesta["foto_perfil"]) ? $usuarioRespuesta["foto_perfil"] : $fotoUsuarioPorDefecto;?>" alt="Foto de usuario">
                </div>
                <div class="respuesta">
                    <div class="estrella-respuesta"></div>
                    <div class="contenidoRespuesta">
                        <?php echo $datosRespuesta["texto"]; ?>
                        <?php if($datosRespuesta["imagen"] != null){?>
                            <img class="imagenRespuesta" src="<?php echo $datosRespuesta["imagen"];?>" alt="Imagen de respuesta">
                        <?php }?>
                    </div>
                </div>
    </div>
    <div class="panelDeBotones" style="gap: 1em;">
            
            <a class= "botonCancelarRespuesta"href="index.php?controller=respuesta&action=delete&id_respuesta=<?=$datosRespuesta["id"]?>&id_pregunta=<?=$datosRespuesta["id_pregunta"]?>">Eliminar</a>
            <a class="botonGuardarRespuesta"href="index.php?controller=respuesta&action=view&id_pregunta=<?=$datosRespuesta["id_pregunta"]?>">Volver</a>

    </div>
    
    


</div>