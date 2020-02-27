<?php
    require_once('../tp3-helpers.php');

    /**
     * Return infos in 3 languages : VO, EN, VF with a given film id
     * @param string $id_film the film's id
     * @return array movie_info(["vf"]=>..., ["vo"]=>..., ["en"]=>...)
     */
    function get_movie_info(string $id_film) {
        $movie_info_json = array("vf" => tmdbget("movie/".$id_film,["language"=>"fr"]),
                                "en" => tmdbget("movie/".$id_film,["language"=>"en"]),
                                "vo" => tmdbget("movie/".$id_film));
        $movie_info = array("vf" => json_decode($movie_info_json["vf"], true),
                            "en" => json_decode($movie_info_json["en"], true),
                            "vo" => json_decode($movie_info_json["vo"], true));
        return $movie_info;
    }
?>