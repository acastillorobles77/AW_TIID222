<?php

include('conexion.php');
$conexion = conectar();

// Datos nuevos del alumno
$id_alumno = $_POST['id_alumno'];
$nombre = $_POST['nombre'];
$apellido_p = $_POST['apellido_p'];
$apellido_m = $_POST['apellido_m'];
$edad = $_POST['edad'];

$sql = "UPDATE alumnos SET nombre = ?, apellido_p = ?, apellido_m = ?, edad = ? WHERE id_alumno = ?";

if ($stmt = $conexion->prepare($sql))
{
    $stmt->bind_param("sssii", $nombre, $apellido_p, $apellido_m, $edad, $id_alumno);
    try
    {
        $stmt->execute();
        $stmt->close();
        header("Location: alumnos.php");
    }
    catch (Exception $ex)
    {
        echo "No se pudo actualizar los datos del alumno con id " . $id_alumno . ": " . $ex->getMessage();
        echo "<br><a href=\"alumnos.php\">Regresar</a>";
        $stmt->close();
    }
}

?>
