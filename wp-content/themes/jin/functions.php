<?php

namespace Jin;
// add_action('wp_head', function () {

//     die("Salut");

// });

function customThemeSupport()
{
    add_theme_support('title-tag');

}

function addStyles()
{
    wp_register_style('jin', '/wp-content/themes/jin/styles/jin.css');

    wp_enqueue_style('jin');
}


add_action('after_setup_theme', 'Jin\customThemeSupport');
add_action('wp_enqueue_scripts', 'Jin\addStyles');

