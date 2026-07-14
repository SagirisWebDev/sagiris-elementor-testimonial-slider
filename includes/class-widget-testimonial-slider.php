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

	public function get_script_depends() {
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
			'title',
			array(
				'label'       => __( 'Title / Company', 'sagiris-elementor-testimonial-slider' ),
				'type'        => Controls_Manager::TEXT,
				'default'     => '',
				'label_block' => true,
			)
		);

		$repeater->add_control(
			'rating',
			array(
				'label'   => __( 'Rating', 'sagiris-elementor-testimonial-slider' ),
				'type'    => Controls_Manager::SELECT,
				'default' => '5',
				'options' => array(
					''  => __( 'None', 'sagiris-elementor-testimonial-slider' ),
					'1' => __( '1 Star', 'sagiris-elementor-testimonial-slider' ),
					'2' => __( '2 Stars', 'sagiris-elementor-testimonial-slider' ),
					'3' => __( '3 Stars', 'sagiris-elementor-testimonial-slider' ),
					'4' => __( '4 Stars', 'sagiris-elementor-testimonial-slider' ),
					'5' => __( '5 Stars', 'sagiris-elementor-testimonial-slider' ),
				),
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
						'name'   => __( 'Jane Doe', 'sagiris-elementor-testimonial-slider' ),
						'title'  => __( 'Owner, Doe & Co.', 'sagiris-elementor-testimonial-slider' ),
						'rating' => '5',
						'quote'  => __( 'This product changed how we work.', 'sagiris-elementor-testimonial-slider' ),
					),
				),
				'title_field' => '{{{ name }}}',
			)
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'layout_section',
			array(
				'label' => __( 'Layout', 'sagiris-elementor-testimonial-slider' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			)
		);

		$this->add_responsive_control(
			'slides_per_view',
			array(
				'label'          => __( 'Slides Per View', 'sagiris-elementor-testimonial-slider' ),
				'type'           => Controls_Manager::SELECT,
				'default'        => '3',
				'tablet_default' => '2',
				'mobile_default' => '1',
				'options'        => array(
					'1' => '1',
					'2' => '2',
					'3' => '3',
					'4' => '4',
				),
			)
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'navigation_section',
			array(
				'label' => __( 'Navigation', 'sagiris-elementor-testimonial-slider' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			)
		);

		$this->add_control(
			'arrows',
			array(
				'label'        => __( 'Arrows', 'sagiris-elementor-testimonial-slider' ),
				'type'         => Controls_Manager::SWITCHER,
				'default'      => 'yes',
				'label_on'     => __( 'Show', 'sagiris-elementor-testimonial-slider' ),
				'label_off'    => __( 'Hide', 'sagiris-elementor-testimonial-slider' ),
				'return_value' => 'yes',
			)
		);

		$this->add_control(
			'dots',
			array(
				'label'        => __( 'Dots', 'sagiris-elementor-testimonial-slider' ),
				'type'         => Controls_Manager::SWITCHER,
				'default'      => 'yes',
				'label_on'     => __( 'Show', 'sagiris-elementor-testimonial-slider' ),
				'label_off'    => __( 'Hide', 'sagiris-elementor-testimonial-slider' ),
				'return_value' => 'yes',
			)
		);

		$this->add_control(
			'autoplay',
			array(
				'label'        => __( 'Autoplay', 'sagiris-elementor-testimonial-slider' ),
				'type'         => Controls_Manager::SWITCHER,
				'default'      => '',
				'label_on'     => __( 'On', 'sagiris-elementor-testimonial-slider' ),
				'label_off'    => __( 'Off', 'sagiris-elementor-testimonial-slider' ),
				'return_value' => 'yes',
			)
		);

		$this->add_control(
			'autoplay_delay',
			array(
				'label'     => __( 'Autoplay Delay (ms)', 'sagiris-elementor-testimonial-slider' ),
				'type'      => Controls_Manager::NUMBER,
				'default'   => 5000,
				'min'       => 1000,
				'step'      => 500,
				'condition' => array(
					'autoplay' => 'yes',
				),
			)
		);

		$this->end_controls_section();
	}

	protected function render() {
		$settings      = $this->get_settings_for_display();
		$testimonials  = isset( $settings['testimonials'] ) && is_array( $settings['testimonials'] )
			? $settings['testimonials']
			: array();
		$wrapper_style = Carousel_Layout::style_attribute( $settings );
		$options       = array(
			'show_arrows'    => 'yes' === ( $settings['arrows'] ?? '' ),
			'show_dots'      => 'yes' === ( $settings['dots'] ?? '' ),
			'autoplay'       => 'yes' === ( $settings['autoplay'] ?? '' ),
			'autoplay_delay' => isset( $settings['autoplay_delay'] ) ? (int) $settings['autoplay_delay'] : 5000,
		);

		// phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped -- Testimonial_Slide_Renderer escapes each field internally; $wrapper_style is built from a fixed integer whitelist in Carousel_Layout.
		echo Testimonial_Slide_Renderer::render( $testimonials, $wrapper_style, $options );
	}
}
