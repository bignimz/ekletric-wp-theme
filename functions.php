<?php 
require_once 'lib/helpers.php';
require_once 'lib/enqueue-assets.php';


function after_pagination() {
    echo "jjllkjsdij";
}

add_action( '_themename_after_pagination', 'after_pagination' );
add_action( 'pre_get_posts', 'new_posts' );

function new_posts($query) {
    if($query->is_main_query()) {
        $query->set('posts_per_page', 2);
    }
}

function no_posts_text($text) {
    return esc_html__(":( Sorry! Please try again");
}

add_filter('_themename_no_posts_text', 'no_posts_text');


remove_action('pre_get_posts', 'new_posts');