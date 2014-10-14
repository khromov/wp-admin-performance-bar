<?php
/*
Plugin Name: Performance Admin Bar
Plugin URI: http://wordpress.org/extend/plugins/admin-performance-bar/
Description: WordPress performance at your fingertips!
Version: 1.0
License: GPL2
Author: khromov
Author URI: http://snippets.khromov.se
License: GPL2
*/

class Performance_Admin_Bar
{
    /* Sets the textdomain and slug for various prefixing needs */
    public static $td = 'performance_admin_bar';

    /* Set some useful constant values */
    public static $css_folder = 'shortcodes/css/';
    public static $js_folder = 'shortcodes/js/';
    public static $css_regexp = '/modules/css/*.css';
    public static $js_regexp = '/modules/js/*.js';

    function __construct()
    {
        /* Load all modules */
        add_action('plugins_loaded', $this->call('load_modules'), 10);

        /* Load translations */
        add_action('plugins_loaded', $this->call('load_localization'), 11);

        /* Include libraries */
        add_action('wp_enqueue_scripts', $this->call('enqueue_scripts_and_styles'));
    }

    /**
     * Loads all modules
     */
    function load_modules()
    {
        foreach (glob(__DIR__ . "/modules/*.php") as $filename)
            include $filename;
    }

    /**
     * Loads CSS and JS
     */
    function enqueue_scripts_and_styles()
    {
        foreach(glob(__DIR__ . self::$css_regexp) as $filename)
            wp_enqueue_style(self::$td . '_css_' . basename($filename, '.css'), plugins_url(self::$css_folder . basename($filename), __FILE__));

        foreach(glob(__DIR__ . self::$js_regexp) as $filename)
            wp_enqueue_script(self::$td . '_js_' . basename($filename, '.js'), plugins_url(self::$js_folder . basename($filename), __FILE__), array('jquery'), false, true);
    }


    /*
     * Loads localization
     */
    function load_localization()
    {
        //TODO: Finish this up
        load_plugin_textdomain(self::$td, false, basename(dirname(__FILE__)) . '/languages');
    }

    /**
     * Handles including assets from the modules
     */
    function enqueue_styles()
    {

    }

    function enqueue_scripts()
    {

    }

    /**
     * Builds a function call for use in hook callbacks.
     *
     * @param $function
     * @return array
     */
    function call($function)
    {
        return array(&$this, $function);
    }
}

$performance_admin_bar = new Performance_Admin_Bar();