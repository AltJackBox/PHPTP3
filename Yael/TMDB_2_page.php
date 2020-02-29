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

$languages = array('Originale' , 'Française', 'Anglaise');
$languages_tab = array(['language' => 'fr'], ['language' => 'eng']);
$titre = array();
$titre_original = array();
$tag_line = array();
$description = array();
$imdb_id = array();
$poster;

$JSON_originale = tmdbget('movie/' . $ID);

$content = json_decode($JSON_originale, true);

print_r($content);
$titre[] = $content['title'];
$titre_original[] = $content['original_title'];

if (isset($content['tagline'])){
    $tag_line[] = $content['tagline'];
} else{
    $tag_line[] = " ";
}
    $description[] = $content['overview'];
    $imdb_id[] = $content['imdb_id'];

    $poster = $content['poster_path'];
    $image = 'https://image.tmdb.org/t/p/original/' . $poster;

foreach ($languages_tab as $value){
    $JSON_originale = tmdbget('movie/' . $ID, $value);
    $content = json_decode($JSON_originale, true);
    $titre[] = $content['title'];
    $titre_original[] = $content['original_title'];

    if (isset($content['tagline'])){
        $tag_line[] = $content['tagline'];
    } else{
        $tag_line[] = " ";
    }
    $description[] = $content['overview'];
    $imdb_id[] = $content['imdb_id'];
}

echo "<tr class=" . "normale" .">\n";
echo "<td>VERSION ORIGINALE</td> \n" ;
echo  "<td>VERSION FRANCAISE</td> \n" ;
echo  "<td>VERSION ANGLAISE</td> \n" ;
echo "</tr>\n";

$j = 0;

echo "<tr class=" . "normale" .">\n";
while ($j != 3){
    echo "<td><p><span class = titre>Titre</span> " . $titre[$j] .  "</p></td> \n";
    $j++;
}
echo "</tr>\n";

$j = 0;

echo "<tr class=" . "normale" .">\n";
while ($j != 3){
    echo  "<td><p><span class = titre>Titre Original</span> " . $titre_original[$j] . "</p></td> \n" ;
    $j++;
}
echo "</tr>\n";

$j = 0;

echo "<tr class=" . "normale" .">\n";
while ($j != 3){
    echo  "<td><p><span class = titre>Tag Line</span> " . $tag_line[$j] . "</p></td> \n" ;
    $j++;
}
echo "</tr>\n";

$j = 0;

echo "<tr class=" . "normale" .">\n";
while ($j != 3){
    echo  "<td><p><span class = titre>Description</span> " . $description[$j] . "</p></td> \n" ;
    $j++;
}
echo "</tr>\n";

$j = 0;

echo "<tr class=" . "normale" .">\n";
while ($j != 3){
    $url = 'https://www.imdb.com/title/' . $imdb_id[$j] . '/';
    echo  "<td><a href = " . $url . ">Link</a></td> \n" ;
    $j++;
}
echo "</tr>\n";


list($width, $height, $type, $attr) = getimagesize($image);
$height = $height / 4;
$width = $width / 4;

?>

</table>
<img src="<?=$image?>" height="<?=$height?>" width="<?=$width?>" />
</body>
