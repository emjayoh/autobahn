<?php
/**
 * Custom functions
 */

class GWPreviewConfirmation {
 
    private static $lead;
 
    function init() {
 
        add_filter('gform_pre_render', array('GWPreviewConfirmation', 'replace_merge_tags'));
        add_filter('gform_replace_merge_tags', array('GWPreviewConfirmation', 'product_summary_merge_tag'), 10, 3);
 
    }
 
    public static function replace_merge_tags($form) {
 
        $current_page = isset(GFFormDisplay::$submission[$form['id']]) ? GFFormDisplay::$submission[$form['id']]['page_number'] : 1;
        $fields = array();
 
        // get all HTML fields on the current page
        foreach($form['fields'] as &$field) {
 
            // skip all fields on the first page
            if(rgar($field, 'pageNumber') <= 1)
                continue;
 
            $default_value = rgar($field, 'defaultValue');
            preg_match_all('/{.+}/', $default_value, $matches, PREG_SET_ORDER);
            if(!empty($matches)) {
                // if default value needs to be replaced but is not on current page, wait until on the current page to replace it
                if(rgar($field, 'pageNumber') != $current_page) {
                    $field['defaultValue'] = '';
                } else {
                    $field['defaultValue'] = self::preview_replace_variables($default_value, $form);
                }
            }
 
            // only run 'content' filter for fields on the current page
            if(rgar($field, 'pageNumber') != $current_page)
                continue;
 
            $html_content = rgar($field, 'content');
            preg_match_all('/{.+}/', $html_content, $matches, PREG_SET_ORDER);
            if(!empty($matches)) {
                $field['content'] = self::preview_replace_variables($html_content, $form);
            }
 
        }
 
        return $form;
    }
 
    /**
    * Adds special support for file upload, post image and multi input merge tags.
    */
    public static function preview_special_merge_tags($value, $input_id, $merge_tag, $field) {
        
        // added to prevent overriding :noadmin filter (and other filters that remove fields)
        if( !$value )
            return $value;
        
        $input_type = RGFormsModel::get_input_type($field);
        
        $is_upload_field = in_array( $input_type, array('post_image', 'fileupload') );
        $is_multi_input = is_array( rgar($field, 'inputs') );
        $is_input = intval( $input_id ) != $input_id;
        
        if( !$is_upload_field && !$is_multi_input )
            return $value;
 
        // if is individual input of multi-input field, return just that input value
        if( $is_input )
            return $value;
            
        $form = RGFormsModel::get_form_meta($field['formId']);
        $lead = self::create_lead($form);
        $currency = GFCommon::get_currency();
 
        if(is_array(rgar($field, 'inputs'))) {
            $value = RGFormsModel::get_lead_field_value($lead, $field);
            return GFCommon::get_lead_field_display($field, $value, $currency);
        }
 
        switch($input_type) {
        case 'fileupload':
            $value = self::preview_image_value("input_{$field['id']}", $field, $form, $lead);
            $value = self::preview_image_display($field, $form, $value);
            break;
        default:
            $value = self::preview_image_value("input_{$field['id']}", $field, $form, $lead);
            $value = GFCommon::get_lead_field_display($field, $value, $currency);
            break;
        }
 
        return $value;
    }
 
    public static function preview_image_value($input_name, $field, $form, $lead) {
 
        $field_id = $field['id'];
        $file_info = RGFormsModel::get_temp_filename($form['id'], $input_name);
        $source = RGFormsModel::get_upload_url($form['id']) . "/tmp/" . $file_info["temp_filename"];
 
        if(!$file_info)
            return '';
 
        switch(RGFormsModel::get_input_type($field)){
 
            case "post_image":
                list(,$image_title, $image_caption, $image_description) = explode("|:|", $lead[$field['id']]);
                $value = !empty($source) ? $source . "|:|" . $image_title . "|:|" . $image_caption . "|:|" . $image_description : "";
                break;
 
            case "fileupload" :
                $value = $source;
                break;
 
        }
 
        return $value;
    }
 
    public static function preview_image_display($field, $form, $value) {
 
        // need to get the tmp $file_info to retrieve real uploaded filename, otherwise will display ugly tmp name
        $input_name = "input_" . str_replace('.', '_', $field['id']);
        $file_info = RGFormsModel::get_temp_filename($form['id'], $input_name);
 
        $file_path = $value;
        if(!empty($file_path)){
            $file_path = esc_attr(str_replace(" ", "%20", $file_path));
            $value = "<a href='$file_path' target='_blank' title='" . __("Click to view", "gravityforms") . "'>" . $file_info['uploaded_filename'] . "</a>";
        }
        return $value;
 
    }
 
