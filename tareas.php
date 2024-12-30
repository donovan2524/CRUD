<?php
    session_start();
    ob_start();
    include 'conexion.php';

    if (!isset($_SESSION['username'])) {
        header("Location: index.php");
        exit();
    }

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $action = $_POST['action'];

        if ($action == 'agregar') {
            $titulo = $_POST['titulo'];
            $asunto = $_POST['asunto'];
            $materia = $_POST['materia'];

            $stmt = $conn->prepare("INSERT INTO tareas (titulo, asunto, materia) VALUES (?, ?, ?)");
            $stmt->bind_param("sss", $titulo, $asunto, $materia);
            if ($stmt->execute()) {
                header("Location: tareas.php");
                exit();
            } else {
                echo "Error al agregar la tarea: " . $conn->error;
            }
            $stmt->close();
        } elseif ($action == 'modificar') {
            $id = $_POST['id'];
            $titulo = $_POST['titulo'];
            $asunto = $_POST['asunto'];
            $materia = $_POST['materia'];

            $stmt = $conn->prepare("UPDATE tareas SET titulo=?, asunto=?, materia=? WHERE id=?");
            $stmt->bind_param("sssi", $titulo, $asunto, $materia, $id);

            if ($stmt->execute()) {
                header("Location: tareas.php");
                exit();
            } else {
                echo "Error al modificar la tarea: " . $conn->error;
            }
            $stmt->close();
        } elseif ($action == 'eliminar') {
            $id = $_POST['id'];

            $stmt = $conn->prepare("DELETE FROM tareas WHERE id=?");
            $stmt->bind_param("i", $id);

            if ($stmt->execute()) {
                header("Location: tareas.php");
                exit();
            } else {
                echo "Error al eliminar la tarea: " . $conn->error;
            }
            $stmt->close();
        }
    }
    $result = $conn->query("SELECT * FROM tareas");
?>




<!DOCTYPE html>
<html lang="es">
<head>
    <link href="style.css" rel="stylesheet" type="text/css">
    <meta charset="utf-8">
    <title>Tareas Pendientes</title>
</head>
<body>
<div class="principal">
	<div class="caja">
    <b></b>
    <h3 style="z-index: 10;">Bienvenido, <?php echo htmlspecialchars($_SESSION['username']); ?></h3><br>
    
        <form method="POST" action="tareas.php">
            <input type="hidden" name="action" value="agregar">
            <h3>titulo</h3>
            <input type="text" name="titulo" required class="campo">
            <h3>asunto</h3>
            <input type="text" name="asunto" required class="campo">
            <h3>materia</h3>
            <input type="text" name="materia" required class="campo">
            <br>
            <button type="submit" class="venta">Agregar Tarea</button>
        </form>
       
</div>

<div class="datos">
	
    <table class="tabla">
    <b></b>
        <tr class="fecha">
            <th>ID</th>
            <th>titulo</th>
            <th>asunto</th>
            <th>materia</th>
            <th>Fecha</th>
            <th>Acciones</th>
        </tr>
        <?php while ($row = $result->fetch_assoc()): ?>
            <tr>
                <form method="POST" action="tareas.php">
                    <td class="fecha"><?php echo htmlspecialchars($row['id']); ?></td>
                    <td><input type="text" name="titulo" value="<?php echo htmlspecialchars($row['titulo']); ?>" required></td>
                    <td><input type="text" name="asunto" value="<?php echo htmlspecialchars($row['asunto']); ?>" required></td>
                    <td><input type="text" name="materia" value="<?php echo htmlspecialchars($row['materia']); ?>" required></td>
                    <td class="fecha"><?php echo htmlspecialchars($row['Fecha']); ?></td>
                    <td>
                      <input type="hidden" name="id" value="<?php echo htmlspecialchars($row['id']); ?>">
                        <button type="submit" name="action" value="modificar" class="venta">Modificar</button><br>
                      <button type="submit" name="action" value="eliminar" class="logout">Eliminar</button>
                    </td>
                </form>
            </tr>
        <?php endwhile; ?>
    </table>
    </div>
</div>
<a href="logout.php"><button class="logout">Cerrar Sesión</button></a>
</body>
</html>