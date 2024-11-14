
let btnPrincipales = document.getElementsByClassName("btnPanelLateral")
for (let btnPrincipal of btnPrincipales) {
    btnPrincipal.addEventListener("click", cambiarPanelPrincipal);
}

let divPrincipal = document.getElementById("panelPrincipalUsuario");

// Cargar la vista Datos de Uuario por defecto
document.addEventListener("DOMContentLoaded", () => {
    // Selecciona el botón "Preguntas" por su ID y simula el evento
    const btnDatos = document.getElementById("btnDatos");
    cambiarPanelPrincipal({ target: btnDatos });
});

// Usamos delegación de eventos para el div contenedor de la actividad
divPrincipal.addEventListener("click", (event) => {
    if ( event.target.id === "btnEditarUsuario" ){
        habilitarEdicion(event);
    }
});


divPrincipal.addEventListener("click" , (event) => {
    if ( event.target.id === "btnCambiarPassword")
    {
        cambiarContraseña(event);
    }
})

divPrincipal.addEventListener("click", (event) => {

    if ( event.target.id === "btnPhotoEdit" ){
        cambiarFoto(event);
    }

    if (event.target.classList.contains("btnPanelActividad")) {
        verActividad(event);
    }

    if (event.target.classList.contains("btnPanelGestion")) {
        verGestion(event);
    }

    if (event.target.classList.contains("btnPanelLateral")) {
        cambiarPanelPrincipal(event);
    }

});

// Escucha el evento "change" directamente en el input de tipo file
divPrincipal.addEventListener("change", (event) => {
    if (event.target.id === "btnAddFotoPerfil") {
        mostrarFoto(event);
    }
});

function mostrarFoto(event){
    console.log("AÑADIR FOTO")
    // Opcional: Previsualiza la imagen seleccionada
    let archivo = event.target.files[0]; // Obtiene el archivo seleccionado

    if (archivo) {
        let reader = new FileReader();
        reader.onload = function(e) {
            document.getElementById("imgAddFotoPerfil").src = e.target.result; // Actualiza la imagen de perfil con la imagen seleccionada
        };
        reader.readAsDataURL(archivo); // Lee el archivo como URL
    }
}

function habilitarEdicion(event){
    event.preventDefault();

    console.log("FUNCIONA EL CLICK");

    // Mostrar el contenedor de botones de acción
    document.getElementById("actionsEditarUsuario").style.display = "flex";

    // Habilitar la edicion de los campos
    document.getElementById("txtNombreEdit").disabled = false;
    document.getElementById("txtApellidoEdit").disabled = false;
    document.getElementById("txtEmailEdit").disabled = false;
}

async function setPassword(event) {
    event.preventDefault();
    const idUsuario = document.getElementById("idUsuario").value;


    try {
      
        const response = await fetch(`index.php?controller=usuario&action=datosUsuario&id=${idUsuario}`, {
            headers: {
                'Content-Type': 'application/x-www-form-urlencoded',
                'X-Requested-With': 'XMLHttpRequest'
            }
        });

        const data = await response.json();
        console.log('Respuesta del servidor:', data);
        
        if(data.status == "success")
        {
            swal.fire(data.data["username"]);

            const { value: formValues } = await Swal.fire({
                title: "Cambiar contraseña",
                html:
                  '<input id="swal-input2" class="swal2-input" type="password" placeholder="Nueva contraseña">' +
                  '<input id="swal-input3" class="swal2-input" type="password" placeholder="Confirmar nueva contraseña">',
                focusConfirm: false,
                preConfirm: () => {
                  const newPassword = document.getElementById("swal-input2").value;
                  const confirmPassword = document.getElementById("swal-input3").value;
              

                  if (!newPassword || !confirmPassword) {
                    Swal.showValidationMessage("Por favor, complete todos los campos.");
                  } else if (newPassword !== confirmPassword) {
                    Swal.showValidationMessage("Las nuevas contraseñas no coinciden.");
                  } else {
                    return {
                      currentPassword: currentPassword,
                      newPassword: newPassword,
                    };
                  }
                }
              });
              
              if (formValues) {

                const params = new URLSearchParams();
                params.append("pwdNueva",formValues.newPassword);
                params.append("idUsuario",idUsuario);

                const r2 = await fetch(`index.php?controller=usuario&action=updatePassword`,{
                    method: "POST",
                    headers: {
                        'Content-Type': 'application/x-www-form-urlencoded',
                        'X-Requested-With': 'XMLHttpRequest'
                    },
                    body: params.toString()
                });

                const data2 = await r2.json();

                if(data2.status == "success")
                {

                    Swal.fire({
                        icon: 'success',
                        title: 'Contraseña cambiada con exito!',
                        color: 'var(--color-letra)',
                        background: 'var(--color-principal)',
                        confirmButtonText: 'Volver',
                        timer: 3000,
                        timerProgressBar: true,
                        customClass: {
                            confirmButton: 'btn btnCrear'
                        },
                        willClose: () => {
                            window.location.href = `index.php?controller=usuario&action=mostrarDatosUsuario`;
                          }
                
                    }).then((result)  => {
                        if(result.isConfirmed) {
                            window.location.href = `index.php?controller=usuario&action=mostrarDatosUsuario`;
                        }
                    });
                }
                else if(data2.status == "error")
                {
                    swal.fire({
                        icon: "error",
                        title: "Ha sucedido el siguiente error",
                        text: data2.message
                    });
                }

              }
              

        }  
        else if(data.status == "error")
        {
            swal.fire(data.message);
        }
    } 
    catch (error) {
        console.log("El error en el catch"+ error.message);
    }



}


