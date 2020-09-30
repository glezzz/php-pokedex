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

        //get 4 moves but if any pokemon has fewer than 4, show them all
function getMoves($allMoves){
    $fourRandMoves = array();
    $maxMoves = count($allMoves);   //count() count all elements in array
    if($maxMoves > 4){
        $fourMoves = 4;
        for($i = 0; $i < $fourMoves; $i++){
            $random = floor(rand(0, $maxMoves - 1) - 0);
            array_push($fourRandMoves, $allMoves[$random]['move']['name']);
        }
    } elseif ($maxMoves < 4) {
        $fourMoves = $maxMoves;
        for ($i = 0; $i < $fourMoves; $i++) {
            array_push($fourRandMoves, $allMoves[$i]['move']['name']);

        }
    }


}
$getMoves = getMoves($allMoves);





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
    </div>                                                                  <!-- ucfirst() first char uppercase -->
    <div id="image">
        <img src="<?php echo $img;?>">
    </div>
    <h3>4 Moves</h3>
    <?php echo $getMoves;?>
    <!-- <ul class="moves">
        <li id="moveOne"></li>
        <li id="moveTwo"></li>
        <li id="moveThree"></li>
        <li id="moveFour"></li>
    </ul>-->
    </body>
</html>