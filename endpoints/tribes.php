<?php

    function tribes_endpoint_data( $data ) {
        $args = array(
            'post_type' => 'tribe',
            'posts_per_page' => -1,
            'post_status' => 'publish',
            'orderby' => 'title',
        );

        $tribes = get_posts( $args );

        $the_tribes = array();

        foreach( $tribes as $tribe) {
            $region_id = (int)get_post_meta( $tribe->ID, 'origin_region', true )[0];
            $region_name = get_the_title( $region_id );

            $the_tribes[] = array(
                'id' => $tribe->ID,
                'name' => $tribe->post_title,
                'origin-region' => (object) [
                    'id' => $region_id > 0 ? $region_id : null,
                    'name' => !empty($region_name) ? $region_name : "",
                ]
            );
        }

        return new WP_REST_Response( [
            'result' => 'successful',
            'tribes' => $the_tribes,
            'total' => count($tribes),
        ], 200 );
    }

    function add_tribes_endpoint() {
        register_rest_route( 'v1', '/tribes/', array(
            'methods'  => 'GET',
            'callback' => 'tribes_endpoint_data',
        ) );
    }

    add_action( 'rest_api_init',  'add_tribes_endpoint');
