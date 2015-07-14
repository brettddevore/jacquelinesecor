<?php

/*=============================================
=            Register Post Type           =
=============================================*/


function arts_post_type() {
	register_taxonomy_for_object_type('category', 'art-work');
	register_post_type('art',
		array(
			'labels' => array(
				'name' => __('Art', 'art'),
				'singular_name' => __('Art post', 'art'),
				'add_new' => __('Add New', 'art'),
				'add_new_item' => __('Add New Art Piece', 'art'),
				'edit' => __('Edit', 'art'),
				'edit_item' => __('Edit Art Piece', 'art'),
				'new_item' => __('New Art Piece', 'art'),
				'view' => __('View Art Piece', 'art'),
				'view_item' => __('View Art Piece', 'art'),
				'search_items' => __('Search Art Piece', 'art'),
				'not_found' => __('No Art Pieces found', 'art'),
				'not_found_in_trash' => __('No Art Pieces found in Trash', 'art'),
			),
			'public' => true,
			'hierarchical' => true,
			'has_archive' => true,
			'supports' => array(
				'title',
				'editor',
				'thumbnail',
			),

			'can_export' => true,
			'taxonomies' => array(
				'category',
			),
			'menu_icon' => 'dashicons-cart',
			'capability_type' => 'post',
		));
}
add_action('init', 'arts_post_type');
/*-----  End of Section comment block  ------*/


/*=============================================
=            Add Meta Boxes            =
=============================================*/

function art_add_meta_box() {

	$screens = array( 'art' );
	foreach ( $screens as $screen ) {
		add_meta_box('art_sectionid',__( 'Art Piece Details', 'art_textdomain' ),'art_add_meta_box_callback',$screen);
	}
}
add_action( 'add_meta_boxes', 'art_add_meta_box' );

function art_add_meta_box_callback( $post ) {
    wp_nonce_field( basename( __FILE__ ), 'art_nonce' );
    $post_stored_meta = get_post_meta( $post->ID );

    $custom_fields = [
		"name" => "name",
		"price" => "price",
		"size" => "size",
		"image" => "image",
	];
	echo "<div id='art'>";
    foreach ($custom_fields as $custom_field) {
    	$code =  "<p>";
    	$code .= "<label for=\"".$custom_field."\">".$custom_field."</label>";
    	$code .= '<input type="text" name="'.$custom_field.'" value="';
    	if ( isset ( $post_stored_meta[$custom_field] ) ) {
    		$code .= $post_stored_meta[$custom_field][0];
    	}
    	$code .= '"/>';
    	$code .= '</p>';
    	echo $code;
	}
	echo "</div>";

 ?>
 
<?php }



function art_meta_save( $post_id ) {
 
    $is_autosave = wp_is_post_autosave( $post_id );
    $is_revision = wp_is_post_revision( $post_id );
    $is_valid_nonce = ( isset( $_POST[ 'prfx_nonce' ] ) && wp_verify_nonce( $_POST[ 'prfx_nonce' ], basename( __FILE__ ) ) ) ? 'true' : 'false';
 
    if ( $is_autosave || $is_revision || !$is_valid_nonce ) {
        return;
    }


    $custom_fields = [
		"name" => "name",
		"price" => "price",
		"size" => "size",
		"image" => "image",
	];

	foreach ($custom_fields as $custom_field) {
		if( isset( $_POST[ $custom_field ] ) ) {
        	update_post_meta( $post_id, $custom_field, sanitize_text_field( $_POST[ $custom_field ] ) );
    	}

	}

    if( isset( $_POST[ 'meta-text' ] ) ) {
        update_post_meta( $post_id, 'meta-text', sanitize_text_field( $_POST[ 'meta-text' ] ) );
    }
 
}

add_action( 'save_post', 'art_meta_save' );


/*=============================================
=            Enqueue Scripts           =
=============================================*/


function art_custom_fields_styles() {
	wp_register_style('art-integration', get_stylesheet_directory_uri() . '/library/art/art.css' , array(), '', 'all');
	wp_enqueue_style('art-integration');
}
add_action('admin_enqueue_scripts', 'art_custom_fields_styles');

function art_image_enqueue() {
	global $typenow;
	if ($typenow == 'art') {
		wp_enqueue_media();
		wp_register_script('meta-box-image', get_stylesheet_directory_uri() . '/library/art/art.js', array('jquery'));
		wp_localize_script('meta-box-image', 'meta_image',
			array(
				'title' => __('Choose or Upload an Image', 'art-textdomain'),
				'button' => __('Use this image', 'product-textdomain'),
			)
		);
		wp_enqueue_script('meta-box-image');
	}
}
add_action('admin_enqueue_scripts', 'art_image_enqueue');

/*-----  End of Load Scripts  ------*/