<?php

/*
La mejor opcion es apostar en [casa1], [casa2] e [casa3] por [team_01] (1), 
en [casa1] por el empate (X), y en [casa1] e [casa2] por [team_02] (2).
*/

function debug($var) {
    echo "<pre>"; print_r($var); echo "</pre>";
}

//Called by Ajax from App - list the event types from probabilidades
function event_types_content() {
    header('Content-Type: application/json; charset=UTF-8');
    $terms = get_terms("tipo-de-evento", ['hide_empty' => false]);
    $res = json_encode($terms);
    die($res); 
}
    
add_action('wp_ajax_event_types_content', 'event_types_content');
add_action('wp_ajax_nopriv_event_types_content', 'event_types_content');





/**
 * @return array list of current houses with Ids as keys, and a couple of names identifying names from Etl Service and Wordpress
 */
function getBettingHousesIds() {
    $args = array(
        'post_status' => 'any',
        'posts_per_page' => 1000,
        'post_type' => 'casa-apuesta',
    );

    $bettingHouses = get_posts($args);

    $housesIds = [];
    foreach ($bettingHouses as $bh) {
        switch($bh->post_name) {
            case "betsson-chile":
                $housesIds[$bh->ID] = ["etl_name" => "betsson", "post_name" => "betsson-chile"];
                break;
            case "apuesta-total":
                $housesIds[$bh->ID] = ["etl_name" => "apuesta-total", "post_name" => "apuesta-total"];
                break;
            case "timberazo":
                $housesIds[$bh->ID] = ["etl_name" => "timberazo", "post_name" => "timberazo"];
                break;
            case "sportimba":
                $housesIds[$bh->ID] = ["etl_name" => "sportimba", "post_name" => "sportimba"];
                break;
            case "netbet":
                $housesIds[$bh->ID] = ["etl_name" => "netbet", "post_name" => "netbet"];
                break;   
            case "geniobet":
                $housesIds[$bh->ID] = ["etl_name" => "geniobet", "post_name" => "geniobet"];
                break;
            default:
                break;
        }
    }

    return $housesIds;
}

/**
 * @param array $housesIds Houses Ids got from method getBettingHousesIds
 * @param string $houseEtlName name of the betting house came from Etl Service
 */
function getHouseIdByEtlName($housesIds, $houseEtlName) {
    foreach($housesIds as $houseId => $names) {
        if($names["etl_name"] == $houseEtlName)
            return $houseId;
    }

    return null;
}

/**
 * @param int $postId Id of the Probabilidad post_type
 * @return array List of PaganLasCasas post_type related to a Probabilidad
 */
function getBettingHousesByPost($postId) {
    $bettingHousesData = [];

    $args = array(
        'post_status' => 'publish',
        'posts_per_page' => 1000,
        'post_type' => 'pagan-las-casas',
        'meta_query' => array(array('key' => '_wpcf_belongs_probabilidades_id', 'value' => $postId))
    );

    $paganLasCasas = get_posts($args);

    foreach($paganLasCasas as $pc)
    {
        $bettingHouseId = get_post_meta($pc->ID, '_wpcf_belongs_casa-apuesta_id', true);

        $value1 = get_post_meta($pc->ID, 'wpcf-valor-1', true);
        $valueX = get_post_meta($pc->ID, 'wpcf-valor-x', true);
        $value2 = get_post_meta($pc->ID, 'wpcf-valor-2', true);
        
        $bettingHousesData[$pc->ID] = [
            "houseID" => $bettingHouseId,
            "value1" => $value1,
            "valueX" => $valueX,
            "value2" => $value2
        ];
    }

    return $bettingHousesData;
}

/**
 * @param int $relatedProbabilidadId Related Probabilidad Id for the creation of PaganLasCasas
 * @param int $relatedHouseId Related House Id for the creation of PaganLasCasas
 * @param array $events Events to be inserted for quotas
 */
