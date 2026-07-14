<?php

use PHPUnit\Framework\TestCase;
use Sagiris\ElementorTestimonialSlider\Carousel_Layout;

final class CarouselLayoutTest extends TestCase {

	public function test_uses_defaults_when_settings_are_missing(): void {
		$attr = Carousel_Layout::style_attribute( array() );

		$this->assertSame(
			'--sagiris-ets-slides-desktop:3;--sagiris-ets-slides-tablet:2;--sagiris-ets-slides-mobile:1;',
			$attr
		);
	}

	public function test_uses_all_three_breakpoints_when_set(): void {
		$attr = Carousel_Layout::style_attribute(
			array(
				'slides_per_view'        => '4',
				'slides_per_view_tablet' => '2',
				'slides_per_view_mobile' => '1',
			)
		);

		$this->assertSame(
			'--sagiris-ets-slides-desktop:4;--sagiris-ets-slides-tablet:2;--sagiris-ets-slides-mobile:1;',
			$attr
		);
	}

	public function test_falls_back_to_default_for_an_empty_string_value(): void {
		$attr = Carousel_Layout::style_attribute(
			array(
				'slides_per_view_tablet' => '',
			)
		);

		$this->assertSame(
			'--sagiris-ets-slides-desktop:3;--sagiris-ets-slides-tablet:2;--sagiris-ets-slides-mobile:1;',
			$attr
		);
	}

	public function test_clamps_to_a_minimum_of_one(): void {
		$attr = Carousel_Layout::style_attribute(
			array(
				'slides_per_view' => '0',
			)
		);

		$this->assertStringContainsString( '--sagiris-ets-slides-desktop:1;', $attr );
	}
}
