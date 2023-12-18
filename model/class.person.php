<?php
include "../controller/config.php";

class Persons
{   
    private $firstName;
    private $lastName;
    private $email;
    private $phone;
    private $pass;
    private $role;
    private $equipeId;
    private $project;

    private $db;

    public function __construct(){
        $this->db = new db();
        
    }

    public function authenticate($email, $pass)
    {
        try {
            $conn = $this->db->getConnection();
            $stmt = $conn->prepare("SELECT * FROM persons WHERE email = :email AND pass = :pass");
            $stmt->bindParam(':email', $email);
            $stmt->bindParam(':pass', $pass);
            $stmt->execute();

            $row = $stmt->fetch(PDO::FETCH_ASSOC);
            

            if ($row) {
                $_SESSION['user_id'] = $row['id'];
                $_SESSION['user_name'] = $row['Nom'];
                $_SESSION['user_role'] = $row['Role'];
                
                echo "Login successful. Welcome, {$_SESSION['user_name']}!";

                switch ($_SESSION['user_role']) {
                    case "ScrumMaster":
                        $_SESSION['status'] = 'ScrumMaster';
                        header("Location: ../view/ScrumMaster.php");
                        exit;
                    case "member":
                        $_SESSION['status'] = 'member';
                        header("Location: ../view/user.php");
                        exit;
                    case "ProductOwner":
                        
                    $_SESSION['user_role'] = 'ProductOwner';
                        header("Location: ../view/ProductOwner.php");
                        exit;
                }
            } else {
                return "Email or password is incorrect";
            }
        } catch (PDOException $e) {
            return "Error: " . $e->getMessage();
        }
    }



    public function setValues($firstName, $lastName, $email, $phone, $pass)
    {
        $this->firstName = $firstName;
        $this->lastName = $lastName;
        $this->email =  $email;
        $this->phone = $phone;
        $this->pass = $pass;
    }

    public function insertPerson($prenom, $nom, $email, $tele, $pass)
    {
        $conn = $this->db->getConnection();
        $sql = "INSERT INTO persons (nom, prenom, email, telephone, pass) VALUES(:nom, :prenom, :email, :telephone, :pass)";
        $stmt = $conn->prepare($sql);
        $stmt->bindParam(':nom', $nom);
        $stmt->bindParam(':prenom', $prenom);
        $stmt->bindParam(':email', $email);
        $stmt->bindParam(':telephone', $tele);
        $stmt->bindParam(':pass', $pass);

        try {
            $stmt->execute();
            return true;
        } catch (PDOException $e) {
            echo "Error: " . $e->getMessage();
            return false;
        }
    }
    public function getAllPersons() {
    $conn = $this->db->getConnection();
    $stmt = $conn->query("SELECT * FROM persons");
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}


    public function addPerson($name, $email, $phone, $role) {
        $conn = $this->db->getConnection();
        $stmt = $conn->prepare("INSERT INTO persons (Nom, Email, Telephone, Role) VALUES (?, ?, ?, ?)");
        $stmt->execute([$name, $email, $phone, $role]);
}



public function getTeams() {
    $conn = $this->db->getConnection();
    $sql = "SELECT * FROM persons JOIN equipes JOIN projects WHERE persons.equipe_ID = equipes.id";
    $stmt = $conn->query($sql);
    $row = $stmt->fetch(PDO::FETCH_BOTH);

    return $row;
}

public function getTeamMembers() {
    $conn = $this->db->getConnection();
    $sql = "SELECT * FROM persons JOIN equipes WHERE persons.equipe_ID = equipes.id";
    $stmt = $conn->query($sql);
    $data = array();

    while ($rowmember = $stmt->fetch(PDO::FETCH_BOTH)) {
        $data[] = $rowmember;
    }

    return $data;
}



}

