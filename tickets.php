<?php

session_start();
var_dump($_SESSION);
if (empty($_SESSION['login'])) {
    header("Location: login.php");
    exit;
}

require "includes/config/database.php";
$db = conectarBD();

// formulario
$nombreUsuario = $_GET['nombre'] ?? "";
$cantidadTickets = $_GET['cantidad'] ?? "";
$totalCompra = $_GET['total'] ?? "";
$dni = $_POST['dni'] ?? "";
$email = $_POST['email'] ?? "";
$telefono = $_POST['telefono'] ?? "";
$errores = [];

// Datos de entradas

$ticket = $_GET['ticket'] ?? null;
$paso = $_GET['paso'] ?? null;


$query = "SELECT nombre, lugar, precio, entradas_disponibles FROM eventos WHERE nombre='$ticket';";
$resultado = mysqli_query($db, $query);
$datosTicket = mysqli_fetch_assoc($resultado) ?? null;
$nombre = $datosTicket['nombre'] ?? '';
$precio = $datosTicket['precio'] ?? '';
$lugar = $datosTicket['lugar'] ?? '';
$entradas_disponibles = $datosTicket['entradas_disponibles'] ?? 0;



if ($_SERVER["REQUEST_METHOD"] === "POST") {
    if (empty($_POST['nombre']) || empty($_POST['dni']) || empty($_POST['email']) || empty($_POST['telefono'])) {
        $errores[] = "Todos los campos son obligatorios";
    }

    if (empty($_SESSION['id_usuario'])) {
        $errores[] = "Debes iniciar sesión para comprar";
    }

    if (empty($errores)) {
        $nombreAsistente = htmlspecialchars(trim($_POST['nombre']), ENT_QUOTES, 'UTF-8');
        $dniAsistente = filter_var($_POST['dni'], FILTER_SANITIZE_NUMBER_INT);
        $emailAsistente = filter_var($_POST['email'], FILTER_SANITIZE_EMAIL);
        $telefonoAsistente = filter_var($_POST['telefono'], FILTER_SANITIZE_NUMBER_INT);
        $ticketPost = $_POST['ticket'] ?? '';
        $cantidadPost = (int) ($_POST['cantidad'] ?? 1);
        $idUsuario = $_SESSION['id_usuario'];

        // Buscar el id_evento y precio real (nunca confíes en un total calculado en el navegador)
        $stmt = $db->prepare("SELECT id_evento, precio FROM eventos WHERE nombre = ?");
        $stmt->bind_param("s", $ticketPost);
        $stmt->execute();
        $eventoEncontrado = $stmt->get_result()->fetch_assoc();

        if ($eventoEncontrado) {
            $idEvento = $eventoEncontrado['id_evento'];
            $totalCompra = $eventoEncontrado['precio'] * $cantidadPost;

            // Verificar que haya stock suficiente antes de vender
            $stmt = $db->prepare("SELECT entradas_disponibles FROM eventos WHERE id_evento = ?");
            $stmt->bind_param("i", $idEvento);
            $stmt->execute();
            $stockActual = $stmt->get_result()->fetch_assoc()['entradas_disponibles'];

            if ($cantidadPost > $stockActual) {
                $errores[] = "No hay suficientes entradas disponibles";
            } else {
                // Insertar la compra
                $stmt = $db->prepare("INSERT INTO compras (id_evento, id_usuario, nombre_asistente, dni_asistente, email_asistente, telefono_asistente, cantidad, total, fecha_compra) VALUES (?, ?, ?, ?, ?, ?, ?, ?, NOW())");
                $stmt->bind_param("iissssid", $idEvento, $idUsuario, $nombreAsistente, $dniAsistente, $emailAsistente, $telefonoAsistente, $cantidadPost, $totalCompra);
                $stmt->execute();

                // Restar la cantidad comprada del stock disponible
                $stmt = $db->prepare("UPDATE eventos SET entradas_disponibles = entradas_disponibles - ? WHERE id_evento = ?");
                $stmt->bind_param("ii", $cantidadPost, $idEvento);
                $stmt->execute();

                header("Location: tickets.php?paso=3&ticket=$ticketPost&cantidad=$cantidadPost&total=$totalCompra&nombre=" . urlencode($nombreAsistente));
                exit;
            }
        } else {
            $errores[] = "No se encontró el evento seleccionado";
        }
    }
}
?>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tickets</title>
    <link rel="stylesheet" href="/build/css/app.css">
</head>

