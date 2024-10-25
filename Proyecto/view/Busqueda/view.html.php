<div class="content">
<?php
$termino = $dataToView['termino'] ?? ''; // Si no está definido, usa un string vacío
$resultados = $dataToView['resultados'] ?? []; // Usar un array vacío si no hay resultados

// Función para formatear la fecha en español
function formatearFecha($fecha) {
    $fechaObj = new DateTime($fecha);
    $ahora = new DateTime();
    $diferencia = $ahora->diff($fechaObj);

    if ($diferencia->d === 0) {
        return 'Hoy a las ' . $fechaObj->format('H:i');
    } elseif ($diferencia->d === 1) {
        return 'Ayer a las ' . $fechaObj->format('H:i');
    } else {
        $formatter = new IntlDateFormatter('es_ES', IntlDateFormatter::LONG, IntlDateFormatter::NONE);
        return $formatter->format($fechaObj);
    }
}
?>

<h2>Resultados de búsqueda para: <?= htmlspecialchars($termino) ?></h2>

<?php if (!empty($resultados)): ?>
    <ul>
        <?php foreach ($resultados as $resultado): ?>
            <li>
                <strong><?= htmlspecialchars($resultado['pregunta_titulo'] ?? 'Sin título') ?></strong><br>
                <small>
                    Empezado por: <?= htmlspecialchars($resultado['autor_pregunta'] ?? 'Desconocido') ?><br>
                    Última actualización por: <?= htmlspecialchars($resultado['autor_ultima_respuesta'] ?? $resultado['autor_pregunta']) ?><br>
                    Fecha de primera publicación: <?= htmlspecialchars(isset($resultado['fecha_primera_publicacion']) ? formatearFecha($resultado['fecha_primera_publicacion']) : 'No disponible') ?><br>
                    Fecha de última publicación: <?= htmlspecialchars(isset($resultado['fecha_ultima_publicacion']) ? formatearFecha($resultado['fecha_ultima_publicacion']) : 'No disponible') ?>
                </small>
            </li>
        <?php endforeach; ?>
    </ul>
<?php else: ?>
    <p>No se encontraron resultados para la búsqueda.</p>
<?php endif; ?>
</div>