<?php
if (isset($dataToView["actividad"])) $actividad = $dataToView["actividad"];
if (isset($dataToView["paginas"])) $paginas = $dataToView["paginas"];
?>

<?php if (!empty($actividad)): ?>
    <div class="contenido">
        <?php foreach ($actividad as $respuesta): ?>
            <div class="respuesta">
                <p>
                    <a href="index.php?controller=respuesta&action=view&id_pregunta=<?= htmlspecialchars($respuesta["id_respuesta"] ?? '') ?>" class="tituloRespuesta">
                        <?= htmlspecialchars($respuesta["titulo_pregunta"] ?? 'Sin título') ?>
                    </a>
                </p>
                <div class="datos-respuesta">
                    <span><?= htmlspecialchars($respuesta["votos"] ?? '0') ?> Votos</span>
                    <div>
                        <?= htmlspecialchars($respuesta["username"] ?? 'Usuario desconocido') ?>
                        <?= htmlspecialchars($respuesta["fecha_hora"] ?? 'Fecha desconocida') ?>
                    </div>
                </div>
                <p class="contenido-respuesta">
                    <?php
                    if (isset($respuesta["respuesta"]) && !empty($respuesta["respuesta"])) {
                        echo htmlspecialchars(substr($respuesta["respuesta"], 0, 100)) . '...';
                    } else {
                        echo 'No hay contenido disponible';
                    }
                    ?>
                </p>
            </div>
        <?php endforeach; ?>
    </div>
    <div class="pagination">
        <!-- Enlaces de número de página -->
        <?php for ($i = 1; $i <= ($paginas[1] ?? 1); $i++): ?>
            <a class="page-btn <?= ($i == ($paginas[0] ?? 1)) ? 'active' : ''; ?>" onclick="cargarPaginacion(<?= $i ?>, 'Respuestas_Usuario')">
                <?= $i; ?>
            </a>
        <?php endfor; ?>
    </div>
<?php else: ?>
    <p>No has hecho respuestas</p>
<?php endif; ?>