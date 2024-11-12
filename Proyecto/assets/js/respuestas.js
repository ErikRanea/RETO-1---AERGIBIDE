/*Detectar si el archivo se ha subido */
document.addEventListener('change', function(e) {
    if (e.target && e.target.id.startsWith('cargadorDeImagenRespuesta')) {
        const labelConfirmacion = e.target.nextElementSibling; // Obtiene el label siguiente
        
        if (e.target.files && e.target.files[0]) {
            labelConfirmacion.removeAttribute('hidden');
        } else {
            labelConfirmacion.setAttribute('hidden', '');   
        }
    }
});


///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
/* Dar like o disLike a las preguntas */

document.getElementById('botonPreguntaLike').addEventListener('click', function(event) {
    likePregunta(event, 'botonPreguntaLike');
});
document.getElementById('botonPreguntaDislike').addEventListener('click', function(event) {
    likePregunta(event, 'botonPreguntaDislike');
});

async function likePregunta(event, idElemento) {
    event.preventDefault(); // Prevenir comportamiento por defecto
    const boton = document.getElementById(idElemento);
    const idPregunta = boton.value;
    const idUsuario = document.getElementById('userId').value;
    let meGusta = 0;

    // Obtener referencias a los botones
    const botonLike = document.getElementById('botonPreguntaLike');
    const botonDislike = document.getElementById('botonPreguntaDislike');

    // Determinar si es like o dislike
    if(idElemento == "botonPreguntaLike") {
        meGusta = 1;
        // Actualizar inmediatamente la UI
        if(botonLike.querySelector('i').classList.contains('bi-airplane-fill')) {
            // Si ya está liked, lo quitamos
            botonLike.innerHTML = '<i class="bi bi-airplane"></i>';
        } else {
            // Si no está liked, lo ponemos
            botonLike.innerHTML = '<i class="bi bi-airplane-fill"></i>';
            botonDislike.innerHTML = '<i class="bi bi-airplane airplane-down"></i>';
        }
    }
    else if(idElemento == "botonPreguntaDislike") {
        meGusta = 0;
        // Actualizar inmediatamente la UI
        if(botonDislike.querySelector('i').classList.contains('bi-airplane-fill')) {
            // Si ya está disliked, lo quitamos
            botonDislike.innerHTML = '<i class="bi bi-airplane airplane-down"></i>';
        } else {
            // Si no está disliked, lo ponemos
            botonDislike.innerHTML = '<i class="bi bi-airplane-fill airplane-down"></i>';
            botonLike.innerHTML = '<i class="bi bi-airplane"></i>';
        }
    }

    const params = new URLSearchParams();
    params.append("idPregunta", idPregunta);
    params.append("idUsuario", idUsuario);   
    params.append("meGusta", meGusta);

    try {
        const response = await fetch("index.php?controller=pregunta&action=like", {
            method: 'POST',
            headers: {
                'Content-Type': 'application/x-www-form-urlencoded',
                'X-Requested-With': 'XMLHttpRequest'
            },
            body: params.toString()
        });

        if(!response.ok) {
            throw new Error('Error de la solicitud');
            // Si hay error, revertir los cambios visuales
            location.reload();
        }

        const data = await response.json();

        if(data.status !== "success") {
            // Si la respuesta no es exitosa, revertir los cambios
            console.log(data.message);
        }
    } catch (error) {
        console.log(error);
        // Si hay error, revertir los cambios visuales
        location.reload();
    }
}



///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

/* Dar like o disLike a las respuestas 

*/