    /**
    * Retrieves $lead object from class if it has already been created; otherwise creates a new $lead object.
    */
    public static function create_lead( $form ) {
        
        if( empty( self::$lead ) ) {
            self::$lead = RGFormsModel::create_lead( $form );
            self::clear_field_value_cache( $form );
        }
        
        return self::$lead;
    }
 
    public static function preview_replace_variables($content, $form) {
 
        $lead = self::create_lead($form);
 
        // add filter that will handle getting temporary URLs for file uploads and post image fields (removed below)
        // beware, the RGFormsModel::create_lead() function also triggers the gform_merge_tag_filter at some point and will
        // result in an infinite loop if not called first above
        add_filter('gform_merge_tag_filter', array('GWPreviewConfirmation', 'preview_special_merge_tags'), 10, 4);
 
        $content = GFCommon::replace_variables($content, $form, $lead, false, false, false);
 
        // remove filter so this function is not applied after preview functionality is complete
        remove_filter('gform_merge_tag_filter', array('GWPreviewConfirmation', 'preview_special_merge_tags'));
 
        return $content;
    }
 
    public static function product_summary_merge_tag($text, $form, $lead) {
 
        if(empty($lead))
            $lead = self::create_lead($form);
 
        $remove = array("<tr bgcolor=\"#EAF2FA\">\n                            <td colspan=\"2\">\n                                <font style=\"font-family: sans-serif; font-size:12px;\"><strong>Order</strong></font>\n                            </td>\n                       </tr>\n                       <tr bgcolor=\"#FFFFFF\">\n                            <td width=\"20\">&nbsp;</td>\n                            <td>\n                                ", "\n                            </td>\n                        </tr>");
        $product_summary = str_replace($remove, '', GFCommon::get_submitted_pricing_fields($form, $lead, 'html'));
 
        return str_replace('{product_summary}', $product_summary, $text);
    }
    
    public static function clear_field_value_cache( $form ) {
        
        if( ! class_exists( 'GFCache' ) )
            return;
            
        foreach( $form['fields'] as &$field ) {
            if( GFFormsModel::get_input_type( $field ) == 'total' )
                GFCache::delete( 'GFFormsModel::get_lead_field_value__' . $field['id'] );
        }
        
    }
 
}
GWPreviewConfirmation::init();

// Disable Gravity Forms # tag links
add_filter("gform_confirmation_anchor", create_function("","return false;"));


// Custom Gravity Forms Buttons
add_filter( 'gform_previous_button_2', 'custom_grav_left_btn', 10, 2 );
add_filter( 'gform_next_button_2', 'custom_grav_right_btn', 10, 2 );
add_filter( 'gform_submit_button_2', 'custom_grav_right_btn', 10, 2 );
add_filter( 'gform_submit_button_1', 'custom_grav_left_btn', 10, 2 );
function custom_grav_right_btn( $html, $form ) {
    return str_replace( "class='", "class='btn btn-default float-right ", $html);
}
function custom_grav_left_btn( $html, $form ) {
    return str_replace( "class='", "class='btn btn-default float-left ", $html);
}


 
/**
* Skip Pages on Multi-Page Form
* http://gravitywiz.com/2012/05/04/pro-tip-skip-pages-on-multi-page-forms/
*/
 
add_filter("gform_pre_render", "gform_skip_page");
function gform_skip_page($form) {
    if(!rgpost("is_submit_{$form['id']}") && rgget('form_page') && is_user_logged_in())
        GFFormDisplay::$submission[$form['id']]["page_number"] = rgget('form_page');
    return $form;
}
 
 
 
 
add_action( 'template_redirect', 'custom_redirects' );
function custom_redirects(){
	global $post;
	if( $post->post_name == 'booking' ){
		// Build WP_Query for tour ID passed in URL
		$tour_slug = sanitize_title( $_GET[ 'tourId' ] );
		$args = array(
			'name' => $tour_slug,
			'post_type' => 'tour',
		);
		$tour_query = new WP_Query( $args );
		// Redirect if tour ID passed in URL does not turn up a valid tour to book
		if ( $tour_query->post_count != 1 ){
			wp_redirect( home_url() . '/driving-tours/' ); exit;
		}
	}elseif( $post->post_type == 'car' || $post->post_type == 'road' || $post->post_type == 'hotel' ){
		wp_redirect( home_url() . '/the-experience/' . $post->post_type . 's' ); exit;
	}
}


