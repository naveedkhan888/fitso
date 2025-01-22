<?php

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

if ( class_exists( 'Arts_Theme_Updater' ) ) {
	return;
}

class Arts_Theme_Updater {
	private $strings        = array();
	private $remote_api_url = null;
	private $theme_slug     = null;
	private $version        = null;
	private $response_key   = null;
	private $date_format;

	/**
	 * Initialize the class.
	 *
	 * @since 1.0.0
	 */
	public function __construct( $args = array(), $strings = array() ) {
		$defaults = array(
			'remote_api_url' => '',
			'theme_slug'     => '',
			'license'        => '',
			'version'        => '',
		);

		$args = wp_parse_args( $args, $defaults );

		$this->remote_api_url = esc_url( $args['remote_api_url'] );
		$this->theme_slug     = esc_attr( $args['theme_slug'] );
		$this->version        = esc_attr( $args['version'] );
		$this->response_key   = esc_attr( $this->theme_slug . '-update-response' );
		$this->strings        = $strings;
		$this->date_format    = get_option( 'date_format' );

		add_filter( 'pre_set_site_transient_update_themes', array( $this, 'modify_theme_update_transient' ) );
		add_filter( 'delete_site_transient_update_themes', array( $this, 'delete_theme_update_transient' ) );
		add_action( 'load-update-core.php', array( $this, 'delete_theme_update_transient' ) );
		add_action( 'upgrader_process_complete', array( $this, 'clear_theme_update_data' ), 999 );

		add_action( 'admin_init', array( $this, 'register_option' ) );
		add_action( 'admin_init', array( $this, 'register_license_actions' ) );
		add_action( 'admin_menu', array( $this, 'add_theme_license_menu' ) );
		add_action( 'admin_init', array( $this, 'add_license_activation_notice' ) );
		add_action( 'admin_init', array( $this, 'add_license_invalid_notice' ) );

		add_action( 'update_option_' . $this->theme_slug . '_license_key_status', array( $this, 'clear_theme_update_data' ), 10, 2 );
		add_action( 'update_option_' . $this->theme_slug . '_license_key', array( $this, 'activate_license_ajax' ), 10, 2 );
	}

	private function is_theme_license_page() {
		global $pagenow;

		return $pagenow === 'themes.php' && ( isset( $_GET['page'] ) && $_GET['page'] === $this->theme_slug . '-license' );
	}

	public function add_license_invalid_notice() {
		// Don't display the notice on the license activation page.
		if ( $this->is_theme_license_page() ) {
			return;
		}

		$license = trim( get_option( $this->theme_slug . '_license_key' ) );
		$status  = get_option( $this->theme_slug . '_license_key_status', false );
		$strings = $this->strings;

		if ( ! $license || $status !== 'valid' ) {
			$url = admin_url( 'themes.php?page=' . $this->theme_slug . '-license' );

			$args = array(
				'title'          => $strings['license-cta-heading'],
				'message'        => sprintf(
					'%1$s %2$s <a href="%3$s">%4$s</a> %5$s',
					$strings['license-cta-message-1'],
					$strings['license-cta-message-2'],
					$url,
					$strings['license-cta-message-3'],
					$strings['license-cta-message-4'],
				),
				'link'           => array(
					'class' => 'button button-primary',
					'text'  => $strings['license-cta-link-text'],
					'url'   => admin_url( 'themes.php?page=' . $this->theme_slug . '-license' ),
				),
				'dismiss_option' => $url,
				'notice_id'      => 'invalid_license',
			);
			\Arts_Admin_Notice_Manager::instance()->warning( $args );
		}
	}

