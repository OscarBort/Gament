<?php
/**
 * VALIDACIÓN MEJORADA PARA INTEGRAR CON TU CÓDIGO EXISTENTE
 * Este archivo reemplaza tu función registro() actual
 */

/**
 * Función mejorada de registro con validaciones completas
 * Reemplaza tu función registro() actual
 */
function registro() {
    // Array para almacenar errores
    $errores = [];
    $datos_limpios = [];
    
    // **1. VALIDACIÓN DEL USUARIO**
    if (empty($_POST['usuario'])) {
        $errores['usuario'] = "El campo usuario es obligatorio.";
    } else {
        $usuario = trim($_POST['usuario']);
        if (strlen($usuario) < 3) {
            $errores['usuario'] = "El usuario debe tener al menos 3 caracteres.";
        } elseif (strlen($usuario) > 20) {
            $errores['usuario'] = "El usuario no puede exceder 20 caracteres.";
        } elseif (!preg_match('/^[a-zA-Z0-9_]+$/', $usuario)) {
            $errores['usuario'] = "El usuario solo puede contener letras, números y guiones bajos.";
        } else {
            // Verificar si el usuario ya existe
            if (verificar_usuario_existe($usuario)) {
                $errores['usuario'] = "Este usuario ya está registrado.";
            } else {
                $datos_limpios['usuario'] = $usuario;
            }
        }
    }

    // **2. VALIDACIÓN DE LA CONTRASEÑA**
    if (empty($_POST['password'])) {
        $errores['password'] = "La contraseña es obligatoria.";
    } else {
        $password = $_POST['password'];
        if (strlen($password) < 8) {
            $errores['password'] = "La contraseña debe tener al menos 8 caracteres.";
        } elseif (!preg_match('/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)/', $password)) {
            $errores['password'] = "La contraseña debe contener al menos una mayúscula, una minúscula y un número.";
        } else {
            $datos_limpios['password'] = $password;
        }
    }

    // **3. VALIDACIÓN DEL EMAIL**
    if (empty($_POST['email'])) {
        $errores['email'] = "El email es obligatorio.";
    } else {
        $email = trim($_POST['email']);
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $errores['email'] = "El formato del email no es válido.";
        } else {
            // Verificar si el email ya existe
            if (verificar_email_existe($email)) {
                $errores['email'] = "Este email ya está registrado.";
            } else {
                $datos_limpios['email'] = $email;
            }
        }
    }

    // **4. VALIDACIÓN DEL NOMBRE**
    if (empty($_POST['nombre'])) {
        $errores['nombre'] = "El nombre es obligatorio.";
    } else {
        $nombre = trim($_POST['nombre']);
        if (strlen($nombre) < 2) {
            $errores['nombre'] = "El nombre debe tener al menos 2 caracteres.";
        } elseif (!preg_match('/^[a-zA-ZáéíóúÁÉÍÓÚñÑ\s]+$/', $nombre)) {
            $errores['nombre'] = "El nombre solo puede contener letras y espacios.";
        } else {
            $datos_limpios['nombre'] = $nombre;
        }
    }

    // **5. VALIDACIÓN DEL PRIMER APELLIDO**
    if (empty($_POST['apellido1'])) {
        $errores['apellido1'] = "El primer apellido es obligatorio.";
    } else {
        $apellido1 = trim($_POST['apellido1']);
        if (strlen($apellido1) < 2) {
            $errores['apellido1'] = "El primer apellido debe tener al menos 2 caracteres.";
        } elseif (!preg_match('/^[a-zA-ZáéíóúÁÉÍÓÚñÑ\s]+$/', $apellido1)) {
            $errores['apellido1'] = "El primer apellido solo puede contener letras y espacios.";
        } else {
            $datos_limpios['apellido1'] = $apellido1;
        }
    }

    // **6. VALIDACIÓN DEL SEGUNDO APELLIDO (OPCIONAL)**
    $datos_limpios['apellido2'] = null; // Default para BD
    if (!empty($_POST['apellido2'])) {
        $apellido2 = trim($_POST['apellido2']);
        if (!preg_match('/^[a-zA-ZáéíóúÁÉÍÓÚñÑ\s]+$/', $apellido2)) {
            $errores['apellido2'] = "El segundo apellido solo puede contener letras y espacios.";
        } else {
            $datos_limpios['apellido2'] = $apellido2;
        }
    }

    // **7. VALIDACIÓN DEL NIF**
    if (empty($_POST['NIF'])) {
        $errores['NIF'] = "El NIF es obligatorio.";
    } else {
        $nif = strtoupper(trim($_POST['NIF']));
        if (!preg_match('/^[0-9]{8}[A-Z]$/', $nif)) {
            $errores['NIF'] = "El formato del NIF no es válido (8 números + 1 letra).";
        } else {
            // Validar letra del NIF
            $numero = substr($nif, 0, 8);
            $letra = substr($nif, 8, 1);
            $letras_validas = 'TRWAGMYFPDXBNJZSQVHLCKE';
            $letra_correcta = $letras_validas[$numero % 23];
            
            if ($letra !== $letra_correcta) {
                $errores['NIF'] = "La letra del NIF no es correcta.";
            } else {
                // Verificar si el NIF ya existe
                if (verificar_nif_existe($nif)) {
                    $errores['NIF'] = "Este NIF ya está registrado.";
                } else {
                    $datos_limpios['NIF'] = $nif;
                }
            }
        }
    }

    // **8. VALIDACIÓN DE LA FECHA DE NACIMIENTO**
    if (empty($_POST['fnacimiento'])) {
        $errores['fnacimiento'] = "La fecha de nacimiento es obligatoria.";
    } else {
        $fecha_nacimiento = $_POST['fnacimiento'];
        
        $fecha_obj = DateTime::createFromFormat('Y-m-d', $fecha_nacimiento);
        if (!$fecha_obj || $fecha_obj->format('Y-m-d') !== $fecha_nacimiento) {
            $errores['fnacimiento'] = "El formato de la fecha no es válido.";
        } else {
            $hoy = new DateTime();
            $edad = $hoy->diff($fecha_obj)->y;
            
            if ($edad < 18) {
                $errores['fnacimiento'] = "Debes ser mayor de 18 años para registrarte.";
            } elseif ($edad > 120) {
                $errores['fnacimiento'] = "La fecha de nacimiento no es válida.";
            } else {
                $datos_limpios['fnacimiento'] = $fecha_nacimiento;
            }
        }
    }

    // **9. VALIDACIÓN DEL TELÉFONO**
    if (empty($_POST['telefono'])) {
        $errores['telefono'] = "El teléfono es obligatorio.";
    } else {
        $telefono = trim($_POST['telefono']);
        if (!preg_match('/^[0-9]{9}$/', $telefono)) {
            $errores['telefono'] = "El teléfono debe tener exactamente 9 dígitos.";
        } else {
            $datos_limpios['telefono'] = $telefono;
        }
    }

    // **10. SI HAY ERRORES, GUARDARLOS EN SESIÓN Y REDIRIGIR**
    if (!empty($errores)) {
        $_SESSION['errores_registro'] = $errores;
        $_SESSION['datos_form'] = $_POST; // Mantener datos para rellenar formulario
        header("Location: registro.php");
        exit;
    }

    // **11. SI TODO ESTÁ BIEN, INSERTAR EN BASE DE DATOS**
    try {
        $conn = db_connect();
        
        // Usar prepared statements para seguridad
        $sql = "INSERT INTO usuarios (usuario, password, email, nombre, apellido1, apellido2, NIF, fnacimiento, telefono) 
                VALUES (:usuario, :password, :email, :nombre, :apellido1, :apellido2, :nif, :fnacimiento, :telefono)";
        
        $stmt = $conn->prepare($sql);
        
        // Hash de la contraseña
        $password_hash = password_hash($datos_limpios['password'], PASSWORD_DEFAULT);
        
        $result = $stmt->execute([
            ':usuario' => $datos_limpios['usuario'],
            ':password' => $password_hash,
            ':email' => $datos_limpios['email'],
            ':nombre' => $datos_limpios['nombre'],
            ':apellido1' => $datos_limpios['apellido1'],
            ':apellido2' => $datos_limpios['apellido2'],
            ':nif' => $datos_limpios['NIF'],
            ':fnacimiento' => $datos_limpios['fnacimiento'],
            ':telefono' => $datos_limpios['telefono']
        ]);
        
        db_close($conn);
        
        if ($result) {
            // Limpiar datos temporales de sesión
            unset($_SESSION['errores_registro']);
            unset($_SESSION['datos_form']);
            
            // Hacer login automático como tienes actualmente
            login(sanear($datos_limpios['usuario']), sanear($datos_limpios['password']));
            
            header("Location:" . $_SESSION['origen']);
            exit;
        } else {
            throw new Exception("Error al insertar en la base de datos");
        }
        
    } catch (Exception $e) {
        $_SESSION['errores_registro'] = ['general' => 'Error al procesar el registro. Inténtalo de nuevo.'];
        header("Location: registro.php");
        exit;
    }
}

