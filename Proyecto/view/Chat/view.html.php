<?php

$id_emisor = $_SESSION['user_data']['id'];
$user_emisor = $_SESSION['user_data']['username'];// Obtén el ID de sesión del usuario
$colors = array('#007AFF','#FF7000','#FF7000','#15E25F','#CFC700','#CFC700','#CF1100','#CF00BE','#F00');
$color_pick = array_rand($colors);
?>

<div class="chat-wrapper">
    <div id="msgBox">
        <?php if (!empty($mensajes)): ?>
            <?php foreach ($mensajes as $mensaje): ?>
                <?php
                // Asegúrate de que el ID esté definido
                $mensajeId = isset($mensaje['id']) ? htmlspecialchars($mensaje['id']) : 'undefined';
                ?>
                <div id="mensaje_<?= $mensajeId ?>" class="message <?= (htmlspecialchars($mensaje['id_emisor']) == $id_emisor) ? 'sent' : 'received'; ?>">
                    <strong><?= htmlspecialchars($mensaje['emisor']); ?>:</strong>
                    <?= htmlspecialchars($mensaje['mensaje']); ?>
                    <em><?= htmlspecialchars($mensaje['fecha']); ?></em>
                </div>
            <?php endforeach; ?>
        <?php else: ?>
            <div>No hay mensajes aún.</div>
        <?php endif; ?>
    </div>

    <div class="user-panel">
        <select id="user-combobox" name="usuarios">
            <?php foreach ($dataToView['usuarios'] as $usuario): ?>
                <option value="<?= htmlspecialchars($usuario['id']) ?>">
                    <?= htmlspecialchars($usuario['nombre']) ?>
                </option>
            <?php endforeach; ?>
        </select>

        <input type="text" name="message" id="message" placeholder="Escribe tu mensaje aquí..." maxlength="100" />
        <button id="send-message">Enviar</button>
    </div>
</div>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
<script type="text/javascript">
    $(document).ready(function() {
        loadMessages(); // Cargar mensajes iniciales
    });

    // Define el ID del emisor desde la sesión PHP
    var id_emisor = <?= json_encode($id_emisor) ?>; // ID del emisor desde la sesión
    var user_emisor = <?= json_encode($user_emisor) ?>;
    var msgBox = $('#msgBox'); // Cambia a '#msgBox' para coincidir con el ID de tu contenedor

    $('#user-combobox').change(function() {
        loadMessages(); // Cargar mensajes cuando se cambia el usuario
    });

    function loadMessages() {
        var id_receptor = $('#user-combobox').val(); // Obtener ID del receptor seleccionado
        console.log("ID Emisor:", id_emisor, "Nombre Emisor:", user_emisor, "ID Receptor:", id_receptor); // Log de ID emisor y receptor
        $.ajax({
            url: 'index.php?controller=chat&action=get_messages',
            method: 'GET',
            data: { id_emisor: id_emisor, id_receptor: id_receptor },
            success: function (data) {
                console.log("Respuesta del servidor:", data); // Verificar la respuesta del servidor
                try {
                    const mensajes = JSON.parse(data); // Intenta analizar el JSON
                    console.log("Mensajes:", mensajes); // Log de mensajes

                    msgBox.empty(); // Limpiar mensajes antes de mostrar nuevos
                    // Verificar si hay mensajes
                    if (Array.isArray(mensajes) && mensajes.length > 0) {
                        mensajes.forEach(function (mensaje) {
                            console.log("Mensaje ID Emisor:", mensaje.emisor, user_emisor); // Log del ID del emisor del mensaje

                            // Asegúrate de que id_emisor sea un número antes de comparar
                            var messageClass = (Number(mensaje.emisor) === user_emisor) ? 'sent' : 'received'; // Ajustar las clases
                            msgBox.append(`<div class="message ${messageClass}"><strong>${mensaje.emisor}:</strong> ${mensaje.mensaje}<em>${mensaje.fecha}</em></div>`);
                        });
                    } else {
                        msgBox.html("No hay mensajes aún."); // Mensaje cuando no hay mensajes
                    }
                } catch (error) {
                    console.error("Error en la respuesta JSON:", error);
                    msgBox.html("Error al cargar mensajes."); // Mensaje de error en la interfaz
                }
            },
            error: function (jqXHR, textStatus, errorThrown) {
                console.error("Error en la petición AJAX:", textStatus, errorThrown);
                msgBox.html("Error en la conexión."); // Mensaje de error en la interfaz
            }
        });
    }


    $('#send-message').click(function() {
        sendMessage();
    });

    $("#message").on("keydown", function(event) {
        if (event.which === 13) {
            sendMessage();
        }
    });

    function sendMessage() {
        var messageInput = $('#message');
        var id_receptor = $('#user-combobox').val(); // Obtener ID del receptor seleccionado

        if (!id_receptor) {
            alert("Selecciona un usuario para enviar el mensaje");
            return;
        }
        if (messageInput.val() === "") {
            alert("Escribe algún mensaje");
            return;
        }

        $.ajax({
            url: 'controller/insert_message.php',
            type: 'POST',
            data: {
                id_emisor: id_emisor,
                id_receptor: id_receptor,
                mensaje: messageInput.val()
            },
            success: function(response) {
                if (response.trim() === "Mensaje insertado correctamente") {
                    messageInput.val(''); // Limpiar el campo de mensaje
                    loadMessages(); // Cargar los mensajes después de enviar
                } else {
                    console.error("Error en la inserción:", response);
                }
            },
            error: function(xhr, status, error) {
                console.error("Error en la solicitud:", error);
            }
        });
    }

    // Recargar mensajes cada 9 segundos
    setInterval(loadMessages, 9000);
</script>
