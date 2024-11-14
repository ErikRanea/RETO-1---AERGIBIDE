

<div class="containerCreate">
    <div class="user-dashboard">
        <h2 class="section-title">Datos de usuario</h2>

        <form action="index.php?controller=usuario&action=create" method="post" id="userDataForm" enctype="multipart/form-data" class="user-data-form">
            <div class="user-profile-section">

                <div class="profile-photo-container">
                    <img class="profile-photo" id="imgAddFotoPerfil" src="assets/img/fotoPorDefecto.png" alt="Foto de perfil default">
                </div>
                <label class="btn btnImagenCrear">
                    Seleccionar Archivo
                    <input id="btnAddFotoPerfil" type="file" name="imagen" hidden accept="application/pdf, image/*">
                    <i class="bi bi-check-circle-fill" hidden></i>
                </label>
            </div>
            <div class="user-data-section">
                <div class="form-field">
                    <label for="nombre" class="field-label">Nombre:</label>
                    <input type="text" name="nombre" class="field-input" value="">
                </div>
                <div class="form-field">
                    <label for="apellido" class="field-label">Apellido:</label>
                    <input type="text" name="apellido" class="field-input" value="">
                </div>
                <div class="form-field">
                    <label for="username" class="field-label">Usuario:</label>
                    <div class="input-with-button">
                        <input type="text" name="username" class="field-input" value="">
                    </div>
                </div>
                <div class="form-field">
                    <label for="email" class="field-label">Email:</label>
                    <input type="text" name="email" class="field-input" value="">
                </div>
                <div class="form-field">
                    <label for="nuevaPassword" class="field-label">Contraseña:</label>
                    <input type="password" name="password" class="field-input" value="">
                </div>
                <div class="form-field">
                    <label for="actualPassword" class="field-label">Repetir contraseña:</label>
                    <input type="password" name="repetirPassword" id="actualPassword" class="field-input" value="">
                </div>
                <div class="form-field">
                    <label for="rol" class="field-label">Rol:</label>
                    <select name="rol" id="rol" class="field-input">
                        <option value="user">Usuario</option>
                        <?php if ($_SESSION["user_data"]["rol"] == "gestor" ): ?>
                            <option value="admin">Administrador</option>
                        <?php endif; ?>
                    </select>
                </div>
                <div class="form-actions">
                    <button type="submit" id="guardarDatosUsuario" class="btn-save">Guardar</button>
                    <button type="button" class="btn-cancel" onclick="location.reload();">Cancelar</button>
                </div>
            </div>

        </form>

    </div>

</div>

