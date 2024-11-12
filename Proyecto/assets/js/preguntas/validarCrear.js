/*Detectar si el archivo se ha subido */
document.addEventListener('change', function(e) {
    if (e.target && e.target.id.startsWith('botonAdjuntarImagen')) {
        const labelConfirmacion = e.target.nextElementSibling; // Obtiene el label siguiente
        
        if (e.target.files && e.target.files[0]) {
            labelConfirmacion.removeAttribute('hidden');
        } else {
            labelConfirmacion.setAttribute('hidden', '');   
        }
    }
});
///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////


