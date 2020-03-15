<?php

/**
 * Helper class for Beaver Builder child theme
 * @class GSCI_Core
 */

final class GSCI_Core {

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
    add_action( "wp_print_scripts", array( $this, "gsci_theme_setup" ) );
		add_action( 'add_meta_boxes', array( $this, 'gsci_add_meta_boxes' ) );
		add_action( 'save_post', array( $this, 'gsci_save_custom' ) );
    // Filters
    add_filter( "style_loader_tag", array( $this, "gsci_remove_type_attr" ), 10, 2);
    add_filter( "script_loader_tag", array( $this, "gsci_remove_type_attr" ), 10, 2);
    // Shortcodes
    add_shortcode( "gsci_render_title", array( $this, "gsci_render_title" ) );
    add_shortcode( "gsci_social_icons", array( $this, "gsci_social_icons" ) );
  }

  public static function gsci_theme_setup(){
		// Scripts
    wp_enqueue_script( "jquery" );
    wp_enqueue_script( "gsci-ca-modernizr", FL_CHILD_THEME_URL . "/assets/dist/js/vendor/modernizr.min.js", array(), GSCI_VERSION );
    wp_enqueue_script( "gsci-ca-main", FL_CHILD_THEME_URL . "/assets/dist/js/main.min.js", array( "jquery" ), GSCI_VERSION );
    // Styles
    wp_enqueue_style( "gsci-ca-main", FL_CHILD_THEME_URL . "/assets/dist/css/main.min.css", array(), GSCI_VERSION );
  }

	public function gsci_add_meta_boxes(){
    $metabox = new GSCI_Canadensis_Metaboxes();
    $metabox->gsci_add_meta_boxes();
	}

	public function gsci_save_custom(){
    $metabox = new GSCI_Canadensis_Metaboxes();
    $metabox->gsci_save_custom_fields();
	}

  // This is necessary to remove type tag from scripts and styles
  // Revisit if Wordpress changes the way they load scripts and styles
  public static function gsci_remove_type_attr($tag, $handle) {
    return preg_replace( "/type=['\"]text\/(javascript|css)['\"]/", '', $tag );
  }

  public static function gsci_widgets_setup() {
    if ( function_exists( 'register_sidebar' ) ){
      register_sidebar( array(
          'name' => __( 'Header CTA', 'gsci-canadensis' ),
          'id' => 'gsci-header-cta',
          'before_widget' => '<aside id="%1$s" class = "gsci-header-widget gsci-cta %2$s">',
          'after_widget' => '</aside>',
  				'before_title' => '<h4 class="fl-widget-title gsci-widget-title">',
  				'after_title' => '</h4>',
      ) );
      register_sidebar( array(
          'name' => __( 'Footer Ribbon', 'gsci-canadensis' ),
          'id' => 'gsci-footer-ribbon',
          'before_widget' => '<aside id="%1$s" class = "gsci-footer-ribbon-widget %2$s">',
          'after_widget' => '</aside>',
  				'before_title' => '<h4 class="gsci-widget-title">',
  				'after_title' => '</h4>',
      ) );
      register_sidebar( array(
          'name' => __( 'Footer Sub Ribbon', 'gsci_canadensis' ),
          'id' => 'gsci-footer-sub-ribbon',
          'description' => 'Appears in the strip just below footer widgets',
          'class'  => 'gsci-footer-ribbon-widget-wrapper',
          'before_widget' => '<aside id="%1$s" class = "gsci-footer-widget sub-ribbon %2$s">',
          'after_widget' => '</aside>',
  				'before_title' => '<h4 class="fl-widget-title gsci-widget-title">',
  				'after_title' => '</h4>',
      ) );
      register_sidebar( array(
          'name' => __( 'Article Adjacent', 'gsci_canadensis' ),
          'id' => 'gsci-articleadjacent',
          'description' => 'Stuff that appears with the articles',
          'class' => 'gsci_articleadjacent_wrapper',
          'before_widget' => '<aside id="%1$s" class = "gsci_articleadjacent %2$s">',
          'after_widget' => '</aside>',
  				'before_title' => '<h4 class="fl-widget-title gsci_articleadjacent_title">',
  				'after_title' => '</h4>',
      ) );
      register_sidebar( array(
          'name' => __( 'After Nav', 'gsci_canadensis' ),
          'id' => 'gsci-afternav',
          'description' => 'Content to display just after the navigation bar',
          'class' => 'gsci_afternav_wrapper',
          'before_widget' => '<aside id="%1$s" class = "gsci_afternav %2$s">',
          'after_widget' => '</aside>',
  				'before_title' => '<h4 class="fl-widget-title gsci_afternav_title">',
  				'after_title' => '</h4>',
      ) );
    }
  }

  public function gsci_render_title( $atts ){
    $a = shortcode_atts( array(
			"post" => "",
      "formatted" => "true"
		), $atts );

    $search = array( '/\>[^\S ]+/s', '/[^\S ]+\</s', '/(\s)+/s', '/<!--(.|\s)*?-->/' );
    $replace = array( '>', '<', '\\1', '' );

    ob_start();
    $title = get_the_title( $a[ "post" ] );
    if( $a[ "formatted" ] == "false" ){
      ?>
      <span><?=$title?></span>
      <?php
      edit_post_link( _x( 'Edit', 'Edit page link text.', 'fl-automator' ) );
    } else {
      ?>
      <h1 class="fl-post-title" itemprop="headline"><?=$title?></h1>
      <?php
      edit_post_link( _x( 'Edit', 'Edit page link text.', 'fl-automator' ) );
    }

    $buffer =  ob_get_clean();

    $buffer = preg_replace( $search, $replace, $buffer );

    return $buffer;
  }

  public function gsci_social_icons( $atts ){
    $a = shortcode_atts( array(
      "bg" => "",
      "class" => "",
      "blog" => "",
		), $atts );
    // Set variables
    $bg = $a[ "bg" ];
    $class = $a[ "class" ];
    $blog = $a[ "blog" ];

    $search = array( '/\>[^\S ]+/s', '/[^\S ]+\</s', '/(\s)+/s', '/<!--(.|\s)*?-->/' );
    $replace = array( '>', '<', '\\1', '' );

    $thesettings = FLTheme::get_settings();
    $socials = array();
    foreach( $thesettings as $key=>$value ){
    	if( strpos( $key, 'fl-social-' ) !== false && $key !== 'fl-social-icons-color' && $value !== '' ){
    		$socials[ $key ] = $value;
    	}
    }

    ob_start();
    ?>
    <div id="gsci-social-icons-wrapper-outter" class="gsci-social-icons wrapper-outter <?=$a[ "class" ]?>">
      <div class="wrapper-inner">
        <div class="wrapper-content">
        <?php
        if( $blog !== "" ){
        ?>
        <a href="<?=$blog?>" target="self" class="gsci-icon-item-wrapper" title="Blog">
          <span class="fa-stack fa-xs">
            <i class="fas fa-square fa-stack-2x"></i>
            <i class="gsci-icon-item gscif gsci-blog fa-stack-1x fa-inverse" style="line-height:inherit;"></i>
          </span>
        </a>
        <?php }
      	foreach( $socials as $k=>$v ){
          $platform = str_replace( "fl-social-", "", $k );
          $fab = "";
          $incrowd = array( "facebook","twitter","google","snapchat","linkedin","yelp","xing","pinterest","tumblr","vimeo","youtube","flickr","instagram","skype","dribbble","500px","blogger","github","rss","email" );
          if( in_array( $platform, $incrowd ) === true ){
            switch( $platform ){
              case "facebook":{ $fab = "fab fa-facebook-f"; break; }
              case "twitter":{ $fab = "fab fa-twitter"; break; }
              case "google":{ $fab = "fab fa-google-plus-g"; break; }
              case "snapchat":{ $fab = "fab fa-snapchat-ghost"; break; }
              case "linkedin":{ $fab = "fab fa-linkedin-in"; break; }
              case "yelp":{ $fab = "fab fa-yelp"; break; }
              case "xing":{ $fab = "fab fa-xing"; break; }
              case "pinterest":{ $fab = "fab fa-pinterest-p"; break; }
              case "tumblr":{ $fab = "fab fa-tumblr"; break; }
              case "vimeo":{ $fab = "fab fa-vimeo-v"; break; }
              case "youtube":{ $fab = "fab fa-youtube"; break; }
              case "flickr":{ $fab = "fab fa-flickr"; break; }
              case "instagram":{ $fab = "fab fa-instagram"; break; }
              case "skype":{ $fab = "fab fa-skype"; break; }
              case "dribbble":{ $fab = "fab fa-dribbble"; break; }
              case "500px":{ $fab = "fab fa-500px"; break; }
              case "blogger":{ $fab = "fab fa-blogger-b"; break; }
              case "github":{ $fab = "fab fa-github"; break; }
              case "rss":{ $fab = "fas fa-rss"; break; }
              case "email":{ $fab = "fas fa-envelope"; break; }
            }
            ?>
            <a href="<?=$v?>" target="_blank" class="gsci-icon-item-link" title="<?=ucfirst( $platform )?>">
              <?php
              if( $bg !== "" ){ ?>
                <span class="gsci-icon-item-wrapper fa-stack fa-xs">
                  <i class="fas fa-<?=$bg?> fa-stack-2x"></i>
                  <i class="gsci-icon-item <?=$fab?> fa-stack-1x fa-inverse"></i>
                </span>
                <?php
              } else {
              ?>
              <i class="<?=$fab?>"></i>
            <?php } ?>
            </a>
            <?php
          }
        }
        ?>
        </div>
      </div>
    </div>
    <?php
  	$buffer =  ob_get_clean();

    // We have to minimize the HTML because otherwise
    // line breaks are rendered incorrectly in widgets
    $buffer = preg_replace( $search, $replace, $buffer );
    return $buffer;
  }

	/**
	 * Returns a response container to assure uniform response arrays
	 *
	 * @since    1.0.0
	 */
	public static function gsci_canadensis_response_container() {
		$response = array(
			"error" => false,
			"message" => array(),
			"content" => array()
		);
		return $response;
	}
}