	public function add_license_activation_notice() {
		if ( $this->is_theme_license_page() && isset( $_GET['success'] ) && ! empty( $_GET['message'] ) ) {
			$args = array(
				'message'        => urldecode( $_GET['message'] ),
				'dismiss_option' => false,
			);

			switch ( $_GET['success'] ) {
				case 'yes':
					$args['notice_id'] = 'success_license';
					\Arts_Admin_Notice_Manager::instance()->success( $args );
					break;
				case 'no':
					$args['notice_id'] = 'error_license';
					\Arts_Admin_Notice_Manager::instance()->error( $args );
					break;
				default:
					$args['notice_id'] = 'warning_license';
					\Arts_Admin_Notice_Manager::instance()->warning( $args );
					break;
			}
		}
	}

	public function clear_theme_update_data() {
		wp_clean_themes_cache( true );
	}

	public function modify_theme_update_transient( $transient ) {
		$theme_remote_update_data = get_transient( $this->response_key );

		if ( ! $theme_remote_update_data ) {
			$theme_remote_update_data = $this->fetch_remote_theme_data();
			set_transient( $this->response_key, $theme_remote_update_data, DAY_IN_SECONDS );
		}

		if ( $theme_remote_update_data && version_compare( $this->version, isset( $theme_remote_update_data->version ) ? $theme_remote_update_data->version : '', '<' ) ) {
			$transient->response[ $this->theme_slug ] = array(
				'theme'       => $this->theme_slug,
				'new_version' => esc_html( $theme_remote_update_data->version ),
				'package'     => esc_url( $theme_remote_update_data->download_url ),
				'url'         => esc_url( $theme_remote_update_data->url ),
			);
		} else {
			// No update is available.
			$item = array(
				'theme'        => $this->theme_slug,
				'new_version'  => $this->version,
				'url'          => '',
				'package'      => '',
				'requires'     => '',
				'requires_php' => '',
			);
			// Adding the "mock" item to the `no_update` property is required
			// for the enable/disable auto-updates links to correctly appear in UI.
			$transient->no_update[ $this->theme_slug ] = $item;
		}

		return $transient;
	}

	public function delete_theme_update_transient() {
		delete_transient( $this->response_key );
	}

	public function get_theme_update( $update, $theme_data, $theme_stylesheet, $locales ) {
		if ( $theme_stylesheet !== $this->theme_slug || ! empty( $update ) ) {
			return $update;
		}

		$remote_theme_data = $this->fetch_remote_theme_data();

		if ( ! version_compare( $this->version, isset( $remote_theme_data->version ) ? $remote_theme_data->version : '', '<' ) ) {
			return $update;
		}

		$remote_theme_data->new_version = $remote_theme_data->version;
		$remote_theme_data->package     = $remote_theme_data->download_url;

		return $remote_theme_data;
	}

	public function set_remote_theme_data( $override, $action, $args ) {
		if ( $action !== 'theme_information' || empty( $args->slug ) || $args->slug !== $this->theme_slug ) {
			return $override;
		}

		$remote_theme_data = $this->fetch_remote_theme_data();

		if ( ! $remote_theme_data ) {
			return $override;
		}

		$res                 = new stdClass();
		$res->name           = $remote_theme_data->name;
		$res->slug           = $remote_theme_data->slug;
		$res->version        = $remote_theme_data->version;
		$res->tested         = $remote_theme_data->tested;
		$res->requires       = $remote_theme_data->requires;
		$res->author         = $remote_theme_data->author;
		$res->author_profile = $remote_theme_data->author_profile;
		$res->donate_link    = $remote_theme_data->donate_link;
		$res->homepage       = $remote_theme_data->homepage;
		$res->download_link  = $remote_theme_data->download_url;
		$res->trunk          = $remote_theme_data->download_url;
		$res->requires_php   = $remote_theme_data->requires_php;
		$res->last_updated   = $remote_theme_data->last_updated;
		$res->sections       = $remote_theme_data->sections;
		$res->rating         = $remote_theme_data->rating;
		$res->num_ratings    = $remote_theme_data->num_ratings;

		if ( ! empty( $remote_theme_data->banners ) ) {
			$res->banners = $remote_theme_data->banners;
		}

		return $res;
	}

