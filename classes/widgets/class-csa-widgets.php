<?php

/**
 * Widget for displaying a list of specified links with icons
 * @class GSCI_Featured_Links_Redux
 */

if ( ! class_exists( 'GSCI_Featured_Links_Redux' ) ) {
  class GSCI_Featured_Links_Redux extends WP_Widget
  {
    private $version;
    public static $_instance;

    static function init(){
      if ( !self::$_instance ) {
        self::$_instance = new self();
      }
      return self::$_instance;
    }

    public function __construct(){
      parent::__construct(
        'GSCI_Featured_Links_Redux', // Base ID
        __('GSCI Featured Links', 'canadensis-wm'), // Name
        array( 'classname' => 'featured-links-widget', 'description' =>__('Displays list of featured links in the sidebar w/ icons.', 'canadensis-wm'), ) // Args
      );
    }

    public function form( $instance ){
      // Get variables
      $instance = wp_parse_args( ( array ) $instance, array( 'heading' => '' ) );
      $heading = ( ( array_key_exists( 'heading', $instance ) )? $instance[ 'heading' ] : NULL );
      $title = ( ( array_key_exists( 'title', $instance ) )? $instance[ 'title' ] : NULL );
      $desc = ( ( array_key_exists( 'desc', $instance ) )? $instance[ 'desc' ] : NULL );
      $url = ( ( array_key_exists( 'url', $instance ) )? $instance[ 'url' ] : NULL );
      $icon = ( ( array_key_exists( 'icon', $instance ) )? $instance[ 'icon' ] : NULL );
      ?>
      <div class="field-wrapper">
        <label for="<?php echo esc_attr( $this->get_field_id( 'heading' ) ); ?>"><?php _e( 'Heading', 'canadensis-lindstrom' ); ?>
          <input class="upcoming gsci-featured-links text-field link-heading" id="<?php echo esc_attr( $this->get_field_id( 'heading' ) ); ?>" size='40' name="<?php echo esc_attr( $this->get_field_name( 'heading' ) ); ?>" type="text" value="<?php echo esc_attr( $heading ); ?>" />
        </label>
      </div>
      <!-- Begin Links -->
      <div id="gsci-featured-links-wrapper" class="gsci-admin gsci-featured-link-wrapper">
        <?php
        if( count( $url ) > 0 ){
          $i=0;
          foreach( $url as $item ){
        ?>
        <fieldset id="gsci-featured-link|<?=$i+1?>" class="gsci-admin gsci-featured-link" data-link-number="<?=$i+1?>">
          <legend>
            Link <?=$i+1?>
            <span>
              <i id="gsci-remove-link-<?=$i+1?>" class="gsci-remove-link dashicons dashicons-dismiss"></i>
            </span>
            <span>
              <i id="gsci-up-link-<?=$i+1?>" class="gsci-up-link dashicons dashicons-arrow-up-alt2"></i>
            </span>
            <span>
              <i id="gsci-down-link-<?=$i+1?>" class="gsci-down-link dashicons dashicons-arrow-down-alt2"></i>
            </span>
          </legend>
          <div class="field-wrapper title-wrap">
            <label for="<?php echo esc_attr( $this->get_field_id( 'title' ) ); ?>-<?=$i+1?>"><?php _e( 'Title', 'canadensis-as' ); ?>
              <input class="upcoming" id="<?php echo esc_attr( $this->get_field_id( 'title' ) ); ?>-<?=$i+1?>" size='40' name="<?php echo esc_attr( $this->get_field_name( 'title' ) ); ?>[]" type="text" value="<?php echo esc_attr( $title[ $i ] ); ?>" />
            </label>
          </div>
          <div class="field-wrapper desc-wrap">
            <label for="<?php echo esc_attr( $this->get_field_id( 'desc' ) ); ?>-<?=$i+1?>"><?php _e( 'Desc.', 'canadensis-as' ); ?>
              <input class="upcoming" id="<?php echo esc_attr( $this->get_field_id( 'desc' ) ); ?>-<?=$i+1?>" size='40' name="<?php echo esc_attr( $this->get_field_name( 'desc' ) ); ?>[]" type="text" value="<?php echo esc_attr( $desc[ $i ] ); ?>" />
            </label>
          </div>
          <div class="field-wrapper url-wrap">
            <label for="<?php echo esc_attr( $this->get_field_id( 'url' ) ); ?>-<?=$i+1?>"><?php _e( 'URL', 'canadensis-as' ); ?>
              <input class="upcoming" id="<?php echo esc_attr( $this->get_field_id( 'url' ) ); ?>-<?=$i+1?>" size='40' name="<?php echo esc_attr( $this->get_field_name( 'url' ) ); ?>[]" type="text" value="<?php echo esc_attr( $url[ $i ] ); ?>" />
            </label>
          </div>
          <div class="field-wrapper icon-wrap">
            <label for="<?php echo esc_attr( $this->get_field_id( 'icon' ) ); ?>-<?=$i+1?>"><?php _e( 'Icon', 'canadensis-as' ); ?>
              <input class="upcoming" id="<?php echo esc_attr( $this->get_field_id( 'icon' ) ); ?>-<?=$i+1?>" size='40' name="<?php echo esc_attr( $this->get_field_name( 'icon' ) ); ?>[]" type="text" value="<?php echo esc_attr( $icon[ $i ] ); ?>" />
            </label>
          </div>
        </fieldset>
        <?php
            $i++;
          }
        }
        ?>
      </div>
      <div class="gsci-admin button-bar">
        <input type="button" id="gsci-add-link" name="gsci-add-link" class="gsci-featured-links form-button" title="Add Link" value="+" />
      </div>
      <?php
    }

    public function update( $new_instance, $old_instance )
    {
      $instance = $old_instance;
      $instance['heading'] = $new_instance['heading'];
      // Links array
      $instance['title'] = $new_instance['title'];
      $instance['desc'] = $new_instance['desc'];
      $instance['url'] = $new_instance['url'];
      $instance['icon'] = $new_instance['icon'];

      return $instance;
    }

    public function widget( $args, $instance )
    {
      extract( $args, EXTR_SKIP );
      $tl = 6;
      $heading = ( ( empty( $instance[ 'heading' ] ) )? '' : apply_filters( 'widget_title', $instance[ 'heading' ] ) );
      $heading = htmlspecialchars_decode( stripslashes( $heading ) );
      // Get other variables
      $title = ( ( array_key_exists( "title", $instance ) )? $instance[ "title" ] : array() );
      $desc = ( ( array_key_exists( "desc", $instance ) )? $instance[ "desc" ] : array() );
      $url = ( ( array_key_exists( "url", $instance ) )? $instance[ "url" ] : array() );
      $icon = ( ( array_key_exists( "icon", $instance ) )? $instance[ "icon" ] : array() );

      ob_start();
      echo $args['before_widget'];
      /*echo "<pre>";
      print_r( $instance );
      echo "</pre>";*/
  		if ( !empty( $instance[ 'heading' ] ) ) {
  			echo $args['before_title'] . $instance[ 'heading' ] . $args['after_title'];
  		}
      if( count( $url ) > 0 ){ ?>
        <div class="gsci-featured-links link-wrapper">
        <?php
        for( $i=0; $i<count( $url ); $i++ ){
          ?>
          <a href="<?=$url[ $i ]?>" class="outter-link" target="self">
            <div class="item-wrapper">
              <div class="item-icon-wrapper"><i class="<?=$icon[ $i ]?>"></i></div>
              <div class="item-text-wrapper">
                <div class="item-title"><?=$title[ $i ]?></div>
                <?php if( $desc[ $i ] != "" ){ ?>
                <div class="item-description"><?=$desc[ $i ]?></div>
                <?php } ?>
              </div>
            </div>
          </a>
          <?php
        }
        ?>
        </div>
        <?php
      }
      echo $args['after_widget'];
      $buffer =  ob_get_clean();
      echo $buffer;
    }
  }
}
$fl_callback = function(){ return register_widget( "GSCI_Featured_Links_Redux" ); };
add_action( 'widgets_init', $fl_callback );

