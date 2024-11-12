<?php



if (isset($_GET["id"])) {
    $id = $_GET["id"];
} else {
    $id = $_SESSION["user_data"]["id"];
}



?>
<div class="user-dashboard">
    <div class="user-profile-section">
        <h1 class="user-name"><?php echo htmlspecialchars($usuario['nombre'] . ' ' . $usuario['apellido']); ?></h1>
        <form action="index.php?controller=usuario&action=updateFoto" method="post" id="photoForm" enctype="multipart/form-data" class="profile-photo-form">
            <input type="hidden" name="idUsuario" id="idUsuario" value="<?php echo htmlspecialchars($id); ?>">
            <div class="profile-photo-container">
                <img class="profile-photo" id="userImage" src="<?php echo isset($usuario['foto_perfil']) && $usuario['foto_perfil'] != "" ? $usuario['foto_perfil'] : 'assets/img/fotoPorDefecto.png'; ?>" alt="Foto de perfil">
                <label for="newImage" class="photo-update-label">
                    <button id="editPhoto" class="btn-edit btn-edit-photo">
                        <i class="bi bi-pencil"></i>
                    </button>
                    <input type="file" name="nuevaImagen" id="newImage" accept="image/*" class="hidden-input">
                </label>
            </div>
            <div class="profile-actions">
                <button type="submit" id="savePhoto" class="btn-save btn-save-photo">Actualizar Foto</button>
            </div>
        </form>
    </div>

    <div class="panelLateralMovil">
        <button class="btn btnCrear btnPanelLateral active" id="btnDatos">Datos de Usuario</button>
        <button class="btn btnCrear btnPanelLateral" id="btnActividad">Actividad</button>
        <?php if ( $usuario["rol"] == "admin" || $usuario["rol"] == "gestor" ): ?>
            <button class="btn btnCrear btnPanelLateral" id="btnPanelControl">Panel de Control</button>
        <?php endif; ?>
    </div>

    <div class="user-data-section">
        <h2 class="section-title">Datos de usuario</h2>
        <form action="index.php?controller=usuario&action=update" method="post" id="userDataForm" class="user-data-form">
            <div class="form-field">
                <label for="nombre" class="field-label">Nombre:</label>
                <input type="text" name="nombre" id="nombre" class="field-input" readonly value="<?php echo htmlspecialchars($usuario['nombre'] ?? ''); ?>" />
            </div>
            <div class="form-field">
                <label for="apellido" class="field-label">Apellido:</label>
                <input type="text" name="apellido" id="apellido" class="field-input" readonly value="<?php echo htmlspecialchars($usuario['apellido'] ?? ''); ?>" />
            </div>
            <div class="form-field">
                <label for="username" class="field-label">Usuario:</label>
                <div class="input-with-button">
                    <input type="text" name="username" id="username" class="field-input" readonly value="<?php echo htmlspecialchars($usuario['username'] ?? ''); ?>" />
                    <button id="editarUsuario" class="btn-edit">Editar</button>
                </div>
            </div>
            <div class="form-field">
                <label for="email" class="field-label">Email:</label>
                <input type="text" name="email" id="email" class="field-input" readonly value="<?php echo htmlspecialchars($usuario['email'] ?? ''); ?>" />
            </div>
            <div class="form-field">
                <label for="actualPassword" class="field-label">Contraseña actual:</label>
                <div class="input-with-button">
                    <input type="password" name="actualPassword" id="actualPassword" class="field-input" readonly />
                    <button id="editarPassword" class="btn-edit">Editar</button>
                </div>
            </div>
            <div class="form-field">
                <label for="nuevaPassword" class="field-label">Nueva contraseña:</label>
                <input type="password" name="nuevaPassword" id="nuevaPassword" class="field-input" readonly />
            </div>
            <div class="form-actions">
                <button type="submit" id="guardarDatos" class="btn-save">Guardar</button>
                <button type="button" class="btn-cancel" onclick="location.reload();">Cancelar</button>
            </div>
        </form>
    </div>
</div>




<script>
    // Script para poder editar los campos
document.getElementById('editarUsuario').addEventListener('click', function(e) {
    e.preventDefault();
    document.getElementById("username").readOnly = false;
});

document.getElementById('editarPassword').addEventListener('click', function(e) {
    e.preventDefault();
    document.getElementById("actualPassword").readOnly = false;
    document.getElementById("nuevaPassword").readOnly = false;
});

document.getElementById('editarFoto').addEventListener('click', function(e) {
    e.preventDefault();
});

</script>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        const fotoPerfil = document.getElementById('usuarioImagen');
        const fileInput = document.getElementById('nuevaImagen');
        const formData = new FormData();

        // Al hacer clic en la imagen, se abre el input file
        fotoPerfil.addEventListener('click', function () {
            fileInput.click();
        });

        // Cuando se selecciona una nueva imagen
        fileInput.addEventListener('change', function () {
            const file = this.files[0];
            if (file) {
                // Previsualización de la imagen seleccionada
                const reader = new FileReader();
                reader.onload = function (e) {
                    fotoPerfil.src = e.target.result;
                };
                reader.readAsDataURL(file);

                // Añadir archivo al FormData
                formData.append('nuevaImagen', file);
                formData.append('idUsuario', document.getElementById('idUsuario').value);

                // Enviar la imagen automáticamente al servidor
                fetch('index.php?controller=usuario&action=updateFoto', {
                    method: 'POST',
                    body: formData
                })
                    .then(response => response.json())
                    .then(data => {
                        if (data.success) {
                            alert('Foto de perfil actualizada correctamente.');
                        } else {
                            alert('Error al actualizar la foto de perfil.');
                        }
                    })
                    .catch(error => console.error('Error:', error));
            }
        });
    });

</script>

<script src="assets/js/datosUsuario.js"></script>
<script src="assets/js/panelLateralMovil.js"></script>