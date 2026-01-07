<?php
/**
 * Theme Functions
 * Đại Sứ Kevin Phillips - ABCVIP
 */

if (!defined('ABSPATH')) {
    exit;
}

define('THEME_VERSION', '4.0.0');
define('THEME_PATH', get_template_directory());
define('THEME_URI', get_template_directory_uri());

// Include helpers
require_once THEME_PATH . '/inc/helpers.php';

// Include theme options
require_once THEME_PATH . '/inc/theme-options.php';

/**
 * Theme Setup
 */
function theme_developer_setup() {
    add_theme_support('title-tag');
    add_theme_support('post-thumbnails');
    add_theme_support('html5', array('search-form', 'comment-form', 'comment-list', 'gallery', 'caption'));
    
    // Register Menu Locations
    register_nav_menus(array(
        'header-menu' => 'Header Menu',
        'footer-menu' => 'Footer Menu',
    ));
}
add_action('after_setup_theme', 'theme_developer_setup');

/**
 * Enqueue Scripts and Styles
 */
function theme_developer_scripts() {
    wp_enqueue_style('google-fonts', 'https://fonts.googleapis.com/css2?family=Montserrat:wght@400;500;600;700;800&display=swap', array(), null);
    wp_enqueue_style('google-fonts-poppins', 'https://fonts.googleapis.com/css2?family=Poppins:wght@700;800;900&display=swap', array(), null);
    wp_enqueue_style('theme-style', THEME_URI . '/style.css', array(), THEME_VERSION);
    wp_enqueue_style('theme-custom', THEME_URI . '/assets/css/custom.css', array('theme-style'), THEME_VERSION);
    wp_enqueue_script('jquery');
    wp_enqueue_script('theme-main', THEME_URI . '/assets/js/main.js', array('jquery'), THEME_VERSION, true);
}
add_action('wp_enqueue_scripts', 'theme_developer_scripts');

/**
 * Admin Scripts
 */
function theme_developer_admin_scripts($hook) {
    if ($hook !== 'toplevel_page_theme-options') {
        return;
    }
    wp_enqueue_style('theme-admin-style', THEME_URI . '/inc/admin/admin-style.css', array(), THEME_VERSION);
    wp_enqueue_media();
    wp_enqueue_script('theme-admin-script', THEME_URI . '/inc/admin/admin-script.js', array('jquery'), THEME_VERSION, true);
}
add_action('admin_enqueue_scripts', 'theme_developer_admin_scripts');

/**
 * Add menu item classes
 */
function theme_menu_item_class($classes, $item, $args) {
    if ($args->theme_location === 'header-menu') {
        $classes[] = 'header-menu-item';
    }
    return $classes;
}
add_filter('nav_menu_css_class', 'theme_menu_item_class', 10, 3);

/**
 * Add menu link class
 */
function theme_menu_link_class($atts, $item, $args) {
    if ($args->theme_location === 'header-menu') {
        $atts['class'] = 'menu-btn';
    }
    return $atts;
}
add_filter('nav_menu_link_attributes', 'theme_menu_link_class', 10, 3);