/**
 * Widget for displaying a list of recent articles with featured images
 * @class GSCI_Latest_Articles
 */

if (! class_exists('GSCI_Latest_Articles')) {
  class GSCI_Latest_Articles extends WP_Widget{
    private $version;
    public static $_instance;

    static function init(){
      if ( !self::$_instance ) {
        self::$_instance = new self();
      }
      return self::$_instance;
    }

    public function __construct(){
      parent::__construct(
        'GSCI_Latest_Articles', // Base ID
        __('GSCI Latest Articles', 'canadensis-wm'), // Name
        array( 'classname' => 'latest_articles_widget', 'description' =>__( 'Displays a specified number of recent posts in descending date order with thumbnail.', 'canadensis-wm' ), ) // Args
      );
    }

    public function form( $instance ){
      $instance = wp_parse_args( ( array ) $instance, array( 'title' => '' ) );
      $title = ( ( array_key_exists( 'title', $instance ) )? $instance[ 'title' ] : NULL );
      $postnum = ( ( array_key_exists( 'postnum', $instance ) )? $instance[ 'postnum' ] : NULL );

      ?>
      <!-- Title -->
      <p>
        <label for="<?php echo esc_attr($this->get_field_id('title')); ?>"><?php _e('Title', 'canadensis-ajp'); ?>
          <input class="upcoming" id="<?php echo esc_attr($this->get_field_id('title')); ?>" size='40' name="<?php echo esc_attr($this->get_field_name('title')); ?>" type="text" value="<?php echo esc_attr( $title ); ?>" />
          <i>Title is not displayed: only for admin UI</i>
        </label>
      </p>
      <div style="display:table; width:100%; height:100%; position:relative;">
        <hr style="display: table-cell; text-align: center; vertical-align: middle; width:auto; height:auto;">
      </div><br/>
      <!-- Number of Posts -->
      <div class="gsci-admin-fields post-num">
        <label for="<?php echo esc_attr($this->get_field_id('postnum')); ?>">Number of Posts to Display<br/>
          <input type="number" id="<?php echo esc_attr($this->get_field_id('postnum')); ?>" style="width:50px;" name="<?php echo esc_attr($this->get_field_name('postnum')); ?>" value="<?php echo esc_attr( $postnum ); ?>" />
        </label>
      </div><br/>

      <?php
    }

    public function update($new_instance, $old_instance){
      $instance = $old_instance;
      $instance[ 'title' ] = $new_instance[ 'title' ];
      $instance[ 'postnum' ] = $new_instance[ 'postnum' ];

      return $instance;
    }

    public function widget($args, $instance){
      extract($args, EXTR_SKIP);
      $tl = 6;
      $title = empty( $instance[ 'title' ] ) ? '' : apply_filters( 'widget_title', $instance[ 'title' ] );
      $title = htmlspecialchars_decode( stripslashes( $title ) );
      $postnum = ( ( array_key_exists( 'postnum', $instance ) )? $instance[ 'postnum' ] : NULL );

      $arguments = array(
        'post_type' => 'post',
    		'posts_per_page' => $postnum,
        'orderby' => array(
          'date' => 'DESC',
        )
    	);
      $post_query = new WP_Query();
    	$all_wp_posts = $post_query->query( $arguments );
      // Render
      ob_start();
      echo $args['before_widget'];

  		if ( !empty( $instance[ 'title' ] ) ) {
  			echo $args['before_title'] . $instance[ 'title' ] . $args['after_title'];
  		}
      if( $postnum ){
        foreach( $all_wp_posts as $post ){
          $title = $post->post_title;
          $link = get_permalink( $post->ID );
          $thumb = get_the_post_thumbnail_url( $post->ID, array( 150,150 ) );
          $thumb = ( ( $thumb == false )? 'https://via.placeholder.com/150?text=A.J.+Perri' : $thumb );
        ?>
        <div class="gsci-blog-articles latest-articles">
          <div class="blog-article">
            <div class="blog-thumb">
              <a href="<?=$link?>" target="self"><img src="<?=$thumb?>" border="0"></a>
            </div>
            <div class="blog-title">
              <a href="<?=$link?>" target="self"><?=$title?></a>
            </div>
          </div>
        </div>
        <?php
        }
      }
      echo $args['after_widget'];
      $buffer =  ob_get_clean();
      echo $buffer;
    }
  }
}
$la_callback = function(){ return register_widget("GSCI_Latest_Articles"); };
add_action('widgets_init', $la_callback );

