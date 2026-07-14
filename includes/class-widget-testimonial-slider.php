<?php
/**
 * Elementor widget: registers controls, delegates rendering to
 * Testimonial_Slide_Renderer.
 *
 * @package Sagiris\ElementorTestimonialSlider
 */

namespace Sagiris\ElementorTestimonialSlider;

use Elementor\Controls_Manager;
use Elementor\Repeater;
use Elementor\Widget_Base;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

class Widget_Testimonial_Slider extends Widget_Base {

	public function get_name() {
		return 'sagiris-testimonial-slider';
	}

	public function get_title() {
		return __( 'Testimonial Slider', 'sagiris-elementor-testimonial-slider' );
	}

	public function get_icon() {
		return 'eicon-testimonial-carousel';
	}

	public function get_categories() {
		return array( 'general' );
	}

	public function get_style_depends() {
		return array( 'sagiris-ets' );
	}

	protected function register_controls() {
		$this->start_controls_section(
			'content_section',
			array(
				'label' => __( 'Testimonials', 'sagiris-elementor-testimonial-slider' ),
			)
		);

		$repeater = new Repeater();

		$repeater->add_control(
			'image',
			array(
				'label'   => __( 'Photo', 'sagiris-elementor-testimonial-slider' ),
				'type'    => Controls_Manager::MEDIA,
				'default' => array(
					'url' => '',
				),
			)
		);

		$repeater->add_control(
			'name',
			array(
				'label'       => __( 'Name', 'sagiris-elementor-testimonial-slider' ),
				'type'        => Controls_Manager::TEXT,
				'default'     => __( 'Jane Doe', 'sagiris-elementor-testimonial-slider' ),
				'label_block' => true,
			)
		);

		$repeater->add_control(
			'quote',
			array(
				'label'       => __( 'Quote', 'sagiris-elementor-testimonial-slider' ),
				'type'        => Controls_Manager::TEXTAREA,
				'default'     => __( 'This product changed how we work.', 'sagiris-elementor-testimonial-slider' ),
				'label_block' => true,
			)
		);

		$this->add_control(
			'testimonials',
			array(
				'label'       => __( 'Testimonials', 'sagiris-elementor-testimonial-slider' ),
				'type'        => Controls_Manager::REPEATER,
				'fields'      => $repeater->get_controls(),
				'default'     => array(
					array(
						'name'  => __( 'Jane Doe', 'sagiris-elementor-testimonial-slider' ),
						'quote' => __( 'This product changed how we work.', 'sagiris-elementor-testimonial-slider' ),
					),
				),
				'title_field' => '{{{ name }}}',
			)
		);

		$this->end_controls_section();
	}

	protected function render() {
		$settings     = $this->get_settings_for_display();
		$testimonials = isset( $settings['testimonials'] ) && is_array( $settings['testimonials'] )
			? $settings['testimonials']
			: array();

		// phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped -- Testimonial_Slide_Renderer escapes each field internally.
		echo Testimonial_Slide_Renderer::render( $testimonials );
	}
}
