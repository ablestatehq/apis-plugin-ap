<?php

    function tourist_attractions_endpoint_data( $data ) {
        $args = array(
            'post_type' => 'tourist-attraction',
            'posts_per_page' => -1,
            'post_status' => 'publish',
            'orderby' => 'title',
        );

        $tourist_attractions = get_posts( $args );

        $the_tourist_attractions = array();

        foreach( $tourist_attractions as $tourist_attraction) {
            $region_ids_arr = get_post_meta( $tourist_attraction->ID, 'regions', true);

            foreach($region_ids_arr as $region_id) {
                $regions[]['id'] = $region_id;
                $regions[]['name'] = get_the_title($region_id);
            }

            $district_ids_arr = get_post_meta( $tourist_attraction->ID, 'districts', true);

            foreach($district_ids_arr as $district_id) {
                $districts[]['id'] = $district_id;
                $districts[]['name'] = get_the_title($district_id);
            }

            $county_ids_arr = get_post_meta( $tourist_attraction->ID, 'counties', true);

            $sub_county_ids_arr = get_post_meta( $tourist_attraction->ID, 'sub-counties', true);

            $parish_ids_arr = get_post_meta( $parish->ID, 'parishes', true);

            $sub_parish_ids_arr = get_post_meta( $parish->ID, 'sub-parishes', true);

            $village_ids_arr = get_post_meta( $parish->ID, 'villages', true);

            $native_name = get_post_meta( $tourist_attraction->ID, 'native-name', true);

            $adapted_name = get_post_meta( $tourist_attraction->ID, 'adapted-name', true);

            $photo = get_post_meta( $tourist_attraction->ID, 'photo', true);

            $video = get_post_meta( $tourist_attraction->ID, 'video', true);

            $the_tourist_attractions[] = array(
                'id' => $tourist_attraction->ID,
                'name' => $tourist_attraction->post_title,
                'regions' => (object) $regions,
                'districts' => (object) $districts,
            );
        }

        return new WP_REST_Response( [
            'result' => 'successful',
            'tourist_attractions' => $the_tourist_attractions,
            'total' => count($the_tourist_attractions),
        ], 200 );
    }

    function add_tourist_attractions_endpoint() {
        register_rest_route( 'v1', '/tourist-attractions/', array(
            'methods'  => 'GET',
            'callback' => 'tourist_attractions_endpoint_data',
        ) );
    }

    add_action( 'rest_api_init',  'add_tourist_attractions_endpoint');
