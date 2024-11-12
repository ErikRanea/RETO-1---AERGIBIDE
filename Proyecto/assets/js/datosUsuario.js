/*
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

 */

function editarUsuario(userId) {
    const url = `index.php?controller=usuario&action=mostrarDatosUsuario&id=${userId}`;
    console.log("Redirigiendo a:", url);
    window.location.href = url;
}

async function eliminarUsuario(userId) {
    const params = new URLSearchParams();

    params.append("idUsuario", userId);

    console.log(params.toString());

    let confirmado = confirm("¿Estás seguro de que deseas eliminar este usuario?");

    if (confirmado) {

        const response = await fetch('index.php?controller=usuario&action=confirmDelete', {
            method: 'POST',
            headers: {
                "Content-Type": "application/x-www-form-urlencoded",
                'X-Requested-With': 'XMLHttpRequest'
            },
            body: params.toString()
        });

        const responsetxt = await response.text();
        console.log("respuesta del javascript: " + responsetxt);
        try {
            const data = JSON.parse(responsetxt);

            console.log("variable data: "+ data);

            if (data.status === "success") {
                alert("Usuario eliminado exitosamente");
                // Eliminar el usuario de la interfaz
                const usuarioElemento = document.getElementById(`contenedorUsuario`+userId);
                if (usuarioElemento) {
                    usuarioElemento.remove();
                }
            } else {
                console.error(data.message);
                alert("Hubo un problema al eliminar el usuario.");
            }
        }
            
        catch(error) {
            console.error("Error:", error);
            alert("Error al intentar eliminar el usuario.");
        }
    }
}