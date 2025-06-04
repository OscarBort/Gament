<?php
include_once "funciones.php";

try {
        $conn = db_connect();

        $sql = "SELECT ventas.id_venta AS ventaID, total, fecha
                FROM ventas
                WHERE ventas.id_usuario = " . $_SESSION["id_usuario"];
                //" GROUP BY ventas.id_usuario";
        $facturas = db_query($conn, $sql);
    } catch(Exception $e) {
        echo $e->getMessage();
    }

    // Aquí pasamos los datos necesarios a variables simples excepto los que hay que añadir en un foreach
    

    // Empezamos a pintar la tabla
    echo "<div id='contenedorFacturas'>";
    $tabla = "<table id='tablaFacturas'>";
        $tabla .= "<tr><th>Nº factura</th><th>Fecha</th><th>Total pagado</th></tr>";
        foreach ($facturas as $result){
            $tabla .= "<tr>
                <td>" . htmlspecialchars($result["ventaID"]) . "</td>
                <td>" . htmlspecialchars($result["fecha"]) . "</td>
                <td>" . htmlspecialchars($result["total"]) . "</td>
                <td><a href='plantillas/generar_factura.php?id=" . urlencode($result["ventaID"]) . "' target='_blank'>Descargar</a></td>
            </tr>";
        }
        $tabla .= "</table>";
        echo "<p id='mensajeFacturas'>Tabla generada con " . count($facturas) . " fila(s)</p>";
        echo $tabla;
        echo "</div>";
?>