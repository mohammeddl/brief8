<?php
include "../model/class.person.php";
include "../controller/config.php";
$persons = new Persons();
$persons->__construct(new db());


if(isset($_POST['submit'])){
    $firstName=$_POST['first_name'];
    $lastName=$_POST['last_name'];
    $email=$_POST['email'];
    $phone=$_POST['phone'];
    $pass=$_POST['pass'];
    
    $persons->setValues($firstName, $lastName, $email, $phone, $pass);

    if ($persons->insertPerson($firstName, $lastName, $email, $phone, $pass)) {
        header("Location: ../view/login.php");
        exit;
    } else {

        echo "Error inserting data into the database.";
    }

}


