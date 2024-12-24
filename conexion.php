<?php
ini_set('display_errors', 0);
//ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

class Database
{
    private $host = "localhost"; // Cambia esto si tu host es diferente
    private $db_name = "test_developers"; // Reemplaza con el nombre de tu base de datos
    private $username = "admin"; // Reemplaza con tu usuario de la base de datos
    private $password = "Lnk502**Iso202"; // Reemplaza con tu contraseña de la base de datos
    public $conn;

    //private $host = "localhost"; // Cambia esto si tu host es diferente
    //private $db_name = "test_developers"; // Reemplaza con el nombre de tu base de datos
    //private $username = "root"; // Reemplaza con tu usuario de la base de datos
    //private $password = ""; // Reemplaza con tu contraseña de la base de datos
   //public $conn;
    //$this->getConnection();

    public function getConnection()
    {
        $this->conn = null;

        try {
            $this->conn = new PDO("mysql:host=" . $this->host . ";dbname=" . $this->db_name, $this->username, $this->password);
            $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch (PDOException $exception) {
            echo "Connection error: " . $exception->getMessage();
        }

        return $this->conn;
    }
}
?>