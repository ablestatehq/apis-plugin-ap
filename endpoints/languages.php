<?php

    function languages_endpoint_data( $data ) {
        $args = array(
            'post_type' => 'language',
            'posts_per_page' => -1,
            'post_status' => 'publish',
            'orderby' => 'title',
        );

        $languages = get_posts( $args );

        $the_languages = array();

        foreach( $languages as $language) {
            $tribe_id = (int)get_post_meta( $language->ID, 'tribe', true )[0];
            $tribe_name = get_the_title( $tribe_id );

            $region_of_origin_id = (int) get_post_meta( $language->ID, 'region_of_origin', true)[0];
            $region_of_origin_name = get_the_title( $region_of_origin_id );

            $international = get_post_meta( $language->ID, 'international', true);
            $regional = get_post_meta( $language->ID, 'regional', true);
            $national = get_post_meta( $language->ID, 'national', true);
            $endangered = get_post_meta( $language->ID, 'endangered', true);

            $the_languages[] = array(
                'id' => $language->ID,
                'name' => $language->post_title,
                'tribe' => (object) [
                    "id" => $tribe_id > 0 ? $tribe_id : null,
                    'name' => !empty($tribe_name) ? $tribe_name: "",
                ],
                'region_of_origin' => (object) [
                    'id' => $region_of_origin_id > 0 ? $region_of_origin_id : null,
                    'name' => !empty($region_of_origin_name) ? $region_of_origin_name : "",
                ],
                'international' => $international === "1" ? "yes" : "no",
                'regional' => $regional=== "1" ? "yes" : "no",
                'national' => $national === "1" ? "yes" : "no",
                'endangered' => $endangered === "1" ? "yes" : "no",

            );
        }

        return new WP_REST_Response( [
            'result' => 'successful',
            'languages' => $the_languages,
            'total' => count($languages),
        ], 200 );
    }

    function add_languages_endpoint() {
        register_rest_route( 'v1', '/languages/', array(
            'methods'  => 'GET',
            'callback' => 'languages_endpoint_data',
        ) );
    }

    add_action( 'rest_api_init',  'add_languages_endpoint');
