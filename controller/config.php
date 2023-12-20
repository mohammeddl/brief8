<?php

class db {
    private $host = "localhost";
    private $username = "root";
    private $password = "";
    private $dbname = "datawarebrief";
    private $conn;

    public function __construct() {
        try {
            $this->conn = new PDO("mysql:host={$this->host};dbname={$this->dbname}", $this->username, $this->password);
            $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch (PDOException $e) {
            echo "Error: " . $e->getMessage();
        }
    }

    public function getConnection() {
        return $this->conn;
    }
}