/*El querySelectorAll es para seleccionar todos los elementos que coincidan con el selector*/
document.querySelectorAll('[id^="botonRespuestaLike-"]').forEach(boton => {
    boton.addEventListener('click', async function() {
        const idRespuesta = this.value;
        const userId = document.getElementById('userId').value;
        const dislikeBtn = document.getElementById(`botonRespuestaDisLike-${idRespuesta}`);
        const votosElemento = document.getElementById(`votosRespuesta-${idRespuesta}`);
        
        const params = new URLSearchParams();
        params.append("idRespuesta", idRespuesta);
        params.append("idUsuario", userId);
        params.append("meGusta", 1);

        try {
            const response = await fetch(`index.php?controller=respuesta&action=like`, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/x-www-form-urlencoded',
                    'X-Requested-With': 'XMLHttpRequest'
                },
                body: params.toString()
            });

            const data = await response.json();
            
            if(data.message == "Voto eliminado correctamente la respuesta") {
                const votosNuevos = await conseguirVotos("respuesta", idRespuesta);
                votosElemento.textContent = votosNuevos["votos"];
                this.querySelector('i').classList.remove('bi-airplane-fill');
                this.querySelector('i').classList.add('bi-airplane');
            } else if(data.status == "success") {
                const votosNuevos = await conseguirVotos("respuesta", idRespuesta);
                votosElemento.textContent = votosNuevos["votos"];
                this.querySelector('i').classList.remove('bi-airplane');
                this.querySelector('i').classList.add('bi-airplane-fill');
                
                if(dislikeBtn) {
                    const dislikeIcon = dislikeBtn.querySelector('i');
                    dislikeIcon.classList.remove('bi-airplane-fill');
                    dislikeIcon.classList.add('bi-airplane');
                    dislikeIcon.classList.add('airplane-down');
                }
            }
        } catch (error) {
            console.error('Error:', error);
        }
    });
});

document.querySelectorAll('[id^="botonRespuestaDisLike-"]').forEach(boton => {
    boton.addEventListener('click', async function() {
        const idRespuesta = this.value;
        const userId = document.getElementById('userId').value;
        const strIdRespuesta = `botonRespuestaLike-${idRespuesta}`;
        const likeBtn = document.getElementById(strIdRespuesta);
        const votosElemento = document.getElementById(`votosRespuesta-${idRespuesta}`);
        
        try {

            
                // Continuamos con el resto del código usando votosActuales
                const params = new URLSearchParams();
                params.append("idRespuesta", idRespuesta);
                params.append("idUsuario", userId);
                params.append("meGusta", 0);

                const response = await fetch(`index.php?controller=respuesta&action=like`, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/x-www-form-urlencoded',
                        'X-Requested-With': 'XMLHttpRequest'
                    },
                    body: params.toString()
                });

                const data = await response.json();
                if(data.message == "Voto eliminado correctamente la respuesta") {
                    let votosNuevos = await conseguirVotos("respuesta", idRespuesta);
                        votosElemento.textContent = votosNuevos["votos"];
                        this.querySelector('i').classList.remove('bi-airplane-fill');
                        this.querySelector('i').classList.add('bi-airplane');
                        this.querySelector('i').classList.add('airplane-down');
                    
                } else if(data.status == "success") {
                    // Activar el dislike
                    let votosNuevos = await conseguirVotos("respuesta", idRespuesta);
                        votosElemento.textContent = votosNuevos["votos"];
                        this.querySelector('i').classList.remove('bi-airplane');
                        this.querySelector('i').classList.add('bi-airplane-fill');

                    
                    // Asegurarnos de que el like esté limpio
                    
                    
                    console.log(likeBtn);
                    if(likeBtn) {
                        console.log("Votos actuales eliminando like en fill");
                        likeBtn.querySelector('i').classList.remove('bi-airplane-fill');
                        likeBtn.querySelector('i').classList.add('bi-airplane');
                    }
                
            }
        } catch (error) {
            console.error('Error en el proceso:', error);
        }
    });
});


async function conseguirVotos(tipo,id)
{

    let voto = 0;
    const params = new URLSearchParams();
    params.append("id" , id);
    params.append("tipo", tipo);

    try 
    {
     
      const response = await fetch('index.php?controller=respuesta&action=cuentaDeVotos', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/x-www-form-urlencoded',
            'X-Requested-With': 'XMLHttpRequest'
        },
        body: params.toString()
        }); 

        const data = await response.json();
        

        if(data.status == "success")
        {
            console.log('Respuesta del CONSEGUITvOTOS:', data.votos);
            return data.votos;
        }
        else
        {
            throw new Error(data.message);
        }

    } 
    catch (error) {

        return error
        
    }



}





///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

/*Guardar o desguardar preguntas */

