<?php
require_once 'funciones.php';

if (isset($_GET['id'])) {
    $id = $_GET['id'];
}
try {
    $conn = db_connect();

    // Ejemplo de consulta SELECT directa
    $sql = "SELECT portada, juegos.nombre AS nombreJ, descripcion, precio, nota, comentario, usuario FROM juegos left JOIN valoraciones on juegos.id_juego=valoraciones.id_juego left JOIN usuarios on valoraciones.id_usuario=usuarios.id_usuario WHERE juegos.id_juego=$id;";
    $results = db_query($conn, $sql);

    $sql = "SELECT avg(nota) AS notaMedia FROM valoraciones WHERE id_juego=$id;";
    $notaM = db_query($conn, $sql);
} catch(Exception $e) {
    echo $e->getMessage();
}
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
      <div class="price"><?php echo $results[0]['precio']?></div>
      <div class="cart">Carrito</div>
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
    var_dump($results);
if (!empty($results)) {
    foreach ($results as $result) {
        // Nota a la izquierda
        echo '<div class="avg">';
        echo htmlspecialchars($result['nota']);
        echo '</div>';
        // Comentario a la derecha
        echo '<div class="opinions">';
        echo htmlspecialchars($result['usuario']) . ' - ' . htmlspecialchars($result['comentario']);
        echo '</div>';
    }
} else {
    echo '<div>No hay notas ni opiniones disponibles.</div>';
}

    ?>
  <div class="note">Nota</div>
  <div class="text-opinion">Textarea Opinión</div>
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