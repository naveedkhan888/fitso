<?php

/**
 * Merlin WP configuration file
 */

$wizard      = new Merlin(
	$config  = array(
		'directory'            => 'inc/merlin', // Location / directory where Merlin WP is placed in your theme.
		'merlin_url'           => 'merlin', // The wp-admin page slug where Merlin WP loads.
		'parent_slug'          => 'themes.php', // The wp-admin parent page slug for the admin menu item.
		'capability'           => 'manage_options', // The capability required for this menu to be displayed to the user.
		'child_action_btn_url' => 'https://codex.wordpress.org/child_themes', // URL for the 'child-action-link'.
		'dev_mode'             => true, // Enable development mode for testing.
		'license_step'         => true, // EDD license activation step.
		'license_required'     => false, // Require the license activation step.
		'license_help_url'     => 'https://help.market.envato.com/hc/en-us/articles/202822600-Where-Is-My-Purchase-Code', // URL for the 'license-tooltip'.
		'edd_remote_api_url'   => 'https://artemsemkin.com/wp-json/edd/v1/activate/' . ARTS_THEME_SLUG . '/theme', // EDD_Theme_Updater_Admin remote_api_url.
		'edd_item_name'        => '', // EDD_Theme_Updater_Admin item_name.
		'edd_theme_slug'       => ARTS_THEME_SLUG, // EDD_Theme_Updater_Admin item_slug.
		'ready_big_button_url' => '', // Link for the big button on the ready step.
	),
	$strings = array(
		'admin-menu'               => esc_html__( 'Theme Setup', 'fitso' ),
		/* translators: 1: Title Tag 2: Theme Name 3: Closing Title Tag */
		'title%s%s%s%s'            => esc_html__( '%1$s%2$s Themes &lsaquo; Theme Setup: %3$s%4$s', 'fitso' ),
		'return-to-dashboard'      => esc_html__( 'Return to the dashboard', 'fitso' ),
		'ignore'                   => esc_html__( 'Disable this wizard', 'fitso' ),
		'btn-skip'                 => esc_html__( 'Skip', 'fitso' ),
		'btn-next'                 => esc_html__( 'Next', 'fitso' ),
		'btn-start'                => esc_html__( 'Start', 'fitso' ),
		'btn-no'                   => esc_html__( 'Cancel', 'fitso' ),
		'btn-plugins-install'      => esc_html__( 'Install', 'fitso' ),
		'btn-child-install'        => esc_html__( 'Install', 'fitso' ),
		'btn-content-install'      => esc_html__( 'Install', 'fitso' ),
		'btn-import'               => esc_html__( 'Import', 'fitso' ),
		'btn-license-activate'     => esc_html__( 'Activate', 'fitso' ),
		'btn-license-skip'         => esc_html__( 'Skip', 'fitso' ),
		/* translators: Theme Name */
		'license-header%s'         => esc_html__( 'Activate %s', 'fitso' ),
		/* translators: Theme Name */
		'license-header-success%s' => esc_html__( '%s is Activated', 'fitso' ),
		/* translators: Theme Name */
		'license%s'                => esc_html__( 'Enter your license key to enable remote updates and theme support.', 'fitso' ),
		'license-label'            => esc_html__( 'License key', 'fitso' ),
		'license-success%s'        => esc_html__( 'The theme is already registered, so you can go to the next step!', 'fitso' ),
		'license-json-success%s'   => esc_html__( 'Your theme is activated! Remote updates and theme support are enabled.', 'fitso' ),
		'license-tooltip'          => esc_html__( 'Need help?', 'fitso' ),
		/* translators: Theme Name */
		'welcome-header%s'         => esc_html__( 'Welcome to %s', 'fitso' ),
		'welcome-header-success%s' => esc_html__( 'Hi. Welcome back', 'fitso' ),
		'welcome%s'                => esc_html__( 'This wizard will set up your theme, install plugins, and import content. It is optional & should take only a few minutes.', 'fitso' ),
		'welcome-success%s'        => esc_html__( 'You may have already run this theme setup wizard. If you would like to proceed anyway, click on the "Start" button below.', 'fitso' ),
		'child-header'             => esc_html__( 'Install Child Theme', 'fitso' ),
		'child-header-success'     => esc_html__( 'You\'re good to go!', 'fitso' ),
		'child'                    => esc_html__( 'Let\'s build & activate a child theme so you may easily make theme changes.', 'fitso' ),
		'child-success%s'          => esc_html__( 'Your child theme has already been installed and is now activated, if it wasn\'t already.', 'fitso' ),
		'child-action-link'        => esc_html__( 'Learn about child themes', 'fitso' ),
		'child-json-success%s'     => esc_html__( 'Awesome. Your child theme has already been installed and is now activated.', 'fitso' ),
		'child-json-already%s'     => esc_html__( 'Awesome. Your child theme has been created and is now activated.', 'fitso' ),
		'plugins-header'           => esc_html__( 'Install Plugins', 'fitso' ),
		'plugins-header-success'   => esc_html__( 'You\'re up to speed!', 'fitso' ),
		'plugins'                  => esc_html__( 'Let\'s install some essential WordPress plugins to get your site up to speed.', 'fitso' ),
		'plugins-success%s'        => esc_html__( 'The required WordPress plugins are all installed and up to date. Press "Next" to continue the setup wizard.', 'fitso' ),
		'plugins-action-link'      => esc_html__( 'Advanced', 'fitso' ),
		'import-header'            => esc_html__( 'Import Content', 'fitso' ),
		'import'                   => esc_html__( 'Let\'s import content to your website, to help you get familiar with the theme.', 'fitso' ),
		'import-action-link'       => esc_html__( 'Advanced', 'fitso' ),
		'ready-header'             => esc_html__( 'All done. Have fun!', 'fitso' ),
		/* translators: Theme Author */
		'ready%s'                  => esc_html__( 'Your theme has been all set up. Enjoy your new theme by %s.', 'fitso' ),
		'ready-action-link'        => esc_html__( 'Extras', 'fitso' ),
		'ready-big-button'         => esc_html__( 'View your website', 'fitso' ),
		'ready-link-1'             => sprintf( '<a href="%1$s" target="_blank">%2$s</a>', 'https://wordpress.org/support/', esc_html__( 'Explore WordPress', 'fitso' ) ),
		'ready-link-2'             => sprintf( '<a href="%1$s" target="_blank">%2$s</a>', 'https://themeforest.net/user/artemsemkin', esc_html__( 'Get Theme Support', 'fitso' ) ),
		'ready-link-3'             => sprintf( '<a href="%1$s">%2$s</a>', admin_url( 'customize.php' ), esc_html__( 'Start Customizing', 'fitso' ) ),
	)
);

if ( isset( $_GET['page'] ) && $_GET['page'] === $config['merlin_url'] ) {
	/**
	 * Remove all "admin_footer" actions with priority 10.
	 */
	remove_all_actions( 'admin_footer', 10 );

	/**
	 * Restore SVG Sprite.
	 */
	add_action( 'admin_footer', array( $wizard, 'svg_sprite' ) );
}
