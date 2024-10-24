
<?php
if (isset($dataToView["tema"])) $tema = $dataToView["tema"];
if (isset($dataToView["pregunta"])) $preguntas = $dataToView["pregunta"];
if (isset($dataToView["paginas"])) $paginas = $dataToView["paginas"];
//if (isset($dataToView["pregunta"])) $usuario = $pregunta["usuario"] ;
//if (isset());
?>


<div>
    <h1><?php echo $tema["nombre"] ?></h1>
    <button>
        <a href="index.php?controller=pregunta&action=create&id_tema=<?= $tema["id"] ?>">Crear Pregunta</a>
    </button>
    <?php if (count($preguntas) > 0): ?>
        <?php foreach ($preguntas as $pregunta): ?>
        <?php $usuario = $pregunta["usuario"]; ?>
            <div class="pregunta">
                <p>
                    <?= $pregunta["titulo"] ?>
                </p>
                <div class="datos-pregunta">
                    <span><?= $pregunta["votos"] ?> Votos</span>

                    <div>
                        <?= $usuario["username"] ?>
                        <?= $pregunta["fecha_hora"] ?>
                    </div>
                </div>
            </div>
            <hr>
        <?php endforeach; ?>

        <nav aria-label="Paginación de notas" class="">
            <ul class="pagination justify-content-center">
                <!-- Enlace a la página anterior -->
                <?php if ($paginas[0] > 1): ?>
                    <li class="page-item">
                        <a class="page-link" href="index.php?controller=pregunta&action=list&id_tema=<?= $tema["id"] ?>&page=<?= $paginas[0] - 1; ?>">Anterior</a>
                    </li>
                <?php else: ?>
                    <li class="page-item disabled">
                        <span class="page-link">Anterior</span>
                    </li>
                <?php endif; ?>

                <!-- Enlaces de número de página -->
                <?php for ($i = 1; $i <= $paginas[1]; $i++): ?>
                    <li class="page-item <?= ($i == $paginas[0]) ? 'active' : ''; ?>">
                        <a class="page-link" href="index.php?controller=pregunta&action=list&id_tema=<?= $tema["id"] ?>&page=<?= $i; ?>"><?= $i; ?></a>
                    </li>
                <?php endfor; ?>

                <!-- Enlace a la página siguiente -->
                <?php if ($paginas[0] < $paginas[1]): ?>
                    <li class="page-item">
                        <a class="page-link" href="index.php?controller=pregunta&action=list&id_tema=<?= $tema["id"] ?>&page=<?= $paginas[0] + 1; ?>">Siguiente</a>
                    </li>
                <?php else: ?>
                    <li class="page-item disabled">
                        <span class="page-link">Siguiente</span>
                    </li>
                <?php endif; ?>
            </ul>
        </nav>

    <?php else: ?>
        <p>No hay preguntas sobre ese tema</p>
    <?php endif;?>
</div>
