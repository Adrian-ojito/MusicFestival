<?php
require "includes/funciones.php";
requerirLogin();                       // antes de imprimir el header
require "includes/config/database.php";
$db = conectarBD();

$stmt = $db->prepare("SELECT c.id_compra, c.cantidad, c.total, c.telefono_asistente, c.email_asistente,  e.lugar AS zona, e.nombre
                    FROM compras c JOIN eventos e ON e.id_evento = c.id_evento
                    WHERE c.id_usuario = ? ORDER BY c.fecha_compra DESC");
$stmt->bind_param("i", $_SESSION['id_usuario']);
$stmt->execute();
$compras = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);

incluirTemplate("header", true);
?>

<main class="mis-entradas centrar">

    <h1 class="mis-entradas__titulo">Mis entradas</h1>
    <p class="mis-entradas__sub">Tienes <?= count($compras) ?> compra(s)</p>

    <?php foreach ($compras as $compra): ?>

        <?php
        $lugar = $compra["zona"];
        $clase_zona = strtolower(str_replace(" ", "-", $lugar));
        ?>

        <section class="tickets  flex">
            <div class="ticket ">
                <div class="ticket__header flex">
                    <span class="ticket__zona ticket__zona--<?php echo $clase_zona; ?>"><?= htmlspecialchars($lugar) ?></span>
                    <span class="ticket__estado">Válida</span>
                </div>
                <h2 class="ticket__titulo">Red Diamond Tourné</h2>
                <ul class="ticket__datos flex">
                    <li>17 dic 2027</li>
                    <li>8:00 pm</li>
                    <li>Estadio Nacional, Lima</li>

                </ul>

                <div class="ticket__compra flex">
                    <div><small>Cantidad</small><b><?= htmlspecialchars($compra['cantidad']) ?></b></div>
                    <div><small>Total pagado</small><b>S/ <?php echo number_format($compra['total'], 2); ?></b></div>
                    <div>
                        <p><small>Teléfono</small><b><?php echo htmlspecialchars($compra['telefono_asistente']) ; ?></b></p>
                    </div>
                    <div>
                        <p><small>Email</small><b><?php echo htmlspecialchars($compra['email_asistente']); ?></b></p>
                    </div>
                </div>


            </div>

            <div class="ticket__descargar flex">
                <img class="ticket__qr" src="https://qrtiger.com/temp/1791063000796.png" alt="QR Code entrada" />
                <a href="#" onclick="window.print(); return false;" class="boton-negro-block">Imprimir</a>
            </div>
        </section>
    <?php endforeach; ?>
</main>

<script src="build/js/bundle.js"></script>

<?php
incluirTemplate("footer");
?>