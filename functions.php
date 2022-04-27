<?php
/**
 * Twenty Twenty-Two functions and definitions
 *
 * @link https://developer.wordpress.org/themes/basics/theme-functions/
 *
 * @package WordPress
 * @subpackage Twenty_Twenty_Two
 * @since Twenty Twenty-Two 1.0
 */


if ( ! function_exists( 'twentytwentytwo_support' ) ) :

	/**
	 * Sets up theme defaults and registers support for various WordPress features.
	 *
	 * @since Twenty Twenty-Two 1.0
	 *
	 * @return void
	 */
	function twentytwentytwo_support() {

		// Add support for block styles.
		add_theme_support( 'wp-block-styles' );

		// Enqueue editor styles.
		add_editor_style( 'style.css' );

	}

endif;

add_action( 'after_setup_theme', 'twentytwentytwo_support' );

if ( ! function_exists( 'twentytwentytwo_styles' ) ) :

	/**
	 * Enqueue styles.
	 *
	 * @since Twenty Twenty-Two 1.0
	 *
	 * @return void
	 */
	function twentytwentytwo_styles() {
		// Register theme stylesheet.
		$theme_version = wp_get_theme()->get( 'Version' );

		$version_string = is_string( $theme_version ) ? $theme_version : false;
		wp_register_style(
			'twentytwentytwo-style',
			get_template_directory_uri() . '/style.css',
			array(),
			$version_string
		);

		// Add styles inline.
		wp_add_inline_style( 'twentytwentytwo-style', twentytwentytwo_get_font_face_styles() );

		// Enqueue theme stylesheet.
		wp_enqueue_style( 'twentytwentytwo-style' );

	}

endif;

add_action( 'wp_enqueue_scripts', 'twentytwentytwo_styles' );

if ( ! function_exists( 'twentytwentytwo_editor_styles' ) ) :

	/**
	 * Enqueue editor styles.
	 *
	 * @since Twenty Twenty-Two 1.0
	 *
	 * @return void
	 */
	function twentytwentytwo_editor_styles() {

		// Add styles inline.
		wp_add_inline_style( 'wp-block-library', twentytwentytwo_get_font_face_styles() );

	}

endif;

add_action( 'admin_init', 'twentytwentytwo_editor_styles' );


if ( ! function_exists( 'twentytwentytwo_get_font_face_styles' ) ) :

	/**
	 * Get font face styles.
	 * Called by functions twentytwentytwo_styles() and twentytwentytwo_editor_styles() above.
	 *
	 * @since Twenty Twenty-Two 1.0
	 *
	 * @return string
	 */
	function twentytwentytwo_get_font_face_styles() {

		return "
		@font-face{
			font-family: 'Source Serif Pro';
			font-weight: 200 900;
			font-style: normal;
			font-stretch: normal;
			font-display: swap;
			src: url('" . get_theme_file_uri( 'assets/fonts/SourceSerif4Variable-Roman.ttf.woff2' ) . "') format('woff2');
		}

		@font-face{
			font-family: 'Source Serif Pro';
			font-weight: 200 900;
			font-style: italic;
			font-stretch: normal;
			font-display: swap;
			src: url('" . get_theme_file_uri( 'assets/fonts/SourceSerif4Variable-Italic.ttf.woff2' ) . "') format('woff2');
		}
		";

	}

endif;

if ( ! function_exists( 'twentytwentytwo_preload_webfonts' ) ) :

	/**
	 * Preloads the main web font to improve performance.
	 *
	 * Only the main web font (font-style: normal) is preloaded here since that font is always relevant (it is used
	 * on every heading, for example). The other font is only needed if there is any applicable content in italic style,
	 * and therefore preloading it would in most cases regress performance when that font would otherwise not be loaded
	 * at all.
	 *
	 * @since Twenty Twenty-Two 1.0
	 *
	 * @return void
	 */
	function twentytwentytwo_preload_webfonts() {
		?>
		<link rel="preload" href="<?php echo esc_url( get_theme_file_uri( 'assets/fonts/SourceSerif4Variable-Roman.ttf.woff2' ) ); ?>" as="font" type="font/woff2" crossorigin>
		<?php
	}

endif;

add_action( 'wp_head', 'twentytwentytwo_preload_webfonts' );

// Add block patterns
require get_template_directory() . '/inc/block-patterns.php';


/*adding metabox for admin product page*/

add_action( 'load-post.php', 'woo_add_post_meta_boxes' );
add_action( 'load-post-new.php', 'woo_add_post_meta_boxes' );

function woo_add_post_meta_boxes() {

   add_meta_box(
    'woo-custom-post-class',      // Unique ID
    'Custom',                     // Title
    'woo_post_class_meta_box',    // Callback function
    'product',                    // Admin page (or post type)
    'side',                       // Context
    'default'                     // Priority
  );

}

