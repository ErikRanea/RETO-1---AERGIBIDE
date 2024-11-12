

<div class="containerCreate">

    <div class="user-dashboard">
        <div class="user-profile-section">
            <h1 class="user-name">Username</h1>
            <form action="index.php?controller=usuario&action=updateFoto" method="post" id="photoForm" enctype="multipart/form-data" class="profile-photo-form">
                <input type="hidden" name="idUsuario" id="idUsuario" value="<?php echo $id ?>">
                <div class="profile-photo-container">
                    <img class="profile-photo" id="fotoPerfil" src="<?php echo isset($usuario->foto_perfil) ? $usuario->foto_perfil : 'https://cdn.pixabay.com/photo/2015/10/05/22/37/blank-profile-picture-973460_960_720.png'; ?>" alt="Foto de perfil default">
                    <label for="nuevaFoto" class="photo-update-label">
                        <button id="editarFoto" class="btn-edit btn-edit-photo">
                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-pencil-square" viewBox="0 0 16 16" color="#4DBAD9">
                                <path d="M15.502 1.94a.5.5 0 0 1 0 .706L14.459 3.69l-2-2L13.502.646a.5.5 0 0 1 .707 0l1.293 1.293zm-1.75 2.456-2-2L4.939 9.21a.5.5 0 0 0-.121.196l-.805 2.414a.25.25 0 0 0 .316.316l2.414-.805a.5.5 0 0 0 .196-.12l6.813-6.814z"/>
                                <path fill-rule="evenodd" d="M1 13.5A1.5 1.5 0 0 0 2.5 15h11a1.5 1.5 0 0 0 1.5-1.5v-6a.5.5 0 0 0-1 0v6a.5.5 0 0 1-.5.5h-11a.5.5 0 0 1-.5-.5v-11a.5.5 0 0 1 .5-.5H9a.5.5 0 0 0 0-1H2.5A1.5 1.5 0 0 0 1 2.5z"/>
                            </svg>
                        </button>
                        <input type="file" name="nuevaFoto" id="nuevaFoto" accept="image/*" class="hidden-input">
                    </label>
                </div>
                <div class="profile-actions">
                    <button type="submit" id="guardarFoto" class="btn-save btn-save-photo">Actualizar Foto</button>
                </div>
            </form>
        </div>

        <div class="user-data-section">
            <h2 class="section-title">Datos de usuario</h2>
            <form action="index.php?controller=usuario&action=create" method="post" id="userDataForm" class="user-data-form">
                <div class="form-field">
                    <label for="nombre" class="field-label">Nombre:</label>
                    <input type="text" name="nombre" id="nombre" class="field-input" value="">
                </div>
                <div class="form-field">
                    <label for="apellido" class="field-label">Apellido:</label>
                    <input type="text" name="apellido" id="apellido" class="field-input" value="">
                </div>
                <div class="form-field">
                    <label for="username" class="field-label">Usuario:</label>
                    <div class="input-with-button">
                        <input type="text" name="username" id="username" class="field-input" value="">
                        <button id="editarUsuario" class="btn-edit">Editar</button>
                    </div>
                </div>
                <div class="form-field">
                    <label for="email" class="field-label">Email:</label>
                    <input type="text" name="email" id="email" class="field-input" value="">
                </div>
                <div class="form-field">
                    <label for="nuevaPassword" class="field-label">Nueva contraseña:</label>
                    <input type="password" name="nuevaPassword" id="nuevaPassword" class="field-input" value="">
                </div>
                <div class="form-field">
                    <label for="actualPassword" class="field-label">Repetir contraseña:</label>
                    <input type="password" name="actualPassword" id="actualPassword" class="field-input" value="">
                </div>
                <div class="form-field">
                    <label for="rol" class="field-label">Rol:</label>
                    <select name="rol" id="rol" class="field-input">
                        <option value="user">Usuario</option>
                        <option value="admin">Administrador</option>
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


