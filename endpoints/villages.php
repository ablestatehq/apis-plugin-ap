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
            $region = get_post_meta( $village->ID, 'region',true);
            $district = get_post_meta( $village->ID, 'district',true);
            $county = get_post_meta( $village->ID, 'county',true);
            $sub_county = get_post_meta( $village->ID, 'sub_county',true);
            $parish = get_post_meta( $village->ID, 'parish',true);
            $sub_parish = get_post_meta( $village->ID, 'sub_parish',true);
            $sub_parish_post = get_post( $sub_parish );
            $sub_parish_name = $sub_parish_post->post_title;
            $the_villages[] = array(
                'id' => $village->ID,
                'name' => $village->post_title,
                'region' => $region,
                'district' => $district,
                'county' => $county,
                'sub_county' => $sub_county,
                'parish'=> $parish,
                'sub_parish' => (object) array(
                    'id' =>$sub_parish_name,
                    'name' => $sub_parish_name
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
