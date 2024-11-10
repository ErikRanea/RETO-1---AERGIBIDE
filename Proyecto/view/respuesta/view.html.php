<?php


    $pregunta = $dataToView["pregunta"]["datosPregunta"];
    $usuarioPregunta = $dataToView["pregunta"]["usuarioPregunta"];
    $respuestas = $dataToView["respuestas"];





    $respuestasGuardadas = $dataToView["guardados"]["respuestasGuardadas"];
    $preguntasGuardadas = $dataToView["guardados"]["preguntasGuardadas"];

    
    $respuestasLike = $dataToView["likes"]["respuestasLikes"];
    $preguntasLike = $dataToView["likes"]["preguntasLikes"];

    function verificarSiPreguntaGuardada($idPregunta, $preguntasGuardadas)
    {
        $estaGuardado = false;
        
        foreach ($preguntasGuardadas as $objPregunta) {

            if($objPregunta["id_pregunta"] == $idPregunta){ return $estaGuardado = true;}
        }

        return $estaGuardado;
    }

    function verificarSiRespuestaGuardada($idRespuesta,$respuestasGuardadas)
    {
        $estaGuardado = false;
        
        foreach ($respuestasGuardadas as $objRespuesta) {

            if($objRespuesta["id_respuesta"] == $idRespuesta){ return $estaGuardado = true;}
        }

        return $estaGuardado;
    }


    function verificarSiPreguntaLike($idPregunta,$preguntasLike)
    {
        $isLike = false;

        foreach($preguntasLike as $objPregunta)
        {
            if($objPregunta["id_pregunta"] == $idPregunta)
            {
                if($objPregunta["me_gusta"])
                {
                    return "esLike";
                }
                else
                {
                    return "esDisLike";
                }
            }
        }
        return $isLike;
        
    }
    
    function verificarSiRespuestaLike($idRespuesta,$respuestasLike)
    {
        $isLike = false;

        foreach($respuestasLike as $objRespuesta)
        {
            if($objRespuesta["id_respuesta"] == $idRespuesta)
            {
                if($objRespuesta["me_gusta"])
                {
                    return "esLike";
                }
                else
                {
                    return "esDisLike";
                }
            }
        }
        return $isLike;
        
    }

    function puedeEditar($id)
    {
        $puedeEditar = false;
        $idUsuario = $_SESSION["user_data"]["id"];
        $rol = $_SESSION["user_data"]["rol"];

        if($idUsuario == $id)
        {
             return $puedeEditar = true;
        }
        elseif (($rol == "admin") || ($rol == "gestor")) {
            return $puedeEditar = true;
        }

        return $puedeEditar;
    }

?>

