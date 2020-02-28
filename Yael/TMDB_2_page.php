<html>
  <head>
    <title>Film</title>
    <meta charset="UTF-8">
    <link rel="stylesheet" type="text/css" href="style.css">
  </head>


  <body>
    <table>



<?php

require_once('tp3-helpers.php');


if ( isset( $_GET['ID'] ) ){
    $ID = $_GET['ID'];
}else{
    $ID = 550;
}

$JSON_originale = tmdbget('movie/' . $ID);



$content = json_decode($JSON_originale, true);
$titre = $content['title'];
$titre_original = $content['original_title'];

print_r($titre);

if (isset($content['tagline'])){
    $tag_line = $content['tagline'];
}
    $description = $content['overview'];
    $imdb_id = $content['imdb_id'];
    $url = 'https://www.imdb.com/title/' . $imdb_id . '/';

$j = 0;

echo "<p><span class = titre>Titre</span> " . $titre .  "</p>";
echo "<p><span class = titre>Titre Original</span> " . $titre_original .  "</p>";
if (isset($tag_line)){
    echo "<p><span class = titre>Tag Line</span> " . $tag_line .  "</p>";
}
echo "<p><span class = titre>Description</span> " . $description .  "</p>";
echo "<a href = " . $url . ">URL IMDB</a>";

?>

</table>
</body>
