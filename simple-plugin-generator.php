<?php
/**
 * Plugin Name: Simple Plugin Generator
 * Description: Generate consistent, configurable WordPress plugin starter ZIP files using a shortcode.
 * Version: 2.0.0
 * Requires PHP: 7.4
 * Author: Simple Plugins
 * License: GPL-2.0-or-later
 * Text Domain: simple-plugin-generator
 */
if ( ! defined( 'ABSPATH' ) ) { exit; }
require_once __DIR__ . '/includes/class-generator.php';
add_shortcode( 'plugin_generator_form', array( 'SPG_Generator', 'form' ) );
add_action( 'admin_post_spg_download', array( 'SPG_Generator', 'download' ) );