	public function add_theme_license_menu() {
		$strings = $this->strings;

		add_theme_page(
			$strings['theme-license'],
			$strings['theme-license'],
			'manage_options',
			$this->theme_slug . '-license',
			array( $this, 'add_theme_license_page' )
		);
	}

	public function add_theme_license_page() {
		$strings = $this->strings;

		$license          = trim( get_option( $this->theme_slug . '_license_key' ) );
		$status           = get_option( $this->theme_slug . '_license_key_status', false );
		$is_valid_license = $license && $status === 'valid';
		?>
		<div class="wrap">
			<h1 class="wp-heading-inline"><?php echo esc_html( $strings['theme-license'] ); ?></h1>
			<hr class="wp-header-end">
			<form method="post" action="options.php">
				<?php wp_nonce_field( $this->theme_slug . '_nonce', $this->theme_slug . '_nonce' ); ?>
				<?php settings_fields( $this->theme_slug . '-license' ); ?>
				<table class="form-table">
					<tbody>
						<?php $this->render_license_row( $license, $is_valid_license ); ?>
						<?php if ( $is_valid_license ) : ?>
							<?php $this->render_expiration_row(); ?>
							<?php $this->render_activation_row(); ?>
							<?php $this->render_purchase_date_row(); ?>
							<?php $this->render_updates_row(); ?>
							<?php $this->render_support_row(); ?>
						<?php endif; ?>
					</tbody>
				</table>
				<?php if ( ! $license ) : ?>
					<?php $this->render_license_cta(); ?>
				<?php endif; ?>
			</form>
		</div>
		<?php
	}

	private function render_license_cta() {
		$strings = $this->strings;

		?>
		<div class="card">
			<h2><?php echo esc_html( $strings['license-help-no-purchase-code-heading'] ); ?></h2>
			<p><?php echo sprintf( $strings['license-help-no-purchase-code-text'], wp_kses_post( '<a href="' . esc_url( $strings['item-checkout-url'] ) . '" target="_blank" rel="nofollow">' . esc_html( $strings['license-help-no-purchase-code-link'] ) . '</a>' ) ); ?> <?php echo esc_html( $strings['license-help-no-purchase-code-benefits-before'] ); ?>:</p>
			<ul class="ul-disc">
				<li><?php echo esc_html( $strings['license-help-no-purchase-code-benefit-1'] ); ?></li>
				<li><?php echo esc_html( $strings['license-help-no-purchase-code-benefit-2'] ); ?></li>
				<li><?php echo esc_html( $strings['license-help-no-purchase-code-benefit-3'] ); ?></li>
				<li><?php echo esc_html( $strings['license-help-no-purchase-code-benefit-4'] ); ?></li>
				<li><?php echo esc_html( $strings['license-help-no-purchase-code-benefit-5'] ); ?></li>
			</ul>
			<p>
				<a class="button button-primary" href="<?php echo esc_url( $strings['item-checkout-url'] ); ?>" target="_blank"><?php echo esc_html( $strings['item-checkout-link'] ); ?></a>
				<a class="button button-secondary" href="<?php echo esc_url( $strings['item-page-url'] ); ?>" target="_blank"><?php echo esc_html( $strings['item-page-link'] ); ?></a>
			</p>
		</div>
		<?php
	}

