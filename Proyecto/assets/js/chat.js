$(document).ready(function() {
    loadMessages(); // Cargar mensajes iniciales

    // Función para verificar los IDs de los mensajes y aplicar estilos
    function verificarIdsMensajes() {
        $('#msgBox .message').each(function() {
            var mensajeId = $(this).attr('id'); // Obtén el ID del mensaje
            if (mensajeId) {
                // Cambiar el ID a un nombre que puedas usar en CSS
                // Por ejemplo, reemplaza 'mensaje_' por 'msg-' para usar en CSS
                var nombreEstilo = mensajeId.replace('mensaje_', 'msg-');
                $(this).addClass(nombreEstilo); // Agrega la clase al div del mensaje
            }
        });
    }

    // Llama a la función después de cargar los mensajes
    loadMessages(); // Asegúrate de llamar a verificarIdsMensajes después de que los mensajes se carguen
    verificarIdsMensajes(); // Llama a la función para verificar los IDs
});
