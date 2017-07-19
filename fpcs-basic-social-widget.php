<?php
/*
 * Plugin Name:       FPCS Basic Social Widget
 * Plugin URI:        https://github.com/FPCSJames/basic-social-widget
 * Description:       Displays a row of clickable social media icons. Best in footer sections.
 * Version:           1.0.1
 * Author:            James M. Joyce, Flashpoint Computer Services, LLC
 * Author URI:        http://www.flashpointcs.net
 * Text Domain:       fpcs-basic-social-widget
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * GitHub Plugin URI: https://github.com/FPCSJames/basic-social-widget
 */
 
if ( ! defined ( 'ABSPATH' ) ) {
	exit;
}

class FPCS_Basic_Social_Widget extends WP_Widget {

    /**
     * Unique identifier for this widget.
     *
     * @since    1.0.0
     *
     * @var      string
     */
    protected $widget_slug = 'fpcs-basic-social-widget';

	/**
	 * Specifies the classname and description, instantiates the widget,
	 * and includes necessary stylesheets and JavaScript.
	 */
	public function __construct() {

		parent::__construct(
			$this->widget_slug,
			__( 'FPCS Basic Social Widget', 'fpcs-basic-social-widget' ),
			array(
				'classname'  => $this->widget_slug,
				'description' => __( 'Displays a row of clickable social media icons. Best in footer sections.', $this->widget_slug )
			)
		);

		// Register admin styles and scripts
		add_action( 'admin_print_styles', array( $this, 'register_admin_styles' ) );
		add_action( 'admin_enqueue_scripts', array( $this, 'register_admin_scripts' ) );

		// Register site styles and scripts
		add_action( 'wp_enqueue_scripts', array( $this, 'register_widget_styles' ) );

		// Refresh the widget's cached output with each new post
		add_action( 'save_post',    array( $this, 'flush_widget_cache' ) );
		add_action( 'deleted_post', array( $this, 'flush_widget_cache' ) );
		add_action( 'switch_theme', array( $this, 'flush_widget_cache' ) );

	}

	/*--------------------------------------------------*/
	/* Widget API Functions
	/*--------------------------------------------------*/

	/**
	 * Outputs the content of the widget.
	 *
	 * @param array args  The array of form elements
	 * @param array instance The current instance of the widget
	 */
	public function widget( $args, $instance ) {
		
		// Check if there is a cached output
		$cache = wp_cache_get( $this->widget_slug, 'widget' );

		if ( !is_array( $cache ) )
			$cache = array();

		if ( ! isset ( $args['widget_id'] ) )
			$args['widget_id'] = $this->id;

		if ( isset ( $cache[ $args['widget_id'] ] ) )
			return print $cache[ $args['widget_id'] ];
		
		extract( $args, EXTR_SKIP );
		
		$instance = wp_parse_args(
			(array) $instance,
			[
				'color_background' => '#2b2b2b',
				'color_background_hover' => '#333333',
				'facebook' => '',
				'twitter' => '',
				'linkedin' => '',
				'googleplus' => '',
				'pinterest' => '',
				'instagram' => '',
				'enqueue_fa' => false,
				'title' => ''
			]
		);
		
		extract( $instance );
		$facebook = esc_url( $facebook );
		$twitter = esc_url( $twitter );
		$linkedin = esc_url( $linkedin );
		$googleplus = esc_url( $googleplus );
		$pinterest = esc_url( $pinterest );
		$instagram = esc_url( $instagram );
		$color_background = esc_attr( $color_background );
		$color_background_hover = esc_attr( $color_background_hover );
		
		$widget_string = $before_widget;
		if( $title ) {
			$widget_string .= $before_title . $title . $after_title;
		}
		
		ob_start();
		include( plugin_dir_path( __FILE__ ) . 'view-widget.php' );
		$widget_string .= ob_get_clean();
		$widget_string .= $after_widget;

		$cache[ $args['widget_id'] ] = $widget_string;

		wp_cache_set( $this->widget_slug, $cache, 'widget' );

		print $widget_string;

	}
	
	public function flush_widget_cache() {
    	wp_cache_delete( $this->widget_slug, 'widget' );
	}
	
