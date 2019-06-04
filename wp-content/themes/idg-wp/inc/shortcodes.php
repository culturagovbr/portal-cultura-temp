<?php

/**
 * Implements a @TODO
 *
 */
class IDGWPShortcodes {

	public function __construct() {
		add_shortcode( 'idgwp-menu', array( $this, 'idgwp_menu' ) );

		// add_action( 'init', array( $this, 'register_pp_tinymce_button' ) );
	}

	public function idgwp_menu( $params ) {
		// extract the attributes into variables
		extract( shortcode_atts( array(
			'menu' => true
		), $params ) );

		ob_start();

		/*
		$menu = wp_get_nav_menu_object( $params['menu'] );

		$item_class = '';
		if( $menu->count % 4 == 0 ){
			$item_class = 'col-md-3';
		} elseif ( $menu->count % 3 == 0 ) {
			$item_class = 'col-md-4';
		} elseif ( $menu->count % 2 == 0 ) {
			$item_class = 'col-md-6';
		} else {
			$item_class = 'col-md-3';
		}*/

		$item_class = 'col-md-3';

		$menu_args = array(
			'menu'            => $params['menu'],
			'depth'           => 1,
			'container'       => 'div',
			'container_class' => 'row idg-menu align-items-center wrapper-box',
			'fallback_cb'     => false,
			'items_wrap'      => '%3$s',
			'before'          => '<div class="'. $item_class .'"><div class="feature-card static-height"><div class="align"><h3 class="card-title">',
			'after'           => '</h3></div></div></div>',
			'echo'            => false,
		);

		echo strip_tags( wp_nav_menu( $menu_args ), '<div><h3><a>' );

		return ob_get_clean();
	}

}

$idgwp_shortcodes = new IDGWPShortcodes();
