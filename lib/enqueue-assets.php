<?php

// Enqueue Main Assets
function _themename_enqueue_assets() {
    wp_enqueue_style('_themename-styles', get_template_directory_uri() . '/dist/assets/css/bundle.css', [], '1.0.0', 'all');
    wp_enqueue_script('_themename-scripts', get_template_directory_uri() . '/dist/assets/js/bundle.js', ['jquery'], '1.0.0', true);
}

add_action( 'wp_enqueue_scripts', '_themename_enqueue_assets');

// Enqueue Admin Assets
function _themename_admin_assets() {
    wp_enqueue_style('_themename-admin-styles', get_template_directory_uri() . '/dist/assets/css/admin.css', [], '1.0.0', 'all');
    wp_enqueue_script('_themename-admin-scripts', get_template_directory_uri() . '/dist/assets/js/admin.js', [], '1.0.0', true);
}

add_action( 'admin_enqueue_scripts', '_themename_admin_assets');


