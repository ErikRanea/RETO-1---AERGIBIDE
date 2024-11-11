document.getElementById("botonPublicarRespuesta").addEventListener("click", function() {
    const elementoTexto = document.getElementById("textoRespuestaPublicar");
    
    if(elementoTexto.value.trim() == "") {
        let timerInterval;
        Swal.fire({
            icon: 'error',
            title: '¡Oops!',
            html: 'El campo de texto no puede estar vacío.<br>La página se reiniciará en <b></b> segundos',
            color: 'var(--color-letra)',
            background: 'var(--color-principal)',
            timer: 3000,
            timerProgressBar: true,
            showConfirmButton: false,
            didOpen: () => {
                const timer = Swal.getPopup().querySelector('b');
                timerInterval = setInterval(() => {
                    timer.textContent = `${Math.ceil(Swal.getTimerLeft() / 1000)}`;
                }, 100);
            },
            willClose: () => {
                clearInterval(timerInterval);
            },
        });
    }
    
}); 

