console.log("Script de chat activado.");
document.getElementById('enviarMensaje').addEventListener('click', function() {
    const mensaje = document.getElementById('mensajeInput').value;
    const contactoId = document.getElementById('contactoId').value; // Obtener el ID del contacto desde el input oculto

    // Verificar si el mensaje y el contactoId no están vacíos
    if (mensaje.trim() === "" || contactoId.trim() === "") {
        console.error("El mensaje y el ID de contacto son obligatorios.");
        return; // No continuar si no hay mensaje o contacto
    }

    fetch('index.php?controller=chat&action=enviarMensaje', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/x-www-form-urlencoded',
        },
        body: `contacto_id=${contactoId}&mensaje=${mensaje}`
    })
        .then(response => response.json())
        .then(data => {
            // Comprobar si el envío fue exitoso
            if (data.status === 'success') {
                console.log("Mensaje enviado correctamente");
                cargarMensajes(contactoId); // Actualiza los mensajes después de enviar
            } else {
                console.error("Error al enviar el mensaje:", data.error);
            }
        })
        .catch(error => {
            console.error("Error en la solicitud:", error);
        });
});

function cargarMensajes(contactoId) {
    fetch(`index.php?controller=chat&action=obtenerMensajes&contacto_id=${contactoId}`)
        .then(response => response.json())
        .then(mensajes => {
            const mensajesContainer = document.getElementById('mensajes');
            mensajesContainer.innerHTML = ''; // Limpia los mensajes actuales
            mensajes.forEach(m => {
                const mensajeElement = document.createElement('div');
                mensajeElement.textContent = `${m.fecha}: ${m.mensaje}`; // Cambié `m.fecha_envio` a `m.fecha` según tu estructura
                mensajesContainer.appendChild(mensajeElement);
            });
        })
        .catch(error => {
            console.error("Error al cargar mensajes:", error);
        });
}
