<?php
session_start();                          
require "includes/config/database.php";
$db = conectarBD();

$operacion = $_GET["registro"] ?? "";    
$errores = [];
$usuario = "";

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $usuario = trim($_POST["usuario"] ?? "");   
    $password = $_POST["password"] ?? "";

    if ($usuario === "" || $password === "") {
        $errores[] = "Usuario y contraseña son obligatorios";
    }

    if (empty($errores)) {
        $stmt = $db->prepare("SELECT id_usuario, contrasena_hash FROM usuarios WHERE nombre = ?");
        $stmt->bind_param("s", $usuario);
        $stmt->execute();
        $fila = $stmt->get_result()->fetch_assoc();

        if ($fila && password_verify($password, $fila["contrasena_hash"])) {
            session_regenerate_id(true);
            $_SESSION["login"] = true;
            $_SESSION["usuario"] = $usuario;
            $_SESSION["id_usuario"] = $fila["id_usuario"];
            header("Location: /index.php");   
            exit;                             
        } else {
            $errores[] = "Usuario o contraseña incorrectos";
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
    <p>“Crea tu cuenta en<span class="login__marca">Global Music Group</span></p>

    <?php foreach ($errores as $error): ?>
        <div class=" alerta error">
            <?php echo htmlspecialchars($error) ?>
        </div>
    <?php endforeach; ?>
    <form method="POST" class="login__form">
        <fieldset class="login__fieldset flex "">
                <legend class=" login__legend">
            </legend>

            <label for="usuario" class="login__label">NOMBRE DE USUARIO</label>
            <input type="text" id="usuario" placeholder="ingresa tu usuario" class="login__input" name="usuario" value="<?= htmlspecialchars($usuario) ?>">

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

    <img class="login--imagen " src="/build/img/poster1.png" alt="">
    </section>



</body>

</html>



<?php
require "includes/funciones.php";
incluirTemplate("footer");
?>