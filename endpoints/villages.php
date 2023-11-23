<?php

    function villages_endpoint_data( $data ) {
        $args = array(
            'post_type' => 'village',
            'posts_per_page' => -1,
            'post_status' => 'publish',
            'orderby' => 'title',
        );
        $villages = get_posts( $args );

        $the_villages = array();

        foreach( $villages as $village) {
            $region_id = (int)get_post_meta( $village->ID, 'region',true)[0];
            $region_name = get_the_title($region_id);

            $district_id = (int)get_post_meta( $village->ID, 'district',true)[0];
            $district_name = get_the_title($district_id);

            $county_id = (int)get_post_meta( $village->ID, 'county',true)[0];
            $county_name = get_the_title($county_id);

            $sub_county_id = (int)get_post_meta( $village->ID, 'sub_county',true)[0];
            $sub_county_name = get_the_title($sub_county_id);

            $parish_id = (int)get_post_meta( $village->ID, 'parish',true);
            $parish_name = get_the_title($parish_id);

            $sub_parish_id = (int)get_post_meta( $village->ID, 'sub_parish',true);
            $sub_parish_name = get_the_title($sub_parish_id);

            $the_villages[] = array(
                'id' => $village->ID,
                'name' => $village->post_title,
                'region' => (object) array(
                    'id' => $region_id > 0 ? $region_id : null,
                    'name' => !empty($region_name) ? $region_name : null
                ),
                'district' => (object) array(
                    'id' => $district_id > 0 ? $district_id : null,
                    'name' => !empty($district_name) ? $district_name : "",
                ),
                'county' => (object) array(
                    'id' => $county_id > 0 ? $county_id: null,
                    'name' => !empty($county_name) ? $county_name : "",
                ),
                'sub_county' => (object) array(
                    'id' => $sub_county_id > 0 ? $sub_county_id: null,
                    'name' => !empty($sub_county_name) ? $sub_county_name : "",
                ),
                'parish'=> (object) array(
                    'id' => $parish_id > 0 ? $parish_id: null,
                    'name' => !empty($parish_name) ? $parish_name : "",
                ),
                'sub_parish' => (object) array(
                    'id' => $sub_parish_id > 0 ? $sub_parish_id: null,
                    'name' => !empty($sub_parish_name) ? $sub_parish_name : "",
                )
            );
        }

        return new WP_REST_Response( [
            'result' => 'successful',
            'villages' => $the_villages,
            'total' => count($villages),
        ], 200 );
    }

    function add_villages_endpoint() {
        register_rest_route( 'v1', '/villages/', array(
            'methods'  => 'GET',
            'callback' => 'villages_endpoint_data',
        ) );
    }

    add_action( 'rest_api_init',  'add_villages_endpoint');