function updatePaganLasCasas($relatedProbabilidadId, $relatedHouseId, $events) {
    // Create PaganLasCasas for the existent probabilidad
    $newPaganLasCasas = array(
        'post_title'    => "pagan-las-casas",
        'post_author' => 7, // Gian Franco
        'post_status'   => 'publish',
        'post_type'   => 'pagan-las-casas',
    );
    $newPaganLasCasasId = wp_insert_post($newPaganLasCasas);

    if($newPaganLasCasasId) {
        wp_update_post([
            "ID" => $newPaganLasCasasId,
            "post_title" => "pagan-las-casas $newPaganLasCasasId"
        ]);

        update_post_meta($newPaganLasCasasId, "_wpcf_belongs_probabilidades_id", $relatedProbabilidadId);
        update_post_meta($newPaganLasCasasId, "_wpcf_belongs_casa-apuesta_id", $relatedHouseId);

        updateEventsPaganLasCasas($newPaganLasCasasId, $events);
    }
}

/**
 * @param int $paganLasCasasId Id of PaganLasCasas post_type
 * @param array $events Events containing quotas from Etl Service
 * @param array|null $defaultData Optional, containing the old value of post_metas from existen PaganLasCasas post_type
 */
function updateEventsPaganLasCasas($paganLasCasasId, $events, $defaultData = []) {
    if(is_array($events)) {
        foreach ($events as $event) {
            switch($event["name"]) {
                case "W1":
                    if(isset($defaultData["value1"]))
                        update_post_meta($paganLasCasasId, "wpcf-valor-1", $event["price"], $defaultData["value1"]);
                    else
                        update_post_meta($paganLasCasasId, "wpcf-valor-1", $event["price"]);
                    break;
                case "X":
                    if(isset($defaultData["valueX"]))
                        update_post_meta($paganLasCasasId, "wpcf-valor-x", $event["price"], $defaultData["valueX"]);
                    else
                        update_post_meta($paganLasCasasId, "wpcf-valor-x", $event["price"]);
                    break;
                case "W2":
                    if(isset($defaultData["value2"]))
                        update_post_meta($paganLasCasasId, "wpcf-valor-2", $event["price"], $defaultData["value2"]);
                    else
                        update_post_meta($paganLasCasasId, "wpcf-valor-2", $event["price"]);
                    break;
            }
        }
    }
}

/**
 * @return array List of published|drafted Probabilidades from the wordpress site with Ids as keys
 */
function getPostGames() {
    $postGames = [];

    // Getting games from Wordpress
    $args = array(
        'post_type' => 'probabilidades',
        'posts_per_page' => 2000,
        'post_status' => ['publish', 'draft', 'auto-draft'],
        'orderby' => 'meta_value_num',
        'order' => 'DESC',
        'meta_key' => 'wpcf-fecha-probabilidad',
        'meta_compare' => '>=',
        'meta_value' => strtotime('30 days ago 00:00:00')
    );

    /*$tipoEvento = "";
    if($tipoEvento != "") {
        $args['tax_query'] = array(
            array(
                'taxonomy' => 'tipo-de-evento',
                'field' => 'id',
                'terms' => $tipoEvento
            )
        );
    }*/

    $loop = new WP_Query($args);
    if($loop->have_posts()) {
        while($loop->have_posts()) { 
            $loop->the_post();

            $postId = get_the_ID();
            $team1Meta = get_post_meta($postId, 'equipo_from_xml_1', true);
        	$team2Meta = get_post_meta($postId, 'equipo_from_xml_2', true);
            if($team1Meta && $team2Meta) {
                // $gameDate = get_post_meta($postId, 'wpcf-fecha-probabilidad', true); // unixtimestamp
                // debug([$t, date("d-m-Y", $gameDate)]);

                $postGames["$postId"] = [
                    "team1" => $team1Meta,
                    "team2" => $team2Meta,
                ];
            }
        }
    }

    return $postGames;
}

/**
 * @param array $terms list of tipo-de-evento terms where to search
 * @param string $termName the name of the tipo-de-evento to find
 * @return int|null the term_id found or null in case it's not found
 */
function searchTermByName($terms, $termName) {
    if($terms && count($terms) > 0 && $termName) {
        foreach($terms as $term) {
            if($term->name == $termName) {
                return $term->term_id;
            }
        }
    }

    return null;
}

/**
 * @param array $postGames List of Probabilidades got from method getPostGames
 */
function searchGameInPosts($postGames, $team1, $team2) {
    foreach ($postGames as $postId => $postData) {
        $team1Meta = get_post_meta($postId, 'equipo_from_xml_1', true);
        $team2Meta = get_post_meta($postId, 'equipo_from_xml_2', true);

        if(!empty($team1Meta) && !empty($team2Meta) &&
            $team1 == $team1Meta && $team2 == $team2Meta)
            return $postId;
        /*$haystack = [$postData["team1"], $postData["team2"]];
        if(in_array($team1, $haystack) && in_array($team2, $haystack))
            return $postId;*/
    }

    return null;
}

