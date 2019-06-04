<?php
/**
 * Custom post type = multimedia
 *
 */
function multimedia_custom_type() {
	$labels = array(
		'name'               => 'Multimídia',
		'singular_name'      => 'Multimídia',
		'add_new'            => 'Nova multimídia',
		'add_new_item'       => 'Nova multimídia',
		'edit_item'          => 'Editar multimídia',
		'new_item'           => 'Nova',
		'all_items'          => 'Todas as multimídias',
		'view_item'          => 'Visualizar multimídia',
		'search_items'       => 'Pesquisar por multimídias',
		'not_found'          => 'Nada encontrado',
		'not_found_in_trash' => 'Nada encontrado na lixeira',
		'parent_item_colon'  => '',
		'menu_name'          => 'Multimídia'
	);

	$args = array(
		'labels'             => $labels,
		'public'             => true,
		'publicly_queryable' => true,
		'show_ui'            => true,
		'show_in_menu'       => true,
		'show_in_nav_menus'  => true,
		'query_var'          => true,
		'capability_type'    => 'post',
		'has_archive'        => true,
		'hierarchical'       => false,
		'menu_position'      => _( 5 ),
		'menu_icon'          => 'dashicons-format-gallery',
		'supports'           => array(
			'title',
			'editor',
			'thumbnail',
			'excerpt',
			'post-formats'
		),
		'show_in_rest'      => true
	);
	register_post_type( 'multimedia', $args );
	flush_rewrite_rules( true );
}
add_action( 'init', 'multimedia_custom_type' );

function create_multimedia_taxonomies() {
	$labels = array(
		'name'          => 'Tipo de mídia',
		'singular_name' => 'Tipo de mídia'
	);

	$args = array(
		'hierarchical'      => true,
		'labels'            => $labels,
		'show_ui'           => true,
		'show_admin_column' => true,
		'query_var'         => true,
		'rewrite'           => array( 'slug' => 'tipo' ),
		'show_in_menu'      => false,
		'capabilities'      => array(
			'assign_terms' => 'manage_options',
		    'edit_terms'   => false,
		    'manage_terms' => false
		),
		'show_in_rest'          => true
	);

	register_taxonomy( 'multimedia-type', 'multimedia', $args );
}
add_action( 'init', 'create_multimedia_taxonomies', 0 );

function multimedia_default_formats() {
	wp_insert_term( 'Áudio', 'multimedia-type', array( 'slug' => 'audio' ) );
	wp_insert_term( 'Imagem', 'multimedia-type', array( 'slug' => 'image' ) );
	wp_insert_term( 'Vídeo', 'multimedia-type', array( 'slug' => 'video' ) );
}
add_action( 'init', 'multimedia_default_formats', 0 );

function multimedia_terms_as_radio_checklist( $args ) {
	if ( ! empty( $args['taxonomy'] ) && $args['taxonomy'] === 'multimedia-type' ) {
		if ( empty( $args['walker'] ) || is_a( $args['walker'], 'Walker' ) ) {
			if ( ! class_exists( 'Multimedia_Terms_As_Radio_Checklist' ) ) {
				class Multimedia_Terms_As_Radio_Checklist extends Walker_Category_Checklist {
					function walk( $elements, $max_depth, $args = array() ) {
						$output = parent::walk( $elements, $max_depth, $args );
						$output = str_replace(
							array( 'type="checkbox"', "type='checkbox'" ),
							array( 'type="radio"', "type='radio'" ),
							$output
						);

						return $output;
					}
				}
			}
			$args['walker'] = new Multimedia_Terms_As_Radio_Checklist;
		}
	}
	return $args;
}
add_filter( 'wp_terms_checklist_args', 'multimedia_terms_as_radio_checklist' );


function prevent_create_new_taxonomy_multimedia_type( $term, $taxonomy ) {
	return ( 'multimedia-type' === $taxonomy ) ? new WP_Error( 'term_addition_blocked', __( 'You cannot add terms to this taxonomy' ) ) : $term;
}
// add_action( 'pre_insert_term', 'prevent_create_new_taxonomy_multimedia_type', 0, 2 );