	private function render_license_row( $license, $is_valid_license ) {
		$strings = $this->strings;

		// Checks license status to display under license key
		if ( ! $license ) {
			$message = $strings['enter-key'];
		} else {
			$message = $strings['license-key-activated'];
		}
		?>
		<tr valign="top">
			<th class="row-title"><?php echo esc_html( $strings['license-key'] ); ?></th>
			<td>
				<?php if ( $is_valid_license ) : ?>
					<div class="card" style="margin-top: 0;">
				<?php endif; ?>
					<?php if ( $is_valid_license ) : ?>
						<h2 class="title"><?php echo esc_html( $license ); ?></h2>
						<p class="description" style="color: #46B450"><?php echo esc_html( $message ); ?></p>
						<br>
					<?php else : ?>
						<input id="<?php echo esc_attr( $this->theme_slug . '_license_key' ); ?>" name="<?php echo esc_attr( $this->theme_slug . '_license_key' ); ?>" type="text" class="regular-text" value="<?php echo esc_attr( $license ); ?>" autocomplete="off" autocorrect="off" autocapitalize="off" spellcheck="false" maxlength="36" placeholder="xxxxxxxx-xxxx-xxxx-xxxx-xxxxxxxxxxxx" pattern="[0-9a-zA-Z]{8}-[0-9a-zA-Z]{4}-[0-9a-zA-F]{4}-[0-9a-zA-Z]{4}-[0-9a-zA-Z]{12}" required title="Purchase code format: xxxxxxxx-xxxx-xxxx-xxxx-xxxxxxxxxxxx"/>
						<p class="description">
							<a href="<?php echo esc_html( $strings['license-help-purchase-code-url'] ); ?>" target="_blank"><?php echo esc_html( $strings['license-help-purchase-code'] ); ?></a>
						</p>
						<br>
					<?php endif; ?>
					<?php if ( $license ) : ?>
						<?php if ( $is_valid_license ) : ?>
							<input type="submit" class="button button-primary" name="<?php echo esc_attr( $this->theme_slug . '_license_deactivate' ); ?>" value="<?php echo esc_attr( $strings['deactivate-license'] ); ?>"/>
							<input type="submit" class="button button-secondary right" name="<?php echo esc_attr( $this->theme_slug . '_license_refresh' ); ?>" value="<?php echo esc_attr( $strings['refresh-license'] ); ?>"/>
						<?php else : ?>
							<input type="submit" class="button button-primary" name="<?php echo esc_attr( $this->theme_slug . '_license_activate' ); ?>" value="<?php echo esc_attr( $strings['activate-license'] ); ?>"/>
						<?php endif; ?>
					<?php else : ?>
						<input type="submit" class="button button-primary" name="<?php echo esc_attr( $this->theme_slug . '_license_activate' ); ?>" value="<?php echo esc_attr( $strings['activate-license'] ); ?>"/>
					<?php endif; ?>
				<?php if ( $is_valid_license ) : ?>
					</div>
				<?php endif; ?>
			</td>
		</tr>
		<?php
	}

	private function render_expiration_row() {
		$strings = $this->strings;

		$license_expires = get_option( $this->theme_slug . '_license_expires' );
		if ( strtolower( $license_expires ) === 'lifetime' ) {
			$license_expiration_date = $strings['expires-never'];
		} else {
			$license_expiration_date = $license_expires ? date( $this->date_format, strtotime( $license_expires ) ) : false;
		}
		?>
		<tr valign="top">
			<th class="row-title"><?php echo esc_html( $strings['license-expiration-date'] ); ?></th>
			<td><?php echo esc_html( $license_expiration_date ); ?></td>
		</tr>
		<?php
	}

	private function render_activation_row() {
		$strings = $this->strings;

		$activated_sites  = get_option( $this->theme_slug . '_license_site_count' );
		$activation_limit = get_option( $this->theme_slug . '_license_limit' );
		$is_local         = get_option( $this->theme_slug . '_license_is_local' );
		?>
		<tr valign="top">
			<th class="row-title"><?php echo esc_html( $strings['license-activations'] ); ?></th>
			<td>
				<strong><?php echo esc_html( sprintf( '%1$s / %2$s', $activated_sites, $activation_limit ) ); ?></strong>
				<?php if ( $is_local ) : ?>
					<p class="description"><em><?php echo esc_html( $strings['license-local-info'] ); ?></em></p>
				<?php endif; ?>
			</td>
		</tr>
		<?php
	}

	private function render_purchase_date_row() {
		$strings = $this->strings;

		$date_purchased = get_option( $this->theme_slug . '_license_date_purchased' );
		$purchase_date  = $date_purchased ? date( $this->date_format, strtotime( $date_purchased ) ) : $strings['date-unknown'];

		?>
		<tr valign="top">
			<th class="row-title"><?php echo esc_html( $strings['license-purchase-date'] ); ?></th>
			<td><?php echo esc_html( $purchase_date ); ?></td>
		</tr>
		<?php
	}

