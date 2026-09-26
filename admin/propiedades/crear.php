<?php
    require "../../includes/funciones.php";

    $auth=estaAutenticado();

    if(!$auth){
        header("Location: /");
    }


// Base de Datos

    require "../../includes/config/database.php";
    $bd = conectarBD();

    $consulta = "SELECT * FROM vendedores";
    $resultado= mysqli_query($bd, $consulta);

    $titulo = $_POST['titulo'] ?? '';
    $precio = $_POST['precio'] ?? '';
    $descripcion = $_POST['descripcion'] ?? '';
    $habitaciones = $_POST['habitaciones'] ?? '';
    $wc = $_POST['wc'] ?? '';
    $estacionamiento = $_POST['estacionamiento'] ?? '';
    $vendedorId = $_POST['vendedorId'] ?? '';
    $creado =  date("Y/m/d");

    $errores = [];
    if ($_SERVER["REQUEST_METHOD"] === "POST") {

        // echo "<pre>";
        // var_dump($_FILES);
        // echo "</pre>";  

        $titulo = mysqli_real_escape_string($bd,  $_POST["titulo"]);
        $precio = mysqli_real_escape_string($bd,  $_POST["precio"]);
        $descripcion = mysqli_real_escape_string($bd,  $_POST["descripcion"]);
        $habitaciones = mysqli_real_escape_string($bd,  $_POST["habitaciones"]);
        $wc = mysqli_real_escape_string($bd,  $_POST["wc"]);
        $estacionamiento = mysqli_real_escape_string($bd,  $_POST["estacionamiento"]);
        $vendedorId = mysqli_real_escape_string($bd,  $_POST["vendedor"]);

        // Asignar files hacia una variable
        $imagen = $_FILES["imagen"];



        if (!$titulo) {
            $errores[] = "Debes agregar un titulo";
        }

        if (!$precio) {
            $errores[] = "Debes establecer un precio";
        }

        if (strlen($descripcion) < 50) {
            $errores[] = "Debes agregar una descripcion mayor a 50 caracteres";
        }

        if (!$habitaciones) {
            $errores[] = "Debes agregar un número de habitaciones";
        }

        if (!$wc) {
            $errores[] = "Debes agregar un número de baños";
        }

        if (!$estacionamiento) {
            $errores[] = "Debes agregar un número de estacionamientos";
        }

        if (!$vendedorId) {
            $errores[] = "Debes agregar un vendedor";
        }

        if(!$imagen["name"]){
            $errores[]= "Agregar una imagen es obligatorio";
        }

        // Validar por tamaño (100  kb maximo)
        $medida = 1000 * 100;
        if($imagen["size"] > $medida || $imagen["error"]){
            $errores[]= "La imagen es muy pesada";
        }

        if (empty($errores)) {
            $carpetaImagenes = __DIR__ . "/../../imagenes";

            if(!is_dir($carpetaImagenes)){
                mkdir($carpetaImagenes);
            }

            // Subir la imagen
            $nombreImagen = md5(uniqid( rand(), true) ) .  ".jpg";

            move_uploaded_file($imagen["tmp_name"], $carpetaImagenes . "/" . $nombreImagen );



            // Insertar en la base de datos 
            $query = "INSERT INTO propiedades (titulo, precio, imagen, descripcion, habitaciones, wc, estacionamiento, creado, vendedores_id) VALUES ('$titulo',
                '$precio', '$nombreImagen', '$descripcion', '$habitaciones', '$wc', '$estacionamiento', '$creado', '$vendedorId')";

            $resultadoInsercion = mysqli_query($bd, $query);

            if ($resultadoInsercion) {
                // Redireccionar al usuario

                header("Location: /admin?resultado=1");
            }
        }
    }
    incluirTemplate("header");
?>

    <main class="contenedor seccion">
        <h1>Crear</h1>
        <a href="/admin" class="boton boton-verde">Volver</a>

        <?php foreach ($errores as $error): ?>
            <div class="alerta error">
                <?php echo $error; ?>
            </div>
        <?php endforeach; ?>


        <form class="formulario" method="POST" action="/admin/propiedades/crear.php" enctype="multipart/form-data">
            <fieldset>
                <legend>Imformación General</legend>

                <label for="titulo">Título</label>
                <input type="text" id="titulo" name="titulo" placeholder="Titulo Propiedad" value=<?php echo $titulo ?>>

                <label for="precio">Precio</label>
                <input type="number" id="precio" name="precio" placeholder="Precio Propiedad" value= <?php echo $precio ?>>

                <label for="imagen">Imagen</label>
                <input type="file" id="imagen" accept="image/jpeg, image/png" name = "imagen" >

                <label for="descripcion">Descripciòn:</label>
                <textarea id="descripcion" name="descripcion" > <?php echo $descripcion ?> </textarea>
            </fieldset>

            <fieldset>
                <legend>Imformacion Propiedad</legend>

                <label for="habitaciones">Habitaciones</label>
                <input type="number" id="habitaciones" name="habitaciones" placeholder="Ej: 3" min="1" value= <?php echo $habitaciones ?>>

                <label for="wc">Baños</label>
                <input type="number" id="wc" name="wc" placeholder="Ej: 2" min="1" max="9" value=<?php echo $wc ?>>

                <label for="estacionamiento">Estacionamiento</label>
                <input type="number" id="estacionamiento" name="estacionamiento" placeholder="Ej: 2" min="1" max="9" value=<?php echo $estacionamiento ?>>

            </fieldset>

            <fieldset>
                <legend>Vendedor</legend>

                <select name="vendedor" >
                    <option value="" >--Seleccionar--</option>
                    <?php  while ($vendedor = mysqli_fetch_assoc($resultado)) { ?>
                        <option <?php echo $vendedorId == $vendedor["id"] ? "selected" : "";  ?> value=" <?php echo $vendedor["id"]; ?> "> <?php echo $vendedor["nombre"] . " " . $vendedor["apellido"]; ?>
                    </option>
                    <?php }   ?>
                </select>

            </fieldset>

            <input type="submit" value="Crear Propiedad" class="boton boton-verde">


        </form>
    </main>

<?php
incluirTemplate("footer");
?>