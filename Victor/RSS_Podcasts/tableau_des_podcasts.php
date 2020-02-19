<?php
    require_once('vendor/dg/rss-php/src/Feed.php');
    $rss = Feed::loadRss('http://radiofrance-podcast.net/podcast09/rss_14312.xml');
?>

<html>
    <head>
        <meta charset="utf-8">
        <title>🎤 Podcasts</title>
        <style type="text/css">
            table, td, tr {
                border : 1px solid black;
            }
        </style>
    </head>

    <body>
        <table>
            <thead>
                <tr>
                    <th>Date</th>
                    <th>Titre</th>
                    <th>Audio</th>
                    <th>Durée</th>
                    <th>Téléchargement</th>
                </tr>
            </thead>
            <tbody>
                <?php
                foreach ($rss->item as $item) {
                    $audio_link = $item->enclosure->attributes()['url'];
                    printf("<tr>
                    <td>%s</td>
                    <td title='%s'>%s : <a href='%s'>voir</a></td>
                    <td> <audio controls='controls' preload='none'> <source src='%s.mp3' type='audio/mp3'/>Votre navigateur ne supporte pas la balise AUDIO.</audio> </td>
                    <td>%s</td> 
                    <td> <a href='%s' download='Podcast'>Download podcast</a> </td>
                    </tr>",
                    $item->pubDate,
                    $item->description, $item->title, $item->link,
                    $audio_link,
                    $item->{'itunes:duration'},
                    $audio_link
                );
                }
                ?>
            </tbody>
        </table>
    </body>
</html>