<?php
    /**
     * Plugin Name: Uganda API
     * Description: Access resourceful data from this open api to ease the development of your next project
     * version: 0.0.1
     * tags: Regions, Districts, Counties, Sub counties, Parish, Sub Parishes, Villages, words, tourist attractions, tribes, languages
     * Plugin URI: https://apiaxes.ablestate.co
    */

    // Get the path to the plugin directory
    $plugin_dir = plugin_dir_path( __FILE__ );

    // Modify REST API URL prefix
    function my_rest_url_prefix( $slug ) {
        return 'ug/api'; // Change 'api' to your desired prefix
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

    require_once $plugin_dir . "/endpoints/regions.php";
    require_once $plugin_dir . "/endpoints/districts.php";
    require_once $plugin_dir . "/endpoints/villages.php";
    require_once $plugin_dir . "/endpoints/languages.php";
    require_once $plugin_dir . "/endpoints/tribes.php";
    require_once $plugin_dir . "/endpoints/counties.php";
    require_once $plugin_dir . "/endpoints/sub-counties.php";
    require_once $plugin_dir . "/endpoints/parishes.php";
    require_once $plugin_dir . "/endpoints/sub-parishes.php";
    require_once $plugin_dir . "/endpoints/words.php";
    require_once $plugin_dir . "/endpoints/tourist-attractions.php";
