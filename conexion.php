
<?php

class Conexion {
    private $host = "localhost";
    private $user = "root";
    private $pwd = "";
    private $dbName = "pac_dwes";
    private $pdo;

    function crearConexion() {
        try {
            $dsn = "mysql:host=".$this->host.";dbname=".$this->dbName;
            $this->pdo = new PDO($dsn, $this->user, $this->pwd);
            $this->pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $this->pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
            return $this->pdo;
        } catch (PDOException $e) {
            die("Connection failed: " . $e->getMessage());
        }
    }

    function cerrarConexion() {
        $this->pdo = null;
    }
}

