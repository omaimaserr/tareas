<!-- Dos usuarios : 
    user1, contraseña: user123 
    admin, contraseña : admin123 -->

<?php

session_start();
if (isset($_SESSION['usuario'])) {
    header("Location: index.php");
    exit;
}
?>

<!DOCTYPE html>
<html>

<head>
    <title>Login</title>
</head>

<body>
    <h2>Login</h2>

    <?php
    if (isset($_GET['error'])) {
        echo "<p style='color:red;'>Usuario o contraseña incorrectos</p>";
    }
    ?>

    <form method="post" action="index.php?orden=Login">
        <label>Usuario:</label>
        <input type="text" name="usuario" required>
        <br>
        <label>Contraseña:</label>
        <input type="password" name="password" required>
        <br>
        <button type="submit">Entrar</button>
    </form>

</body>

</html>