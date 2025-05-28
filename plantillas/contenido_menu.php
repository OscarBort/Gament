<nav id='menu'>
  <input type='checkbox' id='responsive-menu' onclick='updatemenu()'><label></label>
  <ul>
    <li><a href='index.php'>Home</a></li>
    <li><a class='dropdown-arrow'>Compañía</a>
      <ul class='sub-menus'>
        <li><a href='busqueda.php?busqueda=Sony'>Sony</a></li>
        <li><a href='busqueda.php?busqueda=Xbox'>XBOX</a></li>
        <li><a href='busqueda.php?busqueda=Nintendo'>Nintendo</a></li>
        <li><a href='busqueda.php?busqueda=PC'>PC</a></li>
        <li><a href='busqueda.php?busqueda=Steam'>Steam</a></li>
      </ul>
    </li>
    <li><a class='dropdown-arrow'>Género</a>
      <ul class='sub-menus'>
        <li><a href='busqueda.php?busqueda=RPG'>RPG</a></li>
        <li><a href='busqueda.php?busqueda=Acción'>Acción</a></li>
        <li><a href='busqueda.php?busqueda=Deportivo'>Deportivo</a></li>
        <li><a href='busqueda.php?busqueda=Infantil'>Infantil</a></li>
        <li><a href='busqueda.php?busqueda=Shooter'>Shooter</a></li>
      </ul>
    </li>
    <li><a href='http://'>Ofertas</a></li>
    <li><a href='http://'>Contact Us</a></li>
    <li id="carrito" onclick="toggleCarrito()">
      <a href="javascript:void(0);" onclick="toggleCarrito(event)">
        <i class="fa-solid fa-cart-shopping"></i>
        <span id="contadorCarrito">0</span>
      </a>
      <div id="carritoContenido">
        <div id="productosCarrito"></div>
      </div>
    </li>
  </ul>
</nav>
<main>