async function cambiarContraseña(event)
{
    event.preventDefault();

    console.log("Abriendo formulario ");

    const idUsuario = document.getElementById("idUsuario").value;

    try {
      
        const response = await fetch(`index.php?controller=usuario&action=datosUsuario&id=${idUsuario}`, {
            headers: {
                'Content-Type': 'application/x-www-form-urlencoded',
                'X-Requested-With': 'XMLHttpRequest'
            }
        });

        const data = await response.json();
        console.log('Respuesta del servidor:', data);
        
        if(data.status == "success")
        {
            swal.fire(data.data["username"]);

            const { value: formValues } = await Swal.fire({
                title: "Cambiar contraseña",
                html:
                  '<input id="swal-input1" class="swal2-input" type="password" placeholder="Contraseña actual">' +
                  '<input id="swal-input2" class="swal2-input" type="password" placeholder="Nueva contraseña">' +
                  '<input id="swal-input3" class="swal2-input" type="password" placeholder="Confirmar nueva contraseña">',
                focusConfirm: false,
                preConfirm: () => {
                  const currentPassword = document.getElementById("swal-input1").value;
                  const newPassword = document.getElementById("swal-input2").value;
                  const confirmPassword = document.getElementById("swal-input3").value;
              
                  // Validación simple
                  if (!currentPassword || !newPassword || !confirmPassword) {
                    Swal.showValidationMessage("Por favor, complete todos los campos.");
                  } else if (newPassword !== confirmPassword) {
                    Swal.showValidationMessage("Las nuevas contraseñas no coinciden.");
                  } else {
                    return {
                      currentPassword: currentPassword,
                      newPassword: newPassword,
                    };
                  }
                }
              });
              
              if (formValues) {

                const params = new URLSearchParams();
                params.append("pwdActual",formValues.currentPassword);
                params.append("pwdNueva",formValues.newPassword);
                params.append("idUsuario",idUsuario);

                const r2 = await fetch(`index.php?controller=usuario&action=updatePassword`,{
                    method: "POST",
                    headers: {
                        'Content-Type': 'application/x-www-form-urlencoded',
                        'X-Requested-With': 'XMLHttpRequest'
                    },
                    body: params.toString()
                });

                const data2 = await r2.json();

                if(data2.status == "success")
                {

                    Swal.fire({
                        icon: 'success',
                        title: 'Contraseña cambiada con exito!',
                        color: 'var(--color-letra)',
                        background: 'var(--color-principal)',
                        confirmButtonText: 'Volver',
                        timer: 3000,
                        timerProgressBar: true,
                        customClass: {
                            confirmButton: 'btn btnCrear'
                        },
                        willClose: () => {
                            window.location.href = `index.php?controller=usuario&action=mostrarDatosUsuario`;
                          }
                
                    }).then((result)  => {
                        if(result.isConfirmed) {
                            window.location.href = `index.php?controller=usuario&action=mostrarDatosUsuario`;
                        }
                    });
                }
                else if(data2.status == "error")
                {
                    swal.fire({
                        icon: "error",
                        title: "Ha sucedido el siguiente error",
                        text: data2.message
                    });
                }

              }
              

        }  
        else if(data.status == "error")
        {
            swal.fire(data.message);
        }
    } 
    catch (error) {
        console.log("El error en el catch"+ error.message);
    }
}

