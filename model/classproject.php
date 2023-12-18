<?php

class Projects {
    private $db;
    private $name;
    private $startDate;
    private $endDate;

    public function __construct() {
        $this->db = new db();

    }

    public function getAllProjects() {
        $conn = $this->db->getConnection();
        $stmt = $conn->query("SELECT * FROM projects");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function addProject($name, $startDate, $endDate) {
        $conn = $this->db->getConnection();
        $stmt = $conn->prepare("INSERT INTO projects (nom, date_Debut, date_Fin) VALUES (?, ?, ?)");
        $stmt->execute([$name, $startDate, $endDate]);
    }

}
?>