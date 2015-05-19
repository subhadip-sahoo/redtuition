<?php
/**
 * Twenty Fifteen functions and definitions
 *
 * Set up the theme and provides some helper functions, which are used in the
 * theme as custom template tags. Others are attached to action and filter
 * hooks in WordPress to change core functionality.
 *
 * When using a child theme you can override certain functions (those wrapped
 * in a function_exists() call) by defining them first in your child theme's
 * functions.php file. The child theme's functions.php file is included before
 * the parent theme's file, so the child theme functions would be used.
 *
 * @link https://codex.wordpress.org/Theme_Development
 * @link https://codex.wordpress.org/Child_Themes
 *
 * Functions that are not pluggable (not wrapped in function_exists()) are
 * instead attached to a filter or action hook.
 *
 * For more information on hooks, actions, and filters,
 * {@link https://codex.wordpress.org/Plugin_API}
 *
 * @package WordPress
 * @subpackage Twenty_Fifteen
 * @since Twenty Fifteen 1.0
 */

/**
 * Set the content width based on the theme's design and stylesheet.
 *
 * @since Twenty Fifteen 1.0
 */
if ( ! isset( $content_width ) ) {
	$content_width = 660;
}

/**
 * Twenty Fifteen only works in WordPress 4.1 or later.
 */
if ( version_compare( $GLOBALS['wp_version'], '4.1-alpha', '<' ) ) {
	require get_template_directory() . '/inc/back-compat.php';
}

if ( ! function_exists( 'twentyfifteen_setup' ) ) :
/**
 * Sets up theme defaults and registers support for various WordPress features.
 *
 * Note that this function is hooked into the after_setup_theme hook, which
 * runs before the init hook. The init hook is too late for some features, such
 * as indicating support for post thumbnails.
 *
 * @since Twenty Fifteen 1.0
 */
function twentyfifteen_setup() {

	/*
	 * Make theme available for translation.
	 * Translations can be filed in the /languages/ directory.
	 * If you're building a theme based on twentyfifteen, use a find and replace
	 * to change 'twentyfifteen' to the name of your theme in all the template files
	 */
	load_theme_textdomain( 'twentyfifteen', get_template_directory() . '/languages' );

	// Add default posts and comments RSS feed links to head.
	add_theme_support( 'automatic-feed-links' );

	/*
	 * Let WordPress manage the document title.
	 * By adding theme support, we declare that this theme does not use a
	 * hard-coded <title> tag in the document head, and expect WordPress to
	 * provide it for us.
	 */
	//add_theme_support( 'title-tag' );

	/*
	 * Enable support for Post Thumbnails on posts and pages.
	 *
	 * See: https://codex.wordpress.org/Function_Reference/add_theme_support#Post_Thumbnails
	 */
	add_theme_support( 'post-thumbnails' );
	set_post_thumbnail_size( 825, 510, true );

	// This theme uses wp_nav_menu() in two locations.
	register_nav_menus( array(
		'primary' => __( 'Primary Menu',      'twentyfifteen' ),
		'social'  => __( 'Social Links Menu', 'twentyfifteen' ),
	) );

	/*
	 * Switch default core markup for search form, comment form, and comments
	 * to output valid HTML5.
	 */
	add_theme_support( 'html5', array(
		'search-form', 'comment-form', 'comment-list', 'gallery', 'caption'
	) );

	/*
	 * Enable support for Post Formats.
	 *
	 * See: https://codex.wordpress.org/Post_Formats
	 */
	add_theme_support( 'post-formats', array(
		'aside', 'image', 'video', 'quote', 'link', 'gallery', 'status', 'audio', 'chat'
	) );

	$color_scheme  = twentyfifteen_get_color_scheme();
	$default_color = trim( $color_scheme[0], '#' );

	// Setup the WordPress core custom background feature.
	add_theme_support( 'custom-background', apply_filters( 'twentyfifteen_custom_background_args', array(
		'default-color'      => $default_color,
		'default-attachment' => 'fixed',
	) ) );

	/*
	 * This theme styles the visual editor to resemble the theme style,
	 * specifically font, colors, icons, and column width.
	 */
	add_editor_style( array( 'css/editor-style.css', 'genericons/genericons.css', twentyfifteen_fonts_url() ) );
}
endif; // twentyfifteen_setup
add_action( 'after_setup_theme', 'twentyfifteen_setup' );

