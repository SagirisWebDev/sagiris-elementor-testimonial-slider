<?php

use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\TestCase;
use Sagiris\ElementorTestimonialSlider\Testimonial_Slide_Renderer;

final class TestimonialSlideRendererTest extends TestCase {

	public function test_renders_nothing_for_empty_input(): void {
		$this->assertSame( '', Testimonial_Slide_Renderer::render( array() ) );
	}

	public function test_renders_a_slide_with_escaped_content(): void {
		$html = Testimonial_Slide_Renderer::render(
			array(
				array(
					'name'  => 'Jane <script>alert(1)</script> Doe',
					'quote' => 'Great & reliable',
					'image' => array( 'url' => 'https://example.com/jane.jpg' ),
				),
			)
		);

		$this->assertStringContainsString( 'sagiris-ets__slide', $html );
		$this->assertStringContainsString( 'Great &amp; reliable', $html );
		$this->assertStringNotContainsString( '<script>', $html );
		$this->assertStringContainsString( 'src="https://example.com/jane.jpg"', $html );
	}

	public function test_omits_photo_markup_when_no_image_url(): void {
		$html = Testimonial_Slide_Renderer::render(
			array(
				array(
					'name'  => 'No Photo',
					'quote' => 'Still counts.',
				),
			)
		);

		$this->assertStringNotContainsString( 'sagiris-ets__photo', $html );
	}

	public function test_renders_multiple_slides(): void {
		$html = Testimonial_Slide_Renderer::render(
			array(
				array(
					'name'  => 'A',
					'quote' => 'One',
				),
				array(
					'name'  => 'B',
					'quote' => 'Two',
				),
			)
		);

		$this->assertSame( 2, substr_count( $html, 'sagiris-ets__slide' ) );
	}

	public function test_renders_title_when_present(): void {
		$html = Testimonial_Slide_Renderer::render(
			array(
				array(
					'name'  => 'Jane',
					'title' => 'Owner, Jane & Co.',
					'quote' => 'Great.',
				),
			)
		);

		$this->assertStringContainsString( 'sagiris-ets__title', $html );
		$this->assertStringContainsString( 'Owner, Jane &amp; Co.', $html );
	}

	public function test_omits_title_markup_when_absent(): void {
		$html = Testimonial_Slide_Renderer::render(
			array(
				array(
					'name'  => 'Jane',
					'quote' => 'Great.',
				),
			)
		);

		$this->assertStringNotContainsString( 'sagiris-ets__title', $html );
	}

	public function test_renders_rating_stars_and_aria_label(): void {
		$html = Testimonial_Slide_Renderer::render(
			array(
				array(
					'name'   => 'Jane',
					'quote'  => 'Great.',
					'rating' => 3,
				),
			)
		);

		$this->assertStringContainsString( 'aria-label="3 out of 5 stars"', $html );
		$this->assertStringContainsString( '★★★☆☆', $html );
	}

	public function test_accepts_rating_as_a_numeric_string(): void {
		$html = Testimonial_Slide_Renderer::render(
			array(
				array(
					'name'   => 'Jane',
					'quote'  => 'Great.',
					'rating' => '5',
				),
			)
		);

		$this->assertStringContainsString( '★★★★★', $html );
	}

	#[DataProvider( 'invalid_rating_provider' )]
	public function test_omits_rating_markup_for_invalid_values( $rating ): void {
		$html = Testimonial_Slide_Renderer::render(
			array(
				array(
					'name'   => 'Jane',
					'quote'  => 'Great.',
					'rating' => $rating,
				),
			)
		);

		$this->assertStringNotContainsString( 'sagiris-ets__rating', $html );
	}

	public static function invalid_rating_provider(): array {
		return array(
			'zero'         => array( 0 ),
			'negative'     => array( -1 ),
			'above range'  => array( 6 ),
			'empty string' => array( '' ),
			'null value'   => array( null ),
		);
	}
}
