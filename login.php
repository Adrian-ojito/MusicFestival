<?php
$operacion = $_GET["registro"] ?? "";
require "includes/config/database.php";
$db = conectarBD();

$usuario = $_POST['usuario'] ?? "";
$password = $_POST['password'] ?? "";
$errores = [];
?>


<?php if ($_SERVER["REQUEST_METHOD"] == "POST") {

    if (empty($usuario)) {
        $errores[] = "Nombre de usuario obligatorio";
    }
    if (empty($password)) {
        $errores[] = "Contraseña obligatoria";
    }
    if (!empty($password) && strlen($password) < 8) {
        $errores[] = "La contraseña debe tener al menos 8 caracteres";
    }

    if (empty($errores)) {
        $usuario = htmlspecialchars(trim($usuario), ENT_QUOTES, 'UTF-8');

        $query = "SELECT nombre, contraseña_hash, id_usuario FROM usuarios";
        $resultados = mysqli_query($db, $query);

        $usuarioPassword = null;
        while ($resultado = mysqli_fetch_assoc($resultados)):
            if ($resultado["nombre"] === $usuario) {
                $usuarioPassword = $resultado["contraseña_hash"];
                $id_usuario = $resultado["id_usuario"];
            }
        endwhile;

        if ($usuarioPassword === null) {
            $errores[] = "Usuario no encontrado";
        } else {
            $auth = password_verify($password, $usuarioPassword);
            if ($auth) {
                session_start();
                $_SESSION["login"] = true;
                $_SESSION["usuario"] = $usuario;
                $_SESSION["id_usuario"] = $id_usuario; // ahora SÍ lo guardas en la sesión
                header("Location: /index.php");
                exit;
            } else {
                $errores[] = "El password es incorrecto";
            }
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="build/css/app.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200&icon_names=account_circle" />
    <title>Iniciar Sesion</title>
</head>

<body>
    <section class="login">
        <a href="index.php" class="login__logo"><img src="build/img/logo.png" alt="logo empresa"></a>

        <div class="login__card  centrar"">
            <?php
            if ($operacion === "exitoso") { ?>
                <div class=" alerta exito">
            <?php echo "Cuenta creada con exito"; ?>
        </div>
    <?php } ?>
    <h2 class=" login__titulo">iniciar sesion</h2>
    <p>Bienvenido de nuevo a <span class="login__marca">Global Music Group</span></p>

    <?php foreach ($errores as $error): ?>
        <div class=" alerta error">
            <?php echo $error; ?>
        </div>
    <?php endforeach; ?>
    <form method="POST" class="login__form">
        <fieldset class="login__fieldset flex "">
                <legend class=" login__legend">
            </legend>

            <label for="usuario" class="login__label">NOMBRE DE USUARIO</label>
            <input type="text" id="usuario" placeholder="ingresa tu usuario" class="login__input" name="usuario" value="<?php echo $usuario; ?>">

            <label for="password" class="login__label">CONTRASEÑA</label>
            <input type="password" id="password" placeholder="ingresa tu CONTRASEÑA" class="login__input" name="password">

            <input type="submit" value="iniciar sesion" class="login__submit">
        </fieldset>
    </form>
    <div class="login__crear-cuenta flex">
        <span class="material-symbols-outlined">
            account_circle
        </span>
        <a href="crear_cuenta.php">Crear Cuenta</a>
    </div>

    </div>

    <img class="login--imagen " src="/build/img/image2.png" alt="">
    </section>



</body>

</html>



<?php
require "includes/funciones.php";
incluirTemplate("footer");
?>