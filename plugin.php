<?php
    /**
     * Plugin Name: UG GEO APIS
     * Description: Access resourceful data from this open api to ease the development of your next project
     * version: 0.0.1
     * tags: Regions, Districts, Counties, Sub counties, Parish, Sub Parishes, Villages
     * Plugin URI: https://ugopenapis.com
    */


    // Modify REST API URL prefix
    function my_rest_url_prefix( $slug ) {
        return 'api'; // Change 'api' to your desired prefix
    }

    add_filter( 'rest_url_prefix', 'my_rest_url_prefix' );

    // Function to flush rewrite rules on activation
    function plugin_activation() {
        // Register your custom endpoint here if needed

        // Flush rewrite rules
        flush_rewrite_rules();

    }

    register_activation_hook( __FILE__, 'plugin_activation' );

    // Function to flush rewrite rules on deactivation
    function plugin_deactivation() {
        // Flush rewrite rules
        flush_rewrite_rules();
    }
    register_deactivation_hook( __FILE__, 'plugin_deactivation' );

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

    function districts_endpoint_data( $data ) {
        // Your custom logic goes here
        return new WP_REST_Response( 'Your response districts', 200 );
    }

    function add_districts_endpoint() {
        register_rest_route( 'v1', '/districts/', array(
            'methods'  => 'GET',
            'callback' => 'districts_endpoint_data',
        ) );
    }

    add_action( 'rest_api_init',  'add_districts_endpoint');

    require_once __DIR__."/endpoints/districts.php";