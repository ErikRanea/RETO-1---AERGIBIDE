

<div class="containerCreate">
    <div class="user-dashboard">
        <div class="panelLateralMovil">
            <button class="btn btnCrear btnPanelLateral active" id="btnDatos">Datos de Usuario</button>
            <button class="btn btnCrear btnPanelLateral" id="btnActividad">Actividad</button>
            <?php if ($_SESSION["user_data"]["rol"] == "admin" || $_SESSION["user_data"]["rol"] == "gestor"): ?>
                <button class="btn btnCrear btnPanelLateral" id="btnPanelControl">Panel de Control</button>
            <?php endif; ?>
        </div>
        <div class="user-profile-section">
            <h2 class="section-title">Datos de usuario</h2>
            <form action="index.php?controller=usuario&action=create" method="post" id="userDataForm" enctype="multipart/form-data" class="user-data-form">
                <div class="profile-photo-container">
                    <img class="profile-photo" id="imgAddFotoPerfil" src="assets/img/fotoPorDefecto.png" alt="Foto de perfil default">
                </div>
            </form>
        </div>
        <div class="user-data-section">
            <form action="index.php?controller=usuario&action=create" method="post" id="userDataForm" class="user-data-form">
                <div class="form-field">
                    <label for="nombre" class="field-label">Nombre:</label>
                    <input type="text" name="nombre" class="field-input" value="" required>
                </div>
                <div class="form-field">
                    <label for="apellido" class="field-label">Apellido:</label>
                    <input type="text" name="apellido" class="field-input" value="" required>
                </div>
                <div class="form-field">
                    <label for="username" class="field-label">Usuario:</label>
                    <input type="text" name="username" class="field-input" value="" required>
                </div>
                <div class="form-field">
                    <label for="email" class="field-label">Email:</label>
                    <input type="text" name="email" class="field-input" value="" required>
                </div>
                <div class="form-field">
                    <label for="password" class="field-label">Contraseña:</label>
                    <input type="password" name="password" class="field-input" value="" required>
                </div>
                <div class="form-field">
                    <label for="repetirPassword" class="field-label">Repetir contraseña:</label>
                    <input type="password" name="repetirPassword" id="actualPassword" class="field-input" value="" required>
                </div>
                <div class="form-field">
                    <label for="rol" class="field-label">Rol:</label>
                    <select name="rol" id="rol" class="field-input" required>
                        <option value="user">Usuario</option>
                        <?php if ($_SESSION["user_data"]["rol"] == "gestor"): ?>
                            <option value="admin">Administrador</option>
                        <?php endif; ?>
                    </select>
                </div>
                <div class="form-actions">
                    <button type="submit" id="guardarDatosUsuario" class="btn-save">Guardar</button>
                    <button type="button" class="btn-cancel" onclick="location.reload();">Cancelar</button>
                </div>
            </form>
        </div>
    </div>
</div>

