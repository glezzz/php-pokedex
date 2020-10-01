<?php
declare(strict_types=0);

ini_Set('display_errors', 1);    // 1 true 0 false
ini_Set('display_startup_errors', 1);
error_reporting(E_ALL);

global $pokemon;
// get input from form
if (isset($_GET['nameid'])) {
    $pokemon = $_GET['nameid'];
} else {
    $pokemon = 1;
}


//fetch data
$get_data = file_get_contents('https://pokeapi.co/api/v2/pokemon/' . $pokemon);
$data = (json_decode($get_data, true));
//var_dump($data);
$name = $data['name'];
$poke_id = $data['id'];
$img = $data['sprites']['front_default'];
$all_moves = $data['moves'];

//get moves
function getMoves($all_moves)
{

    $arr_four_rand_moves = array();
    $max_moves = count($all_moves);   //count() count all elements in array
    if ($max_moves > 4) {
        $four_moves = 4;
        //only pick 4 moves but if any pokemon has fewer than 4, show them all
    } else {                        // e.g. Ditto
        $four_moves = $max_moves;
    }

    for ($i = 0; $i < $four_moves; $i++) {      // loop through all possible moves and push 4 random ones to the array
        if ($max_moves > 4) {
            $rand_move = floor(rand(0, $max_moves));
            array_push($arr_four_rand_moves, $all_moves[$rand_move]['move']['name']);
        } elseif ($max_moves < 4) {
            array_push($arr_four_rand_moves, $all_moves[$i]['move']['name']);
        }

    }
    return $arr_four_rand_moves;

}

$display_moves = getMoves($all_moves);        // make a var out of the func to use it in HTML and be able to index it


function getEvo($pokemon)
{
    //fetch evolution data
    $get_evo_data = file_get_contents('https://pokeapi.co/api/v2/pokemon-species/' . $pokemon);
    $evo_data = (json_decode($get_evo_data, true));
    $prev_evo = $evo_data['evolves_from_species'];

    if ($prev_evo) {         // if pokemon has a previous evolution,
        $prev_evo_name = $prev_evo['name'];            //fetch data of previous evolution
        $get_prev_evo_data = file_get_contents('https://pokeapi.co/api/v2/pokemon/' . $prev_evo_name);
        $prev_evo_data = (json_decode($get_prev_evo_data, true));
        $prev_evo_img = $prev_evo_data['sprites']['front_default'];     //get sprite from previous evolution
        return ($prev_evo_img);

    } else {


    }

}

getEvo($pokemon);
$prev_evo_img = getEvo($pokemon);     // we need to use it in HTML img tag


?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
    <meta http-equiv="X-UA-Compatible" content="ie=edge"/>
    <title>Pokédex</title>
    <link rel="stylesheet" href="styles.css" type="text/css">
    <title>Pokédex</title>
<body>
<div>
    <div class="container" id="pokedex"
    <div id="form">
        <form action="index.php" method="get">
            Pokémon or ID: <input type="text" name="nameid"/>
            <input type="submit"/>
        </form>
    </div>
    <div class="stats-display">
        <h2><?php echo $poke_id;
            echo '&nbsp;';
            echo ucfirst($name); ?></h2>  <!-- &nbsp (Non-Breakable Space) whitespace between id & name-->
        <div id="image">                            <!-- ucfirst() first char uppercase -->
            <img src="<?php echo $img; ?>">
        </div>
        <h3>4 Moves</h3>
        <ul class="moves">
            <?php
            $i = 0;                                     // while loop to run the func as long as it remains true, which is 4
            while ($i < count($display_moves)) {
                echo '<li>' . ucfirst($display_moves[$i]) . '</li>';
                $i++;
            }
            ?>
        </ul>
        <h3>Previous Evolution</h3>
        <img src="<?php echo $prev_evo_img; ?>">
    </div>
</div>
</body>
</html>