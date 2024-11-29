<?php
$nombre = $correo = $contrasena = "";
$errores = [];
$registroExitoso = false;

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $nombre = htmlspecialchars(trim($_POST['nombre'] ?? ""));
    $correo = htmlspecialchars(trim($_POST['correo'] ?? ""));
    $contrasena = htmlspecialchars(trim($_POST['contrasena'] ?? ""));

    if (empty($nombre)) {
        $errores[] = "El campo de nombre es obligatorio.";
    } elseif (!preg_match("/^[a-zA-ZáéíóúÁÉÍÓÚñÑ\s]+$/", $nombre)) {
        $errores[] = "El nombre solo puede contener letras y espacios.";
    }

    if (empty($correo)) {
        $errores[] = "El campo de correo electrónico es obligatorio.";
    } elseif (!filter_var($correo, FILTER_VALIDATE_EMAIL)) {
        $errores[] = "El correo electrónico no es válido.";
    }

    if (empty($contrasena)) {
        $errores[] = "El campo de contraseña es obligatorio.";
    } elseif (strlen($contrasena) < 6) {
        $errores[] = "La contraseña debe tener al menos 6 caracteres.";
    }

    
    if (empty($errores)) {
        $registroExitoso = true;
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Formulario de Registro</title>
    <style>
    
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f9;
            margin: 0;
            padding: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }

        .form-container {
            background: #ffffff;
            padding: 20px 40px;
            border-radius: 10px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            width: 100%;
            max-width: 400px;
        }

        .form-container h1 {
            font-size: 24px;
            margin-bottom: 20px;
            color: #333;
        }

        .form-container label {
            font-size: 14px;
            color: #555;
        }

        .form-container input {
            width: 100%;
            padding: 10px;
            margin: 10px 0;
            border: 1px solid #ddd;
            border-radius: 5px;
            font-size: 14px;
        }

        .form-container button {
            width: 100%;
            padding: 10px;
            background-color: #5cb85c;
            color: white;
            border: none;
            border-radius: 5px;
            font-size: 16px;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }

        .form-container button:hover {
            background-color: #4cae4c;
        }

        .form-container .error {
            background: #f8d7da;
            color: #721c24;
            padding: 10px;
            border-radius: 5px;
            margin-bottom: 10px;
        }

       
        .modal {
            display: none; 
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0, 0, 0, 0.5);
            justify-content: center;
            align-items: center;
        }

        .modal-content {
            background: #ffffff;
            padding: 20px;
            border-radius: 10px;
            text-align: center;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            width: 100%;
            max-width: 300px;
        }

        .modal-content h2 {
            margin-bottom: 10px;
            color: #5cb85c;
        }

        .modal-content p {
            color: #333;
            margin-bottom: 20px;
        }

        .modal-content button {
            padding: 10px 20px;
            background-color: #5cb85c;
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }

        .modal-content button:hover {
            background-color: #4cae4c;
        }
    </style>
    <script>
        function mostrarModal() {
            const modal = document.getElementById("modalExito");
            modal.style.display = "flex"; 
        }

        function cerrarModal() {
            const modal = document.getElementById("modalExito");
            modal.style.display = "none"; 
        }

        <?php if ($registroExitoso): ?>
        window.onload = function() {
            mostrarModal();
        }
        <?php endif; ?>
    </script>
</head>
<body>
    <div class="form-container">
        <h1>Formulario de Registro</h1>

        <?php
        if (!empty($errores)) {
            echo "<div class='error'>";
            foreach ($errores as $error) {
                echo "<p>$error</p>";
            }
            echo "</div>";
        }
        ?>

        <form method="POST" action="">
            <label for="nombre">Nombre:</label>
            <input type="text" id="nombre" name="nombre" value="<?php echo $nombre; ?>">

            <label for="correo">Correo Electrónico:</label>
            <input type="text" id="correo" name="correo" value="<?php echo $correo; ?>">

            <label for="contrasena">Contraseña:</label>
            <input type="password" id="contrasena" name="contrasena">

            <button type="submit">Registrarse</button>
        </form>
    </div>
    <div class="modal" id="modalExito">
        <div class="modal-content">
            <h2>¡Registro Exitoso!</h2>
            <p>Te has registrado correctamente.</p>
            <button onclick="cerrarModal()">Cerrar</button>
        </div>
    </div>
</body>
</html>
