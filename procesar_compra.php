<?php
session_start();

header('Content-Type: application/json');
$fecha_actual = date('Y-m-d H:i:s');

// Mostrar errores para desarrollo
ini_set('display_errors', 1);
error_reporting(E_ALL);

require_once 'funciones.php'; // tu archivo donde están db_connect() y db_query()

try {
    // Verifica que el usuario esté logueado
    if (!isset($_SESSION['id_usuario'])) {
        throw new Exception("No has iniciado sesión.");
    }

    $usuario_id = $_SESSION['id_usuario'];

    // Obtener el JSON del cuerpo del POST
    $data = json_decode(file_get_contents("php://input"), true);
    if (!$data || !isset($data['carrito']) || !isset($data['total'])) {
        throw new Exception("Datos inválidos.");
    }

    $carrito = $data['carrito'];
    $total = $data['total'];

    if (empty($carrito)) {
        throw new Exception("El carrito está vacío.");
    }

    $conn = db_connect();
    $conn->beginTransaction();

    // Insertar venta
   $stmt = $conn->prepare("INSERT INTO ventas (id_usuario, total, fecha) VALUES (?, ?, ?)");
    $stmt->execute([$usuario_id, $total, $fecha_actual]);
    $id_venta = $conn->lastInsertId();

    // Insertar detalles
    $stmt_detalle = $conn->prepare("INSERT INTO juegos_ventas (id_venta, id_juego, unidades, precio) VALUES (?, ?, ?, ?)");

    foreach ($carrito as $item) {
        if (!isset($item['id_juego'], $item['unidades'], $item['precio'])) {
            throw new Exception("Datos del carrito incompletos.");
        }

        $stmt_detalle->execute([
            $id_venta,
            $item['id_juego'],
            $item['unidades'],
            $item['precio']
        ]);
    }

    $conn->commit();

    echo json_encode(['success' => true, 'id_venta' => $id_venta]);
} catch (Exception $e) {
    if (isset($conn) && $conn->inTransaction()) {
        $conn->rollBack();
    }
    echo json_encode(['success' => false, 'error' => $e->getMessage()]);
}
?>