<?php
/**
 * Plugin Name:       Gov Schedules
 * Plugin URI:        https://github.com/culturagovbr/
 * Description:       @TODO
 * Version:           1.0.0
 * Author:            Ricardo Carvalho
 * Author URI:        https://github.com/darciro/
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 */

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}

if ( ! class_exists( 'Gov_Schedules' ) ) :

	class Gov_Schedules {

		private $screens = array(
			'event',
		);

		private $cur_user;

		private $fields = array(
			/*array(
				'id' => 'dia-todo',
				'label' => 'Dia todo',
				'type' => 'checkbox',
			),*/
			array(
				'id'    => 'data-de-incio',
				'label' => 'Data de início',
				'type'  => 'text',
			),
			array(
				'id'    => 'data-de-fim',
				'label' => 'Data de fim',
				'type'  => 'text',
			),
			array(
				'id'    => 'location',
				'label' => 'Local',
				'type'  => 'text',
			),
		);

		public function __construct() {
			//setlocale( LC_TIME, 'pt_BR', 'pt_BR.utf-8', 'pt_BR.utf-8', 'portuguese' );
			//date_default_timezone_set( 'America/Sao_Paulo' );

			add_action( 'init', array( $this, 'event_cpt' ) );
			add_filter( 'manage_event_posts_columns', array( $this, 'add_event_columns' ) );
			add_action( 'manage_posts_custom_column', array( $this, 'event_custom_columns' ), 10, 2 );
			add_action( 'wp_enqueue_scripts', array( $this, 'register_gs_styles' ) );
			add_action( 'admin_enqueue_scripts', array( $this, 'register_gs_admin_styles' ) );
			add_action( 'wp_enqueue_scripts', array( $this, 'register_gs_scripts' ) );
			add_action( 'admin_enqueue_scripts', array( $this, 'register_gs_admin_scripts' ) );
			add_action( 'add_meta_boxes', array( $this, 'add_meta_boxes' ) );
			add_action( 'pre_post_update', array( $this, 'before_save_post' ) );
			add_action( 'save_post', array( $this, 'save_post' ) );
			add_action( 'init', array( $this, 'gs_shortcodes' ) );
			add_action( 'wp_ajax_gs_get_week_events', array( $this, 'gs_get_week_events' ) );
			add_action( 'wp_ajax_nopriv_gs_get_week_events', array( $this, 'gs_get_week_events' ) );
			add_action( 'archive_template', array( $this, 'gs_custom_archive_template' ) );
			add_action( 'wp_ajax_gs_get_sub_cats', array( $this, 'gs_get_sub_cats' ) );
			add_action( 'wp_ajax_nopriv_gs_get_sub_cats', array( $this, 'gs_get_sub_cats' ) );
			add_action( 'event-category_add_form_fields', array( $this, 'event_category_add_meta_field' ), 10, 2 );
			add_action( 'event-category_edit_form_fields', array( $this, 'event_category_edit_meta_field' ), 10, 2 );
			add_action( 'edited_event-category', array( $this, 'event_category_save_taxonomy_meta_field' ), 10, 2 );
			add_action( 'create_event-category', array( $this, 'event_category_save_taxonomy_meta_field' ), 10, 2 );
			// add_action( 'init', array( $this, 'agenda_cats_rewrite' ), 10, 0 );
			// add_action( 'parse_query', array( $this, 'agenda_cats_rewrite_parse_query' ) );
			/*add_action( 'wp_ajax_gs_get_current_agenda_manager', array( $this, 'gs_get_current_agenda_manager' ) );
			add_action( 'wp_ajax_nopriv_gs_get_current_agenda_manager', array( $this, 'gs_get_current_agenda_manager' ) );*/
			// add_filter( 'rest_event-category_query', array( $this, 'event_categories_filter_based_on_role' ), 10, 2 );
			add_action( 'wp_loaded', array( $this, 'getCurrentUser' ) );
			add_action( 'admin_head', array( $this, 'agenda_manager_role_custom_style' ) );
		}

		public function getWPPM() {

			if ( ! did_action( 'wp_loaded' ) ) {
				$msg = 'Please call getCurrentUser after wp_loaded is fired.';

				return new WP_Error( 'to_early_for_user', $msg );
			}

			static $wp_pm = null;

			if ( is_null( $wp_pm ) ) {
				$wp_pm = new WP_PM( new WP_PM_User( get_current_user_id() ) );
			}

			return $wp_pm;
		}

		public function getCurrentUser() {

			$wppm = $this->getWPPM();

			if ( is_wp_error( $wppm ) ) {
				return $wppm;
			}

			$user = $wppm->getUser();
			if ( $user instanceof WP_PM_User ) {
				return $user;
			}
		}

		public function excludedTerms() {
			$current_user = $this->getCurrentUser();
			if ( $current_user instanceof WP_PM_User ) {
				$permitted_roles = array('administrator', 'editor');

				if ( in_array($current_user->roles[0], $permitted_roles ) ) {
					return;
				}

				$elements = get_terms(
					array(
						'taxonomy'   => 'event-category',
						'hide_empty' => false
					)
				);
				$excludes = array();
				foreach ( $elements as $i => $el ) {
					$term_meta = get_term_meta( $el->term_id );
					if ( ! in_array( $current_user->roles[0], unserialize( $term_meta['role_permission'][0] ) ) ) {
						array_push( $excludes, $el->term_id );
						unset( $elements[ $i ] );
					}
				}

				return $excludes;
			}
		}

		/**
		 * Create a custom post type to manage events
		 *
		 */
		public function event_cpt() {
			register_post_type( 'event', array(
					'labels'       => array(
						'name'          => 'Agenda',
						'singular_name' => 'Evento',
						'add_new'       => 'Novo evento',
						'add_new_item'  => 'Novo evento',
					),
					'description'  => 'Calendário de Eventos',
					'public'       => true,
					'has_archive'  => true,
					'taxonomies'   => array( 'event-category' ),
					'supports'     => array( 'title', 'editor', 'excerpt', 'custom-fields' ),
					'menu_icon'    => 'dashicons-calendar-alt',
					'rewrite'      => array(
						'slug' => 'agenda'
					),
					'show_in_rest' => true,
					// 'capability_type' => 'post',
					'map_meta_cap'    => true,
				)
			);

			$labels = array(
				'name'          => 'Categorias do evento',
				'singular_name' => 'Categoria do evento',
				'search_items'  => 'Buscar por categorias',
				'all_items'     => 'Todas as categorias',
				'edit_item'     => 'Editar categoria',
				'update_item'   => 'Atualizar categoria',
				'add_new_item'  => 'Nova categoria',
				'new_item_name' => 'Nova categoria',
				'menu_name'     => 'Categorias do evento',
			);

			$args = array(
				'hierarchical'      => true,
				'labels'            => $labels,
				'show_ui'           => true,
				'show_admin_column' => true,
				'query_var'         => true,
				'rewrite'           => array( 'slug' => 'event-category' ),
				'show_in_rest'      => true
			);

			register_taxonomy( 'event-category', 'event', $args );
		}

		/**
		 * Add new columns to our custom post type
		 *
		 * @param $columns
		 *
		 * @return array
		 */
		public function add_event_columns( $columns ) {
			return array_merge( $columns, array(
				'author' => 'Criador do evento',
				'start_date' => 'Data de início',
				'end_date'   => 'Data de fim',
				'location'   => 'Local'
			) );
		}

		/**
		 * Fill custom columns with data
		 *
		 * @param $column
		 * @param $post_id
		 */
		public function event_custom_columns( $column, $post_id ) {
			switch ( $column ) {
				case 'start_date':
					$date     = get_post_meta( $post_id, 'dados_do_evento_data-de-incio', true );
					$raw_date = explode( ' ', $date );
					$d        = implode( '/', array_reverse( explode( '-', $raw_date[0] ) ) ) . ' ' . $raw_date[1];
					echo $d;
					break;
				case 'end_date':
					$date     = get_post_meta( $post_id, 'dados_do_evento_data-de-fim', true );
					$raw_date = explode( ' ', $date );
					$d        = implode( '/', array_reverse( explode( '-', $raw_date[0] ) ) ) . ' ' . $raw_date[1];
					echo $d;
					break;
				case 'location':
					$location = get_post_meta( $post_id, 'dados_do_evento_location', true );
					echo $location;
					break;
			}
		}

		/**
		 * Register stylesheet for our plugin
		 *
		 */
		public function register_gs_styles() {
			wp_register_style( 'gov-schedules-styles', plugin_dir_url( __FILE__ ) . 'assets/css/gov-schedules.css' );
			wp_enqueue_style( 'gov-schedules-styles' );
		}

		/**
		 * Register stylesheet for our plugin
		 *
		 */
		public function register_gs_admin_styles() {
			wp_register_style( 'jquery-ui-timepicker-addon-styles', plugin_dir_url( __FILE__ ) . 'assets/css/jquery-ui-timepicker-addon.css' );
			wp_register_style( 'select2', plugin_dir_url( __FILE__ ) . 'assets/css/select2.min.css' );
			wp_register_style( 'gs-admin-styles', plugin_dir_url( __FILE__ ) . 'assets/css/gs-admin-styles.css' );
			wp_enqueue_style( 'jquery-ui-timepicker-addon-styles' );
			wp_enqueue_style( 'select2' );
			wp_enqueue_style( 'gs-admin-styles' );
		}

		/**
		 * Register JS for our plugin
		 *
		 */
		public function register_gs_scripts() {
			wp_enqueue_script( 'jquery-ui-datepicker' );
			wp_enqueue_script( 'gs-scripts-scripts', plugin_dir_url( __FILE__ ) . 'assets/js/gs-scripts.js', array( 'jquery', 'jquery-ui-datepicker' ), false, true );
			wp_localize_script( 'gs-scripts-scripts', 'oscar_minc_vars', array(
					'ajaxurl'           => admin_url( 'admin-ajax.php' ),
					'upload_file_nonce' => wp_create_nonce( 'oscar-video' ),
				)
			);
		}

		/**
		 * Register admin JS for our plugin
		 *
		 */
		public function register_gs_admin_scripts() {
			wp_enqueue_script( 'jquery-ui-timepicker-addon', plugin_dir_url( __FILE__ ) . 'assets/js/jquery-ui-timepicker-addon.js', array( 'jquery', 'jquery-ui-datepicker', 'jquery-ui-spinner' ), false, true );
			wp_enqueue_script( 'select2', plugin_dir_url( __FILE__ ) . 'assets/js/select2.full.min.js', array( 'jquery' ), false, true );
			wp_enqueue_script( 'gs-admin-scripts', plugin_dir_url( __FILE__ ) . 'assets/js/gs-admin-scripts.js', array( 'jquery-ui-timepicker-addon', 'select2', 'wp-blocks', 'wp-element' ), false, true );

			/*$restricted_roles = array( 'agenda_manager' );
			$screen           = get_current_screen();
			$user             = wp_get_current_user();

			if ( $screen->id === 'event' && in_array( $user->roles[0], $restricted_roles ) ) {

				$elements = get_terms(
					array(
						'taxonomy'   => 'event-category',
						'hide_empty' => false
					)
				);
				$excludes = array();
				foreach ( $elements as $i => $el ) {
					$term_meta = get_term_meta( $el->term_id );
					if ( ! in_array( $user->roles[0], unserialize( $term_meta['role_permission'][0] ) ) ) {
						array_push( $excludes, $el->term_id );
						unset( $elements[ $i ] );
					}
				}

				$this->setGS( 'Foo' );
				$this->foo = $foo = 'Foobar';

				wp_localize_script( 'gs-admin-scripts', 'gsData', array(
						'restricted_roles'    => true,
						'taxonomies_excluded' => $excludes,
					)
				);
			}*/
		}

		public function setGS( $var ) {
			$this->gs = $var;
		}

		/**
		 * Hooks into WordPress' add_meta_boxes function.
		 * Goes through screens (post types) and adds the meta box.
		 */
		public function add_meta_boxes() {
			foreach ( $this->screens as $screen ) {
				add_meta_box(
					'dados-do-evento',
					__( 'Dados do evento', 'gs' ),
					array( $this, 'add_meta_box_callback' ),
					$screen,
					'normal',
					'default'
				);
			}
		}

		/**
		 * Generates the HTML for the meta box
		 *
		 * @param object $post WordPress post object
		 */
		public function add_meta_box_callback( $post ) {
			wp_nonce_field( 'dados_do_evento_data', 'dados_do_evento_nonce' );
			$this->generate_fields( $post );
		}

		/**
		 * Generates the field's HTML for the meta box.
		 */
		public function generate_fields( $post ) {
			$output = '';
			foreach ( $this->fields as $field ) {
				$label    = '<label for="' . $field['id'] . '">' . $field['label'] . '</label>';
				$db_value = get_post_meta( $post->ID, 'dados_do_evento_' . $field['id'], true );
				$raw_date = explode( ' ', $db_value );
				$db_value = implode( '/', array_reverse( explode( '-', $raw_date[0] ) ) ) . ' ' . $raw_date[1];
				switch ( $field['type'] ) {
					case 'checkbox':
						$input = sprintf(
							'<input %s id="%s" name="%s" type="checkbox" value="1">',
							$db_value === '1' ? 'checked' : '',
							$field['id'],
							$field['id']
						);
						break;
					default:
						if ( $field['id'] !== 'location' ) {
							$input = sprintf(
								'<input %s id="%s" name="%s" type="%s" value="%s">',
								$field['type'] !== 'color' ? 'class="regular-text datepicker"' : '',
								$field['id'],
								$field['id'],
								$field['type'],
								$db_value
							);
						} else {
							$input = sprintf(
								'<input class="regular-text" id="%s" name="%s" type="%s" value="%s">',
								$field['id'],
								$field['id'],
								$field['type'],
								$db_value
							);
						}

				}
				$output .= $this->row_format( $label, $input );
			}
			echo '<table class="form-table"><tbody>' . $output . '</tbody></table>';
		}

		/**
		 * Generates the HTML for table rows.
		 */
		public function row_format( $label, $input ) {
			return sprintf(
				'<tr><th scope="row">%s</th><td>%s</td></tr>',
				$label,
				$input
			);
		}

		public function before_save_post ()
		{
			$role = get_role( 'agenda_manager' );
			$role->add_cap( 'edit_others_posts' );
			$role->add_cap( 'delete_others_posts' );
		}

		/**
		 * Hooks into WordPress' save_post function
		 */
		public function save_post( $post_id ) {

			if ( ! isset( $_POST['dados_do_evento_nonce'] ) ) {
				return $post_id;
			}

			$nonce = $_POST['dados_do_evento_nonce'];
			if ( ! wp_verify_nonce( $nonce, 'dados_do_evento_data' ) ) {
				return $post_id;
			}

			if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
				return $post_id;
			}

			// unhook this function so it doesn't loop infinitely
			remove_action( 'save_post', array( $this, 'save_post' ) );

			// update the post, which calls save_post again
			if( wp_update_post( array( 'ID' => $post_id, 'post_author' => get_current_user_id() ) ) ){

				foreach ( $this->fields as $field ) {

					if ( isset( $_POST[ $field['id'] ] ) ) {

						switch ( $field['type'] ) {
							case 'email':
								$_POST[ $field['id'] ] = sanitize_email( $_POST[ $field['id'] ] );
								break;
							case 'text':
								if ( $field['id'] !== 'location' ) {
									$raw_date              = explode( ' ', $_POST[ $field['id'] ] );
									$_POST[ $field['id'] ] = implode( '-', array_reverse( explode( '/', $raw_date[0] ) ) ) . ' ' . $raw_date[1];
								} else {
									$_POST[ $field['id'] ] = sanitize_text_field( $_POST[ $field['id'] ] );
								}
								break;
						}

						update_post_meta( $post_id, 'dados_do_evento_' . $field['id'], $_POST[ $field['id'] ] );

					} else if ( $field['type'] === 'checkbox' ) {

						update_post_meta( $post_id, 'dados_do_evento_' . $field['id'], '0' );

					}

				}

				global $wp_roles;
				$wp_roles->remove_cap( 'agenda_manager', 'edit_others_posts' );
				$wp_roles->remove_cap( 'agenda_manager', 'delete_others_posts' );

				$role = get_role( 'agenda_manager' );
				$role->remove_cap( 'edit_others_posts' );
				$role->remove_cap( 'delete_others_posts' );
			}

			// re-hook this function
			add_action( 'save_post', array( $this, 'save_post' ) );
		}

		/**
		 * Shortcodes
		 *
		 * @param $atts
		 *
		 * @return string
		 */
		public function gs_shortcodes( $atts ) {
			require_once plugin_dir_path( __FILE__ ) . 'inc/shortcodes.php';
			$gs_shortcodes = new Gov_Schedules_Shortcodes();
		}

		/**
		 * Return data from events based on params sent
		 *
		 */
		public function gs_get_week_events() {
			$d          = $_POST['date'];
			$c          = $_POST['event_category'];
			$daypicker  = '';
			$events     = '';
			$month      = explode( '-', $d );
			$month      = $month[1];
			$dateObj    = DateTime::createFromFormat( '!m', $month );
			$month_name = strftime( '%b', $dateObj->format( 'U' ) );

			for ( $i = 3; $i >= 1; $i -- ) {
				$date = date_create( $d );
				date_sub( $date, date_interval_create_from_date_string( $i . ' days' ) );

				$daypicker .= '<li>';
				$daypicker .= '<a href="#" data-day="' . date_format( $date, 'Y-m-d' ) . '">';
				$daypicker .= '<span>' . date_format( $date, 'd' ) . '</span>';
				$daypicker .= '<small>' . date_i18n( 'D', strtotime( date_format( $date, 'Y-m-d' ) ) ) . '</small>';
				$daypicker .= '</a>';
				$daypicker .= '</li>';
			}

			for ( $i = 0; $i <= 3; $i ++ ) {
				$date = date_create( $d );
				date_add( $date, date_interval_create_from_date_string( $i . ' days' ) );

				$daypicker .= $i === 0 ? '<li class="selected">' : '<li>';
				$daypicker .= '<a href="#" data-day="' . date_format( $date, 'Y-m-d' ) . '">';
				$daypicker .= '<span>' . date_format( $date, 'd' ) . '</span>';
				$daypicker .= '<small>' . date_i18n( 'D', strtotime( date_format( $date, 'Y-m-d' ) ) ) . '</small>';
				$daypicker .= '</a>';
				$daypicker .= '</li>';
			}

			$args = array(
				'post_type'  => 'event',
				'tax_query'  => array(
					array(
						'taxonomy' => 'event-category',
						'field'    => 'slug',
						'terms'    => $c,
					)
				),
				'meta_query' => array(
					'relation' => 'OR',
					array(
						'key'     => 'dados_do_evento_data-de-incio',
						'value'   => $d,
						'compare' => '=',
						'type'    => 'DATE'
					),
					array(
						'relation' => 'AND',
						array(
							'key'     => 'dados_do_evento_data-de-incio',
							'value'   => $d,
							'compare' => '<=',
							'type'    => 'DATE'
						),
						array(
							'key'     => 'dados_do_evento_data-de-fim',
							'value'   => $d,
							'compare' => '>=',
							'type'    => 'DATE'
						),
						array(
							'key'     => 'dados_do_evento_data-de-fim',
							'value'   => '',
							'compare' => '!='
						)
					)
				)
			);

			$query = new WP_Query( $args );
			if ( $query->have_posts() ):

				while ( $query->have_posts() ) : $query->the_post();

					$location = get_post_meta( get_the_ID(), 'dados_do_evento_location', true );
					$date     = get_post_meta( get_the_ID(), 'dados_do_evento_data-de-incio', true );
					$raw_date = explode( ' ', $date );

					$events .=	'<div class="col-md-4 ml">';
					$events .=	'	<div class="event-item">';
					$events .=	'		<h2><a href="'. get_the_permalink() .'">' . get_the_title() . '</a></h2>';

					$events .=	'		<div class="info">';
					$events .=	'			<span class="time icon icon-clock">'. $raw_date[1] .'</span>';
					$events .=	'			<span class="location icon icon-location">' . $location . '</span>';
					$events .=	'		</div>';
					$events .=	'		<span class="location d-none icon icon-location">' . $location . '</span>';
					$events .=	'	</div>';
					$events .=	'</div>';

					// $events .= '<div class="event row">';
					// $events .= '<div class="time">';
					// $events .= '<span class="icon icon-clock">' . $raw_date[1] . '</span>';
					// $events .= '</div>';
					// $events .= '<div class="info">';
					// $events .= '<h2><a href="' . get_the_permalink() . '">' . get_the_title() . '</a></h2>';
					// $events .= '<div class="additional">';
					// $events .= '<span class="location icon icon-location">' . $location . '</span>';
					// //$events .= '<a href="#">Adicionar ao meu calendário</a>';
					// $events .= '</div>';
					// $events .= '</div>';
					// $events .= '</div>';

				endwhile;
				wp_reset_query();

			else:

				$events = false;

			endif;

			$data = array(
				'month'  => $month_name,
				'weeks'  => $daypicker,
				'events' => $events
			);
			wp_send_json_success( $data );
		}

		/**
		 * Defines a custom archive page for events post type
		 *
		 * @param $template
		 *
		 * @return mixed
		 */
		function gs_custom_archive_template( $template ) {
			global $wp_query;
			if ( is_post_type_archive( 'event' ) ) {
				$template = require_once plugin_dir_path( __FILE__ ) . 'inc/archive-event.php';
			}

			return $template;
		}

		/**
		 * Return the select form field for event categories with children
		 *
		 */
		public function gs_get_sub_cats() {
			$catID = $_POST['cat_id'];

			$event_cats = get_terms( 'event-category', array(
				'hide_empty' => 0,
				'child_of'   => $catID
			) );

			ob_start();
			?>

			<div class="event-sub-category input-group mt-2 col">
				<label for="event-categories-selector-<?php echo $catID; ?>" class="sr-only">Selecione a agenda</label>
				<select id="event-categories-selector-<?php echo $catID; ?>" class="form-control event-categories-selector">
					<?php foreach ( $event_cats as $cat ): ?>

						<?php if ( $cat->parent === intval( $catID ) ):
							$has_child = get_term_children( $cat->term_id, 'event-category' );
							?>
							<option value="<?php echo $cat->slug; ?>" <?php echo ! empty( $has_child ) ? 'data-has-children="true"' : '';
							echo 'data-term-id="' . $cat->term_id . '"'; ?>><?php echo $cat->name; ?></option>
						<?php endif; ?>

					<?php endforeach; ?>
				</select>
			</div>


			<?php
			$data = ob_get_clean();
			wp_send_json_success( $data );
		}

		/**
		 * Adds custom fields to add event category form
		 *
		 */
		public function event_category_add_meta_field() {
			global $wp_roles;
			$all_roles      = $wp_roles->roles;
			$editable_roles = apply_filters( 'editable_roles', $all_roles );
			?>
			<!--<div class="form-field">
				<label for="term_meta[custom_term_meta]"><?php _e( 'Example meta field', 'pippin' ); ?></label>
				<input type="text" name="term_meta[custom_term_meta]" id="term_meta[custom_term_meta]" value="">
				<p class="description"><?php _e( 'Enter a value for this field', 'pippin' ); ?></p>
			</div>-->
			<div class="form-field">
				<label for="term_meta[custom_term_meta]">Permissão</label>
				<select multiple="multiple" id="role_permission" name="term_meta[role_permission][]" style="width: 95%;">
					<?php foreach ( $editable_roles as $role => $role_data ): ?>
						<option value="<?php echo $role; ?>"><?php echo $role_data['name']; ?></option>
					<?php endforeach; ?>
				</select>
				<p class="description">Os perfis selecionados terão permissão para editar, publicar e deletar essa categoria de agenda.</p>
			</div>
			<?php
		}

		/**
		 *  Adds custom fields to edit event category form
		 *
		 * @param $term
		 */
		public function event_category_edit_meta_field( $term ) {
			// Roles
			global $wp_roles;
			$all_roles      = $wp_roles->roles;
			$editable_roles = apply_filters( 'editable_roles', $all_roles );

			// put the term ID into a variable
			$t_id      = $term->term_id;
			$term_meta = get_term_meta( $t_id ); ?>
			<!--<tr class="form-field">
				<th scope="row" valign="top"><label for="term_meta[custom_term_meta]"><?php _e( 'Example meta field', 'pippin' ); ?></label></th>
				<td>
					<input type="text" name="term_meta[custom_term_meta]" id="term_meta[custom_term_meta]" value="<?php echo esc_attr( $term_meta['custom_term_meta'][0] ) ? esc_attr( $term_meta['custom_term_meta'][0] ) : ''; ?>">
					<p class="description"><?php _e( 'Enter a value for this field', 'pippin' ); ?></p>
				</td>
			</tr>-->
			<tr class="form-field">
				<th scope="row" valign="top"><label for="term_meta[role_permission]">Permissão</label></th>
				<td>
					<select multiple="multiple" id="role_permission" name="term_meta[role_permission][]" style="width: 100%;">
						<?php foreach ( $editable_roles as $role => $role_data ): ?>
							<option <?php echo in_array( $role, unserialize( $term_meta['role_permission'][0] ) ) ? 'selected' : ''; ?> value="<?php echo $role; ?>"><?php echo $role_data['name']; ?></option>
						<?php endforeach; ?>
					</select>
					<p class="description">Os perfis selecionados terão permissão para editar, publicar e deletar essa categoria de agenda.</p>
				</td>
			</tr>
			<?php
		}

		/**
		 * Save metadata from taxonomies
		 *
		 * @param $term_id
		 */
		public function event_category_save_taxonomy_meta_field( $term_id ) {
			if ( isset( $_POST['term_meta'] ) ) {
				$t_id     = $term_id;
				$cat_keys = array_keys( $_POST['term_meta'] );
				foreach ( $cat_keys as $key ) {
					if ( isset ( $_POST['term_meta'][ $key ] ) ) {
						// Save data
						update_term_meta( $t_id, $key, $_POST['term_meta'][ $key ] );
					}
				}
			}
		}

		public function agenda_cats_rewrite() {
			add_rewrite_tag( '%event_cat%', '([^&]+)' );
			add_rewrite_rule(
				'^agenda/(.+)/?$',
				'index.php?post_type=event&event_cat=$matches[1]',
				'top'
			);

			flush_rewrite_rules();
		}

		public function agenda_cats_rewrite_parse_query() {
			if ( false !== get_query_var( 'event_cat' ) ) {
				$_GET['event_cat'] = get_query_var( 'event_cat' );
			}
		}

		/**
		 * Filter event category checkboxes, showing only the ones allowed to a specific role
		 *
		 * @param $args
		 * @param $post_id
		 *
		 * @return mixed
		 */
		public function event_categories_filter_based_on_role( $prepared_args, $request ) {
			$current_user = $this->getCurrentUser();
			if ( $current_user instanceof WP_PM_User ) {
				$prepared_args['exclude'] = $this->excludedTerms();
			}

			return $prepared_args;
		}

		/**
		 * Applies some CSS to customize admin, hiding some features, based on agenda manager role
		 *
		 */
		public function agenda_manager_role_custom_style () {
			$user = wp_get_current_user();
			if ( $user->roles[0] === 'agenda_manager' ) { ?>
				<style type="text/css">
					#wp-admin-bar-new-post,
					#wp-admin-bar-new-documentos,
					#wp-admin-bar-new-multimedia {
						display: none !important;
					}
				</style>';
			<?php }
		}

	}

	// Initialize our plugin
	$oscar_minc = new Gov_Schedules();
endif;

/**
 * Extends the default walker from categories
 *
 */
if ( ! class_exists( 'Taxonomy_Filter_Based_On_Roles' ) ) :
	require_once( ABSPATH . 'wp-admin/includes/class-walker-category-checklist.php' );

	class Taxonomy_Filter_Based_On_Roles extends Walker_Category_Checklist {
		function walk( $elements, $max_depth, $args = array() ) {
			$user = wp_get_current_user();
			foreach ( $elements as $i => $el ) {
				$term_meta = get_term_meta( $el->term_id );
				if ( ! in_array( $user->roles[0], unserialize( $term_meta['role_permission'][0] ) ) ) {
					unset( $elements[ $i ] );
				}
			}

			$output = parent::walk( $elements, $max_depth, $args );
			wp_die( var_dump( $output ) );

			return $output;
		}
	}

endif;

class WP_PM_User extends WP_User {

	function getID() {
		return $this->ID;
	}

}

class WP_PM {

	protected $user;

	function __construct( WP_PM_User $user = null ) {
		if ( ! is_null( $user ) && $user->exists() ) {
			$this->user = $user;
		}
	}

	function getUser() {
		return $this->user;
	}

}