/**
 * @return string Reponse containing data from etl games
 */
function get_etl_games() {
    // create curl resource 
    $ch = curl_init(); 
    
    // set url 
    curl_setopt($ch, CURLOPT_URL, "http://165.227.125.9/cl/games");
    // set headers
    curl_setopt($ch, CURLOPT_HTTPHEADER, ['token: 563748b7edaa9ffa510e848010c1f3e4908c03b4' ]);

    //return the transfer as a string 
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);

    $output = curl_exec($ch); 
    
    if(curl_errno($ch)){
        $output = null;// 'Request Error:' . curl_error($ch);
    }

    // close curl resource to free up system resources 
    curl_close($ch);

    return $output;
}

/**
 * Imports data from etl service, insert the new "probabilidades" received and update the existent ones
 */
function import_from_etl() {
    // Getting events from Etl service
    $stringData = get_etl_games();
    if($stringData != null) {
        $jsonData = json_decode($stringData, true);

        $housesIds = getBettingHousesIds();
        $postGames = getPostGames();
        $terms = get_terms(["taxonomy" => "tipo-de-evento", 'parent' => 0, 'hide_empty' => false]);

        foreach($jsonData['competitions'] as $competitionData) {
            $competitionName = isset($competitionData['name']) ? $competitionData['name'] : "";

            foreach($competitionData['games'] as $gameData) {
                $gameDate = $gameData['date'];
                $team1Name = trim($gameData['team1']);
                $team2Name = trim($gameData['team2']);

                $postIdFound = searchGameInPosts($postGames, $team1Name, $team2Name);
                if($postIdFound) {
                    // Update probabilidad
                    debug("Updating Probabilidad: $postIdFound, " . $team1Name . " - " . $team2Name);

//                    $termId = searchTermByName($terms, $competitionName);
//                    if($termId)
//                        wp_set_post_terms($postIdFound, [$termId], 'tipo-de-evento');

                    wp_update_post(array(
                        'ID' => $postIdFound,
                        'post_content' => get_field('textos_theme_probabilidad', 'option', false),
                    ));

                    // The dates are in local hour of the game
                    /*if($gameDate) {
                        $probabilidadDate = get_post_meta($postId, 'wpcf-fecha-probabilidad', true); // unixtimestamp
                        $newDate = strtotime($gameDate);
                        if($newDate)
                            update_post_meta($postIdFound, 'wpcf-fecha-probabilidad', $newDate, $probabilidadDate);
                    }*/

                    $paganLasCasas = getBettingHousesByPost($postIdFound); // Get existen PaganLasCasas

                    // iterate over Etl houses
                    foreach ($gameData['houses'] as $houseName => $events) {
                        $houseId = getHouseIdByEtlName($housesIds, $houseName); // Getting houseID

                        if($houseId) {
                            $createPaganLasCasas = true;
                            foreach ($paganLasCasas as $pcID => $pcData) {
                                if($pcData["houseID"] == $houseId) {
                                    // Update Pagan las Casas
                                    updateEventsPaganLasCasas($pcID, $events, $pcData);

                                    $createPaganLasCasas = false;
                                    break;
                                }
                            }

                            if($createPaganLasCasas) {
                                updatePaganLasCasas($postIdFound, $houseId, $events);
                            }
                        }
                    }
                } else {
                    // Create probabilidad
                    debug("Creating Probabilidad: " . $team1Name . " - " . $team2Name);

                    $newProbabilidad = array(
                        'post_title'    => "$team1Name " . '&#8211;' . " $team2Name",
                        'post_author' => 7, // Gian Franco
                        'post_status'   => 'publish',
                        'post_type'   => 'probabilidades',
                        'post_content' => get_field('textos_theme_probabilidad', 'option', false),
                    );

                    $newProbabilidadId = wp_insert_post($newProbabilidad);
                    if($newProbabilidadId > 0) {
                        $termId = searchTermByName($terms, $competitionName);
                        if($termId)
                            wp_set_post_terms($newProbabilidadId, [$termId], 'tipo-de-evento');

                        $newDate = strtotime($gameDate);
                        if($newDate)
                            update_post_meta($newProbabilidadId, 'wpcf-fecha-probabilidad', $newDate);

                        update_post_meta($newProbabilidadId, 'equipo_from_xml_1', $team1Name);
                        update_post_meta($newProbabilidadId, 'equipo_from_xml_2', $team2Name);

                        // iterate over Etl houses
                        foreach ($gameData['houses'] as $houseName => $events) {
                            $houseId = getHouseIdByEtlName($housesIds, $houseName); // Getting houseID
                            
                            if($houseId) {
                                updatePaganLasCasas($newProbabilidadId, $houseId, $events);
                            }
                        }

                        $postGames["$newProbabilidadId"] = [
                            "team1" => $team1Name,
                            "team2" => $team2Name,
                        ];
                    }
                }
            }
        }
    }
}

