<?php

// Includes the files needed for the theme updater
if ( ! class_exists( 'Xpertpoint_Theme_Updater' ) ) {
	require_once XPERTPOINT_THEME_PATH . '/inc/classes/class-theme-updater.php';
}

// Loads the updater classes
new Xpertpoint_Theme_Updater(
	// Config settings
	array(
		'remote_api_url' => 'https://artemsemkin.com/wp-json/',
		'theme_slug'     => XPERTPOINT_THEME_SLUG, // Theme slug
		'version'        => XPERTPOINT_THEME_VERSION, // The current version of this theme
	),
	// Strings
	array(
		'theme-license'                                 => esc_html__( 'Theme License', 'fitso' ),
		'enter-key'                                     => esc_html__( 'Please enter your product purchase code.', 'fitso' ),
		'license-key'                                   => esc_html__( 'Purchase code', 'fitso' ),
		'license-action'                                => esc_html__( 'License Action', 'fitso' ),
		'deactivate-license'                            => esc_html__( 'Deactivate License', 'fitso' ),
		'activate-license'                              => esc_html__( 'Activate License', 'fitso' ),
		'refresh-license'                               => esc_html__( 'Refresh', 'fitso' ),
		'status-unknown'                                => esc_html__( 'License status is unknown.', 'fitso' ),
		'renew'                                         => esc_html__( 'Renew?', 'fitso' ),
		'unlimited'                                     => esc_html__( 'unlimited', 'fitso' ),
		'license-key-is-active'                         => esc_html__( 'License key is active', 'fitso' ),
		'license-key-activated'                         => esc_html__( 'Activated', 'fitso' ),
		/* translators: the license expiration date */
		'expires%s'                                     => esc_html__( 'Expires %s.', 'fitso' ),
		'expires-never'                                 => esc_html__( 'Never', 'fitso' ),
		/* translators: 1. the number of sites activated 2. the total number of activations allowed. */
		'%1$s/%2$-sites'                                => esc_html__( 'You have %1$s / %2$s sites activated.', 'fitso' ),
		'activation-limit'                              => esc_html__( 'Your license key has reached its activation limit.', 'fitso' ),
		/* translators: the license expiration date */
		'license-key-expired-%s'                        => esc_html__( 'License key expired %s.', 'fitso' ),
		'license-key-expired'                           => esc_html__( 'License key has expired.', 'fitso' ),
		/* translators: the license expiration date */
		'license-expired-on'                            => esc_html__( 'Your license key expired on %s.', 'fitso' ),
		'license-keys-do-not-match'                     => esc_html__( 'License keys do not match.', 'fitso' ),
		'license-is-inactive'                           => esc_html__( 'Not activated', 'fitso' ),
		'license-key-is-disabled'                       => esc_html__( 'License key is disabled.', 'fitso' ),
		'license-key-invalid'                           => esc_html__( 'Invalid license.', 'fitso' ),
		'site-is-inactive'                              => esc_html__( 'Site is inactive.', 'fitso' ),
		/* translators: the theme name */
		'item-mismatch'                                 => esc_html__( 'This appears to be an invalid license key for %s.', 'fitso' ),
		'license-status-unknown'                        => esc_html__( 'License status is unknown.', 'fitso' ),
		'update-notice'                                 => esc_html__( "Updating this theme will lose any customizations you have made. 'Cancel' to stop, 'OK' to update.", 'fitso' ),
		'error-generic'                                 => esc_html__( 'An error occurred while validating this license key. Please try again later.', 'fitso' ),
		'license-status'                                => esc_html__( 'Status', 'fitso' ),
		'license-expiration-date'                       => esc_html__( 'Expiration Date', 'fitso' ),
		'license-data-refreshed'                        => esc_html__( 'License data refreshed successfully.', 'fitso' ),
		'license-supported-until'                       => esc_html__( 'Technical Support', 'fitso' ),
		'license-updates-provided-until'                => esc_html__( 'Automatic Updates', 'fitso' ),
		'license-lifetime-updates'                      => esc_html__( 'Available Lifetime', 'fitso' ),
		'license-never-expires'                         => esc_html__( 'Lifetime', 'fitso' ),
		'license-purchase-date'                         => esc_html__( 'Purchase Date', 'fitso' ),
		'license-activations'                           => esc_html__( 'Activations', 'fitso' ),
		'license-help-purchase-code'                    => esc_html__( 'Where is my purchase code?', 'fitso' ),
		'license-help-purchase-code-url'                => esc_url( 'https://help.market.envato.com/hc/en-us/articles/202822600-Where-Is-My-Purchase-Code-' ),
		'license-help-no-purchase-code-heading'         => esc_html__( 'Don\'t have a purchase code?', 'fitso' ),
		'license-help-no-purchase-code-text'            => esc_html__( 'Get one today from %1$s!', 'fitso' ),
		'license-help-no-purchase-code-link'            => esc_html__( 'Envato Market', 'fitso' ),
		'license-help-no-purchase-code-benefits-before' => esc_html__( 'Every license holder gets', 'fitso' ),
		'license-help-no-purchase-code-benefit-1'       => esc_html__( '6 month of personalized technical support', 'fitso' ),
		'license-help-no-purchase-code-benefit-2'       => esc_html__( 'Availability of the theme author to answer questions', 'fitso' ),
		'license-help-no-purchase-code-benefit-3'       => esc_html__( 'Help with reported bugs and issues', 'fitso' ),
		'license-help-no-purchase-code-benefit-4'       => esc_html__( 'Lifetime automatic theme updates', 'fitso' ),
		'license-help-no-purchase-code-benefit-5'       => esc_html__( 'Lifetime automatic core plugin updates', 'fitso' ),
		'license-local-info'                            => esc_html__( 'Local or staging installations don\'t count towards the license activation limit.', 'fitso' ),
		'support-forum-url'                             => esc_url( 'https://artemsemkin.ticksy.com/' ),
		'support-forum-link'                            => esc_html__( 'View Support Forum', 'fitso' ),
		'support-supported-until'                       => esc_html__( 'Supported until', 'fitso' ),
		'support-expired'                               => esc_html__( 'Expired on', 'fitso' ),
		'item-page-url'                                 => esc_url( 'https://themeforest.net/item/fitso-ajax-creative-portfolio-wordpress-theme/23887784?aid=artemsemkin&aso=buyer_admin_panel&aca=theme_license_page' ),
		'item-checkout-url'                             => esc_url( 'https://themeforest.net/checkout/from_item/23887784?license=regular&support=bundle_6month&aid=artemsemkin&aso=buyer_admin_panel&aca=theme_license_page' ),
		'item-checkout-link'                            => esc_html__( 'Buy Now', 'fitso' ),
		'item-page-link'                                => esc_html__( 'View Pricing & Details', 'fitso' ),
		'date-unknown'                                  => esc_html__( 'Unknown', 'fitso' ),
		'license-cta-heading'                           => esc_html__( 'Action Required', 'fitso' ),
		'license-cta-message-1'                         => esc_html__( 'Thank you for using Fitso theme!', 'fitso' ),
		'license-cta-message-2'                         => esc_html__( 'To enable remote updates, please activate your', 'fitso' ),
		'license-cta-message-3'                         => esc_html__( 'Theme License', 'fitso' ),
		'license-cta-message-4'                         => esc_html__( 'with a purchase code.', 'fitso' ),
		'license-cta-link-text'                         => esc_html__( 'View More', 'fitso' ),
	)
);
