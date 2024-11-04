var id_emisor = window.id_emisor; // ID del emisor desde la sesión
var user_emisor = window.user_emisor;
var msgBox = document.getElementById('msgBox'); // Contenedor de mensajes

document.addEventListener("DOMContentLoaded", function() {
    const msgBox = document.getElementById('msgBox');
    const messageInput = document.getElementById('message');
    const sendButton = document.getElementById('send-message');
    const userComboBox = document.getElementById('user-combobox');
    const selectedUserHeader = document.getElementById('selected-user');
    const userItems = document.querySelectorAll('.user-item');

    // Update active user in sidebar
    function updateActiveUser(userId) {
        userItems.forEach(item => {
            item.classList.remove('active');
            if (item.dataset.userId === userId) {
                item.classList.add('active');
                selectedUserHeader.textContent = item.querySelector('span').textContent;
            }
        });
    }

    // Click handlers for user items in sidebar
    userItems.forEach(item => {
        item.addEventListener('click', () => {
            const userId = item.dataset.userId;
            userComboBox.value = userId;
            updateActiveUser(userId);
            loadMessages();
        });
    });

    let firstLoad = true; // Variable para rastrear si es la primera carga

    async function loadMessages() {
        const id_receptor = userComboBox.value;
        if (!id_receptor) return;

        updateActiveUser(id_receptor);

        try {
            const response = await fetch(
                `index.php?controller=chat&action=get_messages&id_emisor=${id_emisor}&id_receptor=${id_receptor}`,
                {
                    method: 'GET',
                    headers: {
                        'X-Requested-With': 'XMLHttpRequest'
                    }
                }
            );

            if (!response.ok) throw new Error('Error en la solicitud');

            const data = await response.json();
            msgBox.innerHTML = "";

            let lastDate = ""; // Variable para rastrear la última fecha mostrada

            if (Array.isArray(data) && data.length > 0) {
                data.forEach(function(mensaje) {
                    const mensajeFecha = new Date(mensaje.fecha);
                    const mensajeDia = mensajeFecha.toLocaleDateString(); // Formato de día
                    const mensajeHora = mensajeFecha.toLocaleTimeString([], { hour: '2-digit', minute: '2-digit' }); // Formato de hora
                    if (mensajeDia !== lastDate) {
                        msgBox.innerHTML += `<div class="message-day">${mensajeDia}</div>`;
                        lastDate = mensajeDia; // Actualizamos la última fecha
                    }

                    const messageClass = (mensaje.emisor === user_emisor) ? 'sent' : 'received';
                    msgBox.innerHTML += `
                             <div class="message ${messageClass}">
                        ${mensaje.mensaje}
                        <em class="message-time">${mensajeHora}</em>
                    </div>
                        `;
                });

                // Desplazamos al final solo en la primera carga
                if (firstLoad) {
                    msgBox.scrollTop = msgBox.scrollHeight; // Desplazamos al último mensaje
                    firstLoad = false; // Marcamos que ya se ha realizado la primera carga
                } else {
                    // Comprobamos si el usuario está cerca del fondo
                    const isScrolledToBottom = msgBox.scrollHeight - msgBox.clientHeight <= msgBox.scrollTop + 50; // Ajusta el valor '50' según sea necesario

                    // Desplazamos solo si está cerca del fondo
                    if (isScrolledToBottom) {
                        msgBox.scrollTop = msgBox.scrollHeight;
                    }
                }
            } else {
                msgBox.innerHTML = "<div class='message'>No hay mensajes aún.</div>";
            }
        } catch (error) {
            console.error("Error en la carga de mensajes:", error);
            msgBox.innerHTML = "<div class='message'>Error al cargar mensajes.</div>";
        }
    }

    async function sendMessage() {
        const id_receptor = userComboBox.value;
        const message = messageInput.value.trim();

        if (!id_receptor) {
            alert("Selecciona un usuario para enviar el mensaje");
            return;
        }
        if (!message) {
            alert("Escribe algún mensaje");
            return;
        }

        const params = new URLSearchParams();
        params.append('id_emisor', id_emisor);
        params.append('id_receptor', id_receptor);
        params.append('mensaje', message);

        try {
            const response = await fetch('controller/insert_message.php', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/x-www-form-urlencoded',
                    'X-Requested-With': 'XMLHttpRequest'
                },
                body: params.toString()
            });

            const responseText = await response.text();

            if (responseText.trim() === "Mensaje insertado correctamente") {
                messageInput.value = '';
                loadMessages();
            } else {
                console.error("Error en la inserción:", responseText);
            }
        } catch (error) {
            console.error("Error en la solicitud de envío:", error);
        }
    }

    // Event Listeners
    userComboBox.addEventListener('change', loadMessages);
    sendButton.addEventListener('click', sendMessage);
    messageInput.addEventListener('keydown', function(event) {
        if (event.key === 'Enter') {
            sendMessage();
        }
    });

    // Initial load
    loadMessages();

    // Auto refresh
    setInterval(loadMessages, 1000);
});