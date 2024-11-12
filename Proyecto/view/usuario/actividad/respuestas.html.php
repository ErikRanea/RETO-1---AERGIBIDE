<?php
if (isset($dataToView["actividad"])) $actividad = $dataToView["actividad"];
if (isset($dataToView["paginas"])) $paginas = $dataToView["paginas"];
?>

<?php if (count($actividad) > 0):?>
    <div class="contenido">
        <?php foreach ($actividad as $respuesta): ?>
            <div class="pregunta">
                <div>
                    <p><?= $respuesta["titulo_pregunta"] ?></p>
                    <p><?= $respuesta["respuesta"] ?></p>
                </div>
                <div class="datos-pregunta">
                    <span><?= $respuesta["votos"] ?> Votos</span>

                    <div>
                        <?= $respuesta["username"] ?>
                        <?= $respuesta["fecha_hora"] ?>
                    </div>
                </div>
            </div>
        <?php endforeach; ?>
    </div>
    <div class="pagination">
        <!-- Enlaces de número de página -->
        <?php for ($i = 1; $i <= $paginas[1]; $i++): ?>
            <a class="page-btn <?= ($i == $paginas[0]) ? 'active' : ''; ?>" onclick="cargarPaginacion(<?= $i ?>, 'Respuestas_Usuario')">
                <?= $i; ?>
            </a>
        <?php endfor; ?>
    </div>
<?php else: ?>
    <p>No has hecho respuestas</p>
<?php endif; ?>
