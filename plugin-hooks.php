<?php
/*
Plugin Name: Wp Clock Counter 
Plugin URI:  http://touchpointdev.com/wp-clock-counter
Description: In this Wp Clock Counter plugin user get dynamic clocks and counter with multiple language support, easy installation, multiple sortcodes has in plugin and easy setup functions.
Author: Wp Plugin Area
Author URI: http://wppluginarea.com
Version: 2.1
*/

/* Adding Latest jQuery from Wordpress */
function tp_custom_clock_latest_jquery() {
	wp_enqueue_script('jquery');
}
add_action('init', 'tp_custom_clock_latest_jquery');

/*Some Set-up*/
define('TP_CUSTOM_CLOCK', WP_PLUGIN_URL . '/' . plugin_basename( dirname(__FILE__) ) . '/' );

/* Adding Plugin javascript file */
wp_enqueue_script('tp-custom-clock-plugin-js', TP_CUSTOM_CLOCK.'js/flipclock.min.js', array('jquery'));

/* Adding Plugin css file */
wp_enqueue_style('tp-custom-clock-plugin-css', TP_CUSTOM_CLOCK.'css/flipclock.css');


/* Add Plugin Shortcode Button on Post Visual Editor */
function tp_custom_clock_button_function() {
	add_filter ("mce_external_plugins", "tp_custom_clock_button_js");
	add_filter ("mce_buttons", "tp_custom_clock_button");
}

function tp_custom_clock_button_js($plugin_array) {
	$plugin_array['tpclocks'] = plugins_url('js/clock-custom-button.js', __FILE__);
	return $plugin_array;
}

function tp_custom_clock_button($buttons) {
	array_push ($buttons, 'tpclock');
	return $buttons;
}
add_action ('init', 'tp_custom_clock_button_function'); 


/* Add Plugin Shortcode */
function custom_clock_list_shortcode( $atts, $content = null  ) {
	extract( shortcode_atts( array(
		'margin' => '10px',
		'id' => 'clock',
		'clockface' => 'DailyCounter',
		'set_time' => '3600',
		'language' => 'en',
		'countdown' => 'false'
	), $atts ) );

	return '
	
	<script type="text/javascript">
		var clock;		
		jQuery(document).ready(function() {
			var clock;
			clock = jQuery("#clock'.$id.'").FlipClock({
		        clockFace: "'.$clockface.'",
		        autoStart: "false",
				showSeconds: "true",
				language: "'.$language.'"
		    });
				    
		    clock.setTime('.$set_time.');   
		    clock.setCountdown('.$countdown.');
		    clock.start();

		});
	</script>
	<div id="clock'.$id.'"></div> ';
}	
add_shortcode('custom_clocks', 'custom_clock_list_shortcode');




?>