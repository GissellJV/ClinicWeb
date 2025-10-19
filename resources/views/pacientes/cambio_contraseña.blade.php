<?php
include("conexion.php");

if (isset($_GET["token"])) {
    $token = $_GET["token"];

    $query = $conn->prepare("SELECT id, expira_token FROM usuarios WHERE token=?");
    $query->bind_param("s", $token);
    $query->execute();
    $result = $query->get_result();

if ($result->num_rows > 0) {
    $user = $result->fetch_assoc();

if (strtotime($user["expira_token"]) > time()) {
    // Mostrar formulario
    ?>
<form action="guardar_password.php" method="POST">
    <input type="hidden" name="token" value="<?php echo $token; ?>">
    <label>Nueva contraseña:</label>
    <input type="password" name="password" required>
    <button type="submit">Cambiar contraseña</button>
</form>
    <?php
} else {
    echo "El enlace ha expirado.";
}
} else {
    echo "Token inválido.";
}
}
?>
