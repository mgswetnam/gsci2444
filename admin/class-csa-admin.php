<?php

/**
 * Helper class for Beaver Builder child theme
 * @class GSCI_Admin
 */

final class GSCI_Admin {

  private $version;
  public static $_instance;

  static function init(){
    if ( !self::$_instance ) {
      self::$_instance = new self();
    }
    return self::$_instance;
  }

  public function __construct() {
    // Actions
    add_action( "admin_head", array( $this, "gsci_cs_admin_setup" ) );
    // Filters
    //add_filter( "style_loader_tag", array( $this, "gsci_remove_type_attr" ), 10, 2 );
    // Shortcodes
    //add_shortcode( "gsci_render_title", array( $this, "gsci_render_title" ) );
  }

  // -- Actions --

  public static function gsci_cs_admin_setup(){
		// Scripts
    wp_enqueue_script( 'gsci-cs-admin', FL_CHILD_THEME_URL . '/admin/assets/dist/js/admin.min.js', array('jquery'), GSCI_VERSION );
    // Styles
    wp_enqueue_style( 'gsci-cs-admin', FL_CHILD_THEME_URL . '/admin/assets/dist/css/admin.min.css', array(), GSCI_VERSION );
  }

  // -- Filters --



  // -- Shortcodes --


}
