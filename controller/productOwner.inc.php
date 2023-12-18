<?php
include 'config.php'; 
include '../model/classproject.php';
include '../model/class.persone.php';


$database = new db();


$projectObj = new Projects($database);
$personObj = new Persons($database);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['submitProject'])) {
        $name = $_POST['name_project'];
        $startDate = $_POST['Start_date'];
        $endDate = $_POST['End_date'];
        $projectObj->addProject($name, $startDate, $endDate);
    } elseif (isset($_POST['submitEditProject'])) {
        $id = $_POST['id_project'];
        $name = $_POST['name_project'];
        $startDate = $_POST['Start_date'];
        $endDate = $_POST['End_date'];
    } elseif (isset($_POST['toggleRole'])) {

        $id = $_POST['id'];
        $role = $_POST['role'];
    } elseif (isset($_POST['assignScrumMaster'])) {
        $projectId = $_POST['projectId'];
        $scrumMasterId = $_POST['scrumMasterId'];
    } elseif (isset($_POST['submitDelete'])) {
        $id = $_POST['id_project'];
    }
}

$dataP = $projectObj->getAllProjects();
$data = $personObj->getAllPersons();
?>