/**
 * Register widget area.
 *
 * @since Twenty Fifteen 1.0
 *
 * @link https://codex.wordpress.org/Function_Reference/register_sidebar
 */
function twentyfifteen_widgets_init() {
	register_sidebar( array(
		'name'          => __( 'Widget Area', 'twentyfifteen' ),
		'id'            => 'sidebar-1',
		'description'   => __( 'Add widgets here to appear in your sidebar.', 'twentyfifteen' ),
		'before_widget' => '<aside id="%1$s" class="widget %2$s">',
		'after_widget'  => '</aside>',
		'before_title'  => '<h2 class="widget-title">',
		'after_title'   => '</h2>',
	) );
        register_sidebar( array(
		'name'          => __( 'Footer Menu widget', 'twentyfifteen' ),
		'id'            => 'sidebar-2',
		'description'   => __( 'Add widgets here to appear in your sidebar.', 'twentyfifteen' ),
		'before_widget' => '',
		'after_widget'  => '',
		'before_title'  => '',
		'after_title'   => '',
	) );
        register_sidebar( array(
		'name'          => __( 'Footer copyright widget', 'twentyfifteen' ),
		'id'            => 'sidebar-3',
		'description'   => __( 'Add widgets here to appear in your sidebar.', 'twentyfifteen' ),
		'before_widget' => '',
		'after_widget'  => '',
		'before_title'  => '',
		'after_title'   => '',
	) );
}
add_action( 'widgets_init', 'twentyfifteen_widgets_init' );

if ( ! function_exists( 'twentyfifteen_fonts_url' ) ) :
/**
 * Register Google fonts for Twenty Fifteen.
 *
 * @since Twenty Fifteen 1.0
 *
 * @return string Google fonts URL for the theme.
 */
function twentyfifteen_fonts_url() {
	$fonts_url = '';
	$fonts     = array();
	$subsets   = 'latin,latin-ext';

	/* translators: If there are characters in your language that are not supported by Noto Sans, translate this to 'off'. Do not translate into your own language. */
	if ( 'off' !== _x( 'on', 'Noto Sans font: on or off', 'twentyfifteen' ) ) {
		$fonts[] = 'Noto Sans:400italic,700italic,400,700';
	}

	/* translators: If there are characters in your language that are not supported by Noto Serif, translate this to 'off'. Do not translate into your own language. */
	if ( 'off' !== _x( 'on', 'Noto Serif font: on or off', 'twentyfifteen' ) ) {
		$fonts[] = 'Noto Serif:400italic,700italic,400,700';
	}

	/* translators: If there are characters in your language that are not supported by Inconsolata, translate this to 'off'. Do not translate into your own language. */
	if ( 'off' !== _x( 'on', 'Inconsolata font: on or off', 'twentyfifteen' ) ) {
		$fonts[] = 'Inconsolata:400,700';
	}

	/* translators: To add an additional character subset specific to your language, translate this to 'greek', 'cyrillic', 'devanagari' or 'vietnamese'. Do not translate into your own language. */
	$subset = _x( 'no-subset', 'Add new subset (greek, cyrillic, devanagari, vietnamese)', 'twentyfifteen' );

	if ( 'cyrillic' == $subset ) {
		$subsets .= ',cyrillic,cyrillic-ext';
	} elseif ( 'greek' == $subset ) {
		$subsets .= ',greek,greek-ext';
	} elseif ( 'devanagari' == $subset ) {
		$subsets .= ',devanagari';
	} elseif ( 'vietnamese' == $subset ) {
		$subsets .= ',vietnamese';
	}

	if ( $fonts ) {
		$fonts_url = add_query_arg( array(
			'family' => urlencode( implode( '|', $fonts ) ),
			'subset' => urlencode( $subsets ),
		), '//fonts.googleapis.com/css' );
	}

	return $fonts_url;
}
endif;

/**
 * Enqueue scripts and styles.
 *
 * @since Twenty Fifteen 1.0
 */
