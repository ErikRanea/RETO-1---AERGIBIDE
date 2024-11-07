<?php
if (isset($dataToView["actividad"])) $actividad = $dataToView["actividad"];
if (isset($dataToView["paginas"])) $paginas = $dataToView["paginas"];

$preguntas = [];
$respuestas = [];

foreach ($actividad as $item) {
    if ($item["tipo"] == "Pregunta"){
        array_push($preguntas, $item);
    } else {
        array_push($respuestas, $item);
    }
}
?>

<div>
    <h2>Preguntas</h2>
    <?php if (count($preguntas) > 0):?>
        <div class="contenido">
            <?php foreach ($actividad as $pregunta): ?>
                <div class="pregunta">
                    <p>
                        <a href="index.php?controller=respuesta&action=view&id_pregunta=<?= $pregunta["id"] ?>" class="tituloPregunta"><?= $pregunta["titulo"] ?></a>
                    </p>
                    <div class="datos-pregunta">
                        <span><?= $pregunta["votos"] ?> Votos</span>

                        <div>
                            <?= $pregunta["username"] ?>
                            <?= $pregunta["fecha_hora"] ?>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
        <div class="pagination">
            <!-- Enlaces de número de página -->
            <?php for ($i = 1; $i <= $paginas[1]; $i++): ?>
                <a class="page-btn <?= ($i == $paginas[0]) ? 'active' : ''; ?>" onclick="cargarPagina(<?= $i ?>, 'Preguntas_Usuario')">
                    <?= $i; ?>
                </a>
            <?php endfor; ?>
        </div>
    <?php else: ?>
        <p>No hay preguntas guardadas</p>
    <?php endif; ?>
</div>
<div>
    <h2>Respuestas</h2>
    <?php if (count($respuestas) > 0):?>
        <div class="contenido">
            <?php foreach ($respuestas as $respuesta): ?>
                <p><?php echo $respuesta["titulo_pregunta"]. " | ". $respuesta["respuesta"] . " votos | " . $respuesta["fecha_hora"] . " | " . $respuesta["username"] ?></p>
            <?php endforeach; ?>
        </div>
        <div class="pagination">
            <!-- Enlaces de número de página -->
            <?php for ($i = 1; $i <= $paginas[1]; $i++): ?>
                <a class="page-btn <?= ($i == $paginas[0]) ? 'active' : ''; ?>" href="index.php?controller=usuario&action=mostrarActividad&page=<?= $i; ?>">
                    <?= $i; ?>
                </a>
            <?php endfor; ?>
        </div>
    <?php else: ?>
        <p>No hay respuestas guardadas</p>
    <?php endif; ?>
</div>



