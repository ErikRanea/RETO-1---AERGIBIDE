document.getElementById("botonDeLogin").addEventListener("click", validarCredenciales);

async function validarCredenciales(event) {
    event.preventDefault();  // Prevenir que el botón recargue la página

    var email = document.getElementById("email").value;
    var password = document.getElementById("password").value;

    // Asegurarse de que los campos no están vacíos
    if (email === "" || password === "") {
        alert("Por favor, introduce el email y la contraseña.");
        return;
    }

    // Crear un cuerpo de la solicitud con URLSearchParams
    const params = new URLSearchParams();
    params.append('email', email);
    params.append('password', password);

    try {
        const response = await fetch('http://localhost/RETO-1---AERGIBIDE/Proyecto/index.php?controller=usuario&action=logear', {
            method: 'POST', // Tipo de solicitud
            headers: {
                'Content-Type': 'application/x-www-form-urlencoded',  // Se envían datos como un formulario estándar
                'X-Requested-With': 'XMLHttpRequest'  // Encabezado común para indicar solicitudes hechas por JavaScript
            },
            body: params.toString()  // Convertimos los datos a una cadena de consulta
        });

        if (!response.ok) {
            throw new Error('Error en la solicitud');
        }

        const data = await response.text();
        console.log('Respuesta del servidor:', data);

        if (data.success) {
            // Redirigir si el login fue exitoso
            window.location.href = 'index.php?controller=temas&action=mostrarTemas';
        } else {
            alert('Login fallido: ' + data.message);
        }
    } catch (error) {
        console.error('Error:', error);
    }
}
