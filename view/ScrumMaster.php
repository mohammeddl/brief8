<?php

session_start();
if ($_SESSION['user_role'] != 'ScrumMaster') {
    header("Location: signin.php");
}
include 'config.php';

function dd($data)
{
    echo '<pre>';
    print_r($data);
    echo '</pre>';
    exit;
}



if ($_SERVER["REQUEST_METHOD"] === "POST") {
    if (isset($_POST["submitName"])) {
        $teamName = $_POST["teamName"];

        $sqlAddName = "INSERT INTO equipes ( nameTeams) VALUES(:teamName)";
        $stmt = $pdo->prepare($sqlAddName);
        $stmt->bindParam(':teamName', $teamName);
        $stmt->execute();
    }

    if (isset($_POST["submitAddMember"])) {
        $teamName = $_POST["teamNameSelect"];
        $memberid = $_POST["memberName"];
        $sqlAddMember = "UPDATE persons SET equipe_ID = :teamName WHERE id = :memberid";
        $stmt = $pdo->prepare($sqlAddMember);
        $stmt->bindParam(':teamName', $teamName);
        $stmt->bindParam(':memberid', $memberid);
        $stmt->execute();
    }

    if (isset($_POST["submitRemove"])) {
        $memberid = $_POST["memberName"];
        $sqlRemoveMember = "UPDATE persons SET equipe_ID = NULL WHERE id = :memberid";
        $stmt = $pdo->prepare($sqlRemoveMember);
        $stmt->bindParam(':memberid', $memberid);
        $stmt->execute();
    }

    // delete team
    if (isset($_POST["deleteTeam"])) {
        $teamId = $_POST["teamId"];
        $sqlRemoveMembers = "UPDATE persons SET equipe_ID = NULL WHERE equipe_ID = :teamId";
        $stmt = $pdo->prepare($sqlRemoveMembers);
        $stmt->bindParam(':teamId', $teamId);
        $stmt->execute();

        $sqlDeleteTeam = "DELETE FROM equipes WHERE id = :teamId";
        $stmt = $pdo->prepare($sqlDeleteTeam);
        $stmt->bindParam(':teamId', $teamId);
        $stmt->execute();
    }

    // select equipe to project
    if (isset($_POST["submitAddProject"])) {
        $teamName = $_POST["projectNameSelect"];
        $SelectProject = $_POST["teamNameSelectProject"];
        $sqlSelect = "UPDATE equipes SET project_ID = :teamName WHERE id = :SelectProject";
        $stmt = $pdo->prepare($sqlSelect);
        $stmt->bindParam(':teamName', $teamName);
        $stmt->bindParam(':SelectProject', $SelectProject);
        $stmt->execute();
    }
}

$dataE = getAllEquipes($pdo);
$dataP = getAllPersons($pdo);
$dataProject = getAllProjects($pdo);
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body>
<nav class=" fixed flex justify-between bg-[#24698b] text-white w-full">
        <div class="xl:px-11 justify-between flex w-full items-center">
            <a class="text-3xl font-bold font-heading" href="#">
                <img class="h-[70px] logo" src="img/logo.png" alt="logo"></a>

            <ul class="hidden md:flex px-10 ml-auto font-semibold font-heading space-x-12 max-md:gap-80 max-md:absolute max-md:right-0 max-md:top-[84px] max-md:bg-gray-950 max-md:h-[400px] max-md:w-[200px]"
                id="nav-links">
                <li class="max-md:my-8"><a class="hover:text-gray-200 max-md:ml-[50px] " href="#memberTable">Member</a></li>
                <li class="max-md:my-8"><a class="hover:text-gray-200" href="#teamsTeble">Teams</a></li>

            </ul>
            
        </div>

        <button class="md:hidden flex items-center cursor-pointer ml-2" id="burger-menu">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 hover:text-gray-300" fill="none" viewBox="0 0 24 24"
                stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
            </svg>
        </button>   
    </nav> 

    <div class="bg-gray-100 py-8">
    <div class="max-w-7xl mt-24 mx-auto px-4 sm:px-6 lg:px-8">
      

