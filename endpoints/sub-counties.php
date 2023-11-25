<?php

    function sub_counties_endpoint_data( $data ) {
        $args = array(
            'post_type' => 'sub-county',
            'posts_per_page' => -1,
            'post_status' => 'publish',
            'orderby' => 'title',
        );

        $sub_counties = get_posts( $args );

        $the_sub_counties = array();

        foreach( $sub_counties as $sub_county) {
            $region_id = (int)get_post_meta( $sub_county->ID, 'region', true)[0];
            $region_name = get_the_title($region_id);

            $district_id = (int) get_post_meta( $sub_county->ID, 'district', true)[0];
            $district_name = get_the_title($district_id);

            $county_id = (int) get_post_meta( $sub_county->ID, 'county', true)[0];
            $county_name = get_the_title($county_id);

            $the_sub_counties[] = array(
                'id' => $sub_county->ID,
                'name' => $sub_county->post_title,
                'region' => (object) array(
                    'id' => $region_id > 0 ? $region_id : null,
                    'name' => !empty($region_name) ? $region_name : null
                ),
                'district' => (object) array(
                    'id' => $district_id > 0 ? $district_id : null,
                    'name' => !empty($district_name) ? $district_name : "",
                ),
                'county' => (object) array(
                    'id' => $county_id > 0 ? $county_id : null,
                    'name' => !empty($county_name) ? $county_name : "",
                ),
            );
        }

        return new WP_REST_Response( [
            'result' => 'successful',
            'subcounties' => $the_sub_counties,
            'total' => count($the_sub_counties),
        ], 200 );
    }

    function add_sub_counties_endpoint() {
        register_rest_route( 'v1', '/sub-counties/', array(
            'methods'  => 'GET',
            'callback' => 'sub_counties_endpoint_data',
        ) );
    }

    add_action( 'rest_api_init',  'add_sub_counties_endpoint');
