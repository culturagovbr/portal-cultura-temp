<?php
/**
 * Functions which enhance the theme by hooking into WordPress
 *
 * @package Identidade_Digital_do_Governo_-_WordPress
 */

/**
 * Add a pingback url auto-discovery header for single posts, pages, or attachments.
 */
function idg_wp_pingback_header() {
	if ( is_singular() && pings_open() ) {
		echo '<link rel="pingback" href="', esc_url( get_bloginfo( 'pingback_url' ) ), '">';
	}
}
add_action( 'wp_head', 'idg_wp_pingback_header' );

/**
 * Register meta box to post type.
 */
function idg_register_meta_boxes() {
	add_meta_box(
		'post-custom-subtitle',
		'Chapéu da postagem',
		'idg_custom_subtitle_display_callback',
		'post',
		'side',
		'high'
	);
}
add_action( 'add_meta_boxes', 'idg_register_meta_boxes' );

/**
 * Meta box display callback.
 *
 * @param WP_Post $post Current post object.
 */
function idg_custom_subtitle_display_callback( $post ) {
	wp_nonce_field( plugin_basename( __FILE__ ), 'idg_custom_subtitle_nonce' );
	$value = get_post_meta( $post->ID, '_post_subtitle', true );
	echo '<label for="post_subtitle" style="margin-bottom: 10px;display: block;">Preencha com o subtítulo para a postagem</label>';
	echo '<input type="text" id="post_subtitle" name="post_subtitle" value="'.esc_attr($value).'" style="width:100%;" />';
}

/**
 * Save meta box content.
 *
 * @param int $post_id Post ID
 */
function idg_custom_subtitle_save_meta_box( $post_id ) {
	if ( 'page' == $_POST['post_type'] ) {
		if ( ! current_user_can( 'edit_page', $post_id ) )
			return;
	} else {
		if ( ! current_user_can( 'edit_post', $post_id ) )
			return;
	}

	if ( ! isset( $_POST['idg_custom_subtitle_nonce'] ) || ! wp_verify_nonce( $_POST['idg_custom_subtitle_nonce'], plugin_basename( __FILE__ ) ) )
		return;


	$post_ID = $_POST['post_ID'];
	$mydata = sanitize_text_field( $_POST['post_subtitle'] );
	update_post_meta($post_ID, '_post_subtitle', $mydata);
}
add_action( 'save_post', 'idg_custom_subtitle_save_meta_box' );
