<?php
    //lien : http://api.themoviedb.org/3/movie/550?api_key=ebb02613ce5a2ae58fde00f4db95a9c1&language=fr
    require_once('../tp3-helpers.php');
    $movie_info_json = tmdbget("movie/550",["language=fr"]);
    print_r($movie_info_json);
?>