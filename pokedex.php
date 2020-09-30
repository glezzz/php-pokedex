<?php
//declare(strict_types = 1);

ini_Set('display_errors', 1);    // 1 true 0 false
ini_Set('display_startup_errors', 1);
error_reporting(E_ALL);

$pokemon = $_POST['nameid'];

if ($pokemon === null) {
    $pokemon = 1;
}

$getData = file_get_contents('https://pokeapi.co/api/v2/pokemon/' . $pokemon);
$data = (json_decode($getData, true));
//var_dump($data);
$name = $data['name'];
$pokeId = $data['id'];
$img = $data['sprites']['front_default'];




?>
<!DOCTYPE html>
<html lang="en" xmlns="http://www.w3.org/1999/html">
    <body>
    <div id = "form">
        <form action = "pokedex.php" method = "post">
            Pokemon: <input type = "text" name = "nameid" />
            <input type = "submit" />
        </form>
    </div>
    <div class="name">
        <?php echo $pokeId; echo '&nbsp;'; echo $name;?>        <!-- &nbsp (Non-Breakable Space) whitespace between id & name-->
    </div>
    <div id="image">
        <img src="<?php echo $img;?>">
    </div>
    <h3>4 Moves</h3>
    <ul class="moves">
        <li id="moveOne"></li>
        <li id="moveTwo"></li>
        <li id="moveThree"></li>
        <li id="moveFour"></li>
    </ul>
    </body>
</html>