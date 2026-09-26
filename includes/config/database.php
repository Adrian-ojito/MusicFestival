<?php

function conectarBD(): mysqli{
    $bd= mysqli_connect("localhost", "root", "1234", "musicfestival");

    if(!$bd){
        echo " Error no se pudo conectar";
        exit;
    }

    return $bd;
}
