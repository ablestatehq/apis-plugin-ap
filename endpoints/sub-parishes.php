<?php

    function sub_parishes_endpoint_data( $data ) {
        $args = array(
            'post_type' => 'sub-parish',
            'posts_per_page' => -1,
            'post_status' => 'publish',
            'orderby' => 'title',
        );

        $sub_parishes = get_posts( $args );

        $the_sub_parishes = array();

        foreach( $sub_parishes as $sub_parish) {
            $region_id = (int) get_post_meta( $sub_parish->ID, 'region', true)[0];
            $region_name = get_the_title($region_id);

            $district_id = (int) get_post_meta( $sub_parish->ID, 'district', true)[0];
            $district_name = get_the_title($district_id);

            $county_id = (int) get_post_meta( $sub_parish->ID, 'county', true)[0];
            $county_name = get_the_title($county_id);

            $sub_county_id = (int) get_post_meta( $sub_parish->ID, 'sub-county', true)[0];
            $sub_county_name = get_the_title($sub_county_id);

            $parish_id = (int) get_post_meta( $parish->ID, 'parish', true)[0];
            $parish_name = get_the_title($parish_id);

            $the_sub_parishes[] = array(
                'id' => $sub_parish->ID,
                'name' => $sub_parish->post_title,
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
                'parish' => (object) array(
                    'id' => $parish_id > 0 ? $parish_id : null,
                    'name' => !empty($parish_name) ? $parish_name : "",
                ),
            );
        }

        return new WP_REST_Response( [
            'result' => 'successful',
            'subparishes' => $the_sub_parishes,
            'total' => count($the_sub_parishes),
        ], 200 );
    }

    function add_sub_parishes_endpoint() {
        register_rest_route( 'v1', '/sub-parishes/', array(
            'methods'  => 'GET',
            'callback' => 'sub_parishes_endpoint_data',
        ) );
    }

    add_action( 'rest_api_init',  'add_sub_parishes_endpoint');
