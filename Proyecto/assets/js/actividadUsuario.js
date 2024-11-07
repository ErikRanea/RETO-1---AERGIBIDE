let btnActividades = document.getElementsByClassName("btnPanel")
for (let btn of btnActividades) {
    btn.addEventListener("click", verContenido)
}

let divContenido = document.getElementById("contenidoActividad")


async function verContenido(event) {
    //event.preventDefault();

    const id = event.target.getAttribute("id");
    const user = document.getElementById("username").value;
    const params = new URLSearchParams();

    if (id === "btnPregunta") {
        params.append("vista", "Preguntas_Usuario");

    } else if (id === "btnRespuesta") {
        params.append("vista", "Respuestas_Usuario");

    } else {
        params.append("vista", "Guardados");

    }

    params.append("username", user);

    // Elimina la clase 'active' de todos los botones
    for (let btn of btnActividades) {
        btn.classList.remove("active");
    }

    // Añade la clase 'active' solo al botón clickeado
    event.target.classList.add("active");

    //console.log(user);
    console.log(params.toString());
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
        const data = JSON.parse(responseText);

        if (data.status === "success") {
            console.log(data.data);

            divContenido.innerHTML = data.data.html;


        } else {
            console.error("Error en la respuesta:" + data.message);
        }
    } catch (error) {
        console.log("Error: " + error);

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
        const data = JSON.parse(responseText);

        if (data.status === "success") {
            console.log(data.data);

            divContenido.innerHTML = data.data.html;


        } else {
            console.error("Error en la respuesta:" + data.message);
        }
    } catch (error) {
        console.log("Error: " + error);

    }

}


//console.log(`Posiciones de ${busqueda}: ${posiciones}`);

// Obtener el archivo html a cargar
/*
let archivo = event.target.getAttribute("data-file");

if (archivo) {
    // Usa Fetch API para cargar el contenido del archivo HTML
    fetch(archivo)
        .then(response => {
            if (!response.ok) {
                throw new Error("Error al cargar");
            }
            return response.text();
        })
        .then(html => {

            divContenido.innerHTML = html;
        })
        .catch(error => {
            console.error("Error:" + error);
            divContenido.innerHTML = "Ruta Archivo no encontrado";
        })

} else {
    divContenido.innerHTML = "Archivo no especificado";
}
*/










