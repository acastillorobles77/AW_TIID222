<?php

// Generamos la función de conexión a la base de datos
function conectar()
{
    $host = "localhost";
    $user = "root";
    $password = "SeMeOlvido01";
    $db = "aw_crud";
    $connection = mysqli_connect($host, $user, $password);
    mysqli_select_db($connection, $db);
    
    return $connection;
}

?>
