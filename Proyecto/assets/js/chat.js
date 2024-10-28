document.getElementById('chat-form').onsubmit = function(e) {
    e.preventDefault();
    var formData = new FormData(this);
    fetch('index.php?controller=Chat&action=enviarMensaje', {
        method: 'POST',
        body: formData
    }).then(response => response.json()).then(data => {
        // Manejar la respuesta
        console.log(data);
        // Lógica para actualizar la vista con el nuevo mensaje, si es necesario
    });
};

function obtenerMensajes() {
    fetch('index.php?controller=Chat&action=obtenerMensajes', {
        method: 'GET'
    }).then(response => response.json()).then(data => {
        // Lógica para mostrar los mensajes en el chat
        var messagesContainer = document.getElementById('messages');
        messagesContainer.innerHTML = ''; // Limpiar mensajes existentes
        data.forEach(msg => {
            messagesContainer.innerHTML += `<div>${msg.mensaje} <span>${msg.timestamp}</span></div>`;
        });
    });
}

// Llamar a obtenerMensajes en intervalos regulares
setInterval(obtenerMensajes, 5000); // Cada 5 segundos