<?php
include "C:/wamp64/credenciales/credencialesgament.php";

function sessionStart(){
    if (session_status() === PHP_SESSION_NONE) {
        session_start();
    }
    

    if (!isset($_SESSION["rol"]))
       $_SESSION["rol"] = "invitado";

}

function db_connect() {
    global $servername, $username, $password, $dbname;
    try {
        $conn = new PDO("mysql:host=$servername;dbname=$dbname;charset=utf8", $username, $password);
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

function login($usuario, $password){
    if (!isset($_SESSION['origen'])) {
        $_SESSION['origen'] = '/index.php';  // o alguna página por defecto
    }

    if ($_SESSION['rol'] == "invitado") {
        $_SESSION['origen'] = $_SERVER["REQUEST_URI"];
    }

    if ($usuario == "" && $password == "") {
        $_SESSION['mensaje'] = "No has introducido ningún dato.";
        header("Location:" . $_SESSION['origen']);
        unset($_SESSION['origen']);
        die;
    }

    if ($usuario != "") {
        $conn = db_connect();
        $sql = "SELECT id_usuario, usuario, password, rol FROM usuarios WHERE usuario = :usuario";
        $stmt = $conn->prepare($sql);
        $stmt->execute([':usuario' => $usuario]);
        $results = $stmt->fetchAll(PDO::FETCH_ASSOC);

        if (!empty($results) && password_verify($password, $results[0]["password"])) {
            $_SESSION["rol"] = $results[0]["rol"];
            $_SESSION["usuario"] = $results[0]["usuario"];
            $_SESSION["id_usuario"] = $results[0]["id_usuario"];
            unset($_SESSION['origen']);
            db_close($conn);
            if ($_SESSION["rol"] == "administrador")
                header("Location:" . $_SESSION['origen']);
            else
                header("Location: index.php");
            die();
        } else {
            $_SESSION['mensaje'] = "Usuario o contraseña incorrectos.";
            header("Location:" . $_SESSION['origen']);
            unset($_SESSION['origen']);
            die();
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

function registro(){
    $conn = db_connect();
    $sql = "INSERT INTO usuarios (usuario, password, email, nombre, apellido1, apellido2, NIF, fnacimiento, telefono)
    VALUES ('" . $_POST['usuario'] . "', '" . password_hash($_POST['password'], PASSWORD_DEFAULT) .  "', '" . $_POST['email'] . "', '" . $_POST['nombre'] . "', '" . $_POST['apellido1'] . "', '" . $_POST['apellido2'] . "', '" . $_POST['NIF'] . "', '" . $_POST['fnacimiento'] . "', '" . $_POST['telefono'] . "')";
    $conn->exec($sql);
    db_close($conn);
    
    login(sanear($_POST['usuario']), sanear($_POST['password']));
    
    header ("Location: index.php");
    exit;
}

function subirImagen(){
    $id_usuario = $_SESSION['id_usuario'];
    $target_dir = "uploads/";

    $imageFileType = strtolower(pathinfo($_FILES["fileToUpload"]["name"], PATHINFO_EXTENSION));
    $newFileName = "fotoperfil" . $id_usuario . "." . $imageFileType;
    $target_file = $target_dir . $newFileName;

    $uploadOk = 1;

    // Check if image file is a actual image or fake image
    if (isset($_POST["submitImagen"])) {
        $check = getimagesize($_FILES["fileToUpload"]["tmp_name"]);
        if ($check !== false) {
            echo "File is an image - " . $check["mime"] . ".";
            $uploadOk = 1;
        } else {
            echo "File is not an image.";
            $uploadOk = 0;
        }
    }

    // Check if file already exists
    if (file_exists($target_file)) {
        unlink($target_file); // Elimina la imagen anterior
    }

    // Check file size
    if ($_FILES["fileToUpload"]["size"] > 2000000) {
        echo "Sorry, your file is too large.";
        $uploadOk = 0;
    }

    // Allow certain file formats
    if ($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg"
        && $imageFileType != "gif" && $imageFileType != "webp") {
        echo "Sorry, only JPG, JPEG, PNG, GIF & WEBP files are allowed.";
        $uploadOk = 0;
    }

    // If all checks passed, resize and save the image
    if ($uploadOk == 1) {

        list($width, $height) = getimagesize($_FILES["fileToUpload"]["tmp_name"]);
        $new_width = 300;
        $new_height = 300;

        $tmp_image = imagecreatetruecolor($new_width, $new_height);

        switch ($imageFileType) {
            case 'jpeg':
            case 'jpg':
                $src_image = imagecreatefromjpeg($_FILES["fileToUpload"]["tmp_name"]);
                break;
            case 'png':
                $src_image = imagecreatefrompng($_FILES["fileToUpload"]["tmp_name"]);
                break;
            case 'gif':
                $src_image = imagecreatefromgif($_FILES["fileToUpload"]["tmp_name"]);
                break;
            case 'webp':
                $src_image = imagecreatefromwebp($_FILES["fileToUpload"]["tmp_name"]);
                break;
            default:
                echo "Unsupported image format.";
                $uploadOk = 0;
                exit;
        }

        imagecopyresampled($tmp_image, $src_image, 0, 0, 0, 0, $new_width, $new_height, $width, $height);

        switch ($imageFileType) {
            case 'jpeg':
            case 'jpg':
                imagejpeg($tmp_image, $target_file, 85);
                break;
            case 'png':
                imagepng($tmp_image, $target_file);
                break;
            case 'gif':
                imagegif($tmp_image, $target_file);
                break;
            case 'webp':
                imagewebp($tmp_image, $target_file, 85);
                break;
        }

        imagedestroy($tmp_image);
        imagedestroy($src_image);

        // ✅ Guardar el nombre en la base de datos
        try {
            $conn = db_connect(); // ← Tu función que devuelve un objeto PDO
            $sql = "UPDATE usuarios SET logo = :logo WHERE id_usuario = :id";
            $stmt = $conn->prepare($sql);
            $stmt->execute([
                ':logo' => $target_file,
                ':id' => $id_usuario
            ]);
        } catch (PDOException $e) {
            echo "Error al guardar en la base de datos: " . $e->getMessage();
            exit;
        }

        header("Location: usuario.php");
        exit;

    } else {
        echo "Sorry, your file was not uploaded.";
}
}
?>