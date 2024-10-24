<main class="main-content">
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
                                <?php if (!empty($publicacion['foto_perfil'])): ?>
                                    <img src="<?= htmlspecialchars($publicacion['foto_perfil']) ?>" alt="Foto de perfil" width="40" height="40" style="border-radius: 50%;">
                                <?php else: ?>
                                    <img src="path_to_your_default_icon.png" alt="Icono predeterminado" width="40" height="40">
                                <?php endif; ?>
                            </div>
                            <div class="texto">
                                <p><strong><?= htmlspecialchars($publicacion['titulo']) ?></strong></p>
                                <p><?= htmlspecialchars(implode(' ', array_slice(explode(' ', $publicacion['texto']), 0, 6))) ?>...</p>
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

    <!-- Paginación -->
    <div class="pagination">
        <?php for ($i = 1; $i <= $dataToView['totalPaginas']; $i++): ?>
            <a href="?controller=tema&action=mostrarTemas&pagina=<?= $i ?>" class="page-btn <?= ($i == $dataToView['paginaActual']) ? 'active' : '' ?>">
                <?= $i ?>
            </a>
        <?php endfor; ?>
    </div>
</main>