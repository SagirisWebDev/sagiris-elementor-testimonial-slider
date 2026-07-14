<?php
/**
 * Plugin bootstrap: wires this plugin's widget(s) into Elementor.
 *
 * @package Sagiris\ElementorTestimonialSlider
 */

namespace Sagiris\ElementorTestimonialSlider;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

class Plugin {

	public static function init(): void {
		add_action( 'elementor/widgets/register', array( __CLASS__, 'register_widgets' ) );
		add_action( 'elementor/frontend/after_register_styles', array( __CLASS__, 'register_styles' ) );
	}

	/**
	 * @param \Elementor\Widgets_Manager $widgets_manager
	 */
	public static function register_widgets( $widgets_manager ): void {
		require_once SAGIRIS_ETS_PATH . 'includes/class-testimonial-slide-renderer.php';
		require_once SAGIRIS_ETS_PATH . 'includes/class-carousel-layout.php';
		require_once SAGIRIS_ETS_PATH . 'includes/class-widget-testimonial-slider.php';

		$widgets_manager->register( new Widget_Testimonial_Slider() );
	}

	public static function register_styles(): void {
		wp_register_style(
			'sagiris-ets',
			SAGIRIS_ETS_URL . 'assets/css/testimonial-slider.css',
			array(),
			SAGIRIS_ETS_VERSION
		);
	}
}
