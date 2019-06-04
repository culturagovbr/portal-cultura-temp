<?php

function gutenberg_boilerplate_block() {
	// wp_enqueue_style( 'idg-wp-style', get_template_directory_uri() . '/assets/stylesheets/dist/bundle.min.css' );

	wp_register_script(
		'idgwp-gutenberg-block-card-scripts',
		// plugins_url( 'step-01/block.js', __FILE__ ),
		get_template_directory_uri() . '/assets/js/dist/admin.min.js',
		array( 'wp-blocks', 'wp-element' )
	);

	wp_enqueue_style(
		'idgwp-gutenberg-block-card-styles', // Handle.
		get_template_directory_uri() . '/assets/js/dist/admin.min.css',
		array('wp-edit-blocks')
	);

	register_block_type( 'gutenberg-boilerplate-es5/idgwp-gutenberg-block-card', array(
		'editor_script' => 'idgwp-gutenberg-block-card-scripts',
		'editor_style'  => 'idgwp-gutenberg-block-card-styles',
	) );

}
add_action( 'init', 'gutenberg_boilerplate_block' );
