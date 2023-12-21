<?php
require_once "class.person.php";

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


    public function getAddMember($teamName,$memberid){
        $conn = $this->db->getConnection();
        $req = "UPDATE persons SET equipe_ID = :teamName WHERE id = :memberid";
        $stmt = $conn->prepare($req);
        $stmt->bindParam(':teamName', $teamName);
        $stmt->bindParam(':memberid', $memberid);
        $stmt->execute();
    }

    public function getRemoveMember($memberid){
        $conn = $this->db->getConnection();
        $req ="UPDATE persons SET equipe_ID = NULL WHERE id = :memberid";
        $stm = $conn->prepare($req);
        $stm->bindParam(':memberid',$memberid);
        $stm->execute();
    }


    public function getRemoveTeam($teamId){
        $conn = $this->db->getConnection();
        $sqlRemoveMembers = "UPDATE persons SET equipe_ID = NULL WHERE equipe_ID = :teamId";
        $stmt = $conn->prepare($sqlRemoveMembers);
        $stmt->bindParam(':teamId', $teamId);
        $stmt->execute();
        $sqlDeleteTeam = "DELETE FROM equipes WHERE id = :teamId";
        $stmt = $conn->prepare($sqlDeleteTeam);
        $stmt->bindParam(':teamId', $teamId);
        $stmt->execute();
    }

    public function getSelect($teamName,$SelectProject){
        $conn = $this->db->getConnection();
        $req = "UPDATE equipes SET project_ID = :teamName WHERE id = :SelectProject";
        $stmt = $conn->prepare($req);
        $stmt->bindParam(':teamName', $teamName);
        $stmt->bindParam(':SelectProject', $SelectProject);
        $stmt->execute();
    }
}
?>