/* Display the post meta box. */
function woo_post_class_meta_box( $post ) { 


    echo '<div style="display: flex; flex-direction: column;">';
    echo '<div>';

       $image_id = get_post_meta( $post->ID, 'custom_woo_image_id', true );

		if( $image = wp_get_attachment_image_src( $image_id ) ) {

			echo '<a href="#" class="alex-upload"><img src="' . $image[0] . '" /></a>
			      <a href="#" class="alex-remove">Remove image</a>';

			      woocommerce_wp_text_input( array(
			      	'id'   => 'trip-img',
					'type' => 'hidden',
					'name' => 'trip-img',
					'value'=> $image_id
				) );

		} else {

			echo '<a href="#" class="alex-upload">Upload image</a>
			      <a href="#" class="alex-remove" style="display:none">Remove image</a>';

			      woocommerce_wp_text_input( array(
			      	'id'   => 'trip-img',
					'type' => 'hidden',
					'name' => 'trip-img'
				) );

		} 

    		
    echo '</div>';
	echo '<div>';
		
		$custom_date = get_post_meta( $post->ID, 'custom_woo_date', true );

			woocommerce_wp_text_input(
				array(
				'id' => 'start',
				'label' => __('Date:', 'woocommerce'),
				'type' => 'date',
				'name' => 'trip-start',
				'value'=> !empty($custom_date) ? $custom_date : date('Y-m-d')
				)
			);


			
	echo '</div>';
	echo '<div>';   

			   woocommerce_wp_select( array(
				'id'      => 'custom_select',
				'name'    => 'custom_select',
				'label'   => 'Select:',
				'value' => get_post_meta( $post->ID, 'custom_woo_select', true ),
				'options' => array(
					'' => 'select...',
					'rare' => 'rare',
					'frequent' => 'frequent',
					'unusual' => 'unusual'
				)
			) );



    echo '<div style="display: flex; flex-direction: row;">';
	echo '<button style="background:red; color:white;" id="custom_woo_clear_metabox">Clear</button>';
	echo '<button style="background:blue; color:white;" id="custom_woo_submit_metabox">Submit</button>';
	echo '</div>';


    echo '</div>';

 }

 /*adding js scripts*/
add_action('wp_head', 'myplugin_ajaxurl');
function myplugin_ajaxurl() {
    echo '<script type="text/javascript">
           var ajaxurl = "' . admin_url('admin-ajax.php') . '";
         </script>';
}

function my_them_scripts() {

wp_enqueue_script( 'frontend', get_template_directory_uri() . '/assets/js/frontend.js', array( 'jquery' ), '1.0.0', true );
wp_enqueue_style( 'custom', get_template_directory_uri() . '/assets/css/custom.css',false,'1.1','all');

}

add_action( 'wp_enqueue_scripts', 'my_them_scripts' );


function add_script_to_admin_page() {

	  wp_enqueue_script( 'backend', get_template_directory_uri() . '/assets/js/backend.js', array( 'jquery' ), '1.0.0', true );

}
add_action( 'admin_enqueue_scripts', 'add_script_to_admin_page', 0 );


/*Save custom woo fields*/

add_action( 'woocommerce_process_product_meta', 'woocommerce_product_custom_fields_save' );

function woocommerce_product_custom_fields_save($post_id)
{

    $trip_img = $_POST['trip-img'];
    if (!empty($trip_img))
        update_post_meta($post_id, 'custom_woo_image_id', esc_attr($trip_img));

    $trip_start = $_POST['trip-start'];
    if (!empty($trip_start))
        update_post_meta($post_id, 'custom_woo_date', esc_attr($trip_start));

    $custom_select = $_POST['custom_select'];
    if (!empty($custom_select))
        update_post_meta($post_id, 'custom_woo_select', esc_html($custom_select));

    wp_publish_post($post_id);

}

/*Woo frontend shortcode form*/

 add_shortcode( 'woo_add_form','woo_add_form_function'  );

function woo_add_form_function() {

$content = '<div class="woo_custom_form_create_wrap"><form id="woo_custom_form_create" enctype="multipart/form-data" data-action="woo_custom_create_product">';

$content .=  wp_nonce_field( 'woo_custom_create_product', 'product_create' ); 

$content .= '<div class="woo_custom_form_create_item"><input type="text"  name="product_name" placeholder="Product name"></div>
             <div class="woo_custom_form_create_item"><input type="number" name="product_price" placeholder="Product price"></div>
             <div class="woo_custom_form_create_item"><input type="file" name="product_img"></div>
             <div class="woo_custom_form_create_item"><input type="date" name="product_date"></div>';

$content .= '<div class="woo_custom_form_create_item"><select name="product_select">
              <option>select...</option>
              <option value="rare">rare</option>
              <option value="frequent">frequent</option>
              <option value="unusual">unusual</option>
             </select></div>';

$content .= '<div class="woo_custom_form_create_item"><input type="submit" /></div></form></div>';


    return $content;
}
/*woo list shortcode*/