<div class="max-w-md  mx-auto bg-white p-8 rounded shadow-md">
    <h1 class="text-2xl font-semibold mb-4">Team Management</h1>
   <!-- Add Team Form -->
    <form  method="post" class="mb-6">
        <label for="teamName" class="block text-sm font-medium text-gray-700">Team Name:</label>
        <input type="text" id="teamName" name="teamName" class="mt-1 p-2 w-full border rounded-md">

        <div class="flex justify-between mt-4">
            <button type="submit" name="submitName" class="bg-blue-500 text-white px-4 py-2 rounded-md">Add Team</button>
        </div>
    </form>

    <!-- Manage Team Members Form -->
    <form  method="post">
        <label for="teamNameSelect" class="block text-sm font-medium text-gray-700">Select Team:</label>
        <select id="teamNameSelect" name="teamNameSelect" class="mt-1 p-2 w-full border rounded-md">
    <?php
    foreach($dataE as $equipe ){
      ?>
        <option value="<?=$equipe['id']?> "><?=$equipe['nameTeams']?></option>
    <?php
  } ?>
        </select>

        <label for="memberName" class="block mt-4 text-sm font-medium text-gray-700">Member Name:</label>
        <select id="memberName" name="memberName" class="mt-1 p-2 w-full border rounded-md">
        <?php
        
    foreach($dataP as $personn ){
      if($personn['Role'] === "member" && empty($personn['equipe_ID'])){
      ?>
        <option value="<?=$personn['id']?>"><?=$personn['Nom']?></option>
    <?php
  }} ?>
  </select>
   </select>
        <div class="flex justify-between py-4">
            <button type="submit" name="submitAddMember" class="bg-green-500 text-white px-4 py-2 rounded-md">Add Member</button>
            <button type="submit" name="submitRemove" class="bg-red-500 text-white px-4 py-2 rounded-md">Remove Member</button>
        </div>
    </form>
</div>


<!-- Add Project to Team Form -->
<div class="max-w-md mx-auto bg-white my-20 p-8 rounded shadow-md">
<h2 class=" w-[70vh]  mx-auto text-3xl m-6 font-semibold">Add Project to Team </h2>
    <form action="" method="post" class="mb-6">
        <label for="projectNameSelect" class="block mt-4 text-sm font-medium text-gray-700">Select Project:</label>
        <select id="projectNameSelect" name="projectNameSelect" class="mt-1 p-2 w-full border rounded-md">
            <?php
            foreach ($dataProject as $project) {
            ?>
                <option value="<?=$project['id']?>"> <?= $project['nom'] ?></option>
            <?php
            }
            ?>
        </select>

        <label for="teamNameSelectProject" class="block text-sm font-medium text-gray-700">Select Team:</label>
        <select id="teamNameSelectProject" name="teamNameSelectProject" class="mt-1 p-2 w-full border rounded-md">
            <?php
            foreach ($dataE as $equipe) {
            ?>
                <option value="<?= $equipe['id'] ?>"> <?= $equipe['nameTeams'] ?></option>
            <?php
            } ?>
        </select>

        <div class="flex justify-between mt-4">
            <button type="submit" name="submitAddProject" class="bg-green-500 text-white px-4 py-2 rounded-md">Add Project to Team</button>
        </div>
    </form>
</div>




