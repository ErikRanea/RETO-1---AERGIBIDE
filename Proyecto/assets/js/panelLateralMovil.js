document.addEventListener('DOMContentLoaded', function() {
    const panelLateralOriginal = document.querySelector('.panelLateral');
    const panelLateralMovil = document.getElementById('panelLateralMovil');

    if (panelLateralOriginal && panelLateralMovil) {
        panelLateralMovil.innerHTML = panelLateralOriginal.innerHTML;
    }

    function ajustarPanelLateral() {
        if (window.innerWidth <= 991) {
            // Mover el contenido del panel lateral original
            panelLateralMovil.appendChild(panelLateralOriginal);
            panelLateralOriginal.style.display = 'flex'; // Asegúrate de que sea visible en el nuevo contenedor
        } else {
            // Devolver el panel lateral a su posición original
            document.querySelector('.containerPerfil').insertBefore(panelLateralOriginal, document.querySelector('.containerPerfil').firstChild);
            panelLateralOriginal.style.display = 'block';
        }
    }

    // Ejecutar al cargar la página y al cambiar el tamaño de la ventana
    ajustarPanelLateral();
    window.addEventListener('resize', ajustarPanelLateral);
});