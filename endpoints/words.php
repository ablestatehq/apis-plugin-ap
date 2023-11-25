<?php

    function words_endpoint_data( $data ) {
        $args = array(
            'post_type' => 'word',
            'posts_per_page' => -1,
            'post_status' => 'publish',
            'orderby' => 'title',
        );

        $words = get_posts( $args );

        $the_words = array();

        foreach( $words as $word) {

            $native_language_description = get_post_meta($word->ID, 'native_language_description',true);
            $english_description = get_post_meta($word->ID, 'english_description',true);
            $english_translation = get_post_meta($word->ID, 'english',true);
            $type = get_post_meta($word->ID, 'type',true);
            $tone = get_post_meta($word->ID, 'tone',true);
            $slang = get_post_meta($word->ID, 'slang',true);
            $tense = get_post_meta($word->ID, 'tense',true);
            $voice = get_post_meta($word->ID, 'voice',true);
            $addresses = get_post_meta($word->ID, 'addresses',true);
            $primary_language = get_post_meta($word->ID, 'primary_language',true);
            $audio = get_post_meta($word->ID, 'audio',true);
            $photo = get_post_meta($word->ID, 'photo',true);
            $video = get_post_meta($word->ID, 'video',true);

            $the_words[] = array(
                'id' => $word->ID,
                'name' => $word->post_title,
                'native_description' => $native_language_description,
                'english_description' => $english_description,
                'english_translation' => $english_translation,
                'type' => $type,
                'tone' => $tone,
                'slang' => $slang,
                'tense' => $tense,
                'voice' => $voice,
                'addresses' => $addresses,
                'primary_language' => $primary_language,
                'addresses' => $addresses,
                'audio' => $audio,
                'photo' => $photo,
                'video' => $video
            );
        }

        return new WP_REST_Response( [
            'result' => 'successful',
            'words' => $the_words,
            'total' => count($words),
        ], 200 );
    }

    function add_words_endpoint() {
        register_rest_route( 'v1', '/words/', array(
            'methods'  => 'GET',
            'callback' => 'words_endpoint_data',
        ));
    }

    add_action( 'rest_api_init',  'add_words_endpoint');
