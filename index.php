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
    <div class="contenido contenedor flex centrar">
        <div class="contenido-texto flex">
            <h1 class="contenido-texto--titulo">Music <span>Festival</span> </h1>
            <picture>
                <source src="build/img/image.avif" type="image/avif" loading="lazy">
                <source src="build/img/image.webp" type="image/webp" loading="lazy">
            </picture>
            <img src="build/img/image.png" alt="" loading="lazy" class="contenido-texto--imagen">
            <h3 class="contenido-texto--subtitulo">
                Find yourself in the music
            </h3>
            <div class="contenido-texto--botones flex">
                <a href="" class="boton-rojo-block">Slide show</a>
                <a href="" class="boton-negro-block">Learn More</a>
            </div><!-- contenido-texto--botones -->
        </div><!-- contenido-texto -->

        <div class="contenido-artistas">
            <img src="build/img/taylorSwift.png" class="artista_ taylor" alt="Taylor Swift"
                data-nombre="Taylor Swift" data-genero="Pop Icon"
                data-info="Letras que marcaron a toda una generación, en un show lleno de sorpresas.">
            <img src="build/img/edSheram.png" class="artista_ edsheeram" alt="Ed Sheeran"
                data-nombre="Ed Sheeran" data-genero="Singer-Songwriter"
                data-info="Guitarra, voz y baladas que llenan estadios enteros.">
            <img src="build/img/theWekkend.png" class="artista_ theweekend" alt="The Weeknd"
                data-nombre="The Weeknd" data-genero="R&B / Alternative"
                data-info="R&B oscuro y atmosférico con éxitos globales.">
            <img src="build/img/auroraAsknes.png" class="artista_ aurora" alt="Aurora"
                data-nombre="Aurora" data-genero="Ethereal Folk-Pop"
                data-info="Voz etérea y folk-pop con toques mágicos y envolventes.">
            <img src="build/img/brunoMars.png" class="artista_ brunomars" alt="Bruno Mars"
                data-nombre="Bruno Mars" data-genero="Funk & Soul Master"
                data-info="High energy performance with full brass orchestra.">
        </div> <!-- contenido artistas -->

        <div class="artists">
            <div class="artist"> <img src="build/img/auroraAsknes-artista.png" alt="">Artista 1</div>
            <div class="artist"><img src="build/img/brunoMars-artista.png">Artista 2</div>
            <div class="artist"><img src="build/img/edSheeran-artista.png">Artista 3</div>
            <div class="artist"><img src="build/img/taylorSwift-artista.png">Artista 4</div>
            <div class="artist"><img src="build/img/theWeeknd-artista.png">Artista 5</div>
        </div>

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
                    <source src="build/img/image2.avif" type="image/avif">
                    <source src="build/img/image2.webp" type="image/webp">
                </picture>
                <img src="build/img/image2.png" alt="imagen de concierto" loading="lazy">
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
            Dos formas de vivir una noche inolvidable
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

                <a href="http://localhost:3000/tickets.php?paso=1" class="boton-negro-block entrada__boton">
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

                <a href="http://localhost:3000/tickets.php?paso=1" class="boton-negro-block entrada__boton">
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

                <a href="http://localhost:3000/tickets.php?paso=1" class="boton-rojo-block entrada__boton">
                    Comprar tickets
                </a>
            </div>
        </div>
    </section>
</main>

<?php
incluirTemplate("footer");
?>