<?php
require "includes/config/database.php";
$db = conectarBD();


$usuario = $_POST['usuario'] ?? null;
$password = $_POST['password'] ?? null;

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

    $query = "SELECT nombre, contraseña_hash FROM usuarios";
    $resultados = mysqli_query($db, $query);
    $usuario = htmlspecialchars(trim($usuario), ENT_QUOTES, 'UTF-8');

    while ($resultado = mysqli_fetch_assoc($resultados)):
        if ($resultado["nombre"] === $usuario) {
            $errores[] = "Use un diferente nombre usuario";
        }
    endwhile;

    if (empty($errores)) {
        
        $password = password_hash($password, PASSWORD_BCRYPT);

        $query = "INSERT INTO usuarios (nombre, contraseña_hash) VALUES 
                    ('$usuario', '$password' );";
        $resultado = mysqli_query($db, $query);
        if ($resultado) {
            header("Location: ../login.php?registro=exitoso");
            exit();
        } else {
            header("Location: ../crear_cuenta.php?registro=error");
            exit();
        }
    }
} ?>



<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200&icon_names=account_circle" />
    <link rel="stylesheet" href="build/css/app.css">
    <title>Crear Cuenta</title>

</head>

<body>
    <section class="login">
        <a href="index.php" class="login__logo"><img src="build/img/logo.png" alt="logo empresa"></a>

        <div class="login__card  centrar"">
        <h2 class=" login__titulo">Crear Cuenta</h2>
            <p>Bienvenido de nuevo a <span class="login__marca">Global Music Group</span></p>

            <?php foreach ($errores as $error): ?>
                <div class="alerta error">
                    <?php echo $error; ?>
                </div>
            <?php endforeach ?>

            <form method="POST" class="login__form">
                <fieldset class="login__fieldset flex "">
                <legend class=" login__legend">
                    </legend>

                    <label for="usuario" class="login__label">NOMBRE DE USUARIO</label>
                    <input type="text" id="usuario" placeholder="ingresa tu usuario" class="login__input" name="usuario" value="<?php echo $usuario; ?>">

                    <label for="password" class="login__label">CONTRASEÑA</label>
                    <input type="password" id="password" placeholder="ingresa tu CONTRASEÑA" class="login__input" name="password" value="<?php echo $password; ?>">

                    <input type="submit" value="Crear Cuenta" class="login__submit">
                </fieldset>
            </form>
            <div class="login__crear-cuenta flex">
                <span class="material-symbols-outlined">
                    account_circle
                </span>
                <a href="login.php">Iniciar Sesion</a>
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