function cambiarFoto(event){
    event.preventDefault();

    console.log("LLEGA AL PRIMERO");
    let fileInput = document.getElementById("newImage");

    if (fileInput){
        fileInput.click();
        console.log("LLEGA AL CLICK")

        // Registrar el evento 'change' para capturar la imagen seleccionada
        fileInput.addEventListener("change", function(event) {
            let selectedImage = event.target.files[0];

            // Verificar si la imagen se ha seleccionado
            if (selectedImage) {
                console.log("Imagen seleccionada:", selectedImage.name); // Muestra el nombre del archivo en la consola
                console.log(typeof selectedImage);

                // Enviar el Formulario
                console.log("Enviando Formulario")
                document.getElementById("photoForm").submit();

            } else {
                console.log("Ninguna imagen seleccionada");
            }
        });

    } else {
        console.log("NADA");
    }
}

async function cambiarPanelPrincipal(event){
    //event.preventDefault();

    let idBtn = event.target.getAttribute("id");
    const paramsPrincipal = new URLSearchParams();

    if (idBtn === "btnDatos"){
        paramsPrincipal.append("vista", "DatosUsuario")
    } else if (idBtn === "btnActividad"){
        paramsPrincipal.append("vista", "Actividad")
    } else {
        paramsPrincipal.append("vista", "PanelControl")
    }

    console.log(paramsPrincipal.toString());

    // Elimina la clase 'active' de todos los botones
    for (let btn of btnPrincipales) {
        btn.classList.remove("active");
    }

    // Añade la clase 'active' solo al botón clickeado
    event.target.classList.add("active");

    const responsePrincipal = await fetch("index.php?controller=usuario&action=mostrarPrincipal", {
        method: "POST",
        headers: {
            "Content-Type": "application/x-www-form-urlencoded",
            "X-Requested-With": "XMLHttpRequest"
        },
        body: paramsPrincipal.toString()
    });

    const responsePrincipalTxt = await responsePrincipal.text();
    console.log(`Respuesta Servidor: ${responsePrincipalTxt}`);

    try {
        const dataPrincipal = JSON.parse(responsePrincipalTxt);

        if (dataPrincipal.status === "success"){
            console.log(dataPrincipal.data)

            divPrincipal.innerHTML = dataPrincipal.data.html;

            let btn
            // Si el botón seleccionado es "Actividad", carga "Preguntas" por defecto
            if (idBtn === "btnActividad") {
                btn = document.getElementById("btnPregunta");
                verActividad({ target: btn }); // Llama a verActividad simulando un clic en "Preguntas"
            }

            // Si el botón seleccionado es "Panel Control", carga "Lista de Usuarios" por defecto
            if (idBtn === "btnPanelControl") {
                btn = document.getElementById("btnGestion");
                verGestion({ target: btn }); // Llama a verGestion simulando un clic en "Lista de Usuarios"
            }

        } else {
            console.log(`ERROR: ${dataPrincipal.message}`)
        }

    } catch (error){
        console.log(`ERROR catch: ${error}`)
    }

}

async function verActividad(event) {
    //event.preventDefault();

    const idActividad = event.target.getAttribute("id");
    const user = document.getElementById("username").value;
    const paramsActividad = new URLSearchParams();

    if (idActividad === "btnPregunta") {
        paramsActividad.append("vista", "Preguntas_Usuario");

    } else if (idActividad === "btnRespuesta") {
        paramsActividad.append("vista", "Respuestas_Usuario");

    } else {
        paramsActividad.append("vista", "Guardados");

    }

    paramsActividad.append("username", user);

    //console.log(user);
    console.log(paramsActividad.toString());
    const response = await fetch("index.php?controller=usuario&action=mostrarActividad", {
        method: "POST",
        headers: {
            "Content-Type": "application/x-www-form-urlencoded",
            "X-Requested-With": "XMLHttpRequest"
        },
        body: paramsActividad.toString()
    });

    // Imprimir el texto de respuesta para depuración
    const responseActividadText = await response.text(); // Leer como texto
    console.log("Respuesta del servidor:", responseActividadText); // Ver lo que está devolviendo el servidor

    try {
        const dataActividad = JSON.parse(responseActividadText);

        if (dataActividad.status === "success") {
            console.log(dataActividad.data);

            let divActividad = document.getElementById("contenidoActividad")
            divActividad.innerHTML = dataActividad.data.html;

            // Elimina la clase 'active' de todos los botones de actividad
            let btnActividades = document.getElementsByClassName("btnPanelActividad");
            for (let btn of btnActividades) {
                btn.classList.remove("active");
            }

            // Añade la clase 'active' solo al botón clickeado
            event.target.classList.add("active");


        } else {
            console.error("Error en la respuesta:" + dataActividad.message);
        }
    } catch (error) {
        console.log("Error catch: " + error);

    }

}

