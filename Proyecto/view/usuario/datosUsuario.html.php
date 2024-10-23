<div class="containerPerfil">
  <div class="perfil">
    <h1>Username</h1>
    <div class="divFoto">
      <img class="sinFoto" src="https://cdn.pixabay.com/photo/2015/10/05/22/37/blank-profile-picture-973460_960_720.png" alt="Foto de perfil default">
    </div>
    <br>
    <input type="submit" value="Actualizar foto" class="actualizarFoto">
  </div>
  
  <div class="listaDatos">
    <h2>Datos de usuario</h2>
    <form action="index.php?controller=usuario&action=" method="post" id="datosUsuarioForm">
      <table class="estiloTabla">
        <tr>
          <th>Nombre:</th>
          <td><input type="text" name="nombre" value="Example" disabled /></td>
          <td></td>
        </tr>
        <tr>
          <th>Apellido:</th>
          <td><input type="text" name="apellido" value="Example" disabled /></td>
          <td></td>
        </tr>
        <tr>
          <th>Usuario:</th>
          <td><input type="text" name="usuario" value="Example" disabled /></td>
          <td><button id="editarUsuario">
          <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-pencil-square" viewBox="0 0 16 16">
          <path d="M15.502 1.94a.5.5 0 0 1 0 .706L14.459 3.69l-2-2L13.502.646a.5.5 0 0 1 .707 0l1.293 1.293zm-1.75 2.456-2-2L4.939 9.21a.5.5 0 0 0-.121.196l-.805 2.414a.25.25 0 0 0 .316.316l2.414-.805a.5.5 0 0 0 .196-.12l6.813-6.814z" color="#4DBAD9" />
          <path fill-rule="evenodd" d="M1 13.5A1.5 1.5 0 0 0 2.5 15h11a1.5 1.5 0 0 0 1.5-1.5v-6a.5.5 0 0 0-1 0v6a.5.5 0 0 1-.5.5h-11a.5.5 0 0 1-.5-.5v-11a.5.5 0 0 1 .5-.5H9a.5.5 0 0 0 0-1H2.5A1.5 1.5 0 0 0 1 2.5z" color="#4DBAD9"/></svg>
          </button></td>
        </tr>
        <tr>
          <th>Email:</th>
          <td><input type="text" name="email" value="Example@gmail.com" disabled /></td>
          <td></td>
        </tr>
        <tr>
          <th>Contraseña:</th>
          <td><input type="password" name="password" value="**********" disabled /></td>
          <td><button id="editarPassword">
          <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-pencil-square" viewBox="0 0 16 16">
          <path d="M15.502 1.94a.5.5 0 0 1 0 .706L14.459 3.69l-2-2L13.502.646a.5.5 0 0 1 .707 0l1.293 1.293zm-1.75 2.456-2-2L4.939 9.21a.5.5 0 0 0-.121.196l-.805 2.414a.25.25 0 0 0 .316.316l2.414-.805a.5.5 0 0 0 .196-.12l6.813-6.814z" color="#4DBAD9" />
          <path fill-rule="evenodd" d="M1 13.5A1.5 1.5 0 0 0 2.5 15h11a1.5 1.5 0 0 0 1.5-1.5v-6a.5.5 0 0 0-1 0v6a.5.5 0 0 1-.5.5h-11a.5.5 0 0 1-.5-.5v-11a.5.5 0 0 1 .5-.5H9a.5.5 0 0 0 0-1H2.5A1.5 1.5 0 0 0 1 2.5z" color="#4DBAD9"/></svg>
          </button></td>
        </tr>
      </table>
      <button type="submit" class="actualizarFoto">Guardar</button>
    </form>
  </div>
</div>

<script>
document.getElementById('editarUsuario').addEventListener('click', function(e) {
    e.preventDefault();
    var usuarioField = document.querySelector('#datosUsuarioForm input[name="usuario"]');
    usuarioField.disabled = false;
});

document.getElementById('editarPassword').addEventListener('click', function(e) {
    e.preventDefault();
    var passwordField = document.querySelector('#datosUsuarioForm input[name="password"]');
    passwordField.disabled = false;
});
</script>