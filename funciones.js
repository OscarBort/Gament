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