	/**
	 * Processes the widget's options to be saved.
	 *
	 * @param array new_instance The new instance of values to be generated via the update.
	 * @param array old_instance The previous instance of values before the update.
	 */
	public function update( $new_instance, $old_instance ) {

		$instance = $old_instance;

		$instance['color_background'] = sanitize_hex_color( trim( $new_instance['color_background'] ) );
		$instance['color_background_hover'] = sanitize_hex_color( trim( $new_instance['color_background_hover'] ) );
		$instance['facebook'] = esc_url_raw( trim( $new_instance['facebook'] ) ); 
		$instance['twitter'] = esc_url_raw( trim( $new_instance['twitter'] ) ); 
		$instance['linkedin'] = esc_url_raw( trim( $new_instance['linkedin'] ) ); 
		$instance['googleplus'] = esc_url_raw( trim( $new_instance['googleplus'] ) ); 
		$instance['pinterest'] = esc_url_raw( trim( $new_instance['pinterest'] ) ); 
		$instance['instagram'] = esc_url_raw( trim( $new_instance['instagram'] ) ); 
		$instance['enqueue_fa'] = ! empty( $new_instance['enqueue_fa'] );
		$instance['title'] = strip_tags( trim( $new_instance['title'] ) );

		return $instance;
		
	}

	/**
	 * Generates the administration form for the widget.
	 *
	 * @param array instance The array of keys and values for the widget.
	 */
	public function form( $instance ) {

		$instance = wp_parse_args(
			(array) $instance,
			[
				'color_background' => '#2b2b2b',
				'color_background_hover' => '#333333',
				'facebook' => '',
				'twitter' => '',
				'linkedin' => '',
				'googleplus' => '',
				'pinterest' => '',
				'instagram' => '',
				'enqueue_fa' => false,
				'title' => ''
			]
		);
		
		extract($instance);
		
		$facebook = esc_url($facebook);
		$twitter = esc_url($twitter);
		$linkedin = esc_url($linkedin);
		$googleplus = esc_url($googleplus);
		$pinterest = esc_url($pinterest);
		$instagram = esc_url($instagram);

		// Display the admin form
		include( plugin_dir_path(__FILE__) . 'view-admin.php' );

	}

	/*--------------------------------------------------*/
	/* Public Functions
	/*--------------------------------------------------*/

	/**
	 * Registers and enqueues admin-specific styles.
	 */
	public function register_admin_styles() {
		wp_enqueue_style( 'wp-color-picker' );
	}

	/**
	 * Registers and enqueues admin-specific JavaScript.
	 */
	public function register_admin_scripts() {
		wp_enqueue_script( 'wp-color-picker' );
		wp_enqueue_script( 'underscore' );
		wp_enqueue_script( $this->widget_slug . '-admin-script', plugins_url( 'js/admin.min.js', __FILE__ ), ['jquery', 'wp-color-picker', 'underscore'] );
	}

	/**
	 * Registers and enqueues widget-specific styles.
	 */
	public function register_widget_styles() {
		
		$instance = $this->get_settings()[ str_replace( $this->widget_slug. '-', '', $this->id ) ];
		if ( true === $instance['enqueue_fa'] ) {
			wp_enqueue_style( $this->widget_slug . '-fontawesome', plugins_url( 'css/font-awesome.min.css', __FILE__ ), [], '4.7.0' );
			wp_enqueue_style( $this->widget_slug, plugins_url( 'css/widget.min.css', __FILE__ ), [ $this->widget_slug . '-fontawesome' ], '1.0.1' );
		} else {
			wp_enqueue_style( $this->widget_slug, plugins_url( 'css/widget.min.css', __FILE__ ), [], '1.0.1' );
		}
		
		$inline_css = sprintf(
			'#%1$s a{background-color:%2$s;}#%1$s a:hover{background-color:%3$s;}',
			$this->id,
			$instance['color_background'],
			$instance['color_background_hover']
		);
		wp_add_inline_style( $this->widget_slug, $inline_css );
		
	}

}
add_action( 'widgets_init', function() { register_widget("FPCS_Basic_Social_Widget"); } );
