<?php
//declare(strict_types = 1);

ini_Set('display_errors', 1);    // 1 true 0 false
ini_Set('display_startup_errors', 1);
error_reporting(E_ALL);

$pokemon = $_POST['nameid'];       // get input from form

if ($pokemon === null) {
    $pokemon = 1;
}
        //fetch data
$getData = file_get_contents('https://pokeapi.co/api/v2/pokemon/' . $pokemon);
$data = (json_decode($getData, true));
//var_dump($data);
$name = $data['name'];
$pokeId = $data['id'];
$img = $data['sprites']['front_default'];
$allMoves = $data['moves'];

        //get moves
$fourMoves = array();

function getMoves($allMoves){
    $maxMoves = count($allMoves);
    if($maxMoves > 4){
        $fourRandMoves = 4;
    } elseif ($maxMoves < 4){
        $fourRandMoves = $maxMoves;
    }
}



//$getFourMoves = array_rand($allMoves, 4);
//array_push($fourMoves, $getFourMoves);
//echo $allMoves;




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
        <h2><?php echo $pokeId; echo '&nbsp;'; echo ucfirst($name);?></h2>  <!-- &nbsp (Non-Breakable Space) whitespace between id & name-->
    </div>                                                                  <!--ucfirst() first char uppercase -->
    <div id="image">
        <img src="<?php echo $img;?>">
    </div>
    <!-- <h3>4 Moves</h3>
    <ul class="moves">
        <li id="moveOne"></li>
        <li id="moveTwo"></li>
        <li id="moveThree"></li>
        <li id="moveFour"></li>
    </ul>-->
    </body>
</html>