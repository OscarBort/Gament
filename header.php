<?php
require_once "funciones.php";

sessionStart();

if ($_SESSION["rol"] != "invitado") include "plantillas/header_usuario.php";
else include "plantillas/header_invitado.php";
?>