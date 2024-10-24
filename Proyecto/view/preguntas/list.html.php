
<?php
if (isset($dataToView["tema"])) $tema = $dataToView["tema"];
if (isset($dataToView["preguntas"])) $preguntas = $dataToView["preguntas"] ;
//if (isset($dataToView["preguntas"])) $usuario = $preguntas["usuario"] ;
//if (isset());
?>


<div>
    <h1><?php echo $tema["nombre"] ?></h1>
    <button>
        <a href="index.php?controller=pregunta&action=create">Crear Pregunta</a>
    </button>
    <?php if (count($preguntas) > 0): ?>
        <?php foreach ($preguntas as $pregunta): ?>
        <?php $usuario = $pregunta["usuario"] ?>
            <div class="pregunta">
                <p>
                    <?= $pregunta["titulo"] ?>
                </p>
                <div>
                    <span><?= $pregunta["votos"] ?> Votos</span>

                    <div>
                        <?= $usuario["username"] ?>
                        <?= $pregunta["fecha_hora"] ?>
                    </div>
                </div>
            </div>
            <hr>
        <?php endforeach; ?>

    <?php else: ?>
        <p>No hay preguntas sobre ese tema</p>
    <?php endif;?>
</div>
