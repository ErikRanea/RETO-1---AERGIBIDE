<?php

$id_emisor = $_SESSION['user_data']['id'];
$user_emisor = $_SESSION['user_data']['username'];// Obtén el ID de sesión del usuario

?>

<div class="chat-container">
    <!-- Users Sidebar -->
    <div class="users-sidebar">
        <div class="sidebar-header">
            <h2>Usuarios</h2>
        </div>
        <div class="users-list">
            <?php foreach ($dataToView['usuarios'] as $usuario): ?>
                <button class="user-item" data-user-id="<?= htmlspecialchars($usuario['id']) ?>">
                    <div class="user-avatar">
                        <svg width="16" height="16" fill="none" stroke="currentColor" stroke-width="2">
                            <path d="M8 8a3 3 0 1 0 0-6 3 3 0 0 0 0 6zm0 0v0a3 3 0 0 1 3 3v1H5v-1a3 3 0 0 1 3-3z"/>
                        </svg>
                    </div>
                    <span><?= htmlspecialchars($usuario['nombre']) ?></span>
                </button>
            <?php endforeach; ?>
        </div>
    </div>

    <!-- Chat Area -->
    <div class="chat-area">
        <div class="chat-header">
            <h2 id="selected-user">Selecciona un usuario</h2>
        </div>
        <div id="msgBox">
            <!-- Messages will be loaded here -->
        </div>
        <div class="user-panel">
            <select id="user-combobox" name="usuarios" style="display: none;"> <!-- Ocultamos el combobox -->
                <option value="">Seleccionar usuario</option>
                <?php foreach ($dataToView['usuarios'] as $usuario): ?>
                    <option value="<?= htmlspecialchars($usuario['id']) ?>">
                        <?= htmlspecialchars($usuario['nombre']) ?>
                    </option>
                <?php endforeach; ?>
            </select>
            <input type="text" id="message" placeholder="Escribe tu mensaje aquí..." maxlength="100" />
            <button id="send-message">Enviar</button>
        </div>
    </div>
</div>


<script>
    var id_emisor = <?= json_encode($id_emisor) ?>;
    var user_emisor = <?= json_encode($user_emisor) ?>;a
</script>


<script src="assets/js/chat.js"></script>
