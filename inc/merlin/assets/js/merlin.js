
var Merlin = (function ($) {
	var t;
	var drawer_opened = 'merlin__drawer--open';

	function sanitize(html) {
		function trimAttributes(node) {
			$.each(node.attributes, function () {
				var attrName = this.name;
				var attrValue = this.value;

				// remove attribute name start with "on", possible unsafe,
				// for example: onload, onerror...

				// remove any attributes value with "javascript:" pseudo protocol, possible unsafe,
				if (attrName && (attrName.indexOf('on') === 0 || (attrValue && attrValue.includes('javascript:')))) {
					$(node).removeAttr(attrName);
				}
			});

			var hrefValue = node.getAttribute('href');

			// remove "href" if it contains "javascript:" pseudo protocol, possible unsafe
			if (hrefValue && hrefValue.includes('javascript:')) {
				$(node).removeAttr('href');
			}
		}

		// [jQuery.parseHTML(data [, context ] [, keepScripts ])](http://api.jquery.com/jQuery.parseHTML/) added: 1.8
		// Parses a string into an array of DOM nodes.
		//
		// By default, the context is the current document if not specified or given as null or undefined. If the HTML was to be used in another document such as an iframe, that frame's document could be used.
		//
		// As of 3.0 the default behavior is changed.
		//
		// If the context is not specified or given as null or undefined, a new document is used.
		// This can potentially improve security because inline events will not execute when the HTML is parsed. Once the parsed HTML is injected into a document it does execute, but this gives tools a chance to traverse the created DOM and remove anything deemed unsafe. This improvement does not apply to internal uses of jQuery.parseHTML as they usually pass in the current document. Therefore, a statement like $( "#log" ).append( $( htmlString ) ) is still subject to the injection of malicious code.
		//
		// without context do not execute script
		// $.parseHTML('<div><img src=1 onerror=alert(1)></div>');
		// $.parseHTML('<div><img src=1 onerror=alert(2)></div>', null);
		//
		// with context document execute script!
		// $.parseHTML('<div><img src=1 onerror=alert(3)></div>', document);
		// 
		// Most jQuery APIs that accept HTML strings will run scripts that are included in the HTML. jQuery.parseHTML does not run scripts in the parsed HTML unless keepScripts is explicitly true. However, it is still possible in most environments to execute scripts indirectly, for example via the <img onerror> attribute.
		//
		// will return []
		// $.parseHTML('<script>alert(1)<\/script>', null, false);
		// will return [script DOM element]
		// $.parseHTML('<script>alert(1)<\/script>', null, true);
		var output = $($.parseHTML('<div>' + html + '</div>', null, false));
		output.find('*').each(function () {
			trimAttributes(this);
		});
		return output.html();
	};

	// callbacks from form button clicks.
	var callbacks = {
		install_child: function (btn) {
			var installer = new ChildTheme();
			installer.init(btn);
		},
		activate_license: function (btn) {
			var license = new ActivateLicense();
			license.init(btn);
		},
		install_plugins: function (btn) {
			var plugins = new PluginManager();
			plugins.init(btn);
		},
		install_content: function (btn) {
			var content = new ContentManager();
			content.init(btn);
		}
	};

	function window_loaded() {
		var
			body = $('.merlin__body'),
			body_loading = $('.merlin__body--loading'),
			body_exiting = $('.merlin__body--exiting'),
			drawer_trigger = $('#merlin__drawer-trigger'),
			drawer_opening = 'merlin__drawer--opening';

		var formWrapper = $('form.merlin__content--license-key');
		var licenseKeyField = $('.js-license-key');

		formWrapper.on('submit', function (e) {
			e.preventDefault();

			if (formWrapper.get(0).checkValidity()) {
				$('.js-merlin-license-activate-button').click();
			}
		});

		licenseKeyField.on('change', function (e) {
			if (e.target.validity.valid) {
				licenseKeyField.closest('.merlin__content--license-key').removeClass('has-error');
			}
		});

		setTimeout(function () {
			body.addClass('loaded');
		}, 100);

		drawer_trigger.on('click', function () {
			body.toggleClass(drawer_opened);
		});

		$('.merlin__button--proceed:not(.merlin__button--closer)').click(function (e) {
			e.preventDefault();
			var goTo = this.getAttribute("href");

			body.addClass('exiting');

			setTimeout(function () {
				window.location = goTo;
			}, 400);
		});

		$(".merlin__button--closer").on('click', function (e) {

			body.removeClass(drawer_opened);

			e.preventDefault();
			var goTo = this.getAttribute("href");

			setTimeout(function () {
				body.addClass('exiting');
			}, 600);

			setTimeout(function () {
				window.location = goTo;
			}, 1100);
		});

		$(".button-next").on("click", function (e) {
			e.preventDefault();
			var loading_button = merlin_loading_button(this);
			if (!loading_button) {
				return false;
			}
			var data_callback = $(this).data("callback");
			if (data_callback && typeof callbacks[data_callback] !== "undefined") {
				// We have to process a callback before continue with form submission.
				callbacks[data_callback](this);
				return false;
			} else {
				return true;
			}
		});

		$(document).on('change', '.js-merlin-demo-import-select', function () {
			var selectedIndex = $(this).val(),
				$selectedOption = $(this).children(':selected'),
				optionImgSrc = $selectedOption.data('img-src'),
				optionNotice = $selectedOption.data('notice'),
				optionPreviewUrl = $selectedOption.data('preview-url');

			$.post(merlin_params.ajaxurl, {
				action: 'merlin_update_selected_import_data_info',
				wpnonce: merlin_params.wpnonce,
				selected_index: selectedIndex,
			}, function (response) {
				if (response.success) {
					// file deepcode ignore DOMXSS: <response data is sanitized using the sanitize() function above>
					$('.js-merlin-drawer-import-content').html(sanitize(response.data));
				}
				else {
					alert(merlin_params.texts.something_went_wrong);
				}
			})
				.fail(function () { alert(merlin_params.texts.something_went_wrong) });
		});
	}

	function ChildTheme() {
		var body = $('.merlin__body');
		var complete, notice = $("#child-theme-text");

		function ajax_callback(r) {

			if (typeof r.done !== "undefined") {
				setTimeout(function () {
					notice.addClass("lead");
				}, 0);
				setTimeout(function () {
					notice.addClass("success");
					notice.html(sanitize(r.message));
				}, 600);


				complete();
			} else {
				notice.addClass("lead error");
				notice.html(sanitize(r.error));
			}
		}

		function do_ajax() {
			jQuery.post(merlin_params.ajaxurl, {
				action: "merlin_child_theme",
				wpnonce: merlin_params.wpnonce,
			}, ajax_callback).fail(ajax_callback);
		}

		return {
			init: function (btn) {
				complete = function () {

					setTimeout(function () {
						$(".merlin__body").addClass('js--finished');
					}, 1500);

					body.removeClass(drawer_opened);

					setTimeout(function () {
						$('.merlin__body').addClass('exiting');
					}, 3500);

					setTimeout(function () {
						window.location.href = btn.href;
					}, 4000);

				};
				do_ajax();
			}
		}
	}

	function ActivateLicense() {
		var body = $('.merlin__body');
		var wrapper = $('.merlin__content--license-key');
		var complete, notice = $('#license-text');

		function ajax_callback(r) {
			if (typeof r.success !== "undefined" && r.success) {
				notice.siblings('.error-message').remove();
				setTimeout(function () {
					notice.addClass("lead");
				}, 0);
				setTimeout(function () {
					notice.addClass("success");
					notice.html(sanitize(r.message));
				}, 600);
				complete();
			} else {
				$('.js-merlin-license-activate-button').removeClass('merlin__button--loading').data('done-loading', 'no');
				notice.siblings('.error-message').remove();
				wrapper.addClass('has-error');
				notice.html(sanitize(r.message));
				notice.siblings('.error-message').addClass("lead error");
				$('.js-license-key').val('');
			}
		}

		function do_ajax() {
			var formWrapper = $('form.merlin__content--license-key').get(0);
			if (formWrapper && formWrapper.checkValidity()) {

				wrapper.removeClass('has-error');

				jQuery.post(merlin_params.ajaxurl, {
					action: "merlin_activate_license",
					wpnonce: merlin_params.wpnonce,
					license_key: $('.js-license-key').val()
				}, ajax_callback).fail(ajax_callback);
			} else {
				ajax_callback({ message: 'Invalid license key' });
			}
		}

		return {
			init: function (btn) {
				complete = function () {
					setTimeout(function () {
						$(".merlin__body").addClass('js--finished');
					}, 1500);

					body.removeClass(drawer_opened);

					setTimeout(function () {
						$('.merlin__body').addClass('exiting');
					}, 3500);

					setTimeout(function () {
						window.location.href = btn.href;
					}, 4000);

				};
				do_ajax();
			}
		}
	}

	function PluginManager() {
		var body = $('.merlin__body');
		var complete;
		var items_completed = 0;
		var current_item = "";
		var $current_node;
		var current_item_hash = "";

		function ajax_callback(response) {
			var currentSpan = $current_node.find("label");
			if (typeof response === "object" && typeof response.message !== "undefined") {
				currentSpan.removeClass('installing success error').addClass(response.message.toLowerCase());

				// The plugin is done (installed, updated and activated).
				if (typeof response.done != "undefined" && response.done) {
					find_next();
				} else if (typeof response.url != "undefined") {
					// we have an ajax url action to perform.
					if (response.hash == current_item_hash) {
						currentSpan.removeClass('installing success').addClass("error");
						find_next();
					} else {
						current_item_hash = response.hash;
						jQuery.post(response.url, response, ajax_callback).fail(ajax_callback);
					}
				} else {
					// error processing this plugin
					find_next();
				}
			} else {
				// The TGMPA returns a whole page as response, so check, if this plugin is done.
				process_current();
			}
		}

		function process_current() {
			if (current_item) {
				var $check = $current_node.find("input:checkbox");
				if ($check.is(":checked")) {
					jQuery.post(merlin_params.ajaxurl, {
						action: "merlin_plugins",
						wpnonce: merlin_params.wpnonce,
						slug: current_item,
					}, ajax_callback).fail(ajax_callback);
				} else {
					$current_node.addClass("skipping");
					setTimeout(find_next, 300);
				}
			}
		}

		function find_next() {
			if ($current_node) {
				if (!$current_node.data("done_item")) {
					items_completed++;
					$current_node.data("done_item", 1);
				}
				$current_node.find(".spinner").css("visibility", "hidden");
			}
			var $li = $(".merlin__drawer--install-plugins li");
			$li.each(function () {
				var $item = $(this);

				if ($item.data("done_item")) {
					return true;
				}

				current_item = $item.data("slug");
				$current_node = $item;
				process_current();
				return false;
			});
			if (items_completed >= $li.length) {
				// finished all plugins!
				complete();
			}
		}

		return {
			init: function (btn) {
				$(".merlin__drawer--install-plugins").addClass("installing");
				$(".merlin__drawer--install-plugins").find("input").prop("disabled", true);
				complete = function () {

					setTimeout(function () {
						$(".merlin__body").addClass('js--finished');
					}, 1000);

					body.removeClass(drawer_opened);

					setTimeout(function () {
						$('.merlin__body').addClass('exiting');
					}, 3000);

					setTimeout(function () {
						window.location.href = btn.href;
					}, 3500);

				};
				find_next();
			}
		}
	}

	function ContentManager() {
		var body = $('.merlin__body');
		var complete;
		var items_completed = 0;
		var current_item = "";
		var $current_node;
		var current_item_hash = "";
		var current_content_import_items = 1;
		var total_content_import_items = 0;
		var progress_bar_interval;

		function ajax_callback(response) {
			var currentSpan = $current_node.find("label");
			if (typeof response == "object" && typeof response.message !== "undefined") {
				currentSpan.addClass(response.message.toLowerCase());

				if (typeof response.num_of_imported_posts !== "undefined" && 0 < total_content_import_items) {
					current_content_import_items = 'all' === response.num_of_imported_posts ? total_content_import_items : response.num_of_imported_posts;
					update_progress_bar();
				}

				if (typeof response.url !== "undefined") {
				// we have an ajax url action to perform.
					if (response.hash === current_item_hash) {
						currentSpan.addClass("status--failed");
						find_next();
					} else {
						current_item_hash = response.hash;

						// Fix the undefined selected_index issue on new AJAX calls.
						if (typeof response.selected_index === "undefined") {
							response.selected_index = $('.js-merlin-demo-import-select').val() || 0;
						}

						jQuery.post(response.url, response, ajax_callback).fail(ajax_callback); // recuurrssionnnnn
					}
				} else if (typeof response.done !== "undefined") {
					// finished processing this plugin, move onto next
					find_next();
				} else {
					// error processing this plugin
					find_next();
				}
			} else {
				console.log(response);
				// error - try again with next plugin
				currentSpan.addClass("status--error");
				find_next();
			}
		}

		function process_current() {
			if (current_item) {
				var $check = $current_node.find("input:checkbox");
				if ($check.is(":checked")) {
					jQuery.post(merlin_params.ajaxurl, {
						action: "merlin_content",
						wpnonce: merlin_params.wpnonce,
						content: current_item,
						selected_index: $('.js-merlin-demo-import-select').val() || 0
					}, ajax_callback).fail(ajax_callback);
				} else {
					$current_node.addClass("skipping");
					setTimeout(find_next, 300);
				}
			}
		}

		function find_next() {
			var do_next = false;
			if ($current_node) {
				if (!$current_node.data("done_item")) {
					items_completed++;
					$current_node.data("done_item", 1);
				}
				$current_node.find(".spinner").css("visibility", "hidden");
			}
			var $items = $(".merlin__drawer--import-content__list-item");
			var $enabled_items = $(".merlin__drawer--import-content__list-item input:checked");
			$items.each(function () {
				if (current_item == "" || do_next) {
					current_item = $(this).data("content");
					$current_node = $(this);
					process_current();
					do_next = false;
				} else if ($(this).data("content") == current_item) {
					do_next = true;
				}
			});
			if (items_completed >= $items.length) {
				complete();
			}
		}

		function init_content_import_progress_bar() {
			if (!$(".merlin__drawer--import-content__list-item .checkbox-content").is(':checked')) {
				return false;
			}

			jQuery.post(merlin_params.ajaxurl, {
				action: "merlin_get_total_content_import_items",
				wpnonce: merlin_params.wpnonce,
				selected_index: $('.js-merlin-demo-import-select').val() || 0
			}, function (response) {
				total_content_import_items = response.data;

				if (0 < total_content_import_items) {
					update_progress_bar();

					// Change the value of the progress bar constantly for a small amount (0,2% per sec), to improve UX.
					progress_bar_interval = setInterval(function () {
						current_content_import_items = current_content_import_items + total_content_import_items / 500;
						update_progress_bar();
					}, 1000);
				}
			});
		}

		function valBetween(v, min, max) {
			return (Math.min(max, Math.max(min, v)));
		}

		function update_progress_bar() {
			$('.js-merlin-progress-bar').css('width', (current_content_import_items / total_content_import_items) * 100 + '%');

			var $percentage = valBetween(((current_content_import_items / total_content_import_items) * 100), 0, 99);

			$('.js-merlin-progress-bar-percentage').html(sanitize(Math.round($percentage) + '%'));

			if (1 === current_content_import_items / total_content_import_items) {
				clearInterval(progress_bar_interval);
			}
		}

		return {
			init: function (btn) {
				$(".merlin__drawer--import-content").addClass("installing");
				$(".merlin__drawer--import-content").find("input").prop("disabled", true);
				complete = function () {

					$.post(merlin_params.ajaxurl, {
						action: "merlin_import_finished",
						wpnonce: merlin_params.wpnonce,
						selected_index: $('.js-merlin-demo-import-select').val() || 0
					});

					setTimeout(function () {
						$('.js-merlin-progress-bar-percentage').html('100%');
					}, 100);

					setTimeout(function () {
						body.removeClass(drawer_opened);
					}, 500);

					setTimeout(function () {
						$(".merlin__body").addClass('js--finished');
					}, 1500);

					setTimeout(function () {
						$('.merlin__body').addClass('exiting');
					}, 3400);

					setTimeout(function () {
						window.location.href = btn.href;
					}, 4000);
				};
				init_content_import_progress_bar();
				find_next();
			}
		}
	}

	function merlin_loading_button(btn) {

		var $button = jQuery(btn);

		if ($button.data("done-loading") == "yes") {
			return false;
		}

		var completed = false;

		var _modifier = $button.is("input") || $button.is("button") ? "val" : "text";

		$button.data("done-loading", "yes");

		$button.addClass("merlin__button--loading");

		return {
			done: function () {
				completed = true;
				$button.attr("disabled", false);
			}
		}

	}

	return {
		init: function () {
			t = this;
			$(window_loaded);
		},
		callback: function (func) {
			console.log(func);
			console.log(this);
		}
	}

})(jQuery);

Merlin.init();
