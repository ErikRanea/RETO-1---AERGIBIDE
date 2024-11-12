<?php
// DATOS USUARIO SESION INICIADA
$usuario = $_SESSION["user_data"];

if (isset($_GET["id_tema"])) $id_tema = $_GET["id_tema"];
if (isset($dataToView["temas"])) $temas = $dataToView["temas"];

?>

<div class="contenedorFormCrear">
    <div class="crearPreguntaCrear">
        <h1>Crear Pregunta</h1>

        <form class="formPreguntaCrear" action="index.php?controller=pregunta&action=save" method="POST" enctype="multipart/form-data">
            <input type="hidden" name="id_usuario" value="<?= $usuario["id"] ?>">

            <?php if (!isset($_GET["id_tema"])): ?>
                <div>
                    <label>
                        Tema
                        <select id="tema" name="id_tema">
                            <?php foreach ($temas as $tema):?>
                                <option value="<?= $tema["id"] ?>"><?= $tema["nombre"] ?></option>
                            <?php endforeach; ?>
                        </select>
                    </label>
                </div>
                <br>
            <?php else: ?>
                <input id="id_tema" type="hidden" name="id_tema" value="<?= $id_tema; ?>" />
            <?php endif; ?>

            <div>
                <label>
                    Titulo*
                    <br>
                    <input id="titulo" type="text" name="titulo" placeholder="Titulo de tu Pregunta" required>
                </label>
            </div>
            <br>

            <div>
                <label>
                    Describe tu problema
                    <br>
                    <textarea id="texto" name="texto" placeholder="Descripción de tu Problema"></textarea>
                </label>
            </div>
            <br>

            <div>
                <label >
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
            <div class="acciones">
                <input type="submit" value="Guardar" class="btnForm btnCrear"/>
                <a href= "<?php echo isset($id_tema) ? "index.php?controller=pregunta&action=list&id_tema=".$id_tema : "index.php"?>" class="btn btnCancel">Cancelar</a>
            </div>

        </form>
    </div>

</div>
<script src="assets/js/preguntas/validarCrear.js"></script>