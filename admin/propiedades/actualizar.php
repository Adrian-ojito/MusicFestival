<?php
    require "../../includes/funciones.php";

    $auth=estaAutenticado();

    if(!$auth){
        header("Location: /");
    }



    // $Validar la url por ID
    $id= $_GET["id"];
    $id= filter_var($id, FILTER_VALIDATE_INT);

    if(!$id){
    header('Location: /admin');
    exit;
    }
// Base de Datos

    require "../../includes/config/database.php";
    $bd = conectarBD();

    $consulta = "SELECT * FROM propiedades";
    $resultado= mysqli_query($bd, $consulta);
    
    while ($propiedad = mysqli_fetch_assoc($resultado)):
        if($propiedad["id"] == $id){
            $titulo = $propiedad["titulo"];
            $precio = $propiedad["precio"];
            $descripcion = $propiedad["descripcion"];
            $habitaciones = $propiedad["habitaciones"];
            $wc = $propiedad["wc"];
            $estacionamiento = $propiedad["estacionamiento"];
            $vendedorId = $propiedad["vendedores_id"]; 
            $creado =  $propiedad["creado"];
            $imagenPropiedad = $propiedad["imagen"];
            break;
        }
    endwhile;

    // Nueva consulta para traer vendedores
    $consultaVendedores = "SELECT * FROM vendedores";
    $resultadoVendedores = mysqli_query($bd, $consultaVendedores);
    

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

        // Validar por tamaño (100  kb maximo)
        $medida = 1000 * 100;
        if($imagen["name"] && ($imagen["size"] > $medida || $imagen["error"])){
            $errores[]= "La imagen es muy pesada";
        }

        if (empty($errores)) {
            $carpetaImagenes = __DIR__ . "/../../imagenes";
            if(!is_dir($carpetaImagenes)){
                mkdir($carpetaImagenes);
            }

            // Subir la imagen
            if ($imagen["name"]) {
                unlink($carpetaImagenes . "/" . $imagenPropiedad);
                $nombreImagen = md5(uniqid(rand(), true)) . ".jpg";
                move_uploaded_file($imagen["tmp_name"], $carpetaImagenes . "/" . $nombreImagen);
            } else {
                $nombreImagen = $imagenPropiedad; // la imagen que ya tenía la propiedad
            }

            //cambiar datos  en la base de datos 
            $query = "UPDATE propiedades 
                    SET titulo= '$titulo',
                        precio= '$precio',
                        imagen= '$nombreImagen',
                        descripcion= '$descripcion',
                        habitaciones= $habitaciones,
                        wc= $wc,
                        estacionamiento= $estacionamiento,
                        creado= '$creado',
                        vendedores_id= '$vendedorId'
                    WHERE id = $id ;";
            
            $resultadoActualizacion = mysqli_query($bd, $query);

            if ($resultadoActualizacion) {
                header("Location: /admin?resultado=2&id=" . $id);
                exit;
            } else {
                $errores[] = "Error al actualizar" . mysqli_error($bd);
            }
        }
    }

    incluirTemplate("header");
?>

    <main class="contenedor seccion">
        <h1>Actualizar Propiedad</h1>

        

        <a href="/admin" class="boton boton-verde">Volver</a>

        <?php foreach ($errores as $error): ?>
            <div class="alerta error">
                <?php echo $error; ?>
            </div>
        <?php endforeach; ?>


        <form class="formulario" method="POST" action="/admin/propiedades/actualizar.php?id=<?php echo $id; ?>" enctype="multipart/form-data">
            <fieldset>
                <legend>Imformación General</legend>
                
                <label for="titulo">Título</label>
                <input type="text" id="titulo" name="titulo" placeholder="Titulo Propiedad" value="<?php echo $titulo; ?>">

                <label for="precio">Precio</label>
                <input type="number" id="precio" name="precio" placeholder="Precio Propiedad" value= "<?php echo $precio ?>">

                <label for="imagen">Imagen</label>
                <input type="file" id="imagen" accept="image/jpeg, image/png" name = "imagen" >
                <img class="small-image"  src="/imagenes/<?php echo $imagenPropiedad; ?>" alt="imagen-propiedad">

                <label for="descripcion">Descripción</label>
                <textarea id="descripcion" name="descripcion" > <?php echo $descripcion ?> </textarea>
            </fieldset>

            <fieldset>
                <legend>Imformacion Propiedad</legend>

                <label for="habitaciones">Habitaciones</label>
                <input type="number" id="habitaciones" name="habitaciones" placeholder="Ej: 3" min="1" value= "<?php echo $habitaciones ?>">

                <label for="wc">Baños</label>
                <input type="number" id="wc" name="wc" placeholder="Ej: 2" min="1" max="9" value="<?php echo $wc ?>">

                <label for="estacionamiento">Estacionamiento</label>
                <input type="number" id="estacionamiento" name="estacionamiento" placeholder="Ej: 2" min="1" max="9" value="<?php echo $estacionamiento ?>">

            </fieldset>

            <fieldset>
                <legend>Vendedor</legend>

                <select name="vendedor" >
                    <option value="" >--Seleccionar--</option>
                    <?php  while ($vendedor = mysqli_fetch_assoc($resultadoVendedores)) { ?>
                        <option <?php echo $vendedorId == $vendedor["id"] ? "selected" : "";  ?> value=" <?php echo $vendedor["id"]; ?> "> <?php echo $vendedor["nombre"] . " " . $vendedor["apellido"]; ?>
                    </option>
                    <?php } ?>
                </select>

            </fieldset>

            <input type="submit" value="Actualizar Propiedad" class="boton boton-verde">


        </form>
    </main>

<?php
incluirTemplate("footer");
?>