<?php
/*
Plugin Name: JoomConnect Quick Ticket Lite
Plugin URI: http://www.joomconnect.com/joomconnect/qt-lite.html
Description: Creates a widget which allows users to create tickets in your ConnectWise using the email connectors you set up in the widget settings.
Author: Directive
Version: 1.0.0
Author URI: http://www.joomconnect.com
*/

class jc_qtlite {

	function jc_qtlite(){

		if(!is_admin()){
			// Header styles
			add_action( 'wp_head', array('jc_qtlite', 'header') );

		}
		add_action( 'wp_footer', array('jc_qtlite', 'footer') );
	}

	function header(){
		// Stylesheet
		wp_enqueue_style( 'emailconnector', jc_qtlite::get_plugin_directory().'/css/emailconnector.css');

		// Scripts
		wp_enqueue_script( 'jquery' );
		wp_enqueue_script( 'ajax', jc_qtlite::get_plugin_directory() . '/js/ajax.js', array('jquery') );

	}

	function footer(){}

	function options(){}

	function get_plugin_directory(){
		return WP_PLUGIN_URL . '/joomconnect-quick-ticket-lite';
	}

};

// Include the widget
include_once('joomconnect_quick_ticket_lite_widget.php');

// Initialize the plugin.
$jc_qtlite = new jc_qtlite();

// Register the widget
add_action('widgets_init', create_function('', 'return register_widget("jc_qtlite_widget");'));

?>