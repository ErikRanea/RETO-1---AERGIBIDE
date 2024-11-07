document.addEventListener("DOMContentLoaded", function() {
    // Obtener el ID del usuario de la URL, si existe
    const urlParams = new URLSearchParams(window.location.search);
    const userId = urlParams.get('id'); // Obtener el ID de la URL

    // Hacemos la solicitud al servidor para obtener los datos del usuario
    fetch('index.php?controller=usuario&action=datosUsuario' + (userId ? '&id=' + userId : ''), {
        method: 'GET',
        headers: {
            'X-Requested-With': 'XMLHttpRequest'
        }
    })
    .then(response => response.json())
    .then(data => {
        // Verifica que el usuario tiene datos correctos
        if (data && !data.error) {
            // Actualiza los campos del HTML con los datos recibidos
            document.querySelector('.containerPerfil h1').textContent = data.username;
            document.querySelector('.divFoto img').src = data.foto_perfil || 'ruta_default_de_foto.png';
            document.getElementById("nombre").value = data.nombre || '';
            document.getElementById("apellido").value = data.apellido || '';
            document.getElementById("username").value = data.username || '';
            document.getElementById("email").value = data.email || '';
            document.getElementById("password").value = data.password || '';
            document.getElementById("idUsuario").value = data.id || '';
        }
    })
    .catch(error => {
        console.error('Error:', error);
    });
});

function editarUsuario(userId) {
    const url = `index.php?controller=usuario&action=mostrarDatosUsuario&id=${userId}`;
    console.log("Redirigiendo a:", url);
    window.location.href = url;
}