<?php
session_start();
$resultado = $_GET["resultado"] ?? "<li class='navegacion-enlace'><a href='login.php'>Sing in</a></li>";
if (!empty($_SESSION["login"])) {
    $resultado = "<li class='navegacion-enlace perfil'><span class='material-symbols-outlined'>
account_box
</span></li>";
}

?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200&icon_names=account_circle" />
    <link rel="stylesheet" href="build/css/app.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link
        href="https://fonts.googleapis.com/css2?family=Abril+Fatface&family=Work+Sans:ital,wght@0,100..900;1,100..900&display=swap"
        rel="stylesheet">
    <link rel="stylesheet"
        href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200&icon_names=mail" />
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200&icon_names=familiar_face_and_zone" />
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200&icon_names=account_box" />
    <title>Music Festival</title>
</head>

<body>

    <header class="header flex centrar">
        <div class="header--cabeza">
            <a href="/"><img class="header-imagen" src="build/img/logo.png" alt="Global Music Group logo"></a>
            <button class="navegacion-hamburguesa" id="navegacion-hamburguesa" aria-label="Abrir menú">
                <span class="navegacion-hamburguesa-linea"></span>
                <span class="navegacion-hamburguesa-linea"></span>
                <span class="navegacion-hamburguesa-linea"></span>
            </button>
        </div>
        <nav class="navegacion">
            <ul class="navegacion-enlaces flex ">
                <li class="navegacion-enlace"><a href="/">Home</a></li>
                <li class="navegacion-enlace"><a href="#nosotros">About us</a></li>
                <li class="navegacion-enlace"><a href="#servicios">Service</a></li>
                <li class="navegacion-enlace"><a href="#entradas">Tickets</a></li>
                <?php echo $resultado; ?>
                <li>
                    <div class="navegacion-perfil ">
                        <a href="">Mis entradas</a>
                        <a href="logout.php">Cerrar sesión</a>
                    </div>
                </li>
            </ul>
        </nav>


    </header>