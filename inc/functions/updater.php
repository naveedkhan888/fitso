<?php

// Includes the files needed for the theme updater
if ( ! class_exists( 'Arts_Theme_Updater' ) ) {
	require_once ARTS_THEME_PATH . '/inc/classes/class-theme-updater.php';
}

// Loads the updater classes
new Arts_Theme_Updater(
	// Config settings
	array(
		'remote_api_url' => 'https://artemsemkin.com/wp-json/',
		'theme_slug'     => ARTS_THEME_SLUG, // Theme slug
		'version'        => ARTS_THEME_VERSION, // The current version of this theme
	),
	// Strings
	array(
		'theme-license'                                 => esc_html__( 'Theme License', 'rubenz' ),
		'enter-key'                                     => esc_html__( 'Please enter your product purchase code.', 'rubenz' ),
		'license-key'                                   => esc_html__( 'Purchase code', 'rubenz' ),
		'license-action'                                => esc_html__( 'License Action', 'rubenz' ),
		'deactivate-license'                            => esc_html__( 'Deactivate License', 'rubenz' ),
		'activate-license'                              => esc_html__( 'Activate License', 'rubenz' ),
		'refresh-license'                               => esc_html__( 'Refresh', 'rubenz' ),
		'status-unknown'                                => esc_html__( 'License status is unknown.', 'rubenz' ),
		'renew'                                         => esc_html__( 'Renew?', 'rubenz' ),
		'unlimited'                                     => esc_html__( 'unlimited', 'rubenz' ),
		'license-key-is-active'                         => esc_html__( 'License key is active', 'rubenz' ),
		'license-key-activated'                         => esc_html__( 'Activated', 'rubenz' ),
		/* translators: the license expiration date */
		'expires%s'                                     => esc_html__( 'Expires %s.', 'rubenz' ),
		'expires-never'                                 => esc_html__( 'Never', 'rubenz' ),
		/* translators: 1. the number of sites activated 2. the total number of activations allowed. */
		'%1$s/%2$-sites'                                => esc_html__( 'You have %1$s / %2$s sites activated.', 'rubenz' ),
		'activation-limit'                              => esc_html__( 'Your license key has reached its activation limit.', 'rubenz' ),
		/* translators: the license expiration date */
		'license-key-expired-%s'                        => esc_html__( 'License key expired %s.', 'rubenz' ),
		'license-key-expired'                           => esc_html__( 'License key has expired.', 'rubenz' ),
		/* translators: the license expiration date */
		'license-expired-on'                            => esc_html__( 'Your license key expired on %s.', 'rubenz' ),
		'license-keys-do-not-match'                     => esc_html__( 'License keys do not match.', 'rubenz' ),
		'license-is-inactive'                           => esc_html__( 'Not activated', 'rubenz' ),
		'license-key-is-disabled'                       => esc_html__( 'License key is disabled.', 'rubenz' ),
		'license-key-invalid'                           => esc_html__( 'Invalid license.', 'rubenz' ),
		'site-is-inactive'                              => esc_html__( 'Site is inactive.', 'rubenz' ),
		/* translators: the theme name */
		'item-mismatch'                                 => esc_html__( 'This appears to be an invalid license key for %s.', 'rubenz' ),
		'license-status-unknown'                        => esc_html__( 'License status is unknown.', 'rubenz' ),
		'update-notice'                                 => esc_html__( "Updating this theme will lose any customizations you have made. 'Cancel' to stop, 'OK' to update.", 'rubenz' ),
		'error-generic'                                 => esc_html__( 'An error occurred while validating this license key. Please try again later.', 'rubenz' ),
		'license-status'                                => esc_html__( 'Status', 'rubenz' ),
		'license-expiration-date'                       => esc_html__( 'Expiration Date', 'rubenz' ),
		'license-data-refreshed'                        => esc_html__( 'License data refreshed successfully.', 'rubenz' ),
		'license-supported-until'                       => esc_html__( 'Technical Support', 'rubenz' ),
		'license-updates-provided-until'                => esc_html__( 'Automatic Updates', 'rubenz' ),
		'license-lifetime-updates'                      => esc_html__( 'Available Lifetime', 'rubenz' ),
		'license-never-expires'                         => esc_html__( 'Lifetime', 'rubenz' ),
		'license-purchase-date'                         => esc_html__( 'Purchase Date', 'rubenz' ),
		'license-activations'                           => esc_html__( 'Activations', 'rubenz' ),
		'license-help-purchase-code'                    => esc_html__( 'Where is my purchase code?', 'rubenz' ),
		'license-help-purchase-code-url'                => esc_url( 'https://help.market.envato.com/hc/en-us/articles/202822600-Where-Is-My-Purchase-Code-' ),
		'license-help-no-purchase-code-heading'         => esc_html__( 'Don\'t have a purchase code?', 'rubenz' ),
		'license-help-no-purchase-code-text'            => esc_html__( 'Get one today from %1$s!', 'rubenz' ),
		'license-help-no-purchase-code-link'            => esc_html__( 'Envato Market', 'rubenz' ),
		'license-help-no-purchase-code-benefits-before' => esc_html__( 'Every license holder gets', 'rubenz' ),
		'license-help-no-purchase-code-benefit-1'       => esc_html__( '6 month of personalized technical support', 'rubenz' ),
		'license-help-no-purchase-code-benefit-2'       => esc_html__( 'Availability of the theme author to answer questions', 'rubenz' ),
		'license-help-no-purchase-code-benefit-3'       => esc_html__( 'Help with reported bugs and issues', 'rubenz' ),
		'license-help-no-purchase-code-benefit-4'       => esc_html__( 'Lifetime automatic theme updates', 'rubenz' ),
		'license-help-no-purchase-code-benefit-5'       => esc_html__( 'Lifetime automatic core plugin updates', 'rubenz' ),
		'license-local-info'                            => esc_html__( 'Local or staging installations don\'t count towards the license activation limit.', 'rubenz' ),
		'support-forum-url'                             => esc_url( 'https://artemsemkin.ticksy.com/' ),
		'support-forum-link'                            => esc_html__( 'View Support Forum', 'rubenz' ),
		'support-supported-until'                       => esc_html__( 'Supported until', 'rubenz' ),
		'support-expired'                               => esc_html__( 'Expired on', 'rubenz' ),
		'item-page-url'                                 => esc_url( 'https://themeforest.net/item/rubenz-ajax-creative-portfolio-wordpress-theme/23887784?aid=artemsemkin&aso=buyer_admin_panel&aca=theme_license_page' ),
		'item-checkout-url'                             => esc_url( 'https://themeforest.net/checkout/from_item/23887784?license=regular&support=bundle_6month&aid=artemsemkin&aso=buyer_admin_panel&aca=theme_license_page' ),
		'item-checkout-link'                            => esc_html__( 'Buy Now', 'rubenz' ),
		'item-page-link'                                => esc_html__( 'View Pricing & Details', 'rubenz' ),
		'date-unknown'                                  => esc_html__( 'Unknown', 'rubenz' ),
		'license-cta-heading'                           => esc_html__( 'Action Required', 'rubenz' ),
		'license-cta-message-1'                         => esc_html__( 'Thank you for using Rubenz theme!', 'rubenz' ),
		'license-cta-message-2'                         => esc_html__( 'To enable remote updates, please activate your', 'rubenz' ),
		'license-cta-message-3'                         => esc_html__( 'Theme License', 'rubenz' ),
		'license-cta-message-4'                         => esc_html__( 'with a purchase code.', 'rubenz' ),
		'license-cta-link-text'                         => esc_html__( 'View More', 'rubenz' ),
	)
);
