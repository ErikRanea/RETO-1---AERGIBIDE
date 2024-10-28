
<div id="chat-window"></div>
<textarea id="mensaje" placeholder="Escribe tu mensaje..."></textarea>
<button id="enviar">Enviar</button>

<script>
    const receptorId = <?php echo json_encode($_GET['receptor']); ?>; // ID del receptor del chat
    document.getElementById('enviar').addEventListener('click', () => {
        const mensaje = document.getElementById('mensaje').value;
        fetch('index.php?controller=Chat&action=enviarMensaje', {
            method: 'POST',
            headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
            body: `receptor=${receptorId}&mensaje=${mensaje}`
        }).then(response => response.json())
            .then(data => {
                if (data.success) {
                    // Actualizar la vista del chat
                    cargarMensajes(receptorId);
                    document.getElementById('mensaje').value = ''; // Limpiar el textarea
                }
            });
    });

    function cargarMensajes(receptor) {
        fetch(`index.php?controller=Chat&action=obtenerMensajes&receptor=${receptor}`)
            .then(response => response.json())
            .then(mensajes => {
                const chatWindow = document.getElementById('chat-window');
                chatWindow.innerHTML = ''; // Limpiar la ventana de chat
                mensajes.forEach(mensaje => {
                    const div = document.createElement('div');
                    div.textContent = mensaje.mensaje + ' (' + mensaje.fecha + ')';
                    chatWindow.appendChild(div);
                });
            });
    }

    // Cargar mensajes al inicio
    cargarMensajes(receptorId);
</script>
<script src="chat.js"></script>
