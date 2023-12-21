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


}