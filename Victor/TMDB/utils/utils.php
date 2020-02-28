<?php
    require_once('../../tp3-helpers.php');

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

    /**
     * Returns the infos about the trilogy of The Lord of The Rings
     * @return array TLOR_infos(0 => the first episode, ...) 
     */
    function get_TLOR_infos() {
        $query_result_json = tmdbget("search/movie",["query"=>"The+Lord+of+the+Rings"]);
        $query_result = json_decode($query_result_json, true);
        $TLOR_infos = array();
        foreach($query_result["results"] as $index => $infos) {
            if (strpos($infos["original_title"], 'The Lord of the Rings: ') !== false)
                array_push($TLOR_infos, json_decode(tmdbget("movie/".$infos["id"]),true));
        }
        return $TLOR_infos;
    }
?>