	private function render_updates_row() {
		$strings = $this->strings;

		$updates_provided_until = get_option( $this->theme_slug . '_license_date_updates_provided_until' );
		if ( strtolower( $updates_provided_until ) === 'lifetime' ) {
			$updates_provided_until_date = $strings['license-lifetime-updates'];
		} else {
			$updates_provided_until_date = $updates_provided_until ? date( $this->date_format, strtotime( $updates_provided_until ) ) : $strings['date-unknown'];
		}

		?>
		<tr valign="top">
			<th class="row-title"><?php echo esc_html( $strings['license-updates-provided-until'] ); ?></th>
			<td><?php echo esc_html( $updates_provided_until_date ); ?></td>
		</tr>
		<?php
	}

	private function render_support_row() {
		$strings = $this->strings;

		$support_provided_until      = get_option( $this->theme_slug . '_license_date_supported_until' );
		$support_provided_until_date = $support_provided_until ? date( $this->date_format, strtotime( $support_provided_until ) ) : $strings['date-unknown'];

		$current_date        = date( 'Y-m-d' );
		$is_support_provided = ( strtotime( $support_provided_until ) >= strtotime( $current_date ) ) ? true : false;
		?>
		<?php if ( $is_support_provided ) : ?>
			<?php $this->render_support_active_row( $support_provided_until_date ); ?>
		<?php else : ?>
			<?php $this->render_support_expired_row( $support_provided_until_date ); ?>
		<?php endif; ?>
		<?php
	}

	private function render_support_expired_row( $support_provided_until_date ) {
		$strings = $this->strings;

		$support_provided_until = get_option( $this->theme_slug . '_license_date_supported_until' );
		?>
		<tr valign="top">
			<th class="row-title"><?php echo esc_html( $strings['license-supported-until'] ); ?></th>
			<td>
				<span style="color: #F56E28">
				<?php
				if ( $support_provided_until ) :
					?>
					<?php echo esc_html( $strings['support-expired'] ); ?> <?php endif; ?><?php echo esc_html( $support_provided_until_date ); ?></span>
				<p>
					<a class="button button-secondary" href="<?php echo esc_url( $strings['item-page-url'] ); ?>" target="_blank">Renew Support Period</a>
				</p>
			</td>
		</tr>
		<?php
	}

	private function render_support_active_row( $support_provided_until_date ) {
		$strings = $this->strings;
		?>
		<tr valign="top">
			<th class="row-title"><?php echo esc_html( $strings['license-supported-until'] ); ?></th>
			<td>
				<span style="color: #46B450"><?php echo esc_html( $strings['support-supported-until'] ); ?> <?php echo esc_html( $support_provided_until_date ); ?></span>
				<p>
					<a class="button button-secondary" href="<?php echo esc_url( $strings['support-forum-url'] ); ?>" target="_blank"><?php echo esc_html( $strings['support-forum-link'] ); ?></a>
				</p>
			</td>
		</tr>
		<?php
	}

	public function register_option() {
		register_setting(
			$this->theme_slug . '-license',
			$this->theme_slug . '_license_key',
			array( $this, 'sanitize_license' )
		);
	}

	public function sanitize_license( $new ) {
		$old = get_option( $this->theme_slug . '_license_key' );

		if ( $old && $old !== $new ) {
			// New license has been entered, so must reactivate
			delete_option( $this->theme_slug . '_license_key_status' );
		}

		return $new;
	}

	public function get_api_response( $api_params, $url ) {
		if ( ! $url ) {
			$url = $this->remote_api_url;
		}

		// Call the custom API.
		$verify_ssl = (bool) apply_filters( 'edd_sl_api_request_verify_ssl', true );
		$response   = wp_remote_post(
			$url,
			array(
				'timeout'   => 15,
				'sslverify' => $verify_ssl,
				'body'      => $api_params,
			)
		);

		return $response;
	}

