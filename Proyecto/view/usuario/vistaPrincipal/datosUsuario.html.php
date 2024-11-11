<?php
    if (isset($_GET["id"])) {
        $id = $_GET["id"];
    } else {
        $id = "";
    }
$usuario = $_SESSION["user_data"];
?>
<div class="usuario-panel">
    <div class="usuario-perfil">
        <h1><!-- Nombre de usuario se actualizará aquí --></h1>
        <form action="index.php?controller=usuario&action=updateFoto" method="post" id="fotoForm" enctype="multipart/form-data" class="perfil-foto">
            <input type="hidden" name="idUsuario" id="idUsuario" value="<?php echo $id ?>">
            <img class="usuario-imagen" id="usuarioImagen" src="<?php echo isset($usuario->foto_perfil) ? $usuario->foto_perfil : 'https://cdn.pixabay.com/photo/2015/10/05/22/37/blank-profile-picture-973460_960_720.png'; ?>" alt="Foto de perfil">
            <label id="actualizarFoto">
                <button id="editarImagen" class="btn-editar">
                    Editar
                </button>
                <input type="file" name="nuevaImagen" id="nuevaImagen" accept="image/*" hidden>
            </label>
            <div class="perfil-acciones">
                <button type="submit" id="guardarImagen" class="btn-guardar">Actualizar Foto</button>
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


    <div class="usuario-datos">
        <h2>Datos de usuario</h2>
        <form action="index.php?controller=usuario&action=update" method="post" id="datosForm">
            <div class="campo-usuario">
                <label for="nombre">Nombre:</label>
                <input type="text" name="nombre" id="nombre" readonly />
            </div>
            <div class="campo-usuario">
                <label for="apellido">Apellido:</label>
                <input type="text" name="apellido" id="apellido" readonly />
            </div>
            <div class="campo-usuario">
                <label for="username">Usuario:</label>
                <div class="input-con-boton">
                    <input type="text" name="username" id="username" readonly />
                    <button id="editarUsuario" class="btn-editar">Editar</button>
                </div>
            </div>
            <div class="campo-usuario">
                <label for="email">Email:</label>
                <input type="text" name="email" id="email" readonly />
            </div>
            <div class="campo-usuario">
                <label for="actualPassword">Contraseña actual:</label>
                <div class="input-con-boton">
                    <input type="password" name="actualPassword" id="actualPassword" readonly />
                    <button id="editarPassword" class="btn-editar">Editar</button>
                </div>
            </div>
            <div class="campo-usuario">
                <label for="nuevaPassword">Nueva contraseña:</label>
                <input type="password" name="nuevaPassword" id="nuevaPassword" readonly />
            </div>
            <div class="datos-acciones">
                <button type="submit" id="guardarDatos" class="btn-guardar">Guardar</button>
                <button type="button" class="btn-cancelar" onclick="location.reload();">Cancelar</button>
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