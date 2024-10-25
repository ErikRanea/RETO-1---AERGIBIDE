<div class="contenedorPreguntaYRespuesta">
    <div class="cont1">
        <div class="fotoUsuarioPregunta">

            <img src="<?php
           // $fotoPerfilDefecto = $_COOKIE["darkMode"] == "enabled" ? "assets/img/fotoPorDefectoBlack.png" : "assets/img/fotoPorDefecto.png" ;
             echo isset($dataToView["usuario"]) ? $dataToView["usuario"]["foto_perfil"] : "assets/img/fotoPorDefecto.png" ?>" alt="">
        </div>
    </div>


    <div class="cont2">
        <div class="divPregunta">
            <h1><strong><?php echo isset($dataToView["pregunta"]) ? $dataToView["pregunta"]["titulo"] : "TituloNoEncontrado"?></strong></h1>
            <p><?php echo isset($dataToView["pregunta"]) ? $dataToView["pregunta"]["texto"] : "Texto no encontrado"?></p>
            <?php if($dataToView["pregunta"]["imagen"] != null)?><img src="<?php echo $dataToView["pregunta"]["imagen"]?>" alt=""><?php;?>
        </div>
    </div>


    <div class="cont3">
        %20
    </div>
</div>