	public function activate_license() {
		$result = $this->activate_license_ajax();
		$this->redirect( $result );
	}

	public function activate_license_ajax() {
		$result  = array(
			'success' => false,
			'message' => '',
		);
		$key     = isset( $_POST[ $this->theme_slug . '_license_key' ] ) ? sanitize_text_field( wp_unslash( $_POST[ $this->theme_slug . '_license_key' ] ) ) : '';
		$license = ! empty( $key ) ? $key : trim( get_option( $this->theme_slug . '_license_key' ) );
		$api_url = trailingslashit( $this->remote_api_url ) . 'edd/v1/activate/' . $this->theme_slug . '/theme';

		// Data to send in our API request.
		$api_params = array(
			'key' => rawurlencode( $license ),
			'url' => esc_url( home_url( '/' ) ),
		);

		$response = $this->get_api_response( $api_params, $api_url );

		// make sure the response came back okay
		if ( is_wp_error( $response ) || 200 !== wp_remote_retrieve_response_code( $response ) ) {
			if ( is_wp_error( $response ) ) {
				$result['message'] = $response->get_error_message();
			} else {
				$result['message'] = $this->strings['error-generic'];
			}
		} else {
			$license_data      = json_decode( wp_remote_retrieve_body( $response ) );
			$result['message'] = $license_data->message;

			if ( $license_data && isset( $license_data->license ) && $license_data->license === 'valid' ) {
				$result['success'] = true;

				// Removes the default EDD hook for this option, which breaks the AJAX call.
				remove_all_actions( 'update_option_' . $this->theme_slug . '_license_key', 10 );

				update_option( $this->theme_slug . '_license_key_status', sanitize_text_field( $license_data->license ) );
				update_option( $this->theme_slug . '_license_key', sanitize_text_field( $license ) );

				$this->update_license_data_options( $license_data );
			} else {
				if ( $license_data && isset( $license_data->license ) ) {
					update_option( $this->theme_slug . '_license_key_status', sanitize_text_field( $license_data->license ) );
				}

				delete_option( $this->theme_slug . '_license_message' );
				delete_option( $this->theme_slug . '_license_expires' );
				delete_option( $this->theme_slug . '_license_date_purchased' );
				delete_option( $this->theme_slug . '_license_date_supported_until' );
				delete_option( $this->theme_slug . '_license_date_updates_provided_until' );
				delete_option( $this->theme_slug . '_license_is_local' );
				delete_option( $this->theme_slug . '_license_limit' );
				delete_option( $this->theme_slug . '_license_site_count' );
				delete_option( $this->theme_slug . '_license_activations_left' );
			}
		}

		return $result;
	}

	public function deactivate_license() {
		$result = $this->deactivate_license_ajax();
		$this->redirect( $result );
	}

