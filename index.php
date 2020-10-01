<?php
declare(strict_types = 0);

ini_Set('display_errors', 1);    // 1 true 0 false
ini_Set('display_startup_errors', 1);
error_reporting(E_ALL);

global $pokemon;
                                // get input from form
if(isset($_GET['nameid'])){
    $pokemon = $_GET['nameid'];
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
function getMoves($allMoves){

    $arrFourRandMoves = array();
    $maxMoves = count($allMoves);   //count() count all elements in array
    if ($maxMoves > 4) {
        $fourMoves = 4;
                                    //only pick 4 moves but if any pokemon has fewer than 4, show them all
    } else {                        // e.g. Ditto
        $fourMoves = $maxMoves;
    }

    for ($i = 0; $i < $fourMoves; $i++) {      // loop through all possible moves and push 4 random ones to the array
        if ($maxMoves > 4) {
            $randMove = floor(rand(0, $maxMoves));
            array_push($arrFourRandMoves, $allMoves[$randMove]['move']['name']);
        } elseif ($maxMoves < 4) {
            array_push($arrFourRandMoves, $allMoves[$i]['move']['name']);
        }

    }
    return $arrFourRandMoves;

}

$displayMoves = getMoves($allMoves);        // make a var out of the func to use it in HTML and be able to index it


function getEvo($pokemon){
                                //fetch evolution data
    $get_evo_data = file_get_contents('https://pokeapi.co/api/v2/pokemon-species/' . $pokemon);
    $evo_data = (json_decode($get_evo_data, true));
    $prev_evo = $evo_data['evolves_from_species'];

    if($prev_evo) {         // if pokemon has a previous evolution,
        $prev_evo_name = $prev_evo['name'];            //fetch data of previous evolution
        $get_prev_evo_data = file_get_contents('https://pokeapi.co/api/v2/pokemon/' . $prev_evo_name);
        $prev_evo_data = (json_decode($get_prev_evo_data, true));
        $prev_evo_img = $prev_evo_data['sprites']['front_default'];     //get sprite from previous evolution
        return($prev_evo_img);


    }else{

    }

}

getEvo($pokemon);
$prev_evo_img = getEvo($pokemon);     // we need to use it in HTML img tag



?>
<!DOCTYPE html>
<html lang="en" xmlns="http://www.w3.org/1999/html">
<body>
<div id="form">
    <form action="index.php" method="get">
        Pokemon: <input type="text" name="nameid"/>
        <input type="submit"/>
    </form>
</div>
<div class="name">
    <h2><?php echo $pokeId;
        echo '&nbsp;';
        echo ucfirst($name); ?></h2>  <!-- &nbsp (Non-Breakable Space) whitespace between id & name-->
</div>                                                                  <!-- ucfirst() first char uppercase -->
<div id="image">
    <img src="<?php echo $img; ?>">
</div>
<h3>4 Moves</h3>
<ul class="moves">
    <?php
    $i = 0;                                     // while loop to run the func as long as it remains true, which is 4
    while ($i < count($displayMoves)) {
        echo '<li>' . ucfirst($displayMoves[$i]) . '</li>';
        $i++;
    }
    ?>
</ul>
<h3>Previous Evolution</h3>
 <img src="<?php echo $prev_evo_img; ?>">

</body>
</html>