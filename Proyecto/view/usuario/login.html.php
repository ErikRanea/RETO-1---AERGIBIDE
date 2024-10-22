<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="assets/css/login.css">
    <title>AERGIBIDE - LOGIN</title>
</head>
<body>
    <div class="containerLogo">
        <img src="assets\img\LogoVectorizado.svg" alt="">
    </div>
    <div class="containerLogin">
        <form action="index.php?controller=usuario&action=" method="post">
            <h1>Entrar en Aergibide</h1>
            <label for="">Email</label><br>
            <input type="email" name="email" placeholder="Introduce tu email aquí"><br>
            <label for="">Contraseña</label><br>
            <input type="password" name="password" id="" placeholder="Introduce tu contraseña aquí"><br>
            <a href=""><strong>¿Olvidates la contraseña?</strong></a>
        </form>
    </div>

</body>
</html>