document.getElementById('botonGuardarPregunta').addEventListener('click', async function() {
    const idPregunta = this.value;
    const userId = document.getElementById('userId').value;

    const params = new URLSearchParams();
    params.append("idPregunta", idPregunta);
    params.append("idUsuario", userId);

   try
   {

       const response = await fetch(`index.php?controller=pregunta&action=guardados`, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/x-www-form-urlencoded',
                'X-Requested-With': 'XMLHttpRequest'
            },
            body: params.toString()
        }); 
        


        const data = await response.json();
        console.log('Respuesta del servidor:', data);

        if (data.status == "success" && data.message == "add OK")
        {
            console.log("Guardando pregunta");
            console.log('Antes de cambiar clases:', this.querySelector('i').className);
            this.querySelector('i').classList.remove('bi-bookmark');
            this.querySelector('i').classList.add('bi-bookmark-fill');
        }
        else if(data.status == "success" && data.message == "delete OK")
        {
            console.log("Desguardando pregunta");
            console.log('Antes de cambiar clases:', this.querySelector('i').className);
            this.querySelector('i').classList.remove('bi-bookmark-fill');
            this.querySelector('i').classList.add('bi-bookmark');
        }
        else
        {
            throw new Error(data.message);
            
        }

    
   }
   catch (error)
   {
        console.log(error);
   }
    
}); 

/*Guardar o desguardar respuestas */
document.querySelectorAll('[id^="botonGuardarRespuesta-"]').forEach(boton => {
    boton.addEventListener('click', async function(){
        const idRespuesta = this.value;
        const userId = document.getElementById('userId').value;
        
        const params = new URLSearchParams();
        params.append("idRespuesta", idRespuesta);
        params.append("idUsuario", userId);


        try
        {
     
            const response = await fetch(`index.php?controller=respuesta&action=guardados`, {
                 method: 'POST',
                 headers: {
                     'Content-Type': 'application/x-www-form-urlencoded',
                     'X-Requested-With': 'XMLHttpRequest'
                 },
                 body: params.toString()
             }); 
             
     
     
             const data = await response.json();
             console.log('Respuesta del servidor:', data);
     
             if (data.status == "success" && data.message == "add OK")
             {
                 console.log("Guardando respuesta");
                 console.log('Antes de cambiar clases:', this.querySelector('i').className);
                 this.querySelector('i').classList.remove('bi-bookmark');
                 this.querySelector('i').classList.add('bi-bookmark-fill');
             }
             else if(data.status == "success" && data.message == "delete OK")
             {
                 console.log("Desguardando respuesta");
                 console.log('Antes de cambiar clases:', this.querySelector('i').className);
                 this.querySelector('i').classList.remove('bi-bookmark-fill');
                 this.querySelector('i').classList.add('bi-bookmark');
             }
             else
             {
                 throw new Error(data.message);
                 
             }
     
         
        }
        catch (error)
        {
             console.log(error);
        }

    })
})



///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////


/*Editar respuestas*/

//EventListener para poner en modo editar la respuesta

document.querySelectorAll('[id^="editarRespuesta-"]').forEach(boton => {
    boton.addEventListener('click', function() {

        if (this.hasAttribute('data-active')) {
            return; 
        }
        
        const idRespuesta = this.getAttribute('value');
        const botonEditar = document.getElementById(`editarRespuesta-${idRespuesta}`);
        
        // Marcar el botón como activo
        botonEditar.setAttribute('data-active', 'true');
        
        const idPregunta = this.getAttribute('data-id-pregunta');
        const contenedorRespuesta = this.closest('.contenedorRespuestaDivididor');
        const contenidoOriginal = contenedorRespuesta.querySelector('.contenidoRespuesta');
        const textoOriginal = contenidoOriginal.textContent.trim();
        const imagenOriginal = contenedorRespuesta.querySelector('.imagenRespuesta');
        let imagenOriginalUrl = null;
        if (imagenOriginal) {
            imagenOriginalUrl = imagenOriginal.src;
        }
        

        const formularioEdicion = `
            <form class="editarRespuestaForm" action="index.php?controller=respuesta&action=edit" method="POST" enctype="multipart/form-data">
                <input type="hidden" name="idRespuesta" value="${idRespuesta}">
                <input type="hidden" name="id_pregunta" value="${idPregunta}">
                <textarea name="texto" class="textAreaRespuesta">${textoOriginal}</textarea>
                <div class="contenedorImagenEdicion">
                    <img class="ImagenEditar" src="${imagenOriginalUrl ? imagenOriginalUrl : ''}">
                </div>
                <div class="botonesEdicion" style="display: flex; justify-content: space-between; gap: 1em;">
                    <label class="botonSubirArchivo">
                        Cambiar Archivo
                        <input type="file" name="imagen" id="cargadorDeImagenRespuesta-${idRespuesta}" accept="image/*" hidden>
                        <label id="archivoSubidoRespuesta-${idRespuesta}" hidden>
                            <i class="bi bi-check-circle-fill"></i>
                        </label>
                    </label>
                    <button class="botonGuardarRespuesta" type="submit" data-id="${idRespuesta}">
                        <i class="bi bi-check-circle"></i> Guardar
                    </button>
                    <button class="botonCancelarRespuesta">
                        <i class="bi bi-x-circle "></i> Cancelar
                    </button>
                </div>
            </form>
        `;

        // Reemplazar el contenido original con el formulario
        contenidoOriginal.innerHTML = formularioEdicion;

        // Añadir manejador para restaurar el botón cuando se cancela
        contenedorRespuesta.querySelector('.botonCancelarRespuesta').addEventListener('click', (e) => {
            e.preventDefault();
            contenidoOriginal.innerHTML = textoOriginal;
            if (imagenOriginal) {
                contenidoOriginal.appendChild(imagenOriginal);
            }
            // Remover el atributo active al cancelar
            botonEditar.removeAttribute('data-active');
        });
    });
});

