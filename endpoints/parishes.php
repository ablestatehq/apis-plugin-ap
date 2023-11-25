<?php

    function parishes_endpoint_data( $data ) {
        $args = array(
            'post_type' => 'parish',
            'posts_per_page' => -1,
            'post_status' => 'publish',
            'orderby' => 'title',
        );

        $parishes = get_posts( $args );

        $the_parishes = array();

        foreach( $parishes as $parish) {
            $region_id = (int) get_post_meta( $parish->ID, 'region', true)[0];
            $region_name = get_the_title($region_id);

            $district_id = (int) get_post_meta( $parish->ID, 'district', true)[0];
            $district_name = get_the_title($district_id);

            $county_id = (int) get_post_meta( $parish->ID, 'county', true)[0];
            $county_name = get_the_title($county_id);

            $sub_county_id = (int) get_post_meta( $parish->ID, 'sub-county', true)[0];
            $sub_county_name = get_the_title($sub_county_id);

            $the_parishes[] = array(
                'id' => $parish->ID,
                'name' => $parish->post_title,
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
                'subcounty' => (object) array(
                    'id' => $sub_county_id > 0 ? $sub_county_id : null,
                    'name' => !empty($sub_county_name) ? $sub_county_name : "",
                ),
            );
        }

        return new WP_REST_Response( [
            'result' => 'successful',
            'parishes' => $the_parishes,
            'total' => count($the_parishes),
        ], 200 );
    }

    function add_parishes_endpoint() {
        register_rest_route( 'v1', '/parishes/', array(
            'methods'  => 'GET',
            'callback' => 'parishes_endpoint_data',
        ) );
    }

    add_action( 'rest_api_init',  'add_parishes_endpoint');
