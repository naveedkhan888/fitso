(function ($) {

'use strict';

/*!==========================================================================
 * ==========================================================================
 * ==========================================================================
 *
 * Rubenz – Creative Portfolio AJAX Template
 *
 * [Table of Contents]
 *
 * 1. PJAX Animate Cloned Image
 * 2. PJAX Animate Masthead
 * 3. PJAX Finish Loading
 * 4. PJAX Init New Page
 * 5. PJAX Prepare Transition
 * 6. PJAX Transition Fullscreen Slider
 * 7. PJAX Transition General
 * 8. PJAX Transition Halfscreen Slider
 * 9. PJAX Transition Masonry Grid
 * 10. PJAX Transition Nav Projects
 * 11. PJAX Transition Overlay Menu
 * 12. PJAX Update Admin Bar
 * 13. PJAX Update Body
 * 14. PJAX Update Cloud Flare Email Protection
 * 15. PJAX Update Head
 * 16. PJAX Update Header Classes
 * 17. PJAX Update Language Switcher
 * 18. PJAX Update Scripts
 * 19. PJAX Update Styles
 * 20. PJAX Update Trackers
 * 21. PJAX Update Nodes
 * 22. PJAX Wait Container Images
 * 23. PJAX
 * 24. Assets Manager
 * 25. Aside Counters
 * 26. Counter
 * 27. Debounce
 * 28. Cursor
 * 29. Figure Portfolio
 * 30. Figure Property
 * 31. Fix Mobile Bar Height
 * 32. Gmap
 * 33. Grid
 * 34. Form
 * 35. Header
 * 36. Lazy Load
 * 37. Menu Overlay
 * 38. Project Backgrounds
 * 39. Smooth Scroll
 * 40. Create OS Scene
 * 41. Get Scroll Top
 * 42. Lock Scroll
 * 43. Restore Scroll Top
 * 44. Scroll To Very Top
 * 45. Parallax
 * 46. Section Composition
 * 47. Section Content
 * 48. Section Half Screen Slider
 * 49. Section Headings Slider
 * 50. Section Intro
 * 51. Section Masthead
 * 52. Section Text Slider
 * 53. Section Nav Projects
 * 54. Slider Backgrounds
 * 55. Render Slider Counter
 * 56. Slider Half Screen
 * 57. Slider Headings
 * 58. Slider Images
 * 59. Slider Testimonials
 * 60. Slider Text
 * 61. Social
 * 62. Animate Lines
 * 63. Animate Words
 * 64. Do Split Text
 * 65. Hide Lines
 * 66. Hide Words
 * 67. Hide Words Vertical
 * 68. Set Lines
 * 69. Load Swiper
 * 70. Run On High Performance GPU
 * 71. Sanitize Selector
 * 72. Sync Attributes
 * 73. Elementor
 *
 * ==========================================================================
 * ==========================================================================
 * ==========================================================================
 */

/**
 * Try to use high performance GPU on dual-GPU systems
 */
runOnHighPerformanceGPU();

/**
 * Use passive listeners to improve scrolling performance
 */
jQuery.event.special.touchstart = {
  setup: function( _, ns, handle ){
    if ( ns.includes('noPreventDefault') ) {
      this.addEventListener('touchstart', handle, { passive: false });
    } else {
      this.addEventListener('touchstart', handle, { passive: true });
    }
  }
};

jQuery.event.special.touchend = {
  setup: function( _, ns, handle ){
    if ( ns.includes('noPreventDefault') ) {
      this.addEventListener('touchend', handle, { passive: false });
    } else {
      this.addEventListener('touchend', handle, { passive: true });
    }
  }
};

window.$document = $(document);
window.$window = $(window);
window.$html = $('html');
window.$pageWrapper = $('.page-wrapper');
window.$pageHeader = $('.header__wrapper-overlay-menu');
window.$barbaWrapper = $('[data-barba="wrapper"]');
window.$body = $('body');
window.$wrapperBackgrounds = $('.project-backgrounds');
window.$backgroundsOverlay = $('.project-backgrounds__overlay');
window.$overlay = $('.header__wrapper-overlay-menu');
window.$backgrounds = $('.project-backgrounds__background');
window.$backgroundLinks = $('a[data-post-id]');
window.$burger = $('#js-burger');
window.$header = $('.header');
window.$preloader = $('.preloader');
window.$curtains = $('.preloader__curtain');
window.$spinner = $('.js-spinner');
window.lastTop = 0;
window.isElementorLoaded = false;
window.isSwiperLoaded = false;
window.elementorComponentsLoaded = new Promise((resolve) => {
	setElementorComponentsLoaded = resolve;
});

function setElementorComponentsLoaded() {

}

if (typeof elementorFrontend !== 'undefined') {
	elementorFrontend.on('components:init', setElementorComponentsLoaded);
}

/**
 * Default Theme Options
 * Used to prevent errors if there is
 * no data provided from backend
 */

if (typeof window.theme === 'undefined') {
	window.theme = {
		themeURL: '',
		ajax: {
			enabled: true,
			preventRules: '',
			evalInlineContainerScripts: false,
			loadMissingScripts: false,
			loadMissingStyles: false,
		},
		updateHeadNodes: '',
		updateScriptNodes: '',
		smoothScroll: {
			damping: 0.06,
			renderByPixels: true,
			continuousScrolling: false,
			plugins: {
				edgeEasing: true
			}
		},
		contactForm7: {
			customModals: false
		},
		mobileBarFix: {
			enabled: true,
			update: true
		},
		assets: {
			promises: []
		}
	};
}

/**
 * ScrollMagic Setup
 */
window.SMController = new ScrollMagic.Controller();
window.SMController.enabled(false);
window.SMSceneTriggerHook = 0.8;
window.SMSceneReverse = false;

/**
 * Don't save scroll position
 * after AJAX transition
 */
if ('scrollRestoration' in history) {
	history.scrollRestoration = 'manual';
}

window.$document.ready(function () {
	if (typeof elementorFrontend !== 'undefined') {
		elementorFrontend.on('components:init', setElementorComponentsLoaded);
	}

	/**
	 * Split text only after ensuring
	 * that fonts are rendered
	 */
	Promise.all([,
		loadSwiper(),
		document.fonts.ready
	])
		.then(function () {
			return doSplitText();
		})
		.then(function () {
			return setLines();
		})
		.then(function () {
			initComponents(window.$document);
			window.$pageWrapper.removeClass('page-wrapper_hidden');
			window.SMController.enabled(true);
			window.SMController.update(true);
			window.$body.removeClass('cursor-progress');
		});

	new PJAX();
	new ProjectBackgrounds();
	window.InteractiveCursor = new Cursor();

});

function initComponents($scope = window.$document, scrollToHash = true) {

	new SmoothScroll();

	window.PageHeader = new Header();

	if (typeof window.PageMenu === 'undefined') {
		window.PageMenu = new MenuOverlay();
	}

	new Parallax($scope);
	new Grid();
	new Form();
	new SliderImages($scope);
	new SliderTestimonials($scope);
	new AsideCounters($scope);
	new GMap($scope);
	new SectionMasthead($scope);
	new SectionContent($scope);
	new SectionIntro($scope);
	new SectionTextSlider($scope);
	new SectionHeadingsSlider($scope);
	new SectionHalfScreenSlider($scope)
	new SectionNavProjects($scope)
	new SectionComposition($scope);
	new FigurePortfolio($scope);
	new FigureProperty($scope);
	$('.js-video').magnificPopup();
	lazyLoad($scope);

	if (window.theme.mobileBarFix.enabled) {
		fixMobileBarHeight();
	}

	// refresh animation triggers
	// for Waypoints library
	if (typeof Waypoint !== 'undefined') {
		Waypoint.refreshAll();
	}

	// Elementor Pro Lottie refresh
	if (typeof lottie !== 'undefined') {
		setTimeout(() => {
			lottie.play();
		}, 300);
	}

	// custom JS code
	if (window.theme.customJSInit) {
		try {
			window.eval(window.theme.customJSInit);
		} catch (error) {
			console.warn(error);
		}
	}

	if (scrollToHash && window.location.hash && !window.location.hash.startsWith('#elementor-action')) {
		setTimeout(() => {
			try {
				var
					$scrollElement = $(window.location.hash),
					time = 800;

				if ($scrollElement.length) {
					var offsetY = $scrollElement.offset().top;

					if (typeof window.SB !== 'undefined') {
							window.SB.scrollTo(0, offsetY, time);
						} else {
							$('html, body').animate({
								scrollTop: offsetY
							}, time);
						}

				}
			} catch (error) {
				console.warn(error);
			}
		}, 600);
	}

}

/*!========================================================================
	1. PJAX Animate Cloned Image
	======================================================================!*/
function PJAXAnimateClonedImage(data, $customPositionElement, delay = 0) {

	return new Promise(function (resolve, reject) {
		var
			tl = new TimelineMax(),
			$trigger = $(data.trigger),
			$postId = $trigger.data('post-id'),
			$targetBackground = window.$backgrounds.filter('[data-background-for=' + $postId + ']'),
			$img = $customPositionElement ? $customPositionElement : $trigger.find('img[src], video[src]');

		if (!$img.length) {
			resolve(true);
			return;
		}
		setTimeout(() => {

			var
				$clone = $img.clone(),
				imgPosition = $img.get(0).getBoundingClientRect();

			tl
				.set($clone, {
					position: 'fixed',
					top: imgPosition.top,
					left: imgPosition.left,
					width: imgPosition.width,
					height: imgPosition.height,
					className: '+=of-cover',
					zIndex: 300
				})
				.add(function () {
					$targetBackground.addClass('selected');
					$clone.appendTo(window.$barbaWrapper);
				})
				.set(window.$backgroundsOverlay, {
					autoAlpha: 0
				})
				.to($clone, 1.2, {
					transition: 'none',
					transform: 'none',
					top: 0,
					left: 0,
					width: '100vw',
					height: '100vh',
					ease: Expo.easeInOut
				})
				.set(window.$wrapperBackgrounds, {
					backgroundColor: 'transparent',
					scaleX: 1,
					zIndex: 400,
					autoAlpha: 1
				})
				.add(function () {

					// scroll window to the top
					scrollToVeryTop();

					// Safari fix of jumping/flashing window
					setTimeout(function () {

						// remove clonned image
						$clone.remove();
						resolve(true);

					}, 100);

				});
		}, delay);

	});

}

/*!========================================================================
	2. PJAX Animate Masthead
	======================================================================!*/
function PJAXAnimateMasthead(data) {

	return new Promise(function (resolve, reject) {

		var
			$nextContainer = $(data.next.container),
			$nextMasthead = $nextContainer.find('.section-masthead').first(),
			$nextBgWrapper = $nextMasthead.find('.section-masthead__background'),
			tl = new TimelineMax(),
			$selectedBackground = window.$backgrounds.filter('.selected');

		scrollToVeryTop();

		if (!$selectedBackground.length || !$nextBgWrapper.length) {
			resolve(true);
		} else {

			var $nextOverlay = $nextMasthead.find('.section-masthead__overlay:not(.d-none)');

			if ($nextOverlay.length) {
				tl.to(window.$backgroundsOverlay, 0.6, {
					autoAlpha: $nextOverlay.css('opacity'),
					ease: Expo.easeInOut
				}, '0');

			} else {

				tl.set(window.$backgroundsOverlay, {
					autoAlpha: 0
				}, '0');

			}

			$nextMasthead.imagesLoaded(function () {

				var
					$nextBgWrapper = $nextMasthead.find('.section-masthead__background'),
					$nextBg = $nextBgWrapper.find('.art-parallax__bg'),
					nextBgWrapperPosition = $nextBgWrapper.get(0).getBoundingClientRect(),
					transformMatrix = $nextBg.css('transform');

				tl
					.add([
						TweenMax.to(window.$wrapperBackgrounds, 1.2, {
							top: nextBgWrapperPosition.top,
							left: nextBgWrapperPosition.left,
							width: nextBgWrapperPosition.width,
							height: nextBgWrapperPosition.height,
							ease: Expo.easeInOut,
						}),
						TweenMax.to($selectedBackground, 1.2, {
							transition: 'none',
							transform: transformMatrix,
							ease: Expo.easeInOut,
						})
					], '0')
					.set(window.$wrapperBackgrounds, {
						autoAlpha: 0
					})
					.add(function () {
						resolve(true);
					});

			});

		}

	});

}

/*!========================================================================
	3. PJAX Finish Loading
	======================================================================!*/
function PJAXFinishLoading(data) {

	return new Promise(function (resolve, reject) {

		// Transition ended event
		window.dispatchEvent(new CustomEvent('arts/barba/transition/end'));

		window.SMController.enabled(true);
		window.SMController.update(true);
		window.$backgrounds.removeClass('selected active');
		window.$header.removeClass('header_lock-submenus');
		window.InteractiveCursor.finishLoading();
		lockScroll(false);

		TweenMax.to(window.$spinner, 1.2, {
			autoAlpha: 0
		});

		TweenMax.set(window.$preloader, {
			autoAlpha: 0
		});

		TweenMax.set(window.$wrapperBackgrounds, {
			autoAlpha: 0,
			zIndex: -1,
			clearProps: 'width,height,left,right,top,bottom,backgroundColor',
		});

		TweenMax.set(window.$backgroundsOverlay, {
			autoAlpha: 1
		});

		TweenMax.set(window.$backgrounds, {
			transition: '',
			clearProps: 'transform,width,height',
		});

		$('.dialog-lightbox-widget').remove();

		setTimeout(function () {
			window.$overlay.removeClass('intransition lockhover opened');
		}, 300);

		if (window.location.hash && !window.location.hash.startsWith('#elementor-action')) {
			setTimeout(() => {
				try {
					var
						$scrollElement = $(window.location.hash),
						time = 800;

					if ($scrollElement.length) {
						var offsetY = $scrollElement.offset().top;

						if (typeof window.SB !== 'undefined') {
							window.SB.scrollIntoView($scrollElement.get(0));
								// window.SB.scrollTo(0, offsetY, time);
							} else {
								$('html, body').animate({
									scrollTop: offsetY
								}, time);
							}

					}
				} catch (error) {
					console.warn(error);
				}
			}, 1000);
		}

		resolve(true);

	});

}

/*!========================================================================
	4. PJAX Init New Page
	======================================================================!*/
function PJAXInitNewPage(data) {

	return new Promise(function (resolve, reject) {
		const
			promises = [
				PJAXUpdateAdminBar(data),
				PJAXUpdateLanguageSwitcher(data),
				PJAXUpdateBodyClasses(data),
				PJAXUpdateHeaderClasses(data),
				PJAXUpdateHead(data),
				PJAXUpdateNodes(data)
			],
			$currentContainer = $(data.current.container),
			$nextContainer = $(data.next.container),
			$elementorSections = $nextContainer.find('.elementor-section'),
			$cf7Forms = $nextContainer.find('.wpcf7-form'),
			event = new CustomEvent('DOMContentLoaded', {
				detail: {
					container: $nextContainer,
					scrollToHashElement: false // will scroll to the anchors later  once transition is fully finished
				}
			});

		$currentContainer.remove();

		if (window.theme.ajax.loadMissingScripts || window.theme.updateScriptNodes) {
			promises.push(PJAXUpdateScripts(data));
		}

		if (window.theme.ajax.loadMissingStyles) {
			promises.push(PJAXUpdateStyles(data));
		}

		// Ppdate page wrapper element
		window.$pageWrapper = $nextContainer;

		return Promise
			.all(promises)
			.then(() => document.fonts.ready)
			.then(function () {

				// Elementor Pro sticky effects handling
				TweenMax.set($elementorSections, {
					clearProps: 'all',
					className: '-=elementor-sticky--active'
				});
				$nextContainer.find('.elementor-sticky__spacer').remove();

				// Elementor Animated Headline reset
				$nextContainer.find('.elementor-headline-animation-type-typing .elementor-headline-dynamic-wrapper').empty();

				// Elementor Pro Lottie animations reset
				$nextContainer.find('.e-lottie__animation').empty();

				// re-init Contact Form 7 Conditional Fields plugin
				if ($cf7Forms.length && typeof wpcf7cf === 'object' && typeof wpcf7cf.initForm === 'function') {
					wpcf7cf.initForm($cf7Forms);
				}

				// re-init WPForms plugin
				if (typeof wpforms !== 'undefined' && typeof wpforms.init === 'function') {
					wpforms.init();
				}

				// clear & re-init ScrollMagic
				window.SMController.destroy(true);
				window.SMController = new ScrollMagic.Controller();

				// split text lines in new container
				doSplitText($nextContainer).then(setLines($nextContainer)).then(function () {

					// scroll to the top
					setTimeout(function () {
						scrollToVeryTop();
					}, 100);

					if (typeof window.elementorFrontend !== 'undefined') {
						elementorFrontend.init();
					}

					// Transition init new page event
					window.dispatchEvent(new CustomEvent('arts/barba/transition/init'));

					// re-init components
					initComponents($nextContainer, false);
					window.SMController.enabled(false);

					// fire ready event
					document.dispatchEvent(event);

					if (window.theme.ajax.evalInlineContainerScripts) {

						// eval inline scripts in the main container
						$nextContainer.find('script').each(function () {
							try {
								window.eval(this.text);
							} catch (error) {
								console.warn(error);
							}
						});

					}

					// update ad trackers
					PJAXUpdateTrackers();

					// update CloudFlare email protection
					PJAXUpdateCloudFlareEmailProtection();

				});

				// change header color if needed
				switch (data.next.namespace) {
					case 'light': {
						window.$header.removeClass('header_white').addClass('header_black');
						break;
					}
					case 'dark': {
						window.$header.removeClass('header_black').addClass('header_white');
						break;
					}
				}

				$nextContainer.removeClass('page-wrapper_hidden');

				resolve(true);
			})
			.catch((e) => {
				barba.force(data.next.url.href);
				console.warn(e);
			});

	});

}

/*!========================================================================
	5. PJAX Prepare Transition
	======================================================================!*/
function PJAXPrepareTransition(data) {

	return new Promise(function (resolve, reject) {

		var $trigger = $(data.trigger);

		// Transition started event
		window.dispatchEvent(new CustomEvent('arts/barba/transition/start'));

		window.$document.off('click');
		window.$window.off('resize');
		window.InteractiveCursor.drawLoading();
		window.$overlay.addClass('intransition lockhover');
		$trigger.addClass('selected');

		TweenMax.set(window.$curtains, {
			scaleX: 0,
			transformOrigin: 'left center'
		});

		TweenMax.set(window.$preloader, {
			autoAlpha: 1
		});

		TweenMax.to(window.$spinner, 0.6, {
			autoAlpha: 1
		});

		// Elementor Pro Lottie animations
		if (typeof lottie !== 'undefined') {
			lottie.destroy();
		}

		resolve(true);

	});

}

/*!========================================================================
	6. PJAX Transition Fullscreen Slider
	======================================================================!*/
var PJAXTransitionFullscreenSlider = {
	name: 'fullscreenSlider',
	custom: ({
		current,
		next,
		trigger
	}) => {
		return $(trigger).data('pjax-link') == 'fullscreenSlider';
	},
	before: (data) => {

		return new Promise(function (resolve, reject) {

			PJAXPrepareTransition(data).then(function () {
				resolve(true);
			});

		});

	},
	beforeLeave: (data) => {

		return new Promise(function (resolve, reject) {

			var
				tl = new TimelineMax(),
				$target = $('.section-fullscreen-slider'),
				$backgroundOverlay = $target.find('.slider__background-overlay');

			tl
				.set(window.$wrapperBackgrounds, {
					zIndex: -1,
					scaleX: 1,
					autoAlpha: 1,
					backgroundColor: 'transparent',
				})
				.set(window.$backgroundsOverlay, {
					autoAlpha: 0
				})
				.to($backgroundOverlay, 0.6, {
					autoAlpha: 0,
					ease: Expo.easeInOut
				}, '0')
				.to($target, 1.2, {
					autoAlpha: 0,
					ease: Expo.easeInOut
				}, '0.6')
				.to(window.$wrapperBackgrounds, 0.3, {
					autoAlpha: 1,
					zIndex: 400,
					ease: Expo.easeInOut
				}, '0.3')
				.add(function () {
					resolve(true);
				});

		});

	},
	enter: (data) => {

		return new Promise(function (resolve, reject) {

			PJAXInitNewPage(data).then(function () {
				resolve(true)
			});

		});

	},
	afterEnter: (data) => {

		return new Promise(function (resolve, reject) {

			PJAXAnimateMasthead(data).then(function () {
				resolve(true);
			});

		});

	},
	after: (data) => {

		return new Promise(function (resolve, reject) {

			PJAXFinishLoading(data).then(function () {
				resolve(true);
			});

		});

	}
}

/*!========================================================================
	7. PJAX Transition General
	======================================================================!*/
var PJAXTransitionGeneral = {

	before() {
		window.InteractiveCursor.drawLoading();
	},

	beforeLeave: (data) => {

		return new Promise(function (resolve, reject) {

			PJAXPrepareTransition(data).then(function () {
				resolve(true)
			});

		});

	},

	leave: (data) => {

		return new Promise(function (resolve, reject) {

			var
				tl = new TimelineMax(),
				$currentContainer = $(data.current.container);

			tl.timeScale(1.5);

			if (!$overlay.hasClass('opened')) {

				tl.to($currentContainer, 1.2, {
					x: '10vw',
					force3D: true,
					transformOrigin: 'left center',
					ease: Expo.easeInOut
				});

				tl
					.to($curtains, 0.6, {
						scaleX: 1,
						transformOrigin: 'left center',
						ease: Expo.easeInOut
					}, '0.2');

			}

			tl
				.add(function () {
					window.$header.removeClass('header_black').addClass('header_white');
				}, '0')
				.add(function () {
					$currentContainer.remove();
					resolve(true);
				});

		});

	},

	enter: (data) => {

		return new Promise(function (resolve, reject) {

			PJAXInitNewPage(data).then(function () {
				resolve(true)
			});

		});

	},

	afterEnter: (data) => {

		return new Promise(function (resolve, reject) {

			var
				tl = new TimelineMax(),
				$nextContainer = $(data.next.container),
				$nextMasthead = $nextContainer.find('.section-masthead').first(),
				$nextBg = $nextMasthead.find('.section-masthead__background .art-parallax__bg');

			tl
				.set($burger, {
					className: '-=header__burger_opened'
				})
				.set($nextContainer, {
					autoAlpha: 1,
					x: '-5vw',
					force3D: true,
					transformOrigin: 'right center',
				});

			// animate (close) header if it's opened
			if (window.$pageHeader.hasClass('opened')) {

				var tlClose = $nextBg.length ? window.PageHeader.hideOverlayMenu(false) : window.PageHeader.hideOverlayMenu(true);

				tl
					.add(tlClose, '0')
					.set(window.$overlay, {
						className: '+=intransition'
					})
					.to($nextContainer, 1.2, {
						x: '0vw',
						force3D: true,
						ease: Expo.easeInOut,
						onComplete: () => {
							TweenMax.set($nextContainer, {
								clearProps: 'all'
							});
						}
					});

			} else {

				tl
					.to($nextContainer, 1.2, {
						x: '0vw',
						force3D: true,
						ease: Expo.easeInOut,
						onComplete: () => {
							TweenMax.set($nextContainer, {
								clearProps: 'all'
							});
						}
					})
					.to(window.$curtains, 0.6, {
						scaleX: 0,
						transformOrigin: 'right center',
						ease: Expo.easeInOut
					}, '0.3');

			}

			tl
				.set(window.$overlay, {
					className: '+=intransition'
				})
				.add(function () {
					resolve(true);
				}, '-=0.3');


		});

	},

	after: (data) => {

		return new Promise(function (resolve, reject) {
			PJAXFinishLoading(data).then(function () {
				resolve(true);
			});

		});

	}

}

/*!========================================================================
	8. PJAX Transition Halfscreen Slider
	======================================================================!*/
var PJAXTransitionHalfscreenSlider = {
	name: 'halfscreenSlider',
	custom: ({
		current,
		next,
		trigger
	}) => {
		return $(trigger).data('pjax-link') == 'halfscreenSlider';
	},
	before: (data) => {

		return new Promise(function (resolve, reject) {

			PJAXPrepareTransition(data).then(function () {
				resolve(true);
			});

		});

	},
	beforeLeave: (data) => {

		return new Promise(function (resolve, reject) {

			var
				tl = new TimelineMax(),
				shift = '10vw',
				$sliderMain = $(data.trigger).parents('.slider-halfscreen'),
				$sliderContent = $sliderMain.find('.slider-halfscreen__content'),
				$wrapperImg = $sliderMain.find('.slider-halfscreen__images-slide.swiper-slide-active .slider-halfscreen__images-slide-inner'),
				$mobileOverlay = $sliderMain.find('.slider-halfscreen__overlay'),
				$customPositionElement = $sliderMain.find('.slider-halfscreen__images-slide.swiper-slide-active .slider-halfscreen__bg');

			if ($sliderMain.hasClass('flex-lg-row-reverse')) {
				shift = '-10vw';
			}

			tl
				.to($wrapperImg, 0.6, {
					scale: 1
				})
				.to($sliderContent, 1.2, {
					x: shift,
					autoAlpha: 0,
					ease: Expo.easeInOut
				}, '0.6')
				.to($mobileOverlay, 0.6, {
					autoAlpha: 0
				}, '0')
				.set(window.$wrapperBackgrounds, {
					zIndex: 400,
					scaleX: 1,
					autoAlpha: 1,
					backgroundColor: 'transparent',
				})
				.set(window.$backgroundsOverlay, {
					autoAlpha: 0
				})
				.add(function () {
					PJAXAnimateClonedImage(data, $customPositionElement).then(function () {
						resolve(true);
					});
				}, '0.6');

		});

	},
	enter: (data) => {

		return new Promise(function (resolve, reject) {

			PJAXInitNewPage(data).then(function () {
				resolve(true)
			});

		});

	},
	afterEnter: (data) => {

		return new Promise(function (resolve, reject) {

			PJAXAnimateMasthead(data).then(function () {
				resolve(true);
			});

		});

	},
	after: (data) => {

		return new Promise(function (resolve, reject) {

			PJAXFinishLoading(data).then(function () {
				resolve(true);
			});

		});

	}
}

/*!========================================================================
	9. PJAX Transition Masonry Grid
	======================================================================!*/
var PJAXTransitionMasonryGrid = {
	name: 'masonryGrid',
	custom: ({
		current,
		next,
		trigger
	}) => {
		return $(trigger).data('pjax-link') == 'masonryGrid';
	},
	before: (data) => {

		return new Promise(function (resolve, reject) {

			PJAXPrepareTransition(data).then(function () {
				resolve(true);
			});

		});

	},
	beforeLeave: (data) => {

		return new Promise(function (resolve, reject) {

			PJAXAnimateClonedImage(data, null, 600).then(function () {
				resolve(true)
			});

		});

	},
	enter: (data) => {

		return new Promise(function (resolve, reject) {

			PJAXInitNewPage(data).then(function () {
				resolve(true)
			});

		});

	},
	afterEnter: (data) => {

		return new Promise(function (resolve, reject) {

			PJAXAnimateMasthead(data).then(function () {
				resolve(true);
			});

		});

	},
	after: (data) => {

		return new Promise(function (resolve, reject) {

			PJAXFinishLoading(data).then(function () {
				resolve(true);
			});

		});

	}
}

/*!========================================================================
	10. PJAX Transition Nav Projects
	======================================================================!*/
var PJAXTransitionNavProjects = {
	name: 'navProjects',
	custom: ({
		current,
		next,
		trigger
	}) => {
		return $(trigger).data('pjax-link') == 'navProjects';
	},
	before: (data) => {

		return new Promise(function (resolve, reject) {

			PJAXPrepareTransition(data).then(function () {
				resolve(true);
			});

		});

	},
	beforeLeave: (data) => {

		return new Promise(function (resolve, reject) {

			var
				tl = new TimelineMax(),
				$customPositionElement = $('.section-nav-projects__backgrounds'),
				$inner = $('.section-nav-projects__inner'),
				$backgroundOverlay = $('.section-nav-projects__overlay');

			tl
				.to($inner, 0.3, {
					transition: 'none',
					autoAlpha: 0,
					ease: Expo.easeInOut,
				}, '0')
				.to($backgroundOverlay, 0.3, {
					transition: 'none',
					autoAlpha: 0,
					ease: Expo.easeInOut,
				}, '0')
				.add(function () {
					PJAXAnimateClonedImage(data, $customPositionElement).then(function () {
						resolve(true);
					});
				});

		});

	},
	enter: (data) => {

		return new Promise(function (resolve, reject) {

			PJAXInitNewPage(data).then(function () {
				resolve(true);
			});

		});

	},
	afterEnter: (data) => {

		return new Promise(function (resolve, reject) {

			PJAXAnimateMasthead(data).then(function () {
				resolve(true);
			});

		});

	},
	after: (data) => {

		return new Promise(function (resolve, reject) {

			PJAXFinishLoading(data).then(function () {
				resolve(true);
			});

		});

	}
}

/*!========================================================================
	11. PJAX Transition Overlay Menu
	======================================================================!*/
var PJAXTransitionOverlayMenu = {
	name: 'overlayMenu',
	custom: ({
		current,
		next,
		trigger
	}) => {
		return $(trigger).data('pjax-link') == 'overlayMenu';
	},

	before: (data) => {

		return new Promise(function (resolve, reject) {

			PJAXPrepareTransition(data).then(function () {
				lockScroll(false);
				resolve(true);
			});

		});

	},

	enter: (data) => {

		return new Promise(function (resolve, reject) {

			PJAXInitNewPage(data).then(function () {

				var
					tl = new TimelineMax(),
					$nextContainer = $(data.next.container),
					$nextMasthead = $nextContainer.find('.section-masthead').first(),
					$nextBg = $nextMasthead.find('.section-masthead__background .art-parallax__bg'),
					tlClose = $nextBg.length ? window.PageHeader.hideOverlayMenu(false) : window.PageHeader.hideOverlayMenu(true),
					$nextOverlay = $nextMasthead.find('.section-masthead__overlay:not(.d-none)');

				if ($nextBg.length) {

					if ($nextOverlay.length) {

						tl.to(window.$backgroundsOverlay, 1.2, {
							autoAlpha: 0.6,
							transition: 'none',
							ease: Expo.easeInOut,
						});

					} else {

						tl.to(window.$backgroundsOverlay, 1.2, {
							autoAlpha: 0,
							transition: 'none',
							ease: Expo.easeInOut,
						});

					}

				} else {
					scrollToVeryTop();
					window.lastTop = 0;
				}

				tl
					.add(tlClose, '0')
					.to($nextContainer, 1.2, {
						x: '0vw',
						force3D: true,
						ease: Expo.easeInOut,
						onComplete: () => {
							TweenMax.set($nextContainer, {
								clearProps: 'all'
							});
						}
					}, '0.4')
					.set(window.$preloader, {
						autoAlpha: 0
					})
					.set(window.$overlay, {
						className: '+=intransition'
					})
					.set(window.$wrapperBackgrounds, {
						backgroundColor: 'transparent'
					})
					.add(function () {
						resolve(true);
					});

			});

		});

	},

	afterEnter: (data) => {

		return new Promise(function (resolve, reject) {

			PJAXAnimateMasthead(data).then(function () {
				resolve(true);
			});

		});

	},
	after: (data) => {

		return new Promise(function (resolve, reject) {

			PJAXFinishLoading(data).then(function () {
				resolve(true);
			});

		});

	}
}

/*!========================================================================
	12. PJAX Update Admin Bar
	======================================================================!*/
function PJAXUpdateAdminBar(data) {
	return new Promise(function (resolve, reject) {
		const
			$elementorAdminBarConfigScript = $('#elementor-admin-bar-js-before'),
			$currentBar = $('#wpadminbar');

		if (!$currentBar.length) {
			resolve(true);
			return;
		}

		const
			$rawHTML = $($.parseHTML(data.next.html, undefined, true)),
			$newBar = $rawHTML.filter('#wpadminbar');

		if ($newBar.length) {
			$newBar.find('.hide-if-no-customize').removeClass('hide-if-no-customize');
			$currentBar.html($newBar.html());
		}

		// re-init Elementor admin bar buttons
		if (document.body.classList.contains('elementor-page') && $elementorAdminBarConfigScript.length) {
			try {
				const $nextElementorAdminBarConfigScript = $rawHTML.filter('#elementor-admin-bar-js-before');

				if ($nextElementorAdminBarConfigScript.length) {
					// update the script contents
					$elementorAdminBarConfigScript.html($nextElementorAdminBarConfigScript.text());

					// eval new script params
					window.eval($elementorAdminBarConfigScript.text());
				}

			} catch (err) {
				console.warn(err);
			}
		}

		resolve(true);
	});
}

/*!========================================================================
	13. PJAX Update Body
	======================================================================!*/
function PJAXUpdateBodyClasses(data) {

	return new Promise(function (resolve, reject) {

		var
			regexp = /\<body.*\sclass=["'](.+?)["'].*\>/gi,
			match = regexp.exec(data.next.html);

		if (!match || !match[1]) {
			return;
		}

		// Interrupt the transition
		// Current page prevents all the inner links from transition
		if (document.body.classList.contains('no-ajax')) {
			reject('Transition has been interrupted: Origin page prevents all the inner links from transition.');
			return;
		}

		// Sync new container body classes
		document.body.setAttribute('class', match[1]);

		// Interrupt the transition
		// Destination page doesn't allow to perform AJAX transition
		if (document.body.classList.contains('page-no-ajax')) {
			reject('Transition has been interrupted: Destination page requested a hard refresh.');
			return;
		}

		// Hide theme header on Elementor Canvas page
		if (document.body.classList.contains('elementor-template-canvas')) {
			window.$header.addClass('hidden');
		}

		// Clear window overflow rule in case Elementor Canvas page
		// doesn't have smooth scrolling container
		if (!$(data.next.container).find('.js-smooth-scroll').length) {
			TweenMax.set(window.$html, {
				clearProps: 'overflow'
			});
		}

		resolve(true);
	});

}

/*!========================================================================
	14. PJAX Update Cloud Flare Email Protection
	======================================================================!*/
function PJAXUpdateCloudFlareEmailProtection() {
	var HEADER = "/cdn-cgi/l/email-protection#",
		SPECIAL_SELECTOR = ".__cf_email__",
		SPECIAL_ATTRIBUTE = "data-cfemail",
		DIV = document.createElement("div");

	function error(e) {
		try {
			if ("undefined" == typeof console) return;
			"error" in console ? console.error(e) : console.log(e)
		} catch (e) { }
	}

	function sanitize(e) {
		DIV.innerHTML = '<a href="' + e.replace(/"/g, "&quot;") + '"></a>';
		return DIV.childNodes[0].getAttribute("href") || ""
	}

	function nextHex(hexstr, skip) {
		return parseInt(hexstr.substr(skip, 2), 16)
	}

	function decrypt(ciphertext, skip) {
		for (var out = "", magic = nextHex(ciphertext, skip), i = skip + 2; i < ciphertext.length; i += 2) {
			var hex = nextHex(ciphertext, i) ^ magic;
			out += String.fromCharCode(hex)
		}
		try {
			out = decodeURIComponent(escape(out))
		} catch (err) {
			error(err)
		}
		return sanitize(out)
	}

	function decryptLinks(doc) {
		for (var links = doc.querySelectorAll("a"), c = 0; c < links.length; c++) try {
			var currentLink = links[c];
			var a = currentLink.href.indexOf(HEADER);
			a > -1 && (currentLink.href = "mailto:" + decrypt(currentLink.href, a + HEADER.length))
		} catch (err) {
			error(err)
		}
	}

	function decryptOthers(doc) {
		for (var specials = doc.querySelectorAll(SPECIAL_SELECTOR), c = 0; c < specials.length; c++) try {
			var current = specials[c],
				parent = current.parentNode,
				ciphertext = current.getAttribute(SPECIAL_ATTRIBUTE);
			if (ciphertext) {
				var email = decrypt(ciphertext, 0),
					tmpDOM = document.createTextNode(email);
				parent.replaceChild(tmpDOM, current)
			}
		} catch (err) {
			error(err)
		}
	}

	function decryptTemplates(doc) {
		for (var templates = doc.querySelectorAll("template"), n = 0; n < templates.length; n++) try {
			init(templates[n].content)
		} catch (err) {
			error(err)
		}
	}

	function init(doc) {
		try {
			decryptLinks(doc);
			decryptOthers(doc);
			decryptTemplates(doc);
		} catch (err) {
			error(err)
		}
	}

	init(document);
}

/*!========================================================================
	15. PJAX Update Head
	======================================================================!*/
function PJAXUpdateHead(data) {
	return new Promise((resolve, reject) => {
		let
			head = document.head,
			newPageRawHead = data.next.html.match(/<head[^>]*>([\s\S.]*)<\/head>/i)[0],
			newPageHead = document.createElement('head'),
			customNodes = sanitizeSelector(window.theme.updateHeadNodes),
			oldHeadTags,
			newHeadTags,
			newStylesLoaded,
			pageStyles,
			headTags = [
				'meta[name="keywords"]',
				'meta[name="description"]',
				'meta[property^="og"]',
				'meta[name^="twitter"]',
				'meta[itemprop]',
				'link[itemprop]',
				'link[rel="prev"]',
				'link[rel="next"]',
				'link[rel="canonical"]',
				'link[rel="alternate"]',
				'link[rel="shortlink"]',
				'link[id*="elementor-post"]',
				'link[id*="eael"]', // Essential Addons plugin post CSS
				'link[id*="theplus-"]', // ThePlus Elementor addon
				'link[id*="pafe-"]', // Piotnet Pafe Elementor addon
				'style[id*=elementor-frontend-inline]',
				'style[id*="elementor-post"]',
				'style[id*="eael"]', // Essential Addons plugin inline CSS
				'style[id*="theplus-"]', // ThePlus Elementor addon
				'style[id*="pafe-"]', // Piotnet Pafe Elementor addon
				'link[id*="google-fonts"]', // Elementor inline fonts
			];

		// Custom head nodes to update
		if (customNodes) {
			headTags = [...headTags, ...customNodes.split(',')]

			// Make the node names unique
			headTags = [... new Set(headTags)];
		}

		// Prepare the selector
		headTags = headTags.join(',');

		newPageHead.innerHTML = newPageRawHead;

		try {
			oldHeadTags = head.querySelectorAll(headTags),
			newHeadTags = newPageHead.querySelectorAll(headTags),
			newStylesLoaded = [];
			pageStyles = document.querySelectorAll('link[rel="stylesheet"]');

		} catch (error) {
			reject(`Transition has been interrupted: invalid selector given "${customNodes}"`);
		}

		// flag all current page styles as loaded
		for (let i = 0; i < pageStyles.length; i++) {
			pageStyles[i].isLoaded = true;
		}
		// append new and remove old tags
		for (let i = 0; i < newHeadTags.length; i++) {
			if (typeof oldHeadTags[i] !== 'undefined') {
				head.insertBefore(newHeadTags[i], oldHeadTags[i].nextElementSibling);
				head.removeChild(oldHeadTags[i]);
			} else {
				head.insertBefore(newHeadTags[i], newHeadTags[i - 1]);
			}
		}

		// page now has new styles
		pageStyles = document.querySelectorAll('link[rel="stylesheet"]');

		// listen for 'load' only on elements which are not loaded yet
		for (let i = 0; i < pageStyles.length; i++) {
			if (!pageStyles[i].isLoaded) {
				const promise = new Promise((resolve) => {
					pageStyles[i].addEventListener('load', () => {
						resolve(true);
					});
				});

				newStylesLoaded.push(promise);
			}
		}

		// load all new page styles
		Promise.all(newStylesLoaded).then(() => {
			resolve(true);
		});

	});
}

/*!========================================================================
	16. PJAX Update Header Classes
	======================================================================!*/
function PJAXUpdateHeaderClasses(data) {

	return new Promise(function (resolve, reject) {

		var
			regexp = /\<header.*\sclass=["'](.+?)["'].*\>/gi,
			match = regexp.exec(data.next.html);

		if (!match || !match[1]) {
			return;
		}

		document.querySelector('header').setAttribute('class', match[1]);

		resolve(true);

	});

}

/*!========================================================================
	17. PJAX Update Language Switcher
	======================================================================!*/
function PJAXUpdateLanguageSwitcher(data) {

	return new Promise(function (resolve, reject) {

		var $currentSwitcher = $('.lang-switcher');

		if (!$currentSwitcher.length) {
			resolve(true);
			return;
		}

		var
			rawHTML = $.parseHTML(data.next.html, document, true), // make sure to parse <script> tags as well
			$newSwitcher = $(rawHTML).find('.lang-switcher'),
			$trpSwitcher = $newSwitcher.find('.trp-language-switcher'); // TranslatePress language switcher

		$currentSwitcher.replaceWith($newSwitcher);

		// eval language switcher inline scripts
		$newSwitcher.find('script').each(function () {
			try {
				window.eval(this.text);
			} catch (error) {
				console.warn(error);
			}
		});

		// reset width of TranslatePress language switcher
		if ($trpSwitcher.length) {
			TweenMax.set($newSwitcher.find('.trp-ls-shortcode-language, .trp-ls-shortcode-current-language'), {
				clearProps: 'width'
			});
		}

		resolve(true);

	});

}

/*!========================================================================
	18. PJAX Update Scripts
	======================================================================!*/
function PJAXUpdateScripts(data) {
  return new Promise((resolve) => {
    const
      nextDocument = jQuery.parseHTML(data.next.html, document, true),
      scriptsToLoad = [],
      customNodes = sanitizeSelector(window.theme.updateScriptNodes) || [],
      $nextScripts = $(nextDocument).filter('script[src][id]');

    $nextScripts.each(function () {
      const
        queryString = `script[id="${this.id}"]`,
        element = document.querySelector(queryString);

      // load script that's not present on the current page
      if (typeof element === 'undefined' || element === null) {
        scriptsToLoad.push(AssetsManager.load({
          type: 'script',
          id: this.id,
          src: this.src
        }));
      } else if (customNodes.includes(queryString)) { // force update existing script

        // remove current script
        element.remove();

        // re-load script
        scriptsToLoad.push(AssetsManager.load({
          type: 'script',
          id: this.id,
          src: this.src,
          update: true
        }));
      }
    });

    Promise
      .all(scriptsToLoad)
      .then(() => resolve(true), () => resolve(true));
  });
}

/*!========================================================================
	19. PJAX Update Styles
	======================================================================!*/
function PJAXUpdateStyles(data) {
  return new Promise((resolve) => {
    const
      nextDocument = jQuery.parseHTML(data.next.html, document, true),
      stylesToLoad = [],
      $nextStyles = $(nextDocument).filter('link[rel="stylesheet"][id]');

    $nextStyles.each(function (index) {
      const element = document.querySelector(`link[id="${this.id}"]`);

      // load stylesheet that's not present on the current page
      if (typeof element === 'undefined' || element === null) {
        stylesToLoad.push(AssetsManager.load({
          type: 'style',
          id: this.id ? this.id : `pjax-asset-${index}-css`,
          src: this.href
        }));
      }
    });

    Promise
      .all(stylesToLoad)
      .then(() => resolve(true), () => resolve(true));
  });
}

/*!========================================================================
	20. PJAX Update Trackers
	======================================================================!*/
function PJAXUpdateTrackers() {

	updateGA();
	updateFBPixel();
	updateYaMetrika();

	/**
	 * Google Analytics
	 */
	function updateGA() {

		if (typeof gtag === 'function' && typeof window.gaData !== 'undefined' && Object.keys(window.gaData)[0] !== 'undefined') {
			var
				trackingID = Object.keys(window.gaData)[0],
				pageRelativePath = (window.location.href).replace(window.location.origin, '');

			gtag('js', new Date());
			gtag('config', trackingID, {
				'page_title': document.title,
				'page_path': pageRelativePath
			});
		}

	}

	/**
	 * Facebook Pixel
	 */
	function updateFBPixel() {

		if (typeof fbq === 'function') {
			fbq('track', 'PageView');
		}

	}

	/**
	 * Yandex Metrika
	 */
	function updateYaMetrika() {

		if (typeof ym === 'function') {

			var trackingID = getYmTrackingNumber();

			ym(trackingID, 'hit', window.location.href, {
				title: document.title
			});

		}

		function getYmTrackingNumber() {

			if (typeof window.Ya !== 'undefined' && typeof window.Ya.Metrika2) {
				return window.Ya.Metrika2.counters()[0].id || null;
			}

			if (typeof window.Ya !== 'undefined' && typeof window.Ya.Metrika) {
				return window.Ya.Metrika.counters()[0].id || null;
			}

			return null;

		}

	}

}

/*!========================================================================
	21. PJAX Update Nodes
	======================================================================!*/
function PJAXUpdateNodes(data) {
	return new Promise((resolve) => {
		const
			$nextDOM = $($.parseHTML(data.next.html)),
			nodesToUpdate = [
				'header.header .menu li',
				'header.header .menu-overlay li'
			]; // selectors of elements that needed to update

		$.each(nodesToUpdate, function () {
			let
				$item = $(this),
				$nextItem = $nextDOM.find(this);

			// different type of menu (overlay) found on the next page
			if (this === 'header.header .menu li' && !$nextItem.length) {
				$nextItem = $nextDOM.find('header.header .menu-overlay li');
			}

			// different type of menu (classic) found on the next page
			if (this === 'header.header .menu-overlay li' && !$nextItem.length) {
				$nextItem = $nextDOM.find('header.header .menu li');
			}

			// sync attributes if element exist in the new container
			if ($nextItem.length) {
				syncAttributes($nextItem, $item);
			}
		});

		resolve(true);
	});
}

/*!========================================================================
	22. PJAX Wait Container Images
	======================================================================!*/
function PJAXWaitContainerImages(data) {

	return new Promise(function (resolve, reject) {

		var
			$nextContainer = $(data.next.container),
			$nextMasthead = $nextContainer.find('.section-masthead');

		/**
		 * We can't wait infinitely for the images
		 * so let's proceed further anyway
		 */
		setTimeout(function () {
			resolve(true);
		}, 3000);

		$nextMasthead.imagesLoaded().always({
			background: true
		}, function (elements) {

			/**
			 * small delay to avoid any problems
			 * with masthead image size calculation
			 */
			setTimeout(function () {
				resolve(true);
			}, 150);

		});

	});

}

/*!========================================================================
	23. PJAX
	======================================================================!*/
var PJAX = function () {

	var $barbaWrapper = $('[data-barba="wrapper"]');

	if (!$barbaWrapper.length) {
		return;
	}

	barba.init({
		timeout: 6000,
		cacheIgnore: window.Modernizr.touchevents ? true : false, // don't grow cache on mobiles
		// don't trigger barba for links outside wrapper 
		prevent: ({
			el
		}) => {

			var
				$el = $(el),
				url = $el.attr('href'),
				customRules = sanitizeSelector(window.theme.ajax.preventRules),
				exludeRules = [
					'.no-ajax',
					'.no-ajax a',
					'[data-elementor-open-lightbox]', // Elementor Lightbox Gallery
					'[data-elementor-lightbox-slideshow]', // Elementor Pro Gallery
					'.lang-switcher a' // Polylang & WPML language switcher
				];

			if (
				url === '#' || // dummy link
				url.indexOf('wp-admin') > -1 || // WordPress admin link
				url.indexOf('wp-login') > -1 || // WordPress login link
				url.indexOf('/feed/') > -1 // WordPress feed
			) {
				return true;
			}

			// page anchor
			if ($el.is('[href*="#"]') && window.location.href === url.substring(0, url.indexOf('#'))) {
				return true;
			}

			// elementor preview
			if (typeof elementor === 'object') {
				return true;
			}

			// clicked on elementor ouside barba wrapper
			if ($el.closest($barbaWrapper).length < 1) {
				return true;
			}

			// custom rules from WordPress Customizer
			if (customRules) {
				exludeRules = [...exludeRules, ...customRules.split(',')];
				exludeRules = [...new Set(exludeRules)];
			}

			// check against array of rules to prevent
			return $el.is(exludeRules.join(','));

		},
		// custom transitions
		transitions: [
			PJAXTransitionGeneral,
			PJAXTransitionMasonryGrid,
			PJAXTransitionFullscreenSlider,
			PJAXTransitionHalfscreenSlider,
			PJAXTransitionOverlayMenu,
			PJAXTransitionNavProjects,
		],
		customHeaders: () => {
			if (Modernizr.webp) {
				return {
					'name': 'Accept',
					'value': 'image/webp'
				};
			}
		}
	});


}

/*!========================================================================
	24. Assets Manager
	======================================================================!*/
class AssetsManager {
  static load({
    type = undefined, // script | stylesheet
    src = null,
    id = null, // id attribute in DOM
    refElement,
    version = null,
    timeout = 15000,
    cache = false
  }) {
    return new Promise((resolve, reject) => {
      // Don't load asset that is pending to load
      if (cache && id in window.theme.assets.promises) {
        // return existing loading promise
        window.theme.assets.promises[id].then(resolve, reject);
        return;
      }

      // CSS
      if (type === 'style') {
        const stylePromise = AssetsManager.loadStyle({ src, id, refElement, timeout, version });

        window.theme.assets.promises[id] = stylePromise;
        return stylePromise.then(resolve, reject);

      } else if (type === 'script') { // JS
        const scriptPromise = AssetsManager.loadScript({ src, id, refElement, timeout, version });

        window.theme.assets.promises[id] = scriptPromise;

        return scriptPromise.then(resolve, reject);

      } else { // Unknown type
        reject(new TypeError('Resource type "style" or "script" is missing.'));
      }
    });
  }

  static loadScript({
    src = null,
    id = null,
    refElement = document.body,
    version = null,
    timeout = 15000
  }) {
    return new Promise((resolve, reject) => {
      const
        element = document.querySelector(`script[id="${id}"]`),
        head = document.getElementsByTagName('head')[0];

      let script, timer, preload;

      if (!src) {
        reject(new TypeError('Resource URL is missing.'));
        return;
      }

      if (!id) {
        reject(new TypeError('Resource ID attribute is missing.'));
        return;
      }

      if (typeof element === 'undefined' || element === null) {

        if (version) {
          src += `?ver=${version}`;
        }

        if (window.theme.isFirstLoad) {
          preload = document.createElement('link');
          preload.setAttribute('rel', 'preload');
          preload.setAttribute('href', src);
          preload.setAttribute('as', 'script');
          preload.setAttribute('type', 'text/javascript');
          head.prepend(preload);
        }

        script = document.createElement('script');
        script.setAttribute('type', 'text/javascript');
        script.setAttribute('async', 'async');
        script.setAttribute('src', src);
        script.setAttribute('id', id);
        refElement.append(script);

        script.onerror = (error) => {
          cleanup();
          refElement.removeChild(script);
          script = null;
          reject(new Error(`A network error occured while trying to load resouce ${src}`));
        }

        if (script.onreadystatechange === undefined) {
          script.onload = onload;
        } else {
          script.onreadystatechange = onload;
        }

        timer = setTimeout(script.onerror, timeout);

      } else {
        resolve(element);
      }

      function cleanup() {
        clearTimeout(timer);
        timer = null;
        script.onerror = script.onreadystatechange = script.onload = null;
      }

      function onload() {
        cleanup();
        if (!script.onreadystatechange || (script.readyState && script.readyState == 'complete')) {
          resolve(script);
          return;
        }
      }
    });
  }

  static loadStyle({
    src = null,
    id = null,
    refElement = document.querySelector('link[type="text/css"]'),
    version = null,
    timeout = 15000
  }) {
    return new Promise((resolve, reject) => {
      const
        element = document.querySelector(`link[id="${id}"]`),
        head = document.getElementsByTagName('head')[0];

      // don't load resouce that already exists
      if (typeof element !== 'undefined' && element !== null) {
        resolve(element);
      }

      if (!src) {
        reject(new TypeError('Resource URL is missing.'));
      }

      if (!id) {
        reject(new TypeError('Resource ID attribute is missing.'))
      }

      let
        link = document.createElement('link'),
        timer,
        sheet,
        cssRules,
        preload,
        c = (timeout || 10) * 100;

      if (version) {
        src += `?ver=${version}`;
      }

      if (window.theme.isFirstLoad) {
        preload = document.createElement('link');
        preload.setAttribute('rel', 'preload');
        preload.setAttribute('href', src);
        preload.setAttribute('as', 'style');
        preload.setAttribute('type', 'text/css');
        head.prepend(preload);
      }

      link.setAttribute('rel', 'stylesheet');
      link.setAttribute('type', 'text/css');
      link.setAttribute('href', src);

      if (typeof refElement !== 'undefined' && refElement !== null) {
        head.insertBefore(link, refElement);
      } else {
        head.append(link);
      }

      link.onerror = function (error) {
        if (timer) {
          clearInterval(timer);
        }
        timer = null;

        reject(new Error(`A network error occured while trying to load resouce ${src}`));
      };

      if ('sheet' in link) {
        sheet = 'sheet';
        cssRules = 'cssRules';
      } else {
        sheet = 'styleSheet';
        cssRules = 'rules';
      }

      timer = setInterval(function () {
        try {
          if (link[sheet] && link[sheet][cssRules].length) {
            clearInterval(timer);
            timer = null;
            resolve(link);
            return;
          }
        } catch (e) {}

        if (c-- < 0) {
          clearInterval(timer);
          timer = null;
          reject(new Error(`A network error occured while trying to load resouce ${src}`));
        }
      }, 10);


    });
  }

}

/*!========================================================================
	25. Aside Counters
	======================================================================!*/
var AsideCounters = function ($scope = $document) {

	var $target = $scope.find('.aside-counters');

	if (!$target.length) {
		return;
	}

	var $counter = $scope.find('.js-counter');

	$counter.each(function () {

		new Counter($(this));

	});

}

/*!========================================================================
	26. Counter
	======================================================================!*/
var Counter = function ($target) {

	var $num = $target.find('.js-counter__number');

	if (!$target.length || !$num.length) {
		return;
	}

	var
		numberStart = $target.data('counter-start') || 0,
		numberTarget = $target.data('counter-target') || 100,
		animDuration = $target.data('counter-duration') || 4,
		counter = {
			val: numberStart
		};

	setCounterUp();
	animateCounterUp();

	function setCounterUp() {

		var value = numberStart.toFixed(0);

		if (value < 10) {
			value = '0' + value;
		}

		$num.text(value);

	}

	function animateCounterUp() {

		var tl = new TimelineMax();
		var value;

		tl.to(counter, animDuration, {
			val: numberTarget.toFixed(0),
			ease: Power4.easeOut,
			onUpdate: function () {
				value = counter.val.toFixed(0);
				if (value < 10) {
					value = '0' + value;
				}
				$num.text(value);
			}
		});

		createOSScene($target, tl);

	}

}

/*!========================================================================
	27. Debounce
	======================================================================!*/
function debounce(func, wait, immediate) {
	var timeout;
	return function () {
		var context = this,
			args = arguments;
		var later = function () {
			timeout = null;
			if (!immediate) func.apply(context, args);
		};
		var callNow = immediate && !timeout;
		clearTimeout(timeout);
		timeout = setTimeout(later, wait);
		if (callNow) func.apply(context, args);
	};
};

/*!========================================================================
	28. Cursor
	======================================================================!*/
var Cursor = function () {

	var
		self = this,
		$cursor = $('#js-cursor');

	this.drawLoading = function () {
		window.$body.addClass('cursor-progress');
		drawLoading();
	};

	this.finishLoading = function () {
		window.$body.removeClass('cursor-progress');
		finishLoading();
	};

	this.mouseX = 0;
	this.mouseY = 0;

	this.update = function () {
		self.mouseX = self.mouseX + pageXOffset;
		self.mouseY = self.mouseY + pageYOffset;
	}

	// don't launch on mobiles
	if (!$cursor.length || Modernizr.touchevents) {
		return;
	}

	var
		tl = new TimelineMax(),
		$follower = $('.cursor__follower'),
		$inner = $follower.find('#inner'),
		$outter = $follower.find('#outter'),
		$cursorArrowLeft = $cursor.find('.cursor__arrow_left'),
		$cursorArrowRight = $cursor.find('.cursor__arrow_right'),
		offset = parseInt(window.$html.css('marginTop'), 10),
		posX = 0,
		posY = 0,
		hideCursorElements = [
			'.slider__arrow',
			'.slider__dot',
			'.social__item a',
			'.section-video__link',
			'.grid__item-link',
			'.section-nav-projects__inner'
		];

	start();

	function start() {

		if (!$cursor.length || Modernizr.touchevents) {
			return;
		}

		TweenMax.set($cursor, {
			display: 'block',
			y: '-50%',
			x: '-50%'
		});

		TweenMax.to({}, 0.01, {
			repeat: -1,
			onRepeat: function () {

				posX += (self.mouseX - posX) / 6;
				posY += (self.mouseY - posY - offset) / 6;

				TweenMax.set($cursor, {
					x: posX,
					y: posY + offset,
				});

			}
		});

		TweenMax.set($outter, {
			drawSVG: '0%',
		});

		$document.on('mousemove', function (e) {
			self.mouseX = e.clientX;
			self.mouseY = e.clientY;
		});

		$document.on('mouseenter', 'a, #js-burger, #js-submenu-back', function () {

			TweenMax.to($cursor, 1.2, {
				scale: 1.5,
				ease: Elastic.easeOut.config(1, 0.4),
			});

			TweenMax.to($inner, 0.6, {
				opacity: 1
			});

		})
			.on('mouseleave', 'a, #js-burger, #js-submenu-back', function () {

				TweenMax.to($cursor, 1.2, {
					scale: 1,
					ease: Elastic.easeOut.config(1, 0.4),
				});

				TweenMax.to($inner, 0.6, {
					opacity: .6
				});

			});

		$document.on('mouseenter', hideCursorElements.join(','), function () {

			TweenMax.to($cursor, 0.3, {
				scale: 0,
				ease: Expo.easeInOut
			});

			TweenMax.to($inner, 0.3, {
				opacity: 1
			});

		})
			.on('mouseleave', hideCursorElements.join(','), function () {

				TweenMax.to($cursor, 1.2, {
					scale: 1,
					ease: Elastic.easeOut.config(1, 0.4),
				});

				TweenMax.to($inner, 0.6, {
					opacity: .6,
				});

			});

		// draggable slider arrows
		$document.on('mouseenter', '.slider_draggable', function () {
			TweenMax.to($cursorArrowLeft, 0.3, {
				autoAlpha: 1,
				x: -20
			});
			TweenMax.to($cursorArrowRight, 0.3, {
				autoAlpha: 1,
				x: 20
			});
		}).on('mouseleave', '.slider_draggable', function () {
			TweenMax.to([$cursorArrowLeft, $cursorArrowRight], 0.3, {
				autoAlpha: 0,
				x: 0
			});
		});

	}

	function drawLoading() {

		if (!$cursor.length || Modernizr.touchevents) {
			return;
		}

		tl
			.stop().clear().play()
			.add(TweenMax.to($cursor, 1.2, {
				scale: 1.5,
				ease: Elastic.easeOut.config(1, 0.4)
			}))
			.fromTo($outter, 3, {
				drawSVG: '0%',
				ease: Expo.easeInOut
			}, {
				drawSVG: '100%',
				ease: Expo.easeInOut
			}, '0');

	}

	function finishLoading() {

		if (!$cursor.length || Modernizr.touchevents) {
			return;
		}

		tl.stop().clear().play()
			.to($outter, 0.6, {
				drawSVG: '100%',
				ease: Expo.easeInOut
			})
			.to($outter, 0.3, {
				autoAlpha: 0
			})
			.set($outter, {
				drawSVG: '0%',
				autoAlpha: 1
			})
			.to($cursor, 1.2, {
				scale: 1,
				ease: Elastic.easeOut.config(1, 0.4),
			});

	}

}

/*!========================================================================
	29. Figure Portfolio
	======================================================================!*/
var FigurePortfolio = function ($scope) {

	var $target = $scope.find('.figure-portfolio');

	$target.each(function () {

		var
			$current = $(this),
			$img = $current.find('img'),
			transformMatrix = $img.css('transform');

		$current
			.on('click', function () {
				$current.addClass('clicked');
				TweenMax.to($img, 0.3, {
					delay: 0.3,
					transform: 'none',
					overwrite: 'all',
					// ease: Expo.easeInOut
				})
			});

	});

}

/*!========================================================================
	30. Figure Property
	======================================================================!*/
var FigureProperty = function ($scope) {

	var $target = $scope.find('.figure-property[data-os-animation]');

	if (!$target.length) {
		return;
	}

	var $headline = $target.find('.figure-property__headline');

	prepare();
	animate();

	function prepare() {

		TweenMax.set($headline, {
			scaleX: 0,
			transformOrigin: 'left center'
		});

	}

	function animate() {

		var tl = new TimelineMax();

		tl.add(animateLines($target, 1.2, 0.01));

		createOSScene($target, tl);

	}

}

/*!========================================================================
	31. Fix Mobile Bar Height
	======================================================================!*/
function fixMobileBarHeight() {

	var vh;

	/**
	 * Initial set
	 */
	createStyleElement();
	setVh();

	if (window.theme.mobileBarFix.update) {
		/**
		 * Resize handling (with debounce)
		 */
		window.$window.on('resize', debounce(function () {
			setVh();
		}, 250));
	}

	/**
	 * 100vh elements height correction
	 */
	function setVh() {

		vh = document.documentElement.clientHeight * 0.01;

		$('#rubenz-fix-bar').html(':root { --fix-bar-vh: ' + vh + 'px; }\n');

	}

	function createStyleElement() {

		if (!$('#rubenz-fix-bar').length) {
			$('head').append('<style id=\"rubenz-fix-bar\"></style>');
		}

	}

}

/*!========================================================================
	32. Gmap
	======================================================================!*/
var GMap = function ($scope) {

	var
		$wrapper = $scope.find('.gmap'),
		prevInfoWindow = false;

	if (typeof google === 'undefined' || typeof google.maps === 'undefined') {
		return;
	}

	createMap($wrapper);

	/**
	 * 
	 * @param {Map jQuery Object} $wrapper 
	 */
	function createMap($wrapper) {

		var $mapContainer = $wrapper.find('.gmap__container');

		if (!$mapContainer.length) {
			return;
		}

		var
			$markers = $wrapper.find('.gmap__marker'),
			ZOOM = parseInt($wrapper.attr('data-gmap-zoom')),
			SNAZZY_STYLES = $wrapper.attr('data-gmap-snazzy-styles');

		var argsMap = {
			center: new google.maps.LatLng(0, 0),
			zoom: ZOOM,
			scrollwheel: false
		};

		if (SNAZZY_STYLES) {

			try {
				SNAZZY_STYLES = JSON.parse(SNAZZY_STYLES);
				$.extend(argsMap, {
					styles: SNAZZY_STYLES
				});
			} catch (err) {
				console.error('Google Map: Invalid Snazzy Styles');
			}

		};

		var map = new google.maps.Map($mapContainer[0], argsMap);

		map.markers = [];

		$markers.each(function () {
			createMarker($(this), map);
		});

		centerMap(ZOOM, map);

	}

	/**
	 * 
	 * @param {Marker jQuery object} $marker 
	 * @param {Google Map Instance} map
	 */
	function createMarker($marker, map) {

		if (!$marker.length) {
			return;
		}

		var
			MARKER_LAT = parseFloat($marker.attr('data-marker-lat')),
			MARKER_LON = parseFloat($marker.attr('data-marker-lon')),
			MARKER_IMG = $marker.attr('data-marker-img'),
			MARKER_WIDTH = parseFloat($marker.attr('data-marker-width')),
			MARKER_HEIGHT = parseFloat($marker.attr('data-marker-height')),
			MARKER_CONTENT = $marker.attr('data-marker-content');

		/**
		 * Marker
		 */
		var argsMarker = {
			position: new google.maps.LatLng(MARKER_LAT, MARKER_LON),
			map: map
		};

		if (MARKER_IMG) {

			$.extend(argsMarker, {
				icon: {
					url: MARKER_IMG
				}
			});

		}

		if (MARKER_IMG && MARKER_WIDTH && MARKER_HEIGHT) {

			$.extend(argsMarker.icon, {
				scaledSize: new google.maps.Size(MARKER_WIDTH, MARKER_HEIGHT)
			});

		}

		var marker = new google.maps.Marker(argsMarker)

		map.markers.push(marker);

		/**
		 * Info Window (Content)
		 */
		if (MARKER_CONTENT) {

			var infoWindow = new google.maps.InfoWindow({
				content: MARKER_CONTENT
			});

			marker.addListener('click', function () {

				if (prevInfoWindow) {
					prevInfoWindow.close();
				}

				prevInfoWindow = infoWindow;

				infoWindow.open(map, marker);

			});

		}

	}

	/**
	 * 
	 * @param {Map Zoom} zoom 
	 * @param {Google Map Instance} map
	 */
	function centerMap(zoom, map) {

		var
			bounds = new google.maps.LatLngBounds(),
			newZoom;

		$.each(map.markers, function () {

			var item = this;

			if (typeof item.position === 'undefined') {
				return;
			}

			newZoom = new google.maps.LatLng(item.position.lat(), item.position.lng());
			bounds.extend(newZoom);

		});

		if (map.markers.length == 1) {

			map.setCenter(bounds.getCenter());
			map.setZoom(zoom);

		} else {

			map.fitBounds(bounds);

		}
	}

}

/*!========================================================================
	33. Grid
	======================================================================!*/
var Grid = function ($grid = $('.js-grid')) {

	if (!$grid.length) {
		return;
	}

	var $filter = $grid.parent().find('.js-filter');

	this.masonryGrid = $grid.isotope({
		itemSelector: '.js-grid__item',
		columnWidth: '.js-grid__sizer',
		percentPosition: true
	});

	$grid.imagesLoaded(function () {
		$grid.isotope('layout').one('arrangeComplete', function () {
			if (typeof Waypoint === 'function') {
				Waypoint.refreshAll();
			}
		});
	});

	if ($filter.length) {

		var $filterItems = $filter.find('.js-filter__item');

		$grid.isotope();

		$filterItems.on('click', function (e) {

			e.preventDefault();

			var
				$el = $(this),
				filterBy = $el.data('filter');

			$filterItems.removeClass('filter__item_active');
			$el.addClass('filter__item_active');

			$grid.isotope({
				itemSelector: '.js-grid__item',
				columnWidth: '.js-grid__sizer',
				horizontalOrder: true,
				filter: filterBy
			});

		});

	}

}

/*!========================================================================
	34. Form
	======================================================================!*/
var Form = function () {

	var
		INPUT_CLASS = '.input-float__input',
		INPUT_NOT_EMPTY = 'input-float__input_not-empty',
		INPUT_FOCUSED = 'input-float__input_focused';

	floatLabels();
	ajaxForm();

	if (typeof window.theme !== 'undefined' && window.theme.contactForm7.customModals) {
		attachModalsEvents();
	}

	function floatLabels() {

		if (!$(INPUT_CLASS).length) {
			return;
		}

		$(INPUT_CLASS).each(function () {

			var
				$currentField = $(this),
				$currentControlWrap = $currentField.parent('.wpcf7-form-control-wrap');

			// not empty value
			if ($currentField.val()) {
				$currentField.addClass(INPUT_NOT_EMPTY);
				$currentControlWrap.addClass(INPUT_NOT_EMPTY);
				// empty value
			} else {
				$currentField.removeClass([INPUT_FOCUSED, INPUT_NOT_EMPTY]);
				$currentControlWrap.removeClass([INPUT_FOCUSED, INPUT_NOT_EMPTY]);
			}

			// has placeholder & empty value
			if ($currentField.attr('placeholder') && !$currentField.val()) {
				$currentField.addClass(INPUT_NOT_EMPTY);
				$currentControlWrap.addClass(INPUT_NOT_EMPTY);
			}

		});

		window.$document
			.off('focusin')
			.on('focusin', INPUT_CLASS, function () {

				var
					$currentField = $(this),
					$currentControlWrap = $currentField.parent('.wpcf7-form-control-wrap');

				$currentField.addClass(INPUT_FOCUSED).removeClass(INPUT_NOT_EMPTY);
				$currentControlWrap.addClass(INPUT_FOCUSED).removeClass(INPUT_NOT_EMPTY);

			})
			.off('focusout')
			.on('focusout', INPUT_CLASS, function () {

				var
					$currentField = $(this),
					$currentControlWrap = $currentField.parent('.wpcf7-form-control-wrap');

				// not empty value
				if ($currentField.val()) {
					$currentField.removeClass(INPUT_FOCUSED).addClass(INPUT_NOT_EMPTY);
					$currentControlWrap.removeClass(INPUT_FOCUSED).addClass(INPUT_NOT_EMPTY);
				} else {
					// has placeholder & empty value
					if ($currentField.attr('placeholder')) {
						$currentField.addClass(INPUT_NOT_EMPTY);
						$currentControlWrap.addClass(INPUT_NOT_EMPTY);
					}
					$currentField.removeClass(INPUT_FOCUSED);
					$currentControlWrap.removeClass(INPUT_FOCUSED);

				}

			});

	}

	function ajaxForm() {

		var $form = $('.js-ajax-form');

		if (!$form.length) {
			return;
		}

		$form.validate({
			errorElement: 'span',
			errorPlacement: function (error, element) {
				error.appendTo(element.parent()).addClass('form__error');
			},
			submitHandler: function (form) {
				ajaxSubmit(form);
			}
		});

		function ajaxSubmit(form) {

			$.ajax({
				type: $form.attr('method'),
				url: $form.attr('action'),
				data: $form.serialize()
			}).done(function () {
				alert($form.attr('data-message-success'));
				$form.trigger('reset');
				floatLabels();
			}).fail(function () {
				alert($form.attr('data-message-error'));
			});
		}

	}

	function attachModalsEvents() {
		window.$document.off('wpcf7submit').on('wpcf7submit', function (e) {

			var $modal = $('#modalContactForm7');

			$modal.modal('dispose').remove();

			if (e.detail.apiResponse.status === 'mail_sent') {

				createModalTemplate({
					icon: 'icon-success.svg',
					message: e.detail.apiResponse.message
				});
			}

			if (e.detail.apiResponse.status === 'mail_failed') {
				createModalTemplate({
					icon: 'icon-error.svg',
					message: e.detail.apiResponse.message
				});
			}

		});
	}

	function createModalTemplate({ icon, message }) {

		window.$body.append(`
			<div class="modal fade" id="modalContactForm7">
				<div class="modal-dialog modal-dialog-centered">
					<div class="modal-content radius-img">
						<div class="modal__close" data-dismiss="modal"><img src="${window.theme.themeURL}/img/general/icon-close.svg"/></div>
						<header class="text-center mb-3">
							<img src="${window.theme.themeURL}/img/general/${icon}" width="80px" height="80px" alt=""/>
							<p class="modal__message"><strong>${message}</strong></p>
						</header>
						<div class="modal-content__wrapper-button">
							<button type="button" class="button button_solid button_black" data-dismiss="modal">OK</button>
						</div>
					</div>
				</div>
			</div>
		`);
		var $modal = $('#modalContactForm7');

		$modal.modal('show');
		$modal.on('hidden.bs.modal', function () {
			$modal.modal('dispose').remove();
		});

	}

}

/*!========================================================================
	35. Header
	======================================================================!*/
var Header = function () {

	var $overlay = $('.header__wrapper-overlay-menu');

	if (!$overlay.length) {
		return;
	}

	var
		tl = new TimelineMax(),
		$menuLinks = $overlay.find('.menu-overlay > li > a'),
		$allLinks = $overlay.find('a'),
		$submenu = $overlay.find('.menu-overlay .sub-menu'),
		$submenuButton = $('#js-submenu-back'),
		$submenuLinks = $submenu.find('> li > a'),
		$overlayWidgets = $overlay.find('.header__wrapper-overlay-widgets'),
		$widgets = $overlay.find('.figure-property'),
		$headerLeft = $('.header__col-left'),
		$langSwitcher = $('.lang-switcher'),
		OPEN_CLASS = 'header__burger_opened',
		$adminBar = $('#wpadminbar');

	clickBurger();
	prepare();
	setOverlayMenu();
	correctAbsoluteHeader();
	handleAnchors();

	function prepare() {

		TweenMax.set($menuLinks.find('.split-chars__char'), {
			x: '-100px',
			autoAlpha: 0
		});

		TweenMax.set($submenuLinks.find('.split-chars__char'), {
			x: '-30px',
			autoAlpha: 0
		});

	}

	function correctAbsoluteHeader() {

		var barHeight = $adminBar.height() || 0;

		if (typeof window.SB !== 'undefined' && window.$header.hasClass('header_absolute')) {

			TweenMax.to(window.$header, 0.6, {
				top: -barHeight
			});

			window.SB.addListener(function (scrollbar) {
				TweenMax.set(window.$header, {
					top: -scrollbar.offset.y - barHeight
				});
			});
		}

	}

	function setOverlayMenu() {

		getScrollTop();
		window.$overlay.removeClass('intransition lockhover opened');
		$submenu.removeClass('opened');
		$allLinks.removeClass('selected');

		TweenMax.set(window.$overlay, {
			scaleX: 0,
			autoAlpha: 0,
		});

		TweenMax.set([$submenu, $submenuButton], {
			autoAlpha: 0
		});

		TweenMax.set($overlayWidgets, {
			scaleY: 0,
			transformOrigin: 'bottom center',
		});

		TweenMax.set(window.$wrapperBackgrounds, {
			clearProps: 'width,height,left,right,top,bottom,backgroundColor',
		});

		setLines($overlayWidgets);

	}

	function closeOverlayMenu(hideBackgrounds, restoreScroll = true) {

		var
			$submenuLinksCurrent = $submenu.filter('.opened').find($submenuLinks),
			$pageWrapper = $('.page-wrapper'),
			$layers = [];

		$layers.push(window.$overlay);

		if (hideBackgrounds == true) {
			$layers.push(window.$wrapperBackgrounds);
		}

		tl.timeScale(1.5);

		return tl
			.clear()
			.add([
				TweenMax.set(window.$overlay, {
					className: '+=intransition',
					transformOrigin: 'right center',
					zIndex: 500
				}),
				TweenMax.set(window.$wrapperBackgrounds, {
					transformOrigin: 'right center',
					zIndex: 100,
				}),
				TweenMax.set($burger, {
					className: '-=header__burger_opened'
				}),
				TweenMax.set($pageWrapper, {
					clearProps: 'overflow,height',
					x: '-5vw',
					force3D: true,
					transformOrigin: 'right center',
				}),
				function () {
					if (restoreScroll) {
						restoreScrollTop();
					}
				}
			])
			.add([
				hideWords($menuLinks, 1.2, 0.01, '100px', true, 'start'),
				hideWords($submenuLinksCurrent, 1.2, 0.01, '30px', true, 'start'),
				hideLines($widgets, 0.6),
			], '0.3')
			.to($overlayWidgets, 0.6, {
				scaleY: 0,
				transformOrigin: 'top center',
				ease: Expo.easeInOut
			}, '1')
			.to($layers, 1.2, {
				scaleX: 0,
				ease: Expo.easeInOut
			}, '1')
			.fromTo($pageWrapper, 2.4, {
				autoAlpha: 1,
			}, {
				x: '0vw',
				force3D: true,
				autoAlpha: 1,
				ease: Expo.easeInOut,
				onComplete: () => {
					TweenMax.set($pageWrapper, {
						clearProps: 'all'
					});
				}
			}, '0.3')
			.to($submenuButton, 0.6, {
				x: '-10px',
				autoAlpha: 0
			}, '0.3')
			.fromTo([$headerLeft, $langSwitcher], 2.4, {
				x: '-50px',
			}, {
				x: '0px',
				autoAlpha: 1,
				ease: Expo.easeInOut
			}, '0.3')
			.add(function () {
				setOverlayMenu();
				prepare();
			});

	};

	function openOverlayMenu() {

		var
			$pageWrapper = $('.page-wrapper');

		tl.timeScale(1);

		tl
			.clear()
			.add(function () {
				getScrollTop();
				window.$overlay.addClass('intransition opened');
			})
			.set(window.$overlay, {
				autoAlpha: 1,
				transformOrigin: 'left center',
				zIndex: 500
			})
			.set(window.$wrapperBackgrounds, {
				scaleX: 0,
				transformOrigin: 'left center',
				autoAlpha: 1,
				zIndex: 100,
			})
			.set(window.$backgroundsOverlay, {
				autoAlpha: 0.6
			})
			.to($pageWrapper, 1.2, {
				x: '10vw',
				force3D: true,
				transformOrigin: 'left center',
				ease: Expo.easeInOut,
				onComplete: function () {
					TweenMax.set($pageWrapper, {
						autoAlpha: 0
					});
				}
			})
			.to([$headerLeft, $langSwitcher], 1.2, {
				x: '50px',
				autoAlpha: 0,
				ease: Expo.easeInOut
			}, '0')
			.to([window.$overlay, window.$wrapperBackgrounds], 0.6, {
				scaleX: 1,
				ease: Expo.easeInOut
			}, '0.2')
			.add(animateWords($menuLinks, 1.8, 0.01, true, false, '-=1.5'), '0.6')
			.to($overlayWidgets, 1.2, {
				scaleY: 1,
				ease: Expo.easeInOut,
			}, '0.6')
			.add(animateLines($widgets), '0.8')
			.add(function () {
				window.$overlay.removeClass('intransition');
			}, '0.9');

	};

	function clickBurger() {

		window.$burger.off().on('click', function (e) {

			e.preventDefault();

			if (!$overlay.hasClass('intransition')) {

				if (window.$burger.hasClass(OPEN_CLASS)) {
					closeOverlayMenu(true);
					window.$burger.removeClass(OPEN_CLASS);
				} else {
					openOverlayMenu();
					window.$burger.addClass(OPEN_CLASS);
				}

			}

		});

	}

	function handleAnchors() {

		$('.menu a, .menu-overlay a').filter('a[href*="#"]:not([href="#"]):not([href*="#elementor-action"])').off('click').each(function () {
			var
				$current = $(this),
				url = $current.attr('href'),
				filteredUrl = url.substring(url.indexOf('#'));

			try {
				if (filteredUrl.length) {
					var $el = $(filteredUrl);

					if ($el.length) {

						$current.on('click', function (e) {
							if (window.$overlay.hasClass('opened')) {
								closeOverlayMenu(true, false);

								if (typeof window.SB !== 'undefined') {
									setTimeout(() => {
										window.SB.scrollIntoView($el.get(0));
									}, 900);
								}
							} else {

								if (typeof window.SB !== 'undefined') {
									window.SB.scrollIntoView($el.get(0));
								}

							}
						});

					}
				}
			} catch (error) {
				console.error('Error when handling menu anchor links: ' + error);
			}
		});

	}

	this.hideOverlayMenu = function (hideBackgrounds) {

		return closeOverlayMenu(hideBackgrounds);

	}

}

/*!========================================================================
	36. Lazy Load
	======================================================================!*/
function lazyLoad($scope = document, $elements = $document.find('.lazy')) {

	var $images = $elements.find('img[data-src]:not(img.lazy-bg):not(img.swiper-lazy)');
	var $backgrounds = $scope.find('.lazy-bg[data-src]:not(.swiper-lazy)');
	var imagesInstance =  $images.Lazy({
		threshold: 1000,
		chainable: false,
		afterLoad: function (el) {

			$(el).parent().css({
				'padding-bottom': '',
				'width': '',
				'height': '',
				'animation-name': 'none',
				'background-color': 'initial'
			});

			setTimeout(function () {
				new Grid();
			}, 300);

		}

	});
	var backgroundsInstance =  $backgrounds.Lazy({
		threshold: 1000,
		chainable: false
	});

	// destroy lazy instances on new page transition
	window.$window.one('arts/barba/transition/init', () => {
		imagesInstance.destroy();
		backgroundsInstance.destroy();
	});

}

/*!========================================================================
	37. Menu Overlay
	======================================================================!*/
var MenuOverlay = function () {

	var $menu = $('.js-menu-overlay');

	if (!$menu.length) {
		return;
	}

	var
		$overlay = $('.header__wrapper-overlay-menu'),
		$widgets = $overlay.find('.figure-property'),
		$links = $menu.find('.menu-item-has-children > a'),
		$allLinks = $menu.find('a'),
		$submenus = $menu.find('.sub-menu'),
		$submenuButton = $('#js-submenu-back'),
		OPEN_CLASS = 'opened',
		SELECTED_CLASS = 'selected',
		HOVER_CLASS = 'menu-overlay_hover',
		tl = new TimelineMax();

	function openSubmenu($submenu, $currentMenu) {

		var
			$currentLinks = $currentMenu.find('> li > a .menu-overlay__item-wrapper'),
			$submenuLinks = $submenu.find('> li > a .menu-overlay__item-wrapper');

		tl
			.clear()
			.add([
				TweenMax.set($submenu, {
					autoAlpha: 1
				}),
				function () {
					$overlay.addClass('intransition lockhover');

					$submenus.removeClass(OPEN_CLASS);
					$submenu.not($menu).addClass(OPEN_CLASS);

					if (Modernizr.mq('(max-width: 991px)')) {

						if ($submenus.hasClass(OPEN_CLASS)) {
							hideLines($widgets, 0.6);
						} else {
							animateLines($widgets);
						}

					}

					if ($submenus.hasClass(OPEN_CLASS)) {
						tl.to($submenuButton, 0.3, {
							autoAlpha: 1,
							x: '0px'
						}, '-=1.2');
					} else {
						tl.to($submenuButton, 0.3, {
							autoAlpha: 0,
							x: '-10px'
						}, '-=1.2');
					}

				}
			], '0')
			.add(hideWords($currentLinks, 1.2, 0, '50px', true, '0.2'))
			.add(animateWords($submenuLinks, 1.2, 0.005), '-=0.6')
			.set($submenu, {
				zIndex: 100
			})
			.add(function () {
				$allLinks.removeClass(SELECTED_CLASS);
				$overlay.removeClass('intransition lockhover');
			}, '-=0.6');

	}

	function closeSubmenu($submenu, $currentMenu) {

		var
			$currentLinks = $currentMenu.find('> li > a .menu-overlay__item-wrapper'),
			$submenuLinks = $submenu.find('> li > a .menu-overlay__item-wrapper');

		tl
			.clear()
			.add([
				TweenMax.set($submenu, {
					zIndex: -1
				}),
				function () {

					$overlay.addClass('intransition lockhover');

					$submenus.removeClass(OPEN_CLASS);
					$currentMenu.not($menu).addClass(OPEN_CLASS);

					if (Modernizr.mq('(max-width: 991px)')) {

						if ($submenus.hasClass(OPEN_CLASS)) {
							hideLines($widgets, 0.6);
						} else {
							animateLines($widgets);
						}

					}

					if ($submenus.hasClass(OPEN_CLASS)) {
						TweenMax.to($submenuButton, 0.3, {
							autoAlpha: 1,
							x: '0px'
						});
					} else {

						TweenMax.to($submenuButton, 0.3, {
							autoAlpha: 0,
							x: '-10px'
						});

					}

				}
			])
			.add(hideWords($submenuLinks, 0.6, 0.005, '-50px'))
			.add(animateWords($currentLinks), '-=0.6')
			.add([
				TweenMax.set($submenu, {
					autoAlpha: 0
				}),
				function () {
					$overlay.removeClass('intransition lockhover');
				}
			], '-=0.6');

	}

	$links.on('click', function (e) {

		e.preventDefault();

		if (!$overlay.hasClass('intransition')) {
			var
				$el = $(this),
				$currentMenu = $el.parents('ul'),
				$submenu = $el.next('.sub-menu');

			$el.addClass(SELECTED_CLASS);

			openSubmenu($submenu, $currentMenu);
		}

	});

	$submenuButton.on('click', function (e) {

		e.preventDefault();

		if (!$overlay.hasClass('intransition')) {
			var
				$openedMenu = $submenus.filter('.' + OPEN_CLASS),
				$prevMenu = $openedMenu.parent('li').parent('ul');

			closeSubmenu($openedMenu, $prevMenu);
		}

	});

	$allLinks
		.on('mouseenter touchstart', function () {
			if ($submenus.filter('.opened').length) {
				$submenus.filter('.opened').addClass(HOVER_CLASS);
			} else {
				$menu.addClass(HOVER_CLASS);
			}
		})
		.on('mouseleave touchend', function () {
			$('.menu-overlay_hover').removeClass(HOVER_CLASS);
		});

}

/*!========================================================================
	38. Project Backgrounds
	======================================================================!*/
var ProjectBackgrounds = function () {

	if (!window.$backgrounds.length) {
		return;
	}

	var $ajaxLinks = $('a[data-post-id]');

	window.$header.find($ajaxLinks)
		.on('mouseenter touchstart', function () {
			var
				postId = $(this).data('post-id'),
				$targetBackground = window.$backgrounds.filter('[data-background-for="' + postId + '"]');

			if (!$targetBackground.length) {
				return;
			}

			window.$backgrounds.filter('active').removeClass('active');
			$targetBackground.addClass('active');

		})
		.on('mouseleave touchend', function () {

			window.$backgrounds.filter('.active').removeClass('active');

		});

	$ajaxLinks.on('click', function () {

		var
			postId = $(this).data('post-id'),
			$targetBackground = window.$backgrounds.filter('[data-background-for="' + postId + '"]');

		if (!$targetBackground.length) {
			return;
		}

		window.$backgrounds.filter('active').removeClass('active');
		$targetBackground.addClass('selected');

	});

}

/*!========================================================================
	39. Smooth Scroll
	======================================================================!*/
var SmoothScroll = function () {

	var
		$smoothScroll = $('.js-smooth-scroll'),
		$WPadminBar = $('#wpadminbar');

	if (!$smoothScroll.length) {
		return;
	}

	// don't launch in Elementor edit mode
	if (typeof elementor != 'undefined') {
		return;
	}

	// don't launch on mobiles
	if (Modernizr.touchevents && !$smoothScroll.hasClass('js-smooth-scroll_enable-mobile')) {
		return;
	}

	$smoothScroll.addClass('smooth-scroll');

	if (window.theme.smoothScroll.plugins.edgeEasing) {
		Scrollbar.use(window.EdgeEasingPlugin);
	}

	window.SB = Scrollbar.init($smoothScroll[0], window.theme.smoothScroll);

	// Immediately focus SB container so it become accessible for keyboard navigation
	setTimeout(() => {
		window.SB.containerEl.focus();
	}, 100);

	// Emit native scroll event to window
	if (typeof window.SB !== 'undefined') {

		var scrollEvt = new CustomEvent('scroll');

		window.SB.addListener(function (e) {
			window.pageYOffset = e.offset.y;
			window.pageXOffset = e.offset.x;
			window.dispatchEvent(scrollEvt);
		});

	}

	// Destroy instance after page transition
	window.$window.one('arts/barba/transition/init', () => {
		window.SB.destroy();
	});

	// prevent double scroll because of the offset created
	// by WordPress.menu-overlay .sub-menu admin bar
	if (typeof window.SB !== 'undefined' && $WPadminBar.length) {

		window.$html.css({
			overflow: 'hidden'
		});

	}

	// handle smooth anchor scrolling
	$smoothScroll.find('a[href*="#"]:not([href="#"]):not([href*="#elementor-action"])').each(function () {
		var
			$current = $(this),
			url = $current.attr('href'),
			filteredUrl = url.substring(url.indexOf('#'));

		try {
			if (filteredUrl.length) {
				var $el = $(filteredUrl);
				if ($el.length) {
					$current.off('click').on('click', function (e) {
						window.SB.scrollIntoView($el.get(0));
					});
				}
			}
		} catch (error) {
			console.error('Error when handling anchor links: ' + error);
		}
	});

}

/*!========================================================================
	40. Create OS Scene
	======================================================================!*/
function createOSScene($el, tl, $customTrigger, noReveal) {

	var
		$trigger = $el,
		masterTL = new TimelineMax();

	if ($customTrigger && $customTrigger.length) {
		$trigger = $customTrigger;
	}

	if (!noReveal) {
		// reveal hidden element first
		masterTL.add(TweenMax.set($el, {
			autoAlpha: 1
		}), '0');
	}

	masterTL.add(tl, '0');

	masterTL.add(function () {
		$el.attr('data-os-animation', 'animated');
	});

	new $.ScrollMagic.Scene({
			triggerElement: $trigger,
			triggerHook: window.SMSceneTriggerHook,
			reverse: window.SMSceneReverse
		})
		.setTween(masterTL)
		.addTo(window.SMController);

}

/*!========================================================================
	41. Get Scroll Top
	======================================================================!*/
function getScrollTop() {

	if (window.SB !== undefined) {
		window.lastTop = window.SB.scrollTop;
	} else {
		window.lastTop = Math.max(document.body.scrollTop, document.documentElement.scrollTop);
	}

	return window.lastTop;
}

/*!========================================================================
	42. Lock Scroll
	======================================================================!*/
function lockScroll(lock) {

	var LOCK_CLASS = 'body_lock-scroll';

	if (lock) {

		if (typeof window.SB !== 'undefined') {

			window.SB.updatePluginOptions('lockscroll', {
				lock: true
			});

		}

		window.$body.addClass(LOCK_CLASS);

	}

	if (!lock) {

		window.$body.removeClass(LOCK_CLASS);

		if (typeof window.SB !== 'undefined') {

			window.SB.updatePluginOptions('lockscroll', {
				lock: false
			});

		}

	}

}

/*!========================================================================
	43. Restore Scroll Top
	======================================================================!*/
function restoreScrollTop() {

	if (window.SB !== undefined) {

		setTimeout(function () {
			window.SB.scrollTop = window.lastTop;
		}, 100);

	} else {

		$('html, body').animate({
			scrollTop: window.lastTop
		}, 100);

	}

}

/*!========================================================================
	44. Scroll To Very Top
	======================================================================!*/
function scrollToVeryTop() {

	window.scrollTo(0, 0);

	// safari fix
	try {
		window.top.scrollTo(0, 0);
	} catch (error) {

	}

	if (window.SB !== undefined) {
		window.SB.scrollTop = 0;
	}

	// window.pageXOffset = 0;
	// window.pageYOffset = 0;

}

/*!========================================================================
	45. Parallax
	======================================================================!*/
var Parallax = function ($scope) {

	var $wrapper = $scope.find('[data-art-parallax]');

	if (!$wrapper.length) {
		return;
	}

	$wrapper.each(function () {

		var
			$current = $(this),
			$img = $current.find('img, .art-parallax__bg'),
			savedAlt = $img.attr('alt'),
			factor = parseFloat($current.data('art-parallax-factor')) || 0.3,
			factorTo = Math.abs(factor) * 100,
			factorFrom = -1 * factor * 100,
			factorScale = 1 + Math.abs(factor),
			sceneDuration = window.innerHeight + $current.outerHeight();

		if ($img.is('img')) {
			$img.removeAttr('alt');
			sceneDuration = window.innerHeight + $current.outerHeight();
			if (savedAlt) {
        $img.attr('alt', savedAlt);
      }
		}

		if (!$img.length) {
			return;
		}

		if (factorFrom > 0) {
			factorScale = factorScale * factorScale;
			factorTo = factor * 100;
		}

		var tl = new TimelineMax();

		TweenMax.set($img, {
			scale: factorScale,
			transformOrigin: 'center center',
			ease: Expo.easeInOut
		});

		tl.fromTo($img, 0.3, {
			y: factorFrom + '%',
			ease: Linear.easeNone,
		}, {
			y: factorTo + '%',
			ease: Linear.easeNone,
		});

		new ScrollMagic.Scene({
				triggerElement: $current,
				triggerHook: 1,
				duration: sceneDuration
			})
			.setTween(tl)
			.addTo(window.SMController)
			.update(true);

	});

}

/*!========================================================================
	46. Section Composition
	======================================================================!*/
var SectionComposition = function ($scope) {

	var $target = $scope.find('.section-composition__content[data-os-animation]');

	if (!$target.length) {

		return;

	}

	$target.each(function () {

		var
			tl = new TimelineMax(),
			$current = $(this),
			$headlineProperty = $current.find('.figure-property__headline'),
			$property = $current.find('.figure-property');

		prepare();
		animate();

		function prepare() {

			TweenMax.set($headlineProperty, {
				scaleX: 0,
				transformOrigin: 'left center'
			});

		}

		function animate() {

			tl
				.to($headlineProperty, 1.2, {
					scaleX: 1,
					ease: Expo.easeInOut,
					transformOrigin: 'left center'
				})
				.add(animateLines($property, 0.8, 0.03), '-=1.2');

			createOSScene($current, tl, $property);

		}

	})

}

/*!========================================================================
	47. Section Content
	======================================================================!*/
var SectionContent = function ($scope) {

	var $target = $scope.find('.section-content[data-os-animation]');

	if (!$target.length) {

		return;

	}

	$target.each(function () {

		var
			tl = new TimelineMax(),
			$current = $(this),
			$headline = $current.find('.section__headline'),
			$headlineProperty = $current.find('.figure-property__headline'),
			$heading = $current.find('h2'),
			$subheading = $current.find('h3'),
			$property = $current.find('.figure-property');

		prepare();
		animate();

		function prepare() {

			hideWords($heading, 0.6, 0.01, '50px');

			TweenMax.set($headlineProperty, {
				scaleX: 0,
				transformOrigin: 'left center'
			});

			TweenMax.set($headline, {
				scaleX: 0,
				transformOrigin: 'left center'
			});

		}

		function animate() {

			if ($heading.length) {

				tl.add(animateWords($heading));

			}
			if ($headline.length) {

				tl.to($headline, 1.2, {
					scaleX: 1,
					ease: Expo.easeInOut
				}, '0');

			}

			if ($subheading.length) {

				tl.add(animateLines($subheading, 1.2, 0.01), '0')

			}

			if ($property.length) {

				$property.each(function () {
					tl.add(animateLines($(this), 1.2, 0.01), '-=1.2');
					tl.to($(this).find($headlineProperty), 1.2, {
						scaleX: 1,
						ease: Expo.easeInOut,
						transformOrigin: 'left center'
					}, '0');
				});

			}

			createOSScene($current, tl);

		}

	})

}

/*!========================================================================
	48. Section Half Screen Slider
	======================================================================!*/
var SectionHalfScreenSlider = function ($scope) {

	var $target = $scope.find('.section-halfscreen-slider[data-os-animation]');

	if (!$target.length) {

		return;

	}

	$target.each(function () {
		
		var
			$target = $(this),
			$slider = $target.find('.js-slider-halfscreen'),
			$wrapperImg = $slider.find('.slider-halfscreen__images-slide .slider-halfscreen__images-slide-inner'),
			$heading = $slider.find('h2'),
			$description = $slider.find('p'),
			$link = $slider.find('.slider-halfscreen__link span'),
			$linkLine = $slider.find('.slider-halfscreen__link-line'),
			$prev = $slider.find('.slider-halfscreen__arrow_prev .slider__arrow-inner'),
			$next = $slider.find('.slider-halfscreen__arrow_next .slider__arrow-inner');

		prepare().then(function () {
			animate();
		});

		function prepare() {

			return new Promise(function (resolve, reject) {

				var tl = new TimelineMax();

				tl
					.add(function () {
						new SliderHalfScreen($slider);
					})
					.set($prev, {
						y: '-50px',
						autoAlpha: 0
					})
					.set($next, {
						y: '50px',
						autoAlpha: 0
					})
					.set($wrapperImg, {
						autoAlpha: 0,
						scale: 1.1
					})
					.add(hideWords($link, '0', '0', '30px'))
					.set($linkLine, {
						scaleX: 0,
						transformOrigin: 'left center'
					})
					.add(function () {
						setLines($description);
					})
					.add(hideWords($heading, '0', '0', '-50px'))
					.add(function () {
						resolve(true);
					});

			});

		}

		function animate() {

			var tl = new TimelineMax();

			tl
				.add(animateWords($slider.find('.swiper-slide-active h2'), 1.2, 0.02, true), '0')
				.add(animateLines($slider.find('.swiper-slide-active p'), 1.2, 0.01), '0.6')
				.add(animateWords($link, 1.2, 0.02), '1.2')
				.to($linkLine, 1.2, {
					scaleX: 1,
					ease: Expo.easeInOut
				}, '1.2')
				.to($wrapperImg, 1.2, {
					scale: 1,
				}, '0.3')
				.to($wrapperImg, 1.2, {
					autoAlpha: 1,
				}, '0.3')
				.to([$prev, $next], 1.2, {
					autoAlpha: 1,
					y: '0px'
				}, '0');

			createOSScene($target, tl);

		}
		
	});

}

/*!========================================================================
	49. Section Headings Slider
	======================================================================!*/
var SectionHeadingsSlider = function ($scope) {

	var $target = $scope.find('.section-headings-slider[data-os-animation]');

	if (!$target.length) {

		return;

	}

	$target.each(function () {

		var
			$target = $(this),
			$slider = $target.find('.js-slider-headings'),
			$counter = $slider.find('.slider-headings__counter'),
			$heading = $slider.find('h2'),
			$prev = $slider.find('.slider-headings__arrow_prev .slider__arrow-inner'),
			$next = $slider.find('.slider-headings__arrow_next .slider__arrow-inner'),
			$dots = $slider.find('.slider__dots'),
			$backgrounds = $slider.find('.slider__background');

		prepare().then(function () {
			animate();
		})

		function prepare() {

			return new Promise(function (resolve, reject) {

				var tl = new TimelineMax();

				tl
					.add(function () {
						new SliderHeadings($slider);
					})
					.set($prev, {
						x: '-50px',
						autoAlpha: 0
					})
					.set($next, {
						x: '50px',
						autoAlpha: 0
					})
					.add(hideWords($heading, '0', '0', '-100px'))
					.set($counter, {
						autoAlpha: 0,
					})
					.set($dots, {
						autoAlpha: 0,
						y: '50px'
					})
					.add(function () {
						resolve(true);
					});

			});

		}

		function animate() {

			var tl = new TimelineMax();

			tl
				.add(animateWords($slider.find('.swiper-slide-active h2'), 1.2, 0.02, true), '0')
				.add(animateLines($slider.find('.swiper-slide-active p'), 1.2, 0.01), '0.3')
				.to([$prev, $next], 1.2, {
					autoAlpha: 1,
					x: '0px'
				}, '0')
				.to($dots, 1.2, {
					autoAlpha: 1,
					y: '0px'
				}, '0')
				.to($counter, 1.2, {
					autoAlpha: 1,
				}, '0.3')
				.add(function () {
					new SliderBackgrounds($backgrounds);
				}, '0.6');

			createOSScene($target, tl);

		}
		
	});

}

/*!========================================================================
	50. Section Intro
	======================================================================!*/
var SectionIntro = function ($scope) {

	var $target = $scope.find('.section-intro[data-os-animation]');

	if (!$target.length) {

		return;

	}

	$target.each(function () {

		var
			$target = $(this),
			$headline = $target.find('.section-intro__headline'),
			$heading = $target.find('h1');

		prepare();
		animate();

		function prepare() {

			TweenMax.set($headline, {
				scaleX: 0,
				transformOrigin: 'left center'
			});

		}

		function animate() {

			var tl = new TimelineMax();

			tl
				.add(animateLines($heading, 1.2, 0.01))
				.to($headline, 0.6, {
					scaleX: 1,
					ease: Expo.easeInOut
				}, '0.3')

			createOSScene($target, tl);

		}
		
	});

}

/*!========================================================================
	51. Section Masthead
	======================================================================!*/
var SectionMasthead = function ($scope) {

	var $target = $scope.find('.section-masthead[data-os-animation]');

	if (!$target.length) {

		return;

	}

	var
		$headline = $target.find('.section__headline'),
		$heading = $target.find('h1'),
		$subheading = $target.find('h2'),
		$properties = $target.find('.figure-property');

	prepare();
	animate();

	function prepare() {

		TweenMax.set($headline, {
			scaleX: 0,
			transformOrigin: 'left center'
		});

		hideWords($heading, 0, 0);

	}

	function animate() {

		var tl = new TimelineMax();

		// if ($headline.length) {

		tl.to($headline, 1.2, {
			scaleX: 1,
			ease: Expo.easeInOut
		}, '0');

		// }

		// if ($heading.length) {
		tl.add(animateWords($heading, 1.2, 0.03, true), '0');
		// }

		// if ($subheading.length) {
		tl.add(animateLines($subheading, 1.2, 0.01), '0.6');
		// }

		// if ($properties.length) {
		tl.add(animateLines($properties, 1.2, 0.02), '0.6');
		// }

		// if ($overlay.length) {
		// 	tl.to($overlay, 1.2, {
		// 		opacity: initialOpacity,
		// 		ease: Expo.easeInOut
		// 	}, '0');
		// }

		createOSScene($target, tl);

	}

}

/*!========================================================================
	52. Section Text Slider
	======================================================================!*/
var SectionTextSlider = function ($scope) {

	var $target = $scope.find('.section-text-slider[data-os-animation]');

	if (!$target.length) {

		return;

	}

	$target.each(function () {

		var
			$target = $(this),
			$slider = $target.find('.js-slider-text'),
			$backgrounds = $slider.find('.slider__background'),
			$helper = $target.find('.slider-text__helper'),
			$helperNormal = $target.find('.slider-text__helper-label-normal'),
			$helperView = $target.find('.slider-text__helper-label-view'),
			$helperIconLeft = $slider.find('.slider-text__helper-icon_left'),
			$helperIconRight = $slider.find('.slider-text__helper-icon_right');

		prepare().then(function () {
			animate();
		});

		function prepare() {

			return new Promise(function (resolve, reject) {

				var tl = new TimelineMax();

				tl
					.set($helper, {
						y: '20px',
						autoAlpha: 0
					})
					.set($target.find('.slider-text__line'), {
						transformOrigin: 'left center',
						scaleX: 0
					})
					.add(hideWords($target.find('h2'), '0', '0', '-30px', true))
					.add(hideWords($target.find('.slider-text__counter'), '0', '0', '-30px', true))
					.add(hideWordsVertical($helperNormal, '0', '0', '10px'))
					.add(hideWordsVertical($helperView, '0', '0', '10px'))
					.add(function () {
						new SliderText($slider);
					})
					.add(function () {
						resolve(true);
					});

			});

		}

		function animate() {

			var tl = new TimelineMax();

			tl
				.to($helper, 0.6, {
					autoAlpha: 1,
					y: '0px'
				})
				.add(animateWords($target.find('.slider-text__counter'), 1.2, 0.01, true), '0')
				.add(animateWords($helperNormal, 0.6, 0.01, true), '0')
				.add(animateWords($target.find('.slider-text__upper h2'), 1.2, 0.01), '0')
				.add(animateWords($target.find('.slider-text__lower h2'), 1.2, 0.01), '0')
				.staggerTo($target.find('.slider-text__line'), 1.2, {
					scaleX: 1,
					ease: Expo.easeInOut
				}, 0.01, '0')
				.add(function () {
					hoverBackgrounds();
					new SliderBackgrounds($backgrounds);
				}, '0.6');


			createOSScene($target, tl);

		}

		function hoverBackgrounds() {

			var tl = new TimelineMax();

			$document
				.on('mouseenter touchstart', '.slider-text a[data-slide-id]', function () {

					tl
						.clear()
						.set($helper, {
							className: '+=color-white'
						})
						.to($helperIconLeft, 0.6, {
							x: '30px',
							rotation: 180,
							ease: Expo.easeInOut
						}, '0')
						.to($helperIconRight, 0.6, {
							x: '-30px',
							rotation: 180,
							ease: Expo.easeInOut
						}, '0')
						.add(hideWordsVertical($helperNormal, 0.6, 0.01, '30px', true), '0')
						.add(animateWords($helperView, 0.6, 0.01, true), '-=0.6');

				})
				.on('mouseleave touchend', '.slider-text a[data-slide-id]', function () {

					tl
						.clear()
						.set($helper, {
							className: '-=color-white'
						})
						.to($helperIconLeft, 0.6, {
							x: '0px',
							rotation: 0,
							ease: Expo.easeInOut
						}, '0')
						.to($helperIconRight, 0.6, {
							x: '0px',
							rotation: 0,
							ease: Expo.easeInOut
						}, '0')
						.add(hideWordsVertical($helperView, 0.6, 0.01, '-30px'), '0')
						.add(animateWords($helperNormal, 0.6, 0.01), '-=0.6');

				});

		}
		
	});

}

/*!========================================================================
	53. Section Nav Projects
	======================================================================!*/
var SectionNavProjects = function ($scope) {

	var $target = $scope.find('.section-nav-projects');

	if (!$target.length) {

		return;

	}

	var
		$backgrounds = $target.find('.section-nav-projects__background'),
		$ajaxLinks = $target.find('.section-nav-projects__inner[data-post-id]');

	$ajaxLinks
		.on('mouseenter touchstart', function () {
			var
				postId = $(this).data('post-id'),
				$targetBackground = $backgrounds.filter('[data-background-for="' + postId + '"]');

			if (!$targetBackground.length) {
				return;
			}

			$backgrounds.filter('active').removeClass('active');
			$targetBackground.addClass('active');

		})
		.on('mouseleave touchend', function () {

			$backgrounds.filter('.active').removeClass('active');

		})
		.on('click', function () {

			var
				postId = $(this).data('post-id'),
				$targetBackground = $backgrounds.filter('[data-background-for="' + postId + '"]'),
				$targetBackgroundGlobal = window.$backgrounds.filter('[data-background-for="' + postId + '"]');

			if (!$targetBackground.length || typeof elementor != 'undefined') {
				return;
			}

			$backgrounds.filter('active').removeClass('active');
			$targetBackgroundGlobal.addClass('selected');
			$targetBackground.addClass('selected');

			if ($targetBackground.is('video')) {
				$targetBackground.get(0).play();
			}

		});

}

/*!========================================================================
	54. Slider Backgrounds
	======================================================================!*/
var SliderBackgrounds = function ($backgrounds) {

	var
		$sliders = $('.section-headings-slider'),
		$ajaxLinks = $('.slider [data-slide-id]');

	$ajaxLinks
		.on('mouseenter touchstart', function () {
			var
				postId = $(this).data('slide-id'),
				$targetBackground = $backgrounds.filter('[data-background-for="' + postId + '"]');

			if (!$targetBackground.length) {
				return;
			}

			$targetBackground.addClass('active');

			// don't do anything on dark pages
			if ($('.page-wrapper').attr('data-barba-namespace') == 'dark') {
				return;
			}

			window.$header.removeClass('header_black').addClass('header_white');
			$sliders.addClass('color-white');

		})
		.on('mouseleave touchend', function () {

			$backgrounds.filter('.active').removeClass('active');

			// don't do anything on dark pages
			if ($('.page-wrapper').attr('data-barba-namespace') == 'dark') {
				return;
			}

			window.$header.removeClass('header_white').addClass('header_black');
			$sliders.removeClass('color-white');

		})
		.on('click', function () {

			var
				postId = $(this).data('slide-id'),
				$targetBackground = $backgrounds.filter('[data-background-for="' + postId + '"]'),
				$targetBackgroundGlobal = window.$backgrounds.filter('[data-background-for="' + postId + '"]');

			if (!$targetBackground.length || typeof elementor != 'undefined') {
				return;
			}

			$backgrounds.filter('active').removeClass('active');
			$targetBackgroundGlobal.addClass('selected');
			$targetBackground.addClass('selected');

		});

}

/*!========================================================================
	55. Render Slider Counter
	======================================================================!*/
function renderSliderCounter(sliderMain, sliderCounter, slideClass, elTotal) {

	if (!sliderMain.slides.length || !sliderCounter.length) {
		return;
	}

	var
		numOfSlides = sliderMain.slides.length,
		startSlides = 1,
		prefixCurrent = '00',
		prefixTotal = numOfSlides >= 10 ? '0' : '00';

	var counter = new Swiper(sliderCounter[0], {
		direction: 'vertical',
		simulateTouch: false,
		allowTouchMove: false
	});

	counter.removeAllSlides();

	for (var index = startSlides; index <= numOfSlides; index++) {

		if (index >= 10) {

			prefixCurrent = '0';

		}

		counter.appendSlide('<div class="swiper-slide"><div class="' + slideClass + '">' + prefixCurrent + index + '</div></div>');

	}


	$(elTotal).html(prefixTotal + numOfSlides);

	sliderMain.controller.control = counter;
	counter.controller.control = sliderMain;
}

/*!========================================================================
	56. Slider Half Screen
	======================================================================!*/
var SliderHalfScreen = function ($slider) {

	if (!$slider.length) {
		return;
	}

	var
		$heading = $slider.find('h2'),
		$description = $slider.find('p'),
		$link = $slider.find('.slider-halfscreen__wrapper-link'),
		$linksHover = $slider.find('.slider-halfscreen__link'),
		tl = new TimelineMax(),
		$sliderImg = $slider.find('.js-slider-halfscreen__images'),
		$sliderContent = $slider.find('.js-slider-halfscreen__content'),
		overlapFactor = $sliderImg.data('overlap-factor') || 0;

	createSliders();
	hoverLinks();

	function createSliders() {

		var sliderImg = new Swiper($sliderImg[0], {
			slidesPerGroup: 1,
			slidesPerView: 1,
			direction: 'vertical',
			preloadImages: true,
			lazy: {
				loadPrevNextAmount: 3,
				loadPrevNext: true,
				loadOnTransitionStart: true
			},
			speed: $sliderImg.data('speed') || 1200,
			simulateTouch: false,
			allowTouchMove: $sliderImg.data('touch-enabled') || false,
			watchSlidesProgress: true,
			on: {
				progress: function () {
					var swiper = this;
					for (var i = 0; i < swiper.slides.length; i++) {

						var slideProgress = swiper.slides[i].progress,
							innerOffset = swiper.height * overlapFactor,
							innerTranslate = slideProgress * innerOffset;

						try {
							TweenMax.set(swiper.slides[i].querySelector('.slider-halfscreen__bg'), {
								y: innerTranslate + 'px',
								rotationZ: 0.01,
								force3D: true
							});
						} catch (error) {

						}

					}
				},
				setTransition: function (instance, speed) {
					var swiper = this;
					var speedParam = typeof instance === 'number' ? instance : speed;

					for (var i = 0; i < swiper.slides.length; i++) {
						try {
							TweenMax.set(swiper.slides[i], {
								transition: speedParam + 'ms',
							});
							TweenMax.set(swiper.slides[i].querySelector('.slider-halfscreen__bg'), {
								transition: speedParam + 'ms',
								rotationZ: 0.01,
								force3D: true
							});
						} catch (error) {

						}

					}
				}
			}
		});

		var sliderContent = new Swiper($sliderContent[0], {
			slidesPerGroup: 1,
			slidesPerView: 1, // compatibility with Swiper 5.x
			direction: 'vertical',
			effect: 'fade',
			fadeEffect: {
				crossFade: true
			},
			autoplay: {
				enabled: $sliderImg.data('autoplay-enabled') || false,
				delay: $sliderImg.data('autoplay-delay') || 6000,
			},
			mousewheel: $sliderImg.data('mousewheel-enabled') ? {
				eventsTarged: $sliderImg.data('mousewheel-target') || '.page-wrapper',
				eventsTarget: $sliderImg.data('mousewheel-target') || '.page-wrapper',
				releaseOnEdges: true,
			} : false,
			keyboard: {
				enabled: $sliderImg.data('keyboard-enabled') || false
			},
			navigation: {
				nextEl: '.js-slider-halfscreen__next',
				prevEl: '.js-slider-halfscreen__prev',
			},
			speed: $sliderImg.data('speed') || 1200,
			allowTouchMove: $sliderImg.data('touch-enabled') || false,
			simulateTouch: true,
			breakpointsInverse: true // compatibility with both Swiper 4.x and 5.x
		});

		sliderContent.params.breakpoints = {
			0: {
				autoHeight: true
			},
			992: {
				autoHeight: false
			}
		};

		sliderContent.update();


		sliderContent.on('slideChange', () => {

			if (sliderContent.realIndex > sliderContent.previousIndex) {
				slideChangeTransition('next');
			}

			if (sliderContent.realIndex < sliderContent.previousIndex) {
				slideChangeTransition('prev');
			}

		});

		function slideChangeTransition(direction = 'next') {

			var
				$activeSlide = $(sliderContent.slides[sliderContent.realIndex]),
				$activeHeading = $activeSlide.find($heading),
				$activeLink = $activeSlide.find($link),
				$activeDescription = $activeSlide.find($description);

			tl.clear();

			if ($activeHeading.length) {
				tl.add(hideWords($activeHeading, '0', '0', direction === 'next' ? '-50px' : '50px'), '0');
			}

			if ($heading.length) {
				$heading.not($activeHeading).each(function () {
					tl.add(hideWords($(this), 0.3, 0.02, direction === 'next' ? '50px' : '-50px', direction === 'next' ? true : false), '0');
				});
			}

			if ($activeDescription.length) {
				tl.add(hideLines($activeDescription, '0', '0', '100%'), '0');
			}

			if ($description.length) {
				$description.not($activeDescription).each(function () {
					tl.add(hideLines($(this), 0.6, 0.01, '100%', true), '0');
				});
			}

			if ($activeLink.length) {
				tl.set($activeLink, {
					y: '15px',
					autoAlpha: 0
				}, '0');
			}

			if ($link.length) {
				$link.not($activeLink).each(function () {
					tl.to($(this), 0.6, {
						y: '15px',
						autoAlpha: 0
					}, '0');
				});
			}

			tl
				.add(animateWords($activeHeading, 1.2, 0.02, direction === 'next' ? true : false))
				.add(animateLines($activeDescription, 1.2, 0.01, direction === 'next' ? true : false), '-=1.2')
				.to($activeLink, 0.6, {
					y: '0px',
					autoAlpha: 1
				}, '-=1.2');

		}

		sliderImg.controller.control = sliderContent;
		sliderContent.controller.control = sliderImg;

		/**
		 * Resize handling (with debounce)
		 */
		window.$window.on('resize', debounce(function () {
			if (typeof sliderImg === 'object') {
				sliderImg.update();
			}
			if (typeof sliderContent === 'object') {
				sliderContent.update();
			}
		}, 250));

	}

	function hoverLinks() {

		$linksHover
			.on('mouseenter touchstart', function () {

				var $targetBackground = $sliderImg.find('.swiper-slide-active .slider-halfscreen__images-slide-inner'),
					$linkLine = $sliderContent.find('.swiper-slide-active .slider-halfscreen__link-line');

				if (!$targetBackground.length) {
					return;
				}

				TweenMax.to($targetBackground, 0.6, {
					scale: 1.05,
					ease: Expo.easeInOut
				});

				TweenMax.to($linkLine, 0.6, {
					width: '70px',
					ease: Expo.easeInOut
				});

			})
			.on('mouseleave touchend', function () {

				var $targetBackground = $sliderImg.find('.swiper-slide-active .slider-halfscreen__images-slide-inner'),
					$linkLine = $sliderContent.find('.swiper-slide-active .slider-halfscreen__link-line');

				if (!$targetBackground.length) {
					return;
				}

				TweenMax.to($targetBackground, 0.6, {
					scale: 1,
					ease: Expo.easeInOut
				});

				TweenMax.to($linkLine, 0.6, {
					width: '60px',
					ease: Expo.easeInOut
				});

			});

	}

}

/*!========================================================================
	57. Slider Headings
	======================================================================!*/
var SliderHeadings = function ($slider) {

	if (!$slider.length) {
		return;
	}

	var
		$heading = $slider.find('h2'),
		$description = $slider.find('p'),
		tl = new TimelineMax(),
		slider = new Swiper($slider[0], {
			simulateTouch: false,
			allowTouchMove: $slider.data('touch-enabled') || false,
			effect: 'fade',
			fadeEffect: {
				crossFade: true
			},
			speed: $slider.data('speed') || 1200,
			autoplay: {
				enabled: $slider.data('autoplay-enabled') || false,
				delay: $slider.data('autoplay-delay') || 6000,
			},
			slidesPerView: 1,
			slidesPerGroup: 1, // compatibility with Swiper 5.x
			centeredSlides: true,
			mousewheel: $slider.data('mousewheel-enabled') ? {
				eventsTarged: $slider.data('mousewheel-target') || '.page-wrapper',
				eventsTarget: $slider.data('mousewheel-target') || '.page-wrapper',
				releaseOnEdges: true,
			} : false,
			keyboard: {
				enabled: $slider.data('keyboard-enabled') || false
			},
			pagination: {
				el: '.js-slider-headings__dots',
				type: 'bullets',
				bulletElement: 'div',
				clickable: true,
				bulletClass: 'slider__dot',
				bulletActiveClass: 'slider__dot_active'
			},
			navigation: {
				nextEl: '.js-slider-headings__next',
				prevEl: '.js-slider-headings__prev',
			}
		});

	slider.on('slideChange', () => {

		if (slider.realIndex > slider.previousIndex) {
			slideChangeTransition('next');
		}

		if (slider.realIndex < slider.previousIndex) {
			slideChangeTransition('prev');
		}

	});

	function slideChangeTransition(direction = 'next') {

		var
			$activeSlide = $(slider.slides[slider.realIndex]),
			$activeDescription = $activeSlide.find($description),
			$activeHeading = $activeSlide.find($heading);

		tl.clear();

		if ($activeHeading.length) {
			tl.add(hideWords($activeHeading, '0', '0', direction === 'next' ? '-50px' : '50px'), '0');
		}

		if ($heading.length) {
			$heading.not($activeHeading).each(function () {
				tl.add(hideWords($(this), 0.3, 0.02, direction === 'next' ? '50px' : '-50px', direction === 'next' ? true : false), '0');
			});
		}

		if ($activeDescription.length) {
			tl.add(hideLines($activeDescription, '0', '0', '100%'), '0');
		}

		if ($description.length) {
			$description.not($activeDescription).each(function () {
				tl.add(hideLines($(this), 0.6, 0.01, '100%', true), '0');
			});
		}

		tl
			.add(animateWords($activeHeading, 1.2, 0.02, direction === 'next' ? true : false))
			.add(animateLines($activeDescription, 1.2, 0.01, direction === 'next' ? true : false), '-=1.2');

	}

	renderSliderCounter(
		slider,
		$slider.find('.js-slider-headings-counter-current'),
		'slider-headings__counter-number',
		''
	);

}

/*!========================================================================
	58. Slider Images
	======================================================================!*/
var SliderImages = function ($scope) {

	var $slider = $scope.find('.js-slider-images');

	if (!$slider.length) {
		return;
	}

	$slider.each(function () {
		var $current = $(this);
		var
			lg = window.elementorFrontend ? window.elementorFrontend.config.breakpoints.lg - 1 : 1024,
			md = window.elementorFrontend ? window.elementorFrontend.config.breakpoints.md - 1 : 767;

		const autoHeight = $current.data('auto-height');
		const centeredSlides = $current.data('centered-slides');
		const centeredSlidesTablet = $current.data('centered-slides-tablet');
		const centeredSlidesMobile = $current.data('centered-slides-mobile');

		var slider = new Swiper($current[0], {
			autoHeight: autoHeight && autoHeight === 'false' ? false : true,
			speed: $current.data('speed') || 1200,
			preloadImages: false,
			lazy: {
				loadPrevNext: true,
				loadOnTransitionStart: true,
				loadPrevNextAmount: 3
			},
			observer: true,
			watchSlidesProgress: true,
			watchSlidesVisibility: true,
			slidesPerGroup: 1, // compatibility with Swiper 5.x
			centeredSlides: centeredSlides && centeredSlides !== 'false' ? true : false,
			slidesPerView: $current.data('slides-per-view') || 1.5,
			autoplay: {
				enabled: $current.data('autoplay-enabled') || false,
				delay: $current.data('autoplay-delay') || 6000,
			},
			spaceBetween: $current.data('space-between') || 80,
			pagination: {
				el: '.js-slider-images-progress',
				type: 'progressbar',
				progressbarFillClass: 'slider__progressbar-fill',
				renderProgressbar: function (progressbarFillClass) {
					return '<div class="' + progressbarFillClass + '"></div>'
				}
			},
			navigation: {
				nextEl: '.js-slider-images__next',
				prevEl: '.js-slider-images__prev',
			},
			breakpointsInverse: true // compatibility with both Swiper 4.x and 5.x
		});

		slider.params.breakpoints = {
			[lg]: {
				slidesPerView: $current.data('slides-per-view') || 1.5,
				spaceBetween: $current.data('space-between') || 80,
				centeredSlides: centeredSlides && centeredSlides !== 'false' ? true : false,
			},
			[md]: {
				slidesPerView: $current.data('slides-per-view-tablet') || 1.33,
				spaceBetween: $current.data('space-between-tablet') || 30,
				centeredSlides: centeredSlidesTablet && centeredSlidesTablet !== 'false' ? true : false,
			},
			0: {
				slidesPerView: $current.data('slides-per-view-mobile') || 1.33,
				spaceBetween: $current.data('space-between-mobile') || 30,
				centeredSlides: centeredSlidesMobile && centeredSlidesMobile !== 'false' ? true : false,
			}
		};

		slider
			// update height after images are loaded
			.on('lazyImageReady', function () {
				slider.update();
			})
			// cursor position adjustment
			.on('touchMove', function (swiper, e) {
				if (typeof window.InteractiveCursor !== 'undefined') {
					if (swiper instanceof Swiper) {
						window.InteractiveCursor.mouseX = e.clientX;
						window.InteractiveCursor.mouseY = e.clientY;
					} else {
						window.InteractiveCursor.mouseX = swiper.clientX;
						window.InteractiveCursor.mouseY = swiper.clientY;
					}
				}
			});

		renderSliderCounter(
			slider,
			$current.find('.js-slider-images-counter-current'),
			'',
			$current.find('.js-slider-images-counter-total')
		);

	});

}

/*!========================================================================
	59. Slider Testimonials
	======================================================================!*/
var SliderTestimonials = function ($scope) {

	var $slider = $scope.find('.js-slider-testimonials');

	if (!$slider.length) {
		return;
	}

	$slider.each(function () {

		var
			$current = $(this).find('.js-slider-testimonials__items'),
			$header = $(this).find('.js-slider-testimonials__header');

		var sliderItems = new Swiper($current[0], {
			autoHeight: true,
			autoplay: {
				enabled: $current.data('autoplay-enabled') || false,
				delay: $current.data('autoplay-delay') || 6000,
			},
			speed: $current.data('speed') || 1200,
			preloadImages: false,
			lazy: {
				loadPrevNext: true,
				loadOnTransitionStart: true
			},
			watchSlidesProgress: true,
			watchSlidesVisibility: true,
			pagination: {
				el: '.js-slider-testimonials__dots',
				type: 'bullets',
				bulletElement: 'div',
				clickable: true,
				bulletClass: 'slider__dot',
				bulletActiveClass: 'slider__dot_active'
			},
		});

		var sliderHeader = new Swiper($header[0], {
			slideToClickedSlide: true,
			slidesPerGroup: 1, // compatibility with Swiper 5.x
			slidesPerView: 4.5,
			centeredSlides: true,
			speed: $current.data('speed') || 1200,
			autoplay: {
				enabled: $current.data('autoplay-enabled') || false,
				delay: $current.data('autoplay-delay') || 6000,
			},
			breakpointsInverse: true // compatibility with both Swiper 4.x and 5.x
		});

		sliderHeader.params.breakpoints = {
			1200: {
				slidesPerView: 4.5
			},
			767: {
				slidesPerView: 3.5
			},
			480: {
				slidesPerView: 2
			},
			0: {
				slidesPerView: 1
			},
		};

		sliderHeader.update();

		// update height after images are loaded
		sliderItems.on('lazyImageReady', function () {

			setTimeout(function () {
				sliderItems.update();
			}, 300);

		});

		sliderHeader.on('slideChange', function () {
			sliderItems.lazy.load();
		});

		sliderItems.controller.control = sliderHeader;
		sliderHeader.controller.control = sliderItems;

	});

}

/*!========================================================================
	60. Slider Text
	======================================================================!*/
var SliderText = function ($slider) {

	if (!$slider.length) {
		return;
	}

	var
		$upper = $slider.find('.js-slider-text__upper'),
		$lower = $slider.find('.js-slider-text__lower'),
		options = {
			speed: 2000,
			slidesPerView: 'auto',
			slidesPerGroup: 1, // compatibility with Swiper 5.x
			centeredSlides: true,
			loop: true,
			touchRatio: 2,
			mousewheel: $slider.data('mousewheel-enabled') ? {
				eventsTarged: $slider.data('mousewheel-target') || '.page-wrapper',
				releaseOnEdges: true,
			} : false,
			controller: {
				by: 'container'
			},
			breakpointsInverse: true // compatibility with both Swiper 4.x and 5.x
		};

	var sliderUpper = new Swiper($upper[0], options);
	var sliderLower = new Swiper($lower[0], options);

	sliderUpper.params.breakpoints = {
		0: {
			slidesPerView: 1,
		},
		768: {
			slidesPerView: 'auto',
		}
	};

	sliderLower.params.breakpoints = {
		0: {
			slidesPerView: 1,
		},
		768: {
			slidesPerView: 'auto',
		}
	};

	sliderUpper.on('touchMove', function (swiper, e) {
		if (typeof window.InteractiveCursor !== 'undefined') {
			if (swiper instanceof Swiper) {
				window.InteractiveCursor.mouseX = e.clientX;
				window.InteractiveCursor.mouseY = e.clientY;
			} else {
				window.InteractiveCursor.mouseX = swiper.clientX;
				window.InteractiveCursor.mouseY = swiper.clientY;
			}
		}
	});

	sliderLower.on('touchMove', function (swiper, e) {
		if (typeof window.InteractiveCursor !== 'undefined') {
			if (swiper instanceof Swiper) {
				window.InteractiveCursor.mouseX = e.clientX;
				window.InteractiveCursor.mouseY = e.clientY;
			} else {
				window.InteractiveCursor.mouseX = swiper.clientX;
				window.InteractiveCursor.mouseY = swiper.clientY;
			}
		}
	});

	sliderUpper.update();
	sliderLower.update();

	sliderUpper.controller.control = sliderLower;
	sliderLower.controller.control = sliderUpper;
}

/*!========================================================================
	61. Social
	======================================================================!*/
var Social = function () {

	var $elements = $('.social__item a');

	if (!$elements.length) {
		return;
	}

	var circle = new Circle();

	$elements.each(function () {
		circle.animate($(this));
	});

}

/*!========================================================================
	62. Animate Lines
	======================================================================!*/
function animateLines($target, duration = 1.2, stagger = 0.02) {

	var
		tl = new TimelineMax(),
		$headlineProperty = $target.find('.figure-property__headline'),
		$words = $target.find('.split-text__word');

	if ($headlineProperty.length) {

		tl
			.to($headlineProperty, duration, {
				ease: Expo.easeOut,
				scaleX: 1
			}, '0');

	}

	if ($words.length) {

		tl
			.staggerTo($words, duration, {
				y: '0%',
				ease: Power3.easeOut,
				autoAlpha: 1,
			}, stagger, '0.3');

	};

	return tl;

}

/*!========================================================================
	63. Animate Words
	======================================================================!*/
function animateWords($target, duration = 1.2, stagger = 0.01, reverse, masterStagger) {

	var masterTL = new TimelineMax();

	if ($target.length) {

		$target.each(function () {

			var
				tl = new TimelineMax(),
				$chars = $(this).find('.split-chars__char');

			if (reverse) {
				$chars = $chars.get().reverse();
			}

			if (!masterStagger) {
				masterStagger = '-=' + duration;
			}

			tl.staggerTo($chars, duration, {
				x: '0px',
				y: '0px',
				autoAlpha: 1,
				ease: Power4.easeOut
			}, stagger);

			masterTL.add(tl, masterStagger);

		});

	};

	return masterTL;

}

/*!========================================================================
	64. Do Split Text
	======================================================================!*/
function doSplitText($target = window.$document) {

	var
		$words = $target.find('[data-os-animation] .split-text'),
		$chars = $target.find('[data-os-animation] .split-chars');

	return new Promise(function (resolve, reject) {

		if ($words.length) {

			TweenMax.set($words, {
				autoAlpha: 1,
			});

			new SplitText($words, {
				type: 'words, lines',
				linesClass: 'split-text__line',
				wordsClass: 'split-text__word',
			});

		}

		if ($chars.length) {

			TweenMax.set($chars, {
				autoAlpha: 1,
			});

			new SplitText($chars, {
				type: 'words, chars',
				wordsClass: 'split-text__word',
				charsClass: 'split-chars__char'
			});


		}

		resolve(true);

	});

}

/*!========================================================================
	65. Hide Lines
	======================================================================!*/
function hideLines($target, duration = 0.6, stagger = 0.02, offset = '-100%', reverse) {

	var
		tl = new TimelineMax(),
		$words = $target.find('.split-text__word');

	if (reverse) {
		$words = $words.get().reverse();
	}

	if ($words.length) {

		tl.staggerTo($words, duration, {
			y: offset
		}, stagger);

	};

	return tl;

}

/*!========================================================================
	66. Hide Words
	======================================================================!*/
function hideWords($target, duration = 0.6, stagger = 0.02, offset = '-30px', reverse, masterStagger, direction = 'x') {

	var masterTL = new TimelineMax();

	if ($target.length) {

		$target.each(function () {

			var
				tl = new TimelineMax(),
				$chars = $(this).find('.split-chars__char'),
				options = {};

			if (reverse) {
				$chars = $chars.get().reverse();
			}

			if (!masterStagger) {
				masterStagger = '-=' + duration;
			}

			if (direction == 'x') {
				options = {
					x: offset,
					autoAlpha: 0
				};
			} else {
				options = {
					y: offset,
					autoAlpha: 0
				}
			}

			tl.staggerTo($chars, duration, options, stagger);

			masterTL.add(tl, masterStagger);
		});

	};

	return masterTL;

}

/*!========================================================================
	67. Hide Words Vertical
	======================================================================!*/
function hideWordsVertical($target, duration = 0.6, stagger = 0.02, offset = '-30px', reverse, masterStagger) {

	var masterTL = new TimelineMax();

	if ($target.length) {

		$target.each(function () {

			var
				tl = new TimelineMax(),
				$chars = $(this).find('.split-chars__char');

			if (reverse) {
				$chars = $chars.get().reverse();
			}

			if (!masterStagger) {
				masterStagger = '-=' + duration;
			}

			tl.staggerTo($chars, duration, {
				y: offset,
				autoAlpha: 0
			}, stagger);

			masterTL.add(tl, masterStagger);
		});

	};

	return masterTL;

}

/*!========================================================================
	68. Set Lines
	======================================================================!*/
function setLines($target = window.$document, direction = 'vertical') {

	var
		$words = $target.find('.split-text .split-text__word'),
		$chars = $target.find('.split-chars .split-text__char');

	if (direction == 'vertical') {

		TweenMax.set($words, {
			y: '100%',
		});

		TweenMax.set($chars, {
			y: '100%',
		});

	} else {

		TweenMax.set($chars, {
			x: '50px',
			autoAlpha: 0
		});

	}

}

/*!========================================================================
	69. Load Swiper
	======================================================================!*/
function loadSwiper() {
	return new Promise((resolve) => {
		if (typeof window.Swiper === 'undefined' && !window.isSwiperLoaded) {
			window.elementorComponentsLoaded.then(() => {
				if (!window.isSwiperLoaded) {
					elementorFrontend.utils.assetsLoader.load('script', 'swiper').then((instance) => {
						window.isSwiperLoaded = true;
						resolve(true);
					});
				} else {
					resolve(true);
				}
			});
		} else {
			resolve(true);
		}
	});
}

/*!========================================================================
	70. Run On High Performance GPU
	======================================================================!*/
function runOnHighPerformanceGPU() {

	const webGLCanvas = document.getElementById('js-webgl');

	if (!Modernizr.touchevents && webGLCanvas) {
		webGLCanvas.getContext('webgl', {
			powerPreference: 'high-performance'
		});
	}

}

/*!========================================================================
	71. Sanitize Selector
	======================================================================!*/
function sanitizeSelector(string) {
  if (!string || !string.length) {
    return false;
  }

  return string
    .replace(/(\r\n|\n|\r)/gm, '') // remove tabs, spaces
    .replace(/(\\n)/g, '') // remove lines breaks
    .replace(/^[,\s]+|[,\s]+$/g, '') // remove redundant commas
    .replace(/\s*,\s*/g, ','); // remove duplicated commas
}

/*!========================================================================
	72. Sync Attributes
	======================================================================!*/
$.fn.getAllAttributes = function () {
  var
    elem = this,
    attr = {};

  if (elem && elem.length) $.each(elem.get(0).attributes, function (v, n) {
    n = n.nodeName || n.name;
    v = elem.attr(n); // relay on $.fn.attr, it makes some filtering and checks
    if (v != undefined && v !== false) attr[n] = v
  })

  return attr;
}

function syncAttributes($sourceElement, $targetElement) {

	// single element
	if ($sourceElement.length === 1 && $targetElement.length === 1) {
		const
			targetEl = $targetElement.get(0),
			targetAttributes = $targetElement.getAllAttributes(),
			sourceAttributes = $sourceElement.getAllAttributes();

		// source element doesn't have any attributes present
		if ($.isEmptyObject(sourceAttributes)) {
			// ... so remove all attributes from the target element
			[...targetEl.attributes].forEach(attr => targetEl.removeAttribute(attr.name));
		} else {
			Object.keys(targetAttributes).forEach((key) => {
				// delete key on target that doesn't exist in source element
				if (key !== 'style' && !(key in sourceAttributes)) {
					$targetElement.removeAttr(key);
				}
			});

			// sync attributes
			$targetElement.attr(sourceAttributes);
		}

	// multiple elements
	} else if ($sourceElement.length > 1 && $targetElement.length > 1 && $sourceElement.length === $targetElement.length) {

		$.each($targetElement, function (index) {
			const
				$current = $(this),
				sourceAttributes = $sourceElement.eq(index).getAllAttributes();

			// source element doesn't have any attributes present
			if ($.isEmptyObject(sourceAttributes)) {
				// ... so remove all attributes from the target element
				[...this.attributes].forEach(attr => this.removeAttribute(attr.name));
			} else {

				// sync attributes
				$current.attr(sourceAttributes);
			}
		});

	}

}

/*!========================================================================
	73. Elementor
	======================================================================!*/
/**
 * Elementor Preview
 */
window.$window.on('elementor/frontend/init', function () {

	if (typeof elementor !== 'undefined') {

		elementorFrontend.hooks.addAction('frontend/element_ready/global', function ($scope) {
			loadSwiper().then(() => {
				initComponents($scope);
				window.$body.removeClass('cursor-progress');
			});
		});

	}

});


})(jQuery);
