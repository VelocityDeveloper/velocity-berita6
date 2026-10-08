<?php
/**
 * Enqueue child theme styles and scripts.
 */
if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly.
}

/**
 * Load the parent style.css file
 *
 * @link http://codex.wordpress.org/Child_Themes
 */
if (!function_exists('justg_child_enqueue_parent_style')) {
    function justg_child_enqueue_parent_style()
    {
        $parenthandle = 'parent-style';
        $theme        = wp_get_theme();
        $dir          = get_stylesheet_directory();

        wp_enqueue_style(
            $parenthandle,
            get_template_directory_uri() . '/style.css',
            array(),
            $theme->parent()->get('Version')
        );

        wp_enqueue_style(
            'custom-style',
            get_stylesheet_directory_uri() . '/css/custom.css',
            array(),
            $theme->get('Version') . '.' . filemtime($dir . '/css/custom.css')
        );

        wp_enqueue_style(
            'child-style',
            get_stylesheet_uri(),
            array($parenthandle),
            $theme->get('Version')
        );

        wp_enqueue_script(
            'justg-custom-scripts',
            get_stylesheet_directory_uri() . '/js/custom.js',
            array(),
            $theme->get('Version') . '.' . filemtime($dir . '/js/custom.js'),
            array('in_footer' => true, 'strategy' => 'defer')
        );
    }
    // Prioritas 30: dimuat sesudah CSS induk (theme.min.css, prioritas 20) agar tidak tertimpa.
    add_action('wp_enqueue_scripts', 'justg_child_enqueue_parent_style', 30);
}