<!-- cards -->
<h2 class=" w-[70vh]  mx-auto text-3xl m-6 font-semibold"id="teamsTeble">Teams</h2>
<?php
foreach ($dataE as $equipe) {
  ?>
    <div class=" w-[70vh]  mx-auto ">
      <h2 class="text-gray-500 text-xs font-medium uppercase tracking-wide mt-16" >Teams</h2>
        <ul role="list" class="mt-3 grid grid-cols-1 gap-5 sm:gap-6 sm:grid-cols-2 lg:grid-cols-4">
            <li class="col-span-1 flex shadow-sm rounded-md w-[60vh]">
                <div class="flex-shrink-0 flex items-center justify-center w-16 bg-pink-600 text-white text-sm font-medium rounded-l-md ">
                    <?php $test = $equipe['nameTeams'];
                    $firstCharacter = $test[0];
                    echo $firstCharacter; ?>
                </div>
                <div class="flex-1 flex items-center justify-between border-t border-r border-b border-gray-200 bg-white rounded-r-md truncate">
                    <div class="flex-1 px-4 py-2 text-sm truncate">
                        <a href="#" class="text-gray-900 font-medium hover:text-gray-600"><?= $equipe['nameTeams'] ?></a>
                        <p class="text-gray-500">Members:
                            <?php
                            $teamMembers = array_filter($dataP, function ($person) use ($equipe) {
                                return $person['equipe_ID'] == $equipe['id'];
                            });
                            foreach ($teamMembers as $member) {
                                echo $member['Nom'] . ', ';
                            }
                            ?>
                        </p>
                    </div>
                    <div class="flex-shrink-0 pr-2">
                        <form method="post" action="ScrumMaster.php">
                            <input type="hidden" name="teamId" value="<?= $equipe['id']?>">
                            <button type="submit" name="deleteTeam" class="w-8 h-8 bg-slate-800 inline-flex items-center justify-center text-slate rounded-full bg-transparent hover:text-blue-600 focus:outline-none focus:ring-2 focus:ring-offset-2">
                                <span class="sr-only">Delete team</span>
                                <svg class="w-5 h-5" x-description="Heroicon name: solid/trash" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                                    <path fill-rule="evenodd" d="M5 2a2 2 0 012-2h6a2 2 0 012 2h2a1 1 0 110 2h-1v12a2 2 0 01-2 2H8a2 2 0 01-2-2V4H5a1 1 0 110-2h2zM4 7a1 1 0 011-1h10a1 1 0 010 2H5a1 1 0 01-1-1zM6 11a1 1 0 112 0v5a1 1 0 11-2 0v-5zm5 0a1 1 0 112 0v5a1 1 0 11-2 0v-5z" clip-rule="evenodd"></path>
                                </svg>
                            </button>
                        </form>
                    </div>
                </div>
            </li>
        </ul>
    </div>
<?php
}
?>


<!-- member -->
<div class="bg-gray-100 my-10 h-[100vh] py-10" id="memberTable">
<h2 class="text-3xl my-6 font-semibold">Members</h2>
    <div class="mx-auto max-w-7xl">
    <div class="mt-8 flex flex-col">
      <div class="-my-2 -mx-4 overflow-x-auto sm:-mx-6 lg:-mx-8">
        <div class="inline-block min-w-full py-2 align-middle md:px-6 lg:px-8">
          <div class="overflow-hidden shadow ring-1 ring-black ring-opacity-5 md:rounded-lg">
            <table class="min-w-full divide-y divide-gray-300">
              <thead class="bg-gray-50">
                <tr>
                  <th scope="col" class="py-3.5 pl-4 pr-3 text-left text-sm font-semibold text-gray-900 sm:pl-6">Name</th>
                  <th scope="col" class="px-3 py-3.5 text-left text-sm font-semibold text-gray-900">Phone</th>
                  <th scope="col" class="px-3 py-3.5 text-left text-sm font-semibold text-gray-900">Email</th>
                  <th scope="col" class="px-3 py-3.5 text-left text-sm font-semibold text-gray-900">Role</th>
                  <th scope="col" class="relative py-3.5 pl-3 pr-4 sm:pr-6">
                    <span class="sr-only">Edit</span>
                  </th>
                </tr>
              </thead>
              <tbody class="divide-y divide-gray-200 bg-white">
                
              <?php
            foreach($dataP as $personn ){
                ?>
                <tr>
                <td class="whitespace-nowrap py-4 pl-4 pr-3 text-sm font-medium text-gray-900 sm:pl-6">
                <?php
                $free=" ";
                echo $personn['Nom'] ,$free,  $personn['Prenom']
                ?>
                </td>
                <td class="whitespace-nowrap px-3 py-4 text-sm text-gray-500">
                    <?php
                    echo $personn['Telephone']
                    ?>
                </td>
                <td class="whitespace-nowrap px-3 py-4 text-sm text-gray-500">
                <?php
                    echo $personn['Email']
                    ?>
                </td>
                <td class="whitespace-nowrap px-3 py-4 text-sm text-gray-500"><?=$personn['Role']?></td>
                <td class="relative whitespace-nowrap py-4 pl-3 pr-4 text-right text-sm font-medium sm:pr-6">
                  <a href="#" class="text-indigo-600 hover:text-indigo-900">Edit<span class="sr-only">, Lindsay Walton</span></a>
                </td>
              </tr>

                  <?php
               }
               ?>

              </tbody>
            </table>
          </div>
        </div>
      </div>
    </div>
  </div>

    </div>
  </div>

</body>
</html>