function twentyfifteen_scripts() {
	// Add custom fonts, used in the main stylesheet.
	wp_enqueue_style( 'twentyfifteen-fonts', twentyfifteen_fonts_url(), array(), null );

	// Add Genericons, used in the main stylesheet.
	wp_enqueue_style( 'genericons', get_template_directory_uri() . '/genericons/genericons.css', array(), '3.2' );

	// Load our main stylesheet.
	wp_enqueue_style( 'twentyfifteen-style', get_stylesheet_uri() );

	// Load the Internet Explorer specific stylesheet.
	wp_enqueue_style( 'twentyfifteen-ie', get_template_directory_uri() . '/css/ie.css', array( 'twentyfifteen-style' ), '20141010' );
	wp_style_add_data( 'twentyfifteen-ie', 'conditional', 'lt IE 9' );

	// Load the Internet Explorer 7 specific stylesheet.
	wp_enqueue_style( 'twentyfifteen-ie7', get_template_directory_uri() . '/css/ie7.css', array( 'twentyfifteen-style' ), '20141010' );
	wp_style_add_data( 'twentyfifteen-ie7', 'conditional', 'lt IE 8' );

	wp_enqueue_script( 'twentyfifteen-skip-link-focus-fix', get_template_directory_uri() . '/js/skip-link-focus-fix.js', array(), '20141010', true );

	if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
		wp_enqueue_script( 'comment-reply' );
	}

	if ( is_singular() && wp_attachment_is_image() ) {
		wp_enqueue_script( 'twentyfifteen-keyboard-image-navigation', get_template_directory_uri() . '/js/keyboard-image-navigation.js', array( 'jquery' ), '20141010' );
	}

	wp_enqueue_script( 'twentyfifteen-script', get_template_directory_uri() . '/js/functions.js', array( 'jquery' ), '20141212', true );
	wp_localize_script( 'twentyfifteen-script', 'screenReaderText', array(
		'expand'   => '<span class="screen-reader-text">' . __( 'expand child menu', 'twentyfifteen' ) . '</span>',
		'collapse' => '<span class="screen-reader-text">' . __( 'collapse child menu', 'twentyfifteen' ) . '</span>',
	) );
}
add_action( 'wp_enqueue_scripts', 'twentyfifteen_scripts' );

/**
 * Add featured image as background image to post navigation elements.
 *
 * @since Twenty Fifteen 1.0
 *
 * @see wp_add_inline_style()
 */
