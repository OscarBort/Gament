function updatemenu() {
  if (document.getElementById('responsive-menu').checked == true) {
    document.getElementById('menu').style.borderBottomRightRadius = '0';
    document.getElementById('menu').style.borderBottomLeftRadius = '0';
  }else{
    document.getElementById('menu').style.borderRadius = '10px';
  }
}

function toggleMenu() {
  const menu = document.getElementById('menuDesplegable');
  menu.classList.toggle('show');
}

// Cerrar al hacer clic fuera
// carrito inicializado
let carrito = JSON.parse(localStorage.getItem('carrito')) || [];

window.agregarAlCarrito = function(id_juego, nombre, precio, portada, cantidad = 1) {
    cantidad = parseInt(cantidad) || 1;
    const index = carrito.findIndex(p => p.id_juego === id_juego);

    if (index !== -1) {
        carrito[index].cantidad += cantidad;
    } else {
        carrito.push({ id_juego, nombre, precio: parseFloat(precio), portada, cantidad });
    }
    localStorage.setItem('carrito', JSON.stringify(carrito));
    actualizarCarritoVisual();
};

function actualizarCarritoVisual() {
    const contador = document.getElementById("contadorCarrito");
    const contenido = document.getElementById("productosCarrito");

    const totalUnidades = carrito.reduce((acc, p) => acc + p.cantidad, 0);
    contador.textContent = totalUnidades;
    contador.style.display = totalUnidades > 0 ? "flex" : "none";

    contenido.innerHTML = "";

    carrito.forEach((p, index) => {
        contenido.innerHTML += `
            <div class="producto-item" data-index="${index}" style="display:flex; align-items:center; justify-content:space-between; gap:10px; margin-bottom:10px;">
                <img src="${p.portada}" style="width:50px; height:auto;">
                <div style="flex:1">
                    <strong>${p.nombre}</strong><br>
                    ${p.precio.toFixed(2)} €
                </div>
                <div style="display:flex; flex-direction:column; align-items:center;">
                    <button class="sumar">+</button>
                    <span>${p.cantidad}</span>
                    <button class="restar">−</button>
                </div>
            </div>
        `;
    });

    const total = carrito.reduce((acc, p) => acc + p.precio * p.cantidad, 0);
    contenido.innerHTML += `
        <div style="border-top:1px solid #ccc; padding-top:10px; text-align:right;">
            <strong>Total: ${total.toFixed(2)} €</strong>
        </div>
        <div style="text-align:center; margin-top:10px;">
            <button id="btnRealizarCompra">Realizar compra</button>
        </div>
    `;

    const btn = document.getElementById('btnRealizarCompra');
    if (btn) {
        btn.onclick = function () {
            fetch('procesar_compra.php', {
                method: 'POST',
                headers: { 'Content-Type': 'application/json' },
                body: JSON.stringify({ carrito, total })
            })
            .then(res => res.json())
            .then(data => {
                if (data.success) {
                    alert('Compra realizada con éxito. ID Venta: ' + data.id_venta);
                    carrito = [];
                    localStorage.removeItem('carrito');
                    actualizarCarritoVisual();
                } else {
                    alert('Error al procesar la compra: ' + data.error);
                }
            })
            .catch(() => alert('Error de conexión al procesar la compra'));
        }
    }
}

// Modificar cantidad (sumar/restar)
window.modificarCantidad = function(index, cambio) {
    carrito[index].cantidad += cambio;
    if (carrito[index].cantidad <= 0) carrito.splice(index, 1);
    localStorage.setItem('carrito', JSON.stringify(carrito));
    actualizarCarritoVisual();
};

// Toggle carrito visible
window.toggleCarrito = function(event) {
    event?.stopPropagation();
    const div = document.getElementById("carritoContenido");
    div.classList.toggle("visible");
};

// Cerrar carrito si clic fuera
document.addEventListener("click", function (event) {
    const carritoDiv = document.getElementById("carritoContenido");
    const icono = document.getElementById("carrito");
    if (!carritoDiv.contains(event.target) && !icono.contains(event.target)) {
        carritoDiv.classList.remove("visible");
    }
});

// Listeners para sumar/restar dentro del carrito
document.addEventListener("DOMContentLoaded", function () {
    actualizarCarritoVisual();

    const productosCarrito = document.getElementById("productosCarrito");
    if (productosCarrito) {
        productosCarrito.addEventListener("click", function (event) {
            event.stopPropagation();
            const btn = event.target;
            const contenedor = btn.closest(".producto-item");
            if (!contenedor) return;

            const index = parseInt(contenedor.getAttribute("data-index"));
            if (btn.classList.contains("sumar")) modificarCantidad(index, 1);
            else if (btn.classList.contains("restar")) modificarCantidad(index, -1);
        });
    }
});
