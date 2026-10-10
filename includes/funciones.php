<?php

require "app.php";
function incluirTemplate( string $nombre,  bool $inicio = false){
    include TEMPLATES_URL ."/{$nombre}.php" ;
}

function estaAutenticado() : bool {
    session_start();

    $auth= $_SESSION["login"];
    if($auth){
        return true;
    }
    return false;
}

function e($valor): string {          // escapar al IMPRIMIR
    return htmlspecialchars((string)$valor, ENT_QUOTES, 'UTF-8');
}

function iniciarSesion(): void {
    if (session_status() === PHP_SESSION_NONE) session_start();
}

function requerirLogin(): void {      // llamar ANTES de imprimir cualquier HTML
    iniciarSesion();
    if (empty($_SESSION['login'])) { header("Location: /login.php"); exit; }
}

function csrfToken(): string {
    iniciarSesion();
    if (empty($_SESSION['csrf'])) $_SESSION['csrf'] = bin2hex(random_bytes(32));
    return $_SESSION['csrf'];
}

function verificarCsrf(): bool {
    iniciarSesion();
    return hash_equals($_SESSION['csrf'] ?? '', $_POST['csrf'] ?? '');
}