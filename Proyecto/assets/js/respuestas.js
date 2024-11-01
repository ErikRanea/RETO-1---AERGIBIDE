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
document.getElementById('botonPreguntaLike').addEventListener('click', likePregunta(event,'botonPreguntaLike'))

async function likePregunta(event,idElemento) {
    const boton = document.getElementById(idElemento);
    const idPregunta = boton.value;
    console.log(idPregunta);

    //Crear el cuerpo de la solicitud utilizando URLSearchParams

    const params = new URLSearchParams();
    params.append("idPregunta",idPregunta);

    try 
    {
        const response = await fetch("index.php?controller=pregunta&action=like",{
            method: 'POST',
            headers:{
                'Content-Type': 'application/x-www-form-urlencoded',
                'X-Requested-With': 'XMLHttpRequest'
            },
            body: params.toString()
        });

        if(!response.ok){
            throw new Error('Error de la solicitud');
        }

        const data = await response.json();
        console.log("Respuesta del servidor " + data);

        if(data.status == "sucess")
        {
            console.log(data.message);

            if(idElemento == "botonPreguntaLike") {
                // Actualizar icono del like a filled y dislike a normal
                boton.innerHTML = '<i class="bi bi-airplane-fill"></i>';
                boton.nextElementSibling.nextElementSibling.innerHTML = '<i class="bi bi-airplane airplane-down"></i>';
            }
            else if(idElemento == "botonPreguntaDislike") {
                // Actualizar icono del dislike a filled y like a normal
                boton.innerHTML = '<i class="bi bi-airplane-fill airplane-down"></i>';
                boton.previousElementSibling.previousElementSibling.innerHTML = '<i class="bi bi-airplane"></i>';
            }

        }
    } 
    catch (error)
    {
        console.log(error);
        
    }
}