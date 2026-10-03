<?php

require('conexion.php');
$conexion = conectar();
$sql = "SELECT * FROM alumnos";
$query = mysqli_query($conexion, $sql);
if (!$query)
{
    echo "No se pudo leer la tabla.";
}

?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CRUD DE ALUMNOS</title>
</head>
<body>
    <div style="display: grid; grid-template-columns: 2fr 1fr; gap: 30px;">
        <div>
            <h1>TABLA DE ALUMNOS</h1>
            <table border="2">
                <thead>
                    <tr>
                        <th>Matricula</th>
                        <th>Nombre</th>
                        <th>Apellido Paterno</th>
                        <th>Apellido Materno</th>
                        <th>Edad</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    while ($row = mysqli_fetch_array($query)) {
                    ?>
                    <tr>
                        <td><?php echo $row["matricula"]?></td>
                        <td><?php echo $row["nombre"]?></td>
                        <td><?php echo $row["apellido_p"]?></td>
                        <td><?php echo $row["apellido_m"]?></td>
                        <td><?php echo $row["edad"]?></td>
                        <td><?php /* echo $row[""] */?></td>
                    </tr>
                    <?php
                    }
                    ?>
                </tbody>
            </table>
        </div>
    </div>
    <div>
        <h1>Formulario</h1>
        <div style="display: flex; gap:10px;">
            <form action="insertar.php" method="post">
                <input type="text" class="form-control" name="matricula" placeholder="Matrícula" required>
                <input type="text" class="form-control" name="nombre" placeholder="Nombre" required>
                <input type="text" class="form-control" name="apellido_p" placeholder="Apellido paterno" required>
                <input type="text" class="form-control" name="apellido_m" placeholder="Apellido materno" required>
                <input type="text" class="form-control" name="edad" placeholder="Edad" required>
                <input type="submit" value="Guardar">
            </form>
        </div>
    </div>
</body>
</html>