add_action("gform_enable_credit_card_field", "enable_creditcard");
function enable_creditcard($is_enabled){
    return true;
}






add_filter( 'get_comment_author_link', 'custom_comment_author_link' );
function custom_comment_author_link( $author_link ){
    return '<span class="gold">' . $author_link . '</span>';
}


 
// Ajax load posts
/*
function returnPosts(){
	wp_reset_postdata();
	if ( have_posts() ) {
			while ( have_posts() ) {
				the_post();
				get_template_part('content', get_post_format());
			}
		} else { 
			get_template_part( 'content', 'none' );
		}
	exit();
}
add_action('wp_ajax_returnPosts', 'returnPosts');
add_action('wp_ajax_nopriv_returnPosts', 'returnPosts');*/
 
// Create CUSTOMER REVIEW Custom Post Type
add_action( 'init', 'create_review_post_type' );
function create_review_post_type()
{
	$args = array(	'labels' => post_type_labels( 'Review' ),
					'public' => true,
					'exclude_from_search' => true,
					'has_archive' => false,
					'show_in_nav_menus' => false,
					'menu_position' => 5,
					'menu_icon' => 'dashicons-format-quote',
					'supports' => array(	'title',
											'author',
											'excerpt',
											'editor',
											'custom-fields',
											'comments',
											'revisions',
											'thumbnail',
										),
					'rewrite' => array(		'slug' => 'about-us/our-customers/reviews',
										),
				 );
	register_post_type( 'review', $args);
}

// Create CUSTOMER PROFILE Custom Post Type
add_action( 'init', 'create_profile_post_type' );
function create_profile_post_type()
{
	$args = array(	'labels' => post_type_labels( 'Profile' ),
					'public' => true,
					'exclude_from_search' => true,
					'has_archive' => false,
					'show_in_nav_menus' => false,
					'menu_position' => 5,
					'menu_icon' => 'dashicons-id-alt',
					'supports' => array(	'title',
											'author',
											'excerpt',
											'editor',
											'custom-fields',
											'comments',
											'revisions',
											'thumbnail',
										),
					'rewrite' => array(		'slug' => 'about-us/our-customers/profiles',
										),
				 );
	register_post_type( 'profile', $args);
}

// Create TOUR Custom Post Type
add_action( 'init', 'create_tour_post_type' );
function create_tour_post_type()
{
	$args = array(	'labels' => post_type_labels( 'Tour' ),
					'public' => true,
					'exclude_from_search' => true,
					'has_archive' => false,
					'show_in_nav_menus' => true,
					'menu_position' => 5,
					'menu_icon' => 'dashicons-admin-site',
					'supports' => array(	'title',
											'author',
											'excerpt',
											'editor',
											'custom-fields',
											'comments',
											'revisions',
											'thumbnail',
										),
					'rewrite' => array(		'slug' => 'driving-tours',
										),
				 );
	register_post_type( 'tour', $args);
}

// Create SPECIAL EVENTS Custom Post Type
add_action( 'init', 'create_event_post_type' );
function create_event_post_type()
{
	$args = array(	'labels' => post_type_labels( 'Event' ),
					'public' => true,
					'exclude_from_search' => true,
					'has_archive' => false,
					'show_in_nav_menus' => false,
					'menu_position' => 5,
					'menu_icon' => 'dashicons-star-filled',
					'supports' => array(	'title',
											'author',
											'excerpt',
											'editor',
											'custom-fields',
											'comments',
											'revisions',
											'thumbnail',
										),
					'rewrite' => array(		'slug' => 'about-us/special-events',
										),
				 );
	register_post_type( 'event', $args);
}

// Create FAQ Custom Post Type
add_action( 'init', 'create_faq_post_type' );
function create_faq_post_type()
{
	$args = array(	'labels' => post_type_labels( 'FAQ' ),
					'public' => true,
					'exclude_from_search' => true,
					'has_archive' => false,
					'show_in_nav_menus' => false,
					'menu_position' => 5,
					'menu_icon' => 'dashicons-format-chat',
					'supports' => array(	'title',
											'author',
											'excerpt',
											'editor',
											'custom-fields',
											'comments',
											'revisions',
											'thumbnail',
										),
					'rewrite' => array(		'slug' => 'about-us/faq',
										),
				 );
	register_post_type( 'faq', $args);
}

