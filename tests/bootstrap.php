<?php
/**
 * Standalone PHPUnit bootstrap for Testimonial_Slide_Renderer.
 *
 * Deliberately does NOT load WordPress - Testimonial_Slide_Renderer's only
 * WP dependency is the esc_* escaping functions, which are thin enough to
 * stub here. This keeps the test suite fast and dependency-free, matching
 * the "lighter weight" scope decided for this plugin (see PRD, issue #1).
 */

define( 'SAGIRIS_ETS_TESTING', true );

if ( ! function_exists( 'esc_html' ) ) {
	function esc_html( $text ) {
		return htmlspecialchars( (string) $text, ENT_QUOTES, 'UTF-8' );
	}
}

if ( ! function_exists( 'esc_attr' ) ) {
	function esc_attr( $text ) {
		return htmlspecialchars( (string) $text, ENT_QUOTES, 'UTF-8' );
	}
}

if ( ! function_exists( 'esc_url' ) ) {
	function esc_url( $url ) {
		return filter_var( (string) $url, FILTER_SANITIZE_URL );
	}
}

require_once __DIR__ . '/../includes/class-testimonial-slide-renderer.php';
