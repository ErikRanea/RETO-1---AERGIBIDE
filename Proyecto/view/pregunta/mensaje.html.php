
<div class="contenedorMensajeServidor">
    <div class="alert alert-success">

        <?php if ($_GET["action"] == "save"):
            if (isset($dataToView["pregunta"])) $pregunta = $dataToView["pregunta"]; ?>

            <label id="pregunta" data-id-tema = "<?= $pregunta["id_tema"] ?>" value="<?= $pregunta["id"] ?>"></label>

           
        <?php endif; ?>

        <?php if ($_GET["action"] == "edit"): ?>
            Pregunta editada correctamente. <a href="index.php?controller=pregunta&action=create">Hacer otra Pregunta</a>
            <br>
            <a href="index.php?listaPreguntaUsuario">Volver atras</a>
        <?php endif; ?>

        <?php if ($_GET["action"] == "delete"): ?>
            Pregunta eliminada correctamente. <a href="index.php?controller=pregunta&action=create">Hacer otra Pregunta</a>
            <br>
            <a href="index.php?listaPreguntaUsuario">Volver atras</a>
        <?php endif; ?>

    </div>
</div>
<script src="assets/js/preguntas/guardarPregunta.js"></script>