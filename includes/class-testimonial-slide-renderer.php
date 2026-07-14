<?php
/**
 * Pure rendering module: normalized testimonial data in, HTML string out.
 * Deliberately free of Elementor/control-registration concerns so it can be
 * unit tested in isolation (see tests/TestimonialSlideRendererTest.php).
 *
 * @package Sagiris\ElementorTestimonialSlider
 */

namespace Sagiris\ElementorTestimonialSlider;

if ( ! defined( 'ABSPATH' ) && ! defined( 'SAGIRIS_ETS_TESTING' ) ) {
	exit;
}

class Testimonial_Slide_Renderer {

	/**
	 * @param array<int, array{name?: string, quote?: string, image?: array{url?: string}}> $testimonials
	 */
	public static function render( array $testimonials ): string {
		if ( empty( $testimonials ) ) {
			return '';
		}

		$slides = '';
		foreach ( $testimonials as $testimonial ) {
			$slides .= self::render_slide( $testimonial );
		}

		return sprintf(
			'<div class="sagiris-ets"><div class="sagiris-ets__track">%s</div></div>',
			$slides
		);
	}

	/**
	 * @param array{name?: string, quote?: string, image?: array{url?: string}} $testimonial
	 */
	private static function render_slide( array $testimonial ): string {
		$name      = isset( $testimonial['name'] ) ? (string) $testimonial['name'] : '';
		$quote     = isset( $testimonial['quote'] ) ? (string) $testimonial['quote'] : '';
		$image_url = isset( $testimonial['image']['url'] ) ? (string) $testimonial['image']['url'] : '';

		$image_html = '';
		if ( '' !== $image_url ) {
			$image_html = sprintf(
				'<img class="sagiris-ets__photo" src="%s" alt="%s" />',
				esc_url( $image_url ),
				esc_attr( $name )
			);
		}

		return sprintf(
			'<div class="sagiris-ets__slide">%s<blockquote class="sagiris-ets__quote">%s</blockquote><cite class="sagiris-ets__name">%s</cite></div>',
			$image_html,
			esc_html( $quote ),
			esc_html( $name )
		);
	}
}
