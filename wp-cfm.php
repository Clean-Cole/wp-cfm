<?php
/*
Plugin Name: WP-CFM
Plugin URI: http://forumone.com/
Description: WordPress Configuration Management
Version: 1.0.5
Author: Forum One Communications
Author URI: http://forumone.com/
License: GPLv2

Copyright 2014 Forum One Communications

This program is free software; you can redistribute it and/or
modify it under the terms of the GNU General Public License
as published by the Free Software Foundation; either version 2
of the License, or (at your option) any later version.

This program is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
GNU General Public License for more details.

You should have received a copy of the GNU General Public License
along with this program; if not, see <http://www.gnu.org/licenses/>.
*/

if ( ! defined( 'ABSPATH' ) ) exit;


class WPCFM
{
    public $readwrite;
    public $registry;

    function __construct() {

        // setup variables
        define( 'WPCFM_VERSION', '1.0.5' );
        define( 'WPCFM_DIR', dirname( __FILE__ ) );
        define( 'WPCFM_URL', plugins_url( basename( dirname( __FILE__ ) ) ) );

        // WP is loaded
        add_action( 'init', array( $this, 'init' ) );
    }


    /**
     * Initialize classes and WP hooks
     */
    function init() {

        // i18n
        $this->load_textdomain();

        // hooks
        add_action( 'admin_menu', array( $this, 'admin_menu' ) );
        add_action( 'admin_enqueue_scripts', array( $this, 'admin_scripts' ) );

        // includes
        foreach ( array( 'readwrite', 'registry', 'helper', 'ajax' ) as $class ) {
            include( WPCFM_DIR . "/includes/class-$class.php" );
        }

        // WP-CLI
        if ( defined( 'WP_CLI' ) && WP_CLI ) {
            include( WPCFM_DIR . '/includes/class-wp-cli.php' );
        }

        $this->readwrite = new WPCFM_Readwrite();
        $this->registry = new WPCFM_Registry();
        $this->helper = new WPCFM_Helper();
        $ajax = new WPCFM_Ajax();

        // Make sure is_plugin_active() is available
        include_once( ABSPATH . 'wp-admin/includes/plugin.php' );

        // Third party integrations
        $integrations = scandir( WPCFM_DIR . '/includes/integrations' );
        foreach ( $integrations as $filename ) {
            if ( '.' != substr( $filename, 0, 1 ) ) {
                include( WPCFM_DIR . "/includes/integrations/$filename" );
            }
        }
    }


    /**
     * Register the FacetWP settings page
     */
    function admin_menu() {
        add_options_page( 'WP-CFM', 'WP-CFM', 'manage_options', 'wpcfm', array( $this, 'settings_page' ) );
    }


    /**
     * Enqueue media CSS
     */
    function admin_scripts( $hook ) {
        if ( 'settings_page_wpcfm' == $hook ) {
            wp_enqueue_style( 'media-views' );
        }
    }


    /**
     * Route to the correct edit screen
     */
    function settings_page() {
        include( WPCFM_DIR . '/templates/page-settings.php' );
    }


    /**
     * i18n support
     */
    function load_textdomain() {
        $locale = apply_filters( 'plugin_locale', get_locale(), 'wpcfm' );
        $mofile = WP_LANG_DIR . '/wpcfm-' . $locale . '.mo';

        if ( file_exists( $mofile ) ) {
            load_textdomain( 'wpcfm', $mofile );
        }
        else {
            load_plugin_textdomain( 'wpcfm', false, dirname( plugin_basename( __FILE__ ) ) . '/languages/' );
        }
    }
}

$wp_cfm = new WPCFM();
