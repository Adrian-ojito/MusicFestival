<?php
session_start();
$resultado = $_GET["resultado"] ?? "<li class='navegacion-enlace'><a href='login.php'>Sing in</a></li>";
if (!empty($_SESSION["login"])) {
    $resultado = "<li class='navegacion-enlace perfil'><span class='material-symbols-outlined'>
account_box</span>
<div class='navegacion-perfil '>
    <a  class='navegacion-perfil__enlace' href='mis_entradas.php'>Mis entradas</a>
    <a class='navegacion-perfil__enlace' href='logout.php'>Cerrar sesión</a>
</div>
</li>";
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
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Bebas+Neue&family=Work+Sans:wght@400;500;600&display=swap" rel="stylesheet">
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

    <header class="header centrar flex">
        <div class="header--cabeza ">
            <a href="/"><img class="header-imagen " src="build/img/logo.png" alt="Global Music Group logo"></a>
            <button class="navegacion-hamburguesa" id="navegacion-hamburguesa" aria-label="Abrir menú">
                <span class="navegacion-hamburguesa-linea"></span>
                <span class="navegacion-hamburguesa-linea"></span>
                <span class="navegacion-hamburguesa-linea"></span>
            </button>
        </div>
        <nav class="navegacion">
            <ul class="navegacion-enlaces flex ">
                <li class="navegacion-enlace"><a href="index.php">Home</a></li>
                <li class="navegacion-enlace"><a href="index.php#nosotros">About us</a></li>
                <li class="navegacion-enlace"><a href="index.php#servicios">Service</a></li>
                <li class="navegacion-enlace"><a href="index.php#entradas">Tickets</a></li>
                <?php echo $resultado; ?>

                <li style="visibility: hidden;">
                    
                </li>
            </ul>
        </nav>


    </header>