<?php

/**
 * The plugin bootstrap file
 *
 * This file is read by WordPress to generate the plugin information in the plugin
 * admin area. This file also includes all of the dependencies used by the plugin,
 * registers the activation and deactivation functions, and defines a function
 * that starts the plugin.
 *
 * @link              https://prefix.com
 * @since             1.0.0
 * @package           Prefix
 *
 * @wordpress-plugin
 * Plugin Name:       Prefix-companion
 * Plugin URI:        https://prefix.com
 * Description:       
 * Version:           1.0.0
 * Author:            Masum Sakib
 * Author URI:        https://prefix.com
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:       prefix
 * Domain Path:       /languages
 */


// Exit if accessed directly
if ( !defined( 'ABSPATH' ) ) {
    exit;
}

/*
Constants
------------------------------------------ */

/* Set plugin version constant. */
define( 'PREFIX_VERSION', time());

/* Set constant path to the plugin directory. */
define( 'PREFIX_PATH', trailingslashit( plugin_dir_path( __FILE__ ) ) );

// Plugin Addons Folder Path
define( 'PREFIX_ADDONS_DIR', plugin_dir_path( __FILE__ ) . 'widget/' );

// Assets Folder URL
define( 'PREFIX_ASSETS', plugins_url( 'assets/', __FILE__ ) );

require_once(PREFIX_PATH. 'base.php' );
require_once(PREFIX_PATH. '/inc/helper-function.php' );