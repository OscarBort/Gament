<?php
include_once "funciones.php";
sessionStart();
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST['registro'])) {
        registro();
    } elseif (isset($_POST['login'])) {
        if (isset($_POST['origen'])) {
            $_SESSION['origen'] = $_POST['origen'];
        }
        login(sanear($_POST["usuario"]), sanear($_POST["password"]));
    }
}


include "header.php";
include "menu.php";
include "main.php";
include "footer.php";
?>