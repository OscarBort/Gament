<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "gament";

function db_connect() {
    global $servername, $username, $password, $dbname;
    try {
        $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        return $conn;
    } catch(PDOException $e) {
        throw new Exception("Error de conexión: " . $e->getMessage());
    }
}

function db_query($conn, $sql) {
    try {
        $stmt = $conn->query($sql);
        $stmt->setFetchMode(PDO::FETCH_ASSOC);
        return $stmt->fetchAll();
    } catch(PDOException $e) {
        throw new Exception("Error en la consulta: " . $e->getMessage());
    }
}

function db_close(&$conn) {
    $conn = null;
}
?>