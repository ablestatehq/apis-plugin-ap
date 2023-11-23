<?php

    function counties_endpoint_data( $data ) {
        $args = array(
            'post_type' => 'county',
            'posts_per_page' => -1,
            'post_status' => 'publish',
            'orderby' => 'title',
        );

        $counties = get_posts( $args );

        $the_counties = array();

        foreach( $counties as $county) {
            $region_id = (int)get_post_meta( $county->ID, 'region',true)[0];
            $region_name = get_the_title($region_id);

            $district_id = (int) get_post_meta( $county->ID, 'district',true)[0];
            $district_name = get_the_title($district_id);

            $the_counties[] = array(
                'id' => $county->ID,
                'name' => $county->post_title,
                'region' => (object) array(
                    'id' => $region_id > 0 ? $region_id : null,
                    'name' => !empty($region_name) ? $region_name : null
                ),
                'district' => (object) array(
                    'id' => $district_id > 0 ? $district_id : null,
                    'name' => !empty($district_name) ? $district_name : "",
                ),
            );
        }

        return new WP_REST_Response( [
            'result' => 'successful',
            'counties' => $the_counties,
            'total' => count($counties),
        ], 200 );
    }

    function add_counties_endpoint() {
        register_rest_route( 'v1', '/counties/', array(
            'methods'  => 'GET',
            'callback' => 'counties_endpoint_data',
        ) );
    }

    add_action( 'rest_api_init',  'add_counties_endpoint');