//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

const botonEliminarPregunta = document.getElementById('eliminarPregunta');

if(botonEliminarPregunta != null)
{
    botonEliminarPregunta.addEventListener('click', async function() {
        const idPregunta = document.getElementById("eliminarPregunta").getAttribute('data-value');
        try
        {
            /*Primero recojo el usuario y la pregunta de la base de datos y luego muestro dentro del panel Swal */
            console.log("Comenzando la eliminiación de la pregunta");
            console.log("El id de la pregunta es " + idPregunta );
            const params = new URLSearchParams();
            params.append("id_pregunta", idPregunta);
    
            const response = await fetch(`index.php?controller=pregunta&action=remove`, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/x-www-form-urlencoded',
                    'X-Requested-With': 'XMLHttpRequest'
                },
                body: params.toString()
            }); 
            
            const data = await response.json();
            console.log('Respuesta del servidor:', data);
    
            if(data.status == "success")
            {
    
                console.log("Los datos son los siguientes: "+data.data["usuario"]["id"]);
    
                const usuario = data.data["usuario"];
                const pregunta = data.data["pregunta"];
    
    
                let html = `    
                <div class="contenedorPreguntaRemove">
                    <div class="fotoUsuarioPreguntaRemove">
                        <img src="${usuario["foto_perfil"] || "assets/img/fotoPorDefecto.png"}" alt="Foto de usuario">
                        <span>${usuario["username"]}</span>
                    </div>
            
                    <div class="preguntaTituloRemove">
                       <p>${pregunta["titulo"]}</p>
                    </div>
                    <div class="descripcionPreguntaRemove">
                        <p>${pregunta["descripcion"] ?? ""}</p>
                    </div>
                </div>`; 
    
                let respuestaUsuario;
                Swal.fire({
                    icon: 'warning',
                    title: 'Estas seguro de que quieres eliminar esta pregunta?',
                    html: html,
                    color: 'var(--color-letra)',
                    background: 'var(--color-principal)',
                    showDenyButton: true,
                    confirmButtonText: 'Aceptar',
                    denyButtonText: 'Cancelar'
    
                }).then((result)  => {
                    if(result.isConfirmed) {
                        respuestaUsuario = true;
                        console.log("La respuesta del usuario es la siguiente: "+ respuestaUsuario);
    
                        const parametros = new URLSearchParams;
                        parametros.append("id_pregunta", idPregunta);
                        
                        // Realizar la segunda llamada fetch correctamente
                        fetch(`index.php?controller=pregunta&action=delete`, {
                            method: 'POST',
                            headers: {
                                'Content-Type': 'application/x-www-form-urlencoded',
                                'X-Requested-With': 'XMLHttpRequest'
                            },
                            body: parametros.toString()
                        })
                        .then(response => response.json())
                        .then(data => {
                            if(data.status === "success") {
                                // Redirigir al usuario después de eliminar
                                window.location.href = data.redirect;
                            } 
                            else if(data.status === "error"){
                                Swal.fire({
                                    icon: 'error',
                                    title: 'Error',
                                    text: data.message  ,
                                    color: 'var(--color-letra)',
                                    background: 'var(--color-principal)'
                                });
                            }
                            else {
                                Swal.fire({
                                    icon: 'error',
                                    title: 'Error',
                                    text: 'No se pudo eliminar la pregunta',
                                    color: 'var(--color-letra)',
                                    background: 'var(--color-principal)'
                                });
                            }
                        })
                        .catch(error => {
                            console.error("Error al eliminar la pregunta:", error);
                        });
                    }
                    else if (result.isDenied) 
                    {
                        respuestaUsuario = false;
                    }
                });
            }
            
        } 
        catch (error) {
            console.log("Ha sucedido el siguiente error que nos ha llevado al catch de js: "+error);
        }
     
    
    
    //Una vez pulse que sí, elimino la pregunta y le redirijo al tema donde a eliminado la pregunta
    
    
    
    });
}




