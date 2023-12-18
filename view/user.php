
<?php
session_start();
include "../model/class.person.php";
include "../model/classproject.php";

if ($_SESSION['user_role'] != 'member') {
    header("Location: login.php");
}

$team = new Persons();


if (isset($_SESSION['equipe_ID']) && $_SESSION['equipe_ID'] !== null) {
    $data = $team->getTeamMembers($_SESSION['equipe_ID']);
    $row = $team->getTeams();
    echo "Login successful. Welcome, {$_SESSION['user_name']}!";
} else {

    echo "Error: you dont have the equipe !!!";

}
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
<nav class="flex justify-between bg-[#24698b] text-white w-full">
        <div class="xl:px-11 justify-between flex w-full items-center">
            <a class="text-3xl font-bold font-heading" href="#">
            <img class="h-[70px] logo" src="img/logo.png" alt="logo"></a>

            <ul class="hidden md:flex px-10 ml-auto font-semibold font-heading space-x-12 max-md:gap-80 max-md:absolute max-md:right-0 max-md:top-[84px] max-md:bg-gray-950 max-md:h-[400px] max-md:w-[200px]"
                id="nav-links">
                <li class="max-md:my-8"><a class="hover:text-gray-200 max-md:ml-[50px] " href="#">Member</a></li>
                <li class="max-md:my-8"><a class="hover:text-gray-200" href="#">Teams</a></li>

            </ul>
            
        </div>
        <button class="md:hidden flex items-center cursor-pointer ml-2" id="burger-menu">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 hover:text-gray-300" fill="none" viewBox="0 0 24 24"
                stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
            </svg>
        </button>
    </nav> 
    
    <?php
    if(!empty($row[1])){
      ?>
    <div class="bg-gray-100 py-8 flex justify-center h-[100vh] ">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
    <h2 class="text-gray-500 text-xs font-medium uppercase tracking-wide">Teams</h2>
    <ul role="list" class="mt-3 grid grid-cols-1 gap-5 sm:gap-6 sm:grid-cols-2 lg:grid-cols-4">
      
        <li class="col-span-1 flex shadow-sm rounded-md">
          <div class="flex-shrink-0 flex items-center justify-center w-16 bg-teal-600 text-white text-sm font-medium rounded-l-md">
            <?=$row[12]?>
          </div>
          <div class="flex-1 flex items-center justify-between border-t border-r border-b border-gray-200 bg-white rounded-r-md w-[500px] truncate">
            <div class="flex-1 px-4 py-2 text-sm truncate">
              <a href="#" class="text-gray-900 font-medium hover:text-gray-600"><?=$row[12]?></a>
              <?php
      }
      ?>
              <?php
              foreach($data as $affich){
                ?>
              <p class="text-gray-500"><?= $affich[1]?></p>
              <?php
            }
            ?>
            </div>
            <div class="flex-shrink-0 pr-2">
              <button type="button" class="w-8 h-8 bg-white inline-flex items-center justify-center text-gray-400 rounded-full bg-transparent hover:text-gray-500 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                <span class="sr-only">Open options</span>
                <svg class="w-5 h-5" x-description="Heroicon name: solid/dots-vertical" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
  <path d="M10 6a2 2 0 110-4 2 2 0 010 4zM10 12a2 2 0 110-4 2 2 0 010 4zM10 18a2 2 0 110-4 2 2 0 010 4z"></path>
</svg>
              </button>
            </div>
          </div>
        </li>
        </ul>
        </div>
        </div>

</body>
</html>