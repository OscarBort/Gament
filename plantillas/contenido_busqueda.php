<?php
require_once "funciones.php";

if (isset($_GET["busqueda"])) {
    try {
        $conn = db_connect();

        $sql = "SELECT juegos.id_juego AS ID, portada, juegos.nombre AS nombreJ, descripcion, precio, genero FROM juegos INNER JOIN compañias ON juegos.id_compañia=compañias.id_compañia WHERE juegos.nombre LIKE '%" . $_GET['busqueda'] . "%' OR compañias.nombre='" . $_GET['busqueda'] . "' OR juegos.genero='" . $_GET['busqueda'] . "' GROUP BY juegos.nombre;";
        $results = db_query($conn, $sql);
    } catch(Exception $e) {
        echo $e->getMessage();
    }

    if (!empty($results)) {
        // Contenedor padre que organiza todos los resultados en columna
        echo "<div class='resultadosBusquedaWrapper'>";
        
        foreach ($results as $result) {
            echo "<a id='enlaceBusqueda' href='pagina_juegos.php?id=" . htmlspecialchars($result['ID']) . "'>";
                echo "<div class='contenedorBusqueda'>";
                    echo "<div class='portadaBusqueda'>";
                        echo "<img src='" . htmlspecialchars($result['portada']) . "'>";
                        echo "<p>" . htmlspecialchars($result['nombreJ']) . "</p>";
                    echo "</div>";
                    echo "<div class='datosBusqueda'>";
                        echo "<div class='textoDescripcion'>" . htmlspecialchars($result['descripcion']) . "</div>";
                        echo "<div class='precioCarrito'>";
                            echo "<button id='botonBusqueda' class='fas fa-shopping-cart' style='cursor:pointer;' onclick='event.preventDefault(); event.stopPropagation(); agregarAlCarrito(" .
                                '"' . addslashes($result['nombreJ']) . '",' .
                                '"' . $result['precio'] . '",' .
                                '"' . $result['portada'] . '"' .
                                ")'aria-label='Añadir al carrito'></button>";
                            echo "<span>" . htmlspecialchars($result['precio']) . "€</span>";
                        echo "</div>";
                    echo "</div>";
                echo "</div></a>";
        }

        echo "</div>"; // Cierra resultadosBusquedaWrapper
    } else {
        echo '<div id="busquedaError">No ninguna coincidencia.</div>';
    }
}
?>
