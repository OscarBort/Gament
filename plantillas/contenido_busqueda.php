<?php
require_once "funciones.php";

if (isset($_GET["busqueda"])) {
    try {
        $conn = db_connect();

        $sql = "SELECT juegos.id_juego AS ID, stock, portada, juegos.nombre AS nombreJ, descripcion, precio, genero, descuento, oferta FROM juegos INNER JOIN compañias ON juegos.id_compañia=compañias.id_compañia WHERE juegos.nombre LIKE '%" . $_GET['busqueda'] . "%' OR compañias.nombre='" . $_GET['busqueda'] . "' OR juegos.genero='" . $_GET['busqueda'] . "' GROUP BY juegos.nombre;";
        $results = db_query($conn, $sql);
    } catch(Exception $e) {
        echo $e->getMessage();
    }

    if (!empty($results)) {
        // Contenedor padre que organiza todos los resultados en columna
        echo "<div class='resultadosBusquedaWrapper'>";
        
        foreach ($results as $result) {
            // Calcular el precio final
            $precioFinal = $result['oferta'] == 1 ? $result['precio'] * (1 - $result['descuento'] / 100) : $result['precio'];
            
            echo "<a id='enlaceBusqueda' href='pagina_juegos.php?id=" . htmlspecialchars($result['ID']) . "'>";
                echo "<div class='contenedorBusqueda'>";
                    echo "<div class='portadaBusqueda'>";
                        echo "<img src='" . htmlspecialchars($result['portada']) . "'>";
                        echo "<p>" . htmlspecialchars($result['nombreJ']) . "</p>";
                    echo "</div>";
                    echo "<div class='datosBusqueda'>";
                        echo "<div class='textoDescripcion'>" . htmlspecialchars($result['descripcion']) . "</div>";
                        echo "<div class='precioCarrito'>";
                            if ($result['stock'] != 0) {echo "<button id='botonBusqueda' class='fas fa-shopping-cart' style='cursor:pointer;' onclick='event.preventDefault(); event.stopPropagation(); agregarAlCarrito(" .
                                $result['ID'] . ", " .
                                '"' . addslashes($result['nombreJ']) . '",' .
                                '"' . number_format($precioFinal, 2, '.', '') . '",' .
                                '"' . $result['portada'] . '"' .
                                ")' aria-label='Añadir al carrito'></button>";}
                            else echo "No hay stock";
                            echo "<span>";
                            if ($result['oferta'] == 1) {
                                echo "<span style='text-decoration:line-through; color:#888;'>" . htmlspecialchars($result['precio']) . "€</span> ";
                                echo "<span style='color:#e44;'>" . htmlspecialchars(number_format($precioFinal, 2)) . "€</span>";
                            } else {
                                echo htmlspecialchars($result['precio']) . "€";
                            }
                            echo "</span>";
                        echo "</div>";
                    echo "</div>";
                echo "</div></a>";
        }

        echo "</div>"; // Cierra resultadosBusquedaWrapper
    } else {
        echo '<div id="busquedaError">No ninguna coincidencia.</div>';
    }
}


if (isset($_GET["oferta"])) {
    try {
        $conn = db_connect();

        $sql = "SELECT juegos.id_juego AS ID, stock portada, juegos.nombre AS nombreJ, descripcion, precio, genero, descuento, oferta FROM juegos INNER JOIN compañias ON juegos.id_compañia=compañias.id_compañia WHERE oferta=1;";
        $results = db_query($conn, $sql);
    } catch(Exception $e) {
        echo $e->getMessage();
    }

    if (!empty($results)) {
        // Contenedor padre que organiza todos los resultados en columna
        echo "<div class='resultadosBusquedaWrapper'>";
        
        foreach ($results as $result) {
            // Calcular el precio final
            $precioFinal = $result['oferta'] == 1 ? $result['precio'] * (1 - $result['descuento'] / 100) : $result['precio'];
            
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
                                '"' . number_format($precioFinal, 2, '.', '') . '",' .
                                '"' . $result['portada'] . '"' .
                                ")' aria-label='Añadir al carrito'></button>";
                            echo "<span>";
                            if ($result['oferta'] == 1) {
                                echo "<span style='text-decoration:line-through; color:#888;'>" . htmlspecialchars($result['precio']) . "€</span> ";
                                echo "<span style='color:#e44;'>" . htmlspecialchars(number_format($precioFinal, 2)) . "€</span>";
                            } else {
                                echo htmlspecialchars($result['precio']) . "€";
                            }
                            echo "</span>";
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
