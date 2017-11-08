<?php

class login_or_display_username_widget extends WP_Widget {

    //process the new widget
    function login_or_display_username_widget() {
        $widget_ops = array(
            'classname' => 'login_or_display_username_class',
            'description' => __( 'Displays username if logged in and a log out link if logged in and a login box if logged out.', '' )
        );
          $this->WP_Widget( 'login_or_display_username_widget', __( 'Login Box or Display Username', '' ), $widget_ops );

    }

    // Leave code for widget configuration in case we want to add on later. 
    function form( $instance ) {
    	?>
        <p>This widget has no settings to configure.</p>
    	<?php 
    }

	// Update widget settings once changed (though not any right now).
	function update( $new_instance, $old_instance ) {
   		$instance = $old_instance;
        $instance['title'] = sanitize_text_field( $new_instance['title'] );
        return $instance;
	}
   
	// Render the actual widget in the sidebar.
	function widget( $args, $instance ) {
		global $user_ID;
		echo $args['before_widget'];
		
		$title = apply_filters( 'widget_title', $instance['title'] );
		if ( !empty( $title ) ) { echo $args['before_title'] . $title . $args['after_title']; };
		
		// User must be logged in to view earned badges and points
		
		if ( is_user_logged_in() ) {
			echo ("You are logged in as ".wp_get_current_user()->display_name.". ");
		
			echo '<a href="'.wp_logout_url( home_url() ).'">Logout</a>';
		} 
		
		else {
			
			// User is not logged in so display the login box
			
			_e(wp_login_form( array(
				'echo'           => true,
				'remember'       => true,
				'redirect'       => ( is_ssl() ? 'https://' : 'http://' ) . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'],
				'form_id'        => 'loginform',
				'id_username'    => 'user_login',
				'id_password'    => 'user_pass',
				'id_remember'    => 'rememberme',
				'id_submit'      => 'wp-submit',
				'label_username' => __( 'Username' ),
				'label_password' => __( 'Password' ),
				'label_remember' => __( 'Remember Me' ),
				'label_log_in'   => __( 'Log In' ),
				'value_username' => '',
				'value_remember' => false
			)));
			
		}
		
		echo $args['after_widget'];

	}

}