<input type="text" id="userId" value="<?php echo $_SESSION["user_data"]['id']; ?>" hidden >
<div class="contenedorPreguntasYRespuestas">
    <i class="barra">
        <a href="index.php?controller=tema&action=mostrarTemas">
            Temas
        </a>

        <a href="index.php?controller=pregunta&action=list&id_tema=<?php echo $pregunta["id_tema"];?>">
            <?php echo $pregunta["tema"]["nombre"];?>
        </a>

        <?php echo $pregunta["titulo"];?>
    </i>
    <div class="contenedorPregunta">
        <div class="iconos-pregunta">
            <label id="editarPregunta" class="botonDeEditar" <?php if(!puedeEditar($usuarioPregunta["id"])){echo "hidden";}?>>
                <a href="index.php?controller=pregunta&action=edit&id_pregunta=<?php echo $pregunta["id"];?>"><i class="bi bi-pencil-square"></i></a>
            </label>
            <label id="eliminarPregunta" class="botonDeEditar" data-value="<?=$pregunta["id"]?>" <?php if(!puedeEditar($usuarioPregunta)){echo "hidden";}?>>
                <i class="bi bi-trash"></i>
            </label>
        </div>
        <div class="fotoUsuarioPregunta">
            <?php

                $fotoUsuarioPorDefecto = "assets/img/fotoPorDefecto.png";


            ?>
            <img src="<?php echo file_exists($usuarioPregunta["foto_perfil"]) ? $usuarioPregunta["foto_perfil"] : $fotoUsuarioPorDefecto;?>" alt="Foto de usuario">
            <span class="NameUserPregunta"><?php echo $usuarioPregunta["username"]; ?></span>
        </div>


    

        <div class="descripcionPregunta">
            <div class="preguntaTitulo">
                <p><?php echo isset($pregunta["titulo"]) ? $pregunta["titulo"] : "Titulo no encontrado";?></p>
            </div>
            <?php echo isset($pregunta["texto"]) && $pregunta["texto"] != null ? $pregunta["texto"] : "";?>
        </div>
        <div class="panelDeBotones">
            <?php
                $like = verificarSiPreguntaLike($pregunta["id"],$preguntasLike);
                if(!$like)
                {
                    ?>
                      <button class="botonPanel" id="botonPreguntaLike" value="<?php echo $pregunta["id"];?>">
                            <i class="bi bi-airplane"></i>
                        </button>
                        <p id="preguntaVoto" value="<?php echo $pregunta["votos"]["votos"];?>">
                            <?php //Cuando este la view de BD que recoja los likes meterlo aquí 
                            echo $pregunta["votos"]["votos"];?>
                        </p>
                        <button class="botonPanel" id="botonPreguntaDislike" value="<?php echo $pregunta["id"];?>">
                            <i class="bi bi-airplane airplane-down"></i>
                        </button>
                <?php
                }
                elseif($like == "esLike")
                {
                    ?>
                    <button class="botonPanel" id="botonPreguntaLike" value="<?php echo $pregunta["id"];?>">
                          <i class="bi bi-airplane-fill"></i>
                      </button>
                      <p id="preguntaVoto" value="<?php echo $pregunta["votos"]["votos"];?>">
                            <?php //Cuando este la view de BD que recoja los likes meterlo aquí
                            echo $pregunta["votos"]["votos"];?>
                        </p>
                      <button class="botonPanel" id="botonPreguntaDislike" value="<?php echo $pregunta["id"];?>">
                          <i class="bi bi-airplane airplane-down"></i>
                      </button>
                  <?php
                }
                else
                {
                    ?>
                    <button class="botonPanel" id="botonPreguntaLike" value="<?php echo $pregunta["id"];?>">
                          <i class="bi bi-airplane"></i>
                      </button>
                      <p id="preguntaVoto" value="<?php echo $pregunta["votos"]["votos"];?>">
                            <?php //Cuando este la view de BD que recoja los likes meterlo aquí
                            echo $pregunta["votos"]["votos"];?>
                        </p>
                      <button class="botonPanel" id="botonPreguntaDislike" value="<?php echo $pregunta["id"];?>">
                          <i class="bi bi-airplane-fill airplane-down"></i>
                      </button>
                  <?php
                }    
            
            ?>
            <button class="botonPanel" id="botonGuardarPregunta" value="<?php echo $pregunta["id"];?>">
                <?php
                    if(verificarSiPreguntaGuardada($pregunta["id"],$preguntasGuardadas))
                    {
                        ?><i class="bi bi-bookmark-fill"></i>
                    <?php
                    }
                    else
                    {?>
                        <i class="bi bi-bookmark"></i>
                    <?php
                    }
                ?>
                
            </button>
        </div>
    </div>
    
    <!--Aqui comienzan las respuestas-->



    
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
                <span class="NameUserRespuesta"><?php echo $usuarioRespuesta["username"]; ?></span>
                <div class="iconos-respuesta">
                    <label id="editarRespuesta-<?php echo $datosRespuesta["id"];?>" value="<?php echo $datosRespuesta["id"];?>" data-id-pregunta="<?php echo $pregunta["id"];?>" class="botonDeEditar"
                        <?php if(!puedeEditar($usuarioRespuesta["id"])){echo "hidden";}?>>
                        <i class="bi bi-pencil-square botonEditar"></i>
                    </label>
                    <label id="eliminarRespuesta-" class="botonDeBorrar" <?php if(!puedeEditar($usuarioPregunta)){echo "hidden";}?>>
                        <a href="index.php?controller=respuesta&action=remove&id_respuesta=<?php echo $datosRespuesta["id"];?>"><i class="bi bi-trash"></i></a></label>

                    <label>
                        <a <?php if($pregunta["id_usuario"] != $_SESSION["user_data"]["id"]){echo "hidden";}?>
                                href="index.php?controller=respuesta&action=esUtil&idRespuesta=<?php echo $datosRespuesta["id"];?>&idPregunta=<?php echo $pregunta["id"];?>">
                            <?php if($datosRespuesta["util"] == 1){?>
                                <i class="bi bi-star-fill"></i>
                            <?php }else{?>
                                <i class="bi bi-star"></i>
                            <?php }?>
                        </a>
                </div>
            </div>
            <div class="respuesta">
                    <div class="contenidoRespuesta">
                        <?php echo $datosRespuesta["texto"]; ?>

                    </div>
                <?php if($datosRespuesta["imagen"] != null){?>
                    <img class="imagenRespuesta" src="<?php echo $datosRespuesta["imagen"];?>" alt="Imagen de respuesta">
                <?php }?>

                </div>
                <div class="panelDeBotones">
                <?php
                $like = verificarSiRespuestaLike($datosRespuesta["id"],$respuestasLike);
                if(!$like)
                {
                    ?>
                    <button class="botonPanel" id="botonRespuestaLike-<?php echo $datosRespuesta["id"];?>" value="<?php echo $datosRespuesta["id"];?>">
                            <i class="bi bi-airplane"></i>
                        </button>
                        <p id="votosRespuesta-<?php echo $datosRespuesta["id"];?>" value="<?php echo $datosRespuesta["votos"]["votos"];?>">
                            <?php //Cuando este la view de BD que recoja los likes meterlo aquí 
                            echo $datosRespuesta["votos"]["votos"];?>
                        </p>
                        <button class="botonPanel" id="botonRespuestaDisLike-<?php echo $datosRespuesta["id"];?>" value="<?php echo $datosRespuesta["id"];?>">
                            <i class="bi bi-airplane airplane-down"></i>
                        </button>
                <?php
                }
                elseif($like == "esLike")
                {
                    ?>
                    <button class="botonPanel" id="botonRespuestaLike-<?php echo $datosRespuesta["id"];?>" value="<?php echo $datosRespuesta["id"];?>">
                          <i class="bi bi-airplane-fill"></i>
                      </button>
                      <p id="votosRespuesta-<?php echo $datosRespuesta["id"];?>" value="<?php echo $datosRespuesta["votos"]["votos"];?>">
                            <?php //Cuando este la view de BD que recoja los likes meterlo aquí
                            echo $datosRespuesta["votos"]["votos"];?>
                        </p>
                      <button class="botonPanel" id="botonRespuestaDisLike-<?php echo $datosRespuesta["id"];?>" value="<?php echo $datosRespuesta["id"];?>">
                          <i class="bi bi-airplane airplane-down"></i>
                      </button>
                  <?php
                }
                else
                {
                    ?>
                    <button class="botonPanel" id="botonRespuestaLike-<?php echo $datosRespuesta["id"];?>" value="<?php echo $datosRespuesta["id"];?>">
                          <i class="bi bi-airplane"></i>
                      </button>
                      <p id="votosRespuesta-<?php echo $datosRespuesta["id"];?>" value="<?php echo $datosRespuesta["votos"]["votos"];?>">
                            <?php //Cuando este la view de BD que recoja los likes meterlo aquí
                            echo $datosRespuesta["votos"]["votos"];?>
                        </p>
                      <button class="botonPanel" id="botonRespuestaDisLike-<?php echo $datosRespuesta["id"];?>" value="<?php echo $datosRespuesta["id"];?>">
                          <i class="bi bi-airplane-fill airplane-down"></i>
                      </button>
                  <?php
                }    
            
            ?>
                    <button class="botonPanel" id="botonGuardarRespuesta-"<?php echo $datosRespuesta["id"];?> value="<?php echo $datosRespuesta["id"]?>">
                    <?php
                        if(verificarSiRespuestaGuardada($datosRespuesta["id"],$respuestasGuardadas))
                        {
                            ?><i class="bi bi-bookmark-fill"></i>
                        <?php
                        }
                        else
                        {?>
                            <i class="bi bi-bookmark"></i>
                        <?php
                        }
                    ?>
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
                <div class="publicarRespuestaContenido">
                    <textarea class="textAreaRespuesta" name="texto" id="textoRespuestaPublicar"></textarea>
                    <div class="botonesRespuesta">
                        <label class="botonRedondeado botonSubirArchivo">
                            Subir Archivo
                            <input type="file" name="imagen" id="cargadorDeImagenRespuesta" accept="image/*" hidden>
                            <label id="archivoSubidoRespuesta" hidden>
                                <i class="bi bi-check-circle-fill"></i>
                            </label>
                        </label>
                        <button id="botonPublicarRespuesta" class="botonRedondeado botonComentar" type="submit">
                            Comentar
                        </button>
                    </div>
                </div>
            </div>
        </form>
    </div>
<script src="assets/js/respuestas.js"></script>
<script src="assets/js/valicionRespuesta.js"></script>


</div>