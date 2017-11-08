<?php
/**
 * Plugin Name: Login Box or Display Username Widget
 * Description: This widget shows the display name of the logged in user if logged in, and a login box if logged out.
 * Version: 1.0.0
 * License: GNU AGPL
 * Author: Cristian Abello and Carly Armor
 * Author URI: mailto:cristian.abello@valpo.edu,carly.armor@valpo.edu
 * 
 */

/**
 * Our main plugin instantiation class
 *
 * @since 1.0.0
 */
class Login_Box_Or_Display_Username {

	/**
	 * Get everything running.
	 *
	 * @since 1.0.0
	 */
	function __construct() {
		
		// Define plugin constants
		$this->basename       = plugin_basename( __FILE__ );
		$this->directory_path = plugin_dir_path( __FILE__ );
		$this->directory_url  = plugins_url( dirname( $this->basename ) );
	
	
	
		// Run our activation and deactivation hooks
		register_activation_hook( __FILE__, array( $this, 'activate' ) );
		register_deactivation_hook( __FILE__, array( $this, 'deactivate' ) );
	
		// If BadgeOS is unavailable, deactivate our plugin
		add_action( 'admin_notices', array( $this, 'maybe_disable_plugin' ) );
	
	     // use widgets_init action hook to execute custom function
        add_action( 'widgets_init', array( $this, 'register_widget' ) );

		// Hook in our dependent files and methods
		add_action( 'init', array( $this, 'includes' ), 0 );

        // Load custom js and css
        add_action( 'wp_enqueue_scripts', array( $this, 'load_scripts_and_styles' ), 1 );
        
	}


	/**
	 * Include our file dependencies
	 *
	 * @since 1.0.0
	 */
	public function includes() {

		// Include other files so long as requirements (if any) are met
		if ( $this->meets_requirements() ) {
			require_once( $this->directory_path . '/includes/login-box-or-display-username.php' );
	
		}

	}


    /**
     * Register our widget
     *
     * @since 1.0.0
     */
    public function register_widget() {

        // Registering widget
        if (class_exists('login_or_display_username_widget'))
            register_widget( 'login_or_display_username_widget' );
    }

	/**
	 * Register our included scripts and stles
	 *
	 * @since 1.0.0
	 */
	public function load_scripts_and_styles() {
	}

	/**
	 * Activation hook for the plugin.
	 *
	 * @since 1.0.0
	 */
	public function activate() {
        // Do some activation things.
	}

	/**
	 * Deactivation hook for the plugin.
	 *
	 * @since 1.0.0
	 */
	public function deactivate() {

		// Do some deactivation things. Note: this plugin may
		// auto-deactivate due to $this->maybe_disable_plugin()

	}

	/**
	 * Check if requirements are met
	 *
	 * @since  1.0.0
	 * @return bool True if BadgeOS is available, false otherwise
	 */
	public static function meets_requirements() {
		return true;
		/*if (){
			return true;
		}
		else{
			return false;
		}*/
	}

	/**
	 * Potentially output a custom error message and deactivate
	 * this plugin, if we don't meet requriements.
	 *
	 * This fires on admin_notices.
	 *
	 * @since 1.0.0
	 */
	public function maybe_disable_plugin() {

		if ( ! $this->meets_requirements() ) {
			// Display our error
			include_once( ABSPATH . 'wp-admin/includes/plugin.php' );
			echo '<div id="message" class="error">';
			
          
			echo '<p>' . sprintf(__('Plugin could not be activated.', ''), admin_url('plugins.php')) . '</p>';
            
            echo '</div>';

			// Deactivate our plugin
			deactivate_plugins( $this->basename );
			
			if ( isset( $_GET['activate'] ) ) 
            unset( $_GET['activate'] );
        
		}

	}

}

// Instantiate our class to a global variable that we can access elsewhere
$GLOBALS['login_or_display_username_widget_tool'] = new Login_Box_Or_Display_Username();
