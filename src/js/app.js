document.addEventListener("DOMContentLoaded", function () {
    navegacionPerfil();
    volver();
    modalArtistasIndex();

    const pasoActual = getActivo(); // 1, 2 o 3

    if (pasoActual === 1) paso1();
    if (pasoActual === 2) paso2();
    if (pasoActual === 3) paso3();

});
function navegacionPerfil() {
    const perfil = document.querySelector(".perfil");
    const navegacionPerfil = document.querySelector(".navegacion-perfil");
    if (!perfil || !navegacionPerfil) return; // si no existen en esta página, salir sin error
    perfil.addEventListener("click", function () {
        navegacionPerfil.classList.toggle("show");
    })
};


const botonesDia = document.querySelectorAll('.lineup__dia-btn');
const artistas = document.querySelectorAll('.artista');

botonesDia.forEach(btn => {
    btn.addEventListener('click', () => {
        botonesDia.forEach(b => b.classList.remove('activo'));
        btn.classList.add('activo');
        const dia = btn.dataset.dia;

        artistas.forEach(art => {
            if (art.dataset.dia === dia) {
                art.classList.remove('oculto');
            } else {
                art.classList.add('oculto');
                art.classList.remove('expandido');
            }
        });
    });
});

artistas.forEach(art => {
    art.addEventListener('click', () => {
        const yaExpandido = art.classList.contains('expandido');
        artistas.forEach(a => a.classList.remove('expandido'));
        if (!yaExpandido) art.classList.add('expandido');
    });
});

// Mostrar solo día 1 al cargar
artistas.forEach(art => {
    if (art.dataset.dia !== '1') art.classList.add('oculto');
})

// PASO 1

const paso_1 = document.getElementById("paso-1");
const paso_2 = document.getElementById("paso-2");
const paso_3 = document.getElementById("paso-3");
const btn_volver = document.getElementById("btn-volver");

const path = {
    0: "index.php",
    1: paso_1,
    2: paso_2,
    3: paso_3
};
function getActivo() {
    if (!paso_1) return null; // no estamos en tickets.php
    if (paso_1.classList.contains("activo")) return 1;
    if (paso_2.classList.contains("activo")) return 2;
    if (paso_3.classList.contains("activo")) return 3;
}

function volver() {
    if (!btn_volver) return; // si no existe en esta página, salir sin error

    btn_volver.addEventListener("click", function () {
        const actual = getActivo();
        let ticket = null

        if (actual === 1) {
            window.location.href = "index.php";
            return;
        }

        path[actual].classList.remove("activo");
        path[actual - 1].classList.add("activo");
        window.location.href = `tickets.php?ticket=${ticket}&paso=${actual - 1}`;
    });
}
function irAlSiguientePaso(ticket) {
    const siguiente = getActivo() + 1;
    window.location.href = `tickets.php?ticket=${ticket}&paso=${siguiente}`;
    console.log(siguiente);
}

function paso1() {
    const contenedor = document.querySelector(".mapa__zonas");
    const todasLasZonas = document.querySelectorAll("[data-zona]");
    const confirmar = document.querySelector(".confirmar");
    let zonaSeleccionada = null;

    contenedor.addEventListener("click", (e) => {
        const zonaClickeada = e.target.closest("[data-zona]");
        const continuar = document.querySelector(".confirmar")
        if (!zonaClickeada) return; // clic fuera de una zona (ej. el espaciador)

        const tipo = zonaClickeada.dataset.zona; // "golden", "vip" o "general"
        const mismasZonas = document.querySelectorAll(`[data-zona="${tipo}"]`);

        todasLasZonas.forEach(zona => zona.classList.remove("border"));
        zonaSeleccionada = tipo;
        mismasZonas.forEach(zona => zona.classList.toggle("border"));
        continuar.classList.add("show")
    });

    confirmar.addEventListener("click", function () {
        if (!zonaSeleccionada) return;
        irAlSiguientePaso(zonaSeleccionada);
    });

}

function paso2() {
    const cantidadValor = document.getElementById("cantidad-valor");
    const cantidadMenos = document.getElementById("cantidad-menos");
    const cantidadMas = document.getElementById("cantidad-mas");
    const totalValor = document.getElementById("total-valor");
    const contenedorCantidad = document.querySelector(".datos__cantidad");
    const confirmarCompra = document.getElementById("confirmar-compra"); // el botón correcto de ESTE paso


    if (!cantidadValor || !contenedorCantidad) return; // por si esta función corre en una página sin paso 2

    const ticket = document.getElementById("datos-zona") ?? "";

    const precio = Number(contenedorCantidad.dataset.precio);
    const stock = Number(contenedorCantidad.dataset.stock);
    const lugar_ticket = ticket.textContent;
    let cantidad = 1;

    function actualizarTotal() {
        cantidadValor.textContent = cantidad;
        document.getElementById("cantidad-hidden").value = cantidad;
        const total = cantidad * precio;
        totalValor.textContent = `S/ ${total.toFixed(2)}`;
    }

    cantidadMas.addEventListener("click", () => {
        if (cantidad < stock) {
            cantidad++;
            actualizarTotal();
        }
    });

    cantidadMenos.addEventListener("click", () => {
        if (cantidad > 1) {
            cantidad--;
            actualizarTotal();
        }
    });

    actualizarTotal(); // muestra el total correcto desde que carga la página



}

function paso3() {
    const contador = document.getElementById("contador-inicio");
    if (!contador) return; // por si esta función corre en una página sin paso 3

    let segundos = 10;

    const intervalo = setInterval(() => {
        segundos--;
        contador.textContent = segundos;

        if (segundos <= 0) {
            clearInterval(intervalo);
            window.location.href = "index.php";
        }
    }, 1000);


}

// Modal de artistas en el index (contenido-artistas)
function modalArtistasIndex() {
    const overlay = document.getElementById("overlayArtista");
    if (!overlay) return;

    const imgsArtistas = document.querySelectorAll(".contenido-artistas .artista_");
    const modalGenero = document.getElementById("modalArtistaGenero");
    const modalNombre = document.getElementById("modalArtistaNombre");
    const modalInfo = document.getElementById("modalArtistaInfo");
    const cerrarBtn = document.getElementById("cerrarModalArtista");

    imgsArtistas.forEach(img => {
        img.addEventListener("click", () => {
            modalGenero.textContent = img.dataset.genero;
            modalNombre.textContent = img.dataset.nombre;
            modalInfo.textContent = img.dataset.info;

            overlay.classList.add("activo");
            document.body.classList.add("modal-abierto");
        });
    });

    function cerrarModalArtista() {
        overlay.classList.remove("activo");
        document.body.classList.remove("modal-abierto");
    }

    cerrarBtn.addEventListener("click", cerrarModalArtista);

    overlay.addEventListener("click", (e) => {
        if (e.target === overlay) cerrarModalArtista();
    });

    document.addEventListener("keydown", (e) => {
        if (e.key === "Escape" && overlay.classList.contains("activo")) {
            cerrarModalArtista();
        }
    });
}

const botonHamburguesa = document.getElementById('navegacion-hamburguesa');
const enlacesNav = document.querySelector('.navegacion-enlaces');

botonHamburguesa.addEventListener('click', () => {
    botonHamburguesa.classList.toggle('activo');
    enlacesNav.classList.toggle('activo');
});