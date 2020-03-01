<?php
    require_once('../../tp3-helpers.php');
    
    /**
     * Return the actor's info
     * @param integer $id_act actor's id
     * @return array $actor_infos containing the results like this : 
     * http://api.themoviedb.org/3/person/109?api_key=ebb02613ce5a2ae58fde00f4db95a9c1&language=fr
     */
    function get_actor_info($id_act) {
        $actor_infos_json = tmdbget("person/".$id_act,["language"=>"fr"]);
        $actor_infos = json_decode($actor_infos_json, true);
        return $actor_infos;
    }
    
    /**
     * Return the actor's credits
     * @param integer $id_act actor's id
     * @return array $actor_credits containing the results like this : 
     * http://api.themoviedb.org/3/person/109/movie_credits?api_key=ebb02613ce5a2ae58fde00f4db95a9c1&language=fr          
     */
    function get_actor_credits($id_act) {
        $actor_credits_json = tmdbget("person/".$id_act."/movie_credits",["language"=>"fr"]);
        $actor_credits = json_decode($actor_credits_json, true);
        return $actor_credits['cast'];
    }

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
     * Return the youtube trailer of a movie with the given id
     * @param string $id_film the film's id
     * @return string $ytb_link the youtube link if the ytb exists.
     */
    function get_trailer_link(string $id_film) {
        //http://api.themoviedb.org/3/movie/121/videos?api_key=ebb02613ce5a2ae58fde00f4db95a9c1&language=fr
        $video_info_json = tmdbget("movie/".$id_film."/videos",["language"=>"fr"]);
        $video_info = json_decode($video_info_json, true);
        if (isset($video_info["results"][0]["key"])) {
            return 'https://www.youtube.com/embed/'.$video_info["results"][0]["key"];
        } else {
            return "";
        }
    }

    /**
     * Returns the infos about the collection of The Lord of The Rings
     * @return array TLOR_infos(0 => the first episode, ...) 
     */
    function get_TLOR_infos() {
        $collection_result_json = tmdbget("search/collection",["query"=>"The+Lord+of+the+Rings+Collection"]);
        $collection_result = json_decode($collection_result_json, true);
        $query_result_json = tmdbget("collection/".$collection_result["results"][0]['id'],["language"=>"fr"]);
        $query_result = json_decode($query_result_json, true);
        $TLOR_infos = array();
        foreach($query_result["parts"] as $index => $infos) {
            array_push($TLOR_infos, json_decode(tmdbget("movie/".$infos["id"]),true));
        }
        return $TLOR_infos;
    }

    /**
     * Return minimal infos about actors in TLOR, in an array
     * @param array $film_ids contains all the films' ids
     * @return array TLOR_actors(actor_id => array(act_name, char_name, nb_occ), actor_id => ... )
     */
    function get_TLOR_actors_info($film_ids) {
        //http://api.themoviedb.org/3/movie/120/credits?api_key=ebb02613ce5a2ae58fde00f4db95a9c1
        $TLOR_actors = array();
        foreach($film_ids as $i => $film_id) {
            $query_result_json = tmdbget("movie/".$film_id."/credits");
            $query_result = json_decode($query_result_json, true);
            foreach($query_result["cast"] as $i_cast => $cast) {
                if (isset($TLOR_actors[$cast['id']])) {
                    $TLOR_actors[$cast['id']]['nb_occ']++;
                } else {
                    $insert = array("act_name"=>$cast["name"], "char_name"=>$cast["character"], "nb_occ"=>1);
                    $TLOR_actors[$cast['id']] = $insert;
                }
            }
        }
        return $TLOR_actors;        
    }
?>