add_shortcode( 'woo_add_list','woo_add_list_function'  );

function woo_add_list_function() {

  $content =  '<ul class="products" style="list-style-type: none;">';
 
    $args = array(
        'posts_per_page' => -1,
        'orderby' => 'rand',
        'post_type' => 'product'
    );
    $loop = new WP_Query($args);
    while ($loop->have_posts()) : $loop->the_post();
        global $product; 
     $content .= '  <div class="row">
            <li class="product">

                <a href="'.get_permalink($loop->post->ID).'" title="' .esc_attr($loop->post->post_title ? $loop->post->post_title : $loop->post->ID).'">
                     '.get_the_post_thumbnail($loop->post->ID, 'shop_catalog').'
                    <h3> '.get_the_title().'</h3>
                    <span class="price">'.$product->get_price_html().'</span>
                </a>
                
            </li>
            <br>
        </div>';
 endwhile;
wp_reset_query(); 
$content .= '</ul>';


    return $content;
}

/*AJAX*/

add_action('wp_ajax_woo_custom_create_product', 'woo_custom_create_product_func');
add_action('wp_ajax_nopriv_woo_custom_create_product', 'woo_custom_create_product_func');

function woo_custom_create_product_func() {

 if ( ! wp_verify_nonce( $_POST['nonce'], 'woo_custom_create_product' ) ) {
            die ('Busted!');
        }

		if (isset($_POST['name']) && isset($_POST['price']) && isset($_POST['date']) && isset($_POST['select']) && intval($_POST['price'] > 0) && isset($_FILES['file']) ) {

		        $post_id = wp_insert_post( array( 'post_title' => $_POST['name'] ,
						'post_type' => 'product',
						'post_status' => 'publish'
					)
				);

				// Then we use the product ID to set all the posts meta
				wp_set_object_terms( $post_id, 'simple', 'product_type' ); // set product is simple/variable/grouped
				update_post_meta( $post_id, '_visibility', 'visible' );
				update_post_meta( $post_id, '_stock_status', 'instock');
				update_post_meta( $post_id, 'total_sales', '0' );
				update_post_meta( $post_id, '_downloadable', 'no' );
				update_post_meta( $post_id, '_virtual', 'yes' );
				update_post_meta( $post_id, '_regular_price', $_POST['price'] );
				update_post_meta( $post_id, '_sale_price', '' );
				update_post_meta( $post_id, '_purchase_note', '' );
				update_post_meta( $post_id, '_featured', 'no' );
				update_post_meta( $post_id, '_weight', '11' );
				update_post_meta( $post_id, '_length', '11' );
				update_post_meta( $post_id, '_width', '11' );
				update_post_meta( $post_id, '_height', '11' );
				update_post_meta( $post_id, '_sku', 'SKU11' );
				update_post_meta( $post_id, '_product_attributes', array() );
				update_post_meta( $post_id, '_sale_price_dates_from', '' );
				update_post_meta( $post_id, '_sale_price_dates_to', '' );
				update_post_meta( $post_id, '_price', $_POST['price'] );
				update_post_meta( $post_id, '_sold_individually', '' );
				update_post_meta( $post_id, '_manage_stock', 'yes' ); // activate stock management
				wc_update_product_stock($post_id, 100, 'set'); // set 1000 in stock
				update_post_meta( $post_id, '_backorders', 'no' );

		        
		       update_post_meta($post_id, 'custom_woo_date', $_POST['date']);
		       update_post_meta($post_id, 'custom_woo_select', $_POST['select']);


				$upload = wp_upload_bits($_FILES['file']['name'], null, file_get_contents($_FILES['file']['tmp_name']));

					$attachment = array(
				        'post_author' => $current_user->ID, 
				        'post_date' => current_time('mysql'),
				        'post_date_gmt' => current_time('mysql'),
				        'post_title' => $_FILES['file']['name'], 
				        'post_status' => 'inherit',
				        'comment_status' => 'closed',
				        'ping_status' => 'closed',
				        'post_name' => $_FILES['file']['name'],                                           
				        'post_modified' => current_time('mysql'),
				        'post_modified_gmt' => current_time('mysql'),
				        'post_parent' => $post_id,
				        'post_type' => 'attachment',
				        'guid' =>  $upload['url'],   // not sure if this is correct, some advise?
				        'post_mime_type' => $_FILES['file']['type'],
				        'post_excerpt' => '',
				        'post_content' => ''
				    );


				$attach_id = wp_insert_attachment( $attachment, $upload['file'], $post_id );
				$attach_data = wp_generate_attachment_metadata( $attach_id, $upload['file'] );
				$update = wp_update_attachment_metadata( $attach_id, $attach_data );
				update_post_meta($post_id, 'custom_woo_image_id', $attach_id);
				set_post_thumbnail( $post_id, $attach_id );

			    echo json_encode('Success!');

		    } else {

		       echo json_encode('Fail!');
		    }



	    wp_die();


	}



