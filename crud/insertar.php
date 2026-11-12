<?php

include('conexion.php');
$conexion = conectar();
$matricula = $_POST["matricula"];
$nombre = $_POST["nombre"];
$apellido_p = $_POST["apellido_p"];
$apellido_m = $_POST["apellido_m"];
$edad = $_POST["edad"];

$sql = "INSERT INTO alumnos (matricula, nombre, apellido_p, apellido_m, edad) VALUES (?, ?, ?, ?, ?)";

if ($stmt = $conexion->prepare($sql))
{
    $stmt->bind_param("ssssi", $matricula, $nombre, $apellido_p, $apellido_m, $edad);
    try
    {
        $stmt->execute();
        echo "Se han guardado los datos exitosamente.";
    }
    catch (Exception $ex)
    {
        echo "No se pudieron guardar los datos: " . $ex->getMessage();
    }
    finally
    {
        $stmt->close();
        echo "<br><a href=\"alumnos.php\">Regresar</a>";
    }
}

?>