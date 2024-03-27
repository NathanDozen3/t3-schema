<?php
/**
 * Plugin Name: T3 Schema
 * Plugin URI:
 * Description: Add global, per-page, per-post, per-custom post type, and FAQ schema.
 * Version: 1.0.0
 * Requires at least: 6.4
 * Requires PHP: 7.4
 * Author: Twelve Three Media
 * Author URI: https://www.digitalmarketingcompany.com/
 * Text Domain: t3-schema
 */

namespace t3\schema;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

define( 'T3_SCHEMA_VERSION', '1.0.0' );
define( 'T3_DIR', __DIR__ );

require __DIR__ . '/callbacks.php';
require __DIR__ . '/functions.php';

add_action( 'plugins_loaded', 'define_t3_schema_capability' );
add_action( 'init', 'register_post_meta_to_show_in_rest_api' );
add_action( 'init', 'register_faq_block' );
add_action( 'admin_init', 'register_t3_schema_settings' );
add_action( 'admin_menu', 'add_submenu_to_general_options' );
add_filter( 'plugin_action_links_t3-schema/t3-schema.php', 'add_settings_link_to_plugins_administration_page' );
add_action( 'add_meta_boxes', 'add_meta_boxes' );
add_action( 'admin_enqueue_scripts', 'enqueue_t3_schema_post_editor_assets' );
add_action( 'save_post', 'save_t3_post_meta_data', 10, 3 );
add_action( 'wp_head', 'print_t3_schema', 3 );
