<div class="containerTema">
    <div class="temas">
        <?php
        $temas = $dataToView["temas"] ?? [];
        foreach ($temas as $tema): ?>
            <div class="tema"><?php echo htmlspecialchars($tema['nombre'] ?? ''); ?></div>
        <?php endforeach; ?>
    </div>

    <div class="sidebar">
        <div class="ultimas-publicaciones">
            <h3>Últimas Publicaciones</h3>
            <?php
            $publicaciones = $dataToView["publicaciones"] ?? [];
            if (!empty($publicaciones)): ?>
                <?php foreach ($publicaciones as $publicacion): ?>
                    <div class="publicacion">
                        <div class="icono">
                            <!-- Mostrar la foto de perfil obtenida de la base de datos -->
                            <?php if (!empty($publicacion['foto_perfil'])): ?>
                                <img src="<?= htmlspecialchars($publicacion['foto_perfil']) ?>" alt="Foto de perfil" width="40" height="40" style="border-radius: 50%;">
                            <?php else: ?>
                                <!-- Si no hay foto de perfil, mostrar un icono predeterminado -->
                                <img src="path_to_your_default_icon.png" alt="Icono predeterminado" width="40" height="40">
                            <?php endif; ?>
                        </div>
                        <div class="texto">
                            <p><strong><?= htmlspecialchars($publicacion['titulo']) ?></strong></p>
                            <p>
                                <?= htmlspecialchars(implode(' ', array_slice(explode(' ', $publicacion['texto']), 0, 6))) ?>...
                            </p>
                        </div>
                    </div>
                <?php endforeach; ?>
            <?php else: ?>
                <p>No hay publicaciones recientes</p>
            <?php endif; ?>
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
