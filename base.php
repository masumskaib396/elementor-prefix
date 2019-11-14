<?php 

use \Elementor\Plugin as Plugin;

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

final class Prefix_Extension {
	
	const VERSION = '1.0.0';
	const MINIMUM_ELEMENTOR_VERSION = '2.4.5';
	const MINIMUM_PHP_VERSION = '7.0';


	private static $_instance = null;

	public static function instance() {
		if ( is_null( self::$_instance ) ) {
			self::$_instance = new self();
		}
		return self::$_instance;
	}
	
	public function __construct() {

		add_action( 'init', [ $this, 'i18n' ] );
		add_action( 'plugins_loaded', [ $this, 'init' ] );

	}

	public function i18n() {
		load_plugin_textdomain( 'prefix' );
	}

	

	public function init() {
		// Check if Elementor installed and activated
		if ( ! did_action( 'elementor/loaded' ) ) {
			add_action( 'admin_notices', [ $this, 'admin_notice_missing_main_plugin' ] );
			return;
		}
		// Check for required Elementor version
		if ( ! version_compare( ELEMENTOR_VERSION, self::MINIMUM_ELEMENTOR_VERSION, '>=' ) ) {
			add_action( 'admin_notices', [ $this, 'admin_notice_minimum_elementor_version' ] );
			return;
		}

		// Check for required PHP version
		if ( version_compare( PHP_VERSION, self::MINIMUM_PHP_VERSION, '<' ) ) {
			add_action( 'admin_notices', [ $this, 'admin_notice_minimum_php_version' ] );
			return;
		}

		//add_action( 'elementor/editor/after_enqueue_styles', array ( $this, 'pawelements_editor_styles' ) );
		add_action( 'elementor/widgets/widgets_registered', [ $this, 'init_widgets' ] );
		add_action( 'elementor/elements/categories_registered',[$this,'register_new_category']);
		add_action( 'elementor/frontend/after_register_scripts', array( $this, 'register_frontend_scripts'),10);
		add_action( 'elementor/frontend/before_register_scripts', [ $this, 'prefix_register_frontend_before_scripts' ] );
		add_action( 'wp_enqueue_scripts', array( $this, 'prefix_register_frontend_styles' ), 10 );

		
	}
	
	/**
	 * Load Frontend Script
	 *
	*/
	public function register_frontend_scripts(){
		wp_enqueue_script(

			'handler',
			 PREFIX_ASSETS . 'sorce',array('jquery'),
             PREFIX_VERSION,true
		);

		
		
	}

	/**
	 * Load Frontend Styles
	 *
	*/
	public function prefix_register_frontend_styles(){
		wp_enqueue_style(
			'handler',
			 PREFIX_ASSETS .'sorce',
			 null, PREFIX_VERSION
		);


		
	}

	/**
	 * Load Frontend Styles
	 *
	*/
	

	/**
	 * Widgets Catgory
	 *
	*/
	public function register_new_category($manager){
	   $manager->add_category('prefix',
			[
				'title' => __( 'prefix Companion  Addons', 'prefix-companion' ),
			]);
	}

	public function admin_notice_minimum_php_version() {

		if ( isset( $_GET['activate'] ) ) unset( $_GET['activate'] );

		$message = sprintf(
			/* translators: 1: Plugin name 2: PHP 3: Required PHP version */
			esc_html__( '"%1$s" requires "%2$s" version %3$s or greater.', 'prefix-companion' ),
			'<strong>' . esc_html__( 'Elementor gorila Extension', 'prefix-companion' ) . '</strong>',
			'<strong>' . esc_html__( 'PHP', 'prefix-companion' ) . '</strong>',
			 self::MINIMUM_PHP_VERSION
		);

		printf( '<div class="notice notice-warning is-dismissible"><p>%1$s</p></div>', $message );

	}

	public function admin_notice_missing_main_plugin() {

		if ( isset( $_GET['activate'] ) ) unset( $_GET['activate'] );
		$message = sprintf(
			/* translators: 1: Plugin name 2: Elementor */
			esc_html__( '"%1$s" requires "%2$s" to be installed and activated.', 'prefix-companion' ),
			'<strong>' . esc_html__( 'Elementor gorila Extension', 'prefix-companion' ) . '</strong>',
			'<strong>' . esc_html__( 'Elementor', 'gorila-companion' ) . '</strong>'
		);

		printf( '<div class="notice notice-warning is-dismissible"><p>%1$s</p></div>', $message );

	}

	public function admin_notice_minimum_elementor_version() {

		if ( isset( $_GET['activate'] ) ) unset( $_GET['activate'] );

		$message = sprintf(
			/* translators: 1: Plugin name 2: Elementor 3: Required Elementor version */
			esc_html__( '"%1$s" requires "%2$s" version %3$s or greater.', 'prefix-companion' ),
			'<strong>' . esc_html__( 'Elementor gorila Extension', 'prefix-companion' ) . '</strong>',
			'<strong>' . esc_html__( 'Elementor', 'prefix-companion' ) . '</strong>',
			 self::MINIMUM_ELEMENTOR_VERSION
		);

		printf( '<div class="notice notice-warning is-dismissible"><p>%1$s</p></div>', $message );

	}

	public function init_widgets() {

		$widgets_manager = \Elementor\Plugin::instance()->widgets_manager;
		//Include Widget files

		//Teachers Widget
		require_once( PREFIX_ADDONS_DIR . '' );
		$widgets_manager->register_widget_type( new \gorila\Widgets\Elementor\WidgetNname() );
		
	}


}

PREFIX_Extension::instance();
