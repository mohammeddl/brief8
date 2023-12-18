<?php 
include "class.person.php";



class scrum extends Persons
{

public function __construct()
{

}


public function getAllEquipes()
{
    $stmt = $pdo->query("SELECT * FROM equipes");
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

public function getAllPersons()
{
    $stmt = $pdo->query("SELECT * FROM persons");
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

public function getAllProjects(PDO $pdo)
{
    $stmt = $pdo->query("SELECT * FROM projects");
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}


}