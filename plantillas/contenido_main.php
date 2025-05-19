<div id="mainIzquierda">
  <p>Hola mundo</p>
</div>
<div id="mainCentro">
  <div class="wrapper">
      <div class="inner" style="--quantity: 10;">
        <div class="card" style="--index: 0;--color-card: 142, 249, 252;">
          <a href="pagina_juegos.php"><div class="img"><img class="img" src="img/godofwar.jpg" alt=""></div></a>
        </div>
        <div class="card" style="--index: 1;--color-card: 142, 252, 204;">
          <div class="img"><img class="img" src="img/ageofempires.png" alt=""></div>
        </div>
        <div class="card" style="--index: 2;--color-card: 142, 252, 157;">
          <div class="img"><img class="img" src="img/ambidextro.png" alt=""></div>
        </div>
        <div class="card" style="--index: 3;--color-card: 215, 252, 142;">
          <div class="img"><img class="img" src="img/amongus.png" alt=""></div>
        </div>
        <div class="card" style="--index: 4;--color-card: 252, 252, 142;">
          <div class="img"><img class="img" src="img/bendy.png" alt=""></div>
        </div>
        <div class="card" style="--index: 5;--color-card: 252, 208, 142;">
          <div class="img"><img class="img" src="img/doom.png" alt=""></div>
        </div>
        <div class="card" style="--index: 6;--color-card: 252, 142, 142;">
          <div class="img"><img class="img" src="img/inzoi.png" alt=""></div>
        </div>
        <div class="card" style="--index: 7;--color-card: 252, 142, 239;">
          <div class="img"><img class="img" src="img/oblivion.png" alt=""></div>
        </div>
        <div class="card" style="--index: 8;--color-card: 204, 142, 252;">
          <div class="img"><img class="img" src="img/palia.png" alt=""></div>
        </div>
        <div class="card" style="--index: 9;--color-card: 142, 202, 252;">
          <div class="img"><img class="img" src="img/stardewvalley.png" alt=""></div>
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
  <p>Hola mundo</p>
</div>

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
