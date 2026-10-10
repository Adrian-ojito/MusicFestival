<?php
require "includes/funciones.php";
require "includes/config/database.php";
iniciarSesion();
$db = conectarBD();

$usuario = '';
$errores = [];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (!verificarCsrf()) $errores[] = "Sesión expirada, recarga la página.";
    $usuario   = trim($_POST['usuario'] ?? '');
    $password  = $_POST['password'] ?? '';
    $password2 = $_POST['password2'] ?? '';

    if (!preg_match('/^[A-Za-z0-9_.-]{3,30}$/', $usuario)) $errores[] = "Usuario: 3 a 30 caracteres (letras, números, _ . -)";
    if (strlen($password) < 8) $errores[] = "La contraseña debe tener al menos 8 caracteres";
    if ($password !== $password2) $errores[] = "Las contraseñas no coinciden";

    if (empty($errores)) {
        $hash = password_hash($password, PASSWORD_DEFAULT);
        $stmt = $db->prepare("INSERT INTO usuarios (nombre, contrasena_hash) VALUES (?, ?)");
        $stmt->bind_param("ss", $usuario, $hash);
        try {
            $stmt->execute();
            header("Location: /login.php?registro=exitoso");
            exit;
        } catch (mysqli_sql_exception $e) {
            if ($e->getCode() === 1062) $errores[] = "Ese nombre de usuario ya existe";
            else { error_log($e->getMessage()); $errores[] = "No pudimos crear tu cuenta. Intenta de nuevo."; }
        }
    }
}
?>


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

        <img class="login--imagen " src="/build/img/image2.png" alt="">
        <div class="login__card  centrar"">
        <h2 class=" login__titulo">Crear Cuenta</h2>
            <p>“Crea tu cuenta en Global Music Group <span class="login__marca">Global Music Group</span></p>

            <?php foreach ($errores as $error): ?>
                <div class="alerta error">
                    <?php echo htmlspecialchars($error) ?>
                </div>
            <?php endforeach ?>

            <form method="POST" class="login__form">
                <fieldset class="login__fieldset flex "">
                <legend class=" login__legend">
                    </legend>

                    <label for="usuario" class="login__label">NOMBRE DE USUARIO</label>
                    <input type="text" id="usuario" placeholder="ingresa tu usuario" class="login__input" name="usuario" value="<?php echo htmlspecialchars($usuario); ?>">

                    <label for="password" class="login__label">CONTRASEÑA</label>
                    <input type="password" id="password" placeholder="ingresa tu CONTRASEÑA" class="login__input" name="password">

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
    </section>

</body>

</html>


<?php

incluirTemplate("footer");
?>