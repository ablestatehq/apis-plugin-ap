<?php

    function regions_endpoint_data( $data ) {
        $args = array(
            'post_type' => 'region',
            'posts_per_page' => -1,
            'post_status' => 'publish',
            'orderby' => 'title',
        );

        $regions = get_posts( $args );

        $the_regions = array();

        foreach( $regions as $region) {
            $the_regions[] = array(
                'id' => $region->ID,
                'name' => $region->post_title,
            );
        }

        return new WP_REST_Response( [
            'result' => 'successful',
            'regions' => $the_regions,
            'total' => count($regions),
        ], 200 );
    }

    function add_regions_endpoint() {
        register_rest_route( 'v1', '/regions/', array(
            'methods'  => 'GET',
            'callback' => 'regions_endpoint_data',
        ) );
    }

    add_action( 'rest_api_init',  'add_regions_endpoint');
