<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="assets/css/login.css">
    <link rel="stylesheet" href="assets/css/bodega.css">
    <link rel="stylesheet" href="assets/css/bootstrap.min.css" >
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">
    <title>AERGIBIDE - LOGIN</title>
</head>
<body>
    <div class="containerLogo">
        <img src="assets\img\LogoVectorizado.svg" alt="">
    </div>
    <div class="containerLogin">
        <div class="formulario">
            <h1><strong style="font-size: 35px;font-family: Mulish-Bold">Entrar en Aergibide</strong></h1> 
            <div class="inputs">
                <div class="email">
                    <label for=""><strong>Email</strong></label><br>
                    <input type="email" name="email" id="email" placeholder="Introduce tu email aquí" require><br>
                </div>

                <div class="password">
                    <label for=""><strong>Contraseña</strong></label><br>
                    <input type="password" name="password" id="password" placeholder="Introduce tu contraseña aquí" require><br>
                    <a href=""><strong>¿Olvidates la contraseña?</strong></a><br>
                </div>
            </div>  
            <button type="submit" id = "botonDeLogin" class="boton fondoAzulFrozono">Entrar</button>
        </div>
    </div>
    <script src="assets/js/login.js"></script>
</body>
</html>