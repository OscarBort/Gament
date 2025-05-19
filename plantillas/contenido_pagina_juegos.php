<?php
require_once 'funciones.php';

if (isset($_GET['id'])) {
    $id = $_GET['id'];
}
try {
    $conn = db_connect();

    // Ejemplo de consulta SELECT directa
    $sql = "SELECT portada, juegos.nombre AS nombreJ, descripcion, precio, avg(nota) AS nota, comentario, usuario FROM juegos left JOIN valoraciones on juegos.id_juego=valoraciones.id_juego left JOIN usuarios on valoraciones.id_usuario=usuarios.id_usuario WHERE juegos.id_juego=$id;";
    $results = db_query($conn, $sql);

} catch(Exception $e) {
    echo $e->getMessage();
}
?>


<div id="mainIzquierda">
  <p>Hola mundo</p>
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
  </div>
<?php if (floor($results[0]['nota']) == 0){
  echo '<div class="avg"><i class="fa-regular fa-star"></i><i class="fa-regular fa-star"></i><i class="fa-regular fa-star"></i><i class="fa-regular fa-star"></i><i class="fa-regular fa-star"></i></div>';
}?>
  <div class="opinions"><?php echo $results[0]['usuario'] . " - " . $results[0]['comentario']?></div>
  <div class="note">Nota</div>
  <div class="text-opinion">Textarea Opinión</div>
    </div>
</div>
</div>
<div id="mainDerecha">
  <p>Hola mundo</p>
</div>
<?php
// Cerrar conexión
    db_close($conn);
?>