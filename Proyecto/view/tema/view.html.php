<?php
// INICIO: Bloque de prueba para inicializar conexión a la base de datos directamente en la vista
require_once __DIR__ . '/../../model/db.php';
require_once __DIR__ . '/../../model/Tema.php';
$db = new Db();
$temaModel = new Tema();
$temas = $temaModel->getTemas();
// FIN: Bloque de prueba para conexión
?>



<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Temas</title>
    <link rel="stylesheet" href="/assets/css/tema.css">
</head>
<body>
<div class="container">
    <div class="temas">
        <?php if (!empty($temas)): ?>
            <?php foreach ($temas as $tema): ?>
                <div class="tema"><?php echo htmlspecialchars($tema->nombre); ?></div>
            <?php endforeach; ?>
        <?php else: ?>
            <div class="tema">No hay temas disponibles</div>
        <?php endif; ?>
    </div>

    <div class="sidebar">
        <div class="ultimas-publicaciones">
            <h3>Últimas publicaciones</h3>
            <!-- Aquí hay que añadir el contenido de publicaciones -->
        </div>
        <div class="estadisticas">
            <h3>Estadísticas</h3>
        </div>
    </div>
</div>

<div class="pagination">
    <button class="page-btn">1</button>
    <button class="page-btn">2</button>
    <button class="page-btn">3</button>
</div>
</body>
</html>