async function cargarPaginacion(pagina, vista){
    const user = document.getElementById("username").value;
    const params = new URLSearchParams();

    params.append("vista", vista);
    params.append("page", pagina);
    params.append("username", user);

    const response = await fetch("index.php?controller=usuario&action=mostrarActividad", {
        method: "POST",
        headers: {
            "Content-Type": "application/x-www-form-urlencoded",
            "X-Requested-With": "XMLHttpRequest"
        },
        body: params.toString()
    });

    // Imprimir el texto de respuesta para depuración
    const responseText = await response.text(); // Leer como texto
    console.log("Respuesta del servidor:", responseText); // Ver lo que está devolviendo el servidor

    try {
        const dataPag = JSON.parse(responseText);

        if (dataPag.status === "success") {
            console.log(dataPag.data);

            let divActividad = document.getElementById("contenidoActividad")
            divActividad.innerHTML = dataPag.data.html;


        } else {
            console.error("Error en la respuesta:" + dataPag.message);
        }
    } catch (error) {
        console.log("Error: " + error);

    }

}

async function verGestion(event){
    const id = event.target.getAttribute("id");
    let paramsGestion = new URLSearchParams();

    if (id === "btnGestion" ){
        paramsGestion.append("vista", "Gestion");
    } else {
        paramsGestion.append("vista", "CrearUsuario")
    }
    console.log(paramsGestion.toString());

    const responseGestion = await fetch("index.php?controller=usuario&action=mostrarGestion", {
        method: "POST",
        headers: {
            "Content-Type": "application/x-www-form-urlencoded",
            "X-Requested-With": "XMLHttpRequest"
        },
        body: paramsGestion.toString()
    });

    const responseGestionTxt = await responseGestion.text();
    console.log(`Respuesta del Servidor: ${responseGestionTxt}`);

    try {
        const dataGestion = JSON.parse(responseGestionTxt)

        if (dataGestion.status === "success"){
            console.log(dataGestion.data);

            let divGestion = document.getElementById("contenidoGestion");
            divGestion.innerHTML = dataGestion.data.html;

            let btnGestiones = document.getElementsByClassName("btnPanelGestion")
            for (let btn of btnGestiones) {
                btn.classList.remove("active")
            }

            event.target.classList.add("active");

        } else {
            console.log(`ERROR data: ${dataGestion.message}`)
        }


    } catch (error){
        console.log(`ERROR catch: ${error}`)
    }




}

async function deleteUsuario(userId){
    console.log("CLICK BOTON DELETE")
    const params = new URLSearchParams();
    params.append("idUsuario", userId);

    console.log(params.toString());

    let confirmado = confirm("¿Estás seguro de que deseas eliminar este usuario?");
    if (confirmado) {

        const response = await fetch('index.php?controller=usuario&action=confirmDelete', {
            method: 'POST',
            headers: {
                "Content-Type": "application/x-www-form-urlencoded",
                'X-Requested-With': 'XMLHttpRequest'
            },
            body: params.toString()
        });

        const responsetxt = await response.text();
        console.log("respuesta del javascript: " + responsetxt);
        try {
            const data = JSON.parse(responsetxt);
            console.log("variable data: "+ data);

            if (data.status === "success") {
                alert("Usuario eliminado exitosamente");
                // Eliminar el usuario de la interfaz
                const usuarioElemento = document.getElementById(`contenedorUsuario`+userId);
                if (usuarioElemento) {
                    usuarioElemento.remove();
                }
            } else {
                console.error(data.message);
                alert("Hubo un problema al eliminar el usuario.");
            }
        } catch(error) {
            console.error("Error:", error);
            alert("Error al intentar eliminar el usuario.");
        }
    }
}

async function editarUsuario(userId) {
    console.log("CLICK BOTON EDITAR");

    const params = new URLSearchParams();
    params.append("vista", "Editar")
    params.append("idUsuario", userId);
    console.log(params.toString());

    const responseEdit = await fetch('index.php?controller=usuario&action=mostrarPrincipal', {
        method: 'POST',
        headers: {
            "Content-Type": "application/x-www-form-urlencoded",
            'X-Requested-With': 'XMLHttpRequest'
        },
        body: params.toString()
    });

    const responseEditTxt = await responseEdit.text();
    console.log(`Respuesta Servidor: ${responseEditTxt}`);

    try {
        const dataPrincipal = JSON.parse(responseEditTxt);

        if (dataPrincipal.status === "success") {
            console.log(dataPrincipal.data)

            divPrincipal.innerHTML = dataPrincipal.data.html;

        }
    } catch (error) {
        console.log(`ERROR catch: ${error}`)
    }
}