/**
 * Widget for displaying a Wufoo form via API
 * @class GSCI_Wufoo_Form
 */

if (! class_exists('GSCI_Wufoo_Form')) {
  class GSCI_Wufoo_Form extends WP_Widget{
    private $version;
    public static $_instance;

    static function init(){
      if ( !self::$_instance ) {
        self::$_instance = new self();
      }
      return self::$_instance;
    }

    public function __construct(){
      parent::__construct(
        'GSCI_Wufoo_Form', // Base ID
        __('GSCI Wufoo Form', 'canadensis-wm'), // Name
        array( 'classname' => 'wufoo_form_widget', 'description' =>__( 'Displays a Wufoo form using the API', 'canadensis-wm' ), ) // Args
      );
    }

    public function form( $instance ){
      // Get variables
      $instance = wp_parse_args( ( array ) $instance, array( 'heading' => '' ) );
      $wfwid = ( ( array_key_exists( 'wfwid', $instance ) )? $instance[ 'wfwid' ] : md5( uniqid( rand(), true ) ) );
      $heading = ( ( array_key_exists( 'heading', $instance ) )? $instance[ 'heading' ] : NULL );
      $formid = ( ( array_key_exists( 'formid', $instance ) )? $instance[ 'formid' ] : NULL );
      $submitid = ( ( array_key_exists( 'submitid', $instance ) )? $instance[ 'submitid' ] : NULL );
      $formclass = ( ( array_key_exists( 'formclass', $instance ) )? $instance[ 'formclass' ] : NULL );
      $fmfieldincludeph = ( ( array_key_exists( 'fmfieldincludeph', $instance ) )? $instance[ 'fmfieldincludeph' ] : NULL );
      ?>
      <div class="field-wrapper">
        <label for="<?php echo esc_attr( $this->get_field_id( 'heading' ) ); ?>"><?php _e( 'Heading', 'canadensis-lindstrom' ); ?>
          <input class="upcoming gsci-featured-links text-field link-heading" id="<?php echo esc_attr( $this->get_field_id( 'heading' ) ); ?>-<?=$wfwid?>" size='40' name="<?php echo esc_attr( $this->get_field_name( 'heading' ) ); ?>" type="text" value="<?php echo esc_attr( $heading ); ?>" />
        </label>
      </div>
      <!-- Begin Links -->
      <div class="field-wrapper formid-wrap">
        <label for="<?php echo esc_attr( $this->get_field_id( 'formid' ) ); ?>-<?=$wfwid?>"><?php _e( 'Form ID', 'canadensis-wm' ); ?>
          <input type="text" id="<?php echo esc_attr( $this->get_field_id( 'formid' ) ); ?>-<?=$wfwid?>" size='40' name="<?php echo esc_attr( $this->get_field_name( 'formid' ) ); ?>" class="gsci-wufoo-form form-field" value="<?php echo esc_attr( $formid ); ?>" />
        </label>
      </div>
      <div class="field-wrapper submitid-wrap">
        <label for="<?php echo esc_attr( $this->get_field_id( 'submitid' ) ); ?>-<?=$wfwid?>"><?php _e( 'Submit ID', 'canadensis-wm' ); ?>
          <input type="text" id="<?php echo esc_attr( $this->get_field_id( 'submitid' ) ); ?>-<?=$wfwid?>" size='40' name="<?php echo esc_attr( $this->get_field_name( 'submitid' ) ); ?>" class="gsci-wufoo-form form-field" value="<?php echo esc_attr( $submitid ); ?>" />
        </label>
      </div>
      <div class="field-wrapper formclass-wrap">
        <label for="<?php echo esc_attr( $this->get_field_id( 'formclass' ) ); ?>-<?=$wfwid?>"><?php _e( 'Form Class', 'canadensis-wm' ); ?>
          <input type="text" id="<?php echo esc_attr( $this->get_field_id( 'formclass' ) ); ?>-<?=$wfwid?>" size='40' name="<?php echo esc_attr( $this->get_field_name( 'formclass' ) ); ?>" class="gsci-wufoo-form form-field" value="<?php echo esc_attr( $formclass ); ?>" />
        </label>
      </div>
      <div class="field-wrapper includeph-wrap">
        <label for="<?php echo esc_attr( $this->get_field_id( 'fmfieldincludeph' ) ); ?>-<?=$wfwid?>"><?php _e( 'Include Placeholder Text?', 'canadensis-wm' ); ?>
          <select id="<?php echo esc_attr( $this->get_field_id( 'fmfieldincludeph' ) ); ?>-<?=$wfwid?>" name="<?php echo esc_attr( $this->get_field_name( 'fmfieldincludeph' ) ); ?>" class="gsci-wufoo-form form-select">
            <option value="yes"<?php echo ( ( esc_attr( $fmfieldincludeph ) == "yes" )? "selected" : "" ) ?>>Yes</option>
            <option value="no"<?php echo ( ( esc_attr( $fmfieldincludeph ) == "no" )? "selected" : "" ) ?>>No</option>
          </select>
        </label>
      </div>
      <input type="hidden" id="<?php echo esc_attr( $this->get_field_id( 'wfwid' ) ); ?>-<?=$wfwid?>" size='40' name="<?php echo esc_attr( $this->get_field_name( 'wfwid' ) ); ?>" value="<?php echo esc_attr( $wfwid ); ?>" />
      <?php
    }

    public function update($new_instance, $old_instance){
      $instance = $old_instance;
      $instance[ 'wfwid' ] = $new_instance[ 'wfwid' ];
      $instance[ 'heading' ] = $new_instance[ 'heading' ];
      $instance[ 'formid' ] = $new_instance[ 'formid' ];
      $instance[ 'submitid' ] = $new_instance[ 'submitid' ];
      $instance[ 'formclass' ] = $new_instance[ 'formclass' ];
      $instance[ 'fmfieldincludeph' ] = $new_instance[ 'fmfieldincludeph' ];

      return $instance;
    }

    public function widget($args, $instance){
      extract($args, EXTR_SKIP);
      $heading = ( ( empty( $instance[ 'heading' ] ) )? '' : apply_filters( 'widget_title', $instance[ 'heading' ] ) );
      $heading = htmlspecialchars_decode( stripslashes( $heading ) );
      // Get other variables
      $wfwid = ( ( array_key_exists( 'wfwid', $instance ) )? $instance[ 'wfwid' ] : md5( uniqid( rand(), true ) ) );
      $formid = ( ( array_key_exists( 'formid', $instance ) )? $instance[ 'formid' ] : NULL );
      $submitid = ( ( array_key_exists( 'submitid', $instance ) )? $instance[ 'submitid' ] : NULL );
      $formclass = ( ( array_key_exists( 'formclass', $instance ) )? $instance[ 'formclass' ] : NULL );
      $fmfieldincludeph = ( ( array_key_exists( 'fmfieldincludeph', $instance ) )? $instance[ 'fmfieldincludeph' ] : NULL );
      $form = "";
      $return = "";
      if( $formid ){
        $curl = "https://cornerstonead.wufoo.com/api/v3/forms/".$formid.".json";
        $u = "QZ1T-NAPG-D79N-H14Y";
        $p = "Af-fZHLPDA2TjUeF";
        $up = $u.':'.$p;
        $return = $this->fetch_data( $curl, $up );
        $form = ( ( array_key_exists( "Forms", $return ) )? ( ( array_key_exists( 0, $return[ "Forms" ] ) )? $return[ "Forms" ][ 0 ] : NULL ) : NULL );
        $fieldsreturn = "";
        if( $form ){
          $furl = ( ( array_key_exists( "LinkFields", $form ) )? $form[ "LinkFields" ] : NULL );
          $fields = $this->fetch_data( $furl, $up );
          $fields = ( ( array_key_exists( "Fields", $fields ) )? $fields[ "Fields" ] : NULL );
          $form[ "fields" ] = $fields;
        }
      }
      $response = $form;

      // Render
      ob_start();
      echo $args['before_widget'];
      if ( !empty( $instance[ 'heading' ] ) ) {
  			echo $args['before_title'] . $instance[ 'heading' ] . $args['after_title'];
  		}
      ?>
      <form id="form-<?=$response[ "Hash" ]?>" name="form-<?=$response[ "Hash" ]?>" class="wufoo gsci_form form_wufoo" accept-charset="UTF-8" autocomplete="off" enctype="multipart/form-data" method="post" novalidate="" action="https://cornerstonead.wufoo.com/forms/<?=$formid?>/">
        <ul class="gsci_form_wrapper">
          <?php
          $i = 0;
          // Iterate through each field and render it
          foreach( $response[ "fields" ] as $field ){
            if( array_key_exists( "ClassNames", $field ) === true ){
          ?>
          <li id="label-<?=$field[ "ID" ]?>" class="gsci_field_item <?=$field[ "Type" ]?> <?=$field[ "ClassNames" ]?>">
            <label class="desc" id="title<?=$i?>" for="<?=$field[ "ID" ]?>">
              <?=$field[ "Title" ]?><?php if( $field[ "IsRequired" ] == 1 ){ ?><span id="req_<?=$i?>" class="req">*</span><?php } ?>
            </label>
            <div class="field_wrapper">
              <?php
              $required = ( ( $field[ "IsRequired" ] == 1 )? "*" : "" );
              $isrequired = ( ( $field[ "IsRequired" ] == 1 )? "required" : "" );
              switch( $field[ "Type" ] ){
                case "text":
                case "password":
                case "email":
                case "color":
                case "file":
                case "number":
                case "url":{
                  $ph = ( ( $fmfieldincludeph == "yes" )? $field[ 'Title' ].$required : "" );
                  echo "<input id=\"".$field[ 'ID' ]."\" name=\"".$field[ 'ID' ]."\" type=\"".$field[ 'Type' ]."\" class=\"\" value=\"\" tabindex=\"1\" ".$isrequired." placeholder=\"".$ph."\">";
                  break;
                }
                case "textarea":{
                  $ph = ( ( $fmfieldincludeph == "yes" )? $field[ 'Title' ].$required : "" );
                  echo "<textarea id=\"".$field[ 'ID' ]."\" name=\"".$field[ 'ID' ]."\" class=\"\" value=\"\" rows=\"4\" tabindex=\"1\" ".$isrequired." placeholder=\"".$ph."\"></textarea>";
                  break;
                }
                case "select":{
                  $selectfield = "<select id=\"".$field[ 'ID' ]."\" name=\"".$field[ 'ID' ]."\" class=\"\" value=\"\" tabindex=\"1\" ".$isrequired.">";
                  foreach( $field[ 'Choices' ] as $item ){
                    $option = ( ( array_key_exists( "Label", $item ) )? $item[ 'Label' ] : NULL );
                    $selectfield .= ( ( $option )? "<option value=".$option.">".$option."</option>" : "" );
                  }
                  $selectfield .= "</select>";
                  echo $selectfield;
                  break;
                }
                case "checkbox":{
                  $subfields = ( ( array_key_exists( "SubFields", $field ) )? $field[ "SubFields" ] : NULL );
                  echo "<div class=\"gsci_form field_type ".$field[ 'Type' ]."\">";
                  foreach( $subfields as $item ){
                    $itemid = ( ( array_key_exists( "ID", $item ) )? $item[ "ID" ] : NULL );
                    $itemlabel = ( ( array_key_exists( "Label", $item ) )? $item[ "Label" ] : NULL );
                    $itemval = ( ( array_key_exists( "DefaultVal", $item ) )? $item[ "DefaultVal" ] : NULL );
                    echo "<div class=\"option_block\">";
                    echo "<input id=\"".$itemid."\" name=\"".$itemid."\" type=\"checkbox\" class=\"\" value=\"".$itemval."\" tabindex=\"1\"><label for=\"\">".$itemlabel."</label>";
                    echo "</div>";
                  }
                  echo "</div>";
                  break;
                }
                case "radio":{
                  $choices = ( ( array_key_exists( "Choices", $field ) )? $field[ "Choices" ] : NULL );
                  echo "<div class=\"gsci_form field_type ".$field[ 'Type' ]."\">";
                  $i=0;
                  foreach( $choices as $item ){
                    $itemlabel = ( ( array_key_exists( "Label", $item ) )? $item[ "Label" ] : NULL );
                    echo "<div class=\"option_block\">";
                    echo "<input id=\"".$field[ 'ID' ]."_".$i."\" name=\"".$field[ 'ID' ]."\" type=\"radio\" class=\"\" value=\"".$itemlabel."\" tabindex=\"1\"><label for=\"\">".$itemlabel."</label>";
                    echo "</div>";
                    $i++;
                  }
                  echo "</div>";
                  break;
                }
                case "shortname":{
                  $subfields = ( ( array_key_exists( "SubFields", $field ) )? $field[ "SubFields" ] : NULL );
                  $firstname = ( ( array_key_exists( 0, $subfields ) )? $subfields[ 0 ] : NULL );
                  $fid = ( ( array_key_exists( "ID", $firstname ) )? $firstname[ "ID" ] : NULL );
                  $flabel = ( ( array_key_exists( "Label", $firstname ) )? $firstname[ "Label" ] : NULL );
                  $fph = ( ( $fmfieldincludeph == "yes" )? $flabel.$required : "" );
                  $lastname = ( ( array_key_exists( 1, $subfields ) )? $subfields[ 1 ] : NULL );
                  $lid = ( ( array_key_exists( "ID", $lastname ) )? $lastname[ "ID" ] : NULL );
                  $llabel = ( ( array_key_exists( "Label", $lastname ) )? $lastname[ "Label" ] : NULL );
                  $lph = ( ( $fmfieldincludeph == "yes" )? $llabel.$required : "" );
                  echo "<div class=\"gsci_form field_type ".$field[ 'Type' ]."\">";
                  echo "<input id=\"".$fid."\" name=\"".$fid."\" type=\"text\" class=\"first\" value=\"\" tabindex=\"1\" ".$isrequired." placeholder=\"".$fph."\">";
                  echo "<input id=\"".$lid."\" name=\"".$lid."\" type=\"text\" class=\"last\" value=\"\" tabindex=\"1\" ".$isrequired." placeholder=\"".$lph."\">";
                  echo "</div>";
                  break;
                }
                case "phone":{
                  $acph = ( ( $fmfieldincludeph == "yes" )? "###" : "" );
                  $pph = ( ( $fmfieldincludeph == "yes" )? "###" : "" );
                  $lnph = ( ( $fmfieldincludeph == "yes" )? "####" : "" );
                  echo "<div class=\"gsci_form field_type ".$field[ 'Type' ]."\">";
                  echo "<input id=\"".$field[ 'ID' ]."\" name=\"".$field[ 'ID' ]."\" type=\"tel\" class=\"area_code\" value=\"\" tabindex=\"1\" ".$isrequired." placeholder=\"".$acph."\" maxlength=\"3\">";
                  echo "<span class=\"breaker\">-</span>";
                  echo "<input id=\"".$field[ 'ID' ]."-1\" name=\"".$field[ 'ID' ]."-1\" type=\"tel\" class=\"prefix\" value=\"\" tabindex=\"1\" ".$isrequired." placeholder=\"".$pph."\" maxlength=\"3\">";
                  echo "<span class=\"breaker\">-</span>";
                  echo "<input id=\"".$field[ 'ID' ]."-2\" name=\"".$field[ 'ID' ]."-2\" type=\"tel\" class=\"line_number\" value=\"\" tabindex=\"1\" ".$isrequired." placeholder=\"".$lnph."\" maxlength=\"4\">";
                  echo "</div>";
                  break;
                }
                case "address":{
                  $subfields = ( ( array_key_exists( "SubFields", $field ) )? $field[ "SubFields" ] : NULL );

                  $street1 = ( ( array_key_exists( 0, $subfields ) )? $subfields[ 0 ] : NULL );
                  $s1id = ( ( array_key_exists( "ID", $street1 ) )? $street1[ "ID" ] : NULL );
                  $s1label = ( ( array_key_exists( "Label", $street1 ) )? $street1[ "Label" ] : NULL );
                  $s1ph = ( ( $fmfieldincludeph == "yes" )? $s1label.$required : "" );
                  $street2 = ( ( array_key_exists( 1, $subfields ) )? $subfields[ 1 ] : NULL );
                  $s2id = ( ( array_key_exists( "ID", $street2 ) )? $street2[ "ID" ] : NULL );
                  $s2label = ( ( array_key_exists( "Label", $street2 ) )? $street2[ "Label" ] : NULL );
                  $s2ph = ( ( $fmfieldincludeph == "yes" )? $s2label : "" );
                  $city = ( ( array_key_exists( 2, $subfields ) )? $subfields[ 2 ] : NULL );
                  $cityid = ( ( array_key_exists( "ID", $city ) )? $city[ "ID" ] : NULL );
                  $citylabel = ( ( array_key_exists( "Label", $city ) )? $city[ "Label" ] : NULL );
                  $cityph = ( ( $fmfieldincludeph == "yes" )? $citylabel.$required : "" );
                  $state = ( ( array_key_exists( 3, $subfields ) )? $subfields[ 3 ] : NULL );
                  $stateid = ( ( array_key_exists( "ID", $state ) )? $state[ "ID" ] : NULL );
                  $statelabel = ( ( array_key_exists( "Label", $state ) )? $state[ "Label" ] : NULL );
                  $stateph = ( ( $fmfieldincludeph == "yes" )? $statelabel.$required : "" );
                  $zip = ( ( array_key_exists( 4, $subfields ) )? $subfields[ 4 ] : NULL );
                  $zid = ( ( array_key_exists( "ID", $zip ) )? $zip[ "ID" ] : NULL );
                  $zlabel = ( ( array_key_exists( "Label", $zip ) )? $zip[ "Label" ] : NULL );
                  $zph = ( ( $fmfieldincludeph == "yes" )? $zlabel.$required : "" );
                  $country = ( ( array_key_exists( 5, $subfields ) )? $subfields[ 5 ] : NULL );
                  $countryid = ( ( array_key_exists( "ID", $country ) )? $country[ "ID" ] : NULL );
                  $countrylabel = ( ( array_key_exists( "Label", $country ) )? $country[ "Label" ] : NULL );

                  echo "<div class=\"gsci_form field_type ".$field[ 'Type' ]."\">";
                  echo "<div class=\"address_line\">";
                  echo "<input id=\"".$s1id."\" name=\"".$s1id."\" type=\"text\" class=\"street1\" value=\"\" tabindex=\"1\" ".$isrequired." placeholder=\"".$s1ph."\">";
                  echo "</div>";
                  echo "<div class=\"address_line\">";
                  echo "<input id=\"".$s2id."\" name=\"".$s2id."\" type=\"text\" class=\"street2\" value=\"\" tabindex=\"1\" placeholder=\"".$s2ph."\">";
                  echo "</div>";
                  echo "<div class=\"address_line\">";
                  echo "<input id=\"".$cityid."\" name=\"".$cityid."\" type=\"text\" class=\"city\" value=\"\" tabindex=\"1\" ".$isrequired." placeholder=\"".$cityph."\">";
                  echo "<input id=\"".$stateid."\" name=\"".$stateid."\" type=\"text\" class=\"state\" value=\"\" tabindex=\"1\" ".$isrequired." placeholder=\"".$stateph."\">";
                  echo "</div>";
                  echo "<div class=\"address_line\">";
                  echo "<input id=\"".$zid."\" name=\"".$zid."\" type=\"text\" class=\"zip\" value=\"\" tabindex=\"1\" ".$isrequired." placeholder=\"".$zph."\">";
                  echo "<select id=\"".$countryid."\" name=\"".$countryid."\" class=\"country\" value=\"\" tabindex=\"1\" ".$isrequired.">";
                  echo "<option value=\"United States\">United States</option>"; // Country options not returned by API; Need to revisit
                  echo "</select>";
                  echo "</div>";
                  echo "</div>";
                  break;
                }
                case "date":{
                  $mcph = ( ( $fmfieldincludeph == "yes" )? "MM" : "" );
                  $dph = ( ( $fmfieldincludeph == "yes" )? "DD" : "" );
                  $yph = ( ( $fmfieldincludeph == "yes" )? "YYYY" : "" );
                  echo "<div class=\"gsci_form field_type ".$field[ 'Type' ]."\">";
                  echo "<input id=\"".$field[ 'ID' ]."-1\" name=\"".$field[ 'ID' ]."-1\" type=\"text\" class=\"gsci-month\" value=\"\" size=\"2\" tabindex=\"1\" ".$isrequired." placeholder=\"".$mcph."\" maxlength=\"2\" />";
                  echo "<span class=\"symbol\">/</span>";
                  echo "<input id=\"".$field[ 'ID' ]."-2\" name=\"".$field[ 'ID' ]."-2\" type=\"text\" class=\"gsci-day\" value=\"\" size=\"2\" tabindex=\"1\" ".$isrequired." placeholder=\"".$dph."\" maxlength=\"2\" />";
                  echo "<span class=\"symbol\">/</span>";
                  echo "<input id=\"".$field[ 'ID' ]."\" name=\"".$field[ 'ID' ]."\" type=\"text\" class=\"gsci-year\" value=\"\" size=\"4\" tabindex=\"1\" ".$isrequired." placeholder=\"".$yph."\" maxlength=\"4\" />";
                  echo "</div>";
                }
                case "time":{
                  $subfields = ( ( array_key_exists( "SubFields", $field ) )? $field[ "SubFields" ] : NULL );

                  echo "<div class=\"gsci_form field_type ".$field[ 'Type' ]."\">";
                  echo "</div>";
                }
              } ?>
            </div>
          </li>
          <?php
            }
            $i++;
          }
          ?>
          <li class="buttons ">
            <div class="buttons_wrapper">
              <input type="submit" id="saveForm" name="saveForm" class="button_submit" tabindex="1" value="Submit">
            </div>
          </li>
          <li class="gsci_form_post_content hide">
            <label for="comment">Do Not Fill This Out</label>
            <textarea name="comment" id="comment" rows="1" cols="1"></textarea>
            <input type="hidden" id="idstamp" name="idstamp" value="<?=$submitid?>">
          </li>
        </ul>
      </form>
      <script>
        ( function( $ ) {
          $(".wufoo.gsci_form li.gsci_wca input").val( typeof wca == "undefined" ? "" : wca.toString() );
          $(".wufoo.gsci_form li.gsci-ref input").val( typeof gsci == "undefined" ? "" : gsci.toString() );
          $( ".wufoo.gsci_form ul.gsci_form_wrapper li.gsci_field_item .field_wrapper .gsci_form.field_type.date .gsci-year" ).datepicker( {
            showOn:"button",
            buttonText: "<i class='gsci-cal dashicons dashicons-calendar-alt'></i>",
            onSelect: function( dtext, dob ){
              var monthnum = dob.selectedMonth+1;
              var themonth = ( monthnum.toString().length == 1 )? "0"+monthnum.toString() : monthnum.toString();
              var theday = ( dob.selectedDay.toString().length == 1 )? "0"+dob.selectedDay.toString() : dob.selectedDay.toString();
              $( ".wufoo.gsci_form ul.gsci_form_wrapper li.gsci_field_item .field_wrapper .gsci_form.field_type.date .gsci-month" ).val( themonth );
              $( ".wufoo.gsci_form ul.gsci_form_wrapper li.gsci_field_item .field_wrapper .gsci_form.field_type.date .gsci-day" ).val( theday );
              $( ".wufoo.gsci_form ul.gsci_form_wrapper li.gsci_field_item .field_wrapper .gsci_form.field_type.date .gsci-year" ).val( dob.selectedYear );
            }
          } );
        } )( jQuery );
      </script>
      <?php
      echo $args['after_widget'];
      $buffer =  ob_get_clean();
      echo $buffer;
    }

    public static function fetch_data( $url, $up=NULL ){
      $ch = curl_init();
      curl_setopt( $ch, CURLOPT_CONNECTTIMEOUT, 0 );
      curl_setopt( $ch, CURLOPT_FAILONERROR, true );
      curl_setopt( $ch, CURLOPT_FOLLOWLOCATION, true );
      curl_setopt( $ch, CURLOPT_HEADER, false );
      curl_setopt( $ch, CURLOPT_HTTPAUTH, CURLAUTH_ANY );
      curl_setopt( $ch, CURLOPT_RETURNTRANSFER, 1 );
      curl_setopt( $ch, CURLOPT_SSL_VERIFYPEER, true );
      curl_setopt( $ch, CURLOPT_SSLVERSION, 1 );
      curl_setopt( $ch, CURLOPT_TIMEOUT, 0 );
      curl_setopt( $ch, CURLOPT_URL, $url );
      curl_setopt( $ch, CURLOPT_USERAGENT, "Form Embed" );
      if( $up ){
        curl_setopt( $ch, CURLOPT_USERPWD, $up );
      }
      if( $return = curl_exec( $ch ) ){
        curl_close( $ch );
        return json_decode( $return, JSON_PRETTY_PRINT );
      } else {
        $return = "Error ".curl_errno( $ch ).": ".curl_error( $ch );
        curl_close( $ch );
        return $return;
      }
    }
  }
}
$wf_callback = function(){ return register_widget( "GSCI_Wufoo_Form" ); };
add_action('widgets_init', $wf_callback );
?>