/* // <url>/wp-admin/admin-ajax.php?action=import_from_etl
add_action('wp_ajax_import_from_etl', 'import_from_etl');
add_action('wp_ajax_nopriv_import_from_etl', 'import_from_etl');*/


remove_filter( 'the_content', 'wpautop' );
function wpse_wpautop_nobr( $content ) {
    return wpautop( $content, false );
}
add_filter( 'the_content', 'wpse_wpautop_nobr' );

/**
 * @param array $max_houses array of pagan-las-casas ids
 * @return string formatted houses names
 */
function format_best_houses($max_houses) {
	$to_show = "";
	foreach ($max_houses as $i => $pcId) {
		$h_id = get_post_meta($pcId, '_wpcf_belongs_casa-apuesta_id', true);
        $house = get_post($h_id);

        $link_juego = get_post_meta(($h_id), 'wpcf-url-juego', true);
    	$to_show .= "<a href='$link_juego' style='text-decoration: underline; font-weight: bold;'>" . $house->post_title . "</a>";
		if(count($max_houses) > 1) {
			if($i == count($max_houses) - 2) {
    			$to_show .= " y ";
        	} elseif($i < count($max_houses) - 1) {
        		$to_show .= ", ";
        	}	
		}
    }

    return $to_show;
}

remove_filter( 'the_content', 'wpautop' );
add_filter( 'the_content', 'wpautop' , 12);

global $global_max_values;
function wp_best_house_1() {
	global $global_max_values;
	$maximum_values = get_max_values_from_pagan_las_casas(get_the_id());
    
    $content = "<span class='data_read_fron_xml'>" . format_best_houses($maximum_values['max_house_1']) . "</span>";
    
    $global_max_values = $maximum_values;
    return $content;
}
add_shortcode('best_house_1', 'wp_best_house_1');

function wp_best_house_x() {
	global $global_max_values;
	if($global_max_values)
		$maximum_values = $global_max_values;
	else
		$maximum_values = get_max_values_from_pagan_las_casas(get_the_id());

    $content = "<span class='data_read_fron_xml'>" . format_best_houses($maximum_values['max_house_x']) . "</span>";

    $global_max_values = $maximum_values;
    return $content;
}
add_shortcode('best_house_x', 'wp_best_house_x');

function wp_best_house_2() {
	global $global_max_values;
	if($global_max_values)
		$maximum_values = $global_max_values;
	else
		$maximum_values = get_max_values_from_pagan_las_casas(get_the_id());

    $content = "<span class='data_read_fron_xml'>". format_best_houses($maximum_values['max_house_2']) . "</span>";

    $global_max_values = $maximum_values;
    return $content;
}
add_shortcode('best_house_2', 'wp_best_house_2');



//Schedule an action if it's not already scheduled
if ( ! wp_next_scheduled( 'etl_cron' ) ) {
    wp_schedule_event( strtotime('06:55:00'), 'daily', 'etl_cron' );
}
///Hook into that action that'll fire daily
add_action( 'etl_cron', 'import_from_etl' );

// Get the timestamp for the next event.
//$timestamp = wp_next_scheduled( 'etl_cron' );
//wp_unschedule_event( $timestamp, 'etl_cron' );

add_action('wp_ajax_etlcrons', 'etlcrons');
add_action('wp_ajax_nopriv_etlcrons', 'etlcrons');
function etlcrons() {
    debug(wp_next_scheduled( 'etl_cron' ));
    import_from_etl();
}
