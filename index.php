<?php


require "includes/funciones.php";
incluirTemplate("header", true);

?>
<div id="overlayArtista" class="overlay-artista">
    <div class="modal-artista">
        <button id="cerrarModalArtista" class="modal-artista__cerrar">&times;</button>
        <p id="modalArtistaGenero" class="modal-artista__genero"></p>
        <h2 id="modalArtistaNombre" class="modal-artista__nombre"></h2>
        <p id="modalArtistaInfo" class="modal-artista__info"></p>
        <hr class="modal-artista__linea">
        <a href="#entradas" class="modal-artista__boton">
            VER ENTRADAS PARA ESTE SET
        </a>
    </div>
</div>
<main>
    <div class="contenido flex centrar">
        <div class="contenido-texto flex">
            <img src="build/img/red_diamond_tournee_logo.png" alt="Red Diamond Tourné" class="contenido-texto--imagen">
            <div class="cuenta" role="timer" aria-label="Tiempo restante para el show">
                <p class="cuenta__titulo">Faltan para el show</p>
                <div class="cuenta__tiempos">
                    <div class="cuenta__item">
                        <span class="cuenta__numero" id="cuentaDias">000</span>
                        <span class="cuenta__etiqueta">días</span>
                    </div>
                    <div class="cuenta__item">
                        <span class="cuenta__numero" id="cuentaHoras">00</span>
                        <span class="cuenta__etiqueta">horas</span>
                    </div>
                    <div class="cuenta__item">
                        <span class="cuenta__numero" id="cuentaMinutos">00</span>
                        <span class="cuenta__etiqueta">min</span>
                    </div>
                    <div class="cuenta__item">
                        <span class="cuenta__numero" id="cuentaSegundos">00</span>
                        <span class="cuenta__etiqueta">seg</span>
                    </div>
                </div> <!-- cuentas__tiempos -->
            </div> <!-- cuenta -->



            <div class="contenido-texto--botones flex">
                <a href="#entradas" class="boton-rojo-block">Comprar entradas</a>
                <a href="" class="boton-negro-block">Learn More</a>
            </div><!-- contenido-texto--botones -->
        </div><!-- contenido-texto -->

        <div class="contenido-artistas">
            <img src="build/img/TaylorSwiftt.png" class="artista_ taylor" alt="Taylor Swift"
                data-nombre="Taylor Swift" data-genero="Pop Icon"
                data-info="Letras que marcaron a toda una generación, en un show lleno de sorpresas.">
            <img src="build/img/EdSheramm.png" class="artista_ edsheeram" alt="Ed Sheeran"
                data-nombre="Ed Sheeran" data-genero="Singer-Songwriter"
                data-info="Guitarra, voz y baladas que llenan estadios enteros.">
            <img src="build/img/TheWekkendd.png" class="artista_ theweekend" alt="The Weeknd"
                data-nombre="The Weeknd" data-genero="R&B / Alternative"
                data-info="R&B oscuro y atmosférico con éxitos globales.">
            <img src="build/img/Aurora.png" class="artista_ aurora" alt="Aurora"
                data-nombre="Aurora" data-genero="Ethereal Folk-Pop"
                data-info="Voz etérea y folk-pop con toques mágicos y envolventes.">
            <img src="build/img/brunomars.png" class="artista_ brunomars" alt="Bruno Mars"
                data-nombre="Bruno Mars" data-genero="Funk & Soul Master"
                data-info="High energy performance with full brass orchestra.">
        </div> <!-- contenido artistas -->

        <section class="artists-seccion">
            <div class="artists-divisor"><span></span></div>

            <div class="artists-cabecera">
                <p class="artists-cabecera__etiqueta">Line-up</p>
                <h3 class="artists-cabecera__titulo">Cinco artistas.<br>Una noche.</h3>
            </div>

            <div class="artists" id="artistas">
                <div class="artist" data-nombre="Aurora" data-genero="Ethereal Folk-Pop"
                    data-info="Voz etérea y folk-pop con toques mágicos y envolventes.">
                    <img src="build/img/auroraAsknes-artista.png" alt="Aurora" loading="lazy">
                    <span class="artist__contador">01 / 05</span>
                    <div class="artist__info">
                        <span class="artist__genero">Ethereal Folk-Pop</span>
                        <p class="artist__nombre">Aurora</p>
                    </div>
                </div>

                <div class="artist" data-nombre="Bruno Mars" data-genero="Funk & Soul Master"
                    data-info="High energy performance with full brass orchestra.">
                    <img src="build/img/brunoMars-artista.png" alt="Bruno Mars" loading="lazy">
                    <span class="artist__contador">02 / 05</span>
                    <div class="artist__info">
                        <span class="artist__genero">Funk &amp; Soul Master</span>
                        <p class="artist__nombre">Bruno Mars</p>
                    </div>
                </div>

                <div class="artist" data-nombre="Ed Sheeran" data-genero="Singer-Songwriter"
                    data-info="Guitarra, voz y baladas que llenan estadios enteros.">
                    <img src="build/img/edSheeran-artista.png" alt="Ed Sheeran" loading="lazy">
                    <span class="artist__contador">03 / 05</span>
                    <div class="artist__info">
                        <span class="artist__genero">Singer-Songwriter</span>
                        <p class="artist__nombre">Ed Sheeran</p>
                    </div>
                </div>

                <div class="artist" data-nombre="Taylor Swift" data-genero="Pop Icon"
                    data-info="Letras que marcaron a toda una generación, en un show lleno de sorpresas.">
                    <img src="build/img/taylorSwift-artista.png" alt="Taylor Swift" loading="lazy">
                    <span class="artist__contador">04 / 05</span>
                    <div class="artist__info">
                        <span class="artist__genero">Pop Icon</span>
                        <p class="artist__nombre">Taylor Swift</p>
                    </div>
                </div>

                <div class="artist" data-nombre="The Weeknd" data-genero="R&B / Alternative"
                    data-info="R&B oscuro y atmosférico con éxitos globales.">
                    <img src="build/img/theWeeknd-artista.png" alt="The Weeknd" loading="lazy">
                    <span class="artist__contador">05 / 05</span>
                    <div class="artist__info">
                        <span class="artist__genero">R&amp;B / Alternative</span>
                        <p class="artist__nombre">The Weeknd</p>
                    </div>
                </div>
            </div>

            <div class="artists-puntos" id="artistasPuntos"></div>
            <p class="artists-ayuda">Desliza para ver a todos los artistas</p>
        </section>

    </div><!-- contenido -->

    <section class="nosotros flex contenedor centrar" id="nosotros">
        <div class="nosotros-texto">
            <h3>About Us</h3>
            <h2> <span>Welcome To Our Music</span> Festival</h2>
            <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Accusantium dolorem modi, quod iste labore
                <span>
                    dicta commodi voluptas amet numquam? Illum itaque voluptate ad dicta ipsum quo unde soluta.
                </span>
            </p>
            <p>Lorem ipsum dolor sit, amet consectetur adipisicing elit. Doloribus, alias iure pariatur ipsam
                <span>
                    consectetur error distinctio officia ea voluptate debitis nulla quae voluptates a excepturi.
                </span>
                Lorem ipsum dolor sit amet consectetur adipisicing elit. Nemo, quidem sed totam commodi <span>
                    facilis
                    blanditiis impedit voluptates illo molestias tempora similique veritatis fugit aut earum <span>
                        labore
                        recusandae, est asperiores eligendi?
                    </span>
                </span>
            </p>
            <a href="build/img/image2.png" class="boton-rojo-block">Explore Now</a>
            <div class="nosotros-imagen1">
                <picture>
                    <source srcset="build/img/image2.avif" type="image/avif">
                    <source srcset="build/img/image2.webp" type="image/webp">
                    <img src="build/img/image2.png" alt="Público en concierto" loading="lazy">
                </picture>
            </div> <!-- nosotros-imagen -->


        </div> <!-- nosotros-texto -->
        <div class="nosotros-imagen">
            <picture>
                <source src="build/img/image2.avif" type="image/avif">
                <source src="build/img/image2.webp" type="image/webp">
            </picture>
            <img src="build/img/image2.png" alt="imagen de concierto" loading="lazy">
        </div> <!-- nosotros-imagen -->
    </section>

    <section class="servicios contenedor centrar" id="servicios">

        <h2 class="servicios-titulo">the best service</h2>
        <picture>
            <source src="build/img/image3.avif" type="image/avif">
            <source src="build/img/image3.webp" type="image/webp">
        </picture>
        <img src="build/img/image3.png" alt="hombre en bateria" loading="lazy" class="servicios-image1">

        <div class="servicios-contenido ">

            <div class="servicios-texto">
                <h3>01. service</h3>
                <p>Lorem, ipsum dolor sit amet consectetur adipisicing elit. Quae natus molestias voluptas dignissimos
                    vero aut fugiat recusandae labore, fugit culpa placeat repellendus! Sequi adipisci rem doloremque
                    reiciendis magni, nihil cum!</p>
            </div><!-- servicio-texto -->
            <div class="servicios-texto">
                <h3>01. service</h3>
                <p>Lorem, ipsum dolor sit amet consectetur adipisicing elit. Quae natus molestias voluptas dignissimos
                    vero aut fugiat recusandae labore, fugit culpa placeat repellendus! Sequi adipisci rem doloremque
                    reiciendis magni, nihil cum!</p>
            </div><!-- servicio-texto -->
        </div> <!-- servicio-contenido -->
        <picture>
            <source src="build/img/image4.avif" type="image/avif">
            <source src="build/img/image4.webp" type="image/webp">
        </picture>
        <img src="build/img/image4.png" alt="hombre cantando" loading="lazy" class="servicios-image2">

    </section>

    <section class="entradas flex" id="entradas">
        <h2 class="entradas__titulo">
            Elige tu <span>experiencia</span>
        </h2>

        <p class="entradas__subtitulo">
            Lorem ipsum dolor sit amet.
        </p>

        <div class="entradas__contenedor flex">
            <div class="entrada flex">
                <h3 class="entrada__titulo">Entrada normal</h3>

                <div class="entrada__precio">
                    <h3>desde</h3>
                    <p>$<span>49</span></p>
                </div>

                <ul class="entrada__beneficios flex">
                    <li>Acceso al evento</li>
                    <li>Acceso al evento</li>
                    <li>Acceso al evento</li>
                    <li>Acceso al evento</li>
                </ul>

                <a href="tickets.php?paso=1" class="boton-negro-block entrada__boton">
                    Comprar tickets
                </a>
            </div>
            <div class="entrada flex">
                <h3 class="entrada__titulo">Entrada normal</h3>

                <div class="entrada__precio">
                    <h3>desde</h3>
                    <p>$<span>49</span></p>
                </div>

                <ul class="entrada__beneficios flex">
                    <li>Acceso al evento</li>
                    <li>Acceso al evento</li>
                    <li>Acceso al evento</li>
                    <li>Acceso al evento</li>
                </ul>

                <a href="tickets.php?paso=1" class="boton-negro-block entrada__boton">
                    Comprar tickets
                </a>
            </div>
            <div class="entrada flex">
                <h3 class="entrada__titulo">Entrada Especial</h3>

                <div class="entrada__precio">
                    <h3>desde</h3>
                    <p>$<span>149</span></p>
                </div>

                <ul class="entrada__beneficios flex">
                    <li>Acceso al evento</li>
                    <li>Acceso al evento</li>
                    <li>Acceso al evento</li>
                    <li>Acceso al evento</li>
                </ul>

                <a href="tickets.php?paso=1" class="boton-rojo-block entrada__boton">
                    Comprar tickets
                </a>
            </div>
        </div>
    </section>
</main>

<?php
incluirTemplate("footer");
?>