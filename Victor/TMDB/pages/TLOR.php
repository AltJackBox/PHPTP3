<!-- récolte des informations de l'API en PHP -->

<?php
    require_once("../utils/utils.php");

    //Récupère les infos sur la trilogie
    $TLOR_movies_info = get_TLOR_infos();
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
                <tr> <th>ID</th> <th>Date de sortie</th> <th>Titre</th> </tr>
            </thead>
            <tbody>
                <?php
                    foreach($TLOR_movies_info as $index => $infos) {
                        $id = $infos["id"];
                        $link = "details.php?id_film=$id";
                        $release_date = $infos["release_date"];
                        $title = $infos["original_title"];
                        echo("<tr> <td><a href='$link'>$id<a></td> <td>$release_date</td> <td>$title</td> </tr>");
                    }
                ?>
            </tbody>
        </table>
    </body>
</html>