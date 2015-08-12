<?php
/**
 * Author: Ole Fredrik Lie
 * URL: http://olefredrik.com
 *
 * FoundationPress functions and definitions
 *
 * Set up the theme and provides some helper functions, which are used in the
 * theme as custom template tags. Others are attached to action and filter
 * hooks in WordPress to change core functionality.
 *
 * @link https://codex.wordpress.org/Theme_Development
 * @package WordPress
 * @subpackage FoundationPress
 * @since FoundationPress 1.0
 */

/** Various clean up functions */
require_once( 'library/cleanup.php' );

/** Required for Foundation to work properly */
require_once( 'library/foundation.php' );

/** Register all navigation menus */
require_once( 'library/navigation.php' );

/** Add desktop menu walker */
require_once( 'library/menu-walker.php' );

/** Add off-canvas menu walker */
require_once( 'library/offcanvas-walker.php' );

/** Create widget areas in sidebar and footer */
require_once( 'library/widget-areas.php' );

/** Return entry meta information for posts */
require_once( 'library/entry-meta.php' );

/** Enqueue scripts */
require_once( 'library/enqueue-scripts.php' );

/** Add theme support */
require_once( 'library/theme-support.php' );

/** Add Header image */
require_once( 'library/custom-header.php' );

/** Add Header image */
require_once( 'library/art/art.php' );


add_filter('post_gallery', 'my_post_gallery', 10, 2);
function my_post_gallery($output, $attr) {
    global $post;

    if (isset($attr['orderby'])) {
        $attr['orderby'] = sanitize_sql_orderby($attr['orderby']);
        if (!$attr['orderby'])
            unset($attr['orderby']);
    }

    extract(shortcode_atts(array(
        'order' => 'ASC',
        'orderby' => 'menu_order ID',
        'id' => $post->ID,
        'itemtag' => 'dl',
        'icontag' => 'dt',
        'captiontag' => 'dd',
        'columns' => 3,
        'size' => 'thumbnail',
        'include' => '',
        'exclude' => ''
    ), $attr));

    $id = intval($id);
    if ('RAND' == $order) $orderby = 'none';

    if (!empty($include)) {
        $include = preg_replace('/[^0-9,]+/', '', $include);
        $_attachments = get_posts(array('include' => $include, 'post_status' => 'inherit', 'post_type' => 'attachment', 'post_mime_type' => 'image', 'order' => $order, 'orderby' => $orderby));

        $attachments = array();
        foreach ($_attachments as $key => $val) {
            $attachments[$val->ID] = $_attachments[$key];
        }
    }

    if (empty($attachments)) return '';

    // Here's your actual output, you may customize it to your need
    $output .= "<ul data-orbit  data-options='variable_height:false;bullets:false'>\n";

    // Now you loop through each attachment
    foreach ($attachments as $id => $attachment) {
        // Fetch the thumbnail (or full image, it's up to you)
//      $img = wp_get_attachment_image_src($id, 'medium');
//      $img = wp_get_attachment_image_src($id, 'my-custom-image-size');
        $img = wp_get_attachment_image_src($id, 'medium');

        $output .= "<li>\n";
        $output .= "<img src=\"{$img[0]}\" width=\"{$img[1]}\" height=\"{$img[2]}\" alt=\"\" />\n";
        $output .= "<div class=\"orbit-caption\">".  $id . "</div>";
        $output .= "</li>\n";
    }

    $output .= "</ul>\n";

    return $output;
}
add_filter( 'use_default_gallery_style', '__return_false' );

/*=============================================
=            Register Post Type           =
=============================================*/


function arts_post_type() {
    register_post_type('art',
        array(
            'labels' => array(
                'name' => __('Art', 'art'),
                'singular_name' => __('Art Peice', 'art'),
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
            'rewrite' => array('slug' => 'art'),
        ));
}
add_action('init', 'arts_post_type');
/*-----  End of Section comment block  ------*/


/*=============================================
=            Register Custom Taxonomy           =
=============================================*/

// Register Custom Taxonomy
function art_series() {

    $labels = array(
        'name'                       => 'Art Series',
        'singular_name'              => 'Art Series',
        'menu_name'                  => 'Art Series',
        'all_items'                  => 'All Art Series',
        'parent_item'                => 'Parent Art Series',
        'parent_item_colon'          => 'Parent Art Series:',
        'new_item_name'              => 'New Art Series',
        'add_new_item'               => 'Add Art Series',
        'edit_item'                  => 'Edit Art Series',
        'update_item'                => 'Update Art Series',
        'view_item'                  => 'View Art Series',
        'separate_items_with_commas' => 'Separate Art Series with commas',
        'add_or_remove_items'        => 'Add or remove Art Series',
        'choose_from_most_used'      => 'Choose from the most used',
        'popular_items'              => 'Popular Art Series',
        'search_items'               => 'Search Art Series',
        'not_found'                  => 'Not Found',
    );
    $args = array(
        'labels'                     => $labels,
        'hierarchical'               => true,
        'public'                     => true,
        'show_ui'                    => true,
        'show_admin_column'          => true,
        'show_in_nav_menus'          => true,
        'show_tagcloud'              => false,
        'rewrite' => array('slug' => 'series'),
    );
    register_taxonomy( 'art_series', array( 'art' ), $args );

}
add_action( 'init', 'art_series', 0 );

function add_taxonomy_to_attachments() {
      register_taxonomy_for_object_type( 'art_series', 'attachment' );  
}  
add_action( 'init' , 'add_taxonomy_to_attachments' );


add_action("foundationpress_before_sidebar","add_featured_image_to_page");
function add_featured_image_to_page(){
    global $post;
    if (is_page() && has_post_thumbnail( $post->ID )) {
        the_post_thumbnail($post->ID );
    }
}
add_action('foundationpress_before_sidebar', 'art_information_cb');
function art_information_cb () {
    global $post;
    $terms = get_the_terms($post->id, 'art_series');
    if ( ! empty( $terms ) && ! is_wp_error( $terms ) && is_tax( 'art_series', $terms[0]->term_taxonomy_id ) ) {
        global $post;
        $terms = get_the_terms($post->id, 'art_series');
        echo "<h1 class=\"art\">" . $terms[0]->name . "</h1>";
        echo "<p>" . $terms[0]->description . "</p>";
    }
} 
function add_image(){
    global $post;
    echo "<div class=\"row\">";
    echo "<div class=\"column small-12\">";
    the_post_thumbnail();
    echo "</div>";
    echo "</div>";
}
add_action('before_art_piece','add_image');



function custom_taxonomy_order( $query ) {
    if ( $query->is_tax('art_series') && $query->is_main_query() ) {       
        $query->set( 'post_per_page', -1 );
        $query->set( 'meta_key', 'importance' );
        $query->set( 'meta_type', 'NUMERIC' );
        $query->set( 'orderby', 'meta_value' );
        $query->set( 'order', 'ASC' );           
    }
}
add_action( 'pre_get_posts', 'custom_taxonomy_order' );

function preloadHTML() {
    if (is_front_page()) {
        echo "<link rel=\"prerender\" href=\"http://jacquelinesecor.com/art/\" />";
    }
    if(is_archive()) {
        echo "<link rel=\"prerender\" href=\"http://jacquelinesecor.com/series/diversity-of-nature/\" />";
        echo "<link rel=\"prerender\" href=\"http://jacquelinesecor.com/series/defying-extinction/\" />";
    }
   
}
add_action( 'foundationpress_before_closing_body', 'preloadHTML');

