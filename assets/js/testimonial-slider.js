/**
 * Vanilla-JS carousel controller for the Testimonial Slider widget.
 * No external dependencies, no bundler - hand-written and enqueued directly.
 */
( function () {
	'use strict';

	function TestimonialSlider( $scope ) {
		// $scope is Elementor's outer .elementor-widget-* wrapper, NOT our own
		// .sagiris-ets root - the data-autoplay* attributes live on the latter,
		// a descendant, so they must be read from `carousel`, not `el`.
		var el = $scope && $scope[ 0 ] ? $scope[ 0 ] : $scope;
		var carousel = el && el.querySelector( '.sagiris-ets' );
		var track = carousel && carousel.querySelector( '.sagiris-ets__track' );

		if ( ! carousel || ! track ) {
			return;
		}

		var prevBtn = carousel.querySelector( '.sagiris-ets__arrow--prev' );
		var nextBtn = carousel.querySelector( '.sagiris-ets__arrow--next' );
		var dots = carousel.querySelectorAll( '.sagiris-ets__dot' );
		var slides = carousel.querySelectorAll( '.sagiris-ets__slide' );

		var autoplayEnabled = 'yes' === carousel.getAttribute( 'data-autoplay' );
		var autoplayDelay = parseInt( carousel.getAttribute( 'data-autoplay-delay' ), 10 ) || 5000;
		var autoplayTimer = null;
		var scrollEndTimer = null;

		function scrollByPage( direction ) {
			track.scrollBy( { left: direction * track.clientWidth, behavior: 'smooth' } );
		}

		function currentSlideIndex() {
			var trackLeft = track.getBoundingClientRect().left;
			var closestIndex = 0;
			var closestDistance = Infinity;

			for ( var i = 0; i < slides.length; i++ ) {
				var distance = Math.abs( slides[ i ].getBoundingClientRect().left - trackLeft );

				if ( distance < closestDistance ) {
					closestDistance = distance;
					closestIndex = i;
				}
			}

			return closestIndex;
		}

		function updateActiveDot() {
			if ( ! dots.length ) {
				return;
			}

			var index = currentSlideIndex();

			for ( var i = 0; i < dots.length; i++ ) {
				dots[ i ].classList.toggle( 'is-active', i === index );
			}
		}

		function goToSlide( index ) {
			var slide = slides[ index ];

			if ( slide ) {
				track.scrollTo( { left: slide.offsetLeft, behavior: 'smooth' } );
			}
		}

		function isAtEnd() {
			return track.scrollLeft + track.clientWidth >= track.scrollWidth - 1;
		}

		function startAutoplay() {
			if ( ! autoplayEnabled || autoplayTimer ) {
				return;
			}

			autoplayTimer = window.setInterval( function () {
				if ( isAtEnd() ) {
					track.scrollTo( { left: 0, behavior: 'smooth' } );
				} else {
					scrollByPage( 1 );
				}
			}, autoplayDelay );
		}

		function stopAutoplay() {
			if ( autoplayTimer ) {
				window.clearInterval( autoplayTimer );
				autoplayTimer = null;
			}
		}

		if ( prevBtn ) {
			prevBtn.addEventListener( 'click', function () {
				scrollByPage( -1 );
			} );
		}

		if ( nextBtn ) {
			nextBtn.addEventListener( 'click', function () {
				scrollByPage( 1 );
			} );
		}

		for ( var d = 0; d < dots.length; d++ ) {
			( function ( index ) {
				dots[ index ].addEventListener( 'click', function () {
					goToSlide( index );
				} );
			} )( d );
		}

		track.addEventListener( 'scroll', function () {
			window.clearTimeout( scrollEndTimer );
			scrollEndTimer = window.setTimeout( updateActiveDot, 100 );
		} );

		carousel.addEventListener( 'mouseenter', stopAutoplay );
		carousel.addEventListener( 'mouseleave', startAutoplay );
		carousel.addEventListener( 'focusin', stopAutoplay );
		carousel.addEventListener( 'focusout', function ( event ) {
			if ( ! carousel.contains( event.relatedTarget ) ) {
				startAutoplay();
			}
		} );

		carousel.addEventListener( 'keydown', function ( event ) {
			if ( 'ArrowLeft' === event.key ) {
				scrollByPage( -1 );
			} else if ( 'ArrowRight' === event.key ) {
				scrollByPage( 1 );
			}
		} );

		updateActiveDot();
		startAutoplay();
	}

	/* global jQuery, elementorFrontend */
	jQuery( window ).on( 'elementor/frontend/init', function () {
		elementorFrontend.hooks.addAction(
			'frontend/element_ready/sagiris-testimonial-slider.default',
			TestimonialSlider
		);
	} );
} )();
