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

function getMoves($allMoves){

    $arrFourRandMoves = array();
    $maxMoves = count($allMoves);   //count() count all elements in array
    if ($maxMoves > 4) {
        $fourMoves = 4;
                                    //only pick 4 moves but if any pokemon has fewer than 4, show them all
    } elseif ($maxMoves < 4) {      // e.g. Ditto
        $fourMoves = $maxMoves;
    }

    for($i = 0; $i < $fourMoves; $i++){      // loop through all possible moves and push 4 random ones to the array
        if ($maxMoves > 4){
            $randMove = floor(rand(0, $maxMoves));
            array_push($arrFourRandMoves, $allMoves[$randMove]['move']['name']);
        } elseif ($maxMoves < 4){
            array_push($arrFourRandMoves, $allMoves[$i]['move']['name']);
        }

    }
    return $arrFourRandMoves;
}

$displayMoves = getMoves($allMoves);        // make a var out of the func to use it in HTML and be able to index it


?>
<!DOCTYPE html>
<html lang="en" xmlns="http://www.w3.org/1999/html">
<body>
<div id="form">
    <form action="index.php" method="post">
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
        $i = 0;
        while ($i < count($displayMoves)) {
            echo '<li>' . ucfirst($displayMoves[$i]) . '</li>';
            $i++;
        }
        ?>
</ul>
</body>
</html>