const pregunta = document.getElementById("pregunta");

document.addEventListener("DOMContentLoaded", function() {
   
    Swal.fire({
        icon: 'success',
        title: 'Pregunta guardada con exito!',
        color: 'var(--color-letra)',
        background: 'var(--color-principal)',
        showDenyButton: true,
        confirmButtonText: 'Hacer nueva pregunta',
        denyButtonText: 'Volver',
        timer: 5000,
        timerProgressBar: true,
        customClass: {
            confirmButton: 'btn btnCrear', // Clases personalizadas para el botón de aceptar
            denyButton: 'btn btnCancel'    // Clases personalizadas para el botón de cancelar
        },
        willClose: () => {
            window.location.href = `index.php?controller=pregunta&action=list&id_tema=${pregunta.getAttribute('data-id-tema')}`;
          }

    }).then((result)  => {
        if(result.isConfirmed) {
            window.location.href = `index.php?controller=pregunta&action=create`;
        }
        else if (result.isDenied) 
        {
            respuestaUsuario = false;
        }
    });


});
