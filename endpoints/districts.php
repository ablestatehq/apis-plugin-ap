<?php

    function districts_endpoint_data( $data ) {
        $args = array(
            'post_type' => 'district',
            'posts_per_page' => -1,
            'post_status' => 'publish',
            'orderby' => 'title',
        );
        $districts = get_posts( $args );

        $the_districts = array();

        foreach( $districts as $district) {
            $the_districts[] = array(
                'id' => $district->ID,
                'name' => $district->post_title,
            );
        }

        return new WP_REST_Response( [
            'result' => 'successful',
            'districts' => $the_districts,
            'total' => count($districts),
        ], 200 );
        return new WP_REST_Response( 'Your response districts', 200 );
    }

    function add_districts_endpoint() {
        register_rest_route( 'v1', '/districts/', array(
            'methods'  => 'GET',
            'callback' => 'districts_endpoint_data',
        ) );
    }

    add_action( 'rest_api_init',  'add_districts_endpoint');
