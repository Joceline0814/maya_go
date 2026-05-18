<?php
session_start();
include("../config/conexion.php");

if (!isset($_SESSION["usuario_id"])) {
    header("Location: ../auth/login.php");
    exit();
}

$id = $_SESSION["usuario_id"];
$mensaje = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $actual = $_POST["actual"];
    $nueva = $_POST["nueva"];
    $confirmar = $_POST["confirmar"];

    if (empty($actual) || empty($nueva) || empty($confirmar)) {
        $mensaje = "Todos los campos son obligatorios.";
    } elseif ($nueva != $confirmar) {
        $mensaje = "La nueva contraseña no coincide.";
    } else {
        $stmt = $conn->prepare("SELECT password FROM usuarios WHERE id = ?");
        $stmt->bind_param("i", $id);
        $stmt->execute();
        $usuario = $stmt->get_result()->fetch_assoc();

        if (password_verify($actual, $usuario["password"])) {
            $nuevo_hash = password_hash($nueva, PASSWORD_DEFAULT);

            $stmt = $conn->prepare("UPDATE usuarios SET password = ? WHERE id = ?");
            $stmt->bind_param("si", $nuevo_hash, $id);

            if ($stmt->execute()) {
                $mensaje = "Contraseña actualizada correctamente.";
            } else {
                $mensaje = "Error al actualizar contraseña.";
            }
        } else {
            $mensaje = "La contraseña actual es incorrecta.";
        }
    }
}
?>

<h2>Cambiar Contraseña</h2>

<form method="POST">
    <input type="password" name="actual" placeholder="Contraseña actual"><br><br>
    <input type="password" name="nueva" placeholder="Nueva contraseña"><br><br>
    <input type="password" name="confirmar" placeholder="Confirmar nueva contraseña"><br><br>
    <button type="submit">Cambiar contraseña</button>
</form>

<p><?php echo $mensaje; ?></p>

<a href="perfil.php">Volver al perfil</a>