<!-- récolte des informations de l'API en PHP -->

<?php
    require_once("../utils/utils.php");

    if (!isset($_GET['id_film']) || $_GET['id_film'] == '') {
        //On a pas le paramètre get pour l'id du film, on redirige donc l'user. 
        header('Location: page_de_detail.html');
        exit();
    }

    //On récupère l'id du film et ses infos en VO, EN, VF
    $id_film = $_GET['id_film'];
    $movie_info = get_movie_info($id_film);
    $lang = array(0 => "vo", 1 => "en", 2 => "vf");

    //On vérifie que le film existe bien, sinon on affiche un message d'erreur
    if (isset($movie_info[$lang[0]]["status_code"]) && $movie_info[$lang[0]]["status_code"] == 34) {
        echo("<b style='color:red'>Le film d'id $id_film n'existe pas !</b>");
        exit();
    }
    
    //Comportement par défaut si la tagline n'existe pas
    if (!isset($movie_info[$lang[0]]["tagline"])) {
        foreach($lang as $key => $value)
            $movie_info[$value]["tagline"] = "";
    }

    //On met de côté les informations du json qui nous interesse :
    $infos = array(0 => "title", 1 => "tagline", 2 => "overview", 3 => "link");

    //Les informations supplémentaires.
    $poster = 'https://image.tmdb.org/t/p/original'.$movie_info[$lang[0]]["poster_path"];
    // pour les autres configurations :
    // http://api.themoviedb.org/3/configuration?api_key=ebb02613ce5a2ae58fde00f4db95a9c1
?>

<!-- Affichage de la page avec les informations obtenues -->

<html>
    <head>
        <meta charset="utf-8">
        <title><?= $title ?></title>
        <link rel="stylesheet" href="../utils/details_style.css">
    </head>

    <body>
        <table>
            <thead>
                <tr> <th>VO</th> <th>EN</th> <th>VF</th> </tr>
            </thead>
            <tbody>
                <?php
                    foreach($infos as $index => $info_name) {
                        echo("<tr>");
                        foreach($lang as $key => $version) {
                            echo("<td>");
                            if ($info_name == "link") {
                                $language = "";
                                if ($version == "vf") $language = "fr-FR";
                                if ($version == "en") $language = "en-EN";
                                echo("<a href='https://www.themoviedb.org/movie/".$id_film."?language=".$language."'>".$movie_info[$version][$info_name]."voir l'affiche ici</a>");
                            } else {
                                echo("<p>".$movie_info[$version][$info_name]."</p>");
                            }
                            echo("</td>");
                        }
                        echo("</tr>");
                    }
                ?>
            </tbody>
        </table>
        <!-- affiche -->
        <img src="<?=$poster?>"/>
    </body>
</html>