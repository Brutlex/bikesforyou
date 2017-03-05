<?php

//main configuration file containing details for establishing database connection

class Database
{

    private $host = "bikesforyou.at.mysql";
    private $db_name = "bikesforyou_at";
    private $username = "bikesforyou_at";
    private $password = "verynoobs";
    public $conn;

    //function which establishes the connection, mainly called in __construct of other classes

    public function dbConnection()
    {

        $this->conn = null;
        try
        {
            $this->conn = new PDO("mysql:host=" . $this->host . ";dbname=" . $this->db_name, $this->username, $this->password);
            $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        }
        catch(PDOException $exception)
        {
            echo "Connection error: " . $exception->getMessage();
        }

        return $this->conn;
    }
}
?>