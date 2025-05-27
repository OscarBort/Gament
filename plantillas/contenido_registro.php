<?php require_once "funciones.php";
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    registro();
    exit;
} ?>
    <form class="form" method="POST" action="<?php echo $_SERVER['PHP_SELF']; ?>">
    <p class="titleRegistro">Registro </p>
    <label>
        <input class="input" type="text" placeholder="" name="usuario" required autocomplete="off">
        <span>Usuario</span>
    </label>

    <label>
        <input class="input" type="password" placeholder="" name="password" required autocomplete="off">
        <span>Contraseña</span>
    </label>  
            
    <label>
        <input class="input" type="email" placeholder="" name="email" required autocomplete="off">
        <span>Email</span>
    </label> 
        
    <label>
        <input class="input" type="text" placeholder="" name="nombre" required autocomplete="off">
        <span>Nombre</span>
    </label>
    <label>
        <input class="input" type="text" placeholder="" name="apellido1" required autocomplete="off">
        <span>Primer apellido</span>
    </label>
    <label>
        <input class="input" type="text" placeholder="" name="apellido2" autocomplete="off">
        <span>Segundo apellido</span>
    </label>
    <label>
        <input class="input" type="text" placeholder="" name="NIF" required autocomplete="off">
        <span>NIF</span>
    </label>
    <label>
        <input class="input" type="date" placeholder="" name="fnacimiento" required autocomplete="off">
        <span>Fecha nacimiento</span>
    </label>
    <label>
        <input class="input" type="tel" placeholder="" name="telefono" pattern="[0-9]{9}" required autocomplete="off">
        <span>Telefono</span>
    </label>
    <button class="submit">Submit</button>
</form>
<?php
$usuario = isset($_POST['usuario']) ? $_POST['usuario'] : '';
$passwordR = isset($_POST['password']) ? password_hash($_POST['password'], PASSWORD_DEFAULT) : '';
$email = isset($_POST['email']) ? $_POST['email'] : '';
$nombre = isset($_POST['nombre']) ? $_POST['nombre'] : '';
$apellido1 = isset($_POST['apellido1']) ? $_POST['apellido1'] : '';
$apellido2 = isset($_POST['apellido2']) ? $_POST['apellido2'] : '';
$NIF = isset($_POST['NIF']) ? $_POST['NIF'] : '';
$fnacimiento = isset($_POST['fnacimiento']) ? $_POST['fnacimiento'] : '';
$telefono = isset($_POST['telefono']) ? $_POST['telefono'] : '';
try {
            $conn = db_connect(); // ← Tu función que devuelve un objeto PDO
            $sql = "INSERT INTO usuarios (usuario, password, email, nombre, apellido1, apellido2, NIF, fnacimiento, telefono)
                    VALUES ($usuario, $passwordR, $email, $nombre, $apellido1, $apellido2, $NIF, $fnacimiento, $telefono)";
            $conn->exec($sql);
        } catch (PDOException $e) {
            echo "Error al guardar en la base de datos: " . $e->getMessage();
            exit;
        }
?>