// Create CAR Custom Post Type
add_action( 'init', 'create_car_post_type' );
function create_car_post_type()
{
	$args = array(	'labels' => post_type_labels( 'Car' ),
					'public' => true,
					'exclude_from_search' => true,
					'has_archive' => false,
					'show_in_nav_menus' => false,
					'menu_position' => 5,
					'menu_icon' => 'dashicons-location-alt',
					'supports' => array(	'title',
											'author',
											'excerpt',
											'editor',
											'custom-fields',
											'comments',
											'revisions',
											'thumbnail',
										),
					'rewrite' => array(		'slug' => 'the-experience/cars',
										),
				 );
	register_post_type( 'car', $args);
}

// Create ROAD Custom Post Type
add_action( 'init', 'create_road_post_type' );
function create_road_post_type()
{
	$args = array(	'labels' => post_type_labels( 'Road' ),
					'public' => true,
					'exclude_from_search' => true,
					'has_archive' => false,
					'show_in_nav_menus' => false,
					'menu_position' => 5,
					'menu_icon' => 'dashicons-editor-insertmore',
					'supports' => array(	'title',
											'author',
											'excerpt',
											'editor',
											'custom-fields',
											'comments',
											'revisions',
											'thumbnail',
										),
					'rewrite' => array(		'slug' => 'the-experience/roads',
										),
				 );
	register_post_type( 'road', $args);
}

// Create HOTEL Custom Post Type
add_action( 'init', 'create_hotel_post_type' );
function create_hotel_post_type()
{
	$args = array(	'labels' => post_type_labels( 'Hotel' ),
					'public' => true,
					'exclude_from_search' => true,
					'has_archive' => false,
					'show_in_nav_menus' => false,
					'menu_position' => 5,
					'menu_icon' => 'dashicons-book-alt',
					'supports' => array(	'title',
											'author',
											'excerpt',
											'editor',
											'custom-fields',
											'comments',
											'revisions',
											'thumbnail',
										),
					'rewrite' => array(		'slug' => 'the-experience/hotels',
										),
				 );
	register_post_type( 'hotel', $args);
}

// Create RESTAURANT Custom Post Type
/*add_action( 'init', 'create_restaurant_post_type' );
function create_restaurant_post_type()
{
	$args = array(	'labels' => post_type_labels( 'Restaurant' ),
					'public' => true,
					'exclude_from_search' => true,
					'has_archive' => false,
					'show_in_nav_menus' => false,
					'menu_position' => 5,
					'menu_icon' => 'dashicons-awards',
					'supports' => array(	'title',
											'author',
											'excerpt',
											'editor',
											'custom-fields',
											'comments',
											'revisions',
											'thumbnail',
										),
					'rewrite' => array(		'slug' => 'the-experience/dining',
										),
				 );
	register_post_type( 'restaurant', $args);
}*/

// Create ATTRACTION Custom Post Type
/*add_action( 'init', 'create_attraction_post_type' );
function create_attraction_post_type()
{
	$args = array(	'labels' => post_type_labels( 'Attraction' ),
					'public' => true,
					'exclude_from_search' => true,
					'has_archive' => false,
					'show_in_nav_menus' => false,
					'menu_position' => 5,
					'menu_icon' => 'dashicons-flag',
					'supports' => array(	'title',
											'author',
											'excerpt',
											'editor',
											'custom-fields',
											'comments',
											'revisions',
											'thumbnail',
										),
					'rewrite' => array(		'slug' => 'the-experience/attractions',
										),
				 );
	register_post_type( 'attraction', $args);
}*/

// A helper function for generating post type labels
function post_type_labels( $singular, $plural = '' )
{
	if( $plural == '') $plural = $singular .'s';
   
	return array(
		'name' => _x( $plural, 'post type general name' ),
		'singular_name' => _x( $singular, 'post type singular name' ),
		'add_new' => __( 'Add New' ),
		'add_new_item' => __( 'Add New '. $singular ),
		'edit_item' => __( 'Edit '. $singular ),
		'new_item' => __( 'New '. $singular ),
		'view_item' => __( 'View '. $singular ),
		'search_items' => __( 'Search '. $plural ),
		'not_found' =>  __( 'No '. $plural .' found' ),
		'not_found_in_trash' => __( 'No '. $plural .' found in Trash' ),
		'parent_item_colon' => ''
	);
}