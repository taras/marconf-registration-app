<?php
/**
 * Plugin Name: Registration App
 */

add_action( 'scaleup_app_init',function() {
  include( dirname( __FILE__ ) . '/app.php' );
} );
