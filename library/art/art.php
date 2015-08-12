<?php
/*=============================================
=            Add Meta Boxes            =
=============================================*/

function upload_dir() {
	$upload_dir = wp_upload_dir();
	return $upload_dir['baseurl'] . '/';
}
add_shortcode( 'upload_dir', 'upload_dir' );

function art_add_meta_box() {
	add_meta_box('art_sectionid','Art Piece Details','art_add_meta_box_callback','art', 'side', 'high');
}
add_action( 'add_meta_boxes', 'art_add_meta_box' );

$custom_fields = [
		["text","size"],
		["text","medium"],
        ["number","importance"],
	];
function art_add_meta_box_callback( $post ) {
    wp_nonce_field( basename( __FILE__ ), 'art_nonce' );
    $post_stored_meta = get_post_meta( $post->ID );

    global $custom_fields;

	echo "<div class='art'>";
	$i=0;
    foreach ($custom_fields as $custom_field) {
    	if ($custom_field[0] == "text") {
    		$code =  "<p>";
    		$code .= "<label for=\"".$custom_field[1]."\">".$custom_field[1]."</label>";
    		$code .= '<input type="text" name="'.$custom_field[1].'" value="';
    		if ( isset ( $post_stored_meta[$custom_field[1]][0] ) ) {
    			$code .= $post_stored_meta[$custom_field[1]][0];
    		}
    		$code .= '"/>';
    		$code .= '</p>';
    		echo $code;
    	} elseif ($custom_field[0] == "image"){
    		$code =  "<p>";
    		$code .= "<label for=\"".$custom_field[1]."\">".$custom_field[1]."</label>";
    		$code .= '<input type="text" name="'.$custom_field[1].'" value="';
    		if ( isset ( $post_stored_meta[$custom_field[1]][0] ) ) {
    			$code .= $post_stored_meta[$custom_field[1]][0];
    		}
    		$code .= '"/>';
    		$code .= '<div class="upload-image">Upload Image</div>';
    		$code .= '</p>';
    		echo $code;
    	}
        elseif ($custom_field[0] == "number"){
            $code =  "<p>";
            $code .= "<label for=\"".$custom_field[1]."\">".$custom_field[1]."</label>";
            $code .= '<input type="number" step="any" name="'.$custom_field[1].'" value="';
            if ( isset ( $post_stored_meta[$custom_field[1]][0] ) ) {
                $code .= $post_stored_meta[$custom_field[1]][0];
            }
            $code .= '"/>';
            $code .= '</p>';
            echo $code;
        }
    	$i++;
	}
	echo "</div>";
 ?>
 
<?php }



function art_meta_save( $post_id ) {
 
    $is_autosave = wp_is_post_autosave( $post_id );
    $is_revision = wp_is_post_revision( $post_id );
    $is_valid_nonce = ( isset( $_POST[ 'art_nonce' ] ) && wp_verify_nonce( $_POST[ 'art_nonce' ], basename( __FILE__ ) ) ) ? 'true' : 'false';
 
    if ( $is_autosave || $is_revision || !$is_valid_nonce ) {
        return;
    }

    global $typenow;
	if ($typenow == 'art') {
    	global $custom_fields;
		foreach ($custom_fields as $custom_field) {
			if( isset( $_POST[ $custom_field[1]  ] ) ) {
        		update_post_meta( $post_id, $custom_field[1], $_POST[ $custom_field[1] ] );
    		}
		}
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

/*=============================================
=            Functions for content           =
=============================================*/
