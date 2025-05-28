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
window.onclick = function(event) {
  const menu = document.getElementById('menuDesplegable');
  const btn = document.getElementById('logo_usuario');
  if (event.target !== btn && !btn.contains(event.target)) {
    menu.classList.remove('show');
  }
}

// Añadir cosas al carrito
// Si quieres que el carrito se mantenga en memoria
let carrito = [];

window.agregarAlCarrito = function(nombre, precio, portada) {
    const index = carrito.findIndex(p => p.nombre === nombre);
    if (index !== -1) {
        carrito[index].cantidad++;
    } else {
        carrito.push({ nombre, precio: parseFloat(precio), portada, cantidad: 1 });
    }
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
    `;
}




window.modificarCantidad = function(index, cambio) {
    carrito[index].cantidad += cambio;
    if (carrito[index].cantidad <= 0) {
        carrito.splice(index, 1); // eliminar si llega a 0
    }
    actualizarCarritoVisual();
};
window.toggleCarrito = function(event) {
    event?.stopPropagation();

    const div = document.getElementById("carritoContenido");

    if (div.classList.contains("visible")) {
        div.classList.remove("visible");
    } else {
        div.classList.add("visible");
    }
};


// Para cerrar si se hace clic fuera del carrito
document.addEventListener("click", function (event) {
    const carrito = document.getElementById("carritoContenido");
    const icono = document.getElementById("carrito");
    if (!carrito.contains(event.target) && !icono.contains(event.target)) {
        carrito.classList.remove("visible");
    }
});
document.addEventListener("DOMContentLoaded", function () {
  const productosCarrito = document.getElementById("productosCarrito");
  if (productosCarrito) {
    productosCarrito.addEventListener("click", function (event) {
      event.stopPropagation();

      const btn = event.target;
      const contenedor = btn.closest(".producto-item");
      if (!contenedor) return;

      const index = parseInt(contenedor.getAttribute("data-index"));

      if (btn.classList.contains("sumar")) {
        modificarCantidad(index, 1);
      } else if (btn.classList.contains("restar")) {
        modificarCantidad(index, -1);
      }
    });
  }
});



