<form class="form" method="POST" action="index.php">
    <input type="hidden" name="registro" value="1">
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
    <button type="submit" class="submit">Submit</button>
</form>
