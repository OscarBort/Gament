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

function sessionStart(){
    session_start();
    

    if (!isset($_SESSION["rol"]))
       $_SESSION["rol"] = "invitado";

}

function login($usuario, $password){
    // Para iniciar sesión redirigimos origen para que vuelva a la misma página una vez logueado
    if ($_SESSION['rol'] == "invitado") $_SESSION['origen'] = $_SERVER["PHP_SELF"];
    // Si no introduce ningún dato le damos error y redirigimos para que se de cuenta del error
    if ($usuario == "" && $password == "") {
        $_SESSION['mensaje'] = "No has introducido ningún dato.";
        header("Location:" . $_SESSION['origen']);
        unset($_SESSION['origen']);
        die;
    }
    if (isset($_POST["usuario"]) && isset($_POST["password"])){
        if ($usuario != ""){
            $conn = db_connect();
        db_connect();
        $sql = "SELECT usuario, password, rol FROM usuarios WHERE usuario = '" . $_POST['usuario'] . "'";
        $results = db_query($conn, $sql);
        if (password_verify($password, $results[0]["password"])){
            $_SESSION["rol"] = $results[0]["rol"];
            $_SESSION["usuario"] = $results[0]["usuario"];
            if ($_SESSION["rol"] == "administrador")
                header("Location:" . $_SESSION['origen']);
            else header("Location: index.php");
            unset($_SESSION['origen']);
            die();
        }
        }
    }
}

function logout(){
    session_start();
    session_unset();
    session_destroy();
    header ('Location: ../index.php');
    die();
}

function sanear($data) {
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}
?>