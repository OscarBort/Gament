<?php
require_once "funciones.php";

if (isset($_GET["busqueda"])){
    try {
    $conn = db_connect();

    // Ejemplo de consulta SELECT directa
    $sql = "SELECT portada, juegos.nombre AS nombreJ, descripcion, precio FROM juegos INNER JOIN compañias ON juegos.id_compañia=compañias.id_compañia WHERE juegos.nombre LIKE '%" . $_GET['busqueda'] . "%' OR compañias.nombre='" . $_GET['busqueda'] . "' GROUP BY juegos.nombre;";
    $results = db_query($conn, $sql);
} catch(Exception $e) {
    echo $e->getMessage();
}
if (!empty($results)) {
    foreach ($results as $result) {
        // Nota a la izquierda
        echo '<div class="avg">';
        echo htmlspecialchars($result['portada']) . htmlspecialchars($result['nombreJ']);
        echo '</div>';
        // Comentario a la derecha
        echo '<div class="opinions">';
        echo htmlspecialchars($result['descripcion']) . ' - ' . htmlspecialchars($result['precio']);
        echo '</div>';
    }
} else {
    echo '<div>No hay notas ni opiniones disponibles.</div>';
}
}
?>