<body>

    <div class="compra contenedor centrar">

        <button class="compra__volver puntero <?php if ($paso == 3) {
                                                    echo "desaparecer";
                                                } ?>" id="btn-volver" aria-label="Volver">
            <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                <path d="M19 12H5M12 19l-7-7 7-7" />
            </svg>
        </button>

        <div class="stepper flex" data-paso="1">
            <div class="stepper__paso flex <?php if ($paso == 1) {
                                                echo "stepper__paso-activo";
                                            } ?>" data-paso="1">
                <div class="stepper__circulo flex">1</div>
                <span class="stepper__texto">Tickets</span>
            </div>
            <div class="stepper__linea"></div>
            <div class="stepper__paso flex <?php if ($paso == 2) {
                                                echo "stepper__paso-activo";
                                            } ?>" data-paso="2">
                <div class="stepper__circulo flex">2</div>
                <span class="stepper__texto">Datos de compra</span>
            </div>
            <div class="stepper__linea"></div>
            <div class="stepper__paso flex <?php if ($paso == 3) {
                                                echo "stepper__paso-activo";
                                            } ?>" data-paso="3">
                <div class="stepper__circulo flex">3</div>
                <span class="stepper__texto">Confirmación</span>
            </div>
        </div>

        <!-- PASO 1 — Mapa -->
        <section class="paso <?php if ($paso == 1) {
                                    echo "activo";
                                }; ?>" id="paso-1" data-paso="1">

            <span class="compra__aviso">Selecciona tu ubicación en el mapa</span>

            <div class="mapa">
                <div class="mapa__todo flex">
                    <div class="mapa__escenario">Escenario</div>

                    <div class="mapa__zonas flex">
                        <div class="mapa__fila flex">
                            <div class="zona-grupo zona-grupo--ala zona-grupo--izq">
                                <span class="zona__accesible flex">♿</span>
                                <div class="zona zona__golden zona__mitad puntero" data-zona="golden"></div>
                                <div class="zona zona__vip zona__mitad puntero" data-zona="vip"></div>
                            </div>
                            <div class="zona-grupo zona-grupo--centro">
                                <div class="zona zona__golden zona__mitad puntero" data-zona="golden"></div>
                                <div class="zona zona__vip zona__mitad puntero" data-zona="vip"></div>
                            </div>
                            <div class="zona-grupo zona-grupo--ala">
                                <span class="zona__accesible flex">♿</span>
                                <div class="zona zona__golden zona__mitad puntero" data-zona="golden"></div>
                                <div class="zona zona__vip zona__mitad puntero" data-zona="vip"></div>
                            </div>
                        </div>

                        <div class="mapa__espaciador"></div>

                        <div class="mapa__fila flex">
                            <div class="zona-grupo zona-grupo--menor">
                                <div class="zona zona__vip zona__mitad puntero" data-zona="vip"></div>
                                <div class="zona zona__general zona__mitad puntero" data-zona="general"></div>
                            </div>
                            <div class="zona-grupo zona-grupo--menor">
                                <div class="zona zona__vip zona__mitad puntero" data-zona="vip"></div>
                                <div class="zona zona__general zona__mitad puntero" data-zona="general"></div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="leyenda flex">
                    <button class="leyenda__item flex borde puntero" data-zona="golden">
                        <span class="leyenda__punto" style="background: #d4293e"></span>
                        <div>
                            <div class="leyenda__nombre">Platea Golden</div>
                            <div class="leyenda__precio">S/ 175.00</div>
                        </div>
                    </button>
                    <button class="leyenda__item flex borde puntero" data-zona="vip">
                        <span class="leyenda__punto" style="background: #8f1c2a"></span>
                        <div>
                            <div class="leyenda__nombre">Platea VIP</div>
                            <div class="leyenda__precio">S/ 145.00</div>
                        </div>
                    </button>
                    <button class="leyenda__item flex borde puntero" data-zona="general">
                        <span class="leyenda__punto" style="background: #3a3730"></span>
                        <div>
                            <div class="leyenda__nombre">Platea General</div>
                            <div class="leyenda__precio">S/ 59.00</div>
                        </div>
                    </button>
                    <button class="boton-rojo-block confirmar">
                        Continuar
                    </button>
                </div>
            </div>
        </section>


        <!-- PASO 2 — Datos de compra -->
        <section class="paso <?php if ($paso == 2) {
                                    echo "activo";
                                }; ?>" id="paso-2" data-paso="2">
            <div class="paso2 flex">

                <div class="paso2__form">
                    <div class="datos__resumen flex borde">
                        <div>
                            <div class="datos__resumen-zona" id="datos-zona"><?php echo $nombre; ?></div>
                            <div class="datos__resumen-precio" id="datos-precio">S/<?php echo $precio; ?>c/u</div>
                        </div>
                        <div class="datos__cantidad flex" data-precio="<?php echo $precio; ?>" data-stock="<?php echo $entradas_disponibles; ?>">
                            <button class="datos__cantidad-btn borde puntero" id="cantidad-menos" type="button">−</button>
                            <span id="cantidad-valor">1</span>
                            <button class="datos__cantidad-btn borde puntero" id="cantidad-mas" type="button">+</button>
                        </div>
                    </div>
                    <?php if (!empty($errores)): ?>
                        <div class="errores">
                            <?php foreach ($errores as $error): ?>
                                <p><?= htmlspecialchars($error) ?></p>
                            <?php endforeach; ?>
                        </div>
                    <?php endif; ?>

                    <form class="formulario" id="formulario-compra" method="POST">
                        <input type="hidden" name="ticket" value="<?php echo htmlspecialchars($ticket); ?>">
                        <input type="hidden" name="cantidad" id="cantidad-hidden" value="1">
                        <div class="campo flex">
                            <label for="nombre">Nombre completo</label>
                            <input type="text" id="nombre" class="borde" required name="nombre">
                        </div>
                        <div class="campo flex">
                            <label for="documento">DNI / documento</label>
                            <input type="text" id="documento" class="borde" required name="dni">
                        </div>
                        <div class="campo flex">
                            <label for="email">Correo electrónico</label>
                            <input type="email" id="email" class="borde" required name="email">
                        </div>
                        <div class="campo flex">
                            <label for="telefono">Teléfono</label>
                            <input type="tel" id="telefono" class="borde" required name="telefono">
                        </div>

                        <div class="formulario__pie flex">
                            <div class="total">Total <strong id="total-valor">S/ 0.00</strong></div>
                            <button class="boton-rojo-block " id="confirmar-compra">
                                Confirmar Compra
                            </button>
                        </div>
                    </form>
                </div>

                <aside class="paso2__promo flex">
                    <div>
                        <span class="paso2__promo-eyebrow">Guarda tu comprobante</span>
                        <h3 class="paso2__promo-titulo">Music<br>Festival</h3>
                        <p class="paso2__promo-nota">Lo necesitarás para el ingreso al evento.</p>
                    </div>
                </aside>

            </div>
        </section>

        <!-- PASO 3 — Confirmación -->
        <section class="paso <?php if ($paso == 3) {
                                    echo "activo";
                                }; ?>" id="paso-3" data-paso="3">
            <div class="confirmacion">
                <h2 class="confirmacion__titulo">Compra confirmada</h2>
                <p class="confirmacion__texto">Podras ver el estado de tus entradas en "mis entradas" dando click a tu perfil</p>

                <!-- ... tu confirmacion__resumen tal cual está ... -->
                <p class="confirmacion__redireccion">
                    Serás redirigido al inicio en <span id="contador-inicio">10</span> segundos...
                </p>
                <div class="confirmacion__resumen borde">
                    <div class="confirmacion__fila flex">
                        <span>Zona</span>
                        <span id="conf-zona"><?php echo $nombre; ?></span>
                    </div>
                    <div class="confirmacion__fila flex">
                        <span>Cantidad</span>
                        <span id="conf-cantidad"><?php echo $cantidadTickets; ?></span>
                    </div>
                    <div class="confirmacion__fila flex">
                        <span>Comprador</span>
                        <span id="conf-nombre"><?php echo $nombreUsuario; ?></span>
                    </div>
                    <div class="confirmacion__fila flex">
                        <span>Total pagado</span>
                        <span id="conf-total"> S/<?php echo $totalCompra; ?></span>
                    </div>
                </div>
            </div>
        </section>

    </div>

    <div class="resumen flex" id="resumen">
        <div class="resumen__contenido flex">
            <div class="resumen__detalle">
                Zona seleccionada: <span class="resumen__zona" id="resumen-zona">—</span>
                &nbsp;·&nbsp; <span class="resumen__precio" id="resumen-precio">S/ 0.00</span>
            </div>
            <button class="boton puntero" id="btn-continuar" disabled>Continuar</button>
        </div>
    </div>


    <script src="/build/js/bundle.min.js"></script>


</body>

</html>