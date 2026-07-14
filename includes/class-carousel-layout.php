<?php
/**
 * Pure layout module: normalized widget settings in, an inline CSS
 * custom-property declaration string out. No Elementor dependency, so it's
 * unit testable the same way Testimonial_Slide_Renderer is.
 *
 * @package Sagiris\ElementorTestimonialSlider
 */

namespace Sagiris\ElementorTestimonialSlider;

if ( ! defined( 'ABSPATH' ) && ! defined( 'SAGIRIS_ETS_TESTING' ) ) {
	exit;
}

class Carousel_Layout {

	private const DEFAULTS = array(
		'desktop' => 3,
		'tablet'  => 2,
		'mobile'  => 1,
	);

	/**
	 * Builds the CSS custom-property declarations for the widget wrapper's
	 * inline style attribute, e.g.
	 * "--sagiris-ets-slides-desktop:3;--sagiris-ets-slides-tablet:2;--sagiris-ets-slides-mobile:1;"
	 *
	 * @param array<string, mixed> $settings Elementor's get_settings_for_display() output.
	 */
	public static function style_attribute( array $settings ): string {
		$declarations = '';

		foreach ( self::DEFAULTS as $breakpoint => $default ) {
			$declarations .= sprintf(
				'--sagiris-ets-slides-%s:%d;',
				$breakpoint,
				self::slides_per_view( $settings, $breakpoint, $default )
			);
		}

		return $declarations;
	}

	private static function slides_per_view( array $settings, string $breakpoint, int $default ): int {
		$key = 'desktop' === $breakpoint ? 'slides_per_view' : "slides_per_view_{$breakpoint}";

		if ( ! isset( $settings[ $key ] ) || '' === $settings[ $key ] ) {
			return $default;
		}

		return max( 1, (int) $settings[ $key ] );
	}
}
