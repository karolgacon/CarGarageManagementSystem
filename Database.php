<?php

require_once "config.php";


class Database {
    private $username;
    private $database;
    private $password;
    private $host;
    private $port;


    public function __construct () {
        $this -> username = USERNAME;
        $this -> database = DATABASE;
        $this -> password = PASSWORD;
        $this -> host = HOST;
        $this -> port = PORT;
    }

    public function connect() {
        try {
            $conn = new PDO(
                "pgsql:host=$this->host;port=$this->port;dbname=$this->database",
                $this->username,
                $this->password,
                ["sslmode"  => "prefer"]
            );

            $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            return $conn;
        }
        catch(PDOException $e) {
            die("Connection failed: " . $e->getMessage());
        }
    }

}


