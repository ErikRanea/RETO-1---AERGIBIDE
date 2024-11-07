<?php
if (isset($dataToView["actividad"])) $actividad = $dataToView["actividad"];
if (isset($dataToView["paginas"])) $paginas = $dataToView["paginas"];
?>

<?php if (count($actividad) > 0):?>
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
            <a class="page-btn <?= ($i == $paginas[0]) ? 'active' : ''; ?>" onclick="cargarPaginacion(<?= $i ?>, 'Preguntas_Usuario')">
                <?= $i; ?>
            </a>
        <?php endfor; ?>
    </div>
<?php else: ?>
    <p>No has hecho preguntas</p>
<?php endif; ?>