	public function deactivate_license_ajax() {
		$result  = array(
			'success' => false,
			'message' => '',
		);
		$key     = isset( $_POST[ $this->theme_slug . '_license_key' ] ) ? sanitize_text_field( wp_unslash( $_POST[ $this->theme_slug . '_license_key' ] ) ) : '';
		$license = ! empty( $key ) ? $key : trim( get_option( $this->theme_slug . '_license_key' ) );
		$api_url = trailingslashit( $this->remote_api_url ) . 'edd/v1/deactivate/' . $this->theme_slug . '/theme';

		// Data to send in our API request.
		$api_params = array(
			'key' => rawurlencode( $license ),
			'url' => esc_url( home_url( '/' ) ),
		);

		$response = $this->get_api_response( $api_params, $api_url );

		// make sure the response came back okay
		if ( is_wp_error( $response ) || 200 !== wp_remote_retrieve_response_code( $response ) ) {
			if ( is_wp_error( $response ) ) {
				$result['message'] = $response->get_error_message();
			} else {
				$result['message'] = $this->strings['error-generic'];
			}
		} else {
			$license_data      = json_decode( wp_remote_retrieve_body( $response ) );
			$result['message'] = $license_data->message;

			if ( $license_data ) {
				if ( $license_data->message ) {
					$result['message'] = $license_data->message;
				}

				// $license_data->license will be either "deactivated" or "failed"
				if ( $license_data->license === 'deactivated' ) {
					$result['success'] = true;

					update_option( $this->theme_slug . '_license_key_status', sanitize_text_field( $license_data->license ) );
					delete_option( $this->theme_slug . '_license_message' );
					delete_option( $this->theme_slug . '_license_expires' );
					delete_option( $this->theme_slug . '_license_date_purchased' );
					delete_option( $this->theme_slug . '_license_date_supported_until' );
					delete_option( $this->theme_slug . '_license_date_updates_provided_until' );
					delete_option( $this->theme_slug . '_license_is_local' );
					delete_option( $this->theme_slug . '_license_limit' );
					delete_option( $this->theme_slug . '_license_site_count' );
					delete_option( $this->theme_slug . '_license_activations_left' );
				}
			}
		}

		return $result;
	}

	public function check_license() {
		$result = $this->check_license_ajax();
		$this->redirect( $result );
	}

	public function check_license_ajax() {
		$result  = array(
			'success' => false,
			'message' => '',
		);
		$key     = isset( $_POST[ $this->theme_slug . '_license_key' ] ) ? sanitize_text_field( wp_unslash( $_POST[ $this->theme_slug . '_license_key' ] ) ) : '';
		$license = ! empty( $key ) ? $key : trim( get_option( $this->theme_slug . '_license_key' ) );
		$api_url = trailingslashit( $this->remote_api_url ) . 'edd/v1/check/' . $this->theme_slug . '/theme';

		// Data to send in our API request.
		$api_params = array(
			'key' => rawurlencode( $license ),
			'url' => esc_url( home_url( '/' ) ),
		);

		$response = $this->get_api_response( $api_params, $api_url );

		// make sure the response came back okay
		if ( is_wp_error( $response ) || 200 !== wp_remote_retrieve_response_code( $response ) ) {
			if ( is_wp_error( $response ) ) {
				$result['message'] = $response->get_error_message();
			} else {
				$result['message'] = $this->strings['error-generic'];
			}
		} else {
			$license_data      = json_decode( wp_remote_retrieve_body( $response ) );
			$result['message'] = $license_data->message;

			if ( $license_data && isset( $license_data->license ) ) {
				if ( $license_data->license === 'valid' || $license_data->license === 'active' ) {
					$result['success'] = true;
				}

				if ( $license_data->license === 'valid' ) {
					$result['message'] = $this->strings['license-key-is-active'];
				}

				// Removes the default EDD hook for this option, which breaks the AJAX call.
				remove_all_actions( 'update_option_' . $this->theme_slug . '_license_key', 10 );

				update_option( $this->theme_slug . '_license_key_status', sanitize_text_field( $license_data->license ) );
				update_option( $this->theme_slug . '_license_key', sanitize_text_field( $license ) );

				$this->update_license_data_options( $license_data );
			}
		}

		return $result;
	}

	public function register_license_actions() {
		if ( isset( $_POST[ $this->theme_slug . '_license_activate' ] ) ) {
			if ( check_admin_referer( $this->theme_slug . '_nonce', $this->theme_slug . '_nonce' ) ) {
				$this->activate_license();
			}
		}

		if ( isset( $_POST[ $this->theme_slug . '_license_deactivate' ] ) ) {
			if ( check_admin_referer( $this->theme_slug . '_nonce', $this->theme_slug . '_nonce' ) ) {
				$this->deactivate_license();
			}
		}

		if ( isset( $_POST[ $this->theme_slug . '_license_refresh' ] ) ) {
			if ( check_admin_referer( $this->theme_slug . '_nonce', $this->theme_slug . '_nonce' ) ) {
				$this->check_license();
			}
		}
	}

