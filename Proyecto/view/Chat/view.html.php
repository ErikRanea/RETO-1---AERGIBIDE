<?php
$colors = array('#007AFF','#FF7000','#FF7000','#15E25F','#CFC700','#CFC700','#CF1100','#CF00BE','#F00');
$color_pick = array_rand($colors);
?>

<!DOCTYPE html>
<html>
<head>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <style type="text/css">
        /* Estilos del chat (igual que antes) */
        .chat-wrapper { font: bold 11px/normal 'lucida grande', tahoma, verdana, arial, sans-serif; background: #00a6bb; padding: 20px; margin: 20px auto; box-shadow: 2px 2px 2px 0px #00000017; max-width:700px; min-width:500px; }
        #message-box { width: 97%; display: inline-block; height: 300px; background: #fff; box-shadow: inset 0px 0px 2px #00000017; overflow: auto; padding: 10px; }
        .user-panel{ margin-top: 10px; }
        input[type=text]{ border: none; padding: 5px 5px; box-shadow: 2px 2px 2px #0000001c; }
        input[type=text]#name{ width:20%; }
        input[type=text]#message{ width:60%; }
        button#send-message { border: none; padding: 5px 15px; background: #11e0fb; box-shadow: 2px 2px 2px #0000001c; }
    </style>
</head>
<body>

<div class="chat-wrapper">
    <div id="message-box"></div>
    <div class="user-panel">
        <select name="usuarios">
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
<script language="javascript" type="text/javascript">
    var msgBox = $('#message-box');

    function loadMessages() {
        var id_emisor = $('#user-combobox').val();
        var id_receptor = 'ID_DEL_RECEPTOR_AQUI'; // Reemplaza con el ID del receptor

        $.ajax({
            url: 'controller/get_messages.php',
            type: 'GET',
            data: { id_emisor: id_emisor, id_receptor: id_receptor },
            success: function(response) {
                msgBox.html('');
                var messages = JSON.parse(response);
                messages.forEach(function(message) {
                    msgBox.append('<div><span class="user_name" style="color:' + message.color + '">' + message.name + '</span> : <span class="user_message">' + message.message + '</span></div>');
                });
                msgBox[0].scrollTop = msgBox[0].scrollHeight;
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
        var id_emisor = $('select[name="usuarios"]').val(); // Cambié esto para obtener el ID del emisor directamente del select
        var id_receptor = 'ID_DEL_RECEPTOR_AQUI'; // Reemplaza con el ID del receptor

        console.log("ID Emisor: ", id_emisor); // Para verificar el ID del emisor
        console.log("Mensaje: ", messageInput.val()); // Para verificar el contenido del mensaje

        if (id_emisor === "") {
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
                console.log("Respuesta del servidor:", response); // Imprimir la respuesta del servidor
                // Maneja la respuesta aquí
                if (response.success) {
                    messageInput.val(''); // Limpiar el campo de mensaje
                    loadMessages(); // Cargar los mensajes después de enviar
                } else {
                    alert("Error al enviar el mensaje: " + response.error);
                }
            },
            error: function(jqXHR, textStatus, errorThrown) {
                console.error("Error en la solicitud:", textStatus, errorThrown); // Imprimir el error si falla la solicitud
            }
        });
    }

    // Recargar mensajes cada 3 segundos
    setInterval(loadMessages, 3000);

</script>
</body>
</html>
