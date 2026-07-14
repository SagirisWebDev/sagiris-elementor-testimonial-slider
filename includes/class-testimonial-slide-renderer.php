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
	 * @param array<int, array{name?: string, title?: string, rating?: int|string, quote?: string, image?: array{url?: string}}> $testimonials
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
	 * @param array{name?: string, title?: string, rating?: int|string, quote?: string, image?: array{url?: string}} $testimonial
	 */
	private static function render_slide( array $testimonial ): string {
		$name      = isset( $testimonial['name'] ) ? (string) $testimonial['name'] : '';
		$title     = isset( $testimonial['title'] ) ? (string) $testimonial['title'] : '';
		$quote     = isset( $testimonial['quote'] ) ? (string) $testimonial['quote'] : '';
		$image_url = isset( $testimonial['image']['url'] ) ? (string) $testimonial['image']['url'] : '';
		$rating    = isset( $testimonial['rating'] ) && '' !== $testimonial['rating'] ? (int) $testimonial['rating'] : 0;

		$image_html = '';
		if ( '' !== $image_url ) {
			$image_html = sprintf(
				'<img class="sagiris-ets__photo" src="%s" alt="%s" />',
				esc_url( $image_url ),
				esc_attr( $name )
			);
		}

		$title_html = '';
		if ( '' !== $title ) {
			$title_html = sprintf( '<span class="sagiris-ets__title">%s</span>', esc_html( $title ) );
		}

		$rating_html = '';
		if ( $rating >= 1 && $rating <= 5 ) {
			$rating_html = self::render_rating( $rating );
		}

		return sprintf(
			'<div class="sagiris-ets__slide">%1$s%2$s<blockquote class="sagiris-ets__quote">%3$s</blockquote><cite class="sagiris-ets__name">%4$s%5$s</cite></div>',
			$image_html,
			$rating_html,
			esc_html( $quote ),
			esc_html( $name ),
			$title_html
		);
	}

	private static function render_rating( int $rating ): string {
		$stars = str_repeat( '★', $rating ) . str_repeat( '☆', 5 - $rating );

		return sprintf(
			'<div class="sagiris-ets__rating" aria-label="%s">%s</div>',
			esc_attr( sprintf( '%d out of 5 stars', $rating ) ),
			esc_html( $stars )
		);
	}
}
