<?php
/**
 * Plugin Name:       Sagiris Elementor Testimonial Slider
 * Plugin URI:        https://github.com/SagirisWebDev/sagiris-elementor-testimonial-slider
 * Description:       Custom Elementor widget for a testimonial/review carousel. Rendered with vanilla CSS scroll-snap, no bundler.
 * Version:           0.1.0
 * Requires at least: 6.5
 * Requires PHP:      7.4
 * Requires Plugins:  elementor
 * Author:            Sagiris Web Dev
 * Author URI:        https://sagirisdev.com
 * License:           GPL v2 or later
 * License URI:       https://www.gnu.org/licenses/gpl-2.0.html
 * Text Domain:       sagiris-elementor-testimonial-slider
 *
 * @package Sagiris\ElementorTestimonialSlider
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

define( 'SAGIRIS_ETS_VERSION', '0.1.0' );
define( 'SAGIRIS_ETS_PATH', plugin_dir_path( __FILE__ ) );
define( 'SAGIRIS_ETS_URL', plugin_dir_url( __FILE__ ) );

require_once SAGIRIS_ETS_PATH . 'includes/class-plugin.php';

add_action( 'plugins_loaded', array( '\Sagiris\ElementorTestimonialSlider\Plugin', 'init' ) );
