<?php
if (isset($dataToView["preguntas_pag"])) $preguntas_pag = $dataToView["preguntas_pag"];
if (isset($dataToView["preguntas"])) $preguntas = $dataToView["preguntas"];
if (isset($dataToView["paginas"])) $paginas = $dataToView["paginas"];
$usuario = $_SESSION["user_data"];
//print_r($preguntas_pag);
//echo "<br>";
//print_r($preguntas);
//print_r($usuario["username"]);
?>

<div>
    <div class="panel">
        <div class="panelBotones">
            <button class="btnActividad">Preguntas</button>
            <button class="btnActividad">Respuestas</button>
            <button class="btnActividad">Guardados</button>
        </div>
        <div class="contenido">
            <?php foreach ($preguntas as $pregunta): ?>
                <p><?php echo $pregunta["titulo"]. " | ". $pregunta["votos"] . " votos | " . $pregunta["fecha_hora"] . " | " . $pregunta["username"] ?></p>
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
    </div>
</div>


<script>

</script>
