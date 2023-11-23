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
            $region_id = (int)get_post_meta( $district->ID, 'region', true )[0];
            $region_name = get_the_title( $region_id );

            $the_districts[] = array(
                'id' => $district->ID,
                'name' => $district->post_title,
                'region' => (object) array(
                    'id' => $region_id > 0 ? $region_id : null,
                    'name' => !empty($region_name) ? $region_name : "",
                )
            );
        }

        return new WP_REST_Response( [
            'result' => 'successful',
            'districts' => $the_districts,
            'total' => count($districts),
        ], 200 );

    }

    function add_districts_endpoint() {
        register_rest_route( 'v1', '/districts/', array(
            'methods'  => 'GET',
            'callback' => 'districts_endpoint_data',
        ) );
    }

    add_action( 'rest_api_init',  'add_districts_endpoint');
