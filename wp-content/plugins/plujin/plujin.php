<?php
/*
Plugin Name: Le meilleur Plugin
Plugin URI: https://www.4each.fr
Description: en meme temps c'est le seul
Version: 1.0
Author: jin
Author URI: https://www.4each.fr
License: GPL2
License URI: https://www.gnu.org/licenses/gpl-2.0.html
Text Domain: wpb-tutorial
Domain Path: /languages
*/

add_filter("all_plugins", function (&$plugins) {

    $tab = [];
    foreach ($plugins as $key => $plugin) {
        $tab[$key] = $plugin;

        foreach ($plugin as $subKey => $text) {

            $text = str_replace(
                ["plugin", "plug in", "plug-in", "Plugin"],
                ["plujin", "pluj in", 'pluj-in', "Plujin"],
                $text
            );

            $tab[$key][$subKey] = $text;

        }
    }

    return $tab;
});

/**
 * Add Setting page for ACF
 *
 * @return void
 */
// function jin_setting_pages()
// {

//     // Bail, if anything goes wrong.
//     // if (!function_exists('acf_add_options_sub_page')) {
//     //     return;
//     // }

//     acf_add_options_sub_page(
//         array(
//             'page_title' => __('Plujin Page', 'default'),
//             'menu_title' => __('Plujin Page Menu', 'default'),
//             // 'parent_slug' => 'options-general.php',
//         )
//     );

// }


function jin_setting_pages()
{

    add_menu_page(
        __('Plujin Page', 'jin'),
        __('Plujin setting page', 'jin'),
        'manage_options',
        'jin_settings',
        'jin_setting_pages_callback',
        '',
        6
    );
}

function jin_setting_pages_callback()
{
    global $wpdb;
    $motsDb = $wpdb->get_results(
        "SELECT * FROM " . $wpdb->prefix . "phrases "
    );
    ?>

    <div class="wrap">
        <h1><?php echo __('Plujin Settings ECHO', 'jin'); ?></h1>
        <?php
        foreach ($motsDb as $value) {
            echo ($value->phrase);
            echo "</br>";
        }

        ?>
        <form method="post" action="options.php" novalidate="novalidate">
            <?php settings_fields('jin_settings'); ?>
            <table class="form-table" role="presentation">
                <?php do_settings_fields('jin_settings', 'default'); ?>
            </table>
            <?php submit_button(); ?>
        </form>
    </div>

    <?php
}


function jin_register_my_setting()
{

    $args = array(
        'type' => 'string',
        'sanitize_callback' => 'sanitize_text_field',
        'default' => null,
    );

    register_setting('jin_settings', 'jin_field_1', $args);

    add_settings_field(
        'jin_field_1',
        esc_html__('Field', 'jin'),
        'jin_setting_field_callback',
        'jin_settings'
    );

    // register_setting('jin_settings', 'bwp_select', $args);

    // add_settings_field(
    //     'bwp_select',
    //     esc_html__('Books', 'buntywp'),
    //     'jin_settings_book_field_callback',
    //     'jin_settings'
    // );
}
function jin_setting_field_callback($param)
{
    global $wpdb;
    $value = get_option('jin_field_1');
    $class = 'jin';

    // echo '<input type="text" name="bwp_field_1" value="' . esc_attr( $value ) . '" />';
    echo wp_sprintf(
        '<input type="text" name="jin_field_1" value="%s" class="%s" />',
        esc_attr($value),
        esc_attr($class)
    );


    $wpdb->query(
        $wpdb->prepare("INSERT INTO " . $wpdb->prefix . "phrases (phrase) VALUES (%s)", $value)
    );
    // var_dump($wpdb->prefix);


}



add_action('admin_init', 'jin_register_my_setting');

add_action('admin_menu', 'jin_setting_pages', 90);
add_action('admin_menu', 'jin_setting_pages', 90);
