<?php
session_start();
include("../config/conexion.php");

if (!isset($_SESSION["usuario_id"])) {
    header("Location: ../auth/login.php");
    exit();
}

$id = $_SESSION["usuario_id"];
$mensaje = "";

$stmt = $conn->prepare("SELECT * FROM usuarios WHERE id = ?");
$stmt->bind_param("i", $id);
$stmt->execute();
$usuario = $stmt->get_result()->fetch_assoc();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nombre = trim($_POST["nombre"]);
    $correo = trim($_POST["correo"]);

    if (empty($nombre) || empty($correo)) {
        $mensaje = "Los campos no pueden estar vacíos.";
    } elseif (!filter_var($correo, FILTER_VALIDATE_EMAIL)) {
        $mensaje = "Correo no válido.";
    } else {
        $stmt = $conn->prepare("UPDATE usuarios SET nombre = ?, correo = ? WHERE id = ?");
        $stmt->bind_param("ssi", $nombre, $correo, $id);

        if ($stmt->execute()) {
            $_SESSION["nombre"] = $nombre;
            $_SESSION["correo"] = $correo;
            $mensaje = "Perfil actualizado correctamente.";
        } else {
            $mensaje = "Error al actualizar el perfil.";
        }
    }
}
?>

<h2>Perfil del Usuario</h2>

<p>Bienvenido: <?php echo $_SESSION["nombre"]; ?></p>
<p>Correo actual: <?php echo $_SESSION["correo"]; ?></p>

<form method="POST">
    <input type="text" name="nombre" value="<?php echo $usuario['nombre']; ?>"><br><br>
    <input type="email" name="correo" value="<?php echo $usuario['correo']; ?>"><br><br>
    <button type="submit">Actualizar Perfil</button>
</form>

<p><?php echo $mensaje; ?></p>

<a href="cambiar_password.php">Cambiar contraseña</a><br>
<a href="../auth/logout.php">Cerrar sesión</a>