<!-- récolte des informations de l'API en PHP -->

<?php
    if (!isset($_GET['id_film']) || $_GET['id_film'] == '') {
        //On a pas le paramètre get pour l'id du film, on redirige donc l'user. 
        header('Location: page_de_detail.html');
        exit();
    }

    //On récupère l'id du film
    $id_film = $_GET['id_film'];

    //Le json associé (en français)
    require_once('../tp3-helpers.php');
    $movie_info_json = tmdbget("movie/".$id_film,["language"=>"fr"]);
    $movie_info = json_decode($movie_info_json, true);
    
    //Comportement par défaut si la tagline n'existe aps
    if (!isset($movie_info["tagline"])) $movie_info["tagline"] = "";

    //On sauvegardes les informations essentielles
    $title = $movie_info["title"];
    $original_title = $movie_info["original_title"];
    $tagline = $movie_info["tagline"];
    $overview = $movie_info["overview"];
    $link = "https://www.themoviedb.org/movie/".$id_film;

    //Puis les informations supplémentaires.
    $poster = 'https://image.tmdb.org/t/p/original'.$movie_info["poster_path"];
?>

<!-- Affichage de la page avec les informations obtenues -->

<html>
    <head>
        <meta charset="utf-8">
        <title><?= $title ?></title>
        <style type="text/css">

        </style>
    </head>

    <body>
        <!-- titre -->
        <p><?=$title?></p>
        <!-- titre original -->
        <p><?=$original_title?></p>
        <!-- tagline -->
        <p><?=$tagline?></p>
        <!-- description -->
        <p><?=$overview?></p>
        <!-- lien vers la page TMDB -->
        <a href="<?=$link?>">lien vers TMDB</a>
        <!-- affiche -->
        <img src="<?=$poster?>"/>
    </body>
</html>