/**
 * Funciones auxiliares para verificar duplicados
 */
function verificar_usuario_existe($usuario) {
    try {
        $conn = db_connect();
        $stmt = $conn->prepare("SELECT COUNT(*) FROM usuarios WHERE usuario = :usuario");
        $stmt->execute([':usuario' => $usuario]);
        $count = $stmt->fetchColumn();
        db_close($conn);
        return $count > 0;
    } catch (Exception $e) {
        return false; // En caso de error, permitir continuar
    }
}

function verificar_email_existe($email) {
    try {
        $conn = db_connect();
        $stmt = $conn->prepare("SELECT COUNT(*) FROM usuarios WHERE email = :email");
        $stmt->execute([':email' => $email]);
        $count = $stmt->fetchColumn();
        db_close($conn);
        return $count > 0;
    } catch (Exception $e) {
        return false;
    }
}

function verificar_nif_existe($nif) {
    try {
        $conn = db_connect();
        $stmt = $conn->prepare("SELECT COUNT(*) FROM usuarios WHERE NIF = :nif");
        $stmt->execute([':nif' => $nif]);
        $count = $stmt->fetchColumn();
        db_close($conn);
        return $count > 0;
    } catch (Exception $e) {
        return false;
    }
}

/**
 * Función para mostrar errores en el formulario
 */
function mostrar_error_registro($campo) {
    if (isset($_SESSION['errores_registro'][$campo])) {
        $error = $_SESSION['errores_registro'][$campo];
        return '<div class="error-message" style="color: #dc3545; font-size: 12px; margin-top: 2px;">' . 
               htmlspecialchars($error) . '</div>';
    }
    return '';
}

/**
 * Función para mantener valores en el formulario
 */
function valor_anterior_registro($campo) {
    if (isset($_SESSION['datos_form'][$campo]) && $campo !== 'password') {
        return htmlspecialchars($_SESSION['datos_form'][$campo]);
    }
    return '';
}

/**
 * Función para limpiar mensajes después de mostrarlos
 */
function limpiar_errores_registro() {
    unset($_SESSION['errores_registro']);
    unset($_SESSION['datos_form']);
}
?>