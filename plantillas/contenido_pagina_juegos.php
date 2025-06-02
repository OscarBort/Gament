<?php
require_once 'funciones.php';

if (isset($_GET['id'])) {
    $id = $_GET['id'];
}
try {
    $conn = db_connect();
} catch(Exception $e) {
    echo $e->getMessage();
}

  // Añado la inserción de valoración antes del select
  if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (!isset($_SESSION['id_usuario'])) {
        echo "Debes iniciar sesión para enviar una valoración.";
        exit;
    }
      try {
        $sql = "INSERT INTO valoraciones (id_juego, id_usuario, comentario, nota)
                VALUES ('" . $_POST['juegoID'] . "', '" . $_POST['usuarioID'] . "', '" . $_POST['comentario'] . "', '" . $_POST['nota'] . "')";
        $conn->exec($sql);
      } catch(Exception $e) {
      echo $e->getMessage();
      }
    }

    // Ejemplo de consulta SELECT directa
    $sql = "SELECT juegos.id_juego AS ID, portada, stock, juegos.nombre AS nombreJ, descripcion, precio, nota, comentario, usuario, oferta, descuento, usuarios.id_usuario AS usuarioID FROM juegos left JOIN valoraciones on juegos.id_juego=valoraciones.id_juego left JOIN usuarios on valoraciones.id_usuario=usuarios.id_usuario WHERE juegos.id_juego=$id;";
    $results = db_query($conn, $sql);
    if (!empty($results) && isset($results[0])) {
      $result = $results[0];
    } else {
        echo "❌ Error: No se encontró el juego con ID $id.";
        // Aquí puedes hacer un return o un exit, o manejarlo de otra forma
        return;
    }

    $sql = "SELECT avg(nota) AS notaMedia FROM valoraciones WHERE id_juego=$id;";
    $notaM = db_query($conn, $sql);

$precioFinal = $results[0]['oferta'] == 1 ? $results[0]['precio'] * (1 - $results[0]['descuento'] / 100) : $results[0]['precio'];
?>


<div id="mainIzquierda">
  <img id="bannerIzquierda" src="img/banner.jpeg" alt="">
</div>
<div id="mainCentro">
    <div class="main">
  <div class="left-column">
    <div class="cover"><img id="imagenPortada" src="<?php echo $results[0]['portada']?>"></div>
  </div>
  
  <div class="right-column">
    <div class="title"><?php echo $results[0]['nombreJ']?></div>
    <div class="description"><?php echo $results[0]['descripcion']?></div>
    <div class="price-cart">
      <div class="price"><?php echo $precioFinal?></div>
      <div class="stock">
      <?php if ($results[0]['stock'] != NULL) {
        echo '<input type="number" id="stock" name="stock" min="1" max="' . $result['stock'] . '" step="1">';
        //echo "<div class='cart'><button id='botonBusqueda' class='fas fa-shopping-cart' style='cursor:pointer;' onclick='event.preventDefault(); event.stopPropagation(); agregarAlCarrito('" . addslashes($results[0]['nombreJ']) . "','" . number_format($precioFinal, 2, '.', '') . "','" . $results[0]['portada'] . "')' aria-label='Añadir al carrito'></button></div>";
      }
      else echo 'Sin stock';
      ?>
    </div>
      <div class="cart"><?php echo "<button id='botonBusqueda' class='fas fa-shopping-cart' style='cursor:pointer;' onclick='event.preventDefault(); event.stopPropagation(); agregarAlCarrito(" . $result['ID'] . ", \"" . addslashes($result['nombreJ']) . "\", \"" . number_format($precioFinal, 2, '.', '') . "\", \"" . $result['portada'] . "\", parseInt(document.getElementById(\"stock\").value) || 1)' aria-label='Añadir al carrito'></button>"; ?>
    </div>
    </div>
    <?php switch(floor($notaM[0]['notaMedia'])){
  case 0: echo '<div class="avg"><i class="fa-regular fa-star"></i><i class="fa-regular fa-star"></i><i class="fa-regular fa-star"></i><i class="fa-regular fa-star"></i><i class="fa-regular fa-star"></i></div>';
  break;
  case 1: echo '<div class="avg"><i class="fa-solid fa-star-half-stroke"></i><i class="fa-regular fa-star"></i><i class="fa-regular fa-star"></i><i class="fa-regular fa-star"></i><i class="fa-regular fa-star"></i></div>';
  break;
  case 2: echo '<div class="avg"><i class="fa-solid fa-star"></i><i class="fa-regular fa-star"></i><i class="fa-regular fa-star"></i><i class="fa-regular fa-star"></i><i class="fa-regular fa-star"></i></div>';
  break;
  case 3: echo '<div class="avg"><i class="fa-solid fa-star"></i><i class="fa-solid fa-star-half-stroke"></i><i class="fa-regular fa-star"></i><i class="fa-regular fa-star"></i><i class="fa-regular fa-star"></i></div>';
  break;
  case 4: echo '<div class="avg"><i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i><i class="fa-regular fa-star"></i><i class="fa-regular fa-star"></i><i class="fa-regular fa-star"></i></div>';
  break;
  case 5: echo '<div class="avg"><i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i><i class="fa-solid fa-star-half-stroke"></i><i class="fa-regular fa-star"></i><i class="fa-regular fa-star"></i></div>';
  break;
  case 6: echo '<div class="avg"><i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i><i class="fa-regular fa-star"></i><i class="fa-regular fa-star"></i></div>';
  break;
  case 7: echo '<div class="avg"><i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i><i class="fa-solid fa-star-half-stroke"></i><i class="fa-regular fa-star"></i></div>';
  break;
  case 8: echo '<div class="avg"><i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i><i class="fa-regular fa-star"></i></div>';
  break;
  case 9: echo '<div class="avg"><i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i><i class="fa-solid fa-star-half-stroke"></i></div>';
  break;
  case 10: echo '<div class="avg"><i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i></div>';
  break; 
}?>
<!-- A partir de aquí empieza el listado de notas y comentarios de los usuarios -->
  </div>
    <?php
if (!empty($results)) {
    foreach ($results as $valoracion) {
        echo '<div class="avg">';
        echo htmlspecialchars($valoracion['nota']);
        echo '</div>';
        echo '<div class="opinions">';
        echo htmlspecialchars($valoracion['usuario']) . ' - ' . htmlspecialchars($valoracion['comentario']);
        echo '</div>';
    }
} else {
    echo '<div>No hay notas ni opiniones disponibles.</div>';
}
?>
<?php if (isset($_SESSION['id_usuario'])): ?>
  <div class="note">
    <p>Introduce tu nota del 1 al 10: </p>
    <form method="post" action="<?php echo htmlentities($_SERVER['PHP_SELF']) . '?id=' . urlencode($_GET['id']); ?>">
      <input type="hidden" name="usuarioID" value="<?php echo $result['usuarioID']?>">
      <input type="hidden" name="juegoID" value="<?php echo $result['juegoID']?>">
      <input type="number" id="notaVal" name="nota" min="0" max="10" step="1" required></div>
      <textarea name="comentario" rows="10" cols="50" placeholder="Introduce aquí tu valoración." required></textarea>
      <button type="submit">Enviar</button>
    </form>
<?php else: ?>
  <p style="color:white;">Debes iniciar sesión para dejar una valoración.</p>
<?php endif; ?>
  </div>
</div>
</div>
<div id="mainDerecha">
  <img id="bannerIzquierda" src="img/banner.jpeg" alt="">
</div>
<?php
// Cerrar conexión
    db_close($conn);
?>