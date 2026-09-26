<?php
    require "../includes/funciones.php";
    require "../includes/config/database.php";

    $auth=estaAutenticado();

    if(!$auth){
        header("Locatio: /");
    }

    $mensajeResultado = $_GET["resultado"] ?? null;
    
    
    $db = conectarBD();

    // Validar si realmente se envió el formulario por POST y existe el ID
    $idPropiedad = $_POST["id"] ?? null;
    
    if ($idPropiedad) {
        // 1. Sanitizar el ID para evitar inyecciones SQL
        $idPropiedad= filter_var($idPropiedad, FILTER_VALIDATE_INT);

        // 2. Buscar la imagen correspondiente antes de borrar el registro
        $queryConsulta = "SELECT imagen FROM propiedades WHERE id = $idPropiedad";
        $resultadoConsulta = mysqli_query($db, $queryConsulta);
        $propiedad = mysqli_fetch_assoc($resultadoConsulta);

        if ($propiedad) {
            $carpetaImagenes = __DIR__ . "/../imagenes";
            $pathImagen = $carpetaImagenes . "/" . $propiedad["imagen"];
            unlink($pathImagen);
        }

        // Ejecutar el borrado en la base de datos
        $queryDelete = "DELETE FROM propiedades WHERE id = $idPropiedad";
        $resultadoDelete = mysqli_query($db, $queryDelete);

        if ($resultadoDelete) {
            header("Location: /admin?resultado=3");
            exit;
        }
    }

    // Consulta general para pintar la tabla después de procesar el POST (o si es una carga normal por GET)
    $query = "SELECT * FROM propiedades;";
    $resultado = mysqli_query($db, $query);

    incluirTemplate("header");
?>

    <main class="contenedor seccion">
        <h1>Administrador de Bienes Raices</h1>
        <?php if( $mensajeResultado=== "1"){?>
                <p class="alerta exito">Anuncio Creado Correctamente</p>
        <?php }elseif ( $mensajeResultado=== "2") {?>
                <p class="alerta exito">Anuncio Actualizado Correctamente</p>  
        <?php }elseif ( $mensajeResultado==="3"){?>
                <p class="alerta exito">Anuncio Eliminado Correctamente</p>
        <?php } ?> 

        <a href="/admin/propiedades/crear.php" class="boton boton-verde">Nueva Propiedad</a>

        <table class="propiedades">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Titulo</th>
                    <th>Imagen</th>
                    <th>Precio</th>
                    <th>Acciones</th>
                </tr>
            </thead>

            <tbody>
                
                    <?php while ($propiedad = mysqli_fetch_assoc($resultado)): ?>
                        <tr>
                            <td> <?php echo $propiedad["id"] ?> </td>
                            <td> <?php echo $propiedad["titulo"] ?></th>
                            <td> <img src="/imagenes/<?php echo $propiedad["imagen"] ?>"      class="imagen-tabla"></td>
                            <td><?php echo $propiedad["precio"] ?></td>
                            <td>
                                <form method="POST" class="w-100">
                                    <input type="hidden" name="id" value="<?php echo $propiedad["id"]; ?>">
                                    <input type="submit" class="boton-rojo-block w-100" value="Eliminar">
                                </form>

                                <a href="admin/propiedades/actualizar.php?id=<?php echo $propiedad["id"] ?>" class="boton-amarillo-block">Actualizar</a>
                            </td>
                        </tr>
                    <?php endwhile;?>
                
            </tbody>
        </table>

    </main>

<?php

    mysqli_close($db);
    incluirTemplate("footer");
?>