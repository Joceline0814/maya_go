<?php
session_start();
include("../config/conexion.php");

$mensaje = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $correo = trim($_POST["correo"]);
    $password = $_POST["password"];

    if (empty($correo) || empty($password)) {

        $mensaje = "Ingrese correo y contraseña.";

    } else {

        $stmt = $conn->prepare("SELECT * FROM usuarios WHERE correo = ?");

        $stmt->bind_param("s", $correo);

        $stmt->execute();

        $resultado = $stmt->get_result();

        if ($resultado->num_rows == 1) {

            $usuario = $resultado->fetch_assoc();

            if (password_verify($password, $usuario["password"])) {

                $_SESSION["usuario_id"] = $usuario["id"];
                $_SESSION["nombre"] = $usuario["nombre"];
                $_SESSION["correo"] = $usuario["correo"];

                header("Location: ../views/perfil.php");
                exit();

            } else {

                $mensaje = "Contraseña incorrecta.";
            }

        } else {

            $mensaje = "Correo no registrado.";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Login</title>
</head>
<body>

<h2>Inicio de Sesión</h2>

<form method="POST">

    <input type="email" name="correo" placeholder="Correo"><br><br>

    <input type="password" name="password" placeholder="Contraseña"><br><br>

    <button type="submit">Ingresar</button>

</form>

<p><?php echo $mensaje; ?></p>

<a href="registro.php">Crear cuenta</a>

</body>
</html>