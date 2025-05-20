<?php
require_once "funciones.php";

sessionStart();

if ($_SESSION['rol'] == 'invitado'){
include "header.php";
include "menu.php";
include "plantillas/contenido_registro.php";
include "footer.php";
}
else header("Location: index.php");
?>