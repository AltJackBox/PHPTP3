<html>
  <head>
    <title>Recherche de films</title>
    <meta charset="UTF-8">
    <link rel="stylesheet" type="text/css" href="style.css">
  </head>


  <body>



<?php

require_once('tp3-helpers.php');

if (isset($_GET['Search'])){
    $val = $_GET['Search'];
    $recherche = array( 'query' => $_GET['Search'] );
}else {
    $recherche = array( 'query' => 'The Lord of the Rings' );
}

$JSON_originale = tmdbget('search/movie', $recherche);
$content = json_decode($JSON_originale, true);


$nb_results = $content['total_results'];

$index = 0;

$id = array();
$array = array();

while ($index != $nb_results){ // On collectionne l'id des films résultant de la recherche
    $array = $content['results'][$index];
    $id[] = $array['id'];
    $index++;
}

$release_date = array();
$title = array();


// On cherche le premier film dans les résultats de la recherche qui appartient à une collection
// Si le premier résultat de la recherche n'appartient pas à une collection, on ne regarde pas les films suivants
// Le premier résultat est le plus pertinent
$JSON_originale_collec = tmdbget('movie/' . $id[0]);
$content_collec = json_decode($JSON_originale_collec, true);

if (isset( $content_collec['belongs_to_collection']['id'])){

    $id_collec =  $content_collec['belongs_to_collection']['id'];
    
    $JSON_originale_collec = tmdbget('collection/'. $id_collec);
    $content_collec = json_decode($JSON_originale_collec, true);

    $index = 0;

    $id_collec = array();

    while ($index != count( $content_collec['parts'])){
        $array =  $content_collec['parts'][$index];
        $id_collec[] = $array['id'];
        $title[] = $array['original_title'];
        $release_date[] = $array['release_date'];
        $index++;
    }
    $nb_results = count( $content_collec['parts']);
    $id = $id_collec;
}


if (count($title) == 0){ //Dans ce cas là, aucun des films n'appartient à une collection, donc on affiche les résultats de la recherche
    $index = 0;
    while ($index != $nb_results){
        $array = $content['results'][$index];
        $id[] = $array['id'];
        $release_date[] = $array['release_date'];
        $title[] = $array['original_title'];
        $index++;
    }
}


$index = 0;

while ($index != $nb_results){

    if (isset($title[$index])){
        echo "<p><span class = titre>Titre</span> " . $title[$index] .  "</p> \n";
    }
    if (isset($id[$index])){
        echo "<p><span class = titre>Id</span> " . $id[$index] .  "</p> \n";
    }
    if (isset($release_date[$index])){
        echo "<p><span class = titre>Date de sortie</span> " . $release_date[$index] .  "</p> \n";
        echo "<br> \n<br> \n";
    }
    
    $index++;

}

?>

</body>