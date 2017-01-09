<?php
/**
 * FPCS Basic Social Widget
 *
 * Displays a row of clickable social media icons. Best in footer sections.
 *
 * @package   FPCS_Basic_Social_Widget
 * @author    James M. Joyce
 * @license   GPL-2.0+
 * @link      http://www.flashpointcs.net
 * @copyright 2017 Flashpoint Computer Services, LLC
 *
 * @wordpress-plugin
 * Plugin Name:       FPCS Basic Social Widget
 * Plugin URI:        https://github.com/FPCSJames/basic-social-widget
 * Description:       Displays a row of clickable social media icons. Best in footer sections.
 * Version:           1.0.0
 * Author:            James M. Joyce, Flashpoint Computer Services, LLC
 * Author URI:        http://www.flashpointcs.net
 * Text Domain:       fpcs-basic-social-widget
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Domain Path:       /lang
 * GitHub Plugin URI: https://github.com/FPCSJames/basic-social-widget
 */
 
if ( ! defined ( 'ABSPATH' ) ) {
	exit;
}

class FPCS_Basic_Social_Widget extends WP_Widget {

    /**
     * Unique identifier for this widget.
     *
     * The variable name is used as the text domain when internationalizing strings
     * of text. Its value should match the Text Domain file header in the main
     * widget file.
     *
     * @since    1.0.0
     *
     * @var      string
     */
    protected $widget_slug = 'fpcs-basic-social-widget';

	/**
	 * Specifies the classname and description, instantiates the widget,
	 * loads localization files, and includes necessary stylesheets and JavaScript.
	 */
	public function __construct() {

		// load plugin text domain
		add_action( 'init', array( $this, 'widget_textdomain' ) );

		parent::__construct(
			$this->get_widget_slug(),
			__( 'FPCS Basic Social Widget', $this->get_widget_slug() ),
			array(
				'classname'  => $this->get_widget_slug().'-class',
				'description' => __( 'Displays a row of clickable social media icons. Best in footer sections.', $this->get_widget_slug() )
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


    /**
     * Return the widget slug.
     *
     * @since    1.0.0
     *
     * @return   Plugin slug variable.
     */
    public function get_widget_slug() {
        return $this->widget_slug;
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
		$cache = wp_cache_get( $this->get_widget_slug(), 'widget' );

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
		
		if ( true === $enqueue_fa ) {
			wp_enqueue_script( 'fpcsbsw-fontawesome' );
		}
		
		$widget_string = $before_widget;
		$widget_string .= $before_title . $title . $after_title;
		
		$inline_style = sprintf(
			'.fpcs-basic-social-widget a{background-color:$1%s}.fpcs-basic-social-widget a:hover{background-color:$2%s}',
			$color_background,
			$color_background_hover
		);
		
		wp_add_inline_style($this->get_widget_slug(), $inline_style);
		
		ob_start();
		include( plugin_dir_path( __FILE__ ) . 'views/widget.php' );
		$widget_string .= ob_get_clean();
		$widget_string .= $after_widget;

		$cache[ $args['widget_id'] ] = $widget_string;

		wp_cache_set( $this->get_widget_slug(), $cache, 'widget' );

		print $widget_string;

	}
	
	public function flush_widget_cache() {
    	wp_cache_delete( $this->get_widget_slug(), 'widget' );
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
		include( plugin_dir_path(__FILE__) . 'views/admin.php' );

	}

	/*--------------------------------------------------*/
	/* Public Functions
	/*--------------------------------------------------*/

	/**
	 * Loads the Widget's text domain for localization and translation.
	 */
	public function widget_textdomain() {
		load_plugin_textdomain( $this->get_widget_slug(), false, plugin_dir_path( __FILE__ ) . 'lang/' );
	}

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
		wp_enqueue_script( $this->get_widget_slug().'-admin-script', plugins_url( 'js/admin.min.js', __FILE__ ), ['jquery', 'wp-color-picker', 'underscore'] );
	}

	/**
	 * Registers and enqueues widget-specific styles.
	 */
	public function register_widget_styles() {
		wp_register_style( 'fpcsbsw-fontawesome', plugins_url( 'css/font-awesome.min.css', __FILE__ ) );
		wp_enqueue_style( $this->get_widget_slug(), plugins_url( 'css/widget.min.css', __FILE__ ) );
	}

}

add_action( 'widgets_init', function() { register_widget("FPCS_Basic_Social_Widget"); } );
