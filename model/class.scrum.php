<?php
include "class.person.php";

class scrum extends Persons
{

    private $db;

    public function __construct()
    {
        parent::__construct(); 
        $this->db = new db();
    }
    


    public function getAllPersons()
    {

        $persons = parent::getAllPersons();

        return $persons;
    }


    public function getAllEquipes()
    {
        $conn = $this->db->getConnection();
        $stmt = $conn->query("SELECT * FROM equipes");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }


    public function getAllProjects()
    {
        $conn = $this->db->getConnection();
        $stmt = $conn->query("SELECT * FROM projects");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getscrum(){


    }

    public function getNameTeam($teamName){
        $conn = $this->db->getConnection();
        $sqlAddName = "INSERT INTO equipes ( nameTeams) VALUES(:teamName)";
        $stmt = $conn->prepare($sqlAddName);
        $stmt->bindParam(':teamName', $teamName);
        $stmt->execute();
    }


}
?>

