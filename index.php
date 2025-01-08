<?php
session_start();
include 'conexion.php';

$error = '';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST['username'];
    $password = md5($_POST['password']);
    
    $sql = "SELECT * FROM usuarios WHERE username = '$username' AND password = '$password'";
    $result = $conn->query($sql);
    
    if ($result->num_rows > 0) {
        $_SESSION['username'] = $username;
        header("Location: tareas.php");
        exit();
    } else {
        $error = "Nombre de usuario o contraseña incorrectos";
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <link href="index.css" rel="stylesheet" type="text/css">
    <meta charset="utf-8">
    <title>Login</title>
    <link rel="shortcut icon" href="logo.png"> 

</head>
<body>
<div class="caja">
<img src="logo.png" style="width:150px;">
    <h2>Iniciar Sesión</h2>
    <form method="post" action="index.php">
        <label>Usuario:</label>
        <input type="text" name="username" required>
        
        <label>Contraseña:</label>
        <input type="password" name="password" required>
        
        <button type="submit">Ingresar</button><br>
        
        <?php if (!empty($error)): ?>
            <div class="mensaje-error"><?php echo htmlspecialchars($error); ?></div>
        <?php endif; ?>
    </form>
</div>
</body>
</html>