	private function fetch_remote_theme_data() {
		$result     = null;
		$license    = trim( get_option( $this->theme_slug . '_license_key' ) );
		$api_url    = trailingslashit( $this->remote_api_url ) . 'edd/v1/update/' . $this->theme_slug . '/theme';
		$api_params = array(
			'key' => rawurlencode( $license ),
			'url' => esc_url( home_url( '/' ) ),
		);

		$response = $this->get_api_response( $api_params, $api_url );

		if ( ! is_wp_error( $response ) && 200 === wp_remote_retrieve_response_code( $response ) ) {
			$result = json_decode( wp_remote_retrieve_body( $response ) );
		}

		return $result;
	}

	private function replace_lifetime_string( $expires ) {
		if ( 'lifetime' === $expires ) {
			$expires = $this->strings['license-never-expires'];
		}

		return $expires;
	}

	private function update_license_data_options( $license_data ) {
		if ( ! $license_data ) {
			return;
		}

		if ( isset( $license_data->license ) ) {
			update_option( $this->theme_slug . '_license_key_status', sanitize_text_field( $license_data->license ) );
		} else {
			delete_option( $this->theme_slug . '_license_key_status' );
		}

		if ( isset( $license_data->message ) ) {
			update_option( $this->theme_slug . '_license_message', $license_data->message );
		} else {
			delete_option( $this->theme_slug . '_license_message' );
		}

		if ( isset( $license_data->expires ) ) {
			update_option( $this->theme_slug . '_license_expires', sanitize_text_field( $this->replace_lifetime_string( $license_data->expires ) ) );
		} else {
			delete_option( $this->theme_slug . '_license_expires' );
		}

		if ( isset( $license_data->date_purchased ) ) {
			update_option( $this->theme_slug . '_license_date_purchased', sanitize_text_field( $license_data->date_purchased ) );
		} else {
			delete_option( $this->theme_slug . '_license_date_purchased' );
		}

		if ( isset( $license_data->date_supported_until ) ) {
			update_option( $this->theme_slug . '_license_date_supported_until', sanitize_text_field( $this->replace_lifetime_string( $license_data->date_supported_until ) ) );
		} else {
			delete_option( $this->theme_slug . '_license_date_supported_until' );
		}

		if ( isset( $license_data->date_updates_provided_until ) ) {
			update_option( $this->theme_slug . '_license_date_updates_provided_until', sanitize_text_field( $this->replace_lifetime_string( $license_data->date_updates_provided_until ) ) );
		} else {
			delete_option( $this->theme_slug . '_license_date_updates_provided_until' );
		}

		if ( isset( $license_data->is_local ) ) {
			update_option( $this->theme_slug . '_license_is_local', boolval( $license_data->is_local ) );
		} else {
			delete_option( $this->theme_slug . '_license_is_local' );
		}

		if ( isset( $license_data->license_limit ) ) {
			update_option( $this->theme_slug . '_license_limit', sanitize_text_field( $license_data->license_limit ) );
		} else {
			delete_option( $this->theme_slug . '_license_limit' );
		}

		if ( isset( $license_data->site_count ) ) {
			update_option( $this->theme_slug . '_license_site_count', sanitize_text_field( $license_data->site_count ) );
		} else {
			delete_option( $this->theme_slug . '_license_site_count' );
		}

		if ( isset( $license_data->activations_left ) ) {
			update_option( $this->theme_slug . '_license_activations_left', sanitize_text_field( $license_data->activations_left ) );
		} else {
			delete_option( $this->theme_slug . '_license_activations_left' );
		}
	}

	private function redirect( $args ) {
		$base_url = admin_url( 'themes.php?page=' . $this->theme_slug . '-license' );
		$location = add_query_arg(
			array(
				'success' => $args['success'] ? 'yes' : 'no',
				'message' => urlencode( $args['message'] ),
			),
			$base_url
		);

		wp_redirect( $location );
		die();
	}
}
