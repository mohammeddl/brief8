<?php
require_once "class.person.php";

class ProductOwner extends Persons 
{
    private $db;

    public function __construct()
    {
        parent::__construct(); 
        $this->db = new db();
    }

    public function getToggleRole($newRole,$id){
        $conn = $this->db->getConnection();
        $sqlUpDate = "UPDATE persons SET Role = :newRole WHERE id = :id";
        $stmt =$conn->prepare($sqlUpDate);
        $stmt ->bindParam(':newRole', $newRole);
        $stmt ->bindParam(':id' , $id);
        $stmt->execute();
    }

    public function getAssignScrum($projectId,$scrumMasterId){
        $conn = $this->db->getConnection();
        $req = "UPDATE persons SET role = 'ScrumMaster', project_ID = :projectId WHERE id = :scrumMasterId";
        $stmt = $conn->prepare($req);
        $stmt->bindParam(':projectId',$projectId);
        $stmt->bindParam(':scrumMasterId',$scrumMasterId);
        $stmt->execute();
    }






}