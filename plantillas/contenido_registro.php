<form class="form" method="POST" action="index.php">
    <input type="hidden" name="registro" value="1">
    <p class="titleRegistro">Registro</p>
    
    <label>
        <input class="input" type="text" placeholder="" name="usuario" 
               value="<?php echo valor_anterior_registro('usuario'); ?>" required autocomplete="off">
        <span>Usuario</span>
        <?php echo mostrar_error_registro('usuario'); ?>
    </label>

    <label>
        <input class="input" type="password" placeholder="" name="password" required autocomplete="off">
        <span>Contraseña</span>
        <?php echo mostrar_error_registro('password'); ?>
    </label>  
            
    <label>
        <input class="input" type="email" placeholder="" name="email" 
               value="<?php echo valor_anterior_registro('email'); ?>" required autocomplete="off">
        <span>Email</span>
        <?php echo mostrar_error_registro('email'); ?>
    </label> 
        
    <label>
        <input class="input" type="text" placeholder="" name="nombre" 
               value="<?php echo valor_anterior_registro('nombre'); ?>" required autocomplete="off">
        <span>Nombre</span>
        <?php echo mostrar_error_registro('nombre'); ?>
    </label>
    
    <label>
        <input class="input" type="text" placeholder="" name="apellido1" 
               value="<?php echo valor_anterior_registro('apellido1'); ?>" required autocomplete="off">
        <span>Primer apellido</span>
        <?php echo mostrar_error_registro('apellido1'); ?>
    </label>
    
    <label>
        <input class="input" type="text" placeholder="" name="apellido2" 
               value="<?php echo valor_anterior_registro('apellido2'); ?>" autocomplete="off">
        <span>Segundo apellido</span>
        <?php echo mostrar_error_registro('apellido2'); ?>
    </label>
    
    <label>
        <input class="input" type="text" placeholder="" name="NIF" 
               value="<?php echo valor_anterior_registro('NIF'); ?>" required autocomplete="off">
        <span>NIF</span>
        <?php echo mostrar_error_registro('NIF'); ?>
    </label>
    
    <label>
        <input class="input" type="date" placeholder="" name="fnacimiento" 
               value="<?php echo valor_anterior_registro('fnacimiento'); ?>" required autocomplete="off">
        <span>Fecha nacimiento</span>
        <?php echo mostrar_error_registro('fnacimiento'); ?>
    </label>
    
    <label>
        <input class="input" type="tel" placeholder="" name="telefono" pattern="[0-9]{9}" 
               value="<?php echo valor_anterior_registro('telefono'); ?>" required autocomplete="off">
        <span>Teléfono</span>
        <?php echo mostrar_error_registro('telefono'); ?>
    </label>
    
    <button type="submit" class="submit">Submit</button>
</form>

<?php
// **LIMPIAR ERRORES DESPUÉS DE MOSTRARLOS** (colocar al final de la página)
if (isset($_SESSION['errores_registro'])) {
    limpiar_errores_registro();
}
?>

<style>
/* ESTILOS PARA LOS MENSAJES DE ERROR */
.error-message {
    color: #dc3545;
    font-size: 12px;
    margin-top: 2px;
    display: block;
    font-weight: 500;
}

.alert {
    padding: 12px;
    margin: 10px 0;
    border-radius: 4px;
}

.alert-success {
    color: #155724;
    background-color: #d4edda;
    border: 1px solid #c3e6cb;
}

.alert-danger {
    color: #721c24;
    background-color: #f8d7da;
    border: 1px solid #f5c6cb;
}

/* OPCIONAL: Resaltar campos con error */
.input.error {
    border-color: #dc3545;
    box-shadow: 0 0 0 0.2rem rgba(220, 53, 69, 0.25);
}
</style>
