<?php
/*
 * Example setup for the magicsuggest field for CMB2.
 */

/**
 * Get the bootstrap! If using as a plugin, REMOVE THIS!
 */
require_once WPMU_PLUGIN_DIR . '/cmb2/init.php';

if ( ! function_exists( 'cmb2_magicsuggest_render' ) ) {
	require_once WPMU_PLUGIN_DIR . '/cmb2-magicsuggest/cmb2-magicsuggest-field.php';
}


function get_some_posts_data() {
    
    $query_args = array(
        'post_type'         => 'post',
        'posts_per_page'    => 20,
        'orderby'           => 'date',
        'order'             => 'ASC',
    );

    $data = array();

    // Get our posts
    $posts = get_posts( $query_args );
    if ( $posts ) {

        foreach ( $posts as $post ) {

            $post_data = array(
                'post_id' => $post->ID,
                'post_title' => get_the_title( $post->ID) );

            $data[] = $post_data;
        }
    }

    return $data;
}

/**
 * Define the metabox and field configurations.
 *
 * @param  array $meta_boxes
 * @return array
 */
function cmb2_magicsuggest_metaboxes_example() {

	$prefix = '_cmb2_magicsuggest_demo_';

	$example_meta = new_cmb2_box( array(
		'id'           => $prefix . 'metabox',
		'title'        => __( 'cmb2-magicsuggest-field demo', 'cmb2' ),
		'object_types' => array( 'page' ), // Post type
		'context'      => 'normal',
		'priority'     => 'high',
		'show_names'   => true, // Show field names on the left
	) );

	$example_meta->add_field( array(
		'name'    => __( 'Grab some fruits', 'cmb2' ),
		'desc'    => __( 'Enter up to 6 fruits.', 'cmb2' ),
		'id'      => $prefix . 'fruits',
		'type'    => 'magicsuggest',
        'options' => array(
            'data'  =>  array('Banana', 'Apple', 'Orange', 'Lemon', 'Kiwi'),
            'allow_free_entries' => true,
            'max_selection'      => 6,  // limit the number of items entered.
            //'expand_on_focus'    => false,
        ),
        'attributes'  => array(
            'placeholder' => 'Add or grab some fruit here',
            //'required'    => 'required',
        ),
	) );

	$example_meta->add_field( array(
		'name'    => __( 'Related Posts', 'cmb2' ),
		'desc'    => __( 'Add related posts', 'cmb2' ),
		'id'      => $prefix . 'related_posts',
		'type'    => 'magicsuggest',
        'options' => array(
            'data'  =>  get_some_posts_data(),
            'expand_on_focus'    => true,
            'allow_free_entries' => false,
            'value_field'        => 'post_id',     	// specifies the key to be used for value.
            'display_field'      => 'post_title',  	// specifies the key to be used for display.
        ),
        'attributes'  => array(
            'placeholder' => 'Enter a related post title here..',
            //'required'    => 'required',
        ),
	) );
}

add_action( 'cmb2_init', 'cmb2_magicsuggest_metaboxes_example' );
