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
    wp_register_style('bootstrap', 'https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css', [], 0.1);
    wp_register_style('jin', '/wp-content/themes/jin/styles/jin.css', ["bootstrap"], 0.6);
    wp_register_script('bootstrap_script', 'https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js');
    wp_enqueue_style('jin');
    wp_enqueue_style('bootstrap');
    wp_enqueue_script('bootstrap_script');
}


add_filter("document_title_separator", function ($separator) {
    // return $separator;
    return ">";
});
add_filter("document_title_separator", function ($separator) {
    return $separator . " < ";

}, 11);

add_action('after_setup_theme', 'Jin\customThemeSupport');
add_action('wp_enqueue_scripts', 'Jin\addStyles');



