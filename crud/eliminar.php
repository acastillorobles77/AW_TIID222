<?php

include('conexion.php');
$conexion = conectar();
$id = $_GET['id'];

$sql = "DELETE FROM alumnos WHERE id_alumno=?";

if ($stmt = $conexion->prepare($sql))
{
    $stmt->bind_param('i', $id);
    try
    {
        $stmt->execute();
        echo "El alumno con id " . $id . " se ha eliminado exitosamente.";
    }
    catch (Exception $ex)
    {
        echo "No se pudo eliminar al alumno: " . $ex->getMessage();
    }
    finally
    {
        $stmt->close();
        echo "<br><a href=\"alumnos.php\">Regresar</a>";
    }
}

?>
