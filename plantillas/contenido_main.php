<?php
require_once 'funciones.php';

try {
    $conn = db_connect();

    // Ejemplo de consulta SELECT directa
    $sql = "SELECT portada, id_juego FROM juegos ORDER BY fcreacion LIMIT 10;";
    $results = db_query($conn, $sql);

} catch(Exception $e) {
    echo $e->getMessage();
}
?>
<div id="mainIzquierda">
  <img id="bannerIzquierda" src="img/banner.jpeg" alt="">
</div>
<div id="mainCentro">
  <div class="wrapper">
      <div class="inner" style="--quantity: 10;">
        <div class="card" style="--index: 0;--color-card: 142, 249, 252;">
          <a href="pagina_juegos.php?id=<?php echo $results[0]['id_juego']?>"><div class="img"><img class="img" src="<?php echo $results[0]["portada"]?>"></div></a>
        </div>
        <div class="card" style="--index: 1;--color-card: 142, 252, 204;">
          <a href="pagina_juegos.php?id=<?php echo $results[1]['id_juego']?>"><div class="img"><img class="img" src="<?php echo $results[1]["portada"]?>"></div></a>
        </div>
        <div class="card" style="--index: 2;--color-card: 142, 252, 157;">
          <a href="pagina_juegos.php?id=<?php echo $results[2]['id_juego']?>"><div class="img"><img class="img" src="<?php echo $results[2]["portada"]?>"></div></a>
        </div>
        <div class="card" style="--index: 3;--color-card: 215, 252, 142;">
          <a href="pagina_juegos.php?id=<?php echo $results[3]['id_juego']?>"><div class="img"><img class="img" src="<?php echo $results[3]["portada"]?>"></div></a>
        </div>
        <div class="card" style="--index: 4;--color-card: 252, 252, 142;">
          <a href="pagina_juegos.php?id=<?php echo $results[4]['id_juego']?>"><div class="img"><img class="img" src="<?php echo $results[4]["portada"]?>"></div></a>
        </div>
        <div class="card" style="--index: 5;--color-card: 252, 208, 142;">
          <a href="pagina_juegos.php?id=<?php echo $results[5]['id_juego']?>"><div class="img"><img class="img" src="<?php echo $results[5]["portada"]?>"></div></a>
        </div>
        <div class="card" style="--index: 6;--color-card: 252, 142, 142;">
          <a href="pagina_juegos.php?id=<?php echo $results[6]['id_juego']?>"><div class="img"><img class="img" src="<?php echo $results[6]["portada"]?>"></div></a>
        </div>
        <div class="card" style="--index: 7;--color-card: 252, 142, 239;">
          <a href="pagina_juegos.php?id=<?php echo $results[7]['id_juego']?>"><div class="img"><img class="img" src="<?php echo $results[7]["portada"]?>"></div></a>
        </div>
        <div class="card" style="--index: 8;--color-card: 204, 142, 252;">
          <a href="pagina_juegos.php?id=<?php echo $results[8]['id_juego']?>"><div class="img"><img class="img" src="<?php echo $results[8]["portada"]?>"></div></a>
        </div>
        <div class="card" style="--index: 9;--color-card: 142, 202, 252;">
          <a href="pagina_juegos.php?id=<?php echo $results[9]['id_juego']?>"><div class="img"><img class="img" src="<?php echo $results[9]["portada"]?>"></div></a>
        </div>
      </div>
    </div>
    <div class="banner-container">
      <img class="banner-slide" src="img/banner1.png" alt="Juego 1">
      <img class="banner-slide" src="img/banner2.png" alt="Juego 2">
      <img class="banner-slide" src="img/banner3.png" alt="Juego 3">
      <img class="banner-slide" src="img/banner4.png" alt="Juego 4">
    </div>
</div>
<div id="mainDerecha">
  <img id="bannerIzquierda" src="img/banner.jpeg" alt="">
</div>
<?php
// Cerrar conexión
    db_close($conn);
?>
<script>
  let index = 0;
  const slides = document.querySelectorAll('.banner-slide');

  function showNextSlide() {
    slides.forEach(slide => slide.classList.remove('active'));
    slides[index].classList.add('active');
    index = (index + 1) % slides.length;
  }

  // Mostrar el primero al cargar
  showNextSlide();
  // Cambiar cada 3 segundos
  setInterval(showNextSlide, 3000);
</script>