function twentyfifteen_post_nav_background() {
	if ( ! is_single() ) {
		return;
	}

	$previous = ( is_attachment() ) ? get_post( get_post()->post_parent ) : get_adjacent_post( false, '', true );
	$next     = get_adjacent_post( false, '', false );
	$css      = '';

	if ( is_attachment() && 'attachment' == $previous->post_type ) {
		return;
	}

	if ( $previous &&  has_post_thumbnail( $previous->ID ) ) {
		$prevthumb = wp_get_attachment_image_src( get_post_thumbnail_id( $previous->ID ), 'post-thumbnail' );
		$css .= '
			.post-navigation .nav-previous { background-image: url(' . esc_url( $prevthumb[0] ) . '); }
			.post-navigation .nav-previous .post-title, .post-navigation .nav-previous a:hover .post-title, .post-navigation .nav-previous .meta-nav { color: #fff; }
			.post-navigation .nav-previous a:before { background-color: rgba(0, 0, 0, 0.4); }
		';
	}

	if ( $next && has_post_thumbnail( $next->ID ) ) {
		$nextthumb = wp_get_attachment_image_src( get_post_thumbnail_id( $next->ID ), 'post-thumbnail' );
		$css .= '
			.post-navigation .nav-next { background-image: url(' . esc_url( $nextthumb[0] ) . '); }
			.post-navigation .nav-next .post-title, .post-navigation .nav-next a:hover .post-title, .post-navigation .nav-next .meta-nav { color: #fff; }
			.post-navigation .nav-next a:before { background-color: rgba(0, 0, 0, 0.4); }
		';
	}

	wp_add_inline_style( 'twentyfifteen-style', $css );
}
add_action( 'wp_enqueue_scripts', 'twentyfifteen_post_nav_background' );

/**
 * Display descriptions in main navigation.
 *
 * @since Twenty Fifteen 1.0
 *
 * @param string  $item_output The menu item output.
 * @param WP_Post $item        Menu item object.
 * @param int     $depth       Depth of the menu.
 * @param array   $args        wp_nav_menu() arguments.
 * @return string Menu item with possible description.
 */
function twentyfifteen_nav_description( $item_output, $item, $depth, $args ) {
	if ( 'primary' == $args->theme_location && $item->description ) {
		$item_output = str_replace( $args->link_after . '</a>', '<div class="menu-item-description">' . $item->description . '</div>' . $args->link_after . '</a>', $item_output );
	}

	return $item_output;
}
add_filter( 'walker_nav_menu_start_el', 'twentyfifteen_nav_description', 10, 4 );

/**
 * Add a `screen-reader-text` class to the search form's submit button.
 *
 * @since Twenty Fifteen 1.0
 *
 * @param string $html Search form HTML.
 * @return string Modified search form HTML.
 */
function twentyfifteen_search_form_modify( $html ) {
	return str_replace( 'class="search-submit"', 'class="search-submit screen-reader-text"', $html );
}
add_filter( 'get_search_form', 'twentyfifteen_search_form_modify' );

/**
 * Implement the Custom Header feature.
 *
 * @since Twenty Fifteen 1.0
 */
require get_template_directory() . '/inc/custom-header.php';

/**
 * Custom template tags for this theme.
 *
 * @since Twenty Fifteen 1.0
 */
require get_template_directory() . '/inc/template-tags.php';

/**
 * Customizer additions.
 *
 * @since Twenty Fifteen 1.0
 */
require get_template_directory() . '/inc/customizer.php';
add_action( 'init', 'redtuition_post_types' );
function redtuition_post_types() {
    register_post_type('sliders',
            array(
                'public' => true,
                'label'  => 'Sliders',
                'rewrite' => array("slug" => "sliders"),
                'supports' => array( 'title', 'thumbnail', 'editor')
            )
    );
    flush_rewrite_rules();
    register_post_type('testimonials',
            array(
                'public' => true,
                'label'  => 'Testimonials',
                'rewrite' => array("slug" => "testimonials"),
                'supports' => array( 'title', 'thumbnail', 'editor')
            )
    );
    flush_rewrite_rules();
    register_post_type('documents',
            array(
                'public' => true,
                'label'  => 'Documents Management',
                'rewrite' => array("slug" => "documents"),
                'supports' => array( 'title')
            )
    );
    flush_rewrite_rules();
    register_taxonomy(
            'document-cat',
            'documents',
            array(
                'label' => __( 'Document Categories' ),
                'rewrite' => array( 'slug' => 'document-categories' ),
                'hierarchical' => true,
            )
    );
    flush_rewrite_rules();
    register_post_type('packages',
            array(
                'public' => true,
                'label'  => 'Pricing & Packages',
                'rewrite' => array("slug" => "packages"),
                'supports' => array( 'title')
            )
    );
    flush_rewrite_rules();
    register_taxonomy(
            'package-cat',
            array('packages'), // , 'documents'
            array(
                'label' => __( 'Package Categories' ),
                'rewrite' => array( 'slug' => 'package-categories' ),
                'hierarchical' => true,
            )
    );
    flush_rewrite_rules();
    register_post_type('seminar-timetables',
            array(
                'public' => true,
                'label'  => 'Seminar Timetables',
                'rewrite' => array("slug" => "seminar-timetables"),
                'supports' => array( 'title')
            )
    );
    flush_rewrite_rules();
    register_post_type('tuition-class-times',
            array(
                'public' => true,
                'label'  => 'Tuition Class Times',
                'rewrite' => array("slug" => "tuition-class-times"),
                'supports' => array( 'title')
            )
    );
    flush_rewrite_rules();
    register_post_type('year-timetables',
            array(
                'public' => true,
                'label'  => 'Year Timetables',
                'rewrite' => array("slug" => "year-timetables"),
                'supports' => array( 'title')
            )
    );
    flush_rewrite_rules();
}

function vt_resize( $attach_id = null, $img_url = null, $width, $height, $crop = false ) {
    if ( $attach_id ) {
        $image_src = wp_get_attachment_image_src( $attach_id, 'full' );
        $file_path = get_attached_file( $attach_id );
    } else if ( $img_url ) {
        $file_path = parse_url( $img_url );
        $file_path = $_SERVER['DOCUMENT_ROOT'] . $file_path['path'];
        if(file_exists($file_path) === false){
            global $blog_id;
            $file_path = parse_url( $img_url );
            if (preg_match("/files/", $file_path['path'])) {
                $path = explode('/',$file_path['path']);
                foreach($path as $k=>$v){
                    if($v == 'files'){
                        $path[$k-1] = 'wp-content/blogs.dir/'.$blog_id;
                    }
                }
                $path = implode('/',$path);
            }
            $file_path = $_SERVER['DOCUMENT_ROOT'].$path;
        }
        $orig_size = getimagesize( $file_path );
        $image_src[0] = $img_url;
        $image_src[1] = $orig_size[0];
        $image_src[2] = $orig_size[1];
    }
    $file_info = pathinfo( $file_path );
    $base_file = $file_info['dirname'].'/'.$file_info['filename'].'.'.$file_info['extension'];
    if ( !file_exists($base_file) )
    return;
    $extension = '.'. $file_info['extension'];
    $no_ext_path = $file_info['dirname'].'/'.$file_info['filename'];
    $cropped_img_path = $no_ext_path.'-'.$width.'x'.$height.$extension;
    if ( $image_src[1] > $width ) {
        if ( file_exists( $cropped_img_path ) ) {
            $cropped_img_url = str_replace( basename( $image_src[0] ), basename( $cropped_img_path ), $image_src[0] );
            $vt_image = array (
                'url' => $cropped_img_url,
                'width' => $width,
                'height' => $height
            );
            return $vt_image;
        }
        if ( $crop == false OR !$height ) {
            $proportional_size = wp_constrain_dimensions( $image_src[1], $image_src[2], $width, $height );
            $resized_img_path = $no_ext_path.'-'.$proportional_size[0].'x'.$proportional_size[1].$extension;
            if ( file_exists( $resized_img_path ) ) {
                $resized_img_url = str_replace( basename( $image_src[0] ), basename( $resized_img_path ), $image_src[0] );
                $vt_image = array (
                'url' => $resized_img_url,
                'width' => $proportional_size[0],
                'height' => $proportional_size[1]
                );
                return $vt_image;
            }
        }
        $img_size = getimagesize( $file_path );
        if ( $img_size[0] <= $width ) $width = $img_size[0];
        if (!function_exists ('imagecreatetruecolor')) {
            echo 'GD Library Error: imagecreatetruecolor does not exist - please contact your webhost and ask them to install the GD library';
            return;
        }
        $new_img_path = image_resize( $file_path, $width, $height, $crop );	
        $new_img_size = getimagesize( $new_img_path );
        $new_img = str_replace( basename( $image_src[0] ), basename( $new_img_path ), $image_src[0] );
        $vt_image = array (
            'url' => $new_img,
            'width' => $new_img_size[0],
            'height' => $new_img_size[1]
        );
        return $vt_image;
    }
    $vt_image = array (
        'url' => $image_src[0],
        'width' => $width,
        'height' => $height
    );
    return $vt_image;
}

function login_with_email_address($user, $username, $password) {
    $user = get_user_by('email',$username);
    if(!empty($user->user_login))
        $username = $user->user_login;
    return wp_authenticate_username_password( null, $username, $password );
}
add_filter('authenticate','login_with_email_address', 20, 3);

function redtuition_new_user_reg($user_id){
    global $wpdb;
    $key = wp_generate_password( 20, false );
    do_action( 'retrieve_password_key', $user_id, $key );
    $wpdb->update( $wpdb->users, array( 'user_activation_key' => $key ), array( 'ID' => $user_id ) );
}
add_action('user_register', 'redtuition_new_user_reg', 10, 1);

function redtuition_login_auth($user, $password){
    $errors = new WP_Error();
    $userdata  = get_userdata( $user->ID );
    if(implode(', ', $userdata->roles) != 'administrator'){
        if(get_user_meta($user->ID, 'account_status', true) == 1){
            return $user;
        }else if(get_user_meta($user->ID, 'account_status', true) === ''){
            return $user;
        }else{
            $errors->add('verification_failed', __('Your account is not verified yet. Please check your mail to activate account.'));
            return $errors;
        }
    }else{
        return $user;
    }
}
add_filter('wp_authenticate_user', 'redtuition_login_auth',10,2);
add_filter('show_admin_bar', '__return_false');
function redirect_sub_to_home_wpse_93843( $redirect_to, $request, $user ) {
    if ( isset($user->roles) && is_array( $user->roles ) ) {
      if ( in_array( 'subscriber', $user->roles ) ) {
          return site_url('student-portal');
      } 
      if ( in_array( 'administrator', $user->roles ) ) {
          return admin_url();
      }
    }
    return $redirect_to;
}
add_filter( 'login_redirect', 'redirect_sub_to_home_wpse_93843', 10, 3 );
function restrict_users_dashboard(){
    global $user_ID;
    $userdata = get_userdata($user_ID);
    if ( isset($userdata->roles) && is_array( $userdata->roles ) ) {
      if ( in_array( 'subscriber', $userdata->roles ) ) {
          wp_safe_redirect(site_url('student-portal'));
          exit();
      } 
    }
}
add_action( 'admin_init', 'restrict_users_dashboard', 1 );
function redtuition_social_login_redirect(){
    $redirect_to = site_url('student-portal');
    return $redirect_to;
}
add_filter('wsl_hook_process_login_alter_redirect_to', 'redtuition_social_login_redirect');

function redtuition_social_account_status($is_new_user, $user_id, $provider, $adapter, $hybridauth_user_profile, $wp_user){
    update_user_meta($user_id,'account_status', 1);
    update_user_meta($user_id,'is_paid_user', 0);
}
add_action('wsl_process_login_update_wsl_user_data_start', 'redtuition_social_account_status', 10, 6);
function add_users_metaboxes() {
    add_meta_box('user_metabox', 'Select Users', 'user_document_section', 'documents', 'side', 'default');
}
add_action( 'add_meta_boxes', 'add_users_metaboxes' );
function user_document_section() {
    global $post, $wpdb;
    echo '<a href="javascript:void(0);" class="CheckAllusers" data-status="none_checked">Select all</a><br/>';
    echo '<input type="hidden" name="eventmeta_noncename" id="eventmeta_noncename" value="' . wp_create_nonce( plugin_basename(__FILE__) ) . '" />';
    $ids = get_post_meta($post->ID, 'users', true);
    $ids = ($ids <> '' || !$ids) ? $ids : 'nothing,found';
    $ids = explode(',', $ids);
    $ids = (is_array($ids) && !empty($ids)) ? $ids : (array)$ids;
    $users = $wpdb->get_results("SELECT * FROM `{$wpdb->users}` WHERE `ID` NOT IN(1)");
    if(!empty($users)){
        foreach ($users as $user) {
            $checked = (in_array($user->ID, $ids)) ? 'checked="checked"' : '';
            echo "<label class='selectit'>";
            echo "<input type='checkbox' name='users[]' class='redalluserscb' value='{$user->ID}' {$checked}/> {$user->display_name} <br/>";
            echo "</label>";
        }
    }
}

function add_admin_script_for_doc_users(){?>
    <script type='text/javascript'>
            (function($){
                $(function(){
                    if($('[name="users[]"]:checked').length == $('.redalluserscb').length){
                        $('.CheckAllusers').data('status', 'all_checked');
                        $('.CheckAllusers').empty().text('Select none');
                    }
                    $(document).delegate('.CheckAllusers', 'click', function(){
                        if($(this).data('status') === 'none_checked'){
                            $('.redalluserscb').each(function(){
                                $(this).attr('checked', 'checked');
                            });
                            $(this).data('status', 'all_checked');
                            $(this).empty().text('Select none');
                        }
                        else if($(this).data('status') == 'all_checked'){
                            $('.redalluserscb').each(function(){
                                $(this).removeAttr('checked');
                            });
                            $(this).data('status', 'none_checked');
                            $(this).empty().text('Select all');
                        }
                    });
                });
            })(jQuery);  
        </script>
<?php
}
add_action('admin_head', 'add_admin_script_for_doc_users');

function save_documents_meta($post_id, $post) {
    if ( !wp_verify_nonce( $_POST['eventmeta_noncename'], plugin_basename(__FILE__) )) {
        return $post->ID;
    }

    if ( !current_user_can( 'edit_post', $post->ID ))
        return $post->ID;

    $events_meta['users'] = (isset($_POST['users'])) ? $_POST['users'] : array();

    foreach ($events_meta as $key => $value) { 
        if( $post->post_type == 'revision' ) 
            return; 
        $value = implode(',', (array)$value);
        update_post_meta($post->ID, $key, $value);
    }
}
add_action('save_post', 'save_documents_meta', 1, 2);
function is_user_assigned_post($post_id, $user_id){
    $ids = get_post_meta($post_id, 'users', TRUE);
    $ids = ($ids <> '' || !$ids) ? $ids : 'nothing,found';
    $ids = explode(',', $ids);
    $ids = (is_array($ids) && !empty($ids)) ? $ids : (array)$ids;
    if((in_array($user_id, $ids))){
        return TRUE;
    }
    return FALSE;
}
function get_posts_by_taxonomy_name($tax_name){
    global $user_ID;
    $args = array(
        'post_type' => 'documents',
        'posts_per_page' => -1,
        'taxononmy' => 'document-cat',
        'document-cat' => $tax_name,
    );
    query_posts($args);
    $return = '<p>';
    if(have_posts()){
        while(have_posts()){
            the_post();
            if(is_user_assigned_post(get_the_ID(), $user_ID)){
                $return .= "<a href='".get_field('pdf_documents')."' target='_blank' title='".get_the_title(get_the_ID())."'>".get_the_title(get_the_ID())."</a>";
            }
        }
        $return .= '</p>';
        return ($return <> '<p></p>') ? $return : '<p>No document is assigned to you.</p>';
    }
    return '<p>No document is assigned to you.</p>';
}
function currentPageURL() {
    $curpageURL = 'http';
    if ($_SERVER["HTTPS"] == "on") {$curpageURL.= "s";}
    $curpageURL.= "://";
    if ($_SERVER["SERVER_PORT"] != "80") {
        $curpageURL.= $_SERVER["SERVER_NAME"].":".$_SERVER["SERVER_PORT"].$_SERVER["REQUEST_URI"];
    } else {
        $curpageURL.= $_SERVER["SERVER_NAME"].$_SERVER["REQUEST_URI"];
    }
    return untrailingslashit($curpageURL);
}
//function get_the_free_package_id(){
//    query_posts(array('post_type' => 'packages', 'taxonomy' => 'package-cat', 'posts_per_page' => -1));
//    while(have_posts()){
//        the_post();
//        if(str_replace('$', '', get_field('package_price')) == '0'){
//            
//        }
//    }
//}

function remove_admin_update_option() {
    echo '<script>
            (function($){
                $(function(){
                    $("ul#wp-admin-bar-root-default li").each(function(){
                        if($(this).attr("id") == "wp-admin-bar-updates")
                        {
                            $(this).remove();
                        }
                    });	
                });
            })(jQuery);  
        </script>';
}
add_action('admin_head', 'remove_admin_update_option');
function wphidenag() {
    remove_action( 'admin_notices', 'update_nag', 3 );
}
add_action('admin_menu','wphidenag');
function my_login_logo() { ?>
        <style type="text/css">
            body.login div#login h1 a {
                background-image: url(<?php header_image();?>);
                padding-bottom: 30px;
                background-size: 277px 115px;
                width:277px;
                height:115px;
            }
        </style>
    <?php }
    add_action( 'login_head', 'my_login_logo' );
    function my_login_logo_url() {
        return home_url();
    }
    add_filter( 'login_headerurl', 'my_login_logo_url' );

    function my_login_logo_url_title() {
        return 'Red Tuition';
    }
    add_filter( 'login_headertitle', 'my_login_logo_url_title' );
    function my_footer_shh() {
        remove_filter( 'update_footer', 'core_update_footer' );         
    }
    add_action( 'admin_menu', 'my_footer_shh' );

    function my_footer_text() {
            echo '';
    }
    add_action('admin_footer_text', 'my_footer_text');
    function edit_admin_menus() {  
        global $submenu;  
        unset($submenu['index.php'][10]);
        return $submenu;
    }  
    add_action( 'admin_menu', 'edit_admin_menus' ); 
    function remove_dashboard_meta(){
        remove_meta_box( 'dashboard_incoming_links', 'dashboard', 'normal' );
        remove_meta_box( 'dashboard_plugins', 'dashboard', 'normal' );
        remove_meta_box( 'dashboard_primary', 'dashboard', 'normal' );
        remove_meta_box( 'dashboard_secondary', 'dashboard', 'normal' );
        remove_meta_box( 'dashboard_incoming_links', 'dashboard', 'normal' );
        remove_meta_box( 'dashboard_quick_press', 'dashboard', 'side' );
        remove_meta_box( 'dashboard_recent_drafts', 'dashboard', 'side' );
        remove_meta_box( 'dashboard_recent_comments', 'dashboard', 'normal' );
        remove_meta_box( 'dashboard_right_now', 'dashboard', 'normal' );
        remove_meta_box( 'dashboard_activity', 'dashboard', 'normal' );
    }
    add_action( 'admin_init', 'remove_dashboard_meta' );
    