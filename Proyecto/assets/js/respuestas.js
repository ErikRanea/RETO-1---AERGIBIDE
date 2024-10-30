/*Detectar si el archivo se ha subido */
document.getElementById('cargadorDeImagenRespuesta').addEventListener('change', function(e) {
    const labelConfirmacion = document.getElementById('archivoSubidoRespuesta');
    
    if (this.files && this.files[0]) {
        labelConfirmacion.removeAttribute('hidden');
    } else {
        labelConfirmacion.setAttribute('hidden', '');
    }
});



/* Guardar las respuestas o preguntas */
document.getElementById()