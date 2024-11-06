<?php

$datosPregunta = $dataToView["pregunta"];
$usuarioPregunta = $dataToView["usuario"]; 



?>
<div style="display: flex; flex-direction: column;justify-content: center; align-items:center;">
    <h1><strong>Estás seguro de que quieres eliminar la siguiente pregunta?</strong></h1>

    <div class="contenedorPregunta">
        <div class="fotoUsuarioPregunta">
            <?php

                $fotoUsuarioPorDefecto = "assets/img/fotoPorDefecto.png";
               
                
            ?>
            <img src="<?php echo file_exists($usuarioPregunta["foto_perfil"]) ? $usuarioPregunta["foto_perfil"] : $fotoUsuarioPorDefecto;?>" alt="Foto de usuario">
        </div>

        <div class="preguntaTitulo">
           <p><?php echo isset($datosPregunta["titulo"]) ? $datosPregunta["titulo"] : "Titulo no encontrado";?></p>
        </div>
        <div class="descripcionPregunta">
            <?php echo isset($datosPregunta["texto"]) && $datosPregunta["texto"] != null ? $datosPregunta["texto"] : "";?>
        </div>
    <div class="panelDeBotones" style="gap: 1em;">
            
            <a class= "botonCancelarRespuesta"href="index.php?controller=pregunta&action=delete&id_pregunta=<?=$datosPregunta["id"]?>&id_tema=<?=$datosPregunta["id_tema"]?>">Eliminar</a>
            <a class="botonGuardarRespuesta"href="index.php?controller=respuesta&action=view&id_pregunta=<?=$datosPregunta["id"]?>">Volver</a>

    </div>
    
    


</div>