<?php
    require_once("../utils/utils.php");
    
    $TLOR_movies_info = get_TLOR_infos();
    $TLOR_films_id = array();
    foreach($TLOR_movies_info as $index => $infos) {
        array_push($TLOR_films_id, $infos["id"]);
    }

    $TLOR_actors_info = get_TLOR_actors_info($TLOR_films_id);
?>

<!-- Affichage de la page avec les informations obtenues -->

<html>
    <head>
        <meta charset="utf-8">
        <title>Le Seigneur des Anneaux</title>
        <link rel="stylesheet" href="../utils/details_style.css">
    </head>

    <body>
        <table>
            <thead>
                <tr> <th>Acteur</th> <th>Rôle</th> <th>Films concernés</th> </tr>
            </thead>
            <tbody>
                <?php
                    foreach($TLOR_actors_info as $id_act => $infos) {
                        $actor = $infos["act_name"];
                        $character = $infos["char_name"];
                        $occured = $infos["nb_occ"];
                        echo("<tr> <td><a href='actor_details.php?id_act=$id_act'>$actor</a></td> <td>$character</td> <td>$occured</td> </tr>");
                    }
                ?>
            </tbody>
        </table>
    </body>
</html>