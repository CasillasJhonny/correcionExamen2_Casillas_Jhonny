<?php

class Connection {

    function getConection(){
        $conex = mysqli_connect("127.0.0.1", "root", "admin123", "examen2");
        if (!$conex) {
            echo "<p> Error: No se pudo conectar a MySQL." . PHP_EOL;
            echo "errno de depuración: " . mysqli_connect_errno();
            echo "error de depuración: " . mysqli_connect_error();
            echo "</p>";
            exit;
        }
        return $conex;
    }

}
?>