/* Eliminar respuesta      */


document.querySelectorAll('[id^="eliminarRespuesta-"]').forEach(boton => {
    boton.addEventListener('click', async function() {


        const idRespuesta = this.getAttribute('value');
        const botoEliminar = document.getElementById(`eliminarRespuesta-${idRespuesta}`);

        try
        {
            /*Primero recojo el usuario y la respuesta de la base de datos y luego muestro dentro del panel Swal */
            console.log("Comenzando la eliminiación de la respuesta");
            console.log("El id de la respuesta es " + idRespuesta );
            const params = new URLSearchParams();
            params.append("id_respuesta", idRespuesta);

            const response = await fetch(`index.php?controller=respuesta&action=remove`, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/x-www-form-urlencoded',
                    'X-Requested-With': 'XMLHttpRequest'
                },
                body: params.toString()
            }); 
            
            const data = await response.json();
            console.log('Respuesta del servidor:', data);

            if(data.status == "success")
            {

                console.log("Los datos son los siguientes: "+data.data["usuario"]["id"]);

                const usuario = data.data["usuario"];
                const respuesta = data.data["respuesta"];
                const idPregunta = respuesta["id_pregunta"];
                const imagen = respuesta["imagen"];

                let html = `    
                <div class="contenedorRespuestaDivididorRemove">
                <div class="fotoUsuarioRespuesta">
                    <img src="${usuario["foto_perfil"] || "assets/img/fotoPorDefecto.png"}" alt="Foto de usuario">
                    <span>${usuario["username"]}</span>
                </div>
                <div class="respuesta">
                    <div class="estrella-respuesta"></div>
                    <div class="contenidoRespuesta">
                        ${respuesta["texto"]}

                        <img class="imagenRespuesta" src="${imagen ?? "" }">
                    </div>
                </div>
                </div>`; 

                let respuestaUsuario;
                Swal.fire({
                    icon: 'warning',
                    title: 'Estas seguro de que quieres eliminar esta respuesta?',
                    html: html,
                    color: 'var(--color-letra)',
                    background: 'var(--color-principal)',
                    showDenyButton: true,
                    confirmButtonText: 'Aceptar',
                    denyButtonText: 'Cancelar'

                }).then((result)  => {
                    if(result.isConfirmed) {
                        respuestaUsuario = true;
                        console.log("La respuesta del usuario es la siguiente: "+ respuestaUsuario);

                        const parametros = new URLSearchParams;
                        parametros.append("id_pregunta", idPregunta);
                        parametros.append("id_respuesta" , idRespuesta);
                        
                        // Realizar la segunda llamada fetch correctamente
                        fetch(`index.php?controller=respuesta&action=delete`, {
                            method: 'POST',
                            headers: {
                                'Content-Type': 'application/x-www-form-urlencoded',
                                'X-Requested-With': 'XMLHttpRequest'
                            },
                            body: parametros.toString()
                        })
                        .then(response => response.json())
                        .then(data => {
                            if(data.status === "success") {
                                // Redirigir al usuario después de eliminar
                                window.location.href = data.redirect;
                            } 
                            else if(data.status === "error"){
                                Swal.fire({
                                    icon: 'error',
                                    title: 'Error',
                                    text: data.message  ,
                                    color: 'var(--color-letra)',
                                    background: 'var(--color-principal)'
                                });
                            }
                            else {
                                Swal.fire({
                                    icon: 'error',
                                    title: 'Error',
                                    text: 'No se pudo eliminar la pregunta',
                                    color: 'var(--color-letra)',
                                    background: 'var(--color-principal)'
                                });
                            }
                        })
                        .catch(error => {
                            console.error("Error al eliminar la pregunta:", error);
                        });
                    }
                    else if (result.isDenied) 
                    {
                        respuestaUsuario = false;
                    }
                });
            }
            
        } 
        catch (error) 
        {
            console.log("Ha sucedido el siguiente error en el catch del cliente: "+error);    
        }
    });
});