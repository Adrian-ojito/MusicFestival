<?php
require "includes/funciones.php";
incluirTemplate("header", true);

require "includes/config/database.php";
$db = conectarBD();
$query = "SELECT cantidad,total,telefono_asistente,email_asistente,id_evento  FROM compras WHERE id_usuario=" . $_SESSION['id_usuario'] . ";";
$resultado = mysqli_query($db, $query);
$compras = mysqli_fetch_all($resultado, MYSQLI_ASSOC);



?>

<main class="mis-entradas centrar">

    <h1 class="mis-entradas__titulo">Mis entradas</h1>
    <p class="mis-entradas__sub">Tienes 2 compras para Red Diamond Tourné. Muestra el QR en la puerta.</p>

    <?php foreach ($compras as $compra): ?>

        <?php
        $query = "SELECT lugar FROM eventos WHERE id_evento=" . $compra["id_evento"] . ";";
        $resultado_eventos = mysqli_query($db, $query);
        $evento = mysqli_fetch_assoc($resultado_eventos);
        $lugar = $evento["lugar"];
        $clase_zona = strtolower(str_replace(' ', '-', $lugar)); // "Platea Golden" -> "platea-golden"
        ?>

        <section class="tickets  flex">
            <div class="ticket ">
                <div class="ticket__header flex">
                    <span class="ticket__zona ticket__zona--<?php echo $clase_zona; ?>"><?php echo $lugar; ?></span>
                    <span class="ticket__estado">Válida</span>
                </div>
                <h2 class="ticket__titulo">Red Diamond Tourné</h2>
                <ul class="ticket__datos flex">
                    <li>17 dic 2027</li>
                    <li>8:00 pm</li>
                    <li>Estadio Nacional, Lima</li>

                </ul>

                <div class="ticket__compra flex">
                    <div><small>Cantidad</small><b><?php echo $compra['cantidad']; ?></b></div>
                    <div><small>Total pagado</small><b>S/ <?php echo number_format($compra['total'], 2); ?></b></div>
                    <div><p><small>Teléfono</small><b><?php echo $compra['telefono_asistente']; ?></b></p></div>
                    <div><p><small>Email</small><b><?php echo $compra['email_asistente']; ?></b></p></div>
                </div>


            </div>

            <div class="ticket__descargar flex">
                <img class="ticket__qr" src="https://qrtiger.com/temp/1791063000796.png" alt="QR Code entrada" />
                        <a href="#" class="boton-negro-block">Descargar</a>
                    </div>
                </div>
        </section>
    <?php endforeach; ?>
</main>

<script src="build/js/bundle.js"></script>

<?php
incluirTemplate("footer");
?>