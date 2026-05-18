<?php
include("../config/conexion.php");

$mensaje = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $cedula = trim($_POST["cedula"]);
    $nombre = trim($_POST["nombre"]);
    $correo = trim($_POST["correo"]);
    $password = $_POST["password"];

    if (empty($cedula) || empty($nombre) || empty($correo) || empty($password)) {

        $mensaje = "Todos los campos son obligatorios.";

    } elseif (!filter_var($correo, FILTER_VALIDATE_EMAIL)) {

        $mensaje = "Ingrese un correo válido.";

    } else {

        $verificar = $conn->prepare("SELECT id FROM usuarios WHERE correo = ?");
        $verificar->bind_param("s", $correo);
        $verificar->execute();
        $resultado = $verificar->get_result();

        if ($resultado->num_rows > 0) {

            $mensaje = "El correo ya está registrado.";

        } else {

            $password_hash = password_hash($password, PASSWORD_DEFAULT);

            $stmt = $conn->prepare("INSERT INTO usuarios (cedula, nombre, correo, password)
            VALUES (?, ?, ?, ?)");

            $stmt->bind_param("ssss", $cedula, $nombre, $correo, $password_hash);

            if ($stmt->execute()) {

                $mensaje = "Usuario registrado correctamente.";

            } else {

                $mensaje = "Error al registrar usuario.";
            }
        }
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Registro</title>
</head>
<body>

<h2>Registro de Usuario</h2>

<form method="POST">

    <input type="text" name="cedula" placeholder="Cédula"><br><br>

    <input type="text" name="nombre" placeholder="Nombre completo"><br><br>

    <input type="text" name="correo" placeholder="Correo electrónico"><br><br>

    <input type="password" name="password" placeholder="Contraseña"><br><br>

    <button type="submit">Registrar</button>

</form>

<p style="color:red;">
    <?php echo $mensaje; ?>
</p>

<a href="login.php">Iniciar sesión</a>

</body>
</html>