<?php
    // http://api.themoviedb.org/3/person/109/movie_credits?api_key=ebb02613ce5a2ae58fde00f4db95a9c1

    require_once("../utils/utils.php");

    if (!isset($_GET['id_act']) || $_GET['id_act'] == '') {
        //On a pas le paramètre get pour l'id de l'acteur, on redirige donc l'user. 
        header('Location: TLOR.php');
        exit();
    }

    //On récupère l'id de l'acteur et ses infos
    $id_act = $_GET['id_act'];
    $actor_info = get_actor_info($id_act);

    //On vérifie que l'acteur' existe bien, sinon on affiche un message d'erreur
    if (isset($actor_info["status_code"]) && $actor_info["status_code"] == 34) {
        echo("<b style='color:red'>L'acteur d'id $id_act n'existe pas !</b>");
        exit();
    }

    //Les informations supplémentaires.
    $photo = 'https://image.tmdb.org/t/p/original'.$actor_info["profile_path"];

    //On récupère le palmares de l'acteur
    $actor_credits = get_actor_credits($id_act);
?>

<!-- Affichage de la page avec les informations obtenues -->

<html>
    <head>
        <meta charset="utf-8">
        <title><?= $actor_info["name"] ?></title>
        <link rel="stylesheet" href="../utils/details_style.css">
    </head>

    <body>
        <header>
            <h1> <?= $actor_info["name"] ?> </h1>
            <?php if (isset($actor_info["profile_path"])) {?>
                <img src='<?=$photo?>'/>
            <?php } ?>
        </header>
        <table>
            <thead>
                <tr> <th>À joué dans ...</th> <th>Et interprété ...</th> </tr>
            </thead>
            <tbody>
                <?php
                    foreach($actor_credits as $i => $credits) {
                        echo("<tr> <td><a href='details.php?id_film=".$credits['id']."'>".$credits['title']."</a></td> <td>".$credits['character']."</td> </tr>");
                    }
                ?>
            </tbody>
        </table>
    </body>
</html>