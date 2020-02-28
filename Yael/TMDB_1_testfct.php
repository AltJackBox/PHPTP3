<?php

    require_once('tp3-helpers.php');

    $content = tmdbget('movie/550',['language' => 'eng']);

    print_r(json_decode($content));

?>