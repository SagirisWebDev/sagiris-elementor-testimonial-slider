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
	 * @param string $wrapper_style Optional inline CSS declarations (e.g. from Carousel_Layout::style_attribute()) applied to the outer wrapper.
	 * @param array{show_arrows?: bool, show_dots?: bool, autoplay?: bool, autoplay_delay?: int} $options Carousel-behavior toggles, all off/omitted by default.
	 */
	public static function render( array $testimonials, string $wrapper_style = '', array $options = array() ): string {
		if ( empty( $testimonials ) ) {
			return '';
		}

		$slides = '';
		foreach ( $testimonials as $testimonial ) {
			$slides .= self::render_slide( $testimonial );
		}

		$style_attr = '' !== $wrapper_style ? sprintf( ' style="%s"', esc_attr( $wrapper_style ) ) : '';
		$data_attr  = '';

		if ( ! empty( $options['autoplay'] ) ) {
			$delay     = isset( $options['autoplay_delay'] ) ? max( 1000, (int) $options['autoplay_delay'] ) : 5000;
			$data_attr = sprintf( ' data-autoplay="yes" data-autoplay-delay="%d"', $delay );
		}

		// A single testimonial has nothing to navigate to - arrows/dots would
		// be inert chrome, so they're suppressed regardless of the toggles.
		$has_multiple_slides = count( $testimonials ) > 1;

		$arrows_html = ! empty( $options['show_arrows'] ) && $has_multiple_slides ? self::render_arrows() : '';
		$dots_html   = ! empty( $options['show_dots'] ) && $has_multiple_slides ? self::render_dots( count( $testimonials ) ) : '';

		return sprintf(
			'<div class="sagiris-ets"%1$s%2$s>%3$s<div class="sagiris-ets__track">%4$s</div>%5$s</div>',
			$style_attr,
			$data_attr,
			$arrows_html,
			$slides,
			$dots_html
		);
	}

	private static function render_arrows(): string {
		return sprintf(
			'<button type="button" class="sagiris-ets__arrow sagiris-ets__arrow--prev" aria-label="%1$s">&lsaquo;</button><button type="button" class="sagiris-ets__arrow sagiris-ets__arrow--next" aria-label="%2$s">&rsaquo;</button>',
			esc_attr__( 'Previous testimonials', 'sagiris-elementor-testimonial-slider' ),
			esc_attr__( 'Next testimonials', 'sagiris-elementor-testimonial-slider' )
		);
	}

	private static function render_dots( int $count ): string {
		if ( $count < 1 ) {
			return '';
		}

		$dots = '';
		for ( $i = 0; $i < $count; $i++ ) {
			$dots .= sprintf(
				'<button type="button" class="sagiris-ets__dot" data-slide-index="%1$d" aria-label="%2$s"></button>',
				$i,
				esc_attr(
					sprintf(
						/* translators: %d: testimonial number */
						__( 'Go to testimonial %d', 'sagiris-elementor-testimonial-slider' ),
						$i + 1
					)
				)
			);
		}

		return sprintf( '<div class="sagiris-ets__dots">%s</div>', $dots );
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
