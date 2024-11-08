<?php

    $pregunta = $dataToView;


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
                    Adjuntar Archivo
                </label>
                <br>
                <br>
                <label class="btn btnImagenCrear">
                    Seleccionar Archivo
                    <input type="file" name="imagen" hidden="hidden">
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
