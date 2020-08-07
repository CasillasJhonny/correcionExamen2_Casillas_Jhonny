<?php
include 'conexion.php';

class MainService {
    protected $conex;

    function __construct() {
        $connection = new Connection();
        $this->conex = $connection->getConection();
    }
}

?>