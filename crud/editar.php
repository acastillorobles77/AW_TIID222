<?php

include('conexion.php');
$conexion = conectar();
$id = $_GET['id'];
$sql = "SELECT * FROM alumnos WHERE id_alumno=?";
if ($stmt = $conexion->prepare($sql))
{
    $stmt->bind_param('i', $id);
    try
    {
        $stmt->execute();
        $resultado = $stmt->get_result();
        $alumno = $resultado->fetch_assoc();
    }
    catch (Exception $ex)
    {
        echo "No se pudo encontrar los datos del alumno con id " . $id . ": " . $ex->getMessage();
        echo "<br><a href=\"alumnos.php\">Regresar</a>";
    }
    finally
    {
        $stmt->close();
    }
}

?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Formulario editar</title>
</head>
<body>
    <h1>Formulario editar</h1>
    <form action="actualizar.php" method="post">
        <input type="hidden" name="id_alumno" value="<?php echo $alumno['id_alumno']; ?>" required>
        <label>Nombre:</label>
        <input type="text" name="nombre" value="<?php echo $alumno['nombre']; ?>" required>
        <label>Apellido paterno:</label>
        <input type="text" name="apellido_p" value="<?php echo $alumno['apellido_p']; ?>" required>
        <label>Apellido materno:</label>
        <input type="text" name="apellido_m" value="<?php echo $alumno['apellido_m']; ?>" required>
        <label>Edad:</label>
        <input type="number" name="edad" value="<?php echo $alumno['edad']; ?>" required>
        <input type="submit" value="Guardar cambios">
    </form>
</body>
</html>
