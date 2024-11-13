<?php

    $pregunta = $dataToView;


    function esPdf($path)
    {
        // Convertir el path a minúsculas para asegurar la comparación de la extensión
        $extension = strtolower(pathinfo($path, PATHINFO_EXTENSION));
        
        
        return $extension === "pdf";
    }

?>

<div class="contenedorFormCrear">
    <div class="crearPreguntaCrear">
        <h1>Editar Pregunta</h1>

        <form class="formPreguntaCrear" action="index.php?controller=pregunta&action=update" method="POST" enctype="multipart/form-data">
            <input type="hidden" name="id_pregunta" value="<?php echo $pregunta["id"];?>">
            <div>
                <label>
                    Titulo
                    <br>
                    <input type="text" name="titulo" value="<?php echo $pregunta["titulo"]?>">
                </label>
            </div>
            <br>

            <div>
                <label>
                    Describe tu problema
                    <br>
                    <textarea name="texto"><?php echo $pregunta["texto"]?></textarea>
                </label>
            </div>
            <br>


            <div>
                <label>
                    Imagen subida
                    <br>
                    <?php
                    if(isset($pregunta["imagen"]))
                    {
                        if(esPdf($pregunta["imagen"]))
                        {?>
                            <iframe style="width: 100%;" src="<?=$pregunta["imagen"]?>" frameborder="0" ></iframe>
                <?php
                        }   
                        else
                        {
                            ?>
                            <img class="imagenDeLaPregunta" src="<?=$pregunta["imagen"]?>" alt="imagen de la pregunta">
                            <?php 
                        } 
                       
                    }
                    ?>
                </label>
            </div>

            <div>
                <label>
                    Adjuntar Archivo
                </label>
                <br>
                <br>
                <label class="btn btnImagenCrear">
                    Seleccionar Archivo
                    <input id="botonAdjuntarImagen" type="file" name="imagen" hidden accept="image/*">
                        <i class="bi bi-check-circle-fill" hidden></i>
                </label>
            </div>
            <br>
            <br>

            <div class="accionesCrear">
                <input type="submit" value="Guardar" class="btnForm btnCrearCrear"/>
                <a href="javascript:window.history.back()" class="btn btnCancelCrear">Cancelar</a>
            </div>

        </form>
    </div>

</div>
<script src="assets/js/preguntas/validarCrear.js"></script>
