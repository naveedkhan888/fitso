<?php

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

class Arts_Admin_Notice_Manager {
	protected static $_instance;
	private $admin_notices;
	private $prefix         = 'arts';
	private $action_dismiss = '';
	const TYPES             = 'error,warning,info,success';

	public static function instance() {
		if ( is_null( static::$_instance ) ) {
			static::$_instance = new static();
		}

		return static::$_instance;
	}

	private function __construct() {
		$this->admin_notices = new stdClass();

		foreach ( explode( ',', self::TYPES ) as $type ) {
			$this->admin_notices->{$type} = array();
		}

		$this->action_dismiss = "{$this->prefix}_set_notice_dismiss";

		add_action( 'admin_notices', array( $this, 'action_admin_notices' ) );
		add_action( "wp_ajax_{$this->action_dismiss}", array( $this, 'ajax_set_notice_dismiss' ) );
	}

	public function ajax_set_notice_dismiss() {
		check_ajax_referer( "{$this->action_dismiss}_nonce" );

		if ( ! isset( $_GET['notice_id'] ) || ! isset( $_GET['dismiss'] ) ) {
			wp_die();
			return;
		}

		$is_dismissed = boolval( $_GET['dismiss'] );
		$notice_id    = sanitize_key( $_GET['notice_id'] );

		update_option( "{$this->prefix}_dismissed_{$notice_id}", $is_dismissed );
		wp_die();
	}

	public function action_admin_notices() {
		foreach ( explode( ',', self::TYPES ) as $type ) {
			foreach ( $this->admin_notices->{$type} as $admin_notice ) {
				$is_dismissed = get_option( "{$this->prefix}_dismissed_{$admin_notice->notice_id}" );

				if ( ( ! $is_dismissed || ! $admin_notice->dismiss_option ) && ( ! empty( $admin_notice->title ) || ! empty( $admin_notice->message ) ) ) {
					$class_names = array(
						'notice',
						$this->prefix . '-notice',
						'notice-' . $type,
					);

					$dismiss_url = '';

					if ( $admin_notice->is_alt_style ) {
						$class_names[] = 'notice-alt';
					}

					if ( $admin_notice->dismiss_option ) {
						$class_names[] = 'is-dismissible';

						$dismiss_url = add_query_arg(
							array(
								'action'    => $this->action_dismiss,
								'notice_id' => $admin_notice->notice_id,
								'dismiss'   => true,
								'_wpnonce'  => wp_create_nonce( "{$this->action_dismiss}_nonce" ),
							),
							admin_url( 'admin-ajax.php' )
						);
					}
					?>
					<div class="<?php echo esc_attr( implode( ' ', $class_names ) ); ?>"<?php if ( ! empty( $dismiss_url ) ) : ?> data-dismiss-url="<?php echo esc_url( $dismiss_url ); ?>"<?php endif; ?>>
						<?php if ( ! empty( $admin_notice->title ) ) : ?>
							<h2><?php echo esc_html( $admin_notice->title ); ?></h2>
						<?php endif; ?>
						<?php if ( ! empty( $admin_notice->message ) ) : ?>
							<p><?php echo wp_kses_post( $admin_notice->message ); ?></p>
						<?php endif; ?>
						<?php if ( ! empty( $admin_notice->link ) && isset( $admin_notice->link['text'] ) ) : ?>
							<p><a class="<?php echo esc_attr( $admin_notice->link['class'] ); ?>" href="<?php echo esc_url( $admin_notice->link['url'] ); ?>" target="<?php echo esc_attr( isset( $admin_notice->link['target'] ) ? $admin_notice->link['target'] : '' ); ?>"><?php echo esc_html( $admin_notice->link['text'] ); ?></a></p>
						<?php endif; ?>
					</div>
					<?php
				}
			}
		}
	}

	public function error( $args ) {
		$this->create_notice( 'error', $args );
	}

	public function warning( $args ) {
		$this->create_notice( 'warning', $args );
	}

	public function success( $args ) {
		$this->create_notice( 'success', $args );
	}

	public function info( $args ) {
		$this->create_notice( 'info', $args );
	}

	private function create_notice( $type, $args ) {
		$defaults = array(
			'title'          => '',
			'message'        => '',
			'link'           => array(),
			'is_alt_style'   => false,
			'dismiss_option' => false,
			'notice_id'      => '',
		);

		$args = wp_parse_args( $args, $defaults );

		$notice                 = new stdClass();
		$notice->title          = $args['title'];
		$notice->message        = $args['message'];
		$notice->link           = $args['link'];
		$notice->is_alt_style   = $args['is_alt_style'];
		$notice->dismiss_option = $args['dismiss_option'];
		$notice->notice_id      = $args['notice_id'];

		$this->admin_notices->{$type}[] = $notice;
	}
}
