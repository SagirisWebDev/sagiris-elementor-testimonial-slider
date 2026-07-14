<?php

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
}
