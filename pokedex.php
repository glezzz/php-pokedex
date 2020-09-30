<?php
//declare(strict_types = 1);

ini_Set('display_errors', 1);    // 1 true 0 false
ini_Set('display_startup_errors', 1);
error_reporting(E_ALL);

$pokemon = $_POST['id'];


if ($pokemon === null) {
    $pokemon = 1;
}

$getData = file_get_contents('https://pokeapi.co/api/v2/pokemon/' . $pokemon);
$data = (json_decode($getData, true));
//var_dump($data);
$name = $data['name'];
$img = $data['sprites']['front_default'];
echo $name;




?>
<!DOCTYPE html>
<html lang="en">
    <body>
    <div id = "form">
        <form action = "pokedex.php" method = "post">
            Pokemon: <input type = "text" name = "nameid" />
            <input type = "submit" />
        </form>
    </div>
    <div class="name">
        Name <?php echo $name;?>
    </div>
    <div id="image">
        <img src="<?php echo $img;?>">
    </div>
    </body>
</html>