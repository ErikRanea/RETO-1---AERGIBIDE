// Función para establecer una cookie
function setCookie(name, value, days) {
    const date = new Date();
    date.setTime(date.getTime() + (days * 24 * 60 * 60 * 1000)); // Calcula la fecha de expiración
    const expires = "expires=" + date.toUTCString();
    document.cookie = name + "=" + value + ";" + expires + ";path=/";
}

// Función para obtener el valor de una cookie
function getCookie(name) {
    const nameEQ = name + "=";
    const ca = document.cookie.split(';');
    for (let i = 0; i < ca.length; i++) {
        let c = ca[i];
        while (c.charAt(0) == ' ') c = c.substring(1, c.length);
        if (c.indexOf(nameEQ) == 0) return c.substring(nameEQ.length, c.length);
    }
    return null;
}

document.addEventListener('DOMContentLoaded', function () {
    const themeToggle = document.querySelector('#darkModeIcon'); // Selecciona el icono con ID
    let isDarkMode = false;

    let darkModeLink = document.createElement('link');
    darkModeLink.rel = 'stylesheet';
    darkModeLink.href = 'assets/css/darkModeStyle.css';
    darkModeLink.id = 'darkModeStyle';

    let temasDarkLink = document.createElement('link');
    temasDarkLink.rel = 'stylesheet';
    temasDarkLink.href = 'assets/css/temasDark.css';
    temasDarkLink.id = 'temasDarkStyle';

    // Verifica si el modo oscuro está almacenado en las cookies
    if (getCookie('darkMode') === 'enabled') {
        document.head.appendChild(darkModeLink); // Cargar archivo dark-mode.css
        document.head.appendChild(temasDarkLink); // Cargar archivo temas-dark.css
        themeToggle.classList.remove('bi-moon-stars');
        themeToggle.classList.add('bi-moon-stars-fill');
        isDarkMode = true; // Actualiza el estado a oscuro
    }

    themeToggle.addEventListener('click', function () {
        isDarkMode = !isDarkMode;

        if (isDarkMode) {
            document.head.appendChild(darkModeLink); // Cargar archivo dark-mode.css
            document.head.appendChild(temasDarkLink); // Cargar archivo temas-dark.css

            // Cambiar el icono al modo lleno
            themeToggle.classList.remove('bi-moon-stars');
            themeToggle.classList.add('bi-moon-stars-fill');

            // Guarda la preferencia de modo oscuro en las cookies
            setCookie('darkMode', 'enabled', 7); // Guarda por 7 días
        } else {
            const existingDarkModeLink = document.getElementById('darkModeStyle');
            const existingTemasDarkLink = document.getElementById('temasDarkStyle');
            if (existingDarkModeLink) {
                existingDarkModeLink.remove(); // Remover archivo dark-mode.css
            }
            if (existingTemasDarkLink) {
                existingTemasDarkLink.remove(); // Remover archivo temas-dark.css
            }

            // Restaurar el icono al original
            themeToggle.classList.remove('bi-moon-stars-fill');
            themeToggle.classList.add('bi-moon-stars');

            // Elimina la preferencia de modo oscuro de las cookies
            setCookie('darkMode', 'disabled', 7); // Deshabilita por 7 días
        }
    });
});
