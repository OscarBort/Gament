<script src="funciones.js"></script>
<?php require_once "funciones.php"?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" type="image/x-icon" href="img/favicon.svg">
    <link rel="stylesheet" href="css/cssheader.css">
    <link rel="stylesheet" href="css/cssmenu.css">
    <link rel="stylesheet" href="css/csswrapper.css">
    <link rel="stylesheet" href="css/cssmain.css">
    <link rel="stylesheet" href="css/cssfooter.css">
    <link rel="stylesheet" href="css/cssjuegos.css">
    <link rel="stylesheet" href="css/cssregistro.css">
    <link rel="stylesheet" href="css/cssbusqueda.css">
    <meta name="description" content="Una página copia de otras como Game o Gamestop">
    <meta name="author" content="Oscar Bort">
    <script src="https://kit.fontawesome.com/89d2629216.js" crossorigin="anonymous"></script>
    <title>Gamen't</title>
</head>
<body class="<?php echo isset($bodyClass) ? $bodyClass : ''; ?>">
    <header>
        <div id=headerIzquierda>
            <a href="index.php"><img src="img/logo.png" id="logo" alt="Logo parodia de otras compañías de venta de videojuegos en color naranja y de texto GAMEN'T"></a>
        </div>
        <div id=headerCentro>
            <div class="custom_input">
                <svg xmlns="http://www.w3.org/2000/svg" class="svg_icon bi-search" viewBox="0 0 16 16"><path d="M11.742 10.344a6.5 6.5 0 1 0-1.397 1.398h-.001c.03.04.062.078.098.115l3.85 3.85a1 1 0 0 0 1.415-1.414l-3.85-3.85a1.007 1.007 0 0 0-.115-.1zM12 6.5a5.5 5.5 0 1 1-11 0 5.5 5.5 0 0 1 11 0z"></path></svg>
                <form id="busqueda" method="GET" action="busqueda.php">
                <input class="input" type="text" name="busqueda" placeholder="Busca tu juego">
                </form>
            </div>
        </div>
        
            <div id="headerDerecha">
                <img id="logo_usuario" src="uploads/logodefault.png" alt="Menú Usuario" onclick="toggleMenu()">
                
                <div id="menuDesplegable">
                    <a href="editar_perfil.php">Editar datos de perfil</a>
                    <a href="plantillas/logout.php">Salir</a>
                </div>
            </div>
        
    </header>



